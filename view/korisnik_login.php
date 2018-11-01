<?php require_once 'view/_header.php'; ?>

<br><br><br>
<div class="login_form">
  <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=korisnik/login'?>">
    Korisničko ime:<br>
    <input type="text" name="korisnik_name"><br>
    Lozinka:<br>
    <input type="password" name="password"><br>
    <input class="submit" type="submit" value="Ulogiraj se!">
  </form>
  <?php
    if($error != NULL ) echo '<p>' . $error . '</p>';
  ?>
</div>

<?php require_once 'view/_footer.php'; ?>
