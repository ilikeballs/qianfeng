<?php
$original = [1,2,3,4,5,6,7,8,9];
$flip = [];
foreach($original as $v){
	array_unshift($flip, $v);
}
print_r($flip);