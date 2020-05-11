<?php

if($isAuth)
{  ?>
<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login?> !</h4>
<a href="index.php">На главную</a><br>
<a href="add-user.php">Добавить автора</a><br>
<a href="add-category.php">Добавить категорию статьи</a><br>
<h4>РЕДАКТИРОВАНИЕ ДАННЫХ АВТОРА</h4>
<form method="post">  
  <p><span>Код автора: </span><?php  echo $id_user;?></p> 
  ФИО автора<br>
  <input type="text" name="name" value="<?php  echo $name; ?>"><br>
  <input type="submit" value="Применить">
</form>
<p><?php echo $msg; ?></p>
<?php }