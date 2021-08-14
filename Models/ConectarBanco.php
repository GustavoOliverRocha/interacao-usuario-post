<?php

abstract class ConectarBanco
{
	private $server = "localhost"; 
	private $db_name= "db_post";
	private $user = "root";
	private $password = "";
	protected $con;

	function __construct()
	{
        $this->conectar();
	}

	public function conectar()
	{
		try
        {
            $this->con = new PDO("mysql:host=$this->server;dbname=$this->db_name",$this->user,$this->password);
            return $this->con;
        }
        catch( PDOException $error)
        {
        	echo 'A conexão com a base de dados falhou<br><br>'.$error;
        }
	}

	public function desconectar()
	{
		$this->con = null;
	}

}