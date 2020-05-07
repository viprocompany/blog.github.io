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
	$_SESSION['returnUrl'] = "/add.php";
	// $_SESSION['returnUrl'] = "/blog/add.php";
	Header('Location: login.php');
}
//получение параметров с формы методом пост
if(count($_POST) > 0){
	$title = trim($_POST['title']);
	$content = trim($_POST['content']);
	$id_user = trim($_POST['id_user']);
	$id_category = trim($_POST['id_category']);
		  //проверяем корректность вводимого айдишника СТАТЬИ
	if(!correct_id('title', 'article', 'id_article', $id_article ))
	{	
		$msg = errors();
	}	
//проверяем корректность вводимого названия 
	elseif(!new_correct_title($title))
	{		
		$msg = errors();
	}	
	//проверка названия на незанятость вводимого названия 
	elseif (!correct_origin('id_article', 'article', 'title', $title)) 
	{
		$msg = errors();
	}

 //проверяем корректность вводимого айдишника автора
elseif(!correct_id('name', 'users', 'id_user', $id_user ))
{   
  $msg = errors();
}	
    //проверяем корректность вводимого айдишника категории новости
if(!correct_id('title_category', 'categories', 'id_category', $id_category ))
{   
  $msg = errors();
 }
		//проверяем корректность вводимого контента 
	elseif(!correct_content($content))
	{
		$msg = errors();
	}	
	else{
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
		//добавления данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
		$new_article_id = db_query_add_article("INSERT INTO `article`( `title`, `content`,  `id_user`, `id_category`) VALUES (:t,:c,:us,:cat);",
		 [
			't'=>$title,
			'c'=>$content,
			'us'=>$id_user,
			'cat'=>$id_category
		]);

		//header("Location: /blog/post.php?id_article=$new_article_id ");

		header("Location: /post.php?id_article=$new_article_id");
		// header("Location: /blog/post.php?id_article=$new_article_id");
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


<!-- //подключаемся к базе данных через  функцию db_query и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
		// $query = db_query("INSERT INTO `article`( `title`, `content`,  `id_user`, `id_category`) VALUES (:t,:c,:us,:cat);" , [
		// 	't'=>$title,
		// 	'c'=>$content,
		// 	'us'=>$id_user,
		// 	'cat'=>$id_category
		// ]); -->