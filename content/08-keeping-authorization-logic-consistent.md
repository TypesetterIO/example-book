# Keeping Authorization Logic Consistent

Consistency is extremely valuable in a code base, whether you’re a solo developer or working on a large team. By establishing some guidelines as to where certain types of logic belong in your codebase, you make it much easier to maintain your application.

For example, where should you organize your authorization logic? How should you enforce these authorization checks? You could do it in a form request, inside a controller action, within a middleware, or even inside of a view.

Let’s start with where to put the authorization logic. We like to use Laravel policies whenever possible. The policy provides a central place to store all authorization logic for a specific resource. Conventions exist for all the typical actions you want to perform and these map cleanly onto the conventions around resourceful controllers. And if you’re not using resourceful controllers yet, you are still able to add custom methods to your policy as needed.

As a bonus, if you integrate Laravel Nova into your application, it will leverage those same policies you already built for your main application.

If you’re sticking with the resourceful conventions, you can authorize a whole controller with a single line in the constructor:

```php
public function __construct()
{
  $this->authorizeResource(Post::class, 'post');
}
```

If you’re not using resourceful methods, you can check inside the controller action with one line:

```php
$this->authorize('customMethod', Post::class);
```

One additional benefit of using these helpers is that the correct HTTP status code is generated for you if the authorization fails.

Enforcing authorization logic is best done as early in the request lifecycle as you can.  Sometimes you can protect a whole group of routes with a middleware check, like when you’re using a role and permissions system:

```php
Route::middleware('can:manage-posts')->group(function () {
   Route::resource('posts', PostsController::class);
  Route::get('posts/{post}/approve-post', ApprovePostController::class);
});
```
