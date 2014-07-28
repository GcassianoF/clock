<?php
	class Permission extends Common
	{

		public $id;
		public $users_group_id;
		public $navigation_page_id;
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