<?php
declare(strict_types = 1);

class arrayGroupBy {
	private $array = [];
	private $types = [];

	// ---- class constructor ----
	public function __construct(array $array) {
		$this->setArray($array);
		$this->types = ['sum', 'count', 'avg'];
	}

	// ---- class destructor ----
	public function __destruct() {
		$this->array = null;
		$this->types = null;
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
			if ($filter == '' || $filter == $value) {
				$result = $result + [$value => $this->filter($column, $value)];
			}
		}

		// return the result
		return $result;
	}

	// ---- sum ----
	// sum the array by $column and then filter the arrau by $filter
	public function sum(string $sumColumn, string $groupByColumn = '', string $filter = '') : array {
		return $this->doAggregation('sum', $sumColumn, $groupByColumn, $filter);
	}

	// ---- count ----
	// count the array by $column and then filter the arrau by $filter
	public function count(string $countColumn, string $groupByColumn = '', string $filter = '') : array {
		return $this->doAggregation('count', $countColumn, $groupByColumn, $filter);
	}

	// ---- count ----
	// count the array by $column and then filter the arrau by $filter
	public function avg(string $avgColumn, string $groupByColumn = '', string $filter = '') : array {
		return $this->doAggregation('avg', $avgColumn, $groupByColumn, $filter);
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

	// ---- doAggregation ----
	private function doAggregation(string $type, string $column, string $groupByColumn = '', string $filter = '') {
		if (!in_array($type, $this->types)) {
			throw new Exception('critical error: unknown aggregation type ' . $type . ' specified');
		}

		if (!$this->isColumnNumeric($column)) {
			throw new Exception('critical error: sum column ' . $column . ' is not a numeric column');
		}

		if ($column == $groupByColumn) {
			throw new Exception('critical error: sum column and group by column cannot be the same');
		}

		$result = [];
		$list = $this->list($groupByColumn, $filter);

		foreach($list as $key=>$value) {
			switch ($type) {
				case "sum":
					$result = $result + [$key=>$this->aggregate("sum", $value, $column)];
					break;
				case "count":
					$result = $result + [$key=>$this->aggregate("count", $value, $column)];
					break;
				case "avg":
					$result = $result + [$key=>$this->aggregate("avg", $value, $column)];
					break;
			}
		}

		return $result;
	}

	// ---- aggregate ----
	// aggregate the array by column name and column value
	private function aggregate(string $type, array $array, string $aggregateColumn) : float {
		$result = 0.0;
		switch($type) {
			case "sum":
				foreach($array as $key=>$value) {
					$result += $value[$aggregateColumn];
				}
				break;
			case "count":
				foreach($array as $key=>$value) {
					$result += 1;
				}
				break;
			case "avg":
				$sum = 0.0;
				$count = 0.0;
				foreach($array as $key=>$value) {
					$sum += $value[$aggregateColumn];
				}
				foreach($array as $key=>$value) {
					$count += 1;
				}
				$result = $sum / $count;
				break;
		}
		return $result;
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