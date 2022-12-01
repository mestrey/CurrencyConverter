# Currency Converter

Converter any currency from any country:

Easy Peasy Lemon Squeezy 

## How to run the project

Clone the repo:

```bash
git clone https://github.com/mestrey/CurrencyConverter.git
```
Install the dependencies:

```bash
composer install
```

Configure your .env and constants:

```bash
cp .env.example .env
nano .env
nano frontend/src/utils/constants.js
```

Execute the migrations:

```bash
php artisan migrate
```

Start a backend server

Here using mamp:

```bash
cd CurrencyConverter/
open -a "Mamp"
```

Then a frontend vue server:

```bash
cd frontend/
npm i && npm run serve
```

Here we go!

Go to: `localhost:8080/`