<?php
	class Navigation_page extends Common
	{

		public $id;
		public $navigation_menu_id;
		public $nome;
		public $url;
		public $icone;
		public $mostrar;
		public $alt;
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

		public function status()
		{
			if ($this->mostrar == 1)
			{
				return '<span class="label label-success" style="font-weight: normal;">Sim</span>';
			}else{ 
				return '<span class="label label-important" style="font-weight: normal;">Não</span>';
			}
		}
	}
?>