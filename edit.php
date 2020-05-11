<?php
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
session_start();
//проверка авторизации
$isAuth = isAuth();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
if(!$isAuth)
{//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/edit-user.php?id_user=$id_user";
$_SESSION['returnUrl'] = "/edit.php?id_article=$id_article";
Header('Location: login.php');
}
if($isAuth)
{	//имя пользователя для вывода в приветствии
	$login = isName();
	// echo применять здесь нельзя, так как после него не будут работать header(location)
}
// получение данных на форму для изменения 
// из адресной строки берем get-параметр id_article и принимаем его как значение названия статьи выведенной для изменения
global $id_article;
$id_article = $_GET['id_article'];
$err404 = false;
if(!$id_article)
{
	$err404 = true;
	echo 'Ошибка 404, не выбрана статья';
}	
else{//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса		
	$query = select_table(' * ', ' article ', " WHERE  id_article = '$id_article'");
//создаем массив из cтатей нашего блога
	$my_article = $query->fetchAll();
  // var_dump(	$my_article);
	if(!$my_article){
		$err404 = true;
		echo 'Нет такой статьи!';
	}	
	else
	{//проходим циклом по массиву чтоб достать нужные нам поля таблицы
		foreach($my_article as $art)  
		{ 
			$title = $art['title'];
			$id_category = $art['id_category'];
			$id_user = $art['id_user'];
			$content = $art['content'];	
// функция correct_title для проверки корректоности названия статьи из файла functions.php
			if(!correct_title($title))
			{
				$err404 = true;
				echo 'Кривое название !';	
			}
			else
			{
				$err404 = false;
			}
		}		
	}
}
//сохранение измененных данных
if((count($_POST) > 0) )
{
	// $id_article_new = $id_article;
	$title_new = trim($_POST['title']);
	$id_user_new = trim($_POST['id_user']);
	$id_category_new = trim($_POST['id_category']);
	$content_new = trim($_POST['content']);
	$msg = "";
//проверяем корректность вводимого названия 
	if(!new_correct_title($title_new))
	{		
		$msg = errors();
	}	
	elseif($title_new == $title)
	{		
		$msg = 'Название менять нельзя';
	}	
// 	elseif (!correct_origin_title_article($title_new))
// {
// 	$msg = errors();
// }
    //проверяем корректность вводимого айдишника
	elseif(!correct_id('name', 'users', 'id_user', $id_user_new ))
	{   
		$msg = errors();
	}	
  //проверяем корректность вводимого айдишника
	elseif(!correct_id('title_category', 'categories', 'id_category', $id_category_new ))
	{   
		$msg = errors();
	}	
	//проверяем корректность вводимого контента 
	elseif(!correct_content($content_new))
	{
		$msg = errors();
	}	
	else{//подключаемся к базе данных и предаем тело запроса в параметрах, которое будет проверяться на ошибку с помощью этой же функции
		$query =  db_query_update_art($title_new, $content_new, $id_user_new, $id_category_new, $id_article);
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
		header("Location: /post.php?id_article=$id_article ");
		// header("Location: /blog/post.php?id_article=$id_article ");
		exit();
	}
}
if(!$err404)
{
	include('v/v_edit.php');
}

?>


