## Installation

Clone this repository and install all dependency first

```sh
composer install
yarn
```

Setup .env by copying .env.example file. Generate the laravel key and jwt key after that.

```sh
php artisan key:generate
php artisan jwt:secret
```

Here's the thing. In the .env, you should pay attention to some of the things below

-   APP_ENV = You must set this to production so the attendance system will use a server time. But you can set this to local or development so the attendance system will use an inputted time from the request
-   FILE_UPLOAD_ENDPOINT= You must define the base endpoint where you upload the file here
-   DASHBOARD_TIMEZONE= Here you can define the timezone of the dashboard. The default timezone is UTC, but you can change based on your needs
-   BPJSK_EMPLOYEE_PRECENTAGE= This is payroll related. You can ignore this, but you can set how much percentage of employees taken from the bpjsk deduction
-   FIREBASE_CREDENTIALS= Copy .json of your firebase credential. This will handle the firebase cloud messaging to the employee apps later when your apps are ready

After you setup the database, run the migration and seeder

```sh
php artisan migrate
php artisan db:seed
```

Run the server and it was ready to use

```sh
php artisan serve
yarn dev
```

## How To Deploy

After you successfully install it locally, maybe you want to deploy it too. things you should pay attention to when deploying are these.
