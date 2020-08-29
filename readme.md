# Laravel URL Shortener

This contains the application code for the  Laravel URL Shortener. 
	The app is build on top of [Laravel framework](http://laravel.com/docs) 
	which runs on the LAMP stack.


## Setting up

Follow these steps to set up the project.

```
git clone https://github.com/onlinesandy/laravel_url_shortener.git url_shortener
cd url_shortener
composer install
npm install
chmod -R 777 storage bootstrap/cache
cp .env.example .env
create Database
Change the values of the `.env` file as necessary
php artisan migrate

```



