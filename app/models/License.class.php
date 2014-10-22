<?php
	class License extends Common
	{
		public $id;
		public $user_id;
		public $reason_id;
		public $file_id;
		public $data;
		public $hora;
		public $dataHora;
		public $justificativa;
		public $atestado;
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
