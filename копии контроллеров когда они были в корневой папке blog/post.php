<?php
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
include_once('m/system.php');
session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла
// global  $id_article;
$id_article = $_GET['id_article'] ?? null;
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ СТАТЬЮ"
	$_SESSION['returnUrl'] = "/post.php?id_article=$id_article";	
	// $_SESSION['returnUrl'] = "/blog/add.php";
	// Header('Location: login.php');
}
$err404 = false;
if($id_article === null )
{
	$err404 = true;
	echo 'Ошибка 404, не выбрана статья!';
}	
else{
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса
 $query = select_tables_all('id_article, title,  name, content, date, title_category' ,"WHERE  id_article ='$id_article'");
//создаем массив из cтатей нашего блога
	$my_article = $query->fetchAll();  

//ВАЛИДАЦИЯ проходим циклом по массиву чтоб достать нужные нам поля таблицы  -->
foreach($my_article as $art)
{ 
  	//задаем переменную для названия
  $title = $art['title'];
  $date = $art['date'];
  $name = $art['name'];
  $title_category = $art['title_category'];
  $content = $art['content'];
}
	if(!$my_article)
	{
		$err404 = true;
		echo 'Ошибка 404, нет такой страницы!';
	}
	else{					
 // include('v/v_auth.php');
			$inner_auth =  template('v_auth' , [
				'isAuth' => $isAuth,
				'login' => $login,
				'msg' => $msg
			]);			
					// include_once('v/v_post.php');
			$inner_post = template('v_post',  [
				'isAuth' => $isAuth,
				'my_article' => $my_article,
				'title' => $title,
				'date' => $date,
				'name' => $name,
				'id_article' => $id_article,
				'title_category' => $title_category,
				'content' => $content
			]);
			echo template('v_main', [
				'title'=> $title,
				'content'=> $inner_post,
				'auth'=> $inner_auth
			]);		
		}
	}
?>
	