<?php  
include_once('functions.php');

session_start();
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
	//имя пользователя для вывода в приветствии
$login = isName();
//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции

$query = db_query("SELECT id_article, title,  name, content, date, title_category  FROM article INNER JOIN categories ON article.id_category = categories.id_category INNER JOIN users ON  users.id_user = article.id_user WHERE date>'2020-04-30' ORDER BY date DESC;");
//создаем массив из cтатей нашего блога
$my_articles = $query->fetchAll();

// <!-- проверка авторизации на сессию либо куки
// подтверждаем авторизацию с помощью сессии -->
if($isAuth) { ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login;?> !</h4>
	<!-- ссылка для выхода авторизованного пользователя -->
	<a href="login.php"><h5>Выход</h5></a>
	<!-- ссылка для добавления статьи авторизованным пользователем -->
	<a href="add.php">Добавить статью</a><br>
	<a href="add-user.php">Добавить автора</a><br>
	<a href="add-category.php">Добавить категорию новостей</a><br>
<?php } echo	"<br>"; ?>
<a href="users.php">Авторы  </a><span>...</span>
<a href="categories.php">  Категории новостей</a><br><br>
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
<?php echo	"<br>";?>  



