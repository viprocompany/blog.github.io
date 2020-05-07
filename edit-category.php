<?php
include_once('functions.php');
// получение данных на форму для изменения 
// из адресной строки берем getпараметр id_article и принимаем его как значение названия статьи выведенной для изменения
$msg = 'ПРИВЕТ!';
global $id_category;
$id_category = $_GET['id_category'] ?? null;

// if($id_category === null)
// {
//   $title_category = "";
//    $msg = 'Ошибка 404, не выбрана категория!';   
// } 
    //проверяем корректность вводимого айдишника
if(!correct_id('title_category', 'categories', 'id_category', $id_category ))
{   
  $msg = errors();
  $title_category = "";
}
else{
//создаем соеденение с базой, делаем запрос на выбор автора по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса      
  $query = db_query("SELECT * FROM categories  WHERE  id_category = '$id_category';");
//создаем массив из cтатей нашего блога
  $my_category = $query->fetch();
    //задаем переменную для названия
  $title_category = $my_category['title_category'];

  if($title_category === null){
     $msg = 'Ошибка 404, не выбрана категория!';
    $title_category = "";
  } 
// функция correct_title для проверки корректоности названия статьи из файла functions.php
  elseif(!correct_title($title_category)){
    $msg =  'Неверное имя!'; 
  }  
}

session_start();
//проверка авторизации
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
  // $_SESSION['returnUrl'] = "/blog/add-category.php";
  $_SESSION['returnUrl'] = "/edit-category.php?id_category=$id_category";
  Header('Location: login.php');
}
//сохранение измененных данных
if(count($_POST) > 0 ){
  $title_category_new = trim($_POST['title_category']);
  // $id_user = trim($_POST['id_user']);
//проверяем корректность вводимого названия 
  if(!new_correct_title($title_category_new))
  {   
    $msg = errors();
  } 
  //   elseif($title_category_new != $title_category)
  // {   
  //   $msg = 'Название менять нельзя';
  // } 
  
//проверяем корректность вводимого айдишника
  elseif(!correct_id('title_category', 'categories', 'id_category', $id_category ))
  {   
    $msg = errors();
  }
  else{
//подключаемся к базе данных и предаем тело запроса в параметре, которое будет проверяться на ошибку с помощью этой же функции
    $query = db_query("UPDATE `categories` SET  `title_category`=:n  WHERE `id_category`=:id" ,[
      'n'=>$title_category_new,
      'id'=>$id_category
    ]
  );
//по айдишнику созданной   cтатьи из нашего блога переходим к просмотру
    header("Location: /categories.php?id_category=$id_category");
  // header("Location: /blog/categories.php?id_category=$id_category");
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
  <h4>РЕДАКТИРОВАТЬ КАТЕГОРИЮ</h4>
  <form method="post">  
    <p><span>Номер категории: </span><?php  echo $id_category; ?></p> 
    название<br>
    <input type="text" name="title_category" value="<?php  echo $title_category; ?>"><br>
    <input type="submit" value="Применить">
  </form>
  <p><?php echo $msg; ?></p>
<?php }?>

