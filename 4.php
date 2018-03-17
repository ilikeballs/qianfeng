<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=test', "root", "root");
$userInfo = [];
$i = 0;

$postData = file_get_contents("php://input");
$userDatas = explode("&", urldecode($postData));
$use = [];
foreach($userDatas as $userData){
	$data = explode("=", $userData);
	$use[$data[0]] = $data[1];
}
$user1 = $use["user"];
$age1 = $use["age"];
$userResult = $pdo->query("select * from user where name = '{$user1}' and age = {$age1}");
foreach($userResult as $value){
	$userInfo[$i]['name'] = $value['name'];
	$userInfo[$i]['age'] = $value['age'];
	$i++;
}
$export = var_export($userInfo, true);
echo $export;