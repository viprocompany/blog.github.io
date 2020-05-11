<?php if($isAuth) { ?>
  <!-- приветствие аутентифицированного пользователя  -->
  <h4>Добро пожаловать, <?php echo $login?> !</h4>

<a href="index.php">На главную</a><br>
<h3>ДОБАВИТЬ КАТЕГОРИЮ НОВОСТИ</h3>
<form method="post">
  Название категории: <br>
  <input type="text" name="title_category" value="<?php  echo $title_category; ?>"><br>
  <input type="submit" value="Добавить">
</form>
<?php echo $msg; ?>
<?php }