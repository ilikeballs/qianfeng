<?php
$commits= array('A','B','B','A','C','C','D','A','B','C','D','C','C','C','D','A','B','C','D','A');
$answers= array('A','A','B','A','D','C','D','A','A','C','C','D','C','D','A','B','C','D','C','D');

$count = count($commits);
$num = 0;
$sum = 0;
for($i=0; $i<$count; $i++){
	if($commits[$i] == $answers[$i]){
		$num++;
	}
}
$sum = $num*5;
echo $sum;