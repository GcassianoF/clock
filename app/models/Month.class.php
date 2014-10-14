<?php
	class Month extends Common
	{
		public $id;
		public $descricao;
		public $codigo;
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
