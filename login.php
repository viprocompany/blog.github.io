<?php
include_once('functions.php');

// var_dump($_COOKIE);
session_start();

// сброс  предыдущего входа для новой авторизации, использовано при нажатии кнопки выход, для повторной авторизации.
if(isset($_SESSION['is_auth']))
{	
	unset($_SESSION['is_auth']);
}
//c чисткой кук логина и пароля путем установки их жизней на 1 января 1970 года (1)
if(isset($_COOKIE['login'])){
	setcookie('login', '', time()-3600, '/');
}
if(isset($_COOKIE['password'])){
	setcookie('password', '', time()-3600, '/');
}

//парольный вход дляпользователя
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
?>
<a href="index.php">На главную</a><br><br>
<form method="post">
	ВХОД<br>
	Логин	<input type="text" name="login" value=""><br>
	Пароль<input type="password" name="password" value=""><br>
	<input type="checkbox" name="remember" value="">Запомнить<br>	
	<input type="submit" value="Войти">
</form>
