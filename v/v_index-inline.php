<p><a href="index.php?view=base">Отобразить нормально</a><span>...</span><a href="index.php?view=inline">Отобразить в линию</a></p>
<?php 
if(!$isAuth){?>
<p><a href="login.php">Войти</a></p>
<?php }?>
<?php  foreach($my_articles as $message)  {  $id_article = $message['id_article'];  ?>
<div>	
	<strong><?=$message['title']?></strong>
	<em><?=$message['date']?></em>         
	<em>автор: </em>
	<em><?=$message['name']?></em>         
	<em>рубрика: </em>
	<em><?=$message['title_category']?></em> 
	<!-- <div><?=$message['content']?></div> -->	 
	<a href="post.php?id_article=<?=$id_article;?>">ЧИТАТЬ</a>
	<?php if($isAuth) { ?>
		<a href="edit.php?id_article=<?=$id_article?>">EDIT</a>
	<?php }  ?>        
</div>
<hr>
<?php } ?>