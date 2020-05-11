<?php
if($isAuth)
{  ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login?> !</h4>
<a href="index.php">На главную</a><br>
<a href="add-user.php">Добавить автора</a><br>
<a href="add-category.php">Добавить категорию статьи</a><br>  
  <h4>РЕДАКТИРОВАТЬ КАТЕГОРИЮ</h4>
  <form method="post">  
    <p><span>Номер категории: </span><?php  echo $id_category; ?></p> 
    название<br>
    <input type="text" name="title_category" value="<?php  echo $title_category; ?>"><br>
    <input type="submit" value="Применить">
  </form>
  <p><?php echo $msg; ?></p>
<?php }