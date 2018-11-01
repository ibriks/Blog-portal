<?php

class IndexController
{
	public function index()
	{
		header( 'Location: ' . __SITE_URL . '/index.php?rt=blog' );
	}
};

?>
