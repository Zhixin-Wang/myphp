<?php
class Message
{
	var $id;
	var $name;
	var $time;
	var $content;

	public function __construct($i,$n,$t,$c)
	{
		$this->id=$i;
		$this->name=$n;
		$this->time=$t;
		$this->content=$c;
	}

	public function show()
	{
		echo "<hr />";
		echo "name:".$this->name."<br>";
		echo "time:".$this->time."<br>";
		echo "content:".$this->content."<br>";
	}
}
?>

<?php
	include 'DB_connect.php';

class Messageboard extends DB
{
	var $D_message = array();
	function __construct()
	{
		parent::__construct();
		$this -> receive();
		$this -> load();
	}

	public function receive()
	{
		if( count($_POST) != 0)
		{
			$this ->save($_POST['name'],date('Y-m-d h:i:s',time()),$_POST['contant']);
		}
		if( count($_GET) != 0)
		{
			if($_GET['action']=="del")
			{
				$this ->M_delete($_GET['id']);
			}
		}
	}
	public function save($n,$t,$c)
	{
		$query = "INSERT INTO `messagedb` (`id`, `name`, `time`, `contant`) VALUES (NULL, '".$n."', '".$t."', '".$c."')";
		mysql_query($query);
	}
	public function M_delete($id)
	{
		$query = "DELETE FROM `messagedb` WHERE `messagedb`.`id` = $id";
		mysql_query($query);
	}

	public function load()
	{
		$query = "SELECT * FROM `messagedb` ORDER BY id DESC";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{
			$temp = new Message($row['id'],$row['name'],$row['time'],$row['contant']);
			array_push($this->D_message, $temp);
		}
	}
	public function show_all()
	{
		$page =0;
		$n=4;
		$count = count($this->D_message);
		if( count($_GET) != 0)
		{
			if($_GET['action']=="page")
			{
				$page=$_GET['p'];
				$page += $_GET['inc'];
			}
		}
		$page_max = ceil($count/$n);

		for ($i=0; $i<$n ; $i++) {
			$nc = $page+$i;
			if(@$this->D_message[$nc] != null)
			{
				$this->D_message[$nc] -> show();
				$id = $this->D_message[$nc]->id;
				echo"<a href=\"?action=del&id= $id\">删除</a>";
			}
		}
		echo "<hr />";
		if($page == 0){
			echo"<a class=\"page\" href=\"?action=page&p=$page&inc=+$n\">下一页</a>";
		}
		elseif (ceil($page /$n)+1 == $page_max) {
			echo"<a class=\"page\" href=\"?action=page&p=$page&inc=-$n\">上一页</a>";
		}
		else{
			echo"<a class=\"page\" href=\"?action=page&p=$page&inc=-$n\">上一页</a>";
			echo"<a class=\"page\" href=\"?action=page&p=$page&inc=+$n\">下一页</a>";
		}
	}
	public function show_form()
	{
		echo "<form action='' method='POST'>";
		echo "Name:"."<input class='inputBox' type='text' name='name'>"."<br>";
		echo "Contant:"."<textarea class='inputBox' id='textm' type='text' name='contant'></textarea>"."<br>";
		echo "<input type='submit' value='发布留言'>";
		echo "</form>";
	}
}
?>