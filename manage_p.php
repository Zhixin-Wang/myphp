<?php
include 'DB_connect.php';

class manage extends DB
{
	var $user;
	var $user_all=array();

	function __construct($user)
	{
		parent::__construct();
		$this->user_all=$user;
		$this->user=$user['name'];
		$this -> receive();
	}

	public function receive()
	{
		if( count($_GET) != 0)
		{
			if(@$_GET['action']=="adm")
			{
				$this ->updata_admin($_GET['user']);
			}
		}
	}

	public function show($sql)
	{
		$page_size=5;
		if(isset($_GET['page']))
		{
			$page=$_GET['page'];
		}
		else
		{
			$page = 1;
		}

		$res = mysql_query($sql);
		$total = mysql_num_rows($res);

		if ($total) {
			if ($total < $page_size) {
				$page_count = 1;
			}
			if ($total % $page_size) {
				$page_count = (int)($total / $page_size)+1;
			}
			else
			{
				$page_count = $total / $page_size;
			}
		}
		else
		{
			$page_count = 0;
		}

		if (isset($_GET['act'])) {
		echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=1\">首页</a>";
		if ($page == 1 && $page == $page_count) {
			echo " ";
		}
		elseif($page == 1){
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page+1)."\">下一页</a>";
		}
		elseif ($page == $page_count) {
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page-1)."\">上一页</a>";
		}
		else{
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page-1)."\">上一页</a>";
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page+1)."\">下一页</a>";
		}
		echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=$page_count\">尾页</a>";
		echo "<hr />";
		}

		$query = $sql." ORDER BY `id` DESC limit ".($page-1)*$page_size.",".$page_size;
		$result = mysql_query($query);

		if ($num = mysql_num_rows($result)) {
			echo "<dl>";
			while ($row = mysql_fetch_array($result)) {
				$name = $row['name'];
				echo "<dt>
						<div class=\"title\">
						<div class=\"title_l\">
						".$row['name']."
						</div>
						<div class=\"title_r\">
						<a href=\"?act=".$_GET['act']."&action=adm&user=$name&up=Y\">同意</a>
						 | <a href=\"?act=".$_GET['act']."&action=adm&user=$name&up=N\">拒绝</a>
						</div>
						</div>
					</dt>";
				echo "<dt>";
				echo "<hr>";
				echo "</dt>";
			}
			echo "</dl>";
		}

	}

	public function show_admin()
	{
		$sql="SELECT `name` FROM `user` WHERE `administrator` LIKE 'W'";
		$this->show($sql);
	}

	public function updata_admin($user)
	{
		$this->datebese = @mysql_connect('localhost','wzx','123456');

		$result = mysql_select_db('db_wzx',$this->datebese);

		if ($_GET['up'] == 'Y') {
			$admin = 'Y';
		}
		else{
			$admin = 'N';
		}
		$sql = "UPDATE `user` SET `administrator` = '$admin' WHERE `user`.`name` = '$user'";
		mysql_query($sql);
	}
}

?>