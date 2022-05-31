# Laravel Interview Task

Create billing system for selling products in the monthly subscription model. 

## Models

* `Customer` - person (first name, last name, email) who can purchase an product in the subscription model
* `Product` - product with a description, price. Product can be deactivated
* `Subscription` - Monthly subscription only, can be paused. Single customer can subscribe multiple products, but only one of the same type. System should bill customer every single month on the same day when subscription was started without overflow (let's say the subscription was started at 31 May, then following should be 30 June, 31 July etc.)
* `Transaction` - Information about payment transaction (date, amount, status: failed/succeeded). Failed transaction should be retried day after

## Tasks

1. Create API Endpoint `/api/customer` to register customer
2. Create API Endpoint `/api/product` to list products
3. Create API Endpoint `/api/subscription` to list own subscriptions and make new subscription
4. Create API Endpoint `/api/transaction` to list the billing history
5. Create and cronjob running every minute to handle the payments and simulate payment gateway with 80% succeeded and 20% failed transactions.
6. Create database migrations and seeders
7. Implement `\App\Component\Billing\DueDateCalculator` class, should pass `\Tests\Unit\DueDateCalculatorTest` test
8. Feature tests `tests/Feature` should pass
9. Write PHPUnit tests

## Setup 

1. Rename .env.sample to .env, change parameters if neccessary, create table in the database
2. `composer install`
3. `php artisan db:migrate`
4. Run the tests now if you need - `php artisan test`
5. `php artisan db:seed` 
6. Add to crontab:
`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
7. `php artisan serve` or use dedicated server 

You can execute the billing schedule manually if you need to:
`php artisan nicehealth:billing`

