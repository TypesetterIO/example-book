# Using Composer Scripts for Common Tasks

Most PHP projects use the Composer package manager to manage dependencies and Laravel is no exception. You might even have installed Laravel the first time using Composer.  Besides package management, Composer adds a number of other features to your project.  One of them is the ability to run scripts in your current project.

Projects like Laravel make use of Composer’s lifecycle hooks by registering scripts under specific hook names like `post-create-project-cmd` or `post-autoload-dump`.  But, the scripts section is not limited to just lifecycle hooks. You can also define other commands that you might want to use during development or continuous integration.

When you define a script under the `scripts` key of the `composer.json` file, it runs in the current working directory with access to everything in your current path. In addition, it also adds your project’s `vendor/bin` directory at the beginning of your path resolution. This means you can use your project’s local dependencies in your Composer scripts.

To see all of the commands that Composer can execute, you can simply run `composer` with no arguments and options.  You’ll see a mix of built-in commands and non-lifecycle scripts.  You can describe these scripts in the `scripts-descriptions` key.

Let’s take a look at an example.

**File: composer.json**
```json
{
  "scripts": {
    "tests": [
      "phpunit --colors=always"
    ]
  },
  "scripts-descriptions": {
    "tests": "Runs PHPUnit tests with console colors"
  }
}
```

To run PHPUnit tests in your project, it’s now as easy as `composer tests`.  When you see the list of Composer commands, the tests command will now be properly described.  Running this Composer script is the equivalent of running this command in your project: `vendor/bin/phpunit --colors=always` 

Oh, and one last thing.  The `scripts` elements are all arrays. This means you can register multiple commands to run in order that can all be invoked as a single Composer script.
