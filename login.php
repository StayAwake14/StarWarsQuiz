<?php

	session_start();
	
	if ((isset($_SESSION['zalogowanie'])) && ($_SESSION['zalogowanie']==true))
	{
		header('Location: panel.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<HTML lang="en">
	<HEAD>
		<font face="Verdana" size="5" color="white">
		<link rel="stylesheet" href="panel.css" type="text/css">
	</HEAD>
	
	<BODY bgcolor="black">
	<center>
	<br/><br/><br/><img src="graphics/logo.png"><br/><br/><br/><br/>
		<form action="login.php" method="POST">
			Login: <input type="text" name="username">
			Password: <input type="password" name="pwd">
			<input type="submit" value="Login">
		</form>
		</center>
	</BODY>
	
	
	
</HTML>


<?php	
	if ((isset($_POST['username'])) || (isset($_POST['pwd'])))
	{
		
	
	include_once "connect2.php";
	
	$connect = @new mysqli($host,$db_user,$db_password,$db_name);
	
	if($connect->connect_errno!=0)
	{
		echo "Something went wrong!". $connect->connect_errno;
	}
	else
	{
		
		$login = $_POST['username'];
		$password = md5($_POST['pwd']);
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
		
		$download_sql = "SELECT * FROM users WHERE login='$login' AND password='$password'";
		
		if($end = @$connect->query($download_sql))
		{
			
			$count_users = $end->num_rows;

			if($count_users>0)
			{
				$_SESSION['zalogowanie']=true;
				
				$row = $end->fetch_assoc();
				$_SESSION['login'] = $row['login'];
				$_SESSION['pass'] = $row['password'];

				unset($_SESSION['blad']);
				$end->free_result();
				
				header('Location: panel.php'); 
			}
			else
			{
				$_SESSION['blad'] = '<span style="color: red;">Nieprawid³owy login lub has³o !</span>';
				header('Location: login.php');   
			}
		}
		$connect->close();
	}
}

?>