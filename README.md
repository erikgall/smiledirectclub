# SmileDirectClub Coding Challenge

## Setup

### Cloning the repository

1. Clone the repository - `git clone git@github.com:erikgall/smiledirectclub.git`
2. Install the composer dependencies - `composer install`
3. From a terminal run - `cp .env.example .env`
4. Generate a secret key - `php artisan key:generate`

### Setting up the database

#### SQLite

1. From the root of the project run - `touch database/database.sqlite`
2. Open the `.env` file created earlier
3. Remove all environment variables prefixed with `DB_` except `DB_CONNECTION`
4. Set the `DB_CONNECTION` environment variable to `sqlite`. (Ex. `DB_CONNECTION=sqlite`)
5. Run the database migrations - `php artisan migrate`

## Running the tests

Once the application is setup and a database connection has been established you can run the `PHPUnit` tests by entering the following command from the project's root*:

```bash
php vendor/bin/phpunit --testdox
```

* By running the tests, the database will be reset and any database stored will be erased.

## Requirements

The following tasks should be performed using PHP and Laravel. The database you use should be relational, but beyond that it's your choice and it will have no bearing on the test. You are welcome to use any additional software packages you feel would help. Your results will be judged based on conformance to the spec, code quality and clarity, and user experience.

- [x] Create a sign-up form with two required fields—email address and full name.
- [x] Use https://gender-api.com/ to determine the user's gender.
- [x] BONUS: determine the user's country any way you can think of and pass that to the gender API to improve accuracy.
- [x] If the confidence of the gender API's guess is below 70%, present the user with an additional means to specify their gender—"Male", "Female", or "Other".
- [x] Save the user. First name and last name should be stored in separate columns. Gender and email address should also be stored.

There are no intentional gotchas and no "wrong" solutions for satisfying any of the above steps. Handle them to the best of your ability using whatever approach you deem most appropriate. If you have any questions, please feel free to reach out. It will not be held against you.

## How it works

The application is pretty simple and I went a little past the requirement sent to me.

The client side application is a `Vue.js` single page application (SPA) using the `vue-router` package/vue plugin. The server side application is a `Laravel` application renders a view containing a single div tag. The `Vue.js` application will replace the single div element and inject the SPA into the page. The Laravel application also exposes a public API (endpoints found below) to serve the Vue.js application. All assets have been compiled and stored in their public directories if you wish you install all assets and tinker with the JavaScript or styling you can run `npm install` from the projects root to install all dependencies. Once all dependencies are installed you can begin changing the resources. The assets will need to be recompiled before a change will be visible in a browser. to do this you can run `npm run dev` or if you are making multiple changes `npm run watch`.

When registering a new user, if the Gender API returns a guess accuracy below 70% the application's API will return an error and the Vue.js app will then expose hidden radio buttons so the user can pick a gender from the list.

To complete the bonus (send the user's country to the gender API), a request is being made the `ip-api.com` API which returns data regarding the user's IP address. Before submitting the a registration form, I then attach the user's country code to the form request's data. The Laravel application then checks if a country code is present and if it is, will use it when sending the request to Gender API.

### API Endpoints

- [POST] `api/users` - Create a new user.
- [GET] `api/users` - Fetch all registered users.
- [GET] `api/users/{id}` - Fetch a user by their ID number.
