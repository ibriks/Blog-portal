<?php

class blogController extends BaseController
{
	public function index() //dohvaca popis svih blogova
	{
		$blog = new Blog();

		if( isset( $_POST["dugme"] ) ){
			$_SESSION['id']['korisnik_ime'] = NULL;
			$_SESSION['id']['admin'] = NULL;
		}

		if( isset( $_SESSION['id']['korisnik_ime'] ) ){

			$this->registry->template->lista_blogova = $blog->get_all_blogs();

			$this->registry->template->show( 'blog_index' );
		}
		else
		{
			$this->registry->template->lista_blogova = $blog->get_all_blogs();

			$this->registry->template->show( 'blog_index' );
		}
	}

	public function postovi() //otvara novi session za konkretni blog
	{
		$blog = new Blog();
		$korisnik = new Korisnik();

		if( isset( $_POST["id_bloga"] ) )
		{
			$id = $_POST["id_bloga"];
		}
		else if( isset( $_SESSION['id']['id_bloga'] ) )
			$id = $_SESSION['id']['id_bloga'];
		else
		{
			// Nema treće opcije -- nešto ne valja. Preusmjeri na početnu stranicu.
			header( 'Location: ' . __SITE_URL . '/index.php?rt=blog' );
			exit;
		}

		if( isset( $_SESSION['id']['korisnik_ime'] ) ){
			$k= $korisnik->get_korisnik_by_name($_SESSION['id']['korisnik_ime']);
			foreach($k as $kor){
				$id_kor = $kor->id_korisnika;
			}
		}

		// Stavi ga u $_SESSION tako da uvijek prikazujemo njegove podatke
		$_SESSION['id'][ 'id_bloga' ] = $id;

		$this->registry->template->id_bloga = $id;
		$this->registry->template->admin = $korisnik->get_admin_by_name($_SESSION['id']['korisnik_ime']);
		$this->registry->template->id_k = $id_kor;
		$this->registry->template->lista_blogova = $blog->get_all_blogs();
		$this->registry->template->title = $blog->get_naziv_by_id($id);
		$this->registry->template->show( 'blog_postovi' );

	}

	public function sve() //dohvaca popis svih blogova
	{
		$blog = new Blog();

		$this->registry->template->lista_blogova = $blog->get_all_blogs();

		$this->registry->template->show( 'blog_sve' );
	}

	public function moj() //otvara novi session za konkretni blog
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
		$this->registry->template->show( 'blog_postovi' );

	}

 };

?>
