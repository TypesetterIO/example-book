# Make Upgrades Easier by Simplifying Configuration Files

Upgrading to the newest Laravel version can be an exciting time. Hooray for all the new features! Usually the upgrade process is fairly straightforward, but today’s tip will help you avoid some potential problems.

First, it’s important to clarify the types of things that get upgraded with a Laravel project upgrade. Most of the code changes come via package updates to the framework itself. These are relatively automatic. Composer handles that for you, and you just need to make sure your tests still pass and things work as expected.

The other type of change is a little bit more complicated: changes inside your app folder. For example, looking at the Laravel 8.0 release, here are just a few of the files changed inside your application code:

* `app/Exceptions/Handler.php`
* `app/Http/Kernel.php`
* `app/Providers/RouteServiceProvider.php`
* `config/auth.php`
* `config/queue.php`

This tip will focus on just the configuration files. By keeping Laravel’s configuration files as unchanged as possible, you can make these version upgrades much easier to manage. How can we do this? There are two main strategies.

**1. Leverage environment variables**

Many of the configuration settings you’ll need to change first check for a specific environment variable before falling back to a default specified in the config file. Wherever possible, use these environment variables to customize the config. Plus, as a bonus, you’re on your way to an OWASP secure project!

**2. Create your own custom config file**

The config files you get with the framework are only a starting point. You can create your own file for things not covered by existing configuration. I typically like to name this file after my application, or just call it something generic like `config/custom.php`. Inside this config file, you can do whatever you want and leave it untouched during the next Laravel upgrade.

With these two strategies, you can keep your framework config files as close as possible to their default states. Yes, there will still be some things you may need to modify, but by keeping the number of changes as low as possible, your `git diff` will be a lot cleaner when merging in upstream Laravel changes, saving yourself some time.
