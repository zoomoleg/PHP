<HTML>
	<HEAD>
		<TITLE> Создание Таблица сотрудник-пароль </TITLE>
	</HEAD>

		<BODY>
				<?PHP

				print ("Привет!");
				$Host = "localhost";
				$User = "root";
				$Password = "";
				$DbName = "work";
				$TabName = "staff";
				$Link = mysql_connect ($Host, $User, $Password);
			
				$sql = "CREATE table $TabName (id INT UNSIGNED not NULL AUTO_INCREMENT primary key, staffName text, staffFamiliya text, staffLogin text, staffPassword text, staffWork tinyint UNSIGNED )";
				
				if (mysql_db_query ($DbName, $sql, $Link)) {
					print ("таблица сотрудников $TabName в базе, $DbName, создана <BR>\n");
				} else {
					print ("ошибка создания таблицы сотрудников $TabName в базе, $DbName <BR>\n");
				}

				mysql_close ($Link);
				?>
		</BODY>
</HTML>
