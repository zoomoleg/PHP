<HTML>
	<HEAD>
		<TITLE> ввод данных в БД таблица продуктов </TITLE>
	</HEAD>

		<BODY>
				
				<?php
				// обработка данных и ввод в таблицу продуктов из формы  ввод данных в БД таблица продуктов 
				// удаление пробелов в начале и конце строк
				
				$ProductType1 = $_POST[ProductType];
				$ProductName1 = $_POST[ProductName];
				$ProductEd1 = $_POST[ProductEd];
				$ProductBall1 =$_POST[ProductBall];
				
				
				// установка переменных для доступа к серверу sql базе данных и таблице
				
				$Host = "localhost";
				$User = "root";
				$Password = "POST_graduate";
				$DbName = "work";
				$TabName = "ProductBall";
				$Link = mysql_connect ($Host, $User, $Password);
				$sql1 = "SET NAMES 'UTF8'";
				mysql_query ($sql1, $Link);
				$id = 0;
				print ("продукт $ProductType <BR>");
$sql = "INSERT INTO $TabName (ProductType, ProductName, ProductEd, ProductBall) values ('$ProductType1', '$ProductName1', '$ProductEd1', '$ProductBall1')";
				
				print ("запрос записи в таблицу $TabName <BR> $sql<P>\n");
				
				if (mysql_db_query ($DbName, $sql, $Link)) { print ("запрос успешный <BR>\n");}
				else {print ("запрос отклонён <BR>\n "); echo mysql_error ();}
				mysql_close ($Link);
				
				?>
		</BODY>
</HTML>
