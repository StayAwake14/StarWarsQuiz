<?php
	session_start();
	
	if ((!isset($_SESSION['zalogowanie'])) && (!$_SESSION['zalogowanie']==true))
	{
		header('Location: login.php');
		exit();
		
	}
?>

<!DOCTYPE HTML>
<HTML lang="en">
	<HEAD>
		<font face="Verdana" size="5" color="white">
		<link rel="stylesheet" href="panel.css" type="text/css">
	</HEAD>
	
	<BODY>
	<?php
	
	echo "<center><h1>Welcome to the <font color='red'>".$_SESSION['login']."</font> panel.</h1></center>";
	
	?>
	<ul>
		<a href="addq.php"><li>Add a question</li></a>
		<a href="editq.php"><li>Edit a question</li></a>
		<a href="logout.php"><li>Logout</li></a>
	</ul>
	
	</BODY>
</HTML>
	