<?php

class Framework_Controller extends App_Controller {
	
	private $tables = false;
	private $models = false;
	private $controllers = false;

	public function createModel()
	{
		global $MSG;

		if ($_POST['tabelas']) 
		{
			$tabelas = $_POST['tabelas'];
			foreach ($tabelas as $table) 
			{
				$inflector = new Inflector();
				$model_name = ucfirst($inflector->singularize($table));
				$pagename = APPROOT.DS."models".DS.$model_name.".class.php";
				if (file_exists($pagename)) 
				{
					$models_exist[] = "A tabela <span style=\"color:#000000\">".$table."</span> já possui modelo: <p><span style=\"color:#000000\">".$model_name.".class.php</span></p>";
				} else
				{
					$models_create[] = "O modelo da tabela <span style=\"color:#000000\">".$table."</span> foi criado: <p><span style=\"color:#000000\">".$model_name.".class.php</span></p>";
					$filds = filds_name_model($table);
					$text = '';
					$fp = fopen($pagename , "w+");
					$text .= '<?php'.PHP_EOL;
					$text .= '	class '.$model_name.' extends Common'.PHP_EOL;
					$text .= '	{'.PHP_EOL;
					foreach ($filds as $name) 
					{
						$text .= '		public $'.$name.';'.PHP_EOL;
					}
					$text .= '		'.PHP_EOL;
					$text .= '		public $rel;'.PHP_EOL;
					$text .= '		'.PHP_EOL;
					$text .= '		function __construct($params=NULL)'.PHP_EOL;
					$text .= '		{'.PHP_EOL;
					$text .= '			$this->constructor($params);'.PHP_EOL;
					$text .= '			$dao = new DAO();'.PHP_EOL;
					$text .= '			$this->rel = $dao->get_related($this);'.PHP_EOL;
					$text .= '			return $this;'.PHP_EOL;
					$text .= '		}'.PHP_EOL;
					$text .= '	}'.PHP_EOL;
					$text .= '?>'.PHP_EOL;
					$fw = fwrite($fp, $text);
					chmod($pagename, 0777);
					fclose($fp);
				}
			}
			foreach ($models_create as $c) 
			{
				$MSG->success[] = $c;
			}			
			foreach ($models_exist as $e) 
			{
				$MSG->info[] = $e;
			}
		}
		return false;
	}

