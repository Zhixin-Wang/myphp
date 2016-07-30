<?php
include 'DB_connect.php';

class article_M extends DB
{
	var $user;
	var $user_all=array();
	var $result;
	var $type;

	function __construct($user)
	{
		parent::__construct();
		$this->user_all=$user;
		$this->user=$user['name'];
		$this -> receive();
	}

	public function receive()
	{
		if( count($_POST) != 0)
		{
			if (@$_POST['add']) {
				$this ->save($this->user,$_POST['title'],$_POST['contant'],date('Y-m-d h:i:s',time()),$_POST['typee']);
			}
			if (@$_POST['updata']) {
				$this ->a_updata($_POST['title'],$_POST['contant'],date('Y-m-d h:i:s',time()),$_POST['typee'],$_GET['id']);
			}
		}
		if( count($_GET) != 0)
		{
			if(@$_GET['action']=="del")
			{
				$this ->a_delete($_GET['id']);
			}
		}
	}

	public function save($n='',$tt='',$c='',$t='',$tp='')
	{
		echo "dao save l ";
		$query = "INSERT INTO `article` (`id`, `user`, `title`, `content`, `time`, `type`) VALUES (NULL, '$n', '$tt', '$c', '$t', '$tp');";
		mysql_query($query);
		echo "<SCRIPT>window.location = \"article.php\"; </SCRIPT>";
	}

	public function show_form($row='')
	{	if ($_GET['act'] == 'add') {
			$name = "add";
			$value='发布日志';
		}
		else{
			$name = "updata";
			$value='修改日志';
		}
		echo "<form action='' method='POST'>";
		echo "<dl>";
		echo "<dt>title:"."<br>"."<textarea class='inputBox' type='text' name='title'>".@$row['title']."</textarea>"."<br></dt>";
		echo "<dt>Contant:"."<br>"."<textarea class='inputBox' id='texta' type='text' name='contant'>".@$row['content']."</textarea>"."<br></dt>";
		echo "<dt>种类："
			."<input type='radio' name='typee' value='diray'>"."日记"
			."<input type='radio' name='typee' value='php'>"."php"
			."<input type='radio' name='typee' value='others'>"."其他</dt>";
		echo "<dt><input type='submit' value=".$value."  name=".$name."></dt>";
		echo "</dl>";
		echo "</form>";
	}

	public function load()
	{
		$this -> show("SELECT `id`,`user`, `title`, `content`, `time` FROM `article`");
	}


	public function show($sql)
	{
		if (isset($this ->type)) {
			$sql .=$this ->type;
		}
		elseif (isset($_GET['type'])) {
			$sql .=$_GET['type'];
		}

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
		echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=1&type=".$this ->type."\">首页</a>";
		if ($page == 1 && $page == $page_count) {
			echo " ";
		}
		elseif($page == 1){
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page+1)."&type=".$this ->type."\">下一页</a>";
		}
		elseif ($page == $page_count) {
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page-1)."&type=".$this ->type."\">上一页</a>";
		}
		else{
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page-1)."&type=".$this ->type."\">上一页</a>";
			echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=".($page+1)."&type=".$this ->type."\">下一页</a>";
		}
		echo"<a class=\"page\" href=\"?act=".$_GET['act']."&action=page&page=$page_count&type=".$this ->type."\">尾页</a>";
		echo "<hr />";
		}

		$query = $sql." ORDER BY `id` DESC limit ".($page-1)*$page_size.",".$page_size;
		$result = mysql_query($query);
		$this->result = $result;

		if ($num = mysql_num_rows($result)) {
			echo "<dl>";
			while ($row = mysql_fetch_array($result)) {
				$id = $row['id'];
				echo "<dt>
						<div class=\"title\">
						<div class=\"title_l\">
						<a href=\"?act=article&id= $id\">".$row['title']."</a>
						</div>
						<div class=\"title_r\">
						".$row['user']."   ".$row['time']."
						</div>
						</div>
					</dt>";
				if ($this ->user_all['administrator'] == "Y" || $this->user ==$row['user'] ) {
					if (isset($_GET['act'])) {
					echo "<dd id=\"text_r\">";
					echo "<a href=\"?act=".$_GET['act']."&action=del&id= $id&type=".$this ->type."\">删除</a>";

					}
				}
				if ($this->user ==$row['user']) {
					echo "|";
					echo "<a href=\"?act=updata&action=updata&id= $id\">编辑</a>";
					echo "</dd>";
				}
				echo "<dt>";
				echo "<hr>";
				echo "</dt>";
			}
			echo "</dl>";
		}

	}

	public function a_delete($id)
	{
		$query = "DELETE FROM `article` WHERE `article`.`id` = $id;";
		mysql_query($query);
	}

	public function a_updata_show($id)
	{
		$query = "SELECT * FROM `article` WHERE `id` = $id";
		$result=mysql_query($query);
		$total = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		$this -> show_form($row);
	}

	public function a_updata($tt,$c,$t,$tp='',$id)
	{
		$query = "UPDATE `article` SET `title` = '$tt', `content` = '$c', `time` = '$t', `type` = '$tp' WHERE `article`.`id` = $id;";
		mysql_query($query);
		echo "<SCRIPT>window.location = \"article.php\"; </SCRIPT>";
	}

	public function article_show($id)
	{
		$query = "SELECT * FROM `article` WHERE `id` = $id";
		$result=mysql_query($query);
		$total = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		echo "<dl>";
		echo "<dt id=\"text_c\">";
		echo $row['title'];
		echo "</dt>";
		echo "<dt id=\"text_c\">";
		echo $row['user'];
		echo "</dt>";
		echo "<dt id=\"text_l\">";
		echo $row['content'];
		echo "</dt>";
		echo "<dt id=\"text_r\">";
		echo $row['time'];
		echo "</dt>";
		echo "</dl>";
	}

	public function t_type_show()
	{
		$query = "SELECT * FROM `type_a`";
		$result=mysql_query($query);
		$row = mysql_fetch_assoc($result);
		foreach ($row as $key => $value) {
				if($key == 'id'){continue;}
				echo "<li id=\"m_bottom\">";
				echo "<a href=\"?act=type&type=".$key."\">".$key."</a>";
				echo "</li>";
			}

	}

	public function type_show($type)
	{
		$this ->type = $type;
		$query = "SELECT a.id,a.title,a.user,a.time FROM article AS a INNER JOIN type_a AS t ON a.type=t.";
		$this -> show($query);
	}

	public function mya_show()
	{
		$query = "SELECT * FROM `article` WHERE `user` LIKE '$this->user'";
		$this -> show($query);
	}
}

?>