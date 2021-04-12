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
	echo "<form enctype=\"multipart/form-data\" action=\"addq.php\" method=\"POST\">
		<br/>Question: <input type=\"text\" name=\"question\">
		<br/><br/>Answer1: <input type=\"text\" name=\"answer1\">
		<br/><br/>Answer2: <input type=\"text\" name=\"answer2\">
		<br/><br/>Answer3: <input type=\"text\" name=\"answer3\">
		<br/><br/>Correct Answer: <input type=\"text\" name=\"correct\">
		<br/><br/>Choose your file: <input type=\"file\" name=\"plik\">
		<br/><br/><input type=\"submit\" name=\"add\" value=\"Add\"> 
		<input type=\"submit\" name=\"back\" value=\"Back\"> 
		</form>";
		?>
	</BODY>

</HTML>





<?php
if(isset($_POST['back']))
{
	header("Location: login.php");
}
if(isset($_POST['question'],$_POST['answer1'],$_POST['answer2'],$_POST['answer3'],$_POST['correct'],$_POST['add'])){

	require_once "connect.php";
	
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);

	if($connect->connect_errno!=0)
	{
		echo "Error: ".$connect->connect_errno;
		
	}
	else
	{
		$download_sql = "SELECT * FROM Star_Wars";
		
		if($end = @$connect->query($download_sql))
		{
		//WYSYL PLIKU//
			$q_count = $end->num_rows;
			$name=$q_count+1;

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
			
			
			$zapytanie = "INSERT INTO Star_Wars (id, content, answer1, answer2, answer3, Correct_answer) VALUES ('$name', \"$question\", \"$answer1\", \"$answer2\", \"$answer3\", \"$correct\")";

			@$connect ->query($zapytanie);
		}
	}
}
?>