	public function createController()
	{
		global $MSG;

		if ($_POST['modelos']) 
		{
			$modelos = $_POST['modelos'];
			foreach ($modelos as $model) 
			{
				$inflector = new Inflector();
				$name = str_replace(".class.php", "", $model);
				$controll_name = strtolower($inflector->pluralize($name));
				$pagename = APPROOT.DS."controllers".DS.$controll_name."_controller.php";
				if (file_exists($pagename)) 
				{
					$controll_exist[] = "O Model <span style=\"color:#000000\">".$model."</span> já possui Controller: <p><span style=\"color:#000000\">".$controll_name."_controller.php</span></p>";
				} else
				{
					$controll_create[] = "O Controller do Model <span style=\"color:#000000\">".$model."</span> foi criado: <p><span style=\"color:#000000\">".$controll_name."_controller.php</span></p>";
					$model_ref = $name;
					$filds = filds_name_controll($controll_name);
					$text  = '';
					$fp    = fopen($pagename , "w+");
					$text .= '<?php'.PHP_EOL;
					$text .= '	class '.ucfirst($controll_name).'_Controller extends App_Controller'.PHP_EOL;
					$text .= '	{'.PHP_EOL;
					$text .= '		'.PHP_EOL;
					$text .= '		private $'.$controll_name.' = false;'.PHP_EOL;
					$text .= '		'.PHP_EOL;
					$text .= '		public static function add()'.PHP_EOL;
					$text .= '		{'.PHP_EOL;
					$text .= '			global $DATA;'.PHP_EOL;
					$text .= '			global $MSG;'.PHP_EOL;
					$text .= '			'.PHP_EOL;
					$text .= '			if($DATA[\''.$model_ref.'\'])'.PHP_EOL;
					$text .= '			{'.PHP_EOL;
					$text .= '				// campos obrigatoios'.PHP_EOL;
					foreach ($filds as $fild_name) 
					{
						if ($fild_name != 'id' && $fild_name != 'created_at' && $fild_name != 'updated_at' && $fild_name != 'deleted_at') 
						{
							$text .= '				validates_presence_of(\''.$model_ref.'\', \''.$fild_name.'\', \''.strtoupper($fild_name).'\');'.PHP_EOL;
						}
					}
					$text .= '				'.PHP_EOL;
					foreach ($filds as $fild_name) 
					{
						if ($fild_name === 'email' || $fild_name === 'cpf' || $fild_name === 'cnpj' || $fild_name === 'cpfCnpj') 
						{
							$text .= '				// valida se o email, CPF ou CNPJ informado e valido'.PHP_EOL;
							$text .= '				validates_format_of(\''.$model_ref.'\', \''.$fild_name.'\', \''.$fild_name.'\', \''.strtoupper($fild_name).'\', TRUE );'.PHP_EOL;
						}
					}
					$text .= '				'.PHP_EOL;
					foreach ($filds as $fild_name) 
					{
						if ($fild_name === 'email' || $fild_name === 'cpf' || $fild_name === 'cnpj' || $fild_name === 'cpfCnpj') 
						{
							$text .= '				// valida se o campo informado e unico'.PHP_EOL;
							$text .= '				validates_uniqueness_of(\''.$fild_name.'\', $DATA[\''.$model_ref.'\'], \''.$model_ref.'\', \''.strtoupper($fild_name).'\');'.PHP_EOL;
						}
					}
					$text .= '				'.PHP_EOL;
					$text .= '				// valida as funções acima caso de erro retorna p/ o usuario'.PHP_EOL;
					$text .= '				if(check_errors())'.PHP_EOL;
					$text .= '				{'.PHP_EOL;
					$text .= '					return false;'.PHP_EOL;
					$text .= '				}'.PHP_EOL;
					$text .= '				'.PHP_EOL;
					$text .= '				// caso não haja error o objeto DAO e instanciado'.PHP_EOL;
					$text .= '				$dao = new DAO();'.PHP_EOL;
					$text .= '				'.PHP_EOL;
					if (in_array('senha', $filds)) 
					{
						$text .= '				// caso exista o campo senha ou password'.PHP_EOL;
						$text .= '				$DATA[\''.$model_ref.'\'][\'senha\'] = md5($DATA[\''.$model_ref.'\'][\'senha\']);'.PHP_EOL;
						$text .= '				'.PHP_EOL;
					}
					$text .= '				// instacia o objeto da Class principal'.PHP_EOL;
					$text .= '				$'.strtolower($model_ref).' = new '.$model_ref.'($DATA[\''.$model_ref.'\']);'.PHP_EOL;
					$text .= '				'.PHP_EOL;
					$text .= '				if($dao->Create($'.strtolower($model_ref).'))'.PHP_EOL;
					$text .= '				{'.PHP_EOL;
					$text .= '					$MSG->success[] = "Cadastro efetuado!";'.PHP_EOL;
					$text .= '					$_POST = array();'.PHP_EOL;
					$text .= '				}else'.PHP_EOL;
					$text .= '				{'.PHP_EOL;
					$text .= '					$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";'.PHP_EOL;
					$text .= '				}'.PHP_EOL;
					$text .= '			}'.PHP_EOL;
					$text .= '			return false;'.PHP_EOL;
					$text .= '		}'.PHP_EOL;
					$text .= '		'.PHP_EOL;
					$text .= '		public function update($'.strtolower($model_ref).')'.PHP_EOL;
					$text .= '		{'.PHP_EOL;
					$text .= '			global $DATA;'.PHP_EOL;
					$text .= '			global $MSG;'.PHP_EOL;
					$text .= '			'.PHP_EOL;
					$text .= '			if($DATA[\''.$model_ref.'\'])'.PHP_EOL;
					$text .= '			{'.PHP_EOL;
					$text .= '				// campos obrigatoios'.PHP_EOL;
					foreach ($filds as $fild_name) 
					{
						if ($fild_name != 'id' && $fild_name != 'created_at' && $fild_name != 'updated_at' && $fild_name != 'deleted_at') 
						{
							$text .= '				validates_presence_of(\''.$model_ref.'\', \''.$fild_name.'\', \''.strtoupper($fild_name).'\');'.PHP_EOL;
						}
					}
					$text .= '				'.PHP_EOL;
					foreach ($filds as $fild_name) 
					{
						if ($fild_name === 'email' || $fild_name === 'cpf' || $fild_name === 'cnpj' || $fild_name === 'cpfCnpj') 
						{
							$text .= '				// valida se o email, CPF ou CNPJ informado e valido'.PHP_EOL;
							$text .= '				validates_format_of(\''.$model_ref.'\', \''.$fild_name.'\', \''.$fild_name.'\', \''.strtoupper($fild_name).'\', TRUE );'.PHP_EOL;
						}
					}
					$text .= '				'.PHP_EOL;
					/*foreach ($filds as $fild_name) 
					{
						if ($fild_name === 'email' || $fild_name === 'cpf' || $fild_name === 'cnpj') 
						{
							$text .= '				// valida se o campo informado e unico'.PHP_EOL;
							$text .= '				validates_uniqueness_of(\''.$fild_name.'\', $DATA[\''.$model_ref.'\'], \''.$model_ref.'\', \''.strtoupper($fild_name).'\');'.PHP_EOL;
						}
					}*/
					$text .= '				'.PHP_EOL;
					$text .= '				// valida as funções acima caso de erro retorna p/ o usuario'.PHP_EOL;
					$text .= '				if(check_errors())'.PHP_EOL;
					$text .= '				{'.PHP_EOL;
					$text .= '					return false;'.PHP_EOL;
					$text .= '				}'.PHP_EOL;
					$text .= '				// caso não haja error o objeto DAO e instanciado'.PHP_EOL;
					$text .= '				$dao = new DAO();'.PHP_EOL;
					$text .= '				'.PHP_EOL;
					if (in_array('senha', $filds)) 
					{
						$text .= '				// caso exista o campo senha ou password'.PHP_EOL;
						$text .= '				if(array_key_exists(\'senha\', $DATA[\''.$model_ref.'\']))'.PHP_EOL;
						$text .= '				{'.PHP_EOL;
						$text .= '					$DATA[\''.$model_ref.'\'][\'senha\'] = md5($DATA[\''.$model_ref.'\'][\'senha\']);'.PHP_EOL;
						$text .= '				}'.PHP_EOL;
						$text .= '				'.PHP_EOL;
					}else
					{
						$text .= '				'.PHP_EOL;
					}
					$text .= '				$'.strtolower($model_ref).' = batch_update($'.strtolower($model_ref).', $DATA[\''.$model_ref.'\']);'.PHP_EOL;
					$text .= '				if($dao->Update($'.strtolower($model_ref).'))'.PHP_EOL;
					$text .= '				{'.PHP_EOL;
					$text .= '					$MSG->success[] = "Dados Atualizados!";'.PHP_EOL;
					$text .= '				}'.PHP_EOL;
					$text .= '			}'.PHP_EOL;
					$text .= '		}'.PHP_EOL;
					$text .= '		'.PHP_EOL;
					$text .= '		public function filter()'.PHP_EOL;
					$text .= '		{'.PHP_EOL;
					$text .= '			$dao  = new DAO();'.PHP_EOL;
					$text .= '			$sql  = "SELECT '.$controll_name.'.id FROM '.$controll_name.' ";'.PHP_EOL;
					$text .= '			$sql .= " WHERE '.$controll_name.'.deleted_at IS NULL ";'.PHP_EOL;
					$text .= '			$page = 1;'.PHP_EOL;
					$text .= '			if($_GET)'.PHP_EOL;
					$text .= '			{'.PHP_EOL;
					$text .= '				$page = @$_GET[\'page\'] ? @$_GET[\'page\'] : $page;'.PHP_EOL;
					foreach ($filds as $fild_name) 
					{
						if ($fild_name != 'senha' && $fild_name != 'password' && $fild_name != 'id' && $fild_name != 'created_at' && $fild_name != 'updated_at' && $fild_name != 'deleted_at') 
						{
							$text .= '				$sql .= @$_GET[\''.$fild_name.'\'] ? " AND '.$controll_name.'.'.$fild_name.' LIKE \'%".@$_GET[\''.$fild_name.'\']."%\' " : "";'.PHP_EOL;
						}
					}
					$text .= '			}'.PHP_EOL;
					$text .= '				'.PHP_EOL;
					$text .= '			$q = mysql_query($sql) or die(mysql_error());'.PHP_EOL;
					$text .= '			if (!mysql_num_rows($q)) return false;'.PHP_EOL;
					$text .= '			while ($row = mysql_fetch_assoc($q))'.PHP_EOL;
					$text .= '			{'.PHP_EOL;
					$text .= '				$this->'.$controll_name.'[] = $dao->Retrieve(\''.ucfirst($controll_name).'\', $row[\'id\'], true, true);'.PHP_EOL;
					$text .= '			}'.PHP_EOL;
					$text .= '			return parent::paginate($this->'.$controll_name.', $page, $limit);'.PHP_EOL;
					$text .= '		}'.PHP_EOL;
					$text .= '	}'.PHP_EOL;
					$text .= '?>'.PHP_EOL;
					$fw = fwrite($fp, $text);
					chmod($pagename, 0777);
					fclose($fp);
				}
			}
			foreach ($controll_create as $c) 
			{
				$MSG->success[] = $c;
			}			
			foreach ($controll_exist as $e) 
			{
				$MSG->info[] = $e;
			}	
		}
		return false;
	}

