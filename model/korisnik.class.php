<?php

require_once 'db.class.php';

class Korisnik
{
	protected $id_korisnika, $ime, $pass;

	function __construct( $id_korisnika=NULL, $ime=NULL, $pass=NULL, $admin=NULL )
	{
		$this->id_korisnika = $id_korisnika;
		$this->ime = $ime;
		$this->pass = $pass;
    $this->admin = $admin;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }

	function get_all_korisnici( )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_korisnika, ime, pass, admin FROM korisnik' );
			$st->execute( );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Korisnik( $row['id_korisnika'], $row['ime'], $row['pass'], $row['admin'] );
		}

		return $arr;
	}

	public function get_korisnik_by_name( $name )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_korisnika, ime, pass, admin FROM korisnik WHERE ime=:ime' );
			$st->execute( array( 'ime' => $name ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Korisnik( $row['id_korisnika'], $row['ime'], $row['pass'], $row['admin'] );
		}

		return $arr;
	}

	public function get_admin_by_name( $name )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_korisnika, ime, pass, admin FROM korisnik WHERE ime=:ime' );
			$st->execute( array( 'ime' => $name ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Korisnik( $row['id_korisnika'], $row['ime'], $row['pass'], $row['admin'] );
		}

		foreach($arr as $a){
			return $a->admin;
		}
	}

}

?>
