<?php if($isAuth) { ?>
  <h3>РЕДАКТИРОВАТЬ ТЕКСТ</h3>
  <hr>
  <form method="post">
    ИМЯ (не редактируется)<br>
    <span type="text" name="id_text" value=""><?php  echo $id_text; ?></span><br><br>
    ТЕКСТ: <br>
    <input type="text" name="text_content" value="<?php  echo $text_content; ?>"><br>
    (просмотр папки с файлами изображений)<br>
    <select name="img_content" class="img inp" >
      <?php foreach ($images as $f) {   
      $images[] = $f;?>
      <option value="<?php echo $f ?>">
        <?php  echo $f?>        
      </option>
  <?php } ?> 
  </select><br>
<!--     <input type="text" name="img_content" value="<?php  echo $img_content; ?>"><br> -->
    ОПИСАНИЕ: <br>
    <textarea  name="description" ><?php  echo $description; ?></textarea><br>
    <input class="btn btn-success" type="submit" value="Добавить">

  </form> 
<?php }?>
<p><?php echo $msg; ?></p>