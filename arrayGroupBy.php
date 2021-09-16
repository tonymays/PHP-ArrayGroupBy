<?php
declare(strict_types = 1);

class arrayGroupBy {
	private $array = [];

	// ---- class constructor ----
	public function __construct(array $array) {
		// set the array given
		$this->setArray($array);
	}

	// ---- class destructor ----
	public function __destruct() {
		// null out the array private variable
		$this->array = null;
	}

	// ---- setArray ----
	// set the array private variable if and only if the array is a multi-dimensional array
	public function setArray(array $array) : void {
		// set the class $array private variable ... throw an error if the array given is not a multi-dimensional array
		if ($this->isMultiDimensionalArray($array)) {
			$this->array = $array;
		} else {
			throw new Exception('critical error: invalid array - must be a multi-dimensional array');
		}
	}

	// ---- getArray ----
	// standard getter for the $array private variable
	public function getArray() : array {
		return $this->array;
	}

	// ---- list ----
	// list the array by $column and then filter the array by $filter
	public function list(string $column, string $filter = '') : array {
		// error is missing column
		if ($column === '') {
			throw new Exception('critical list error: column cannot be empty');
		}

		// init worker arrays
		$columns = [];
		$result = [];
		$temp = [];

		// get a unique list of elements within the specified column
		foreach($this->array as $key=>$value) {
			if (!in_array($value[$column], $columns, true)) {
				array_push($columns, $value[$column]);
			}
		}

		// sort the columns - sorting numeric first and then sorting normal
		// allows for both numeric and string columns to be sorted accurately
		sort($columns, SORT_NUMERIC);
		sort($columns);

		// group array by column
		foreach($columns as $key=>$value) {
			// group the column if there is no filter of if the filter equals
			// the specified element within the column
			if ($filter == '' || $filter == $value) {
				$result = $result + [$value => $this->filter($column, $value)];
			}
		}

		// return the result
		return $result;
	}

	public function sum(string $column, string $groupByColumn = '', string $filter = '') : array {
		if (!$this->isColumnNumeric($column)) {
			throw new Exception('critical error: column ' . $column . ' is not a numeric column');
		}
		return [];
	}

	// ---- filter ----
	// filter the array by column name and column value
	private function filter(string $colName, string $colValue) : array {
		$result = [];
		foreach($this->array as $key=>$value) {
			if ($value[$colName] === $colValue) {
				$result[$key] = array_merge($this->array[$key], $value);
			}
		}
		return array_values($result);
	}

	// ---- isMultiDimensionalArray ----
	private function isMultiDimensionalArray(array $array) : bool {
		return (!(count($array) == count($array, COUNT_RECURSIVE)));
	}

	// ---- isColumnNumeric ----
	private function isColumnNumeric(string $column) : bool {
		$result = true;
		foreach($this->array as $key=>$value) {
			if (!is_numeric($value[$column])) {
				$result = false;
				break;
			}
		}
		return $result;
	}
}