<?php
declare(strict_types = 1);

class arrayGroupBy {
	private $src = [];

	public function __construct(array $src) : void {
		$this->src = $src;
	}

	public function __destruct() : void {
		$this->src = [];
	}

	public function list() : array {
		return $src;
	}
}