	public function createView()
	{
		global $MSG;

		if ($_POST['controlador']) 
		{
			$inflector = new Inflector();
			$controlador = $_POST['controlador'];
			$tabela = str_replace('_controller.php', '', $controlador);
			$paginas = array('index.php', 'add.php', 'update.php', 'show.php', 'delete.php');
			$dir = APPROOT.DS."views".DS.$tabela;
			$modelo = ucfirst($inflector->singularize($tabela));
			
			if (!file_exists($dir)) 
			{
				mkdir($dir, 0700);
				chmod($dir, 0777);
			}
			foreach ($paginas as $p) 
			{
				if (file_exists($dir.DS.$p)) 
				{
					$file_e[] = "A pasta <span style=\"color:#000000\">".$tabela."</span> já possui a Page: <p><span style=\"color:#000000\">".$p."</span></p>";
				}else
				{
					if ($p === 'index.php') 
					{
						$file_n[] = "O arquivo <span style=\"color:#000000\">".$p."</span> foi criado com Sucesso no diretorio: <p><span style=\"color:#000000\">".$dir."</span></p>";
						$filds  = filds_name_page($tabela);
						$text   = '';
						$fi     = fopen($dir.DS.$p , "w+");
						$text   = '<?/** @author Giceu Cassiano **/?>'.PHP_EOL;
						$text  .= '<!DOCTYPE hmtl>'.PHP_EOL; 
						$text  .= '<html lang="pt-br">'.PHP_EOL; 
						$text  .= '	<head>'.PHP_EOL; 
						$text  .= '		<?'.PHP_EOL; 
						$text  .= '			head("'.ucfirst($tabela).'");'.PHP_EOL; 
						$text  .= '			auth("yes");'.PHP_EOL; 
						$text  .= '			$'.$tabela.'_controller = new '.ucfirst($tabela).'_Controller();'.PHP_EOL; 
						$text  .= '			if (array_key_exists(\'deleted\', $_SESSION))'.PHP_EOL; 
						$text  .= '			{'.PHP_EOL; 
						$text  .= '				$MSG->success[] = "'.ucfirst($tabela).' Excluido.";'.PHP_EOL; 
						$text  .= '				unset($_SESSION[\'deleted\']);'.PHP_EOL; 
						$text  .= '			}'.PHP_EOL; 
						$text  .= '		?>'.PHP_EOL; 
						$text  .= '	</head>'.PHP_EOL; 
						$text  .= '	<body>'.PHP_EOL; 
						$text  .= '		<?topbar();?>'.PHP_EOL; 
						$text  .= '		<?include DOCROOT."/app/views/protected/sidebar.php";?>'.PHP_EOL; 
						$text  .= '		<?HTML::main_content_START("main-content");?>'.PHP_EOL; 
						$text  .= '			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>'.PHP_EOL;
						$text  .= '			<?Menus_Controller::breadcrumbs("'.$tabela.'", "icon-picture", null, null, null);?>'.PHP_EOL;
						$text  .= '			<?default_messages()?>'.PHP_EOL;
						$text  .= '			<?HTML::container_START("container-fluid padded");?>'.PHP_EOL;
						$text  .= '				<?HTML::row_START("row-fluid");?>'.PHP_EOL;
						$text  .= '					<?HTML::span_START("12");?>'.PHP_EOL;
						$text  .= '						<?HTML::box_START("icon-list", "Coloque aqui o Titulo da Lista");?>'.PHP_EOL;
						$text  .= '							<div id="dataTables">'.PHP_EOL;
						$text  .= '								<?if ($'.$tabela.'_list = $'.$tabela.'_controller->filter()):?>'.PHP_EOL;
						$text  .= '									<table cellpadding="0" cellspacing="0" border="0" class="dTable responsive">'.PHP_EOL;
						$text  .= '										<thead>'.PHP_EOL;
						$text  .= '											<tr>'.PHP_EOL;
						foreach ($filds as $campo => $tipo) 
						{
							$text  .= '												<th><stong>'.strtoupper($campo).'</stong></th>'.PHP_EOL; 
						}
						$text  .= '												<th style="width:120px"><stong>Opções</stong></th>'.PHP_EOL;
						$text  .= '											</tr>'.PHP_EOL;
						$text  .= '										</thead>'.PHP_EOL;
						$text  .= '										<tbody>'.PHP_EOL;
						$text  .= '											<?foreach($'.$tabela.'_list[\'query\'] as $'.$tabela.'):?>'.PHP_EOL;
						$text  .= '												<tr>'.PHP_EOL;
						foreach ($filds as $campo => $tipo) 
						{
							if ($tipo != 'datetime') 
							{
								$text  .= '													<td><?=$'.$tabela.'->'.$campo.'?></td>'.PHP_EOL; 
							}
							if ($tipo == 'datetime')
							{
								$text  .= '													<td style="text-align:center"><?=format_date($'.$tabela.'->'.$campo.', "/")?></td>'.PHP_EOL; 
							}
						}
						$text  .= '													<td class="center">'.PHP_EOL;
						$text  .= '														<a href="<?=WWWROOT.\'/'.$tabela.'/show/\'.$'.$tabela.'->id?>" class="btn btn-mini btn-gray tip" title="Detalhes"><i class="icon-list-alt"></i></a>'.PHP_EOL;
						$text  .= '														<a href="<?=WWWROOT.\'/'.$tabela.'/update/\'.$'.$tabela.'->id?>" class="btn btn-mini btn-black tip" title="Editar"><i class="icon-edit"></i></a>'.PHP_EOL;
						$text  .= '														<a href="<?=WWWROOT.\'/'.$tabela.'/delete/\'.$'.$tabela.'->id?>" class="btn btn-mini btn-red tip" title="Excluir"><i class="icon-trash icon-white"></i></a>'.PHP_EOL;
						$text  .= '													</td>'.PHP_EOL;
						$text  .= '												</tr>'.PHP_EOL;
						$text  .= '											<?endforeach?>'.PHP_EOL;
						$text  .= '										</tbody>'.PHP_EOL;
						$text  .= '									</table>'.PHP_EOL;
						$text  .= '								<?else:?>'.PHP_EOL;
						$text  .= '									<div class="alert alert-info">Sem resultados</div>'.PHP_EOL;
						$text  .= '								<?endif?>'.PHP_EOL;
						$text  .= '							</div>'.PHP_EOL;
						$text  .= '							<?Form_html::form_actions_START()?>'.PHP_EOL;
						$text  .= '								<span class="pull-right"><a href="<?=WWWROOT.\'/'.$tabela.'/add\'?>" class="btn btn-blue tip" title="Detalhes"><i class="icon-plus"></i> Novo Cadastro</a></span>'.PHP_EOL;
						$text  .= '							<?Form_html::form_actions_END()?>'.PHP_EOL;
						$text  .= '						<?HTML::box_END();?>'.PHP_EOL;
						$text  .= '					<?HTML::span_END();?>'.PHP_EOL;
						$text  .= '				<?HTML::row_END();?>'.PHP_EOL;
						$text  .= '			<?HTML::container_END();?>'.PHP_EOL;
						$text  .= '		<?HTML::main_content_END();?>'.PHP_EOL; 
						$text  .= '		<?scripts();?>'.PHP_EOL; 
						$text  .= '	</body>'.PHP_EOL; 
						$text  .= '</html>'.PHP_EOL;
						$fw = fwrite($fi, $text);
						chmod($dir.DS.$p , 0777);
						fclose($fi);
					}
					if ($p === 'add.php') 
					{
						$file_n[] = "O arquivo <span style=\"color:#000000\">".$p."</span> foi criado com Sucesso no diretorio: <p><span style=\"color:#000000\">".$dir."</span></p>";
						$filds  = filds_name_page($tabela);
						$text   = '';
						$fa     = fopen($dir.DS.$p , "w+");
						$text   = '<?/** @author Giceu Cassiano **/?>'.PHP_EOL;
						$text  .= '<!DOCTYPE hmtl>'.PHP_EOL; 
						$text  .= '<html lang="pt-br">'.PHP_EOL; 
						$text  .= '	<head>'.PHP_EOL; 
						$text  .= '		<?'.PHP_EOL; 
						$text  .= '			head("New '.ucfirst($tabela).'");'.PHP_EOL; 
						$text  .= '			auth("yes");'.PHP_EOL; 
						$text  .= '			$'.$tabela.'_controller = new '.ucfirst($tabela).'_Controller();'.PHP_EOL; 
						$text  .= '			$'.$tabela.'_controller->add();'.PHP_EOL; 
						foreach ($filds as $campo => $tipo) 
						{
							if (strpos($campo, '_id')) 
							{
								$new = ucfirst($inflector->pluralize(str_replace('_id', '', $campo)));
								$text  .= '			$'.$new.' = $dao->Retrieve("'.$new.'", "ORDER BY id");'.PHP_EOL; 
								
							}
						}
						$text  .= '		?>'.PHP_EOL; 
						$text  .= '	</head>'.PHP_EOL; 
						$text  .= '	<body>'.PHP_EOL; 
						$text  .= '		<?topbar();?>'.PHP_EOL; 
						$text  .= '		<?include DOCROOT."/app/views/protected/sidebar.php";?>'.PHP_EOL; 
						$text  .= '		<?HTML::main_content_START("main-content");?>'.PHP_EOL; 
						$text  .= '			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>'.PHP_EOL;
						$text  .= '			<?Menus_Controller::breadcrumbs("'.$tabela.'", "icon-picture", null, null, null);?>'.PHP_EOL;
						$text  .= '			<?default_messages()?>'.PHP_EOL;
						$text  .= '			<?HTML::container_START("container-fluid padded");?>'.PHP_EOL;
						$text  .= '				<?HTML::row_START("row-fluid");?>'.PHP_EOL;
						$text  .= '					<?HTML::span_START("12");?>'.PHP_EOL;
						$text  .= '						<?HTML::box_START("icon-picture", "Coloque aqui o Titulo do Formulario");?>'.PHP_EOL;
						$text  .= '							<?$form = new Form_html(array(\'class\'=>\'form-horizontal fill-up validatable\'));'.PHP_EOL;
						$text  .= '							$form->Start();?>'.PHP_EOL;
						$text  .= '								<?Form_html::form_START()?>'.PHP_EOL;
						foreach ($filds as $campo => $tipo) 
						{
							if (strpos($campo, '_id')) 
							{
								$new_field = ucfirst($inflector->pluralize(str_replace('_id', '', $campo)));
								$text  .= '									'.PHP_EOL; 
								$text  .= '									<?$form->InputGroup_Start("'.$new_field.'")?>'.PHP_EOL; 
								$text  .= '										<?$form->Select($'.$new_field.', array(\'class\'=>\'chzn-select span4\'), \''.$modelo.'\', \''.$campo.'\', \'id\')?>'.PHP_EOL; 
								$text  .= '									<?$form->InputGroup_End()?>'.PHP_EOL; 
								$text  .= '									'.PHP_EOL; 
																
							}else
							{
								if($campo != 'id' && $campo != 'created_at' && $campo != 'updated_at' && $campo != 'deleted_at')
								{
									$text  .= '									<?$form->InputGroup_Start("'.strtoupper($campo).'")?>'.PHP_EOL; 
									$text  .= '										<?$form->Input(array(\'type\'=>\'text\', \'class\'=>\'span8\'), \''.$modelo.'\', \''.$campo.'\')?>'.PHP_EOL; 
									$text  .= '									<?$form->InputGroup_End()?>'.PHP_EOL; 
									$text  .= '									'.PHP_EOL; 
								}
							}
						}
						$text  .= '								<?Form_html::form_END()?>'.PHP_EOL;
						$text  .= '								<?Form_html::form_actions_START()?>'.PHP_EOL;
						$text  .= '									<button type="submit" class="btn btn-blue"><i class="icon-save"></i> Salvar</button>'.PHP_EOL;
						$text  .= '									<a href="<?=WWWROOT?>/'.$tabela.'" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>'.PHP_EOL;
						$text  .= '								<?Form_html::form_actions_END()?>'.PHP_EOL;
						$text  .= '							<?$form->End()?>'.PHP_EOL;
						$text  .= '						<?HTML::box_END();?>'.PHP_EOL;
						$text  .= '					<?HTML::span_END();?>'.PHP_EOL;
						$text  .= '				<?HTML::row_END();?>'.PHP_EOL;
						$text  .= '			<?HTML::container_END();?>'.PHP_EOL;
						$text  .= '		<?HTML::main_content_END();?>'.PHP_EOL; 
						$text  .= '		<?scripts();?>'.PHP_EOL; 
						$text  .= '	</body>'.PHP_EOL; 
						$text  .= '</html>'.PHP_EOL;
						$fw = fwrite($fa, $text);
						chmod($dir.DS.$p , 0777);
						fclose($fa);	
					}
					if ($p === 'update.php') 
					{
						$file_n[] = "O arquivo <span style=\"color:#000000\">".$p."</span> foi criado com Sucesso no diretorio: <p><span style=\"color:#000000\">".$dir."</span></p>";
						$filds  = filds_name_page($tabela);
						$text   = '';
						$fu     = fopen($dir.DS.$p , "w+");
						$text   = '<?/** @author Giceu Cassiano **/?>'.PHP_EOL;
						$text  .= '<!DOCTYPE hmtl>'.PHP_EOL; 
						$text  .= '<html lang="pt-br">'.PHP_EOL; 
						$text  .= '	<head>'.PHP_EOL; 
						$text  .= '		<?'.PHP_EOL; 
						$text  .= '			head("Alter '.ucfirst($tabela).'");'.PHP_EOL; 
						$text  .= '			auth("yes");'.PHP_EOL;
						$text  .= '			if (!$'.$tabela.' = $dao->Retrieve(\''.ucfirst($tabela).'\', @$params[0], true, true))'.PHP_EOL; 
						$text  .= '			{'.PHP_EOL; 
						$text  .= '				error_404();'.PHP_EOL; 
						$text  .= '			}'.PHP_EOL; 
						foreach ($filds as $campo => $tipo) 
						{
							if (strpos($campo, '_id')) 
							{
								$new = ucfirst($inflector->pluralize(str_replace('_id', '', $campo)));
								$text  .= '			$'.$new.' = $dao->Retrieve("'.$new.'", "ORDER BY id");'.PHP_EOL; 
								
							}
						}
						$text  .= '			$'.$tabela.'_controller = new '.ucfirst($tabela).'_Controller();'.PHP_EOL; 
						$text  .= '			$'.$tabela.'_controller->update($'.$tabela.');'.PHP_EOL; 
						$text  .= '			$'.$tabela.' = $dao->Retrieve(\''.ucfirst($tabela).'\', @$params[0], true, true);'.PHP_EOL; 
						$text  .= '		?>'.PHP_EOL; 
						$text  .= '	</head>'.PHP_EOL; 
						$text  .= '	<body>'.PHP_EOL; 
						$text  .= '		<?topbar();?>'.PHP_EOL; 
						$text  .= '		<?include DOCROOT."/app/views/protected/sidebar.php";?>'.PHP_EOL; 
						$text  .= '		<?HTML::main_content_START("main-content");?>'.PHP_EOL; 
						$text  .= '			<?bar($icon="icon-picture", $titulo="Coloque aqui o Titulo!", $descricao="Coloque aqui a Descrição!");?>'.PHP_EOL;
						$text  .= '			<?Menus_Controller::breadcrumbs("'.$tabela.'", "icon-picture", null, null, null);?>'.PHP_EOL;
						$text  .= '			<?default_messages()?>'.PHP_EOL;
						$text  .= '			<?HTML::container_START("container-fluid padded");?>'.PHP_EOL;
						$text  .= '				<?HTML::row_START("row-fluid");?>'.PHP_EOL;
						$text  .= '					<?HTML::span_START("12");?>'.PHP_EOL;
						$text  .= '						<?HTML::box_START("icon-picture", "Coloque aqui o Titulo do Formulario");?>'.PHP_EOL;
						$text  .= '							<?$form = new Form_html(array(\'class\'=>\'form-horizontal fill-up validatable\'));'.PHP_EOL;
						$text  .= '							$form->Start();?>'.PHP_EOL;
						$text  .= '								<?Form_html::form_START()?>'.PHP_EOL;
						foreach ($filds as $campo => $tipo) 
						{
							if (strpos($campo, '_id')) 
							{
								$new_field = ucfirst($inflector->pluralize(str_replace('_id', '', $campo)));
								$text  .= '									'.PHP_EOL; 
								$text  .= '									<?$form->InputGroup_Start("'.$new_field.'")?>'.PHP_EOL; 
								$text  .= '										<?$form->Select($'.$new_field.', array(\'class\'=>\'chzn-select span4\'), \''.$modelo.'\', \''.$campo.'\', \'id\', $'.$tabela.'->'.$campo.')?>'.PHP_EOL; 
								$text  .= '									<?$form->InputGroup_End()?>'.PHP_EOL; 
								$text  .= '									'.PHP_EOL; 
																
							}else
							{
								if($campo != 'id' && $campo != 'created_at' && $campo != 'updated_at' && $campo != 'deleted_at')
								{
									$text  .= '									<?$form->InputGroup_Start("'.strtoupper($campo).'")?>'.PHP_EOL; 
									$text  .= '										<?$form->Input(array(\'type\'=>\'text\', \'class\'=>\'span8\', \'value\'=>$'.$tabela.'->'.$campo.'), \''.$modelo.'\', \''.$campo.'\')?>'.PHP_EOL; 
									$text  .= '									<?$form->InputGroup_End()?>'.PHP_EOL; 
									$text  .= '									'.PHP_EOL; 
								}
							}
						}
						$text  .= '								<?Form_html::form_END()?>'.PHP_EOL;
						$text  .= '								<?Form_html::form_actions_START()?>'.PHP_EOL;
						$text  .= '									<button type="submit" class="btn btn-blue"><i class="icon-save"></i> Salvar</button>'.PHP_EOL;
						$text  .= '									<a href="<?=WWWROOT?>/'.$tabela.'" class="btn btn-gold"><i class="icon-remove-sign"></i> Cancelar</a>'.PHP_EOL;
						$text  .= '								<?Form_html::form_actions_END()?>'.PHP_EOL;
						$text  .= '							<?$form->End()?>'.PHP_EOL;
						$text  .= '						<?HTML::box_END();?>'.PHP_EOL;
						$text  .= '					<?HTML::span_END();?>'.PHP_EOL;
						$text  .= '				<?HTML::row_END();?>'.PHP_EOL;
						$text  .= '			<?HTML::container_END();?>'.PHP_EOL;
						$text  .= '		<?HTML::main_content_END();?>'.PHP_EOL; 
						$text  .= '		<?scripts();?>'.PHP_EOL; 
						$text  .= '	</body>'.PHP_EOL; 
						$text  .= '</html>'.PHP_EOL;
						$fw = fwrite($fu, $text);
						chmod($dir.DS.$p , 0777);
						fclose($fu);	
					}
					if ($p === 'delete.php') 
					{
						$file_n[] = "O arquivo <span style=\"color:#000000\">".$p."</span> foi criado com Sucesso no diretorio: <p><span style=\"color:#000000\">".$dir."</span></p>";
						$filds  = filds_name_page($tabela);
						$text   = '';
						$fd     = fopen($dir.DS.$p , "w+");
						$text   = '<?/** @author Giceu Cassiano **/?>'.PHP_EOL;
						$text  .= '	<?'.PHP_EOL; 
						$text  .= '		auth("yes");'.PHP_EOL;
						$text  .= '		if (!$'.$tabela.' = $dao->Retrieve(\''.ucfirst($tabela).'\', @$params[0], true, true))'.PHP_EOL; 
						$text  .= '		{'.PHP_EOL; 
						$text  .= '			error_404();'.PHP_EOL; 
						$text  .= '		}'.PHP_EOL; 
						$text  .= '		 '.PHP_EOL; 
						$text  .= '		$dao->Delete($'.$tabela.');'.PHP_EOL; 
						$text  .= '		$_SESSION[\'deleted\'] = true;'.PHP_EOL; 
						$text  .= '		header(\'location:\'.$_SERVER[\'HTTP_REFERER\']);'.PHP_EOL; 
						$text  .= '	?>'.PHP_EOL; 
						$fw = fwrite($fd, $text);
						chmod($dir.DS.$p , 0777);
						fclose($fd);	
					}
					if ($p === 'show.php') 
					{
						$file_n[] = "O arquivo <span style=\"color:#000000\">".$p."</span> foi criado com Sucesso no diretorio: <p><span style=\"color:#000000\">".$dir."</span></p>";
						$filds  = filds_name_page($tabela);
						$text   = '';
						$fs     = fopen($dir.DS.$p , "w+");
						$text   = '<?/** @author Giceu Cassiano **/?>'.PHP_EOL;
						$text  .= '<!DOCTYPE hmtl>'.PHP_EOL; 
						$text  .= '<html lang="pt-br">'.PHP_EOL; 
						$text  .= '	<head>'.PHP_EOL; 
						$text  .= '		<?'.PHP_EOL; 
						$text  .= '			head("Detail '.ucfirst($tabela).'");'.PHP_EOL; 
						$text  .= '			auth("yes");'.PHP_EOL; 
						$text  .= '		?>'.PHP_EOL; 
						$text  .= '	</head>'.PHP_EOL; 
						$text  .= '	<body>'.PHP_EOL; 
						$text  .= '		<?topbar();?>'.PHP_EOL; 
						$text  .= '		<?include DOCROOT."/app/views/protected/sidebar.php";?>'.PHP_EOL; 
						$text  .= '		<?HTML::main_content_START("main-content");?>'.PHP_EOL; 
						$text  .= '			<?default_messages()?>'.PHP_EOL;
						$text  .= '			<?HTML::container_START("container-fluid padded");?>'.PHP_EOL;
						$text  .= '				<?HTML::row_START("row-fluid");?>'.PHP_EOL;
						$text  .= '					<?HTML::span_START("12");?>'.PHP_EOL;
						$text  .= '						<?HTML::show_container_START()?>'.PHP_EOL;
						$text  .= '							<?if ($'.$modelo.' = $dao->Retrieve(\''.$modelo.'\', $params[0], true, true)):?>'.PHP_EOL;
						$text  .= '								<?HTML::show_header_START();?>'.PHP_EOL;
						$text  .= '									<div class="span4">'.PHP_EOL;
						$text  .= '										<h1 class="pull-right" style="color:#FFFFFF"><?=sobreNome("O Texto Que Você Quiser!")?></h1>'.PHP_EOL;
						$text  .= '									</div>'.PHP_EOL;
						$text  .= '									<div class="span5">'.PHP_EOL;
						$text  .= '										<p>Detalhes do Cadastro</p>'.PHP_EOL;
						$text  .= '									</div>'.PHP_EOL;
						$text  .= '									<div class="span2 pull-right">'.PHP_EOL;
						$text  .= '										<?HTML::show_config();?>'.PHP_EOL;
						$text  .= '									</div>'.PHP_EOL;
						$text  .= '								<?HTML::show_header_END();?>'.PHP_EOL;

						$text  .= '								<?HTML::show_content_START();?>'.PHP_EOL;
						$text  .= '									<?HTML::show_content_title(\'Texto a Sua Escolha\', \'icon-picture\');?>'.PHP_EOL;
						$text  .= '									<?HTML::show_content_box_START()?>'.PHP_EOL;
						foreach ($filds as $campo => $tipo) 
						{
							if ($tipo != 'datetime') 
							{
								$text  .= '												<?HTML::show_content_field(\''.strtoupper($campo).'\', \'icon-picture\', $'.$modelo.'->'.$campo.');?>'.PHP_EOL; 
							}
							if ($tipo == 'datetime')
							{
								$text  .= '												<?HTML::show_content_field(\''.strtoupper($campo).'\', \'icon-picture\', format_date($'.$modelo.'->'.$campo.', "/", $t=false));?>'.PHP_EOL; 
							}
						}
						$text  .= '									<?HTML::show_content_box_END()?>'.PHP_EOL;
						$text  .= '								<?HTML::show_content_END();?>'.PHP_EOL;
						$text  .= '							<?else:?>'.PHP_EOL;
						$text  .= '								<div class="alert alert-info">Sem resultados</div>'.PHP_EOL;
						$text  .= '							<?endif?>'.PHP_EOL;
						$text  .= '						<?HTML::box_END();?>'.PHP_EOL;
						$text  .= '					<?HTML::span_END();?>'.PHP_EOL;
						$text  .= '				<?HTML::row_END();?>'.PHP_EOL;
						$text  .= '			<?HTML::container_END();?>'.PHP_EOL;
						$text  .= '		<?HTML::main_content_END();?>'.PHP_EOL; 
						$text  .= '		<?scripts();?>'.PHP_EOL; 
						$text  .= '		<script>'.PHP_EOL; 
						$text  .= '			$(document).ready(function(){'.PHP_EOL; 
						$text  .= '				$("#paint").hide();'.PHP_EOL; 
						$text  .= '				$(".controller2 #colorir").click(function(){'.PHP_EOL; 
						$text  .= '					$("#paint").slideDown();'.PHP_EOL; 
						$text  .= '				}).dblclick(function(){'.PHP_EOL; 
						$text  .= '					$("#paint").slideUp();'.PHP_EOL; 
						$text  .= '				});'.PHP_EOL; 
						$text  .= '			});'.PHP_EOL; 
						$text  .= '		</script>'.PHP_EOL; 
						$text  .= '	</body>'.PHP_EOL; 
						$text  .= '</html>'.PHP_EOL;
						$fw = fwrite($fs, $text);
						chmod($dir.DS.$p , 0777);
						fclose($fs);
					}
				}
			}
			foreach ($file_e as $e) 
			{
				$MSG->info[] = $e;
			}
			foreach ($file_n as $n) 
			{
				$MSG->success[] = $n;
			}
		}
		return false;
	}

