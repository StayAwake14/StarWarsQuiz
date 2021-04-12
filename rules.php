<!DOCTYPE HTML>
	<HTML lang="PL">
		
		<HEAD>
			<meta charset="utf-8"/>
			<font face="Verdana" size="5" color="white">
			<link rel="stylesheet" href="styles.css" type="text/css">
		</HEAD>
		
		<BODY>
			
				<Br><br><br>
				<div class='content'>
				<center><h1>Welcome to my mini Star Wars quiz! Let's check your knowledge!</h1></center>
				<hr>
				<center><h2>Rules of the quiz:</h2></center>
				<p> - The quiz consists of 10 randomly selected questions.<br>
				 - If you don't provide your name, you will be redirected to an error page.<br>
				 - The quiz database now consists of 44 questions but authorized people can add new ones.<br>
				 - You get 2 points for each correct answer.<br>
				 - Only one option is correct.<Br>
				 - You can't choose more than one option.<br>
				 - Your score will show up at the bottom of the page.<br>
				<center><h2>Have Fun! =) </h2></center></p><Br>
				 </div>
				<Br><Br><Br>
				<form action='start_quiz.php' method='post'>
				<center><h2>When you are ready, click the button!</h2><br><br></center>
				
				<input class='center' type='submit' name='randomize' value='Start!' style="width:200px; height:50px;">
				</form>
				<br><br>
			
		
			<div id="footer2">
				<p class='cp'>Mateusz Cichulski &copy //  <?php echo date("F j, Y, g:i a"); ?></p>
			</div>
		</BODY>
		
		<!-- SCM Music Player http://scmplayer.net -->
		<script type="text/javascript" src="http://scmplayer.net/script.js" 
		data-config="{'skin':'skins/black/skin.css','volume':50,'autoplay':true,'shuffle':true,'repeat':1,'placement':'top','showplaylist':false,'playlist':[{'title':'Star Wars - Imperial March','url':'https://www.youtube.com/watch?v=-bzWSJG93P8'},{'title':'Star Wars - Anakin vs Obi-Wan','url':'https://www.youtube.com/watch?v=P1k5zo0w6N8'},{'title':'Star Wars - Across The Stars (Love Theme)','url':'https://www.youtube.com/watch?v=9nk_WHHTQtY'},{'title':'Star Wars - Leia%27s News / Light of the Force ','url':'https://www.youtube.com/watch?v=nDMLbk4nMm4'}]}" ></script>
		<!-- SCM Music Player script end -->
		
	</HTML>
	