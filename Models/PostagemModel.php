<?php

class PostagemModel
{
	private $id;
	private $nota;
	private $num_like;
	private $desc; 
	private $comment;

	function __construct()
	{
		
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getNota()
	{
		return $this->nota;
	}

	public function setNota($nota)
	{
		$this->nota = $nota;
	}

	public function getNum_like()
	{
		return $this->num_like;
	}

	public function setNum_like($num_like)
	{
		$this->num_like = $num_like;
	}

	public function getDesc()
	{
		return $this->desc;
	}

	public function setDesc($desc)
	{
		$this->desc = $desc;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
	}



}