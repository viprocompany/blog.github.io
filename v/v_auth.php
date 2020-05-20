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
					<!-- после подключения правил перезаписи в файле .htaccess делаем урлы человекочитаемыми   выбрасывая из ссылки подставляемый ранее index.php?c= , так как теперь в индексном файле страницы при получении из строки(массив гет) значение элемента home , будет происходить соответственно вызов контролера home 
								<?php echo ROOT?> используем для указания корня сайта , задаем с индексной страницы-->
						<p><a class="btn btn-outline-primary" href="<?php echo ROOT?>home">Статьи</a></p>
				<!-- 		<p><a class="btn btn-outline-primary" href="index.php?c=home">Главная</a></p> -->
						<p><a class="btn btn-outline-primary" href="<?php echo ROOT?>users">Авторы  </a></p>
						<!-- после подключения правил перезаписи в файле .htaccess делаем урлы человекочитаемыми   выбрасывая из ссылки подставляемый ранее index.php?c= , так как теперь в индексном файле страницы при получении из строки(массив гет) значение элемента users , будет происходить соответственно вызов контролера users -->
									<!-- <p><a class="btn btn-outline-primary" href="index.php?c=users">Авторы  </a></p> -->
						<p><a  class="btn btn-outline-primary" href="<?php echo ROOT?>categories">Категории</a></p>
						<!-- <p><a  class="btn btn-outline-primary" href="index.php?c=categories">Категории</a></p> -->
						<p><a  class="btn btn-outline-primary" href="<?php echo ROOT?>texts">Тексты</a>	</p>
				<hr>
	<!-- ссылка для добавления статьи авторизованным пользователем -->
	<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
<!-- <a class=" btn btn-outline-info" href="index.php?c=add">Добавить  статью</a> -->
<a class=" btn btn-outline-info" href="<?php echo ROOT?>add">Добавить  статью</a>
	<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
	<!-- <a class=" btn btn-outline-info"  href="index.php?c=add-user">Добавить автора</a>
	<a class=" btn btn-outline-info" href="index.php?c=add-category">Добавить категорию</a> -->
		<a class=" btn btn-outline-info"  href="<?php echo ROOT?>add-user">Добавить автора</a>
				<a class=" btn btn-outline-info" href="<?php echo ROOT?>add-category">Добавить категорию</a>
		
	
		<a class=" btn btn-outline-info" href="<?php echo ROOT?>add-text
			">Добавить текст</a>
	
<?php } ?>
<!-- <p><?php echo $msg?></p> -->

