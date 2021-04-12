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
			<font face="Verdana" size="4" color="white">
		<link rel="stylesheet" href="panel.css" type="text/css">
	</HEAD>

	<BODY>
	<?php
		if(isset($_POST['id']))
		{
			$id=$_POST['id'];
			
			echo "<center><h1>You selected question with id=$id <br/><br/>";
			
			require_once "connect.php";
			
			$connect = @new mysqli($host, $db_user, $db_password, $db_name);

			if($connect->connect_errno!=0)
			{
				echo "Error: ".$connect->connect_errno;
				
			}
			else
			{
				$sql = "SELECT * FROM Star_Wars WHERE id=$id";
				
				if($end = @$connect->query($sql))
				{
					$row = $end->fetch_assoc();
					$id = $row['id'];
					$question = $row['content'];
					$a1 = $row['answer1'];
					$a2 = $row['answer2'];
					$a3 = $row['answer3'];
					$at = $row['Correct_answer'];
					echo "<table border='1' cellspacing='2' cellpadding='5'>
					<tr>
						<th><font size='5'><center>ID</font></center></th>
						<th><font size='5'><center>Question</center></font></th>
						<th><font size='5'><center>Answer1</center></font></th>
						<th><font size='5'><center>Answer2</center></font></th>
						<th><font size='5'><center>Answer3</center></font></th>
						<th><font size='5'><center>Correct_Answer</center></font></th>
					</tr>
					<tr>
					<td><font color=\"orange\" size='4'><center>$id</center></font></td>
					<td><font color=\"#8144D6\" size='4'><center>$question</center></font></td>
					<td><font color=\"#D9005B\" size='4'><center>$a1</center></font></td>
					<td><font color=\"#0A64A4\" size='4'><center>$a2</center></font></td>
					<td><font color=\"#03899C\" size='4'><center>$a3</center></font></td>
					<td><font color=\"#48DD00\" size='4'><center>$at</center></font></td>
					<tr>
					</table>
					<br/>
					<h3>Here you can download the image if you don't have it<h3/>
					<a href='./graphics/$id.png' download>Click</a>";
					
				}
				
			}
			
			echo "</center>";
			echo "<form enctype=\"multipart/form-data\" action=\"editq2.php\" method=\"POST\">
				<br/>Question: <input type=\"text\" name=\"question\">
				<br/><br/>Answer1: <input type=\"text\" name=\"answer1\">
				<br/><br/>Answer2: <input type=\"text\" name=\"answer2\">
				<br/><br/>Answer3: <input type=\"text\" name=\"answer3\">
				<br/><br/>Correct Answer: <input type=\"text\" name=\"correct\">
				<br/><br/>Choose your file: <input type=\"file\" name=\"plik\">
				<br/><br/><input type=\"submit\" name=\"add\" value=\"Change\">
				<input type=\"submit\" name=\"back\" value=\"Back\"> 
				<input type=\"submit\" name=\"panel\" value=\"Panel\"> 
				<input type='hidden' name='id' value='$id'>
				</form>";
		}
	?>
	</BODY>

</HTML>
<?php
if(isset($_POST['back']))
{
	header("Location: editq.php");
}
if(isset($_POST['back2']))
{
	header("Location: panel.php");
}
if(isset($_POST['panel']))
{
	header("Location: panel.php");
}
?>




<?php
if(isset($_POST['question'],$_POST['answer1'],$_POST['answer2'],$_POST['answer3'],$_POST['correct'],$_POST['add'])){

	require_once "connect.php";
	
	$id = $_POST['id'];
	
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);

	if($connect->connect_errno!=0)
	{
		echo "Error: ".$connect->connect_errno;
		
	}
	else
	{
		$download_sql = "SELECT * FROM Star_Wars WHERE id=$id";
		
		if($end = @$connect->query($download_sql))
		{
		//WYSYL PLIKU//
			$name=$id;

			$file_tmp=$_FILES['plik']['tmp_name'];
			$file_name=$_FILES['plik']['name'];
			$file_size=$_FILES['plik']['size'];
			$file_type=$_FILES['plik']['type'];
			$location='./graphics/'.$name.".png";
			list($width, $height) = getimagesize($file_tmp);
			
			function resizeImage($filename, $newwidth, $newheight,$name)
			{
				list($width, $height) = getimagesize($filename);
				if($width > $height && $newheight < $height)
				{
					$newheight = 300;
				} 
				else if ($width < $height && $newwidth < $width) 
				{
					$width = $newwidth / ($height / $newheight);   
				} 
				else 
				{
					$newwidth = $width;
					$newheight = $height;
				}
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefrompng($filename);
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagepng($thumb, "./graphics/$name.png");
			}
			
			if(empty($_POST['question']) || empty($_POST['answer1']) || empty($_POST['answer2']) || empty($_POST['answer3']) || empty($_POST['correct']))
			{
				echo "ERROR! You did not provide all values<br>";
				echo "Try Again !";
				break;
			}
			
			if($width<800 and $height<300)
			{
				echo "ERROR! You can only send files with resolution > 800x300<br>";
				echo "Try Again !";
				break;
			}
			
			if($file_type=="image/png")
			{
				$myimage = resizeImage("$file_tmp", '800', '300', $name);
				move_uploaded_file($myimage,$location);
				rename("./graphics/$file_name", "./graphics/$name.png");
				echo "File ".$file_name." has been sent!";
			}
			
			else
			{
				echo "ERROR! You can only send files with type *.png<br>";
				echo "Try Again !";
				break;
			}
			
			// WYSYL PLIKU KONIEC //
			
			$question = $_POST["question"];
			$answer1 = $_POST['answer1'];
			$answer2 = $_POST['answer2'];
			$answer3 = $_POST['answer3'];
			$correct = $_POST['correct'];
			
			
			$zapytanie = "UPDATE Star_Wars SET id=$id, content=\"$question\", answer1=\"$answer1\", answer2=\"$answer2\", answer3=\"$answer3\", Correct_answer=\"$correct\" WHERE id=$id";

			@$connect ->query($zapytanie);
		}
	}
}
?>