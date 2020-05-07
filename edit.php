<?php
include_once('functions.php');
// получение данных на форму для изменения 
// из адресной строки берем getпараметр id_article и принимаем его как значение названия статьи выведенной для изменения
$msg = 'Ошибок нет!';
$id_article = $_GET['id_article'] ?? null;
  	if($id_article === null){
	echo 'Ошибка 404, не выбрана статья';
}	

//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса			
$query = db_query("SELECT id_article, title,  content, id_user, id_category  FROM article  WHERE  id_article = '$id_article';");
//создаем массив из cтатей нашего блога
	$my_article = $query->fetchAll();
  // var_dump(	$my_article);
	//проходим циклом по массиву чтоб достать нужные нам поля таблицы
  foreach($my_article as $art)  { 
  	//задаем переменную для названия
  	global $id_article;
  	$id_article = $art['id_article'];
  	// global $title;
  	$title = $art['title'];
  	$id_category = $art['id_category'];
  	$id_user = $art['id_user'];
  	$content = $art['content'];

 if($title === null){
	echo 'Ошибка 404, не выбрана статья';
}	
// функция correct_title для проверки корректоности названия статьи из файла functions.php
if(!correct_title($title)){
	echo 'Кривое название !';	
}

}

session_start();
//проверка авторизации
$isAuth = isAuth();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/edit-user.php?id_user=$id_user";
  $_SESSION['returnUrl'] = "/edit.php?id_article=$id_article";
  Header('Location: login.php');
}
if($isAuth)
{
			//имя пользователя для вывода в приветствии
	$login = isName();
			//приветствие аутентифицированного пользователя
	$welcome = '<h4>Добро пожаловать, ' . $login  .' !</h4>';
	// echo применять здесь нельзя, так как после него не будут работать header(location)
}
// else
// {
// 	//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда пойдет переход после авторизации в файле login.php после клика на EDIT к какой-то статье
// 	$_SESSION['returnUrl'] = "/blog/edit.php";
// 	header('Location: login.php');
// 	exit();
// }
//сохранение измененных данных
if(count($_POST) > 0 ){
	$id_article_new = $id_article;
	$title_new = trim($_POST['title']);
	$id_user_new = trim($_POST['id_user']);
	$id_category_new = trim($_POST['id_category']);
	$content_new = trim($_POST['content']);

//проверяем корректность вводимого названия 
	if(!new_correct_title($title))
	{		
		$msg = errors();
	}	
		elseif($title_new != $title)
	{		
		$msg = 'Название менять нельзя';
	}	
// 	elseif (!correct_origin_title_article($title))
// {
// 	$msg = errors();
// }
    //проверяем корректность вводимого айдишника
elseif(!correct_id('name', 'users', 'id_user', $id_user ))
{   
  $msg = errors();
}	
    //проверяем корректность вводимого айдишника
if(!correct_id('title_category', 'categories', 'id_category', $id_category ))
{   
  $msg = errors();
  $title_category = "";
}
		//проверяем корректность вводимого контента 
	elseif(!correct_content($content))
	{
		$msg = errors();
	}	
	else{
//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
		$query = db_query("UPDATE `article` SET  `title`='$title_new', `content`='$content_new',   `id_user`='$id_user_new', `id_category`='$id_category_new' WHERE id_article= '$id_article_new' ; ");
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
		header("Location: /post.php?id_article=$id_article_new ");
		// header("Location: /blog/post.php?id_article=$id_article_new ");

		exit();
	}
}
// echo 'auth: ' . $isAuth ;
?>
<p><?php echo $welcome; ?></p>

<a href="index.php">На главную</a><br>
<h4>РЕДАКТИРОВАТЬ СТАТЬЮ</h4>
<form method="post">	
	<p><span>Номер статьи: </span><?php  echo $id_article; ?></p>	
	Название<br>
	<input type="text" name="title" value="<?php  echo $title; ?>"><br>
	Код автора<br>
	<input type="text" name="id_user" value="<?php  echo $id_user; ?>"><br>	
	Категория новости<br>
	<input type="text" name="id_category" value="<?php  echo $id_category; ?>"><br>
	Контент<br>
	<textarea name="content"><?php echo nl2br($content); ?></textarea><br>
	<input type="submit" value="Применить">
</form>
<p><?php echo $msg; ?></p>

