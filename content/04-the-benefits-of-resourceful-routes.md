# The Benefits of Resourceful Routes

One theme in these tips you’ve likely picked up on at this point is our love of consistency. With so many different opinions and ways of organizing your code, it’s nice to have one consistent way used within your application.

Resourceful controllers are an example of this, and this tip will focus on the benefits of using the `Route::resource` helper in your routes files.

The benefit when using this helper is that you are adopting Laravel’s conventions for resourceful controllers. No more controllers with 20 custom methods! This also means you have consistency in at least two levels of your app: routes and controllers. If you’re using policies, this convention now works across three levels.

Second, this helper reduces the size of your routes file. As your app grows, the routes file can get out of hand quickly. This method will condense as many as 7 separate route definitions into one simple line:

```php
Route::resource('widgets', WidgetController::class);
```

Finally, the helper can be easily customized when needed. Sometimes, a resource doesn’t need all conventional methods. For example, maybe you never allow a resource to be deleted:

```php
Route::resource('widgets', WidgetController::class)->except(['destroy']);
```

Or let’s say your resource is read only:

```php
Route::resource('widgets', WidgetController::class)->only(['index', 'show']);
```
