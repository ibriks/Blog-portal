<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>Blog portal</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<br><br>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">

          <a class="navbar-brand" href="<?php echo __SITE_URL; ?>/index.php?rt=blog">Blog portal</a>
        </div>
				<ul class="nav navbar-nav">
					<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=blog">Home</a>
					<?php if ($_SESSION['id']['admin'] == 0 && $_SESSION['id']['korisnik_ime'] !== NULL)
					{
						echo '<li><a href="' . __SITE_URL . '/index.php?rt=blog/moj">My page</a></li>';
						echo '<li><a href="' . __SITE_URL . '/index.php?rt=korisnik/post">Add post</a></li>';
						echo '<li><a href="' . __SITE_URL . '/index.php?rt=korisnik/edit">Edit posts</a></li>';
					} ?>
					<?php if ($_SESSION['id']['admin'] == 1)
					{
						echo '<li><a href="' . __SITE_URL . '/index.php?rt=korisnik/admin">Delete</a></li>';
					} ?>
      		<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=blog/sve">Everything</a></li>

    		</ul>
        <div id="navbar" class="navbar-collapse collapse">
					<?php if ( isset($_SESSION['id']['korisnik_ime'])){ ?>
						<form class="navbar-form navbar-right" method="post" action="<?php echo __SITE_URL . '/index.php?rt=blog'?>">
	            <button class="btn btn-success" name="dugme" value="logout" >Log out</button>
	          </form>
						<div class="navbar-form navbar-right">
            	<?php  echo $_SESSION['id']['korisnik_ime']; ?>
            </div>

					<?php } else { ?>
          <form class="navbar-form navbar-right" method="post" action="<?php echo __SITE_URL . '/index.php?rt=korisnik/login'?>">
            <div class="form-group">
              <input type="text" name="korisnik_name" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
					<?php } ?>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>


</head>
<body>
