<?php
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
$msg = '';
session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
	$_SESSION['returnUrl'] = "/users.php";
		// $_SESSION['returnUrl'] = "/blog/users.php";
	// Header('Location: login.php');
}
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла 
$id_user = $_GET['id_user'] ?? null;
if(isset($id_user )){//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса			
	$query = select_table(' * ', ' users ', " WHERE  id_user = '$id_user' "); 
//задаем переменную для названия	
	$user = $query->fetch();
	$name = $user['name'];
	$id_user = $user['id_user'];
	{   		  //проверяем корректность вводимого айдишника
    if(!correct_id('name', 'users', 'id_user', $id_user ))
    {   
      $msg = errors();
    }
// функция correct_name для проверки корректоности имени автора проверяем корректность вводимого имени 
		elseif(!correct_name($name))
		{		
			$msg = errors();
		}	

		include('v/v_users_new.php');
	 }
	}
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса		
	$query = select_table(' name, id_user ', ' users ', " ORDER BY name ");  
//задаем переменную для названия	
	$users= $query->fetchAll();

	include('v/v_auth.php');
	include('v/v_users.php');
?>
	
	