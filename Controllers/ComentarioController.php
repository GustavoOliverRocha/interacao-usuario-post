<?php
require_once './Models/ComentarioModel.php';
session_start();
class ComentarioController
{
	public function exibirComentarios()
	{
		if(isset($_POST['id_post']))
		{	
			$v_comment = [];
			$obj_comment = new ComentarioModel();
			$v_comment = $obj_comment->exibir($_POST['id_post']);
			$this->atualizarComentarios(sizeof($v_comment));
		}
	}

	public function manterComentario()
	{
		if(isset($_POST['comment'],$_POST['id_post']) && DataValidator::isLogado())
		{
			$i = 0;
			$obj_comment = new ComentarioModel();

			if(isset($_POST['id_comment']))
				$obj_comment->setId($_POST['id_comment']);

			$obj_comment->setComentario(DataValidator::cleanData($_POST['comment']));
			$obj_comment->setUserId($_SESSION['id_user']);
			$obj_comment->setPostId($_POST['id_post']);

			if($obj_comment->save())
				$this->atualizarComentarios(5);
			else
				echo "ERROR";
		}
	}

	private function atualizarComentarios($qtMax)
	{
		if(isset($_REQUEST['id_post']))
		{
		//Eu posso colocar um parametro e colocar um if pra caso se vai ser só o 5 coments
		//ou se vai ser no modal com tds os comentarios
			$i = 0;
			$obj_comment = new ComentarioModel();
			$v_comentarios = $obj_comment->exibir($_REQUEST['id_post']);
			foreach($v_comentarios as $c)
			{
				if($i == $qtMax)
					break;
				ob_start();
					require "./Views/Templates/ComentarioTemplate/ren_ComentariosRead.phtml";
					$str = ob_get_contents();
				ob_end_clean();
				echo $str;
				$i++;
			}
		}
	}

	public function newComment()
	{
		if(isset($_REQUEST['id_comment']))
		{
			$obj_comment = new ComentarioModel();
			$obj_comment->loadById($_POST['id_comment']);
			$obj_comment->setComentario(DataValidator::cleanData($_REQUEST['comment']));

			/**
			 * Verificando se o comentario realmente pertence ao usuario
			 * Esta condição tem que vir primeiro pois se retornar 'false'
			 * o if ja quebra
			 * Pois se a condição save() vier antes ele vai escutar o metodo
			 * Assim editando um comentario nao pertencente de qualquer maneira
			 * mesmo se cair no else
			 */
			if($obj_comment->getUserId() == $_SESSION['id_user'] && 
					$obj_comment->save()){

				echo $obj_comment->getComentario();
			}
			else
				echo "false";
		}
	}

	public function deletarComment()
	{
		if(isset($_REQUEST['id_comment']))
		{
			$obj_comment = new ComentarioModel();
			$obj_comment->setId($_REQUEST['id_comment']);

			if($obj_comment->delete())
				echo "sucess";
			else
				echo "ERROR";
		}
	}
}