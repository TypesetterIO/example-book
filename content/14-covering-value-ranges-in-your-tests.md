# Covering Value Ranges in Your Tests

One big benefit of tests is that they increase confidence in our code. We write tests while we’re building a feature to confirm it works as expected. We run these tests every time we make a code change to check if we broke anything that was already working. Knowing what to test is an important skill and today’s tip will point out one area you may not have considered.

Let’s picture a relatively simple form with some text inputs that will get persisted to a database. You’ll create a migration that defines the field definition in the table, a form request which validates the maximum length of that field, and usually some HTML input properties to also enforce the length in the browser.

Generally, we would write a test for the “happy path”, where the form submission will succeed and all the inputs will pass validation. We’d also write some failing tests to confirm that our form request validation is catching missing required fields or fields that are too long to be stored in the database.

But consider one additional test to write: Making sure you can submit a value that is exactly the longest allowed length. So if your database field allows 1000 characters, make sure your happy path is storing a 1000-character value successfully. 

This actually bit us in production when we intended to allow 1000 characters, set up the validation and HTML form attributes to match, but then forgot to set the length in the database migration. Instead it used the default length, so the first time someone typed in more than that default length in production, the request failed with a `Data too long for column` exception from MySQL.

Lesson learned. Now anytime there’s a non-default length for a database field, we make sure to cover the max length in my happy path test. It doesn’t take any extra time, and it gives us just a bit more confidence our code is working as expected.
