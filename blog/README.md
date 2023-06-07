Blog-Module

Installation and Configuration

a. Download & Extract the contents of zip.

b. Upload Blog Folder "inside "packages" folder.

c. Go to config\app.php & add "Webkul\Blog\Providers\BlogServiceProvider::class," (without double quotation) inside 'providers'.

Go to composer.json & add "Webkul\\Blog\\": "packages/Webkul/Blog/src"," inside 'autoload' -> 'psr-4'.

f. Run the following command.

    ~~~
	composer dump-autoload
	php artisan migrate
	php artisan config:cache
	php artisan view:cache
	php artisan route:cache
	~~~
