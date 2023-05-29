# Remove Complex Decisions from Your Blade Files

Blade files allow for logical decisions using directives like `@if` or `@isset`.  But, we need to make sure to not abuse these by putting too much logic into our Blade files.

The Blade files are the “view” of your MVC-structured application. This means that they should primarily deal with displaying information. Business rules and domain knowledge should have been already decided in a previous layer.

While some data you might send to a view seems obvious, like boolean or string values from a model, others aren’t as cut and dried. In that case, it’s best to calculate the decision outside and pass in the result to the view.

Let’s see an example.

Imagine you have a view that needs to know if the user is a premium customer and if they’ve set up their billing account.  We have a flag on the user to indicate if they’re a premium account.  We also use Stripe for billing, so a user will have a Stripe customer token on their record if they’re all set up.

You might be tempted to do something like this in your controller:

```php
return view('the.view.here', [
  'user' => $user,
]);
```

If we’re going to get information from the user, why don’t we just send in the whole user?  Well that’s bad for a number of reasons.  First, we don’t want to send extra information into a view - just in case we were to accidentally display it (weirder things have happened!). And second, it requires our view to understand the construction of the `$user` object. That’s too much responsibility and too highly coupled.  What if we change the `User` model? We have to now look in all controllers and possibly all views?  No thank you!

So what about this?

```php
return view('the.view.here', [
  'is_premium' => $user->is_premium,
  'stripe_token' => $user->stripe_token,
]);
```

In your Blade file, you might do something like this:

```php
@if($stripe_token)
  <h2>Billing Section</h2>...
```

Now, we’re still playing with fire! We’re passing a secret to the view, and just hoping we never display it.  Also, if we change the billing provider, we have to change the name of this variable. Or worse, leave it the same and have its value mean something different.

Let’s do this instead:

```php
return view('the.view.here', [
  'is_premium' => $user->is_premium,
  'has_billing_account' => !empty($user->stripe_token),
]);
```

Now, we can check the Blade file like this:

```php
@if($has_billing_account)
  <h2>Billing Section</h2>...
```

We haven’t passed any secrets to our Blade file, it’s easier to read, and doesn’t require our Blade template to understand the details of the domain objects.  Success!
