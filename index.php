<?php  
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
//подключаемся к базе данных и предаем составляющие тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
// include_once('m/db.php');
$query = select_tables_all('id_article, title,  name, content, date, title_category','WHERE date>\'2020-04-30\'','ORDER BY date DESC');
//создаем массив из cтатей нашего блога
$my_articles = $query->fetchAll();
// <!-- проверка авторизации на сессию либо куки
// подтверждаем авторизацию с помощью сессии -->
include('v/v_auth.php');
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
//выводим представление для индекс-страницы
include ("v/$template.php");

?>

