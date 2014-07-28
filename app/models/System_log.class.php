<?php
	class System_log extends Common
	{

		public $id;    
		public $user_id;
		public $tabela;
		public $registro_id;
		public $comando;
		public $campo;    
		public $antes;
		public $depois;
		public $h;
		public $data;
		public $l;    
		public $j;

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