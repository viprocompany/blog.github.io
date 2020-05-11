<?php if($isAuth) { ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login?> !</h4>

<a href="index.php">На главную</a><br>
<a href="add-user.php">Добавить автора</a><br>
<a href="add-category.php">Добавить категорию статьи</a><br>
<h4>РЕДАКТИРОВАНИЕ СТАТЬИ</h4>
<form method="post">	
	<p><span>Номер статьи: </span><?php  echo $id_article; ?></p>	
	Название<br>
	<input type="text" name="title" value="<?php  echo $title; ?>"><br>
	Код автора<br>
	<input type="text" name="id_user" value="<?php  echo $id_user; ?>"><br>
	Код категории новости<br>
	<input type="text" name="id_category" value="<?php  echo $id_category; ?>"><br>
	Контент<br>
	<textarea name="content"><?php echo $content; ?></textarea><br>
	<input type="submit" value="Применить">
</form>
<p><?php echo $msg; ?></p>
<?php } 