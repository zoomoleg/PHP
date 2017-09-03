<?PHP
session_start ();
if (!isset($_SESSION["user_id"]) OR (!isset($_SESSION['user_staffwork'])) OR ($_SESSION['user_staffwork']) !=2 ) { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}
require_once 'mysql.php';



$user_colnew = $_POST["user_colnew"]; // вставить удаление пробелов и проверку введенных только цифр 
$user_colold = $_POST["user_colold"];


var_dump ($user_colnew);

if ( (isset ($user_colnew)) AND ($user_colnew != $user_colold) ) {
	foreach ($user_colnew as $user=>$office) {	

												$sql="UPDATE $TabName SET `staff_office_id`=\"$office\" WHERE `id`= \"$user\"";
												echo "<p>$sql</p>";
												$result = mysql_query($sql) OR die ("ошибка обновления данных  " . mysql_error());
												//переадресация обратно на страницу
													
		}	// foreach
					//	header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");
};//if
unset ($user_colnew);
unset ($_POST["user_colnew"]);
unset ($user_colold);
unset ($_POST["user_colold"]);

mysql_close ($Link)

?>
