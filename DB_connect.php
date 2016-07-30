<?php
class DB
{
	var $datebese = null;
	function __construct()
	{
		header('Content-type:text/html;charset=utf-8');
		$this->datebese = @mysql_connect('localhost','wzx','123456');
		// if($this->datebese)
		// {echo "DB connect";}
		// else
		// {echo "DB connect fail";}
		$result = mysql_select_db('db_wzx',$this->datebese);
		// if($result)
		// {echo "DB select";}
		// else
		// {echo "DB select fail";}
		mysql_query("set names utf8"); //设置编码
	}

	function __desturct()
	{
		mysql_close($this->datebese);
	}
}
?>
