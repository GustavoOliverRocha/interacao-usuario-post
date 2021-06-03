<?php
require_once 'ConectarBanco.php';
require_once 'UsuarioModel.php';

class ComentarioModel extends ConectarBanco
{
	private $id;
	private $comentario;
	private $user_id;
	private $post_id;
	private $usuario;

	function __construct()
	{
		parent::__construct();
		$this->usuario = new UsuarioModel();
	}

	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id = $id;
	}

	public function getComentario()
	{
		return $this->comentario;
	}
	public function setComentario($comentario)
	{
		$this->comentario = $comentario;
	}

	public function getUserId()
	{
		return $this->user_id;
	}
	public function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	public function getPostId()
	{
		return $this->post_id;
	}
	public function setPostId($post_id)
	{
		$this->post_id = $post_id;
	}
	public function getUsuario()
	{
		return $this->usuario;
	}

	public function save()
	{
		if(!is_null($this->id))
			$st_query = "UPDATE comentarios set nm_comentario = '$this->comentario' WHERE cd_comentario = $this->id;";
		else
			$st_query = "INSERT INTO comentarios(nm_comentario,fk_cd_usuario,fk_cd_postagem)VALUES('$this->comentario',$this->user_id,$this->post_id);";
		try
		{
			if($this->con->exec($st_query) > 0)
				return true;
			else
				return false;

		}
		catch(PDOException $error)
		{
			echo "Erro na inserção dos comentarios".$error;
		}

		return false;
	}
	
	public function exibir($id)
	{
		$v_comentarios = [];
		$st_query = "SELECT cd_comentario, nm_comentario, nm_usuario FROM comentarios JOIN tb_usuario on tb_usuario.cd_usuario = comentarios.fk_cd_usuario WHERE fk_cd_postagem = $id;";

		try
		{
			$dados = $this->con->query($st_query);

			while($registros = $dados->fetchObject())
			{
				$obj_comment = new ComentarioModel();
				$obj_comment->setId($registros->cd_comentario);
				$obj_comment->setComentario($registros->nm_comentario);
				$obj_comment->usuario->setNome($registros->nm_usuario);
				array_push($v_comentarios, $obj_comment);
			}
		
		}
	    catch(PDOException $error)
		{
            echo "ERROR: ".$error->getMessage();
        }
        return $v_comentarios;

	}
}