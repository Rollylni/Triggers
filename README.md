# Triggers
calling callback triggers by its id

# Example
```php
require "vendor/autoload.php";
use Triggers;

function example(Triggers $trigg) {
    $trigg->handleTriggers("pre-loop");
    for ($i = 1; $i < 10; $i++) {
        $trigg->handleTriggers("looping", [$i]);
    }
    $trigg->handleTriggers("end-loop");
}

$trigg = new Triggers();
$trigg->addTrigger("pre-loop", function() {
    echo "starting loop!";
});

$trigg->addTrigger("looping", function($i) {
    echo "looping $i iteration!";
});

$trigg->addTrigger("end-loop", function() {
    echo "loop finished!";
});
example($trigg);
```
**Output**
```
> starting loop!
> looping 1 iteration!
> looping 2 iteration!
> looping 3 iteration!
> looping 4 iteration!
> looping 5 iteration!
> looping 6 iteration!
> looping 7 iteration!
> looping 8 iteration!
> looping 9 iteration!
> loop finished!
```
