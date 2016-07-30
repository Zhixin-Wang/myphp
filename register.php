  <?php
  // 定义变量并设置为空值
  $nameErr = $passwordErr = $emailErr = $genderErr = "";

  if (count($_POST) != 0) {
    if (exit_user($_POST['name'])) {
       $nameErr = "姓名重复";
    }
     elseif (empty($_POST["name"])) {
       $nameErr = "姓名是必填的";
     }
     elseif (empty($_POST["password"])) {
       $passwordErr = "密码是必填的";
     }
     elseif (empty($_POST["email"])) {
       $emailErr = "电邮是必填的";
     }
     elseif (empty($_POST["gender"])) {
       $genderErr = "性别是必选的";
     }
     else{
      save_np($_POST["name"],crypt($_POST["password"],"salt"),$_POST["gender"],$_POST["email"],$_POST["comment"]);
     }
   }

  function exit_user($user)
  {
    $datebese = @mysql_connect('localhost','wzx','123456');

    $result = mysql_select_db('db_wzx',$datebese);
    @$sql = "SELECT * FROM `user` WHERE `name` LIKE '$user'";
    $res = mysql_query($sql);
    $row = mysql_fetch_row($res);
    if ($row == 0) {
      return 0;
    }
    else{
      return 1;
    }
  }

  function save_np($n,$p,$g,$m,$c)
  {
    $datebese = @mysql_connect('localhost','wzx','123456');
    $result = mysql_select_db('db_wzx',$datebese);
    $query = "INSERT INTO `user` (`id`, `name`, `password`, `gender`, `email`, `comment`, `administrator`) VALUES (NULL, '$n', '$p', '$g', '$m', '$c', 'N')";
    mysql_query($query);
    mysql_close($datebese);
    echo "<SCRIPT>window.location = \"login.php\"; </SCRIPT>";
  }

  ?>



<!DOCTYPE html>
<html>
<head>
    <TITLE>王志鑫的主页的注册</TITLE>
    <link rel="stylesheet" type="text/css" href="mystyle.css" />
</head>
<body>
  <div class="reg">
  <h2>用户注册：</h2>
  <p><span class="error_reg" >* 必填的字段</span></p>
  <form method="post" action="register.php">
     姓名：<input type="text" name="name">
     <span class="error_reg">* <?php echo $nameErr;?></span>
     <br><br>
     密码：<input type="text" name="password">
     <span class="error_reg">* <?php echo $passwordErr;?></span>
     <br><br>
     性别：
     <input type="radio" name="gender" value="female">女性
     <input type="radio" name="gender" value="male">男性
     <span class="error_reg">* <?php echo $genderErr;?></span>
     <br><br>
     电邮：<input type="text" name="email">
     <span class="error_reg">* <?php echo $emailErr;?></span>
     <br><br>
     简介：<textarea name="comment"class="input" rows="5" cols="40"></textarea>
     <br><br>
     <input type="submit" name="submit" value="提交">
     <br><br>
     <a href="login.php">返回登陆界面</a>
  </form>
  </div>
</body>
</html>