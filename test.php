<?php
echo "<pre>";

	
$items = array(
	array('num'=>5,'period'=>3),
 	array('num'=>10,'period'=>3),
 	array('num'=>15,'period'=>9),
);
 
$map=[];
foreach($items  as $item){
 	$key=$item['period'];
 	if(isset($map[$key])){
 		$map[$key]['num']+=$item['num'];
 	}else{
 		$map[$key]=$item;
 	}
 }
 
 array_values($map);
   print_r($map);

exit;

$items = array(
	array('http://www.abc.com/a/', 100, 120),
	array('http://www.abc.com/b/index.php', 50, 80),
	array('http://www.abc.com/a/index.html', 90, 100),
	array('http://www.abc.com/a/?id=12345', 200, 33),
	array('http://www.abc.com/c/index.html', 10, 20),
	array('http://www.abc.com/abc/', 10, 30)
);

$sum = [];
foreach($items as $value){
	$url = substr($value[0], 0, strrpos($value[0], '/')+1);
	print_r($url);echo "<br/>";
	if(strpos($value[0], $url) !== false){
		// $sum[][$url] += 1;
		/*$sum[][] = $url;
		$sum[][] += $value[1];
		$sum[][] += $value[2];*/
	}/*else{
		$sum[][] = $url;
		$sum[][] = $value[1];
		$sum[][] = $value[2];
	}*/
}
// print_r($sum);




/*class User{
	public $name;
	public $age;
	public function __construct($name,$age){
		$this->name = $name;
		$this->age = $age;
	}
	public function showName(){
		return $this->name;
	}
	public function showAge(){
		return $this->age;
	}
}
$user = new User;
$objString = serialize($user);*/




































































echo "</pre>";