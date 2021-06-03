<?php


class IndexController
{
	public function indexRedirect()
	{
		if(DataValidator::isLogado())
			RouteController::redirect('?classe=Postagem&metodo=listarPostagens');
		else
			RouteController::redirect('?classe=Usuario&metodo=login');
	}
}