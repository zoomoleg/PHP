<HTML>
	<HEAD>
		<TITLE> Создание Таблица продуктов </TITLE>
	</HEAD>

		<BODY>
				<?PHP

				print ("Привет!");
				$Host = "localhost";
				$User = "root";
				$Password = "";
				$DbName = "work";
				$TabName = "ProductBall";
				$Link = mysql_connect ($Host, $User, $Password);
			
				$sql = "CREATE table $TabName (id INT UNSIGNED not NULL AUTO_INCREMENT primary key, ProductType text, ProductName text, ProductEd text, ProductBall float(5,2))";
				
				if (mysql_db_query ($DbName, $sql, $Link)) {
					print ("таблица продуктов $TabName в базе, $DbName, создана <BR>\n");
				} else {
					print ("ошибка создания таблица продуктов $TabName в базе, $DbName <BR>\n");
				}

				mysql_close ($Link);
				?>
		</BODY>
</HTML>
