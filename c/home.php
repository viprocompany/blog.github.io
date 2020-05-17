<?php  
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
	$_SESSION['returnUrl'] = ROOT;
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
//include_once('v/v_post.php');
			$inner = template( $template, [
				'my_articles' => $my_articles,
				'isAuth' => $isAuth
					]);
	$title = 'ГЛАВНАЯ';
?>

