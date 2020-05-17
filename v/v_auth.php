<?php 
if(!$isAuth){?>
		<!-- ссылка для добавления статьи авторизованным пользователем -->
<!-- <p><a class="btn btn-success" href="index.php?c=login">Вход </a></p> -->
<p><a class="btn btn-success" href="<?php echo ROOT?>login">Вход </a></p>
<?php }
elseif($isAuth)
{ ?><!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login;?> !</h4>
	<!-- ссылка для выхода авторизованного пользователя -->
<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->	
<!-- <p><a class="btn btn-outline-danger" href="index.php?c=login">Выход</a></p><br> -->
<p><a class="btn btn-outline-danger" href="<?php echo ROOT?>login">Выход</a></p><br>
	<!-- ссылка для добавления статьи авторизованным пользователем -->
	<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
<!-- <a class=" btn btn-outline-info" href="index.php?c=add">Добавить  статью</a> -->
<a class=" btn btn-outline-info" href="<?php echo ROOT?>add">Добавить  статью</a>
	<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
	<!-- <a class=" btn btn-outline-info"  href="index.php?c=add-user">Добавить автора</a>
	<a class=" btn btn-outline-info" href="index.php?c=add-category">Добавить категорию</a> -->
		<a class=" btn btn-outline-info"  href="<?php echo ROOT?>add-user">Добавить автора</a>
	<a class=" btn btn-outline-info" href="<?php echo ROOT?>add-category">Добавить категорию</a>
<?php } ?>
<!-- <p><?php echo $msg?></p> -->

