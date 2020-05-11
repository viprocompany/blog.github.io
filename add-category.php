<?php
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя из функции
$login = isName();
//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/add-category.php";
  $_SESSION['returnUrl'] = "/add-category.php";
  Header('Location: login.php');
}
//получение параметров с формы методом пост
if(count($_POST) > 0){
  $title_category = trim($_POST['title_category']);
//проверяем корректность вводимого названия 
  if(!correct_name($title_category))
  {   
    $msg = errors();
  } 
  //проверяем незатанятость данного названия(для категории статьи)
  elseif (!correct_origin( 'id_category', 'categories', 'title_category', $title_category))
  {
   $msg = errors();
  }  
  else{
    //подключаемся к базе данных через  функцию db_query_add_article и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
    //добавления данных в базу функция вернет значение последнего введенного айдишника в переменную new_article_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
    $new_category_id = db_query_add("INSERT INTO `categories`( `title_category`) VALUES (:n);",
      [
        'n'=>$title_category
      ]);
    header("Location: /categories.php?id_category=$new_category_id");
     // header("Location: /blog/categories.php?id_category=$new_category_id");
    exit();
  }
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
  $title_category = "";
  $msg = '';
}
include_once('v/v_add-category.php');

?>
