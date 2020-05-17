<?php  
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
include_once('m/system.php');
session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
	$_SESSION['returnUrl'] = "/index.php";
		// $_SESSION['returnUrl'] = "/blog/index.php";
	// Header('Location: login.php');
}
//имя пользователя для вывода в приветствии
$login = isName();
//подключаемся к базе данных и предаем составляющие тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
$query = select_tables_all('id_article, title,  name, content, date, title_category','WHERE date>\'2020-04-30\'','ORDER BY date DESC');
//создаем массив из cтатей нашего блога
$my_articles = $query->fetchAll();

//выбираем вьюшку для вывода: либо столбиком либо в одну строку. создаем $template  для дальнейшей подстановки при выводе нужного представления через include
switch ($_GET['view'] ?? null) {
	case 'base':
		$template = 'v_index';
		break;
		case 'inline':
		$template = 'v_index-inline';
		break;	
	default:
		$template = 'v_index-inline';
		break;
}
// <!-- проверка авторизации на сессию либо куки
// подтверждаем авторизацию с помощью сессии -->

// include('v/v_auth.php');
	$inner_auth =  template('v_auth', [
				'isAuth' => $isAuth,
				'login' => $login,
				'msg' => $msg
			]);			
//include_once('v/v_post.php');
			$inner_index = template( $template, [
				'my_articles' => $my_articles,
				'isAuth' => $isAuth
					]);
			echo template('v_main', [
				'title'=> 'ГЛАВНАЯ',
				'content'=> $inner_index,
				'auth'=> $inner_auth
			]);

//выводим представление для индекс-страницы
// include ("v/$template.php");
?>

