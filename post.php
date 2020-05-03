<?php
include_once('functions.php');
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла 
$id_article = $_GET['id_article'] ?? null;
  	if($id_article === null){
	echo 'Ошибка 404, не выбрана статья';
}	
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса			
$query = db_query("SELECT id_article, title,  content FROM article  WHERE  id_article = '$id_article';");
//создаем массив из cтатей нашего блога
	$my_article = $query->fetchAll();
	//проходим циклом по массиву чтоб достать нужные нам поля таблицы
  foreach($my_article as $art)  { 
  	//задаем переменную для названия
  	$title = $art['title'];
//  if($title === null){
// 	echo 'Ошибка 404, не выбрана статья';
// }	
// функция correct_title для проверки корректоности названия статьи из файла functions.php
if(!correct_title($title)){
	echo 'Кривое название !';	
}
// elseif(!file_exists('data/' . $title)){
// 	echo 'Ошибка 404. Нет такой статьи!';
// }
 ?>
 <a href="index.php">На главную</a><br>
 <!-- выводим название статьи и текст статьи -->
  <strong><?=$art['title']?></strong>	
  <hr>
	<div><?php echo $art['content']?></div>
	<?php }?>
