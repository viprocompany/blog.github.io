<?php  
//объявляем константу для переменной корня сайта для подстановки на ссылках сайта после перехода на человекочитаемые урлы
define('ROOT','/');
// define('ROOT','http://blog/');
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
include_once('m/system.php');

//переписываем урлы . В файле .htaccess задали название(php1chpu) значения, которое будет дописываться в конце адреса урла. Задаем переменную params которая будет добавлять значение полученное из php1chpu после слеша в адрес , если было передано такое  значение 
	$params = explode('/', $_GET['php1chpu']);
	// var_dump($params);
//значение последнего параметра в массиве $_GET.
	$end = count($params) - 1;
	// Если после слеша ничего нет ,то этот параметр будет удален из массива $_GET. Это делается для того чтобы независимо от того есть в конце адреса слеш или нет он будет  считаться одним и тем же адресом.
	if($params[$end] === ''){
		unset($params[$end]);
//соответственно уменьшаем номер последнего элемента массива
		$end--;
	}

session_start();

$texts = textsStatic('id' , $text);
// echo($texts);
	// var_dump($params);
// echo $params[1];

$title = '';
$inner = '';
$err404 = false;
// делаем переменную для выбора контроллера по информации из адресной строки -первый элемент после слеша $params[0], если он не задан выбираем контроллер главной страницы home То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null;  и сделать ветвление для проверки :
// if($id === null || $id == ''){
// 	$err404 = true;
// }
//сделать нужно в контролерах post  и всех контролерах edit 
$controller = trim($params[0] ?? 'home');
//прорверку контроллера на название  и ошибку
// (!file_exists("c/{$controller}.php")
if($controller === '' || !file_exists("c/{$controller}.php") || !preg_match("/^[a-zA-Z0-9_-]+$/", $controller))
{
	$err404 = true;
}
else
{
	include_once("c/$controller.php");
}	
// <!-- проверка авторизации на сессию либо куки
// подтверждаем авторизацию с помощью сессии -->
// include('v/v_auth.php');
//передаем переменные в виде шаблонов из кода разметки и прередаем в выбранные вьюшки значения  isAuth,login,msg. v_auth  для вывода представления авторизации
$inner_auth =  template('v_auth', [
	'isAuth' => $isAuth,
	'login' => $login
				// ,				'msg' => $msg
]);	

if($err404){
		// header("HTTP 1.1 Not Found");
	$title = 'Ошибка 404';
	$inner = template('v_error');

}
	//выводим итоговый шаблон v_main из переменных-шаблонов для разметки title, content, auth, new_row, error.
echo template('v_main', [
	'title'=> $title,
	'content'=> $inner,
	'auth'=> $inner_auth,
	'new_row'=> $new_row,
	// substr($texts, 0, -1),
	'error'=> $error,
	$texts
	// 'image_footer'=> 'footer.jpg','image_header'=> 'header.jpg','image_mail'=> 'mail.png','instagram'=> 'instagram.jpg','title_1'=> 'PHP','title_2'=> 'Первый уровень PHP','vk'=> 'vk.jpg'
]);

?>