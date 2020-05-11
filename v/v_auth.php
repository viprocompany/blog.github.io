<?php if($isAuth) { ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login;?> !</h4>
	<!-- ссылка для выхода авторизованного пользователя -->
	<a href="login.php"><h5>Выход</h5></a>
	<!-- ссылка для добавления статьи авторизованным пользователем -->
	<a href="add.php">Добавить  статью</a><br>
<a href="add-user.php">Добавить автора</a><br>
<a href="add-category.php">Добавить категорию статьи</a><br>
<p><a href="index.php">Главная</a><span>...</span><a href="users.php">Авторы  </a><span>...</span>
<a href="categories.php">  Категории новостей</a>
</p>
 <p><?php echo $msg?></p>
 <?php } 