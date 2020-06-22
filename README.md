## Pico y Placa Predictor

 The inputs should be a license plate number (the full number, not the last digit), a date (as a String), and a time, and the program will return whether or not that car can be on the road


## How to deploy

1. Clone repositorie into a local branch.
2. Install composer dependencies (composer install)
3. Create .env file from .env.example
4. Generate application key with the command: php artisan key:generate
5. Add the following line: MIX_APP_URL = "http://localhost/picoyplaca/public/" to the .env file with the appropriate URL. 
6. Install npm dependencies (npm install)
7. Run npm (npm run dev)
8. Ready to use the application


## Author

Developed by albertinho88 



## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
