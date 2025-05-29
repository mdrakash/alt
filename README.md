# Bike Service Management System

## Features

- Create and manage bike service records
- Track parts used in each service
- Stock, dealer price, and retail price management
- Distribute fixed discounts 100 across parts
- Service history and reporting

## Installation

    1. Clone the repository:
   ```
    git clone https://github.com/mdrakash/alt.git bike-service
    cd bike-service
   ```

   2. Install dependencies:
   ```
    composer install

   ```

   3. Copy and set up .env file:
   ```
    cp .env.example .env
    php artisan key:generate
   ```

   4. Configure database in .env, then run:

   ```
   php artisan migrate --seed
   ```

   5. Run the development server:
   ```
   php artisan serve
   ```