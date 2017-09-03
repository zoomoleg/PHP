
<?PHP
session_start ();
if   (   !isset($_SESSION["user_id"]) OR (!isset($_SESSION['user_staffwork']) ) OR ($_SESSION['user_staffwork']) !=2  ) { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}

require_once 'mysql.php';		
				
				$plan_colnew = $_POST["plan_colnew"]; // вставить удаление пробелов и проверку введенных только цифр 
				$plan_colold = $_POST["plan_colold"];

if (isset ($plan_colnew)) {
	 // надо проверить есть значение в ячейке   

		foreach ($plan_colnew as $product=>$products) {

		foreach ($products as $office=>$colichestvo) {	
			
				if ($plan_colnew[$product][$office] != $plan_colold[$product][$office]) {
$sql = "SELECT * FROM $TabNamePlan WHERE `plan_id_product`=\"$product\" AND `plan_id_office`=\"$office\" AND `plan_value` IS NOT NULL";
				$result = mysql_query($sql);
		
				if (($colichestvo=="") OR ($colichestvo=="0")) {
					$sql="DELETE FROM $TabNamePlan WHERE `plan_id_product`=\"$product\" AND `plan_id_office`=\"$office\"";
									//	echo "<p>$sql</p>";
					$result = mysql_query($sql) OR die ("ошибка обновления данных  " . mysql_error());
					header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
					}
				
				// если значение есть то его требуется обновить если нет то ВСТАВИТЬ новую строку в таблицу
		elseif (mysql_num_rows($result)>0)  {
$sql="UPDATE $TabNamePlan SET `plan_value`=\"$colichestvo\" WHERE `plan_id_product`= \"$product\" AND `plan_id_office`= \"$office\"";
				//	echo "<p>$sql</p>";
					$result = mysql_query($sql) OR die ("ошибка обновления данных  " . mysql_error());
					//переадресация обратно на страницу
					header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
										 } else { 

$sql="INSERT INTO $TabNamePlan (`plan_id_product`,`plan_id_office`,`plan_value`) VALUES (\"$product\",\"$office\",\"$colichestvo\")";
				//	echo "<p>$sql</p>";
					$result = mysql_query($sql) OR die ("ошибка добавления данных  " . mysql_error());
					//переадресация обратно на страницу
					header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
									
					}//else
				
			}	// if
		}//if
	}	
} else // {header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");};



mysql_close ($Link)

?>
