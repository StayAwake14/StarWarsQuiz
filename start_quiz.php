<!DOCTYPE HTML>
<HTML lang='en'>
	<HEAD>
		<link rel="stylesheet" href="styles.css" type="text/css">
		<link rel="stylesheet" href="styles2.css" type="text/css">
		<font face="Verdana" size="5" color="white">
	</HEAD>


<?php
if(isset($_POST['randomize'])){
	
	include_once "connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
		
	if($connect->connect_errno!=0)
	{
		echo "Error: ". $connect->connect_errno;
			
	}
	
	
	// $sql = "SELECT * FROM Star_Wars WHERE id='$liczba'";
	
	// if ($end = @$connect->query($sql))
	//	{
			
	//		$row = $end->fetch_assoc();
	//		$question = $row['content'];
	//		$zmienna2 = $row['points'];
	//		echo $zmienna;
	//	}
	
	echo "<center><h2>Choose your answers!</h2><br/>";
										//FORMULARZ//
	echo "<form method='POST' action='start_quiz.php'>";
	echo "What's your name? <input type='text' name='nickname' size='31'></center><br/><br/>";

	$download_sql = "SELECT * FROM Star_Wars";
		
	if($end = @$connect->query($download_sql))
	{
		$q_count = $end->num_rows;
		$ile_pytan = $q_count; //z ilu pytan losujemy?
		$ile_wylosowac = 10; //ile pytan wylosowac?
		$ile_juz_wylosowano=0; //zmienna pomocnicza
		$answer = 0;
	}
	
	for ($i=0; $i<$ile_wylosowac; $i++)
	{
		
		do
			{
				$liczba=rand(1,$ile_pytan); //losowanie w PHP
				$losowanie_ok=true;
				
									 
				for ($j=1; $j<=$ile_juz_wylosowano; $j++)
				{
				//czy liczba nie zostala juz wczesniej wylosowana?
					if ($liczba==$wylosowane[$j])
					{ 
						$losowanie_ok=false;
					}
				}
									 
				if ($losowanie_ok==true)
				{
				//mamy unikatowa liczbe, zapiszmy ja do tablicy
					$ile_juz_wylosowano++;
					$wylosowane[$ile_juz_wylosowano]=$liczba;
					$lottery=$wylosowane[$ile_juz_wylosowano];
					$sql = "SELECT * FROM Star_Wars WHERE id=$lottery";

					
					if ($end = @$connect->query($sql))
					{
						$download = $end->fetch_assoc();
						$question = $download['content'];
						$answer1 = $download['answer1'];
						$answer2 = $download['answer2'];
						$answer3 = $download['answer3'];
							
							echo "
							<div class='question' style='background-image:url(graphics/$wylosowane[$ile_juz_wylosowano].png);'><h1><font color='White'>$question</font></h1><br/><br/>
							<input type='radio' name='answer$answer' value=\"$answer1\"><a><b><i>$answer1</b></i></a><br/>
							<input type='radio' name='answer$answer' value=\"$answer2\"><a><b><i>$answer2</a></b></i><br/>
							<input type='radio' name='answer$answer' value=\"$answer3\"><a><b><i>$answer3</b></i></a><br/>
							</div><br/><br/>";
					}
				}
			}
		while($losowanie_ok!=true);
		$answer++;
	}
	
	foreach ($wylosowane as $liczby){
		echo "<input type='hidden' name='liczby[]' value='$liczby'>";
	}
						
	
	echo "<center><input class='troll' type='submit' name='score' value='Send' style='width:200px; height:50px;'></center><br/><br/>";
	echo "</form>";			
}

?>
	

