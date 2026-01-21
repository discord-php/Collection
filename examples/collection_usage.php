<?php

require __DIR__ . '/../vendor/autoload.php';

use Discord\Helpers\Collection;

echo "Collection Usage Examples\n\n";

// Basic construction and pushing arrays
$col = new Collection(); // default discrim 'id'
$col->push(['id' => 1, 'name' => 'Alice'], ['id' => 2, 'name' => 'Bob']);
echo "Count: "; var_dump($col->count());
echo "First: "; var_dump($col->first());
echo "Last: "; var_dump($col->last());

// Get by discrim
$item = $col->get('id', 2);
echo "Get id=2: "; var_dump($item);

// Push an object
$obj = new stdClass(); $obj->id = 3; $obj->name = 'Carol';
$col->pushItem($obj);
echo "Get object id=3: "; var_dump($col->get('id', 3));

// Pull removes and returns item
$pulled = $col->pull(2);
echo "Pulled: "; var_dump($pulled);
echo "Has 2? "; var_dump($col->has(2));

// Shift returns first key=>value and removes it
$shifted = $col->shift();
echo "Shifted: "; var_dump($shifted);

// Search (by value) and find (by predicate)
$foundKey = $col->search($obj, true);
echo "Search strict for object: "; var_dump($foundKey);

$found = $col->find(function ($it) { return (is_array($it) ? $it['name'] : $it->name) === 'Alice'; });
echo "Find name Alice: "; var_dump($found);

// Map returns new Collection
$names = $col->map(function ($it) { return is_array($it) ? $it['name'] : $it->name; });
echo "Mapped names (as array): "; var_dump($names->toArray());

// Demonstrate class restriction
class ExampleItem { public $id; public $name; public function __construct($id, $name) { $this->id = $id; $this->name = $name; } }
$sc = Collection::for(ExampleItem::class);
$sc->push(new ExampleItem(1, 'X'), new ExampleItem(2, 'Y'));
// Attempt to push an array (will be ignored due to class restriction)
$sc->push(['id' => 3, 'name' => 'Z']);
echo "Class-restricted collection toArray: "; var_dump($sc->toArray());

// jsonSerialize / toArray
echo "JSON serializable: "; var_dump($sc->jsonSerialize());

// ArrayAccess: set/get/isset/unset
$sc->set(5, new ExampleItem(5, 'E'));
echo "isset index 5: "; var_dump(isset($sc[5]));
echo "value at 5: "; var_dump($sc[5]->name);
unset($sc[5]);
echo "isset index 5 after unset: "; var_dump(isset($sc[5]));

// Merge collections
$other = Collection::from([['id' => 10, 'name' => 'Other']]);
$sc->merge($other);
echo "Keys after merge: "; var_dump($sc->keys());
echo "Values after merge: "; var_dump($sc->values());

// Unique, diff, intersect examples (using simple values)
$u = new Collection([1, 2, 2, 3], null, null); // discrim null keeps numeric insertion
echo "Unique values: "; var_dump($u->unique()->toArray());

// Fill and clear
$u->clear();
$u->fill([['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B']]);
echo "Filled: "; var_dump($u->toArray());

// Walk and reduce (accumulate into an array so Collection::__construct() receives an array)
$reduced = $u->reduce(function ($carry, $item) {
	$carry[] = is_array($item) ? $item['name'] : $item->name;
	return $carry;
}, []);
echo "Reduced names array: "; var_dump($reduced->toArray());

// Serialize / unserialize
$s = $u->serialize();
$u2 = new Collection();
$u2->unserialize($s);
echo "Unserialized: "; var_dump($u2->toArray());

// __debugInfo
echo "Debug info: "; var_dump($u2->__debugInfo());

// Additional utilities: find_key, any, all, splice, slice, sort, diff, intersect
$c2 = new Collection([['id' => 1, 'v' => 3], ['id' => 2, 'v' => 1]], 'id');
$sorted = $c2->sort(function ($a, $b) { return ($a['v'] <=> $b['v']); });
echo "Sorted collection: "; var_dump($sorted->toArray());

$keyOfLow = $c2->find_key(function ($it) { return $it['v'] === 1; });
echo "Key of v===1: "; var_dump($keyOfLow);

echo "Any v>2?: "; var_dump($c2->any(function ($it) { return $it['v'] > 2; }));
echo "All have v>0?: "; var_dump($c2->all(function ($it) { return $it['v'] > 0; }));

$spliced = $c2->splice(0, 1, [['id' => 3, 'v' => 0]]);
echo "After splice (mutated c2): "; var_dump($c2->toArray());

$sliced = $c2->slice(0, 1);
echo "Sliced (new collection): "; var_dump($sliced->toArray());

// diff/intersect
$a = new Collection([1, 2, 3], null);
$b = new Collection([2, 3, 4], null);
echo "Diff a-b: "; var_dump($a->diff($b)->toArray());
echo "Intersect a-b: "; var_dump($a->intersect($b)->toArray());

echo "Done.\n";
