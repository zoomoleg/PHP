<HTML>
	<HEAD>
		<TITLE> смена пароля  </TITLE>
		<META charset="utf-8">
	</HEAD>

		<BODY>
			<?PHP
		
	session_start ();
if (!isset($_SESSION["user_id"])) { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}

// присоединяемся к базе и устанавливаем переменные-имена базы данных
require_once 'mysql.php';
		//		$TabName = "staff";
		//		$TabNameProductBall = "ProductBall";
		//		$TabNameSale = "sale";

// переменные для определения текущего года и месяца
				$today_year = date ('o');
				$today_month = date ('m');
				$today = date ('j'); //текущий день без ведущего нуля
				$today_any_day="$today_year-$today_month";
if ((isset($_POST["pass"])) AND ($_POST["pass"]!='') ) {
$sql_pass = "UPDATE $TabName SET `staffPassword`=\"$_POST[pass]\" WHERE `id`= \"$_SESSION[user_id]\"";
//echo $sql_pass;
$result_pass = mysql_query ($sql_pass) OR die("Unable to connect to MySQL");
unset ($_SESSION["user_id"]);
header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
}
		
	?>
	</BODY>
			
