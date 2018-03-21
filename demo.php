<?php
/* 第一题
	多维数组排序
	$items = array(
		array('http://www.abc.com/a/', 100, 120),
		array('http://www.abc.com/b/index.php', 50, 80),
		array('http://www.abc.com/a/index.html', 90, 100),
		array('http://www.abc.com/a/?id=12345', 200, 33),
		array('http://www.abc.com/c/index.html', 10, 20),
		array('http://www.abc.com/abc/', 10, 30)
	);
	变成如下的样子：
	array (
	  array ( 'http://www.abc.com/a/', 390,253),
	  array ('http://www.abc.com/b/', 50,80),
	  array ('http://www.abc.com/c/', 10,20),
	  array ('http://www.abc.com/abc/', 10,30)
	)
*/
$items = array(
	array('http://www.abc.com/a/', 100, 120),
	array('http://www.abc.com/b/index.php', 50, 80),
	array('http://www.abc.com/a/index.html', 90, 100),
	array('http://www.abc.com/a/?id=12345', 200, 33),
	array('http://www.abc.com/c/index.html', 10, 20),
	array('http://www.abc.com/abc/', 10, 30)
);
$map = array();
foreach($items as $item){
	$item[0] = substr($item[0], 0, strrpos($item[0], "/")+1);
	if(isset($map[$item[0]])){
		$map[$item[0]][0] = $item[0];
		$map[$item[0]][1] += $item[1];
		$map[$item[0]][2] += $item[2];
	}else{
		$map[$item[0]][0] = $item[0];
		$map[$item[0]][1] = $item[1];
		$map[$item[0]][2] = $item[2];
	}
}
sort($map);

/* 第二题
一群猴子排成一圈，按1，2，...，n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数，再数到第m只，在把它踢出去...，如此不停的进行下去，直到最后只剩下一只猴子为止，那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
*/
function king($n,$m){
	$monkeyArray = range(1,$n);
	$i = 0;
	while(count($monkeyArray) > 1){
		$tmpMonkey = $monkeyArray[$i];
		unset($monkeyArray[$i]);
		if(($i+1)%$m != 0){
			array_push($monkeyArray,$tmpMonkey);
		}
		$i++;
	}
	return $monkeyArray[$i];
}
print_r(king(5,2));

/* 第三题
得分计算，已知道选题提交的答案是
$commits= 'A,B,B,A,C,C,D,A,B,C,D,C,C,C,D,A,B,C,D,A';
实际的答案是：
$answers= 'A,A,B,A,D,C,D,A,A,C,C,D,C,D,A,B,C,D,C,D'
每题得分是5分，那么这个同学得分是多少？
*/

$commits = 'A,B,B,A,C,C,D,A,B,C,D,C,C,C,D,A,B,C,D,A';
$answers = 'A,A,B,A,D,C,D,A,A,C,C,D,C,D,A,B,C,D,C,D';
$commitsArray = explode(",",$commits);
$answersArray = explode(",",$answers);
print_r(array_intersect_assoc($commitsArray,$answersArray));


/* 第四题
应用：使用php://input接收post提交的参数，从db中获取数据，并使用var_export写入文件缓存，下次访问从文件中获取数据。
*/
	if(file_exists('cache.php')){
        $data = include ('cache.php');
    }else{
        $inputData = file_get_contents('php://input');
        $inputArray = explode('&',$inputData);
        $where = '';
        foreach ($inputArray as $user){
            if(empty($where)) {
                $where .= $user;
            }else {
                $where .= ' AND '.$user;
            }
        }
        $pdo = new PDO("mysql:localhost;dbname=test","root","root");
        $userResult = $pdo->query("select * from user where '.$where.' limit 1");
        $userInfo = array();
        foreach($userResult as $userValue){
        	$userInfo["name"] = $userValue["name"];
        }
        $userCache = '<?php return ';
        $userCache .= var_export($userInfo,true);
        $userCache .= ';';
        file_put_contents('cache.php',$userCache);
        $data = $userInfo;
    }

/* 第五题
	实现一个对象的数组式访问接口
*/

