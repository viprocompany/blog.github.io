<?php
include_once('functions.php');

$msg = 'ПРИВЕТ!';

session_start();

//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла 
$id_category = $_GET['id_category'] ?? null;
if(isset($id_category )){
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса      
  $query = db_query("SELECT  * FROM categories  WHERE  id_category = '$id_category';");
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
    ?>
    <a href="categories.php">Все категории</a>
    <!-- выводим название статьи и текст статьи -->
    <h4>Новая категория</h4>
    <span>Нормер: <?=$id_category?></span><br>  
    <span>Название :</span><strong> <?php echo $title_category?></strong>
     
    <hr>
  <?php }}?>
  <p><?php echo $msg?></p>  
  <a href="index.php">На главную</a><br>
  <?php   if($isAuth) { ?>
    <a href="add-category.php">Добавить категорию новостей</a><br>
    <hr>

  <?php }
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса      
  $query = db_query("SELECT  title_category, id_category FROM categories ORDER BY title_category;");
//задаем переменную для названия  
  $categories= $query->fetchAll();
  //проходим циклом по массиву чтоб достать нужные нам поля таблицы
  foreach ($categories as $cat) {
    $id_category = $cat['id_category'];
    ?>
    <span>Категория новостей: <strong><?=$cat['title_category']?></strong></span> 
    <span>порядковый нормер категории: </span><strong> <?=$cat['id_category']?></strong>
    <?php if($isAuth) { ?>
      <a href="edit-category.php?id_category=<?=$id_category?>">EDIT</a>
    <?php }  ?>    
    <hr>
  <?php }?>