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
		<font face="Verdana" size="3" color="white">
		<link rel="stylesheet" href="panel.css" type="text/css">
	</HEAD>

	<BODY style="overflow: scroll;overflow-x:hidden;">
	
	<center><table border="1" cellspacing="10" cellpadding="2">
	<tr>
		<th>ID</th>
		<th>Question</th>
		<th>Answer1</th>
		<th>Answer2</th>
		<th>Answer3</th>
		<th>Correct_Answer</th>
	</tr>
	
	<?php
	echo "<center><h1>Here you are all questions:</h1></center>";
	
	require_once "connect.php";
	
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);

	if($connect->connect_errno!=0)
	{
		echo "Error: ".$connect->connect_errno;
		
	}
	else
	{
		$sql = "SELECT * FROM Star_Wars";
		
		if($end = @$connect->query($sql))
		{
			$count = $end->num_rows;
			for($i=0;$i<$count;$i++){
			$row = $end->fetch_assoc();
			$id = $row['id'];
			$question = $row['content'];
			$a1 = $row['answer1'];
			$a2 = $row['answer2'];
			$a3 = $row['answer3'];
			$at = $row['Correct_answer'];
			
			//echo $id."<br/>";
			echo "<tr>
			<td><font color=\"orange\"><center>$id</center></font></td>
			<td><font color=\"#8144D6\"><center>$question</center></font></td>
			<td><font color=\"#D9005B\"><center>$a1</center></font></td>
			<td><font color=\"#0A64A4\"><center>$a2</center></font></td>
			<td><font color=\"#03899C\"><center>$a3</center></font></td>
			<td><font color=\"#48DD00\"><center>$at</center></font></td>
			<tr>";
			}
		}
	}
		
	?>
		
	</table>
	<br/><br/>
	<h1>Which question do you want edit?<h1/>
	<form action="editq2.php" method="POST">
	<br/>Write question's ID<br/><input type="text" name="id">
	<br/><input type="submit" value="Send">
	<input type="submit" name="back2" value="Back"> 
	</form>
	
	
	</center>
	</BODY>

</HTML>