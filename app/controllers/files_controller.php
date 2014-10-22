<?php
	class Files_Controller extends App_Controller
	{

		private $files = false;

		public static function add()
		{
			global $DATA;
			global $MSG;

			if($DATA['File'])
			{
				// campos obrigatoios
				validates_presence_of('File', 'name', 'NAME');
				validates_presence_of('File', 'size', 'SIZE');
				validates_presence_of('File', 'type', 'TYPE');
				validates_presence_of('File', 'path', 'PATH');

				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}

				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();

				// instacia o objeto da Class principal
				$file = new File($DATA['File']);

				if($dao->Create($file))
				{
					$MSG->success[] = "Cadastro efetuado!";
					$_POST = array();
				}else
				{
					$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
				}
			}
			return false;
		}

		public function update($file)
		{
			global $DATA;
			global $MSG;

			if($DATA['File'])
			{
				// campos obrigatoios
				validates_presence_of('File', 'name', 'NAME');
				validates_presence_of('File', 'size', 'SIZE');
				validates_presence_of('File', 'type', 'TYPE');
				validates_presence_of('File', 'path', 'PATH');

				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();


				$file = batch_update($file, $DATA['File']);
				if($dao->Update($file))
				{
					$MSG->success[] = "Dados Atualizados!";
				}
			}
		}

		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT files.id FROM files ";
			$sql .= " WHERE files.deleted_at IS NULL ";
			$page = 1;
			if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['name'] ? " AND files.name LIKE '%".@$_GET['name']."%' " : "";
				$sql .= @$_GET['size'] ? " AND files.size LIKE '%".@$_GET['size']."%' " : "";
				$sql .= @$_GET['type'] ? " AND files.type LIKE '%".@$_GET['type']."%' " : "";
				$sql .= @$_GET['path'] ? " AND files.path LIKE '%".@$_GET['path']."%' " : "";
			}

			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->files[] = $dao->Retrieve('Files', $row['id'], true, true);
			}
			return parent::paginate($this->files, $page, $limit);
		}
	}
?>
