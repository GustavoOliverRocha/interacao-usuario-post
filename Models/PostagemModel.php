<?php
require_once 'ConectarBanco.php';
require_once 'UsuarioModel.php';
class PostagemModel extends ConectarBanco
{
	private $id;
	private $conteudo;
	/*private $media;
	private $nota;*/
	private $tot_like;
	private $id_user;
	private $usuario;
	private $num_like;

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

	/*public function getNota()
	{
		return $this->nota;
	}

	public function setNota($nota)
	{
		$this->nota = $nota;
	}*/

	public function getNum_like()
	{
		return $this->num_like;
	}

	public function setNum_like($num_like)
	{
		$this->num_like = $num_like;
	}

	public function getConteudo()
	{
		return $this->conteudo;
	}

	public function setConteudo($conteudo)
	{
		$this->conteudo = $conteudo;
	}
	public function getTotLike()
	{
		return $this->tot_like;
	}
	public function setTotLike($tot_like)
	{
		$this->tot_like = $tot_like;
	}

	public function getIdUser()
	{
		return $this->id_user;
	}
	public function setIdUser($idUser)
	{
		$this->id_user = $idUser;
	}

	public function getUsuario()
	{
		return $this->usuario;
	}

	/*public function getComment()
	{
		return $this->comment;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
	}*/

	public function save()
	{
		$st_query = "INSERT INTO tb_postagem(nm_conteudo,tot_like,fk_cd_usuario) VALUES ('$this->conteudo',0,$this->id_user);";

		try
		{
			if($this->con->exec($st_query) > 0)
				return true;
			else
				return false;

		}
		catch(PDOException $error)
		{
			echo "ERROR";
		}
	}

	public function curtirPost()
	{
		if($this->isInteragido())
			$st_query = "UPDATE interacao_post SET nr_like = $this->num_like WHERE fk_cd_postagem = $this->id and fk_cd_usuario = $this->id_user;";
		else
			$st_query = "INSERT INTO interacao_post(nr_like,fk_cd_postagem,fk_cd_usuario) VALUES ($this->num_like,$this->id,$this->id_user);";
		//echo $st_query;
		try
		{
			if($this->con->exec($st_query) > 0 && $this->calcularCurtidas())
			{
				echo $this->loadById($this->id)->getTotLike() ;
				return true;
			}
			else
				return false;
		}
		catch(PDOException $error)
		{
			echo "ERROR";
		}
	}

	private function isInteragido()
	{
		$st_query = "SELECT nr_like FROM interacao_post WHERE fk_cd_postagem = $this->id and fk_cd_usuario = $this->id_user;";
		try
		{
			$dados = $this->con->query($st_query);
			$registros = $dados->fetchObject();
			if(!$registros)
			{
				$this->num_like = 1;
				return false;
			}
			else if($registros->nr_like == 1)
			{
				$this->num_like = 0;
				return true;
			}
			else
			{
				$this->num_like = 1;
				return true;
			}
		}
				catch(PDOException $error)
		{
			echo "ERROR";
		}
	}

	public function calcularCurtidas()
	{
		$total = "(SELECT COUNT(nr_like) FROM interacao_post WHERE fk_cd_postagem = $this->id and nr_like = 1)";
		$st_query = "UPDATE tb_postagem set tot_like = $total WHERE cd_postagem = $this->id;";
		try
		{
			if($this->con->exec($st_query) > 0)
			{
				
				
				return true;
			}
			else
				return false;
		}
		catch(PDOException $error)
		{
			echo "ERROR";
		}
	}

	public function listar()
	{
		$v_postagem = [];
		$st_query = "SELECT nm_usuario,cd_postagem,nm_conteudo,tot_like FROM tb_postagem JOIN tb_usuario on tb_usuario.cd_usuario = tb_postagem.fk_cd_usuario;";
		try
		{
			$dados = $this->con->query($st_query);
			$dados2 = $this->postsCurtidos();
			while($registros = $dados->fetchObject())
			{
				$obj_post = new PostagemModel();
				$obj_post->setId($registros->cd_postagem);
				$obj_post->setConteudo($registros->nm_conteudo);
				$obj_post->setTotLike($registros->tot_like);
				$obj_post->usuario->setNome($registros->nm_usuario);
				foreach ($dados2 as $key) {
				if($obj_post->id == $key->getId() && $key->getNum_like() == 1)
					$obj_post->setNum_like($key->getNum_like());
				}
				array_push($v_postagem, $obj_post);
			}
		}
		catch(PDOException $error)
		{
			echo "ERROR";
		}
		return $v_postagem;
	}

	public function postsCurtidos()
	{
		$v_postagem = [];
		$st_query = "SELECT nr_like,fk_cd_postagem FROM interacao_post JOIN tb_usuario on tb_usuario.cd_usuario = interacao_post.fk_cd_usuario WHERE fk_cd_usuario = 6 and nr_like = 1;";
		try
		{
			$dados = $this->con->query($st_query);
			while($registros = $dados->fetchObject())
			{
				$obj_post = new PostagemModel();
				$obj_post->setId($registros->fk_cd_postagem);
				$obj_post->setNum_like($registros->nr_like);
				array_push($v_postagem, $obj_post);
			}
		}
		catch(PDOException $error)
		{
			echo "ERROR";
		}
		return $v_postagem;
	}
	/*$st_query = "SELECT nr_like FROM interacao_post JOIN tb_usuario on tb_usuario.cd_usuario = interacao_post.fk_cd_usuario WHERE fk_cd_postagem = $this->id and fk_cd_usuario = $this->usuario->getId();"*/
	public function loadById($id)
	{
		$st_query = "SELECT * FROM tb_postagem WHERE cd_postagem = $id";
				try
		{
			$dados = $this->con->query($st_query);
			$registros = $dados->fetchObject();
			$this->setId($registros->cd_postagem);
			$this->setConteudo($registros->nm_conteudo);
			$this->setTotLike($registros->tot_like);
			$this->setIdUser($registros->fk_cd_usuario);
			return $this;
		}
		catch(PDOException $error)
		{
			echo "ERROR";
		}
		return $this;
	}

}
$p = new PostagemModel();
if(isset($_GET['id']))
{
$p->setId($_GET['id']);
$p->setIdUser($_GET['id_user']);
echo $_GET['sonic'];
//$p->setNum_like($_GET['like']);
$p->curtirPost();
}

?>