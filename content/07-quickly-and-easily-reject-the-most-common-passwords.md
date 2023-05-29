# Quickly and Easily Reject the Most Common Passwords

A common way applications get “hacked” is that users reuse the same password among services.  So, if they fall victim to a phishing attack for one site, the bad guys now have their password for many sites.

While we might joke that that sounds like a user problem, not ours, that’s not true. The story never is “users reused passwords leading to breach in software.” Instead, it’s sensationalized to say “LaravelTipsReader’s Website Hacked in Crime of Century!” or something like that.  Your site gets blamed even if it’s not directly your fault.

Whether you think it should be your responsibility or not, stopping password reuse on your website should be a priority now.  One way sites do this is by requiring more and more complex password syntaxes.  The effectiveness of this and its corresponding user experience is a whole other conversation we’re not going to have in this quick tip.

Instead, let’s focus on a quick win.  Each year, security companies publish a list of the top 25 most common, most reused passwords.  This sounds silly that anyone would use them, but they do!  In our Laravel apps, we can easily make sure that no one uses these passwords. That seems like the least we can do to protect our users and the site’s reputation.

Let’s get started.

Step 1 - search “top 25 passwords of ####” where #### is the current year.  Or, you might make a combined list of a couple years. Point is, you want to develop a list of common passwords that you want to immediately reject.

Step 2 - make a Laravel Validation Rule with the responsibility to reject any of those common passwords.  Don’t get fancy like hitting an API to retrieve a list or importing a CSV in real time. Just hard-code the values in like this:

<div class="page-break"></div>

**File: app/Rules/RejectCommonPasswords.php**
```php
<?php
namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;

class RejectCommonPasswords implements Rule
{
  public function passes($attribute, $value)
  {
    return !in_array($value, [
      '12345',
      '123456',
      '123456789',
      'test1',
      //... a bunch more here
      'Password',
      'maria',
      'lovely',
    ]);
  }

  public function message()
  {
     return trans('validation.reject_common_passwords');
  }
}
```

Step 3 - add a translation to all of your language files under the `validation.reject_common_passwords` key.  Or, you can simply hard-code a message in this method.  Use something clear, but not overly detailed: “Please choose a stronger password.”  Be concise, but not insulting.

Step 4 - add this rule to every password field in your app. These probably are your sign up and reset password form requests/validation configurations.  For example, your password validation might look like this:

```php
'password' => [
  'required',
  'string',
  'min:8',
  new RejectCommonPasswords(),
]
```

Or, you can combine this with the password validation rule in Laravel 8:

```php
'password' => [
  Password::min(8)->letters()->numbers(),
  new RejectCommonPasswords(),  
]
```

Note that this is not a replacement for the `Password::uncompromised()` method.  But, if you're in a situation where you need to eliminate your calls to a third party, the reject common passwords rule can help.

Now, you’re doing your part to help make your application more secure for your users.
