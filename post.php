<?php
include_once('m/auth.php');
include_once('m/validate.php');
include_once('m/db.php');
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла
// global  $id_article;
$id_article = $_GET['id_article'] ?? null;
$err404 = false;
if($id_article === null )
{
	$err404 = true;
	echo 'Ошибка 404, не выбрана статья!';
}	
else{
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса
 $query = select_tables_all('id_article, title,  name, content, date, title_category' ,"WHERE  id_article ='$id_article'");
//создаем массив из cтатей нашего блога
	$my_article = $query->fetchAll();  
	if(!$my_article)
	{
		$err404 = true;
		echo 'Ошибка 404, нет такой страницы!';
	}
	else{
		include_once('v/v_post.php');
	}
}
?>
	