	public function listTables($table=null)
    {
        $where = $table;
        $dao = new DAO();
        $sql = "SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".DATABASE."' {$where} ";
        $page = 1;
      

        $q = mysql_query($sql) or die(mysql_error());
        if (!mysql_num_rows($q)) return false;
        while ($row = mysql_fetch_assoc($q))
        {
            $this->tables[] = $row['TABLE_NAME'];
        }
        return $this->tables;
    }

    public function listModels()
    {
	    $dirr = APPROOT.DS."models";
	    foreach (new DirectoryIterator($dirr) as $diretorio) 
		{
			if($diretorio->isDot()) continue;
			if (!$diretorio->isFile) 
			{
				$this->models[] = $diretorio->getFilename();
			}
		}
        return $this->models;
    }

    public function listControllers()
    {
	    $dirr = APPROOT.DS."controllers";
	    foreach (new DirectoryIterator($dirr) as $diretorio) 
		{
			if($diretorio->isDot()) continue;
			if (!$diretorio->isFile) 
			{
				$file = $diretorio->getFilename();
				if(!preg_match('/^[^a-z]*$/', $file{0})) 
				{
					$this->controllers[] = $file;
				} 
			}
		}
        return $this->controllers;
    }
}

			/*
			$destinatario['Giceu'] = "gcassianof@hotmail.com";
			$destinatario['Cassiano'] = "gcassianof@gmail.com";
			$msgText = "varios array e keys";
			$t = "PHP e o bixo!!!";
			parent::send_email($destinatario, $msgText, $t);
			*/
?>