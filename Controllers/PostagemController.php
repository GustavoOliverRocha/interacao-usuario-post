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
require_once './Models/ComentarioModel.php';
class PostagemController
{

	public function listarPostagens()
	{
		//esse if é para impedir que acessem esse metodo pelo ajax
		if(count($_POST) == 0)
		{
			$obj_view = new ViewRender('./Views/mainPost.phtml');
			$obj_post = new PostagemModel();

			if(DataValidator::isLogado())
				$obj_post->setIdUser($_SESSION['id_user']);

			$v_posts = $obj_post->listar();

			$obj_view->setDados(array('postagens' => $v_posts  ));
			$obj_view->showPage();
		}
			
	}

	public function manterPostagem()
	{
		
		if(isset($_POST['nm_postagem']) && DataValidator::isLogado())
		{
			$obj_post = new PostagemModel();
			$obj_post2 = new PostagemModel();
			if(isset($_REQUEST['id_postagem']))
			{
				$obj_post->setId($_REQUEST['id_postagem']);
				$obj_post2->loadById($_REQUEST['id_postagem']);
			}

			$obj_post->setIdUser($_SESSION['id_user']);
			$obj_post->setConteudo(chop($_POST['nm_postagem']," "));
			if($obj_post->save() && $obj_post2->getIdUser() == $_SESSION['id_user'])
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
	public function mostrarPost()
	{
		if(isset($_REQUEST['id_postagem']) && DataValidator::isLogado())
		{
			$obj_post = new PostagemModel();
			$obj_post->loadById($_REQUEST['id_postagem']);

			echo $obj_post->getId().','.$obj_post->getConteudo();

		}
	}
	public function curtirPostagem()
	{
		if(isset($_POST['id_post']) && DataValidator::isLogado())
		{
			$obj_post = new PostagemModel();
			$obj_post->setId($_POST['id_post']);
			$obj_post->setIdUser($_SESSION['id_user']);
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