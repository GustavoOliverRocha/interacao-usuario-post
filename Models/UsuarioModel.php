<?php 
require_once 'ConectarBanco.php';
/*
Classe responsavel pelo CRUD e o login do Usuario
*/
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

	public function listar()
	{
		$v_user = [];
		$st_query = "SELECT * FROM tb_usuario;";
		try
		{
			$dados = $this->con->query($st_query);
				/**
				 *Toda vez que o while checar a condição $registros vai receber o Objeto
				 *Ao $dados->fetchObject() ser atribuido ele está 
				'transformando' $registros em um objeto com os atributos do banco de dados
				 *fetchObject() ele retorna a linha atual do requisição do banco
				Portanto se usarmos ele apenas uma vez ele vai retornar a primeira linha
				porém ao usa-lo varias vezes vamos ter todas as linhas
				Porém  devemos armazenar as outras ja que o objeto vai ser sobrescreto toda hora
				e esse while ele só vai terminar quando chegar no ultimo
				onde o $dados->fetchObject() não irá mudar no proximo loop pois não há mais linha para ele instanciar portante ele ficará igual e o $registros terá recebido		*/
				while($registros = $dados->fetchObject())
				{
					$obj_user = new UsuarioModel();
					$obj_user->setId($registros->cd_usuario);
					$obj_user->setNome($registros->nm_usuario);
					$obj_user->setSenha($registros->senha_usuario);
					array_push($v_user, $obj_user);
				}
				return $v_user;
			
		}
		catch(PDOException $error)
		{
			echo "ERROR: UsuarioModel,metodo: listar() <br>".$error;
		}
	}

	public function logar()
	{
		$st_query = "SELECT * FROM tb_usuario WHERE nm_usuario = '$this->nome' and senha_usuario = '$this->senha';";
		try
		{
			$dados = $this->con->query($st_query);
			$registros = $dados->fetchObject();
			if(!$registros)
				return false;

			else if($this->nome == $registros->nm_usuario && 
						$this->senha == $registros->senha_usuario)
			{
				$this->id = $registros->cd_usuario;
				$this->nome = $registros->nm_usuario;
				return true;
			}
			else
				return false;
		}
		catch(PDOException $error)
		{
			echo "ERROR: ".$error;
		}
	}

	public function inserir()
	{
		$st_query = "INSERT INTO tb_usuario(nm_usuario,senha_usuario) VALUES ('$this->nome','$this->senha');";
		try
		{
			if($this->con->exec($st_query) > 0)
				return true;
			else
				return false;
		}
		catch(PDOException $error)
		{
			echo "ERROR: ".$error;
		}
	}
}