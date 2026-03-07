# Output: collection_usage.php

Command:

```bash
php examples/collection_usage.php
```

Run date: 2026-01-21

Output:

```
Collection Usage Examples

Count: int(2)
First: array(2) {
  ["id"]=>
  int(1)
  ["name"]=>
  string(5) "Alice"
}
Last: array(2) {
  ["id"]=>
  int(2)
  ["name"]=>
  string(3) "Bob"
}
Get id=2: array(2) {
  ["id"]=>
  int(2)
  ["name"]=>
  string(3) "Bob"
}
Get object id=3: object(stdClass)#4 (2) {
  ["id"]=>
  int(3)
  ["name"]=>
  string(5) "Carol"
}
Pulled: array(2) {
  ["id"]=>
  int(2)
  ["name"]=>
  string(3) "Bob"
}
Has 2? bool(false)
Shifted: array(1) {
  [1]=>
  array(2) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(5) "Alice"
  }
}
Search strict for object: int(0)
Find name Alice: NULL
Mapped names (as array): array(1) {
  [0]=>
  string(5) "Carol"
}
Class-restricted collection toArray: array(2) {
  [1]=>
  object(ExampleItem)#7 (2) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(1) "X"
  }
  [2]=>
  object(ExampleItem)#8 (2) {
    ["id"]=>
    int(2)
    ["name"]=>
    string(1) "Y"
  }
}
JSON serializable: array(2) {
  [1]=>
  object(ExampleItem)#7 (2) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(1) "X"
  }
  [2]=>
  object(ExampleItem)#8 (2) {
    ["id"]=>
    int(2)
    ["name"]=>
    string(1) "Y"
  }
}
isset index 5: bool(true)
value at 5: string(1) "E"
isset index 5 after unset: bool(false)
Keys after merge: array(3) {
  [0]=>
  int(0)
  [1]=>
  int(1)
  [2]=>
  int(2)
}
Values after merge: array(3) {
  [0]=>
  object(ExampleItem)#7 (2) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(1) "X"
  }
  [1]=>
  object(ExampleItem)#8 (2) {
    ["id"]=>
    int(2)
    ["name"]=>
    string(1) "Y"
  }
  [2]=>
  array(2) {
    ["id"]=>
    int(10)
    ["name"]=>
    string(5) "Other"
  }
}
Unique values: array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [3]=>
  int(3)
}
Filled: array(2) {
  [0]=>
  array(2) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(1) "A"
  }
  [1]=>
  array(2) {
    ["id"]=>
    int(2)
    ["name"]=>
    string(1) "B"
  }
}
Reduced names array: array(2) {
  [0]=>
  string(1) "A"
  [1]=>
  string(1) "B"
}
Unserialized: array(2) {
  [0]=>
  object(stdClass)#13 (2) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(1) "A"
  }
  [1]=>
  object(stdClass)#14 (2) {
    ["id"]=>
    int(2)
    ["name"]=>
    string(1) "B"
  }
}
Debug info: array(2) {
  [0]=>
  object(stdClass)#13 (2) {
    ["id"]=>
    int(1)
    ["name"]=>
    string(1) "A"
  }
  [1]=>
  object(stdClass)#14 (2) {
    ["id"]=>
    int(2)
    ["name"]=>
    string(1) "B"
  }
}
Sorted collection: array(2) {
  [1]=>
  array(2) {
    ["id"]=>
    int(2)
    ["v"]=>
    int(1)
  }
  [0]=>
  array(2) {
    ["id"]=>
    int(1)
    ["v"]=>
    int(3)
  }
}
Key of v===1: int(1)
Any v>2?: bool(true)
All have v>0?: bool(true)
After splice (mutated c2): array(2) {
  [0]=>
  array(2) {
    ["id"]=>
    int(3)
    ["v"]=>
    int(0)
  }
  [1]=>
  array(2) {
    ["id"]=>
    int(2)
    ["v"]=>
    int(1)
  }
}
Sliced (new collection): array(1) {
  [0]=>
  array(2) {
    ["id"]=>
    int(3)
    ["v"]=>
    int(0)
  }
}
Diff a-b: array(1) {
  [0]=>
  int(1)
}
Intersect a-b: array(2) {
  [1]=>
  int(2)
  [2]=>
  int(3)
}
Done.
```