<?php
if(isset($_POST['score'])){
	
	include_once "connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	$points=0;
	$name=$_POST['nickname'];
		
	if($connect->connect_errno!=0)
	{
		echo "Error: ". $connect->connect_errno;
	}
	
	echo "<center><h2>Answers:</h2><br/><br/></center>";
	
	for($i=0;$i<10;$i++)
	{
		$check_answer[$i] = $_POST["answer$i"];
		$Tab[$i]=$_POST['liczby'][$i];
		$sql = "SELECT * FROM Star_Wars WHERE id=$Tab[$i]";
		
		if(empty($name))
		{
			header("Location: error.php");
		}

		if(empty($check_answer[$i]))
		{
			header("Location: error.php");
		}
		
		if ($end = @$connect->query($sql))
		{
				$download = $end->fetch_assoc();
				$id=$download['id'];
				$question = $download['content'];
				$answer1 = $download['answer1'];
				$answer2 = $download['answer2'];
				$answer3 = $download['answer3'];
				$check = $download['Correct_answer'];
				
			if($check_answer[$i] == $check AND $check_answer[$i] == $answer1)
			{
					echo "<div class='question' style='background-image:url(graphics/$Tab[$i].png);'><h1><font color='White'>$question</font></h1><br/>";
					echo "<a class='correct'><center><b><i>$answer1</b></i></center><br/>
							<strike><center><b><i>$answer2</b></i></center><br/>
							<center><b><i>$answer3</center></strike></i></b></a>
							</div>
							<h3> Good Answer! :)</h3>";
							$points+=2;		
			}
			
			if($check_answer[$i] == $check AND $check_answer[$i] == $answer2)
			{	
					echo "<div class='question' style='background-image:url(graphics/$Tab[$i].png);'><h1><font color='White'>$question</font></h1><br/>";
					echo "<a class='correct'><center><b><i>$answer2</b></i></center><br/>
							<strike><center><b><i>$answer3</b></i></center><br/>
							<center><b><i>$answer1</center></strike></i></b></a>
							</div>
							<h3> Good Answer! :)</h3>";
							$points+=2;		
			}
			
			if($check_answer[$i] == $check AND $check_answer[$i] == $answer3)
			{
					echo "<div class='question' style='background-image:url(graphics/$Tab[$i].png);'><h1><font color='White'>$question</font></h1><br/>";
					echo "<a class='correct'><center><b><i>$answer3</b></i></center><br/>
							<strike><center><b><i>$answer2</b></i></center><br/>
							<center><b><i>$answer1</center></strike></i></b></a>
							</div>
							<h3> Good Answer! :)</h3>";
							$points+=2;	
			}
			
			if($check_answer[$i] != $check)
			{
				if ($check == $answer1)
				{
					echo "<div class='question' style='background-image:url(graphics/$Tab[$i].png);'><h1><font color='White'>$question</font></h1><br/>";
					echo "<a><center><b><i>$check</b></i></center><br/>
							<strike><center><b><i>$answer2</b></i></center><br/>
							<center><b><i>$answer3</center></strike></i></b></a>
							</div>
							<h4> Your answer: $check_answer[$i]</h4>";

				}
				
				if ($check == $answer2)
				{
					echo "<div class='question' style='background-image:url(graphics/$Tab[$i].png);'><h1><font color='White'>$question</font></h1><br/>";
					echo "<a><center><b><i>$check</b></i></center><br/>
							<strike><center><b><i>$answer1</b></i></center><br/>
							<center><b><i>$answer3</center></strike></i></b></a>
							</div>
							<h4> Your answer: $check_answer[$i]</h4>";

				}
				
				if ($check == $answer3)
				{
					echo "<div class='question' style='background-image:url(graphics/$Tab[$i].png);'><h1><font color='White'>$question</font></h1><br/>";
					echo "<a><center><b><i>$check</b></i></center><br/>
							<strike><center><b><i>$answer2</b></i></center><br/>
							<center><b><i>$answer1</center></strike></i></b></a>
							</div>
							<h4> Your answer: $check_answer[$i]</h4>";
				}
			}
		}
	}
	
	if($points>10)
	{
		echo "<center><h2>Congratulations $name! You gained $points/20!<h2>";
		echo "<br/>";
		echo "</br></center>";
		echo "<a href='lightside.php'><h1>CLick to see your force!</h1>";
		echo "<br/><br/><br/><br/><center><img src='graphics/yoda.gif'></a></center>";
	}
	else
	{
		echo "<center><h2>You're coming with the Dark Side of the force $name!<br/>You gained only $points / 20! You need to clear your mind!<h2>";
		echo "<br/>";
		echo "<br/></center>";
		echo "<a href='darkside.php'><h4>Click to see your force!</h4>";
		echo "<br/><br/><br/><br/><center><img src='graphics/r2d2.gif'></a></center>";
	}
echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/>";
}
?>

	<div id="footer">
				<p class='cp'>Mateusz Cichulski &copy //  <?php echo date("F j, Y, g:i a"); ?></p>
			</div>

</HTML>