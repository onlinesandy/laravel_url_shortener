# \<Project Name\>

This contains the application code for the \<Laravel URL Shortener\>. 
	The app is build on top of [Laravel framework](http://laravel.com/docs) 
	which runs on the LAMP stack.


## Setting up

Follow these steps to set up the project.

```
git clone <project.url> <project>
cd <project>
composer install
npm install
chmod -R 777 storage bootstrap/cache
cp .env.example .env
```

##Create Databse.
Change the values of the `.env` file as necessary.

##Run Migrate Command 
php artisan migrate



