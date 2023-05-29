# Things to Consider When Validating String Length

One important reason to write tests is to gain confidence that our code works as expected. Many developers focus on the “happy path”, writing tests to make sure all the right things happen as people use our application.

But what about testing when things “go wrong”? For example, what if a user does something unexpected? It would also be great to have confidence we handle those scenarios gracefully and provide useful feedback to the user.

Testing our validation logic can give us this confidence! Let’s consider a text field on a form and a few types of tests we could write.

Here’s what our form validation rules look like:

```php
$rules = [
  'title' => [
    'required',
    'max:255',
  ],
  'description' => [
    'required',
    'max:65535',
  ],
];
```

Here is how we can test the required field validation:

```php
$values = [];

$response = $this->post(route('route-name'), $values);

$response->assertSessionHasErrors([
   'title' => 'The title field is required.',
   'description' => 'The description field is required.',
]);
```

Here is how we can test the maximum length validation

```php
$values = [
   'title' => str_repeat('a', 256),
   'description' => str_repeat('a', 65536),
];

$response = $this->post(route('student.offerings.store'), $values);

$response->assertSessionHasErrors([
   'title' => 'The title may not be greater than 255 characters.',
   'description' => 'The description may not be greater than 65535 characters.',
]);
```

Note the use of `str_repeat`. This makes it very easy to scan and read as compared to putting a 256 character string literal in your test.

As we’ve shown these tests can be grouped together. We often have one test that checks all required fields and one test for all length-validated fields, and so on. This gives you good confidence without growing your test file any larger than necessary.
