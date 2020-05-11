 <?php  
   //проходим циклом по массиву чтоб достать нужные нам поля таблицы
  foreach ($categories as $cat) {
    $id_category = $cat['id_category'];
    ?>
    <span>Категория новостей: <strong><?=$cat['title_category']?></strong></span> 
    <span>код категории: </span><strong> <?=$cat['id_category']?></strong>
    <?php if($isAuth) { ?>
      <a href="edit-category.php?id_category=<?=$id_category?>">EDIT</a>
    <?php }  ?>    
    <hr>
  <?php }