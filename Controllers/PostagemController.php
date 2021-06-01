<?php
if(file_exists('./Models/PostagemModel.php'))
	require_once './Models/PostagemModel.php';
else
{
	/*Por algum motivo quando o Ajax executa um script PHP
	ele não reconheçe 'um ponto' como um recuo de diretorio/pasta
	mas sim 'dois pontos'*/
	require_once '../Models/PostagemModel.php';
}
require_once './Libs/ViewRender.php';
class PostagemController
{
	function __construct()
	{

	}

	public function listarPostagens()
	{
		/*esse if é para impedir que acessem esse metodo pelo ajax*/
		if(count($_POST) == 0)
		{
			$obj_view = new ViewRender('./Views/mainPost.phtml');
			$obj_post = new PostagemModel();
			$obj_post->setId(4);
			$sonic = $obj_post->listar();
			$obj_view->setDados(array('teste' => $sonic  ));
			$obj_view->showPage();
			//return $obj_post->listar();
		}
			
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
					//	header("Location: ?classe=Postagem&metodo=listarPostagens");
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
/*$pc = new PostagemController();
//$pc->manterPostagem();
$pc->curtirPostagem();*/