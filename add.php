<?php
include_once('functions.php');

session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
	//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ СТАТЬЮ"
	$_SESSION['returnUrl'] = "add.php";
	Header('Location: login.php');
}
//получение параметров с формы методом пост
if(count($_POST) > 0){
	$title = trim($_POST['title']);
	$content = trim($_POST['content']);
	$id_user = trim($_POST['id_user']);
	$id_category = trim($_POST['id_category']);
//проверяем корректность вводимого названия 
	if(!new_correct_title($title))
	{		
		$msg = errors();
	}	
	elseif(!correct_user($id_user))
	{
		// echo $id_user;
		$msg = errors();
	}	
	elseif(!correct_category($id_category))
	{
		$msg = errors();
	}	
		//проверяем корректность вводимого контента 
	elseif(!correct_content($content))
	{
		$msg = errors();
	}	
	else{
//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
		$query = db_query("INSERT INTO `article`( `title`, `content`,  `id_user`, `id_category`) VALUES ('$title','$content','$id_user','$id_category');");
//получаем ячейку айдишника созданной   cтатьи из нашего блога
		$query = db_query("SELECT id_article FROM article  WHERE  title = '$title';");
		$id_article = $query->fetchColumn();

		header("Location: /post.php?id_article=$id_article ?>");
		exit();
	}
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
	$title = "";
	$id_user = "";
	$id_category = "";
	$content = "";
	$msg = '';
}

if($isAuth) { ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login?> !</h4>
<?php } ?>
<a href="index.php">На главную</a><br>
<h3>ДОБАВИТЬ СТАТЬЮ</h3>
<form method="post">
	Название<br>
	<input type="text" name="title" value="<?php  echo $title; ?>"><br>
	Код автора<br>
	<input type="text" name="id_user" value="<?php  echo $id_user; ?>"><br>
	Код категории<br>
	<input type="text" name="id_category" value="<?php  echo $id_category; ?>"><br>
	Контент<br>
	<textarea name="content"><?php echo $content; ?></textarea><br>
	<input type="submit" value="Добавить">
</form>
<?php echo $msg; ?>
<br><a href="add-user.php">Добавить автора</a><br>