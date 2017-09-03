
<?PHP
session_start ();
if (!isset($_SESSION["user_id"])) { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}
//if ($_POST["prod_colnew"]=='') { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}
require_once 'mysql.php';		
		
				$today_year = date ('o');
				$today_month = date ('m');
				$today = date ('j'); //текущий день без ведущего нуля
		
				
				$prod_colnew = $_POST["prod_colnew"]; // вставить удаление пробелов и проверку введенных только цифр 


				$prod_colold = $_POST["prod_colold"];
				
				$prod_comment = $_POST["prod_comment"]; //переменная для передачи пояснений по продукту
				

//var_dump($prod_colnew);
//echo "<BR>";
//var_dump($prod_colold);

$sql = "SELECT `staff_office_id` FROM $TabName WHERE `id`=\"$_SESSION[user_id]\"";
echo $sql;
$result = mysql_query ($sql) OR die ("ошибка обновления данных  " . mysql_error());
while ($row = mysql_fetch_row ($result)) {
													$staff_office_id = $row[0];
													}
 




if (isset ($prod_colnew)) {
	 // надо проверить есть значение в ячейке   
	

		foreach ($prod_colnew as $product=>$products) {

		foreach ($products as $day=>$colichestvo) {	


			$coment = $prod_comment[$product][$day]; // присвоение значения пояснения к продаже  привязка  продукт - день
			
			
				if ($prod_colnew[$product][$day] != $prod_colold[$product][$day]) {
$sql = "SELECT * FROM $TabNameSale WHERE `Staff`=\"$_SESSION[user_id]\" AND `Day`=\"$today_year-$today_month-$day\" AND `Product`=\"$product\" AND \"ProductColichestvo\" IS NOT NULL";
				$result = mysql_query($sql);
				
		if (($colichestvo=="") OR ($colichestvo=="0")) {
					$sql="DELETE FROM $TabNameSale WHERE `Staff`=\"$_SESSION[user_id]\" AND `Day`=\"$today_year-$today_month-$day\" AND `Product`=\"$product\"";
			//							echo "<p>$sql</p>";
					$result = mysql_query($sql) OR die ("ошибка обновления данных  " . mysql_error());
					header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
					}
				
				// если значение есть то его требуется обновить если нет то ВСТАВИТЬ новую строку в таблицу
		elseif (mysql_num_rows($result)>0)  {
			$coment = $prod_comment[$product][$day];
$sql="UPDATE $TabNameSale SET `ProductColichestvo`=\"$colichestvo\",`sale_staff_office_id`=\"$staff_office_id\", `sale_comment`=\"$coment\" WHERE `Staff`= \"$_SESSION[user_id]\" AND `Day`= \"$today_year-$today_month-$day\" AND `Product`=\"$product\"";
			//		echo "<p>$sql</p>";
					$result = mysql_query($sql) OR die ("ошибка обновления данных  " . mysql_error());
					//переадресация обратно на страницу
					header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
										 } else { 

$sql="INSERT INTO $TabNameSale (`Staff`,`sale_staff_office_id`,`Product`,`ProductColichestvo`, `sale_comment`, `Day`) VALUES (\"$_SESSION[user_id]\",\"$staff_office_id\",\"$product\",\"$colichestvo\", \"$coment\", \"$today_year-$today_month-$day\")";
				//	echo "<p>$sql</p>";
					$result = mysql_query($sql) OR die ("ошибка добавления данных  " . mysql_error());
					//переадресация обратно на страницу
					header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
									
					}//else
				
			}	// if
		}//if
	}	
} else {header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");};



mysql_close ($Link)

?>
