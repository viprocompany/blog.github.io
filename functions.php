<?php
//функция для передачи последней ошибки
function errors($msg = null)
{
	//делаем статику, что бы ошибка могла сохраниться и её описание могло передаться по запросу в место вызова
	static $last_erorr = '';
	if($msg !== null)
	{
		$last_erorr = $msg;
	}	
	else
	{
		return $last_erorr;
	}
}

//проверка корректности названия новой статьи
function new_correct_title($title){
	$title = trim($title);
	if($title == '' )
	{		//вызываем функцию и передаем параметром сообщение
		errors('Заполните название!');
		return false;
	}
	elseif(!(mb_strlen($title) > 1 && mb_strlen($title) < 31))
	{
		errors('Oт двух до тридцати знаков в названии!');
		return false;
	}
	//используем функцию c регулярным выражением на проверку названия  файла 
	elseif(!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $title))
	{
		errors('Введите корректное название !');
		return false;
	}
	else{
		// return preg_match('/^([A-Za-z0-9_!\-\.])+$/', $title);
		return true;
	}	
}

//проверка корректности имени автора статьи ли категории
function correct_name($name){
	if(mb_strlen($name)<2)
	{
		errors('Не менее двух знаков!');
		return false;
	}
	elseif((!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\-])/', $name))){
		errors('Ввести корректные имя и фамилию !');
		return false;
	}	
	return true;
}

//проверка корректности названия существующей  статьи
function correct_title($title){
	$title = trim($title);
	return preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $title);			
}

//проверка корректности контента текста статьи
function correct_content($content){
	if(mb_strlen($content)<100 || (!preg_match('/^([а-яА-Яa-zA-ZёЁІіЇїЄєҐґ\'\d\-\s\!?;:.,-])/', $content)))
	{
		errors('Не менее ста знаков  и корректный текст в контенте!');
		return false;
	}
	return true;
}

//проверка наличия ДОБАВЛЯЕМОГO поля УНИВЕРСАЛЬНАЯ
function correct_origin($id, $table, $param, $text){
	// $query = db_query("SELECT  $id FROM $table,  WHERE $param = '$original';");
	$query = db_query("SELECT  $id FROM $table  WHERE $param = '$text';");
	//переменная айдишника для имени и фамилии автора
	$id_original = $query->fetchColumn();	
	//если айдишник не пустой значит такой автор уже есть
	if (!$id_original == "")
	{
		errors('Название занято!');
		return false;
	}
	return true;
}

//УНИВЕРСАЛЬНАЯ проверка корректности получаемого айдишника сущности, то есть его наличие
function correct_id($text, $table, $param, $id ){
	//получаем массив айдишников категории новости
	$query = db_query("SELECT $text FROM $table WHERE $param = '$id';");
//пременаая с названием категории
	$cat = $query->fetchColumn();
//если переданного айдишника нет, значит нет и категории(пустая),  значит пишем ошибку
	if($cat == "")
	{
		errors('Нерный код, введите корректный числовой код !');
		return false;
	}
	return true;
}

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


                          // Б А З А     Д А Н Н Ы Х 
//функция для подключения соеденения  с базой данных , для постоянного подключения используем СТАТИК для пременной $db
function db_connect(){
	static $db;

	if($db === null){
		$db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
		$db->exec('SET NAMES UTF8');
	}
	return $db;
}

//проверка запроса на ошибки в теле запроса, используем константу безошибочности PDO::ERR_NONE, которая равна 00000, и будет сравниваться с массивом по разбору возможных ошибок. константу вместо её значения 00000 используем потому, что с обновлением версии PHP её значение может измениться на другое.
function db_check_error($query){
	$info = $query->errorInfo();
	//если данные из массива возможных ошибок не равны константе PDO::ERR_NONE, то есть при наличии ошибки скрипт прекращает свою работу
	if($info[0] != PDO::ERR_NONE){
		exit($info[2]);
	}
}

//функция работы с запросом, в параметре передается тело запроса и параметры для подстановки в тело запроса в виде массива(по умолчанию пустой, и поэтому не всегда указывается )
function db_query($sql, $params = []){
//создаем объект для подключения к базе данных  с помощью функции db_connect
	$db = db_connect();
//подготовка запроса
	$query = $db->prepare($sql);
//готовый выполненный запрос с параметрами , который можно впоследствии выводить для SELECT с помощью fetch , fetchAll
	$query->execute($params);
	//проверка тела запроса на ошибки с помощью функции db_check_error
	db_check_error($query);
	return $query;
}

//создание статьи путем вставки запроса и массива значений для подстановки в запрос С ПОЛУЧЕНИЕМ ЗНАЧЕНИЯ ПОСЛЕДНЕГО ВВЕДЕННОГО АЙДИШНИКА
	function db_query_add_article($sql, $params = []){		
		db_query($sql, $params);
		$db = db_connect();
		return $new_article_id = $db->lastInsertId();

	}