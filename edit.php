<?php
include_once('functions.php');
// получение данных на форму для изменения 
// из адресной строки берем getпараметр fname и принимаем его как значение названия статьи выведенной для изменения
$title = $_GET['fname'] ?? null;

if($title === null){
	$msg = 'Ошибка 404, не передано название';
}	//функция correct_title для проверки корректоности названия статьи из файла functions.php
elseif(!correct_title($title)){
	$msg = 'Статьи с таким названием не существует либо оно некорректно!';
}
elseif(!file_exists('data/' . $title)){
	$msg = 'Ошибка 404. Нет такой статьи!';
}
else{
	$content = file_get_contents('data/' . $title);
}


session_start();
//проверка авторизации
$isAuth = isAuth();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
if($isAuth)
{
			//имя пользователя для вывода в приветствии
	$login = isName();
			//приветствие аутентифицированного пользователя
	$welcome = '<h4>Добро пожаловать, ' . $login  .' !</h4>';
	// echo применять здесь нельзя, так как после него не будут работать header(location)

}
else
{
	//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда пойдет переход после авторизации в файле login.php после клика на EDIT к какой-то статье
	header('Location: login.php');
	exit();
}


//сохранение измененных данных
if(count($_POST) > 0){
	$title_edit = (trim($_POST['title']));
	$content_edit = trim($_POST['content']);
	if(!correct_title($title_edit)){
		$msg = 'Чушь какая-то!';
	}
				// проверка неизменности title				
	elseif($title != $title_edit ){
		$msg = 'Название статьи  менять нельзя!';
	}
	//если хотим изменить название статьи, проверяем что бы такого названия не было в базе
	// if(($title_edit == "") ||  (file_exists("data/$title"))){
	// $msg = 'Введите новое название!';
 // }
	// проверка корректности статьи
	elseif($content_edit == ''){
		$msg = 'Введите текст статьи!';
	}
	elseif(mb_strlen($content_edit)<2 || (!correct_content($content_edit))){
		$msg = 'Не менее двух знаков  и корректный текст в контенте!';
	}
	else{
			// сохранить статью в файл сначала удалив старый с таким же названием
		unlink("data/$title"); 
		file_put_contents("data/$title_edit" , $content_edit);	
		header("Location: /post.php?fname=$title");
		exit();
	}
}
// echo 'auth: ' . $isAuth ;
?>
<p><?php echo $welcome; ?></p>
<a href="index.php">На главную</a><br>
<h4>РЕДАКТИРОВАТЬ СТАТЬЮ</h4>
<form method="post">
	Название<br>
	<input type="text" name="title" value="<?php  echo $title; ?>"><br>
	Контент<br>
	<textarea name="content"><?php echo nl2br($content); ?></textarea><br>
	<input type="submit" value="Применить">
</form>
<?php echo $msg; ?><br>
