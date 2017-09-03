<HTML>
<HEAD>
	<LINK rel = "stylesheet" href="style2.css">
	<META charset="utf-8">
</HEAD>
<BODY>


<input TYPE="button" VALUE="вернуться" ONCLICK="HomeButton()"> <script>
function HomeButton()
{
location.href="http://10.102.91.130/work/start.php";
}
</script>


<?PHP
session_start ();
if   (   !isset($_SESSION["user_id"]) OR (!isset($_SESSION['user_staffwork']) ) OR ($_SESSION['user_staffwork']) !=2  ) { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}

// присоединяемся к базе и устанавливаем переменные-имена базы данных
require_once 'mysql.php';
		
// переменные для определения текущего года и месяца
				$today_year = date ('o');
				$today_month = date ('m');
				$today = date ('j'); //текущий день без ведущего нуля
				$today_any_day="$today_year-$today_month";


	

echo "<FORM  action=\"update_BD_plan.php\" method=POST >";
// вставляем скрытое поле с указанием id текущего пользователя
echo "<input type=\"hidden\" name=\"user\" value=\"". $_SESSION[user_id] ."\">";

echo "<TABLE id=\"t1\" BORDER=1 WIDTH=\"100%\" CELLSPACING=2 CELLPADDING=2 ALIGN=CENTER>\n";
//$TabNamePlan = "plan";
//$TabNameOffice = "office";

$sql_plan = "SELECT * FROM $TabNamePlan"; //запрос плана по всем ОО
$result_plan = mysql_query($sql_plan);

$sql_office = "SELECT * FROM $TabNameOffice"; //запрос названий всех отделений
$result_office = mysql_query ($sql_office);

$sql_product = "SELECT * FROM $TabNameProductBall";// запрашиваем продукты с их id
$result_product = mysql_query($sql_product);


// заполняем таблицу по планам для отделений
///////////////////////////////////////////////////
$table_plan[0][0] = "НАЗВАНИЕ ПРОДУКТА";

	while ($row_product=mysql_fetch_array ($result_product)) {
		$product_id = $row_product['id']; // последнее это значение поля
		$product_name = $row_product['ProductName']; // имя продукта

		$table_plan[$product_id][0] = $product_name;


		while ($row_office = mysql_fetch_array ($result_office)) {
			$office_id = $row_office['office_id'];
			$office_name = $row_office['office_name'];
	

			$table_plan[0][$office_id] = $office_name;
			
			$table_plan[$product_id][$office_id] = "0";
//вносится ноль для продута если нет плана по офису в таблице планов

			while ($row_plan = mysql_fetch_array ($result_plan)) {
				if ( ($row_plan['plan_id_product'] == $product_id) AND ($row_plan['plan_id_office'] == $office_id) ) {
					$table_plan[$product_id][$office_id] = $row_plan['plan_value'];
				}; // if 
			}; // while
		mysql_data_seek ($result_plan, 0); //возвращаем указатель массива ид пользователей на 0 положение для повторной обработки

		} // while
	mysql_data_seek ($result_office, 0); //возвращаем указатель массива ид пользователей на 0 положение для повторной обработки

	} // while
///////////////////////////////////////////////////


//выводим таблицу планов для заполнения

//var_dump($table_plan);
	foreach ($table_plan as $product_id_1=>$cell) { // $table[$product_id][$day]
		echo "<TD>$product_id_1</TD>";
			foreach ($cell as $office_id_1=>$plan_value_1) {
		//		echo "<TD>$office_id_1</TD>";
				if ($plan_value_1 == "") {$plan_value_1 = 1;};	
				echo "<TD>$plan_value_1 <BR>";
					if (($product_id_1!=0) AND ($office_id_1!=0)) {
				echo "<input type=\"hidden\" name=\"plan_colold[$product_id_1][$office_id_1]\" value=\"$plan_value_1\">";
				echo "<input type = \"TEXT\" name = \"plan_colnew[$product_id_1][$office_id_1]\" value = \"$plan_value_1\" size = \"8\" pattern = \"[0-9]{0,12}\">";   
				echo "</TD>";};
			} // foreach
echo "</TR>";			
	} // foreach
echo "</TR>";
echo "</TABLE>";
echo "<input type=\"submit\" name=\"submit\" Value=\"применить изменения\">";
echo "<input type=\"reset\" Value=\"очистить\">";
echo "</FORM>";
?>
</BODY>
</HTML>
