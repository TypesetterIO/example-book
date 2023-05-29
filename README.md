# Example Project

This is an example project using [Typesetter](https://typesetter.io).

## The Process

This is what I did to make this project and publish my book.

* Initialize and version a folder using Git - you can git ignore the `vendor` folder if you wish (but you don't have to). Remember this is a book project, not necessarily a PHP package/project.
* `composer require typesetterio/typesetter-cli`
* `vendor/bin/typesetter init` This generates a default configuration including folders and test content.
* Customize my `config.php` with the author and title
* Replace `content/*` with my contents for the book
* Put `content/cover.jpg`
* Replace `theme/theme.html` with my theme CSS.
* `vendor/bin/typesetter generate`