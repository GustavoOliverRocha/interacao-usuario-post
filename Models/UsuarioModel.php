<?php 
require_once 'ConectarBanco.php';
class UsuarioModel extends ConectarBanco
{
	private $id;
	private $nome;
	private $senha;

	function __construct()
	{
		parent::__construct();
	}

	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id = $id;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	public function getSenha()
	{
		return $this->senha;
	}
	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

	public function logar()
	{
		$v_usuarios = [];
		$st_query = "SELECT * FROM tb_usuario WHERE nm_usuario='$this->nome' and senha_usuario = '$this->senha'";
		try
		{
			
			$dados = $this->con->query($st_query);
			$res = $dados->fetchAll();
			var_dump($res);

		}
		catch(PDOException $error)
		{
			echo "ERROR: ".$error;
		}
	}
}