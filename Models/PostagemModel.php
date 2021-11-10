<?php
require_once 'ConectarBanco.php';
require_once 'UsuarioModel.php';
require_once 'ComentarioModel.php';

/*Model responsavel pelas postagens
* $usuario(relação de agregação):objeto responsavel por conseguir a informaçoes do usuario que postou
* $comentarios: serve para receber os comentarios que aparecerão no post
* $comment_post: Responsavel pelo vetor contendo os objetos do post
*/
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
	/**
	*	Metodo de inserção da postagem
	*	Será inserido o conteudo(texto do post),o total de likes(padrão 0),e a id do usuario que postou
	*/
	public function save()
	{
		if(!is_null($this->id))
			$st_query = "UPDATE tb_postagem set nm_conteudo = '$this->conteudo' WHERE cd_postagem = $this->id";
		else
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
			exit;
		}
	}

	/**
	Metodo de para curtir a postagem
	* Será inserido o id do usuario que curtiu e a id do post que foi curtido
	* Caso o usuario ja tenha curtido a postagem antes, só vai alterar o estado do like
	* 0: para não curtido
	* 1: pra curtido
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
	/**
	* Esse metodo serve para verificar se o usuario ja curtiu uma postagem antes e ver se ele 			ja curtiu ou não 
	* Será executado pelo metodo curtirPost()
	* Assim curtir ou descurtir a postagem dependendo do que esse metodo retornará
	* No caso do usuario nunca ter interagido ele retornará false
	* No caso de ja ter interagido ele vai verificar se a postagem está curtida ou não
	*/
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
	/**
		Metodo para inserir o Total de likes
	* Ele fará um update com Select onde esse Select irá pegar todo o total 
	*/
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

	/**
		* Metodo para listar todas as informações das postagens incluindo os comentarios
		* Ele selecionará o codigo,o texto, total de like, e o nome de usuario que fez a postagem
		* As informações dos comentarios referentes ao post
		* E também se ele foi curtido para assim renderiaar os botão de like selecionado
	*/
	public function listar()
	{
		$v_postagem = [];
		$st_query = "SELECT cd_postagem,nm_conteudo,tot_like,nm_pessoal,nm_foto,fk_cd_usuario FROM tb_postagem JOIN tb_usuario on tb_usuario.cd_usuario = tb_postagem.fk_cd_usuario ORDER by cd_postagem desc;";
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
				$obj_post->setIdUser($registros->fk_cd_usuario);
				$obj_post->setTotLike($registros->tot_like);
				$obj_post->usuario->setNomePessoal($registros->nm_pessoal);
				$obj_post->usuario->setNomeFoto($registros->nm_foto);

				//Setando os posts que foram curtidos
				foreach ($dados_curtidos as $p)
					if($obj_post->id == $p->getId() && $p->getNum_like() == 1)
						$obj_post->setNum_like($p->getNum_like());
				//O PROBLEMA ESTA NOS COMENTARIOS	
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


	/**
	 * Metodo que identificará se a postagem ja foi curtida ou não pelo usuario logado
	 * para renderizar o like ja selecionado na pagina
	 * Ele irá selecionar a id da postagem e o numero do like(0 para nao curtido e 1 para curtido)
	 * e essa chave estrangeira será a id do usuario logado
	 * Retornará um vetor contendo os objetos do like igual a 1(ja curtido) para se juntar as outras informações no metodo listar()
	 */
	private function postsCurtidos()
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

	/**
	 * Metodo para deletar uma postagem
	 * deletará todas a informações referente a curtida na tabela interacao_post
	 * e depois deletará a postagem na tabela principal
	 */
	public function delete()
	{
		$st_query = "DELETE FROM interacao_post WHERE fk_cd_postagem = $this->id;";
		$st_query .= "DELETE FROM tb_postagem WHERE cd_postagem = $this->id";
		try
		{
			if($this->con->exec($st_query))
				return true;
			else
				return false;
		}
		catch(PDOException $error)
		{
			echo "ERROR:Camada: Model<br>Arquivo: ".__FILE__."<br>Metodo: ".__FUNCTION__."<br>".$error;
		}
	}

	//Metodo para selecionar as informações de um post especifico
	public function loadById($id)
	{
		$st_query = "SELECT * FROM tb_postagem WHERE cd_postagem = $id;";
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