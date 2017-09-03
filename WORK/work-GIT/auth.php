<HTML>
	<HEAD>
		<TITLE> страница авторизации и аутентификации пользователей </TITLE>
		<META charset="utf-8">
	</HEAD>

		<BODY>
				<?PHP
				if (isset($_GET['action']) OR $_GET['action']=="logout") {
					session_start ();
			     	session_destroy ();
			     	unset ($_SESSION['user_staffwork']);
			     	unset ($_SESSION['user_id']);
				header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
					exit;
				}
				
				session_start ();
				
				$Host = "localhost";
				$User = "root";
				$Password = "";
				$DbName = "work";
				$TabName = "staff";
				$Link = mysql_connect ($Host, $User, $Password);
				$sql1 = "SET NAMES 'UTF8'";
				mysql_query ($sql1, $Link);
				$id = 0;
	
				    $sqllog = "SELECT * FROM `staff` WHERE `staffLogin` = \"$_POST[login]\"";
					
				//	echo $sqllog;
					
					$resultt = mysql_db_query ($DbName, $sqllog, $Link); //подключение и запрос к таблице
					
					$result = mysql_fetch_row ($resultt);// разбор полученный данных (всего один ряд)
					
				//		print ("<BR>\n $result[4] запрос sql <BR>\n");
					
					
						if (($_POST['pass'] == $result[4]) AND ($result[5] != 0))  {$_SESSION['user_id'] = $result[0];$_SESSION['user_staffwork'] = $result[5];
					
				//			print ("<BR>\n имеется совпадение ");}
					
				//		else {
				//			print ("<BR>\n нет совпадений выход");
				//			print ("<BR>\n");
					
				//			echo $_POST['pass']." введённый пароль". "    из базы   "  .$result[4];
				//			print ("<BR>\n");
					
				//			print (" $_POST[login] введённый логин") ;
					
						};				
				//	print ("<BR>\n номер сессии пользователя $_SESSION[user_id]"); 
					
				
				//	print ("<BR>\n всё напечатано");
										
					header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
				
				?>
			
			<?PHP mysql_close ($Link); ?>
		</BODY>
</HTML>
