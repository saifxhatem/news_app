# News App



News app is a simple app that allows users to read news headlines from two countries (Egypt and UAE) and filter by two categories: Sports and Business. The user can also register an account, which allows them to save headlines they would like to read later. The app uses Laravel as backend/API and Vue for the front-end.

## Requirements
- PHP (v7.3+)
- NPM
- Composer
- MySQL (5.3+), or any other database system [supported by Laravel](https://laravel.com/docs/8.x/database#introduction "DB Systems Supported by Laravel")
- An API Key from NewsAPI (https://newsapi.org/)


## Setup
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

Note: if you want to use Gmail as your SMTP host you will need to 
1. Setup 2FA
2. Create an app password
3. Use that app password in the `MAIL_PASSWORD=` field instead of your own account's password
4. You _may_ also need to tick "Allow unsafe apps"

## Testing


After you have defined the .env variables, you need to make sure everything is defined correctly.
You need to test that both the database connection and the mailer works properly.
To test the database connection, you should run laravel's migrations (which we need to do anyway) using `$ php artisan migrate` to create the tables required by our project.
If there are no error messages, the database connected successfully.

To test the mailer, you can either run the project (more on that in the next section) and attempt to register, or you can  
- Make a new controller, view, and route 
- Hardcode the mailer to your own email
- Navigate to your new route and see if it throws an error.
 
## The mailer
By default, the user receives an email upon registering with a randomly generated password. The email structure is as follows
At `app/Http/Controllers/UserController.php`
```php
$details = [
    'title' => 'Registration Successful!', 
    'body' => 'Your randomly generated password is:', 
    'password' => $user->password, 
    'user_name' => $user->name];

    //send the email

    Mail::to($user->email)->send(new \App\Mail\Mailer($details));
```


1. title: A simple title for your email, e.g. "Registration Successful"
2. body: Any body text you want
3. password: where you send the user's randomly generated password
4. user_name: Simply stores the user's name for a personalized welcome email
You can change this however you like, just remember to mirror your changes in the view file at `resources/views/emails.blade.php`

To change the "Subject" part of the email, go to `app/Mail/Mailer.php` and change this line:

`return $this->subject('News App')` 
to 
`return $this->subject('New Subject')`


## Running the project

- Make sure the working directory is the project's root directory (`$ pwd`)
- Run `$ php artisan serve` to start the project on a PHP webserver
- Run `$ npm run watch` to compile our Vues and watch for changes


