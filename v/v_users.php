<?php  
	//проходим циклом по массиву чтоб достать нужные нам поля таблицы
	foreach ($users as $user) {
		$id_user = $user['id_user'];
		?>
		<span>ФИО: <strong><?=$user['name']?></strong></span> 
		<span>порядковый нормер: </span><strong> <?=$user['id_user']?></strong>
		<?php if($isAuth) { ?>
			<a href="edit-user.php?id_user=<?=$id_user?>">EDIT</a>
		<?php }  ?>    
		<hr>
	<?php	}