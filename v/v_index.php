<p><a class="btn btn-outline-secondary" href="<?php echo ROOT?>home?view=inline">Отобразить в линию</a></p>
<div>	
	<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
<!-- 	<p><a class="btn btn-outline-secondary" href="index.php?c=home&view=inline">Отобразить в линию</a></p>
	<div>	 -->
	<?php  foreach($my_articles as $message)  {  $id_article = $message['id_article'];  ?>
	<div>	
		<strong><?=$message['title']?></strong><br>
		<em><?=$message['date']?></em><br>         
		<em>автор: </em>
		<em><?=$message['name']?></em><br>         
		<em>рубрика: </em>
		<em><?=$message['title_category']?></em><br> 
		<!-- <div><?=$message['content']?></div> -->	
		<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ --> 
		<!-- <a class="btn btn-success" href="index.php?c=post&id_article=<?=$id_article;?>">ЧИТАТЬ</a> -->
		<a class="btn btn-success" href="<?php echo ROOT?>post/<?=$id_article;?>">ЧИТАТЬ</a>
		<?php if($isAuth) { ?>
			<!-- старые ссылки до приведение к человекочитаемым урлам ЧПУ -->
		<!-- 	<a class="btn btn-outline-warning" href="index.php?c=edit&id_article=<?=$id_article?>">Изменить</a> -->
			<a class="btn btn-outline-warning" href="<?php echo ROOT?>edit/<?=$id_article?>">Изменить</a>
		<?php }  ?>        
	</div>
	<hr>
<?php } ?>
</div>