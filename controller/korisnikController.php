<?php

class korisnikController extends BaseController
{
	public function index()
	{
		$this->registry->template->title = 'Login';

    $this->registry->template->error = NULL;

		$this->registry->template->show( 'korisnik_login' );
	}

  public function login()
  {
    if ( !isset($_POST["korisnik_name"]) || empty($_POST["korisnik_name"]) || !preg_match( '/[a-zA-Z0-9_]/', $_POST["korisnik_name"] )
    	||  !isset($_POST["password"]) || empty($_POST["password"]) || !preg_match( '/[a-zA-Z0-9_]/', $_POST["password"] ) )
    {

    	$this->registry->template->title = 'Neispravan unos';

      $this->registry->template->error = "Neispravan unos!";

    	$this->registry->template->show( 'korisnik_login' );
    }
		else
		{
			$korisnik = new Korisnik();

			$korisnik_name = $_POST["korisnik_name"];
			$password = $_POST["password"];

			$kor = $korisnik->get_korisnik_by_name( $korisnik_name );

			if( empty($kor) || $kor[0]->pass !== $password )
			{
				$this->registry->template->title = 'Krivo korisničko ima ili lozinka';

				$this->registry->template->error = 'Krivo korisničko ime ili lozinka!';

				$this->registry->template->show( 'korisnik_login' );
			}
			else
			{
				$blog = new Blog();
				$this->registry->template->lista_blogova = $blog->get_all_blogs();

				$admin = $korisnik->get_admin_by_name($korisnik_name);

				$_SESSION['id']['korisnik_ime'] = $korisnik_name;
				$_SESSION['id']['admin'] = $admin;

				$this->registry->template->title = 'Pa cao';

				if ($admin == 1)
					$this->registry->template->show( 'korisnik_admin' );
				else
				 $this->registry->template->show( 'blog_index' );
			}

		}

  }

	public function post()
	{
		$blog = new Blog();
		$korisnik = new Korisnik();

		if( isset( $_SESSION['id']['korisnik_ime'] ) && $_SESSION['id']['admin'] == 0 ){
			$k= $korisnik->get_korisnik_by_name($_SESSION['id']['korisnik_ime']);
			foreach($k as $kor)
				$id = $blog->get_id_by_korisnik($kor->id_korisnika);
		}
		else
		{
			// Nema treće opcije -- nešto ne valja. Preusmjeri na početnu stranicu.
			header( 'Location: ' . __SITE_URL . '/index.php?rt=blog' );
			exit;
		}

		// Stavi ga u $_SESSION tako da uvijek prikazujemo njegove podatke
		$_SESSION['id'][ 'id_bloga' ] = $id;

		$this->registry->template->id_bloga = $id;

		$this->registry->template->title = 'Post';

    $this->registry->template->error = NULL;

		$this->registry->template->show( 'korisnik_post' );
	}

	public function admin()
	{

		if( isset( $_SESSION['id']['korisnik_ime'] ) && $_SESSION['id']['admin'] == 1 ){
			$this->registry->template->$korisnik_name = $_SESSION['id']['korisnik_ime'];
		}
		else
		{
			// Nema treće opcije -- nešto ne valja. Preusmjeri na početnu stranicu.
			header( 'Location: ' . __SITE_URL . '/index.php?rt=blog' );
			exit;
		}

	$blog = new Blog();
	$this->registry->template->lista_blogova = $blog->get_all_blogs();


	$this->registry->template->title = 'Pa cao';

		$this->registry->template->show( 'korisnik_admin' );
	}

	public function edit()
	{

		$blog = new Blog();
		$korisnik = new Korisnik();

		if( isset( $_SESSION['id']['korisnik_ime'] ) && $_SESSION['id']['admin'] == 0 ){
			$k= $korisnik->get_korisnik_by_name($_SESSION['id']['korisnik_ime']);
			foreach($k as $kor)
				$id = $blog->get_id_by_korisnik($kor->id_korisnika);
		}
		else
		{
			// Nema treće opcije -- nešto ne valja. Preusmjeri na početnu stranicu.
			header( 'Location: ' . __SITE_URL . '/index.php?rt=blog' );
			exit;
		}

		// Stavi ga u $_SESSION tako da uvijek prikazujemo njegove podatke
		$_SESSION['id'][ 'id_bloga' ] = $id;

		if( isset( $_SESSION['id']['korisnik_ime'] ) ){
			$k= $korisnik->get_korisnik_by_name($_SESSION['id']['korisnik_ime']);
			foreach($k as $kor)
				$id_kor = $kor->id_korisnika;
		}
		$this->registry->template->id_k = $id_kor;

		$this->registry->template->id_bloga = $id;
		$this->registry->template->lista_blogova = $blog->get_all_blogs();
		$this->registry->template->title = $blog->get_naziv_by_id($id);
		$this->registry->template->show( 'korisnik_edit' );
	}

};
?>
