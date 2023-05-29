# Eloquent Methods to Encapsulate Creation Logic

There are a number of ways to create new Eloquent models.  The one we reach for the most is calling the static `create()` method.  For example, to create a new `Car` model, the code in the controller might look like this:

```php
$myCar = App\Models\Car::create([
  'make_id' => $ford->id,
  'model_id' => $explorer->id,
  'year' => '2019',
]);
```

Great!  But, what about if our creation of a model gets more complicated?  For example, let’s say we have this in our controller:

```php
$owner = $tradeIn->owner;
$address = $owner->homeAddress;
$insuranceRegion = Region::where('city', $address->city)
  ->where('state', $address->state)
  ->firstOrFail();

$myCar = App\Models\Car::create([
  'make_id' => $ford->id,
  'model_id' => $explorer->id,
  'year' => '2019',
  'owner_id' => $owner->id,
  'insurance_region_id' => $insuranceRegion->id,
]);
```

In this contrived example, our car model requires not only identifiable information about the vehicle, but information about the owner as well.  It also requires we determine what the insurance region is for that automobile.

Now, this isn’t so bad at first glance, but can we make it encapsulated and easier to use? Normally, we wouldn’t recommend creating a method just for a single time’s sake, but this is different.  Here, we want to encapsulate some required business needs into one method so that we guarantee they happen.  It makes it easier to read the controller and less likely we’ll miss something if we use it again.  Plus, it provides a way to make a more self-documenting bit of code.

Let’s change our code to this:

```php
$myCar = App\Models\Car::createFromTradeIn(
  $tradeIn, 
  $ford, 
  $explorer, 
  '2019'
);
```

Then, in our Car model, we can have a method like this:

```php
public static method createFromTradeIn(
  Car $tradeIn,
  CarMake $make,
  CarModel $model,
  string $year
) {
  $owner = $tradeIn->owner;
  $address = $owner->homeAddress;
  $insuranceRegion = Region::where('city', $address->city)
    ->where('state', $address->state)
    ->firstOrFail();

  return static::create([
    'make_id' => $make->id,
    'model_id' => $model->id,
    'year' => $year,
    'owner_id' => $owner->id,
    'insurance_region_id' => $insuranceRegion->id,
  ]);
}
```

Now, we can call the more obvious method `createFromTradeIn()` and the logic required to transfer a car’s information to a new car is all encapsulated.

This is one of those tips that you need to be careful with, however.  Don’t start creating too many single-use methods just because it seems like a good idea.  Only create methods like this where the set up takes a few steps to retrieve and manipulate the data.

