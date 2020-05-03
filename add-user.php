<?php
include_once('functions.php');

session_start();

//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
	$_SESSION['returnUrl'] = "add-user.php";
	Header('Location: login.php');
}

//получение параметров с формы методом пост
if(count($_POST) > 0){
	$name = trim($_POST['name']);
//проверяем корректность вводимого названия 
	if(!correct_name_user($name))
	{		
		$msg = errors();
	}	
	elseif(!correct_origin_name_user($name))
	{		
		$msg = errors();
	}		
	else{
//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
		$query = db_query("INSERT INTO `users`( `name`) VALUES (:n);",
			['n'=>$name]);
//получаем ячейку айдишника созданной   cтатьи из нашего блога
		$query = db_query("SELECT id_user FROM users  WHERE  name = '$name';");
		$id_user = $query->fetchColumn();
		
		header("Location: /users.php?id_user=$id_user");
		exit();
	}
}
else{
//если данные в инпуты не вводились, задаем пустые значения инпутов формы для того чтобы через РНР вставки в разметке кода не выскакивали(на странице в полях инпутов для заполнения) нотации об отсутствии данных в переменных $title и $content
	$name = "";
	$msg = '';
}

if($isAuth) { ?>
	<!-- приветствие аутентифицированного пользователя  -->
	<h4>Добро пожаловать, <?php echo $login?> !</h4>
<?php } ?>
<a href="index.php">На главную</a><br>
<h3>ДОБАВИТЬ АВТОРА</h3>
<form method="post">
	ФИО  автора<br>
	<input type="text" name="name" value="<?php  echo $name; ?>"><br>
	<input type="submit" value="Добавить">
</form>
<?php echo $msg; ?>
