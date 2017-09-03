
<HTML>
	<HEAD>
		<TITLE> Создание Таблица продаж </TITLE>
	</HEAD>

		<BODY>
				<?PHP

				print ("Привет!");
				$Host = "localhost";
				$User = "root";
				$Password = "";
				$DbName = "work";
				$TabName = "sale";
				$Link = mysql_connect ($Host, $User, $Password);
			
				$sql = "CREATE table $TabName (id INT UNSIGNED not NULL AUTO_INCREMENT primary key, Staff text, Product text, ProductColichestvo TINYINT UNSIGNED, Day DATE )";
				
				if (mysql_db_query ($DbName, $sql, $Link)) {
					print ("таблица продуктов $TabName в базе, $DbName, создана <BR>\n");
				} else {
					print ("ошибка создания таблица продуктов $TabName в базе, $DbName <BR>\n");
				}

				mysql_close ($Link);
				?>
		</BODY>
</HTML>
