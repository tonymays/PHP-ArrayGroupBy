<?php
require_once("arrayGroupBy.php");

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

$a = new arrayGroupBy($src);
$runTest = 6;

if ($runTest == 1 ) print_r($a->list('department'));
if ($runTest == 2 ) print_r($a->list('department', "Operations"));
if ($runTest == 3 ) print_r($a->list('salary'));
if ($runTest == 4 ) print_r($a->list('salary', '58000'));
if ($runTest == 5 ) print_r($a->sum('salary', 'department'));
if ($runTest == 6 ) print_r($a->sum('salary', 'department', 'Operations'));


