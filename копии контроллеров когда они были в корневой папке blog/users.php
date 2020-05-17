<?php
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
include_once('m/system.php');
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
		// include('v/v_users_new.php');
		//при добавлении нового автора будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
				$inner_users_new = template('v_users_new',  [
				'id_user' => $id_user,
				'name' => $name
			]);			
	 }
	}
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса		
	$query = select_table(' name, id_user ', ' users ', " ORDER BY name ");  
//задаем переменную для названия	
	$users= $query->fetchAll();

	//создаем переменные в виде шаблонов из кода разметки и прередаем в выбранные вьюшки значения  isAuth,login,msg,users из  файла users.php : 1. v_auth  для вывода представления авторизации и 2. v_users для вывода общего списка авторов
 // include('v/v_auth.php');
			$inner_auth =  template('v_auth' , [
				'isAuth' => $isAuth,
				'login' => $login,
				'msg' => $msg
			]);	
	// include('v/v_users.php');
				$inner_users = template('v_users',  [
				'isAuth' => $isAuth,
				'users' => $users
			]);
	//подставляем переменные разметки  $inner_auth и $inner_users в код главной страницы v_main для вывода на экран. значение title как и любое другое можно задать вручную без переменных 
			echo template('v_main', [
				'title'=> 'АВТОРЫ',
				'content'=> $inner_users,
				'auth'=> $inner_auth,
				'new_row'=> $inner_users_new
			]);	
?>
	
	