<HTML>
	<HEAD>
		<TITLE> Таблица сравнения </TITLE>
	</HEAD>

		<BODY>
				<?PHP

				print ("Привет!");
				$Host = "localhost";
				$User = "root";
				$Password = "POST_graduate";
				$DbName = "work";
				
				$Link = mysql_connect ($Host, $User, $Password);

				$sql = "CREATE DATABASE $DbName";
				
				if (mysql_query ($sql, $Link)) {
					print ("база данных, $DbName, создана <BR>\n");
				} else {
					print ("ошибка создания бызы данных $DbName <BR>\n");
				}

				mysql_close ($Link);
				?>
		</BODY>
</HTML>
