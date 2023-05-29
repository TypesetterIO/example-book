# Using Console Routes for Ad-hoc Testing

Most developers reach for Tinker when they want to run something interactive, in real time, without loading a complex webpage. This is convenient since you have the fully configured Laravel app at your fingertips.

But, what about times when you want to experiment and juggle the order of your method calls, your dependencies, or anything else? It can get tedious rebuilding these things in an interactive shell. Or even worse, you can lose track of what you did that finally worked.

Enter closure-based console commands.  The `routes/console.php` file contains an example command to get you started.  You can add a new one by temporarily defining a new route and closure. Then, you can easily run your command over and over with the `artisan` tool while making incremental changes.

For example, let’s say we wanted to test a complex third party service integration with some data from our application.  We might set something like this up:

```php
Artisan::command('test', function () {
  $service = app()->make(\App\Services\ThirdPartyService::class);
  $myModel = \App\Models\MyModel::findOrFail(42);
  $data = [
    'id' => $myModel->id,
    'label' => $myModel->label,
  ];
  $service->sendToEndPoint($data);
});
```

Then, you can run your command:

```bash
artisan test
```

Next time you reach for Tinker to whip up a quick proof of concept function, give this technique a try instead.
