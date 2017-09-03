<HTML>
<HEAD>
	<TITLE> таблица продаж  </TITLE>
	<LINK rel = "stylesheet" href="style.css">
	<META charset="utf-8">
</HEAD>
					<?PHP
					require_once 'mysql.php';
					
				$id = 0;
				$itogo = 0;
				// проверка авторизован ли пользователь
				
				if (!isset($_SESSION["user_id"])) { header ("Location: http://".$_SERVER['HTTP_HOST']."/work/start.php");}
				
				//снимаем начения для передачи данных из формы в запись
				unset ($_POST["user"]); //id пользователя для передачи в обработку при заполнении формы
				unset ($_POST["day"]); // день за который пользователь меняет данные
				unset ($_POST["product_id"]); // продукт для которого пользоваель меняет или вносит данные 
				unset ($_POST["prod-col"]); // количетво проданного продукта вводится пользователем в форме
				
				// переменные для определения текущего года и месяца
				$today_year = date ('o');
				$today_month = date ('m');
				$today = date ('j'); //текущий день без ведущего нуля
				$today_any_day="$today_year-$today_month";
			//	echo $today_any_day;
			
			
				// запрос имени авторизовавшегося пользователя
				$sql = "SELECT * FROM $TabName WHERE id = $_SESSION[user_id]";
				$result = mysql_query($sql);
				$user = mysql_fetch_row($result);
				
				// вывод в виде заголовка авторизованного пользователя
				print ("<BR>Здравствуйте,  <B>$user[2]</B></BR>\n <BR>");
				

			

// таблица дни в горизонт
// сформировали заголовок (дни)
$table[0][0] = "НАЗВАНИЕ ПРОДУКТА";	

for ($day=1; $day<32; $day++) {
	$table[0][] = $day;	
	} // for


$sql = "SELECT * FROM `ProductBall`"; //запрос всех продуктов с баллами названиями и тд
	$result = mysql_query($sql);

$sql_staff = "SELECT * FROM $TabName"; //запрос имен всех пользователей ид и тд
	$result_staff = mysql_query ($sql_staff);


while ($row=mysql_fetch_array ($result)) { //запрос по продуктам
	$product_id = $row['id'];
	$product_name = $row['ProductName'];
	$product_ed = $row['ProductEd'];
	//проверка если тип продукта для суммы (вклады или кредиты) то что вводит руками и суммировать
		if ($product_ed == "руб") { $table_productED[]=$product_id; };
	
	
	$table[$product_id][0] = $product_name;
	// для каждого продукта достать из бд кол-во продаж за указанный день
		for ($day=1; $day<32; $day++) {
		
			if ($day < 10) { $day = '0'.$day; }
		
			$sql_1 = "SELECT SUM(`ProductColichestvo`) as `ProductColichestvo` FROM $TabNameSale WHERE `Staff`=$user[0] AND `Day`=\"$today_year-$today_month-$day\" AND `Product`=\"$product_id\"";

			//echo "$sql_1<BR>"; //для отладки выводит строку для запроса в базу
			$result_1 = mysql_query($sql_1);
					
					while ($row_1 = mysql_fetch_array($result_1)) {
				
							$table[$product_id][$day] = $row_1['ProductColichestvo'];

					};	 // while
		
		
		
		
		//по каждому продукту для авторизованного пользователя достаём пояснения к продаже
			$sql_comment = "SELECT `sale_comment` FROM $TabNameSale WHERE `Staff`=$user[0] AND `Day`=\"$today_year-$today_month-$day\" AND `Product`=\"$product_id\"";
			$result_comment = mysql_query($sql_comment);
				while ($row_comment = mysql_fetch_array($result_comment) ) {
					$table_comment[$product_id][$day] = $row_comment[0];
				};
		
		
		
		
		
		
		
		
		} // for 
	
	
	//получение сколько баллов за продукт		
	$sql_ball= "SELECT ProductBall FROM ProductBall WHERE id=\"$product_id\"";
	$ball_sql = mysql_query ($sql_ball);
	$ball = mysql_fetch_row ($ball_sql);


	while ($row_staff=mysql_fetch_array($result_staff)) { //запрос по пользователям
	// запрашиваем сумму проданного продукта по пользователю всего за месяц
		$sql_2 = "SELECT SUM(`ProductColichestvo`) as `ProductColichestvo` FROM $TabNameSale WHERE `Staff`= $row_staff[id] AND `Day` LIKE \"$today_year-$today_month%\" AND `Product`=\"$product_id\"";
		$resultsumma_poProductu = mysql_query ($sql_2);
		$summa_poProductu = mysql_fetch_row ($resultsumma_poProductu);
		$row_staff1 = $row_staff[id];

//таблица пользователей с суммами продукта
		$table_usersummaProduct[$row_staff1][$product_id]=$summa_poProductu[0];

// таблица пользователей с баллами  (сумма продакта)*кол-во баллов за продукт
		$table_userball[$row_staff1][$product_id]= $summa_poProductu[0] * $ball[0];


//echo "сумма по продукту $summa_poProductu[0] <BR>";
//var_dump ($table_usersummaProduct);
//echo $sql_2; echo "<BR>";
//echo $ball[0]; echo "ballll<BR>"; 
//echo $sql_ball; echo "<BR>";
	}; //while


mysql_data_seek ($result_staff, 0); //возвращаем указатель массива ид пользователей на 0 положение для повторной обработки
//echo $product_id; echo "<BR>";
	
}; // while

