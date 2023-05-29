# Using a Bootstrap File for PHPUnit Can Make Life Easier

The standard install of a Laravel application contains a PHPUnit test suite that is set up pretty nicely.  The application loads up the Composer autoload functionality, uses the Abstract Test Case to register traits, and builds up an encapsulated Laravel environment.

What happens if you want to add some other set up into that process, though?  You have the standard PHPUnit `setUp()` and `setUpBeforeClass()` methods, but those are run on each test and each test class, respectively.  What if you just need to bootstrap a few more things before your entire set of tests kick off?

The unit test process gets configured using the `phpunit.xml` file in the root of your project.  In the root `phpunit` element of the XML, there is an attribute called `bootstrap`.  By default, this is loading your Composer autoloader to complete bootstrapping the test environment.

In our Laravel projects, we use the Mockery library for mocking items.  While we could use static methods on fully qualified classes, we prefer to use the global method helpers in our test suite.  In order to use the method `mock()` for example, I need to run the `Mockery::globalHelpers()` method.

First, I’m going to modify `phpunit.xml`, find the `phpunit` root element and modify the `bootstrap` attribute like this:

```xml
<phpunit bootstrap="tests/bootstrap.php" ...>
```

Now, I’ll create the file with the following content:

**File: tests/bootstrap.php**
```php
<?php
require __DIR__ . '/../vendor/autoload.php';

Mockery::globalHelpers();
```

Now, when PHPUnit tests begin, the bootstrap process calls our new bootstrap file.  The first thing it does is load the Composer autoloader.  Then, it calls the method to register the Mockery global functions.  If we wanted to add more bootstrapping code for our test environment, we could continue to expand this file.
