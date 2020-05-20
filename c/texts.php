<?php
$msg = '';
//вводим переменную $isAuth  что бы знать ее значение и какждый раз не делать вызов функции isAuth() 
$isAuth = isAuth();
//имя пользователя для вывода в приветствии
$login = isName();
//проверка авторизации
if(!$isAuth)
{
//ПЕРЕДАЧА ИНФОРМАЦИИ С ОДНОЙ СТРАНИЦЫ НА ДРУГУЮ ЧЕРЕЗ СЕССИЮ : в массив сессии  добавляем элемент указывающий куда перейдет клиент после авторизации в файле login.php, если он заходил после клика на "ДОБАВИТЬ автора"
$_SESSION['returnUrl'] = ROOT . "texts";
  // Header('Location: login.php');
}
//получаем ГЕТ параметр из адресной строки при переходе из индексного файла 
// $id_user = $_GET['id_text'] ?? null;
  // Разрешаем указать параметр после заданного контролера в урле .То есть на первом месте всегда располагается название контролера, а после слеша могут добавиться еще параметр как в данном случае  для чего в контроллере , где может добавляться айдишник нужно прописать этот дополнительный параметр как $id = $params[1] ?? null; 
$id_user = $params[1] ?? null; 
// echo $id ;
$err404 = false;
if(isset($id_text ) && correct_id('text_content', 'texts', 'id_text', $id_text ))
{//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса      
  $query = select_table(' * ', ' texts ', " WHERE  id_text = '$id_text' "); 
//задаем переменную для названия  
  $text = $query->fetch();
  $id_text = $text['id_text'];
  $text_content = $text['text_content'];
  // $img_content = $text['img_content'];
  $description = $text['description'];
  { //проверяем корректность вводимого айдишника
    // if(!correct_id('name', 'users', 'id_user', $id_user ))
    // {   
    //   $msg = errors();
    // }
// функция correct_name для проверки корректоности имени автора проверяем корректность вводимого имени 
    if(!correct_name($text_content))
    {   
      $msg = errors();
    } 
    }
  }
  //создаем массив сканирую директорию img
// $dir_img = $_SERVER['DOCUMENT_ROOT'] . 'assest/img';
// $dir_img =  'f:/OpenServer/OSPanel/domains/blog/assest/img/';
$dir_img =  'D:/open-server/OSPanel/domains/blog/assest/img';
$img_files = scandir($dir_img);
//создаем пустой массив для картинок
$images = [];
$images = $img_files;
//создаем соеденение с базой, делаем запрос на выбор статьи по пререданному с индексной строки айдишнику, попутно в этой же функции проверяем коррктность тела запроса    
  $query = select_table(' * ', ' texts ', " ORDER BY id_text ASC ");  
//задаем переменную для названия  
  $texts= $query->fetchAll();
  // //создаем переменные в виде шаблонов из кода разметки и прередаем в выбранные вьюшки значения  isAuth,login,msg,users из  файла users.php : 1. v_auth  для вывода представления авторизации и 2. v_users для вывода общего списка авторов
        $inner = template('v_texts',  [
        'isAuth' => $isAuth,  
        'texts' => $texts,
        'images' => $images
      ]);
        $title = 'СТАТИЧЕСКИЕ ТЕКСТЫ'; 
?>
  
  