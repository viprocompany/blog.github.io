<?php
include_once('functions.php');
// получение данных на форму для изменения 
// из адресной строки берем getпараметр id_article и принимаем его как значение названия статьи выведенной для изменения
$msg = 'ПРИВЕТ!';
$id_user = $_GET['id_user'] ?? null;
// echo $id_user;
if($id_user === null)
{
  echo 'Ошибка 404, не выбрана статья';
  $name = "";
} 
    //проверяем корректность вводимого айдишника
elseif(!correct_id('name', 'users', 'id_user', $id_user ))
{   
  $msg = errors();
  $name = "";
  // $id_user ="";
}
else{
//создаем соеденение с базой, делаем запрос на выбор автора по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса      
$query = db_query("SELECT * FROM users  WHERE  id_user = '$id_user';");
//создаем массив из cтатей нашего блога
$my_users = $query->fetchAll();
  // var_dump(  $my_article);
  //проходим циклом по массиву чтоб достать нужные нам поля таблицы
foreach($my_users as $user)  { 
    //задаем переменную для названия
  global $id_user;
  $id_user = $user['id_user'];
  $name = $user['name'];

  if($name === null){
    echo 'Ошибка 404, не выбран автор!';
    $name = "";
  } 
// функция correct_title для проверки корректоности названия статьи из файла functions.php
  elseif(!correct_title($name)){
    echo 'Неверное имя!'; 
  }
  }
}

session_start();
//проверка авторизации
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//проверка авторизации
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 

if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/edit-user.php?id_user=$id_user";
  $_SESSION['returnUrl'] = "/edit-user.php?id_user=$id_user";
  Header('Location: login.php');
}
//сохранение измененных данных
if(count($_POST) > 0 ){
  $name_new = trim($_POST['name']);
  // $id_user = trim($_POST['id_user']);
//проверяем корректность вводимого названия 
  if(!new_correct_title($name))
  {   
    $msg = errors();
  } 
  //   elseif($title_new != $name)
  // {   
  //   $msg = 'Название менять нельзя';
  // } 
  
//проверяем корректность вводимого айдишника
elseif(!correct_id('name', 'users', 'id_user', $id_user ))
{   
  $msg = errors();
}
else{
//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
  $query = db_query("UPDATE `users` SET  `name`=:n  WHERE `id_user`=:id" ,[
    'n'=>$name_new,
    'id'=>$id_user
  ]
);
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
  header("Location: /users.php?id_user=$id_user");
  // header("Location: /blog/users.php?id_user=$id_user");
  exit();
}
}

if($isAuth)
{//имя пользователя для вывода в приветствии
  $login = isName();
      //приветствие аутентифицированного пользователя
  $welcome = '<h4>Добро пожаловать, ' . $login  .' !</h4>';
  // echo применять здесь нельзя, так как после него не будут работать header(location)
?>
<p><?php echo $welcome; ?></p>
<a href="index.php">На главную</a><br>
<h4>РЕДАКТИРОВАТЬ АВТОРА</h4>
<form method="post">  
  <p><span>Номер автора: </span><?php  echo $id_user; ?></p> 
  ФИО  автора<br>
  <input type="text" name="name" value="<?php  echo $name; ?>"><br>
  <input type="submit" value="Применить">
</form>
<p><?php echo $msg; ?></p>
<?php }?>

