<?php
$msg = '';
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора" 
 // $_SESSION['returnUrl'] = "/blog/categories.php";
  // Header('Location: login.php');
  //старые ссылки c контроллером index.php?c= до введения ЧПУ
   // $_SESSION['returnUrl'] = "index.php?c=categories";
    $_SESSION['returnUrl'] = ROOT . "categories";
}
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла
// $id_category = $_GET['id_category'] ?? null;
  // Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_category = $params[1] ?? null; 
// echo $id ;
$err404 = false;
if(isset($id_category ) && correct_id('title_category', 'categories', 'id_category', $id_category ))
{//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса  
$query = select_table(' * ', ' categories ', " WHERE  id_category = '$id_category' ");    
//задаем переменную для названия  
  $category = $query->fetch();
  $title_category = $category['title_category'];
      //проверяем корректность вводимого айдишника
    // if(!correct_id('title_category', 'categories', 'id_category', $id_category ))
    // {   
    //   $msg = errors();
    // }
// функция correct_name для проверки корректоности имени автора проверяем корректность вводимого имени 
    if(!correct_name($title_category))
    {   
      $msg = errors();
    } 
// include('v/v_categories_new.php');
//при добавлении нового категории будет создаваться переменная шаблона для вывода данных о новом авторе , которая далее будет добавлена в массив переменных шаблона v_main
    
        $inner_categories_new = template('v_categories_new',  [
        'id_category' => $id_category,
        'title_category' => $title_category
      ]);     
  
}
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса     
$query = select_table(' title_category , id_category ', ' categories ', " ORDER BY title_category ");   
//задаем переменную для названия  
  $categories= $query->fetchAll();
 
 //создаем переменные в виде шаблонов из кода разметки и прередаем в выбранные вьюшки значения  isAuth,login,msg,users из  файла users.php : 1. v_auth  для вывода представления авторизации и 2. v_users для вывода общего списка авторов
   // // include('v/v_auth.php');
   //    $inner_auth =  template('v_auth' , [
   //      'isAuth' => $isAuth,
   //      'login' => $login,
   //      'msg' => $msg
   //    ]);
  
  // include('v/v_categories.php');
        $inner = template('v_categories',  [
        'isAuth' => $isAuth,
        'categories' => $categories
      ]);
        $title = 'КАТЕГОРИИ';
        $new_row = $inner_categories_new;
//подставляем переменные разметки  $inner_auth и $inner_categories в код главной страницы v_main для вывода на экран. значение title как и любое другое можно задать вручную без переменных 
      // echo template('v_main', [
      //   'title'=> 'КАТЕГОРИИ',
      //   'content'=> $inner_categories,
      //   'auth'=> $inner_auth,
      //   'new_row'=> $inner_categories_new
      // ]); 
  ?>