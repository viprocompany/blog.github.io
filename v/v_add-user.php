<?php if($isAuth) { ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login?> !</h4>
	<a href="index.php">На главную</a><br>
	<h3>ДОБАВИТЬ АВТОРА</h3>
	<form method="post">
		ФИО  автора<br>
		<input type="text" name="name" value="<?php  echo $name; ?>"><br>
		<input type="submit" value="Добавить">
	</form>
	<?php echo $msg; ?>
<?php }