<HTML>
<HEAD>
	<LINK rel = "stylesheet" href="style2.css">
	<META charset="utf-8">
</HEAD>
<button onclick="FixAction(this)">закрепить</button>



<a href="http://10.102.91.130/work/plan.php">заполнить план</a>;


<a href="http://10.102.91.130/work/user_for_office.php"> привязка пользователя к отделению </a>


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

Print "<p> Продажи за текущий месяц ($today_month) $today_year год. Сегодня $today число.  </p><BR> ";
//таблица продаж первое значение=название продукта (id) второе значение=пользователь   значение=кол-во проданного продукта

//$table_plan[0][0] = "офис";

$table_sale[0][0] = "НАЗВАНИЕ ПРОДУКТА";	

echo "<TABLE id=\"t1\" BORDER=1 WIDTH=\"100%\" CELLSPACING=2 CELLPADDING=2 ALIGN=CENTER>\n";


$sql_staff = "SELECT * FROM `staff` WHERE staffWork = 1 "; // запрашиваем id пользователей для которых будем доставать продажи каждого продукта
$result_staff = mysql_query($sql_staff);

while ($row_staff=mysql_fetch_array ($result_staff)) {
	$staff_id = $row_staff['id'];
	$staff_name = $row_staff['staffFamiliya'];
	
$table_sale[0][$staff_id] = $staff_name;

$sql_product_id = "SELECT * FROM `ProductBall`";// запрашиваем продукты с их id
$result_product_id = mysql_query($sql_product_id);

while ($row_product_id = mysql_fetch_array ($result_product_id)) {
	$product_id = $row_product_id['id'];
	$product_name = $row_product_id['ProductName'];
	
	$table_sale[$product_id][0] = $product_name;
//считаем сумму проданного продукта по пользователю за текущий месяц

$sql_sale = "SELECT SUM(`ProductColichestvo`) as `ProductColichestvo` FROM $TabNameSale WHERE `Staff`=\"$staff_id\" AND `Day` LIKE \"$today_any_day%\" AND `Product`=\"$product_id\"";
		$result_sale = mysql_query($sql_sale);
			while ($row_sale = mysql_fetch_array($result_sale)) {
				
					$table_sale[$product_id][$staff_id] = $row_sale['ProductColichestvo'];


			};	// while
	}; // while				
};// while

//подсчет выполнения плана офисами и заполнение таблицы план выполнения продаж
$sql_office = "SELECT * FROM $TabNameOffice";
$result_office = mysql_query ($sql_office);

mysql_data_seek ($result_product_id, 0); //возвращаем указатель массива на 0 положение для повторной обработки

while ($row_sql_office = mysql_fetch_array ($result_office)) {
		$office_id = $row_sql_office['office_id'];
		$office_name = $row_sql_office['office_name'];
		
			while ($row_product_id = mysql_fetch_array ($result_product_id)) {
				$product_id = $row_product_id['id'];
				$product_name = $row_product_id['ProductName'];
				
$sql_sum = "SELECT ROUND((SELECT SUM(`ProductColichestvo`) as `ProductColichestvo` FROM $TabNameSale WHERE `sale_staff_office_id`=\"$office_id\" AND `Day` LIKE \"$today_any_day%\" AND `Product`=\"$product_id\")/(SELECT `plan_value` FROM $TabNamePlan WHERE `plan_id_product` = $product_id AND `plan_id_office` = $office_id)* 100)";
$result_sum = mysql_query($sql_sum);
				
				while ($sum = mysql_fetch_array ($result_sum)) {
				//заносим в таблицу ид офиса и его выполненный план по продукту
						$table_plan[$product_id][$office_id] =  $sum[0];};

					};
			mysql_data_seek ($result_product_id, 0); //возвращаем указатель массива на 0 положение для повторной обработки
};

mysql_data_seek ($result_office, 0); //возвращаем указатель массива на 0 положение для повторной обработки


// выводим таблицу продаж продукты вертикаль пользователи горинталь количество продукта в ячейках

foreach ($table_sale as $product_id=>$cell) { // $table[$product_id][$day]
	echo "<TR>";
	echo "<TD>$product_id</TD>"; // 
	
	foreach ($cell as $day=>$productcolichestvo) {
	     	     
	     echo "<TD>$productcolichestvo";
				
				if ( ($day == 0 ) AND ($product_id != 0) ) {
					while ($row_sql_office = mysql_fetch_array ($result_office)) {
							$office_id = $row_sql_office['office_id'];
							$office_name = $row_sql_office['office_name'];
							$plan = $table_plan[$product_id][$office_id];
							echo "<p></p><b>$office_name $plan% <BR>";
						};
				};
		echo "</TD>";
		mysql_data_seek ($result_office, 0); //возвращаем указатель массива на 0 положение для повторной обработки

	
		} // foreach
	} // foreach
echo "</TR>";
echo "</table>";

?>


<BR><BR><BR><BR>
сменить пароль (если желаете сменить пароль, введите новый)
<FORM  action="changepass.php" method=POST >
				<p>
				<input type="text" name="pass"><br>
				</p>
				<input type="submit" name="submit" Value="сменить пароль ->">
				<input type="reset" Value="очистить">
				</FORM>		

<script>

function gid(i) {return document.getElementById(i);}
function CEL(s) {return document.createElement(s);}
function ACH(p,c) {p.appendChild(c);}

