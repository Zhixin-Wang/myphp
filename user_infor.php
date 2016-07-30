<!DOCTYPE HTML>
<HTML>

<head>
  <TITLE>我的信息管理</TITLE>
  <link rel="stylesheet" type="text/css" href="mystyle.css" />
  <?php
    include 'user_infor_p.php';
    $infor = new user_infor($user);
    $infor -> exit_user();
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


  <div class="main_infor">
    <div class="head_infor">
      <p style="margin-top: 0px;">个人资料</p>
    </div>
    <div>
      <div class="left_infor" >
      <img src="show_ppp.php?user=<?php echo $user['name'];?>" width="200" >
      <hr />
      <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="user_pic" size="30"></input>
        <input type="submit" value="修改头像" name="go_pic"></input>
      </form>
      </div>
      <div class="right_infor">
      <?php $infor -> show_s($user); ?>
      </div>
    </div>
  </div>


  <div class="foot">
    Made by Zhixin Wang.
  </div>
</body>

</HTML>