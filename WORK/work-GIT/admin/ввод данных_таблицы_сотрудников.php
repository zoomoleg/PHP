<HTML>
	<HEAD>
		<TITLE> ввод данных в БД таблица сотрудников </TITLE>
	</HEAD>

		<BODY>
				
				<FORM ACTION ="<?php echo $_SERVER['PHP_SELF']; ?>" method=POST>
				
				staffName (имя)<input type = text name="staffName" size=20><BR>
				staffFamiliya (фамилия)<input type = text name="staffFamiliya" size=40><BR>
				staffLogin (логин)<input type = text name="staffLogin" size=10><BR>
				staffPassword (пароль)<input type = text name="staffPassword" size=5><BR>
				staffWork (признак работает ли) <input type = text name="staffWork" size=1><BR>

				<input type="submit" name="submit" Value="ВВОД!!!">
				<input type="reset" Value="очистить">
				</FORM>
				
				<?PHP
				$Host = "localhost";
				$User = "root";
				$Password = "";
				$DbName = "work";
				$TabName = "staff";
				$Link = mysql_connect ($Host, $User, $Password);
				$sql1 = "SET NAMES 'UTF8'";
				mysql_query ($sql1, $Link);
				$id = 0;
				
$sql = "INSERT INTO $TabName (staffName , staffFamiliya, staffLogin , staffPassword , staffWork) values ('$_POST[staffName]', '$_POST[staffFamiliya]', '$_POST[staffLogin]', '$_POST[staffPassword]', '$_POST[staffWork]')";
				
				print ("запрос записи в таблицу $TabName <BR> $sql<P>\n");
				
				if ($_POST[staffName]<>0) {
				if (mysql_db_query ($DbName, $sql, $Link)) { print ("запрос успешный <BR>\n");}
										}
				else {print ("запрос отклонён <BR>\n "); echo mysql_error ();}
				
				mysql_close ($Link);
				
				
				?>
		</BODY>
</HTML>
