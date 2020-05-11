<p><a href="index.php?view=base">Отобразить нормально</a><span>...</span><a href="index.php?view=inline">Отобразить в линию</a></p>
<?php 
if(!$isAuth){?>
<p><a href="login.php">Войти</a></p>
<?php }?>
<div>	
<?php  foreach($my_articles as $message)  {  $id_article = $message['id_article'];  ?>
<div>	
	<strong><?=$message['title']?></strong><br>
	<em><?=$message['date']?></em><br>         
	<em>автор: </em>
	<em><?=$message['name']?></em><br>         
	<em>рубрика: </em>
	<em><?=$message['title_category']?></em><br> 
	<!-- <div><?=$message['content']?></div> -->	 
	<a href="post.php?id_article=<?=$id_article;?>">ЧИТАТЬ</a><span>...</span>
	<?php if($isAuth) { ?>
		<a href="edit.php?id_article=<?=$id_article?>">EDIT</a>
	<?php }  ?>        
</div>
<hr>
<?php } ?>
</div>