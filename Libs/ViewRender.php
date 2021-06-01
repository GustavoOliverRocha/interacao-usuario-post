<?php

class ViewRender
{
	private $content;
	private $htmlFile;
	private $dados;

	function __construct($html = null)
	{
		if(!is_null($html))
			$this->setHtmlFile($html);
	}

	public function getContent()
	{
		return $this->content;
	}
	public function setContent()
	{
		ob_start();
		if(file_exists($this->htmlFile))
			require_once $this->htmlFile;
		$this->content = ob_get_contents();
		ob_end_clean();
	}

	public function getHtmlFile()
	{
		return $this->htmlFile;
	}
	public function setHtmlFile($html)
	{
		if(file_exists($html))
			$this->htmlFile = $html;
		else
			exit('Aquivo html nao encontrado');
	}

	public function getDados()
	{
		return $this->dados;
	}
	public function setDados(Array $dados)
	{
		$this->dados = $dados;
	}

	public function showPage()
    {
    	$this->setContent();
        echo $this->getContent();
        exit;
    }
}
