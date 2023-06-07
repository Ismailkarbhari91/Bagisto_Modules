Csv Category-Module

Installation and Configuration

a. Download & Extract the contents of zip.

b. Upload CsvCategory Folder "inside "packages" folder.

c. Go to config\app.php & add "Webkul\CsvCategory\Providers\CategoryUploadServiceProvider::class," (without double quotation) inside 'providers'.

Go to composer.json & add ""Webkul\\CsvCategory\\": "packages/Webkul/CsvCategory/src"," inside 'autoload' -> 'psr-4'.

f. Run the following command.

    ~~~
	composer dump-autoload
	php artisan migrate
	php artisan config:cache
	php artisan view:cache
	php artisan route:cache
	~~~
