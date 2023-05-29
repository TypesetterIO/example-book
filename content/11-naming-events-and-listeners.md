# Naming Events and Listeners

It’s often said that there are two hard problems in programming: cache invalidation, naming things and off-by-one errors.  

With that in mind, let’s talk about naming things, specifically events and listeners. Naming events and listeners can be hard.  However, there’s a simple trick to doing this easily. 

Name the event after what happened. Name the listener after what it’s tasked to do.

While listeners can listen to a specific event, you’re not required to limit them to one-to-one relationships.  You can have multiple events that all have a single listener. Or you can assign a listener to multiple events.  As a bonus, with this naming convention, you’re more likely to write simpler code that only does the thing the class is named.

Let’s look at an example:

`App\Events\UserConfirmedEmail` is issued when a user clicks a confirmation link after they’ve signed up themselves.

`App\Events\AdminCreatedAccount` is issued when an admin creates a fully activated user account (no email confirmation is required because the admin knows the information is legitimate).

`App\Listeners\DispatchWelcomePackage` is a listener that sends a welcome email with attachments and other information for your product.

Now, look at our configuration for our `EventServiceProvider`.  We can reuse this listener and it makes complete sense.

```php
protected $listen = [
  App\Events\UserConfirmedEmail::class => [
    App\Listeners\DispatchWelcomePackage::class
  ],
  App\Events\AdminCreatedAccount::class => [
    App\Listeners\DispatchWelcomePackage::class
  ],
];
```

This would be more confusing if we had named our listener something like `HandleUserConfirmedEmail` — it’d be confusing as to why that is registered under an event that was not email confirmation.

Because of listener reuse, however, type-hinting an event and using automatic listener registration will not work and should be avoided.
