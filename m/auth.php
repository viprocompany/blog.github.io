<?php
// К У К И    И     С Е С С И Я
//функция для проверки наличия кук и сессий для авторизации
function isAuth(){
	//задаем флаг авторизации 
	$isAuth = false;	
	if((isset($_SESSION['is_auth']))  && ($_SESSION['is_auth']))
	{ 
//подтверждаем авторизацию с помощью сессии
		$isAuth = true;	
	}
	elseif(isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{
		if(($_COOKIE['login'] == 'admin') &&  ($_COOKIE['password'] == myhash('admin')))
		{
			$_SESSION['is_auth'] = true;
			$isAuth = true;
		}
	}
	return $isAuth;
}

//функция возвращает имя пользователя полученное из куки или сессии , которое можно использовать для приветствия после авторизации или входа
function isName(){		
	if($_COOKIE['login'])
	{
		$login = $_COOKIE['login'];	
	}	
	else
	{ 
		$login = $_SESSION['name'];	
	}
	return $login;
}
//хеширование пароля для отправки в куку, 'salt777' это так называемая соль (для дополнительного шифрования алгоритма), которая задается от балды
function myhash($str){
	return hash('sha256', $str . 'salt777');
}