class  obj  implements  arrayaccess  {
    private  $container  = array();
    public function  __construct () {
         $this -> container  = array(
             "one"    =>  1 ,
             "two"    =>  2 ,
             "three"  =>  3 ,
        );
    }
    public function  offsetSet ( $offset ,  $value ) {
        if ( is_null ( $offset )) {
             $this -> container [] =  $value ;
        } else {
             $this -> container [ $offset ] =  $value ;
        }
    }
    public function  offsetExists ( $offset ) {
        return isset( $this -> container [ $offset ]);
    }
    public function  offsetUnset ( $offset ) {
        unset( $this -> container [ $offset ]);
    }
    public function  offsetGet ( $offset ) {
        return isset( $this -> container [ $offset ]) ?  $this -> container [ $offset ] :  null ;
    }
}

/* 第六题
有1000瓶水，其中有一瓶有毒，小白鼠只要尝一点带毒的水24小时后就会死亡，问至少要多少只小白鼠才能在24小时鉴别出哪瓶水有毒？
*/

/*
给1000个瓶分别标上如下标签（10位长度）： 
0000000001 （第1瓶） 
0000000010 （第2瓶） 
0000000011 （第3瓶） 
...... 
1111101000 （第1000瓶） 
从编号最后1位是1的所有的瓶子里面取出1滴混在一起（比如从第一瓶，第三瓶，。。。里分别取出一滴混在一起）并标上记号为1。以此类推，从编号第一位是1的所有的瓶子里面取出1滴混在一起并标上记号为10。现在得到有10个编号的混合液，小白鼠排排站，分别标上10，9，。。。1号，并分别给它们灌上对应号码的混合液。24小时过去了，过来验尸吧： 
从左到右，死了的小白鼠贴上标签1，没死的贴上0，最后得到一个序号，把这个序号换成10进制的数字，就是有毒的那瓶水的编号。 

检验一下：假如第一瓶有毒，按照0000000001 （第1瓶），说明第1号混合液有毒，因此小白鼠的生死符为0000000001（编号为1的小白鼠挂了），0000000001二进制标签转换成十进制=1号瓶有毒；假如第三瓶有毒，0000000011 （第3瓶），第1号和第2号混合液有毒，因此小白鼠的生死符为00000011（编号为1，2的鼠兄弟挂了），0000000011二进制标签转换成十进制=3号瓶有毒。
*/

/* 第七题
使用serialize序列化一个对象，并使用__sleep和__wakeup方法。
*/

class Person{
	private $name;
	private $age;
	private $sex;

	public function __construct($name="", $sex="", $age=""){
		$this->name = $name;
		$this->sex = $sex;
		$this->age = $age;
	}
	function say(){
		echo "我的名字叫".$this->name."，性别".$this->sex."，年龄".$this->age;
	}

	public function __sleep(){
		$array = array("name","age");
		return $array;
	}

	public function __wakeup(){
		$this->age=23;
	}

}

/* 第八题
利用数组栈实现翻转字符串功能
*/

$original = [1,2,3,4,5,6,7,8,9];
$flip = [];
foreach($original as $v){
	array_unshift($flip, $v);
}
print_r($flip);


/*
从m个数中选出n个数来 ( 0 < n <= m) ，要求n个数之间不能有重复，其和等于一个定值k，求一段程序，罗列所有的可能。
例如备选的数字是：11, 18, 12, 1, -2, 20, 8, 10, 7, 6 ，和k等于：18 
*/
define('K', 18);

$nums = array(11, 18, 12, 1, -2, 20, 8, 10, 7, 6);

$numscount = count($nums);

$subscount = 2 << ($numscount - 1); //每一次左移动都表示“乘以 2”。


for ($i = 1; $i < $subscount; $i++) {
    $subitem = array();
    $binstr = decbin($i);
    $binstr = str_pad($binstr, $numscount, '0', STR_PAD_LEFT);//填充左边0，实现0补全
    for ($j = 0; $j < $numscount; $j++) {
        if (1 == $binstr[$j]) {
            $subitem[] = $nums[$j];
        }
    }
    if (K == array_sum($subitem)) {
        echo json_encode($subitem) . "\n";
    }
}