//var_dump ($table);
//var_dump ($table_producttype);
//echo "<BR>";


// таблица содержит по вертикали id пользователя по горизонтали кол-во проданного продукта в сумме за месяц и сумму балов
echo "<p>";
print ("<TABLE BORDER=1 WIDTH=\"95%\" CELLSPACING=1 CELLPADDING=2 ALIGN=CENTER>\n");


foreach ($table_userball as $row_staff1=>$product_1) { 
//	echo "<TR>";
//	echo "<TD>$row_staff1<BR></TD>";
	foreach ($product_1 as $product_2 => $summa) {
//		echo "<TD>продукт $product_2<BR>";
//		echo "сумма $summa<BR></TD>";
			$total = $total + $summa;
	} //foreach 
//	Echo "<TD> $total</TD>";
//	echo "</TR>";

	$rating_user[$row_staff1] = $total;
	
	$total =0;
}//foreach

// подсчёт места в рейтинге среди других пользователей
$real_user_id = $_SESSION[user_id];
arsort ($rating_user); // сортируем по убыванию   те в начале самый большой балл пользователя
$mesto = 0; //начальная позиция в рейтинге
$a_key = array_keys($rating_user);
$mesto = array_search ($real_user_id, $a_key);
$mesto++;
//echo "<BR>ваше место в рейтинге = $mesto   баллы всего $itogo_users[$real_user_id]";
//echo "<TR>";echo "<TD>ваше место в рейтинге $mesto<BR></TD></TR>";
//echo "<TR>";
//print ("</TABLE>");

$total_userBall = $rating_user[$real_user_id];


echo "<p>";
				print ("Таблица продаж за текущий месяц "); echo date ('F'); echo " , текущее место в рейтинге (без учёта суммы кладов и кредитов) $mesto, сумма набранных баллов $total_userBall <p></p>";
	
				// форма для ввода измений о продажах
				echo "<FORM  action=\"update-bdsale.php\" method=POST >";
				
				// вставляем скрытое поле с указанием id текущего пользователя
				echo "<input type=\"hidden\" name=\"user\" value=\"". $_SESSION[user_id] ."\">"; 
print ("<TABLE BORDER=1 WIDTH=\"95%\" CELLSPACING=1 CELLPADDING=2 ALIGN=CENTER>\n");
//echo "<table border=\"1\">";





