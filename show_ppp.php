<?php
		$user=$_GET['user'];
		// var_dump($user);
		$datebese = @mysql_connect('localhost','wzx','123456');
		$res = mysql_select_db('db_wzx',$datebese);
		// $sql ="SELECT * FROM `portrait` WHERE `user` LIKE 'wzx'";

		$sqll = "SELECT * FROM `portrait` WHERE `user` LIKE '$user'";
		$ress = mysql_query($sqll);
		$roww = mysql_fetch_row($ress);
		if ($roww == 0) {
			$user = "null";
		}
		$sql    = "select * from portrait where user='$user'";
		$result = mysql_query($sql);
		// $image_t = mysql_result($result,0,'mime_type');
		// $image_p = mysql_result($result,0,'photo');
		$row = mysql_fetch_assoc($result);
		// $image_p = $row['photo'];
		// var_dump($image_t);
		// header('Content-type: '.$image['mime_type']);
		// header('Content-size: '.$image['file_size']);

	 //    // echo "<img src=\"".$image['photo']."\">";
		$image_t= $row['mime_type'];
		header("Content-type: $image_t");

		// echo $image_p;
		echo  $row['photo'];
		// var_dump($image_p);



		?>