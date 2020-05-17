<?php

//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя из функции
$login = isName();
//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
	$_SESSION['returnUrl'] = "/index.php?c=add-user";
		// $_SESSION['returnUrl'] = "/blog/add-user.php";
	Header('Location: index.php?c=login');
}

//получение параметров с формы методом пост
if(count($_POST) > 0){
	$name = trim($_POST['name']);
//проверяем корректность вводимого названия 
	if(!correct_name($name))
	{		
		$msg = errors();
	}	
	//проверяем незатанятость данного названия(для пользователя)
	elseif (!correct_origin( 'id_user', 'users', 'name', $name))
	{
		$msg = errors();
	}		
	else{
		//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
		//добавления данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
		$new_user_id = db_query_add("INSERT INTO `users`( `name`) VALUES (:n);",
			['n'=>$name]);
		// header("Location: blog/users.php?id_user=$new_user_id");
			// старые ссылки до приведение к человекочитаемым урлам ЧПУ 
		// header("Location: /index.php?c=users&id_user=$new_user_id");
		header("Location: " . ROOT . "users/$new_user_id");
				exit();
	}
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
	$name = "";
	$msg = '';
}
	// include('v/v_users.php');
				$inner = template('v_add-user',  [
					'isAuth' => $isAuth	,
				  'name' => $name,
				  'msg' => $msg
			]);
				$title = 'НОВЫЙ АВТОР';
	

?>
