# News App



News app is a simple app that allows users to read news headlines from two countries (Egypt and UAE) and filter by two categories: Sports and Business. The user can also register an account, which allows them to save headlines they would like to read later. The app uses Laravel as backend/API and Vue for the front-end.

## Requirements
- PHP (v7.3+)
- NPM
- Composer
- MySQL
- An API Key from NewsAPI (https://newsapi.org/)
## To run the project:
  - Install requirements
  - Create a database for the project
  - Clone the repo
  - Change working directory to the project's root folder
  - Run composer to download dependencies using `$ php composer.phar install`
  - Run `$ npm install` to download all npm dependencies
  - Open your .env and enter the following parameters:
  ```
DB_HOST=your_mysql_host
DB_PORT=your_mysql_port
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
  ```

This project also uses a mailer, so you need set up an SMTP mailer and define your mailer in the following fields:

```
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```
`MAIL_FROM_ADDRESS=` is the email address you want the emails your project sends to have


After you have defined the env variables, we need to make sure everything is defined correctly.
To test the MySQL connection, we will 
- Run laravel's migrations (which we need to do anyway) using `$ php artisan migrate` to create the tables required by our project
- If the above executes successfuly, run `$ php artisan serve` to start the server on a PHP webserver
- Run `$ npm run watch` to compile our Vues and watch for changes
- Now the only thing left to do is test the mailer. We can do this by navigating to `/register` on the website, and make an account. If you receive an email that means the emailer was defined correctly and you are now ready to deploy project on a webserver.

