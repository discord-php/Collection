<?php

require __DIR__ . '/../vendor/autoload.php';

use Discord\Helpers\Collection;

echo "Collection Usage Examples\\n\\n";

// Basic construction and pushing arrays
$col = new Collection(); // default discrim 'id'
$col->push(['id' => 1, 'name' => 'Alice'], ['id' => 2, 'name' => 'Bob']);
echo "Count: "; var_dump($col->count()); // => int(2)
echo "First: "; var_dump($col->first()); // => array with id 1, name Alice
echo "Last: "; var_dump($col->last()); // => array with id 2, name Bob

// Get by discrim
$item = $col->get('id', 2);
echo "Get id=2: "; var_dump($item); // => array id=2, name=Bob

// Push an object
$obj = new stdClass(); $obj->id = 3; $obj->name = 'Carol';
$col->pushItem($obj);
echo "Get object id=3: "; var_dump($col->get('id', 3)); // => object(stdClass) with id 3, name Carol

// Pull removes and returns item
$pulled = $col->pull(2);
echo "Pulled: "; var_dump($pulled); // => the removed array for id=2
echo "Has 2? "; var_dump($col->has(2)); // => bool(false)

// Shift returns first key=>value and removes it
$shifted = $col->shift();
echo "Shifted: "; var_dump($shifted); // => array with the first key=>value pair removed

// Search (by value) and find (by predicate)
$foundKey = $col->search($obj, true);
echo "Search strict for object: "; var_dump($foundKey); // => int(0) (index of the object)

$found = $col->find(function ($it) { return (is_array($it) ? $it['name'] : $it->name) === 'Alice'; });
echo "Find name Alice: "; var_dump($found); // => null (Alice was shifted/pulled earlier)

// Map returns new Collection
$names = $col->map(function ($it) { return is_array($it) ? $it['name'] : $it->name; });
echo "Mapped names (as array): "; var_dump($names->toArray()); // => array containing remaining names (e.g., Carol)

// Demonstrate class restriction
class ExampleItem { public $id; public $name; public function __construct($id, $name) { $this->id = $id; $this->name = $name; } }
$sc = Collection::for(ExampleItem::class);
$sc->push(new ExampleItem(1, 'X'), new ExampleItem(2, 'Y'));
// Attempt to push an array (will be ignored due to class restriction)
$sc->push(['id' => 3, 'name' => 'Z']);
echo "Class-restricted collection toArray: "; var_dump($sc->toArray()); // => array with ExampleItem objects for ids 1 and 2

// jsonSerialize / toArray
echo "JSON serializable: "; var_dump($sc->jsonSerialize()); // => same structure as toArray

// ArrayAccess: set/get/isset/unset
$sc->set(5, new ExampleItem(5, 'E'));
echo "isset index 5: "; var_dump(isset($sc[5])); // => bool(true)
echo "value at 5: "; var_dump($sc[5]->name); // => "E"
unset($sc[5]);
echo "isset index 5 after unset: "; var_dump(isset($sc[5])); // => bool(false)

// Merge collections
$other = Collection::from([['id' => 10, 'name' => 'Other']]);
$sc->merge($other);
echo "Keys after merge: "; var_dump($sc->keys()); // => numeric keys after merge
echo "Values after merge: "; var_dump($sc->values()); // => ExampleItem objects plus the merged array element

// Unique, diff, intersect examples (using simple values)
$u = new Collection([1, 2, 2, 3], null, null); // discrim null keeps numeric insertion
echo "Unique values: "; var_dump($u->unique()->toArray()); // => array(1,2,3)

// Fill and clear
$u->clear();
$u->fill([['id' => 1, 'name' => 'A'], ['id' => 2, 'name' => 'B']]);
echo "Filled: "; var_dump($u->toArray()); // => arrays for A and B

// Walk and reduce (accumulate into an array so Collection::__construct() receives an array)
$reduced = $u->reduce(function ($carry, $item) {
	$carry[] = is_array($item) ? $item['name'] : $item->name;
	return $carry;
}, []);
echo "Reduced names array: "; var_dump($reduced->toArray()); // => array("A","B")

// Serialize / unserialize
// Serialize / unserialize
$s = $u->serialize();
$u2 = new Collection();
$u2->unserialize($s);
echo "Unserialized: "; var_dump($u2->toArray()); // => collection reconstructed from serialized JSON

// __debugInfo
echo "Debug info: "; var_dump($u2->__debugInfo()); // => same as unserialized output

// Additional utilities: find_key, any, all, splice, slice, sort, diff, intersect
$c2 = new Collection([['id' => 1, 'v' => 3], ['id' => 2, 'v' => 1]], 'id');
$sorted = $c2->sort(function ($a, $b) { return ($a['v'] <=> $b['v']); });
echo "Sorted collection: "; var_dump($sorted->toArray()); // => ordered by 'v' ascending

// find_key returns the key of the first matching element
$keyOfLow = $c2->find_key(function ($it) { return $it['v'] === 1; });
echo "Key of v===1: "; var_dump($keyOfLow); // => int(1)

echo "Any v>2?: "; var_dump($c2->any(function ($it) { return $it['v'] > 2; })); // => bool(true)
echo "All have v>0?: "; var_dump($c2->all(function ($it) { return $it['v'] > 0; })); // => bool(true)

// splice mutates the collection in place
$spliced = $c2->splice(0, 1, [['id' => 3, 'v' => 0]]);
echo "After splice (mutated c2): "; var_dump($c2->toArray()); // => id 3 now at index 0

$sliced = $c2->slice(0, 1);
echo "Sliced (new collection): "; var_dump($sliced->toArray()); // => new collection with the first element

// diff/intersect
$a = new Collection([1, 2, 3], null);
$b = new Collection([2, 3, 4], null);
echo "Diff a-b: "; var_dump($a->diff($b)->toArray()); // => array(1)
echo "Intersect a-b: "; var_dump($a->intersect($b)->toArray()); // => array(2,3)

echo "Done.\n";
