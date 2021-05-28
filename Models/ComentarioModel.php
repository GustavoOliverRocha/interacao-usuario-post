<?php
require_once 'ConectarBanco.php';

class ComentarioModel extends ConectarBanco
{
	private $id;
	private $comentario;
	private $user_id;
	private $post_id;

	function __construct()
	{

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

	public function save()
	{
		if(isset($this->id))
			$st_query = "UPDATE comentario set nm_comentario = '$this->comentario' WHERE cd_comentario = $this->id;";
		else
			$st_query = "INSERT INTO comentario(nm_comentario,fk_cd_usuario,fk_cd_postagem)VALUES('$this->nm_comentario',$this->user_id,$this->post_id);";
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

	public function exibir()
	{
		$v_comentarios = [];
		$st_query = "SELECT cd_comentario,nm_comentario FROM comentarios;";

		try
		{
			$dados = $this->con->query($st_query);
			while($registros = $dados->fetchObject())
			{
				$obj_comment = new ComentarioModel();
				$obj_comment->setId($registros->cd_comentario);
				$obj_comment->setComentario($registros->nm_comentario);
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