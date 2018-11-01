<?php

class Komentar
{
	protected $id_komentara, $id_posta, $id_korisnika, $tekst;

	function __construct( $id_komentara, $id_posta, $id_korisnika, $tekst )
	{
		$this->id_komentara = $id_komentara;
		$this->id_posta = $id_posta;
		$this->id_korisnika = $id_korisnika;
		$this->tekst = $tekst;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }

	function get_korisnik( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_korisnika, ime, pass, admin FROM korisnik WHERE id_korisnika=:id_korisnika' );
			$st->execute( array( 'id_korisnika' => $this->id_korisnika ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Korisnik( $row['id_korisnika'], $row['ime'], $row['pass'], $row['admin'] );
		}

		return $arr;
	}
}

function get_all_komentari( )
{
	try
	{
		$db = DB::getConnection();
		$st = $db->prepare( 'SELECT id_komentara, id_posta, id_korisnika, tekst FROM komentar WHERE id_posta=:id_posta' );
		$st->execute( array( 'id_posta' => $this->id_posta ) );
	}
	catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	$arr = array();
	while( $row = $st->fetch() )
	{
		$arr[] = new Komentar( $row['id_komentara'], $row['id_posta'], $row['id_korisnika'], $row['tekst'] );
	}

	return $arr;
}

?>
