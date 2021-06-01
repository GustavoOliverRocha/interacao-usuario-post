<?php
require_once './Models/ComentarioModel.php';

class ComentarioController
{
	function __construct()
	{

	}


	public function exibirComentarios()
	{
		if(isset($_POST['id_post']))
		{	$v_comment = [];
			$obj_comment = new ComentarioModel();
			$obj_comment->setId($_POST['id_post']);
			$v_comment = $obj_comment->exibir();
		}
	}
	public function manterComentario()
	{
		if(isset($_POST['comment'],$_POST['id_user'],$_POST['id_post']))
		{
			$obj_comment = new ComentarioModel();
			$obj_comment->setComentario($_POST['comment']);
			$obj_comment->setIdUser($_POST['id_user']);
			$obj_comment->setIdPost($_POST['id_post']);
			if($obj_comment->save())
			{
				return true
			}
			else
			{
				echo "ERROR";
			}
		}
	}
}