# gmj-laravel_block2_thumbnail_filter_icon

Laravel Block for backend and frontend - need tailwindcss support

**composer require gmj/laravel_block2_thumbnail_filter_icon**

package for test<br>
composer.json#autoload-dev#psr-4: "GMJ\\LaravelBlock2ThumbnailFilterIcon\\": "package/laravel_block2_thumbnail_filter_icon/src/",<br>
config > app.php > providers: GMJ\LaravelBlock2ThumbnailFilterIcon\LaravelBlock2ThumbnailFilterIconServiceProvider::class,
in terminal run: composer dump-autoload

---

in terminal run:

```
php artisan vendor:publish --provider="GMJ\LaravelBlock2ThumbnailFilterIcon\LaravelBlock2ThumbnailFilterIconServiceProvider" --force
php artisan migrate
php artisan db:seed --class=LaravelBlock2ThumbnailFilterIconSeeder
```
