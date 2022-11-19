
# Stock Management

This api takes an order and calculates the stock based on the ingredients quantity required to make the product.


### Setting up project

Clone the project

```bash
  git clone https://github.com/kamransarwar47/Stock-Management.git
```

Go to the project directory

```bash
  cd stock-management
```

Generate `APP_KEY`

```bash
  php artisan key:generate
```

Copy `.env.example` to `.env` and update DB and MAIL credentials

### Install dependencies

```bash
  composer install
```
### Run Migration and Seeder

```bash
  php artisan migrate
```
```bash
  php artisan db:seed
```

### Start the server

```bash
  php artisan serve
```