function getScrollWidth() {
	var dv = CEL('div');
	dv.style.overflowY = 'scroll'; dv.style.width = '1150px'; dv.style.height = '1150px'; dv.style.position = 'absolute';
	dv.style.visibility = 'hidden';//при display:none размеры нельзя узнать. visibility:hidden - сохраняет геометрию, а выше было position=absolute - не сломает разметку
	ACH(document.body,dv);
	var scrollWidth = dv.offsetWidth - dv.clientWidth;
	document.body.removeChild(dv);
	return (scrollWidth);
}

function setSum(tbl, rr, cc) {
	var rowCount = tbl.rows.length, sum = '';
	for (var i=rr; i<rowCount; i++) {
		var row = tbl.rows[i];
		for (var j=cc; j < row.cells.length; j++) {
			sum = Math.floor(Math.random()*10000) + '';
			row.cells[i,j].innerHTML = sum.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
			row.cells[i,j].style.textAlign = 'right';
		}
	}
}

function FixAction(el) {
	FixHeaderCol(gid('t1'),1,3,1200,550);


	el.parentNode.removeChild(el);
}

function FixHeaderCol(tbl, fixRows, fixCols, ww, hh) {
	var scrollWidth = getScrollWidth(), cont = CEL('div'), tblHead = CEL('table'), tblCol = CEL('table'), tblFixCorner = CEL('table');
	cont.className = 'divFixHeaderCol';
	cont.style.width = ww + 'px'; cont.style.height = hh + 'px';
	tbl.parentNode.insertBefore(cont,tbl);
	ACH(cont,tbl);

	var rows = tbl.rows, rowsCnt = rows.length, i=0, j=0, colspanCnt=0, columnCnt=0, newRow, newCell, td;

	// Берем самую первую строку (это rows[0]) и получаем истинное число столбцов в ТАБЛИЦЕ (учитывается colspan)
	for (j=0; j<rows[0].cells.length; j++) {columnCnt += rows[0].cells[j].colSpan;}
	var delta = columnCnt - fixCols;

	// Пробежимся один раз по всем строкам и построим наши фиксированные таблицы
	for (i=0; i<rowsCnt; i++) {
		columnCnt = 0; colspanCnt = 0;
		newRow = rows[i].cloneNode(true), td = rows[i].cells;
		for (j=0; j<td.length; j++) {
			columnCnt += td[j].colSpan;//кол-во столбцов в данной строке с учетом colspan
			if (i<fixRows) {//ну и заодно фиксируем заголовок
				newRow.cells[j].style.width = getComputedStyle(td[j]).width;
				ACH(tblHead,newRow);
			}
		}

		newRow = CEL('tr');
		for (j=0; j<fixCols; j++) {
			if (!td[j]) continue;
			colspanCnt += td[j].colSpan;
			if (columnCnt - colspanCnt >= delta) {
				newCell = td[j].cloneNode(true);
				newCell.style.width = getComputedStyle(td[j]).width;
				newCell.style.height = td[j].clientHeight - parseInt(getComputedStyle(td[j]).paddingBottom) - parseInt(getComputedStyle(td[j]).paddingTop) + 'px';
				ACH(newRow,newCell);
			}
		}
		if (i<fixRows) {ACH(tblFixCorner,newRow);}
		ACH(tblCol,newRow.cloneNode(true));
	} // Закончили пробегаться один раз по всем строкам и строить наши фиксированные таблицы

	tblFixCorner.style.position = 'absolute'; tblFixCorner.style.zIndex = '3'; tblFixCorner.className = 'fixRegion';
	tblHead.style.position = 'absolute'; tblHead.style.zIndex = '2'; tblHead.style.width = tbl.offsetWidth + 'px'; tblHead.className = 'fixRegion';
	tblCol.style.position = 'absolute'; tblCol.style.zIndex = '2'; tblCol.className = 'fixRegion';

	cont.insertBefore(tblHead,tbl);
	cont.insertBefore(tblFixCorner,tbl);
	cont.insertBefore(tblCol,tbl);

	var bodyCont = CEL('div');
	bodyCont.style.cssText = 'position:absolute;';

	// Горизонтальная прокрутка
	var divHscroll = CEL('div'), d1 = CEL('div');
	divHscroll.style.cssText = 'width:100%; bottom:0; overflow-x:auto; overflow-y:hidden; position:absolute; z-index:3;';
	divHscroll.onscroll = function () {
		var x = -this.scrollLeft + 'px';
		bodyCont.style.left = x;
		tblHead.style.left = x;
	}

	d1.style.width = tbl.offsetWidth + scrollWidth + 'px';
	d1.style.height = '1px';

	ACH(divHscroll,d1);
	ACH(cont,divHscroll);
	ACH(bodyCont,tbl);
	ACH(cont,bodyCont);

	// Вертикальная прокрутка
	var divVscroll = CEL('div'), d2 = CEL('div');
	divVscroll.style.cssText = 'height:100%; right:0; overflow-x:hidden; overflow-y:auto; position:absolute; z-index:3';
	divVscroll.onscroll = function () {
		var y = -this.scrollTop + 'px';
		bodyCont.style.top = y;
		tblCol.style.top = y;
	}

	d2.style.height = tbl.offsetHeight + scrollWidth + 'px';
	d2.style.width = scrollWidth + 'px';

	ACH(divVscroll,d2);
	ACH(cont,divVscroll);

	cont.addEventListener('wheel', myWheel);
	function myWheel(e) {
		e = e || window.event;
		var delta = e.deltaY || e.detail || e.wheelDelta;
		var z = delta > 0 ? 1 : -1;
		divVscroll.scrollTop = divVscroll.scrollTop + z*17;
		e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	}
} //FixHeaderCol




</script>


</HTML>