foreach ($table as $product_id=>$cell) { 
	
	echo "<TR>"; $sum_1 = $table_usersummaProduct[$real_user_id][$product_id]; $sum_2 = $table_userball[$real_user_id][$product_id];
	echo "<TD>$product_id<BR>всего продано($sum_1)<BR>начислено баллов($sum_2)<BR> </TD>";  
		
	
		foreach ($cell as $day=>$productcolichestvo) {
			//	echo "<TD>$productcolichestvo</TD>";
	
	
				$today_2 = $today - $day;
					if (($today_2 <= 2) AND ($today_2 >=0) ) {
						
						$comment = $table_comment[$product_id][$day]; 
						echo "<TD>$comment<BR> $productcolichestvo<BR>";
			 
			 // поправить если первый день месяца выпадает !!!!!!!!!!!!!!!!!!!!!!!!!!!
							if (($product_id!=0) AND ($day!=0)) {
								echo "<input type=\"hidden\" name=\"prod_colold[$product_id][$day]\" value=\"$productcolichestvo\">";
			
			
								// если продукт тип сумма вывести инпут  иначе выбор из ниспадающего списка
		
								if (in_array($product_id, $table_productED)) {
//	if ($productcolichestvo=='') {$productcolichestvo = 0 ;} было добавлено если в строке ниже есть слово requered то есть обязательно и тогда по умолчанию присваивались нули
									echo "<input type = \"TEXT\" name = \"prod_colnew[$product_id][$day]\" value = \"$productcolichestvo\" size = \"8\" pattern = \"[0-9]{0,10}\">"; //   \s\d{0,5}   
								}
								 else {
									
									
									/// ввод пояснений к продаже
									
									echo "<input type = \"TEXT\" name = \"prod_comment[$product_id][$day]\" value = \"$comment\" placeholder=\"$comment\" size = \"22\" > ";  
									
									
									///ввод пояснений к продаже
									
									echo "<select name = \"prod_colnew[$product_id][$day]\">";
									echo "<option value = \"\">нет продаж</option>";
							
										//ниспадающий список для выбора кол-во проданного продукта
										for ($ii=1; $ii<21; $ii++) {
							
											if ($ii == $productcolichestvo) { echo "<option selected value = \"$ii\"> заменить на $ii</option>"; }
												else echo "<option value = \"$ii\"> заменить на $ii</option>";
											};//for для вывода списка допустимых значений
												echo "</select>";
					
								} //else
							
							echo "</td>";
			
							}
					}// if //if
		else 
	// если дата продукта выходит за два дня то выводит эту часть проверяя количество продукта и устанавливая переменную пояснений
			if ( ($productcolichestvo != '') OR ($productcolichestvo != 0) ) {
					
					$comment = $comment = $table_comment[$product_id][$day];
					echo "<TD>$comment<BR>$productcolichestvo</td>";}
				
				else echo "<TD></TD>";
	
		} // foreach
} // foreach
echo "</TR>";
echo "</table>";
echo "<BR>";
echo "<input type=\"submit\" name=\"submit\" Value=\"применить изменения\">";
echo "<input type=\"reset\" Value=\"очистить\">";
echo "</FORM>";
echo "</p>";

// в скрипт для записи данных передаётся не день а ид продукта   возможно поменять местами надо
?>
<BR><BR><BR><BR>
сменить пароль (если желаете сменить пароль, введите новый)
<FORM  action="changepass.php" method=POST >
				<p>
				<input type="password" name="pass" placeholder="введите новый пароль" pattern = "[A-Za-zА-Яа-яЁё0-9]{1,10}"><br>
				</p>
				<input type="submit" name="submit" Value="сменить пароль ->">
				<input type="reset" Value="очистить">
				</FORM>		
<?PHP

mysql_close ($Link)
?>



</HTML>
