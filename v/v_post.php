<?php	 
//ВАЛИДАЦИЯ проходим циклом по массиву чтоб достать нужные нам поля таблицы  -->
    foreach($my_article as $art)  { 
  	//задаем переменную для названия
		$title = $art['title'];
		$date = $art['date'];
		$name = $art['name'];
		$title_category = $art['title_category'];
		$content = $art['content'];
	}?>
 <p><a href="index.php">На главную</a></p>
 <!-- выводим название статьи и текст статьи -->
  <h3><?=$title?></h3>	
      <span>Автор:</span><STRONG><?=$name?></STRONG>	
  <br>
  <em><span>Дата:</span><?=$date?></em>	
  <br>
     <em><span>Рубрика:</span><?=$title_category?></em>	
  <br>
  <hr>
	<div><?php echo $content?></div>

