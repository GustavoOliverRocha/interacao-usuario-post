<?php
if(file_exists('./Models/PostagemModel.php'))
	require_once './Models/PostagemModel.php';
else
{
	/*Por algum motivo quando o Ajax executa um script PHP
	ele não reconheçe 'um ponto' como um retorno de diretorio/pasta
	e sim 'dois pontos'*/
	require_once '../Models/PostagemModel.php';
}

class PostagemController
{
	function __construct()
	{

	}

	public function listarPostagens()
	{
		$obj_post = new PostagemModel();
		$obj_post->setId(4);
		return $obj_post->listar();
			
	}

	public function manterPostagem()
	{
		
		if(isset($_POST['id_user'],$_POST['nm_postagem']))
		{
			$obj_post = new PostagemModel();
			$obj_post->setIdUser($_POST['id_user']);
			$obj_post->setConteudo($_POST['nm_postagem']);
			if($obj_post->save())
			{
				echo "<div class=\"alert alert-success\" role=\"alert\">
  							Postagem postada com sucesso
						</div>";
			}
			else
			{
				echo '<div class="alert alert-danger" role="alert">
  						ERROR: A postagem nao foi postada
					</div>';
			}
		}

	}

	public function curtirPostagem()
	{
		if(isset($_POST['id_post'],$_POST['id_user']))
		{
			$obj_post = new PostagemModel();
			$obj_post->setId($_POST['id_post']);
			$obj_post->setIdUser($_POST['id_user']);
			//echo $_GET['sonic'];
			//$p->setNum_like($_GET['like']);
			if($obj_post->curtirPost())
				echo $obj_post->loadById($obj_post->getId())->getTotLike() ;
			else
				echo '<div class="alert alert-danger" role="alert">
  						ERROR: Like nao funcionou
					</div>';
		}
	}
}
$pc = new PostagemController();
//$pc->manterPostagem();
$pc->curtirPostagem();