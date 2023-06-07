# Quotation-Module
 
### Installation and Configuration

##### a. Download & Extract the contents of zip

##### b. Upload CsvCategory Folder "inside "packages" folder.

##### c. Go to config\app.php & add " Webkul\Quote\Providers\QuoteServiceProvider::class," (without double quotation) inside 'providers'

##### d. Go to config\concord.php & add "\Webkul\Quote\Providers\ModuleServiceProvider::class," (without double quotation) inside 'modules'

##### e. Go to composer.json & add ""Webkul\\Quote\\": "packages/Webkul/Quote/src"" inside 'autoload' -> 'psr-4'

##### f. Run the following command
		~~~
		composer dump-autoload
		php artisan migrate
		php artisan config:cache
		php artisan view:cache
		php artisan route:cache
		~~~

##### g. Now, you are good to go. Access the contact form at 'yourdomain.com/contact' & Messages list in admin panel at 'yourdomain.com/admin/contact'
