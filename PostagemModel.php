<?php
require_once 'ConectarBanco.php';
require_once 'UsuarioModel.php';
require_once 'ComentarioModel.php';

/*Model responsavel pelas postagens*/
class PostagemModel extends ConectarBanco
{
	private $id;
	private $conteudo;
	private $tot_like;
	private $id_user;
	private $num_like;
	private $usuario;
	private $comentarios;
	private $comment_post;

	//Nesse construtor 
	function __construct()
	{
		parent::__construct();
		$this->usuario = new UsuarioModel();
		$this->comentarios = new ComentarioModel();
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

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
	public function getComentario()
	{
		return $this->comentarios;
	}

	public function setCommentPost(Array $id)
	{
		$this->comment_post = $id;
	}

	public function getCommentPost()
	{
		return $this->comment_post;
	}

	//Metodo de inserção da postagem
	/*Recebera o conteudo(o texto), o total de like que por padrao será 0 e a id do usuario que postou */
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
			echo "ERROR:Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
		}
	}

	/**
	Metodo de para curtir a postagem
	caso o usuario ja tenha interagido com a postagem ele só vai alterar o estado do like
	0 não curtido e 1 pra curtido
	*/
	public function curtirPost()
	{

		if($this->isInteragido())
			$st_query = "UPDATE interacao_post SET nr_like = $this->num_like WHERE fk_cd_postagem = $this->id and fk_cd_usuario = $this->id_user;";
		else
			$st_query = "INSERT INTO interacao_post(nr_like,fk_cd_postagem,fk_cd_usuario) VALUES ($this->num_like,$this->id,$this->id_user);";

		try
		{
			if($this->con->exec($st_query) > 0 && $this->calcularCurtidas())
				return true;
			else
				return false;
		}
		catch(PDOException $error)
		{
			echo "ERROR:Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
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
			echo "ERROR:Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
		}
	}
	/*Metodo para inserir o total de likes de uma postagem*/
	//
	private function calcularCurtidas()
	{
		$total = "(SELECT COUNT(nr_like) FROM interacao_post WHERE fk_cd_postagem = $this->id and nr_like = 1)";
		$st_query = "UPDATE tb_postagem set tot_like = $total WHERE cd_postagem = $this->id;";
		try
		{
			if($this->con->exec($st_query) > 0)
				return true;
			else
				return false;
		}
		catch(PDOException $error)
		{
			echo "ERROR:Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
		}
	}

	//Aki será onde todas as informações da postagem serão renderisadas
	//O texto do postagem,o total de curtidas,o nome do usuario que fez o post
	//Se as postagens foram curtidas pelo usuario logado,e os comemtarios
	public function listar()
	{
		$v_postagem = [];
		$st_query = "SELECT cd_postagem,nm_conteudo,tot_like,nm_usuario FROM tb_postagem JOIN tb_usuario on tb_usuario.cd_usuario = tb_postagem.fk_cd_usuario ORDER by cd_postagem desc;";
		try
		{
			$dados = $this->con->query($st_query);

			//Array contendo os objetos que identificam se o post foi curitdo pelo usuario logado
			$dados_curtidos = $this->postsCurtidos();

			while($registros = $dados->fetchObject())
			{
				$obj_post = new PostagemModel();
				$obj_post->setId($registros->cd_postagem);
				$obj_post->setConteudo($registros->nm_conteudo);
				$obj_post->setTotLike($registros->tot_like);
				$obj_post->usuario->setNome($registros->nm_usuario);

				//Setando os posts que foram curtidos
				foreach ($dados_curtidos as $p)
					if($obj_post->id == $p->getId() && $p->getNum_like() == 1)
						$obj_post->setNum_like($p->getNum_like());
					
				//colocando os comentarios deste post
				$obj_post->setCommentPost($this->comentarios->exibir($registros->cd_postagem));
				
				array_push($v_postagem, $obj_post);
			}
		}
		catch(PDOException $error)
		{
			echo "ERROR: Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
		}
		return $v_postagem;
	}
	//Este metodo servirá para mostrar se a postagem ja foi curtida ou não pelo usuario logado
	//Ele irá selecionar a id da postagem e o numero do like(0 para nao curtido e 1 para curtido)
	//e essa chave estrangeira será a id do usuario logado
	//ele retornara um array com objetos
	public function postsCurtidos()
	{
		$v_postagem = [];
		$st_query = "SELECT nr_like,fk_cd_postagem FROM interacao_post JOIN tb_usuario on tb_usuario.cd_usuario = interacao_post.fk_cd_usuario WHERE fk_cd_usuario = $this->id_user and nr_like = 1;";
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
			echo "ERROR:Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
		}
		return $v_postagem;
	}

	/*$st_query = "SELECT nr_like FROM interacao_post JOIN tb_usuario on tb_usuario.cd_usuario = interacao_post.fk_cd_usuario WHERE fk_cd_postagem = $this->id and fk_cd_usuario = $this->usuario->getId();"*/

	//Metodo para selecionar as informações de um pot especifico
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
			echo "ERROR:Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
		}
		return $this;
	}

}