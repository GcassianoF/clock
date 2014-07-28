<?php
	class Navigation_menu extends Common
	{

		public $id;
		public $nome;
		public $icone;
		public $posicao;
		public $created_at;
		public $updated_at;
		public $deleted_at;

		public $rel;

		function __construct($params=NULL)
		{
			$this->constructor($params);
			$dao = new DAO();
			$this->rel = $dao->get_related($this);
			return $this;
		}
	}
?>