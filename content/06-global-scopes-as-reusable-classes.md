# Global Scopes as Reusable Classes

Eloquent provides two methods to modify queries for a model: local scopes and global scopes. In this tip, we’re going to focus on global scopes which are query modifications that are applied to an eloquent model every time it is retrieved.

When writing a global scope, you can either add it directly to the class’ `booted()` method as an anonymous function or you can register it with a class.  The Laravel documentation describes writing a class-based global scope that is pretty specialized for a unique case in an application.  But, don’t let that limited example fool you - this feature is very powerful.

One of the things that we’ve used global scopes for quite often is applying an order to the result set of a model.  Depending on the model, you might have a specific ordering that makes sense.  Invoices might be ordered by created at or sent at dates.  Cities might be ordered by their name field.

If you find you’re writing a lot of similar global scopes like this, it’s time to invest in a good reusable class for applying your global scopes.  In this example, let’s add a single line to the model’s `booted()` method to order its results by a field and direction unique for this model.

Here’s how it looks in two different models:

**File: app\Models\City.php**
```php
<?php
namespace App\Models;
use App\Scopes\OrderBy;

class City extends Model
{
  protected static function booted()
  {
    static::addGlobalScope(new OrderBy('name', 'asc'));
  }
  ...
```

<div class="page-break"></div>

**File: app\Models\Comment.php**
```php
<?php
namespace App\Models;
use App\Scopes\OrderBy;

class Comment extends Model
{
  protected static function booted()
  {
    static::addGlobalScope(new OrderBy('created_at', 'desc'));
  }
  ...
```

Now, what does this reusable global scope look like? Let’s check it out.

**File: app\Scopes\Orderby.php**
```php
<?php
namespace App\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderBy implements Scope
{
  protected $column;
  protected $direction;

  public function __construct(string $column, string $direction = 'asc')
  {
    $this->column = $column;
    $this->direction = $direction;
  }

  public function apply(Builder $builder, Model $model)
  {
    $builder->orderBy($this->column, $this->direction);
  }
}
```

Now, we have a global scope for ordering our results that truly is reusable. This is just one example. Any time you find yourself writing multiple variations of a very similar scope, consider this technique.
