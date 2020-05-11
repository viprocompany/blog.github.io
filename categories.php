<?php
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
$msg = '';
session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла 
$id_category = $_GET['id_category'] ?? null;
if(isset($id_category ))
{//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса  
$query = select_table(' * ', ' categories ', " WHERE  id_category = '$id_category' ");    
//задаем переменную для названия  
  $category = $query->fetch();
  $title_category = $category['title_category'];
  $id_category = $category['id_category'];
  {     //проверяем корректность вводимого айдишника
    if(!correct_id('title_category', 'categories', 'id_category', $id_category ))
    {   
      $msg = errors();
    }
// функция correct_name для проверки корректоности имени автора 
//проверяем корректность вводимого имени 
    elseif(!correct_name($title_category))
    {   
      $msg = errors();
    } 
    include('v/v_categories_new.php');
  }
}
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса     
$query = select_table(' title_category , id_category ', ' categories ', " ORDER BY title_category ");   
//задаем переменную для названия  
  $categories= $query->fetchAll();
  include('v/v_auth.php');
  include('v/v_categories.php');
  ?>