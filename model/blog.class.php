<?php

require_once 'db.class.php';
require_once 'post.class.php';
require_once 'komentar.class.php';

class Blog
{
	protected $id_bloga, $id_korisnika, $naziv, $opis;

	//function __construct(){}
	function __construct( $id_bloga=NULL, $id_korisnika=NULL, $naziv=NULL, $opis=NULL)
	{
		$this->id_bloga = $id_bloga;
		$this->id_korisnika = $id_korisnika;
		$this->naziv = $naziv;
		$this->opis = $opis;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }

	function get_all_blogs( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_bloga, id_korisnika, naziv, opis FROM blog' );
			$st->execute( );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Blog( $row['id_bloga'], $row['id_korisnika'], $row['naziv'], $row['opis']);
		}

		return $arr;
	}

	function get_all_postovi( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_posta, id_bloga, naslov, tekst FROM post WHERE id_bloga=:id_bloga ORDER BY id_posta DESC' );
			$st->execute( array( 'id_bloga' => $this->id_bloga ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Post( $row['id_posta'], $row['id_bloga'], $row['naslov'], $row['tekst'] );
		}

		return $arr;
	}

	function get_all_posts( $id_bloga )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_posta, id_bloga, naslov, tekst FROM post WHERE id_bloga=:id_bloga' );
			$st->execute( array( 'id_bloga' => $id_bloga ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Post( $row['id_posta'], $row['id_bloga'], $row['naslov'], $row['tekst'] );
		}

		return $arr;
	}

	function get_all_komentari()
	{
		$postovi = $this->get_all_postovi();

		$arr = array();
		foreach ($postovi as $post)
		{
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare( 'SELECT id_komentara, id_posta, id_korisnika, tekst FROM komentar WHERE id_posta=:id_posta' );
				$st->execute( array( 'id_posta' => $post->id_posta ) );
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			while( $row = $st->fetch() )
			{
				$arr[] = new Komentar( $row['id_komentara'], $row['id_posta'] , $row['id_korisnika'], $row['tekst'] );
			}
		}
		return $arr;
	}



	function get_num_of_postovi ()
	{
		$db = DB::getConnection();
		$listaPostova = $this->get_all_postovi();
		$broj_postova=0;
		foreach ($listaPostova as $post)
		{
			$broj_postova++;
		}
		return $broj_postova;
	}

	public function get_naziv_by_id( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_bloga, id_korisnika, naziv, opis FROM blog WHERE id_bloga=:id_bloga' );
			$st->execute( array( 'id_bloga' => $id ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
					$arr[] = new Blog( $row['id_bloga'], $row['id_korisnika'], $row['naziv'], $row['opis']);
		}

		foreach($arr as $a){
			return $a->naziv;
		}

	}

	public function get_id_by_korisnik( $id_korisnika )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_bloga, id_korisnika, naziv, opis FROM blog WHERE id_korisnika=:id_korisnika' );
			$st->execute( array( 'id_korisnika' => $id_korisnika ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
					$arr[] = new Blog( $row['id_bloga'], $row['id_korisnika'], $row['naziv'], $row['opis']);
		}

		foreach($arr as $a){
			return $a->id_bloga;
		}

	}

}
?>
