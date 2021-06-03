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
		{	
			$v_comment = [];
			$obj_comment = new ComentarioModel();
			//$obj_comment->setId();
			$v_comment = $obj_comment->exibir($_POST['id_post']);

			/*echo '<div class="modal" id="myModal">
    				<div class="modal-dialog-scrollable">
      					<div class="modal-content">';*/
			foreach($v_comment as $c)
			{
				echo "<div class=\"row\">
						<div class=\"col-1\">
							<img src=\"https://blogtectoy.com.br/wp-content/uploads/2020/02/sonic-the-hedgehog-2020-3.jpg\" width=\"50px\" height=\"50px\">
						</div>
						<div class=\"col-10\">
								<div>
							<h6 id=\"nomeuser\">".$c->getUsuario()->getNome()."</h6>
					
							<p> ".$c->getComentario(). "</p>
								</div>
						</div>

					</div>		";

			}
			//echo '</div></div></div>';
		}
	}
	public function manterComentario()
	{
		if(isset($_POST['comment'],$_POST['id_post']) && DataValidator::isLogado())
		{
			$obj_comment = new ComentarioModel();
			$obj_comment->setComentario($_POST['comment']);
			$obj_comment->setUserId($_SESSION['id_user']);
			$obj_comment->setPostId($_POST['id_post']);
			if($obj_comment->save())
			{
				echo "SCUESSO";
			}
			else
			{
				echo "ERROR";
			}
		}
	}
}