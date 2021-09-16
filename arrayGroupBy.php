<?php
declare(strict_types = 1);

class arrayGroupBy {
	private $array = [];

	public function __construct(array $array) {
		$this->set($array);
	}

	public function __destruct() {
		$this->src = [];
	}

	public function set(array $array) : void {
		if ($this->isValidMultiDimensional($array)) {
			$this->array = $array;
		} else {
			throw new Exception("critical error: invalid array - must be an associaitve array");
		}
	}

	public function get() : array {
		return $this->array;
	}

	public function list() : array {
		return $this->array;
	}

	private function isValidMultiDimensional(array $array) : bool {
		return (!(count($array) == count($array, COUNT_RECURSIVE)));
	}
}