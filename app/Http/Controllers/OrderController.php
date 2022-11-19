<?php

namespace App\Http\Controllers;

use App\Events\LowStockNotificationEvent;
use App\Http\Requests\storeOrderRequest;
use App\Models\Ingredient;
use App\Models\Order;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponser;

    // Store Order
    public function storeOrder(storeOrderRequest $request) {

        $ordersReceived = $request->validated();
        $productIds = array_column($ordersReceived['products'], 'product_id');
        $ingredientData = Ingredient::with('product')->whereIn('product_id', $productIds)->get()->toArray();

        try {
            $orderStatus = DB::transaction(function () use ($ordersReceived, $ingredientData) {
                $orderData = [];
                $now = Carbon::now()->toDateTimeString();
                foreach ($ordersReceived['products'] as $key => $order) {
                    $ingredients = array_filter($ingredientData, function ($arr) use ($order) {
                        return ($arr['product_id'] == $order['product_id']);
                    });
                    //
                    foreach($ingredients as $ingredient) {
                        $currentStock = unitConverter($ingredient['stock_unit'], $ingredient['consumption_unit'], $ingredient['available_stock']);
                        $remainingStock = $currentStock - ($order['quantity'] * $ingredient['consumption']);
                        if($remainingStock >= 0) {
                            Ingredient::where('id', $ingredient['id'])->update([
                                'available_stock' => unitConverter($ingredient['consumption_unit'], $ingredient['stock_unit'], $remainingStock)
                            ]);
                        } else {
                            throw new \Exception($ingredient['title'] . ' is out of stock for ' . $ingredient['product']['title']);
                        }
                    }
                    //
                    $orderData[$key]['product_id'] = $order['product_id'];
                    $orderData[$key]['quantity'] = $order['quantity'];
                    $orderData[$key]['created_at'] = $now;
                    $orderData[$key]['updated_at'] = $now;
                }
                Order::insert($orderData);

                return true;
            });
            if(!$orderStatus) {
                throw new \Exception('Error occurred while creating order. Please try again');
            }
        } catch (\Exception $exception) {
            return $this->failure($exception->getMessage());
        }

        //
        $lowStockItems = [];
        foreach ($ingredientData as $key => $ingredient) {
            if(checkLowStock($ingredient['stock'], $ingredient['available_stock']) && !$ingredient['stock_notification']) {
                $lowStockItems[$key]['id'] = $ingredient['id'];
                $lowStockItems[$key]['title'] = $ingredient['title'];
            }
        }

        if(!empty($lowStockItems)) {
            $lowStockItemsIds = array_column($lowStockItems, 'id');
            $lowStockItemsTitle = implode('\r\n', array_column($lowStockItems, 'title'));
            LowStockNotificationEvent::dispatch($lowStockItemsTitle);
            //
            Ingredient::whereIn('id', $lowStockItemsIds)->update([
                'stock_notification' => 1
            ]);
        }

        return $this->success('Order created successfully');
    }
}
