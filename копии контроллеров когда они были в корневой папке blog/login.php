<?php
include_once('m/auth.php');
include_once('m/system.php');
// include_once('m/validate.php');
// include_once('m/db.php');
// var_dump($_COOKIE);
session_start();
// сброс  предыдущего входа для новой авторизации, использовано при нажатии кнопки выход функцией notAuth(), для повторной авторизации.
$notAuth = notAuth();
//парольный вход для пользователя
if(count($_POST) > 0) 
{
	$_SESSION['name'] = $_POST['login'];
	// echo $_SESSION['name'] можно использовать на всех страницах сайта и обращаться к нему как к имени авторизованного пользователя
	if($_POST['login'] == 'admin' && $_POST['password'] == 'admin')
	{
	//задаем значение авторизации как действительное
		$_SESSION['is_auth'] = true;
//при поставленной галке в поле запомнить в массив ПОСТ добавится 'remember' , что даст возможность повесить куку с хешированным функцией myhash паролем для входа
		if(isset($_POST['remember']))
		{
			setcookie('login', 'admin', time()+3600*24*365 , '/');
			setcookie('password', myhash('admin'), time()+3600*24*365 , '/');
		}
	//!!!!!!!!ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : элемент $_SESSION['returnUrl'] указывающий куда пойдет клиент  после авторизации в файле login.php. НАПРИМЕР: если файл login.php открылся после клика по edit(изменению)  то клиент пойдет на edit.php выбранной статьи, так как на edit.php элемент задан как $_SESSION['returnUrl'] = 'edit.php?fname=$fname' .  соответственно добавление  и так далее !!!!!
		if(isset($_SESSION['returnUrl']))
		{
			//затирает старый адрес для перехода, что бы при разных страницах входа на сайт не происходил переход на когда-то давно выбранную страницу, а был переход на страницу по последнему сделанному клику
			// НЕ РАБОТАЕТ!!!!!
			
			header('Location:'. $_SESSION['returnUrl']);	
			unset($_SESSION['returnUrl']);		
			exit();
		}
		else{
			header('Location: index.php');
			exit();
		}		
	}
}
// include('v/v_login.php');
	$inner_login = template('v_login');

	echo template('v_main', [
				'title'=> 'ВХОД',
				'content'=> $inner_login
			]);

