# PHP-ArrayGroupBy
A PHP class that provides array group by features such as organized lists, counts, summations, averages, etc.

```
Built on PHP 7.4.23
Zend Engine v3.4.0

This class is not backwards compatible to PHP 5 because it uses scalar and return
type declarations
```

## Example Data
You this data in all your tests
```
$src = [
	['name'=>'Jake', 'department'=>'Marketing', 'salary'=>'61000'],
	['name'=>'John', 'department'=>'Sales', 'salary'=>'80000'],
	['name'=>'Kenzie', 'department'=>'Accounting', 'salary'=>'75000'],
	['name'=>'Mark', 'department'=>'Marketing', 'salary'=>'58000'],
	['name'=>'Connor', 'department'=>'Operations', 'salary'=>'58000'],
	['name'=>'Jeff', 'department'=>'Marketing', 'salary'=>'52000'],
	['name'=>'Bill', 'department'=>'Sales', 'salary'=>'45000'],
	['name'=>'Frank', 'department'=>'Operations', 'salary'=>'75000'],
	['name'=>'Beth', 'department'=>'Accounting', 'salary'=>'39000'],
	['name'=>'Sarah', 'department'=>'Operations', 'salary'=>'115000'],
];
```

## Example List
* public function list(string $column, string $filter = '') : array
* groups all array elements by the column specified
* see the next section for filter application

<ins>Code</ins>
```bash
<?php
require_once("arrayGroupBy.php");

/* Place copy of src data here */

$a = new arrayGroupBy($src);
print_r($a->list('department'));
```

<ins>Output</ins>
```bash
Array
(
    [Accounting] => Array
        (
            [0] => Array
                (
                    [name] => Kenzie
                    [department] => Accounting
                    [salary] => 75000
                )

            [1] => Array
                (
                    [name] => Beth
                    [department] => Accounting
                    [salary] => 39000
                )
        )
    [Marketing] => Array
        (
            [0] => Array
                (
                    [name] => Jake
                    [department] => Marketing
                    [salary] => 61000
                )

            [1] => Array
                (
                    [name] => Mark
                    [department] => Marketing
                    [salary] => 58000
                )

            [2] => Array
                (
                    [name] => Jeff
                    [department] => Marketing
                    [salary] => 52000
                )
        )
    [Operations] => Array
        (
            [0] => Array
                (
                    [name] => Connor
                    [department] => Operations
                    [salary] => 58000
                )

            [1] => Array
                (
                    [name] => Frank
                    [department] => Operations
                    [salary] => 75000
                )

            [2] => Array
                (
                    [name] => Sarah
                    [department] => Operations
                    [salary] => 115000
                )
        )
    [Sales] => Array
        (
            [0] => Array
                (
                    [name] => John
                    [department] => Sales
                    [salary] => 80000
                )

            [1] => Array
                (
                    [name] => Bill
                    [department] => Sales
                    [salary] => 45000
                )
        )
)
```

## Example List with Filter
* A filter can be specified to grab only those elements that meet the filter

<ins>Code</ins>
```bash
<?php
require_once("arrayGroupBy.php");

/* Place copy of src data here */

$a = new arrayGroupBy($src);
print_r($a->list('department', 'Operations'));
```

<ins>Output</ins>
```bash
Array
(
    [Operations] => Array
        (
            [0] => Array
                (
                    [name] => Connor
                    [department] => Operations
                    [salary] => 58000
                )

            [1] => Array
                (
                    [name] => Frank
                    [department] => Operations
                    [salary] => 75000
                )

            [2] => Array
                (
                    [name] => Sarah
                    [department] => Operations
                    [salary] => 115000
                )
        )
)
```

## Example Sum
* public function sum(string $sumColumn, string $groupByColumn = '', string $filter = '') : array
* sums the sumColumn for each groupByColumn
* see the next section for filter application

<ins>Code</ins>
```bash
<?php
require_once("arrayGroupBy.php");

/* Place copy of src data here */

$a = new arrayGroupBy($src);
print_r($a->sum('salary', 'department'));
```

<ins>Output</ins>
```bash
Array
(
    [Accounting] => 114000
    [Marketing] => 171000
    [Operations] => 248000
    [Sales] => 125000
)
```
## Example Sum with Filter
* A filter can be specified to grab only those elements that meet the filter

<ins>Code</ins>
```bash
<?php
require_once("arrayGroupBy.php");

/* Place copy of src data here */

$a = new arrayGroupBy($src);
print_r($a->sum('salary', 'department', 'Operations'))
```

<ins>Output</ins>
```bash
Array
(
    [Operations] => 248000
)
```