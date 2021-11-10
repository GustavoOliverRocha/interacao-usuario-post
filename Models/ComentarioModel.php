<?php
require_once 'ConectarBanco.php';
require_once 'UsuarioModel.php';
/**Classe responsavel pelas informações do comentario da postagem
  * $comentario: Responsavel pelo texto da postagem
  *
*/
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

	/**
	 *
	 * Metodo para exibir os comentarios de uma postagem em especifico
	 * o parametro desse metodo sera a id do post
	 * retornará um vetor contendo o id,o comentario(texto),a id do usuario que fez o comentarios
	 * e o nome dele
	 *
	 */
	public function exibir($id)
	{
		$v_comentarios = [];
		$st_query = "SELECT cd_comentario, nm_comentario, nm_pessoal,nm_foto,fk_cd_usuario FROM comentarios JOIN tb_usuario on tb_usuario.cd_usuario = comentarios.fk_cd_usuario WHERE fk_cd_postagem = $id ORDER by cd_comentario desc;";

		try
		{
			$dados = $this->con->query($st_query);

			while($registros = $dados->fetchObject())
			{
				$obj_comment = new ComentarioModel();
				$obj_comment->setId($registros->cd_comentario);
				$obj_comment->setComentario($registros->nm_comentario);
				$obj_comment->setUserId($registros->fk_cd_usuario);
				$obj_comment->usuario->setNomePessoal($registros->nm_pessoal);
				$obj_comment->usuario->setNomeFoto($registros->nm_foto);
				array_push($v_comentarios, $obj_comment);
			}
		
		}
	    catch(PDOException $error)
		{
            echo "ERROR: ".$error->getMessage();
        }
        return $v_comentarios;

	}

	/**
	 * Deletar uma postagem
	 */
	public function delete()
	{
		if(isset($this->id))
		{
			$st_query = "DELETE FROM comentarios WHERE cd_comentario = $this->id";
			try
			{
				if($this->con->exec($st_query) > 0)
					return true;
				else
					return false;
			}
			catch(PDOException $error)
			{
				echo "ERROR: ";
			}

		}
	}

	/**
	 * Inserir as informações de uma postagem espeficifica em um objeto
	 */
	public function loadById($id)
	{
		$st_query = "SELECT * FROM comentarios WHERE cd_comentario = $id;";
		try
		{
			$dados = $this->con->query($st_query);
			$registros = $dados->fetchObject();
			$this->setId($registros->cd_comentario);
			$this->setComentario($registros->nm_comentario);
			$this->setUserId($registros->fk_cd_usuario);
			$this->setPostId($registros->fk_cd_postagem);
			return $this;
			
		}
		catch(PDOException $error)
		{
			echo "ERROR";
		}
		return $this;
	}
}