<?php
include_once('functions.php');
session_start();

//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла 
$id_user = $_GET['id_user'] ?? null;
if(isset($id_user )){
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса			
	$query = db_query("SELECT  name FROM users  WHERE  id_user = '$id_user';");
//задаем переменную для названия	
	$name = $query->fetchColumn();
	{   	
		if(!correct_user($id_user))
		{		
			$msg = errors();
		}
// функция correct_name_user для проверки корректоности имени автора 
//проверяем корректность вводимого имени 
		elseif(!correct_name_user($name))
		{		
			$msg = errors();
		}	
		?>
		<a href="users.php">Все авторы</a>
		<!-- выводим название статьи и текст статьи -->
		<h4>Новый автор</h4>
		<span>порядковый нормер: <?=$id_user?></span><br>	 
		<span>ФИО:</span><strong> <?php echo $name?></strong>
		<hr>
	<?php }}?>
	<p><?php echo $msg?></p>	
	<a href="index.php">На главную</a><br>
	<?php 	if($isAuth) { ?>
		<a href="add-user.php">Добавить автора</a><br>	
		<hr>

	<?php }
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса			
	$query = db_query("SELECT  name, id_user FROM users ORDER BY name;");
//задаем переменную для названия	
	$users= $query->fetchAll();
	//проходим циклом по массиву чтоб достать нужные нам поля таблицы
	foreach ($users as $user) {?>
		<span>ФИО: <strong><?=$user['name']?></strong></span> 
		<span>порядковый нормер: </span><strong> <?=$user['id_user']?></strong>
		<hr>
	<?php	}?>
	
	