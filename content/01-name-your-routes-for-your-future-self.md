# Name Your Routes for Your Future Self

Has this happened to you?

* A new developer joins the team and adds new routes. In our project, we use plural nouns, but they created a bunch of singular ones
* The marketing department requires that you change all of the URLs because they’re doing branding changes
* You’ve changed the nesting of resources, and now you’ve got to go find every single hard-coded URL and update them with their parent directory

We can guarantee you if they haven’t already happened, they will happen to you in the future. How do we make this easier on ourselves?

Named routes!

When you name a route, and then use the `route()` helper, you now have a single place of authority and responsibility for the URLs: your route definitions file.

You will go from something like this:

```php
return redirect('/welcome');
```

To this:

```php
return redirect(route('first-time-visitor-splash'));
```

Not only will this have all URL construction done based on one source of truth, you also will receive an error from Laravel when you refer to a route that doesn’t exist. No more dead links! (Bonus: some IDEs will even auto-complete route names for you.)

To do this, it’s simple, just add a call to name() on your route definitions.  For example:

```php
Route::view('/welcome', 'welcome')->name('first-time-visitor-splash');
```

Laravel also automatically defines names on resourceful route definitions. It provides route name prefix options on route groups as well.
