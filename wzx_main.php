<!DOCTYPE HTML>
<HTML>
<?php
	include 'messageboard.php';
?>
<head>
	<TITLE>王志鑫大帅比的主页</TITLE>
	<link rel="stylesheet" type="text/css" href="mystyle.css" />
	<?php
		$m = new Messageboard();
		session_start();
		$user = $_SESSION['user'];
	?>
</head>

<body>
	<div class="top">
	<div class="topadd">
		<div class="topmy">
		<h1 style="margin-top: 12px;margin-bottom: 12px;">王志鑫的主页</h1>
		</div>
		<div class="topuser_pic">
   		 <img src="show_ppp.php?user=<?php echo $user['name'];?>" height="60px" >
  		</div>
		<div class="topuser">
		<?php
			echo $user['name'];
			if ($user['administrator'] == 'Y') {
				echo "     ";
      			  echo "<a href=\"manage.php\">网站管理</a>";
    		}
		?>
		<a href="user_infor.php">        我的信息管理</a>
		<a href="login.php">        退出登录</a>
		</div>
	</div>
	</div>
	<div class="head">
	<a href="wzx_main.php">主页</a>
	<a href="article.php">日志</a>
	</div>


	<div class="main">
		<div>
			<div class="left" >
				<img style="float: left" src="img/main.jpg" width="1000px">
			</div>
			<div class="right">
				<div style="margin-bottom: 50px";>
				<?php
				 $m -> show_all();
				?>
				</div>
				<?php
				$m -> show_form();
				?>
			</div>
		</div>
	</div>


	<div class="foot">
		Made by Zhixin Wang.
	</div>
</body>

</HTML>