<?PHP
session_start ();
if (!isset($_SESSION["user_id"]) OR (!isset($_SESSION['user_staffwork'])) OR ($_SESSION['user_staffwork']) !=2 ) { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}
require_once 'mysql.php';



echo "<FORM  action=\"user_office_update_BD.php\" method=POST >";
// вставляем скрытое поле с указанием id текущего пользователя
echo "<input type=\"hidden\" name=\"user\" value=\"". $_SESSION[user_id] ."\">";

echo "<TABLE id=\"t1\" BORDER=1 WIDTH=\"100%\" CELLSPACING=2 CELLPADDING=2 ALIGN=CENTER>\n";


$sql_user = "SELECT * FROM $TabName WHERE staffWork = 1"; //выбираем только работающий и не администратора у него значение 2
$result_user = mysql_query ($sql_user);

$sql_office = "SELECT * FROM $TabNameOffice"; //запрос названий всех отделений
$result_office = mysql_query ($sql_office);


// заполняем таблицу по принадлежности пользователей отделениям
///////////////////////////////////////////////////
$table_user[0][0] = "пользователь";
$Prohod = True;

	while ($row_user=mysql_fetch_array ($result_user)) {
		$user_id = $row_user['id']; // последнее это значение поля
		$user_name = $row_user['staffFamiliya']; // имя пользователя
		$user_office = $row_user['staff_office_id']; //принадлежность пользователя к офису

		$table_user[$user_id][0] = $user_name;
		$table_office_user[$user_id] = $user_office; //таблица ползователи и значения офиса
													// дальше будет сравниваться что бы переключатель вывести на текущее значение
		while ($row_office = mysql_fetch_array ($result_office)) {
			$office_id = $row_office['office_id'];
			$office_name = $row_office['office_name'];
	

			$table_user[0][$office_id] = $office_name;
			$table_user[$user_id][$office_id] = $office_id;
			}; // while
		mysql_data_seek ($result_office, 0); //возвращаем указатель массива ид пользователей на 0 положение для повторной обработки
						
		} // while

///////////////////////////////////////////////////


//выводим таблицу пользователи - офис для заполнения
$Prohod = True;
//var_dump($table_user);
	foreach ($table_user as $user=>$cell) { // $table[$product_id][$day]
		echo "<TD>$user</TD>";
			foreach ($cell as $office=>$value) {
			//		echo "<TD>$value<BR>";
				if ( ($Prohod == True) )  { echo "<TD>$value<BR>";  }//нужно для вывода первой строки с названиями офиса
					
				if (($office <= 0) AND ($Prohod == False)) {echo "<TD>$value<BR></TD>";} //вывод для всех если id офиса <1 то есть только имено выводит
							
			if (($user != 0) AND ($office != 0)) { //выводит для всех кроме нулевой строки
					echo "<TD>";						
					echo "<input type=\"hidden\" name=\"user_colold[$user]\" value=\"$value\">";
					
						if ($table_office_user[$user] == $office) {echo "<input type = \"RADIO\" name = \"user_colnew[$user]\" value = \"$value\" checked>";   }
							else {
								echo "<input type = \"RADIO\" name = \"user_colnew[$user]\" value = \"$value\">";   
										};
						echo "</TD>";}; 
			} // foreach
echo "</TR>";	$Prohod = False;		
	}; // foreach

echo "</TR>";
echo "</TABLE>";
echo "<input type=\"submit\" name=\"submit\" Value=\"применить изменения\">";
echo "<input type=\"reset\" Value=\"очистить\">";
echo "</FORM>";
