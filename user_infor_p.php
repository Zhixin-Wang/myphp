<?php

include 'DB_connect.php';
session_start();
$user = $_SESSION['user'];


class user_infor extends DB
{
	var $user;
	var $user_all=array();
	function __construct($user)
	{
		parent::__construct();
		$this->user_all=$user;
		$this->user=$user['name'];
		$this->receive();
		$this->save_pic();
	}

	public function receive()
	{
		if (count($_GET) != 0) {
			if(@$_GET['act']=="updata_admin")
			{
				$this ->updata_admin();
			}
		}
	}

	public function show_s()
	{
		$sql="SELECT `name`, `gender`, `email`, `comment`, `administrator` FROM `user` WHERE `name` LIKE '$this->user'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		foreach ($row as $key => $value) {
			echo "<table class=\"table_infor\">";
			echo "<tr>";
			echo "<td width=\"300\">";
			echo $key.":";
			echo "</td>";
			echo "<br>";
			echo "<td width=\"400\">";
			if ($key != "administrator") {
				echo $value;
			}
			elseif ($value=='N') {
				echo "普通用户";
				echo "<a href=\"?act=updata_admin\">申请管理员</a>";
			}
			elseif ($value=='W') {
				echo "申请管理员中，待审核";
			}
			elseif ($value=='Y') {
				echo "管理员";
			}
			echo "</td>";
			echo "</tr>";
			echo "</table>";
		}
	}

	public function updata_admin()
	{
		$sql = "UPDATE `user` SET `administrator` = 'W' WHERE `user`.`name` = '$this->user'";
		mysql_query($sql);
	}

	public function exit_user()
	{
		$sql = "SELECT * FROM `portrait` WHERE `user` LIKE '$this->user'";
		$res = mysql_query($sql);
		$row = mysql_fetch_row($res);
		if ($row == 0) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function save_pic()
	{
		if (@$_FILES['user_pic']['size'] != '0' && @$_POST['go_pic']) {
		$image_fieldname = "user_pic";
		$now = time();
		while (file_exists($upload_filename = $this->user.'_'.$now)) {
			$now++;
		}
		$image = $_FILES[$image_fieldname];
		$image_filename = $image['name'];

		$image_info = getimagesize($image['tmp_name']);
		$image_mime = $image_info['mime'];
		$image_size = (int)$image['size'];
		$fp=fopen($image['tmp_name'], 'rb');
		$image_data = addslashes(fread($fp, filesize($image['tmp_name'])));
		if ($this->exit_user()) {
			// echo "更新用户！";
		$sql = "UPDATE `portrait` SET `mime_type` = '$image_mime', `file_size` = '$image_size', `photo` = '$image_data' WHERE `portrait`.`user` = '$this->user';";
		}
		else{
			// echo "添加用户！";
		$sql = "INSERT INTO `portrait` (`id`, `user`, `mime_type`, `file_size`, `photo`) VALUES (NULL, '$this->user', '$image_mime', '$image_size', '$image_data')";
		}
		 // echo $sql;
		// $sql = sprintf("INSERT INTO `portrait` (`id`, `user`, `mime_type`, `file_size`, `photo`) VALUES (NULL, '%s', '%s', '%d', '%s')",
		// 	mysql_real_escape_string($this->user),
		// 	mysql_real_escape_string($image_mime),
		// 	mysql_real_escape_string($image_size),
		// 	mysql_real_escape_string($image_data)
		// 	);
			// $this->user,$image_mime,$image_size,$image_data);
		mysql_query($sql);
	}
	}
}
?>