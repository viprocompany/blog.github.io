<?php
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
	//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ СТАТЬЮ"	
	// $_SESSION['returnUrl'] = "/blog/add.php";
	//старые ссылки c контроллером index.php?c= до введения ЧПУ
	// $_SESSION['returnUrl'] = "/index.php?c=add";
	// Header('Location: index.php?c=login');
	$_SESSION['returnUrl'] =  ROOT . "add";
	Header("Location: " . ROOT . " login");
}	
//задаем массив для дальнейшего вывода фамилий авторов в разметке через опшины селекта, после выбора автора из значения опшина подтянется айдишник автора для дальнейшего добавления в статью
	 $query= select_table('*', 'users', "ORDER by name ASC");
	 $names = $query->fetchAll();	
	 
//задаем массив для дальнейшего вывода категорий новостей в разметке через опшины селекта, после выбора категории из значения опшина подтянется айдишник категории для дальнейшего добавления в статью
   $query= select_table('*', 'categories', "ORDER by title_category ASC");
   $categories = $query->fetchAll(); 

//создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
$dir_img =  'D:/open-server/OSPanel/domains/blog/assest/img';
$img_files = scandir($dir_img);
//создаем пустой массив для картинок
$images = [];
$images = $img_files;


//получение параметров с формы методом пост
if(count($_POST) > 0){
	$title = trim($_POST['title']);
	$content = trim($_POST['content']);
	$id_category = trim($_POST['id_category']);
	$img = trim($_POST['image']);
	// $image = trim($_POST['image']);
	// айдишник получаем из значения value опшина после того как в выпадающем списке был выбран автор 
	$id_user = trim($_POST['name']);	
 //НЕ НУЖНО проверяем корректность вводимого айдишника СТАТЬИ
	// if(!correct_id('title', 'article', 'id_article', $id_article ))
	// {	
	// 	$msg = 'Нерный код статьи';
	// }	
//проверяем корректность вводимого названия 
	if(!new_correct_title($title))
	{		
		$msg = errors();
	}	
	// проверка названия на незанятость вводимого названия 
	elseif (!correct_origin('id_article', 'article', 'title', $title)) 
	{
		$msg = errors();
	}
 //проверяем корректность вводимого айдишника автора
	elseif(!correct_id('name', 'users', 'id_user', $id_user ))
	{   
		$msg = 'Неверный код автора';
	}	
//проверяем корректность вводимого айдишника категории новости
	elseif(!correct_id('title_category', 'categories', 'id_category', $id_category ))
	{   
		$msg = 'Неверный код категории новости';
	}
//проверяем корректность вводимого контента 
	elseif(!correct_content($content))
	{
		$msg = errors();
	}	
	else
	{
//подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
//добавление данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
		$new_article_id = db_query_add_article($title,$content, $id_user, $id_category, $img);	
		//header("Location: /blog/post.php?id_article=$new_article_id");
		//старые ссылки c контроллером index.php?c= до введения ЧПУ
		// header("Location: /index.php?c=post&id_article=$new_article_id");
			header("Location: " . ROOT . "post/$new_article_id");
		exit();
	}
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
	$title = "";
	$id_user = "";
	$name = "";
	$id_category = "";
	$content = "";
	$img = "";
	$msg = '';
} 
// // include('v/v_auth.php');
//  $inner_auth =  template('v_auth' , [
//  	'isAuth' => $isAuth,
//  	'login' => $login,
//  	 'msg' => $msg
//  ]);
  // include('v/v_add.php'); 
 $inner = template('v_add' , [
 	'isAuth' => $isAuth,
 	'title' => $title,
 	'id_user' => $id_user,
 	'id_category' => $id_category,
 	'content' => $content,
 	'names' => $names,
 	'categories' => $categories,
 	'img' => $img,
 	'images' => $images,
 	'msg' => $msg
 ]);
$title = 'НОВАЯ СТАТЬЯ';
// echo template('v_main', [
// 'title'=> 'Добавить статью',
// 'content'=> $inner_add,
// 'auth'=> $inner_auth
// ]);
 


?>
