<?php
require_once './Libs/DataValidator.php';
class RouteController
{
	private $classeController;
	private $rotaMetodo;

	private function setRoutes()
	{
		$this->classeController = isset($_GET['classe']) ? $_GET['classe'] :'Index';
		$this->rotaMetodo = isset($_GET['metodo']) ? $_GET['metodo'] : 'indexRedirect';
	}

	public function importController()
	{
		$this->setRoutes();
		$controllerFile = './Controllers/'.ucfirst($this->classeController).'Controller.php';
		$classe = $this->classeController.'Controller';
		$metodo = $this->rotaMetodo;

		if(file_exists($controllerFile))
			require_once $controllerFile;
		else{
			echo "<h1>Error: Arquivo não encontrado</h1>";
			exit;
		}

		if(class_exists($classe))
			$c = new $classe;
		else
			exit('Classe não encontrada');

		if(method_exists($c, $metodo))
			$c->$metodo();
		else
			exit('metodo não encontrado');
	}

	public function redirect($url)
	{
		header('Location: '.$url);
	}
}