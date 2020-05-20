<?php
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя из функции
$login = isName();
//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  $_SESSION['returnUrl'] = "/index.php?c=add-text";
  Header('Location: index.php?c=login');
}
//создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/assest/img/';
$dir_img =  'D:/open-server/OSPanel/domains/blog/assest/img';
$img_files = scandir($dir_img);
//создаем пустой массив для картинок
$images = [];
$images = $img_files;
//получение параметров с формы методом пост
if(count($_POST) > 0){
  $id_text = trim($_POST['id_text']);
  $text_content = trim($_POST['text_content']);
  $description = trim($_POST['description']);
//проверяем корректность вводимого названия 
  // if(!correct_name($text_content))
  // {   
  //   $msg = errors();
  // } 
  //проверяем незанятость данного названия(для пользователя)
  if (!correct_origin( 'id_text', ' texts ', ' id_text ', $id_text))
  {
    $msg = errors();
  }   
  else{
    //подключаемся к базе данных через  функцию db_query_add и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции, после 
    //добавления данных в базу функция вернет значение последнего введенного айдишника в переменную  $new_text_id, которую будем использовать для просмотра новой статьи при переходе на страницу post.php
    $new_text_id = db_query_add("INSERT INTO `texts`( `id_text` , `text_content`, `description`) VALUES (:i,:n,:d)", [
      'i'=>$id_text,
      'n'=>$text_content,
      'd'=>$description
    ]);    
    header("Location: " . ROOT . "texts/$new_text_id");
    exit();
  }
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
  $id_text = "";
  $text_content = '';
  $description = '';
  $msg = '';
}
$inner = template('v_add-text',  [
  'isAuth' => $isAuth ,
  'id_text' => $id_text,
  'text_content' => $text_content,
  'images' => $images,
  'description' => $description,
  'msg' => $msg
]);
$title = 'НОВЫЙ ТЕКСТ';
?>
