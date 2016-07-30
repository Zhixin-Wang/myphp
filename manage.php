<!DOCTYPE HTML>
<HTML>

<head>
  <TITLE>王志鑫大帅比的主页</TITLE>
  <link rel="stylesheet" type="text/css" href="mystyle.css" />
  <?php
    include 'manage_p.php';
    session_start();
    $user = $_SESSION['user'];
    $m = new manage($user);
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


  <div class="main_a">
  <div class="head_infor">
        <p style="margin-top: 0px;">网 站 信  管 理</p>
  </div>
      <div class="left_art" >
      <ul>
        <li id="m_bottom"><a href="?act=admin">管理员申请审核</a></li>
        <li id="m_bottom"><a href="?act=">用户管理</a></li>
      </ul>
      </div>
      <div class="right_art">
          <?php
          if (count($_GET) == 0) {
            $_GET['act']="admin";
          }
            switch ($_GET['act'])
            {
              case 'admin':
                 $m -> show_admin();
              break;
              default:
              echo "do not OK;";
            }
        ?>
      </div>
  </div>


  <div class="foot">
    Made by Zhixin Wang.
  </div>
</body>

</HTML>