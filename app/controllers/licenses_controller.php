<?php
	class Licenses_Controller extends App_Controller
	{

		private $licenses = false;

		public static function add()
		{
			global $DATA;
			global $MSG;

			if($DATA['License'])
			{
				$dao = new DAO();
				if ($DATA['License']['pwd'])
				{
					$data = array(
						'email' => $_SESSION['user_email'],
						'senha' => md5($DATA['License']['pwd'])
					);

					// se houver um usuário no banco de dados com essas credenciais inicia-se a sessão
					if ($user = $dao->Retrieve('Users', $data, true, true))
					{
						/*$dateTime = date("Y-m-d H:i:s");
						$dateVar = date("d/m/Y");
						$var = explode(" ",$dateTime,2);
						$date = $var[0];
						$time = $var[1];
						$Users = $dao->get("Users", $_SESSION['user_id']);*/

						$DATA['License']['user_id'] = $_SESSION['user_id'];

						if ($DATA['License']['atestado'] == 1) {
							$DATA['License']['atestado'] = true;
						} else {
							$DATA['License']['atestado'] = false;
						}

						validates_presence_of('License', 'justificativa', 'JUSTIFICATIVA');
						validates_presence_of('License', 'data', 'DATA');
						validates_presence_of('License', 'inicio', 'INICIO');
						validates_presence_of('License', 'fim', 'FIM');

						if(check_errors())
						{
							return false;
						}

						$DATA['License']['data'] = date("Y-m-d", strtotime($DATA['License']['data']));
						$inicio = new DateTime($DATA['License']['inicio']);
						$fim = new DateTime($DATA['License']['fim']);

						if ($inicio->diff($fim)->format('%R') == '-' || $inicio->diff($fim)->format('%R') == '') {
							$MSG->error[] = "O campo FIM não pode ser menor que INICIO";
							return false;
						}

						if ($inicio == $fim) {
							$MSG->error[] = "O campo FIM não pode ser iqual ao INICIO";
							return false;
						}

						if (!$DATA['License']['atestado']) {
							if (isset($_FILES["uploadFile"])) {
								if($fileSave = upload_files($_FILES["uploadFile"]))
								{
									$name 	= basename($_FILES["uploadFile"]["name"]);
									$size 	= basename($_FILES["uploadFile"]["size"]);
									$type 	= basename($_FILES["uploadFile"]["type"]);
									$path 	= basename($_FILES["uploadFile"]["path"]);

									if ($registroArq = $dao->get("Files", "WHERE files.name like '%".$name."%' AND files.size = ".$size." AND files.type LIKE '%".$type."%' AND files.path LIKE '%".$path."%'")) {
										$DATA['License']['file_id'] = $registroArq[0]->id;
									} else {
										$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
										//$MSG->error[] = "1";
										return false;
									}
								} else {
									$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
									//$MSG->error[] = "2";
									return false;
								}
							}else{
								$MSG->error[] = "Selecione um arquivo";
								return false;
							}
						}

						$dao = new DAO();

						$license = new License($DATA['License']);

						if($dao->Create($license))
						{
							$MSG->success[] = "Cadastro efetuado!";
							$_POST = array();
						}else
						{
							$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
							//$MSG->error[] = "5";
						}
					}else
					{
						$MSG->error[] = 'Erro ao Autenticar. Verifique os dados.';
					}
				}else
				{
					$MSG->alert[] = "Atenção, Favor informa suas credênciais";
				}
			}
			return false;
		}

		public function update($license)
		{
			global $DATA;
			global $MSG;

			if($DATA['License'])
			{
				// campos obrigatoios
				validates_presence_of('License', 'user_id', 'USER_ID');
				validates_presence_of('License', 'file_id', 'FILE_ID');
				validates_presence_of('License', 'data', 'DATA');
				validates_presence_of('License', 'hora', 'HORA');
				validates_presence_of('License', 'dataHora', 'DATAHORA');
				validates_presence_of('License', 'justificativa', 'JUSTIFICATIVA');
				validates_presence_of('License', 'atestado', 'ATESTADO');

				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();


				$license = batch_update($license, $DATA['License']);
				if($dao->Update($license))
				{
					$MSG->success[] = "Dados Atualizados!";
				}
			}
		}

		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT licenses.id FROM licenses ";
			$sql .= " WHERE licenses.deleted_at IS NULL ";
			$page = 1;
			if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['user_id'] ? " AND licenses.user_id LIKE '%".@$_GET['user_id']."%' " : "";
				$sql .= @$_GET['file_id'] ? " AND licenses.file_id LIKE '%".@$_GET['file_id']."%' " : "";
				$sql .= @$_GET['data'] ? " AND licenses.data LIKE '%".@$_GET['data']."%' " : "";
				$sql .= @$_GET['hora'] ? " AND licenses.hora LIKE '%".@$_GET['hora']."%' " : "";
				$sql .= @$_GET['dataHora'] ? " AND licenses.dataHora LIKE '%".@$_GET['dataHora']."%' " : "";
				$sql .= @$_GET['justificativa'] ? " AND licenses.justificativa LIKE '%".@$_GET['justificativa']."%' " : "";
				$sql .= @$_GET['atestado'] ? " AND licenses.atestado LIKE '%".@$_GET['atestado']."%' " : "";
			}

			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->licenses[] = $dao->Retrieve('Licenses', $row['id'], true, true);
			}
			return parent::paginate($this->licenses, $page, $limit);
		}

		public function download($arquivo=null)
		{
			global $MSG;

			if ($arquivo != null) {
				$dao  = new DAO();

				if ($content = $dao->Retrieve('Licenses', $arquivo, true, true)) {
					$target_dir = UPLOADFILES.'/'.basename($content->name);

					if (!file_exists($target_dir)) {
						$MSG->error[] = "Arquivo não existente no repositorio de documentos";
						return false;
					}

					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="'.$content->name.'"');
					header('Content-Type: application/octet-stream');
					header('Content-Transfer-Encoding: binary');
					header('Content-Length: ' . filesize($content->name));
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Expires: 0');

					readfile($target_dir);
				} else {
					$MSG->error[] = "Arquivo inexistente";
				}
			} else {
				$MSG->error[] = "Selecione um arquivo valido";
			}
		}

	}
?>
