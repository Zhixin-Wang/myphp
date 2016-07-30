<?php
  $nameErr = $passwordErr = "";
  $nErr = $pErr = "";

  if (count($_POST) != 0) {
     if (empty($_POST["name"])) {
       $nameErr = "姓名是必填的";
     }
     if (empty($_POST["password"])) {
    	$passwordErr = "密码是必填的";
     }
     else{
      // compare_np($_POST["name"],$_POST["password"]);
     	$datebese = @mysql_connect('localhost','wzx','123456');
   		$result = mysql_select_db('db_wzx',$datebese);
    	if($result)
		{}
		else
		{echo "DB select fail";}
		$p = $_POST["name"];
	    $query = "SELECT * FROM `user` WHERE `name` LIKE '$p'";
	    $res = mysql_query($query);
	    $row = mysql_fetch_array($res);
	    if ($row == 0) {
	    	$nErr = "用户名输入错误";
	    }
	    elseif ($row['password'] != crypt($_POST["password"],"salt")){
	    	$pErr = "密码输入错误";
	    }
	    else{
	    	session_start();
	    	$_SESSION['user'] = $row;
	    	echo "<SCRIPT>window.location = \"wzx_main.php\"; </SCRIPT>";
	    }

     }
   }
?>


<!DOCTYPE HTML>
<HTML>

<head>
	<TITLE>王志鑫的主页的登陆</TITLE>
	<link rel="stylesheet" type="text/css" href="mystyle.css" />
</head>

<body>
	<div class="longin_head">
		<p>  欢迎来到王志鑫的主页！</p>
	</div>
	<div class="log">
		<div class="longin_img">
			<img src="/img/LONGIN.JPG" width="250px">
		</div>
		<form method="post" action="">
			<dl >
				<dt></dt>
				<dd id="dd">用户：<input type="text" name="name" class="text"></input>
				<br />
				<span class="error"><?php echo $nameErr.$nErr;?></span>
				</dd id="dd">
				<dd id="dd">密码：<input type="password" name="password" class="text"></input>
				<br />
				<span class="error"><?php echo $passwordErr.$pErr;?></span>
				</dd>
				<input class="dd_d" type="submit" value="登陆"></input>
				<dd id="dd">
				<p>什么！还没注册？<a class="dd_a" href="register.php">注册</a></p>
				</dd>
			</dl>
		</form>
	</div>
</body>

</HTML>