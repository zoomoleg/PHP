
<HTML>
	<HEAD>
		<TITLE> авторизация пользователей  </TITLE>
		<META charset="utf-8">
	</HEAD>

		<BODY>
			<?PHP
				session_start ();
				require_once 'mysql.php';
				$id = 0;
				$sql = "SELECT * FROM $TabName WHERE staffWork <> 0";
				$result = mysql_query ($sql);
			
			
			
			if (!isset($_SESSION["user_id"])) { 
					?>
				<FORM  action="auth.php" method=POST >
				<p>
				<select name="login">
				<?PHP  
				while ($row = mysql_fetch_array ($result)) {
				print("<option value = \"$row[staffLogin]\" > $row[staffFamiliya] </option>"); 
															}
				?>
				</select>
				</p>
				<p>
				<input type="password" name="pass"><br>
				</p>
				<input type="submit" name="submit" Value="ВОЙТИ ->">
				<input type="reset" Value="очистить">
				</FORM>
				
			<?PHP
			} 
			
			elseif ($_SESSION['user_staffwork']==2){//($_SESSION["user_id"]==36) {
				include ("otchet.php"); ?>
				<p>
				<br>Выйти из системы <br>
				<a href="auth.php?action=logout">ВЫЙТИ</a>
				
					<?PHP     }
						
			else	{?>
					<?PHP include ("prodazy.php"); ?>
					<p>
					<br>Выйти из системы <br>
					<a href="auth.php?action=logout">ВЫЙТИ</a>
					<?PHP     };	?>
						
			<?PHP mysql_close ($Link); ?>

</BODY>
</HTML>
