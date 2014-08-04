<?php
	class Users_Controller extends App_Controller
	{
		
		private $users = false;
		
		public static function add()
		{
			global $DATA;
			global $MSG;
			
			if($DATA['User'])
			{
				// campos obrigatoios
				validates_presence_of('User', 'users_group_id', 'GRUPO DE USUARIO');
				validates_presence_of('User', 'itineraries_id', 'GARGA HORARIA');
				validates_presence_of('User', 'nome', 'NOME');
				validates_presence_of('User', 'matricula', 'MATRICULA');
				validates_presence_of('User', 'cpf', 'CPF');
				validates_presence_of('User', 'email', 'EMAIL');
				validates_presence_of('User', 'senha', 'SENHA');
				validates_equal_of('User', 'senha', 'Confirm', 'password', 'SENHA');
				
				// valida se o email, CPF ou CNPJ informado e valido
				validates_format_of('User', 'cpf', 'cpf', 'CPF', TRUE );
				// valida se o email, CPF ou CNPJ informado e valido
				validates_format_of('User', 'email', 'email', 'EMAIL', TRUE );
				
				// valida se o campo informado e unico
				validates_uniqueness_of('cpf', $DATA['User'], 'User', 'CPF');
				// valida se o campo informado e unico
				validates_uniqueness_of('email', $DATA['User'], 'User', 'EMAIL');
				// valida se o campo informado e unico
				validates_uniqueness_of('matricula', $DATA['User'], 'User', 'MATRICULA');
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				


				// caso exista o campo senha ou password
				$DATA['User']['senha'] = md5($DATA['User']['senha']);
				
				// instacia o objeto da Class principal
				$user = new User($DATA['User']);
				
				if($dao->Create($user))
				{
					$MSG->success[] = "Usuario efetuado!";
					$_POST = array();
				}else
				{
					$MSG->error[] = "Erro no Cadastro. Entre em contato com o Administrador do Sistema!";
				}
			}
			return false;
		}
		
		public function update($user)
		{
			global $DATA;
			global $MSG;
			
			if($DATA['User'])
			{
				// campos obrigatoios
				validates_presence_of('User', 'users_group_id', 'GRUPO DE USUARIO');
				validates_presence_of('User', 'itineraries_id', 'GARGA HORARIA');
				validates_presence_of('User', 'nome', 'NOME');
				validates_presence_of('User', 'matricula', 'MATRICULA');
				validates_presence_of('User', 'cpf', 'CPF');
				validates_presence_of('User', 'email', 'EMAIL');
				validates_presence_of('User', 'senha', 'SENHA');
				
				// valida se o email, CPF ou CNPJ informado e valido
				validates_format_of('User', 'cpf', 'cpf', 'CPF', TRUE );
				// valida se o email, CPF ou CNPJ informado e valido
				validates_format_of('User', 'email', 'email', 'EMAIL', TRUE );
				
				// valida se o campo informado e unico
				validates_uniqueness_of('cpf', $DATA['User'], 'User', 'CPF');
				// valida se o campo informado e unico
				validates_uniqueness_of('email', $DATA['User'], 'User', 'EMAIL');
				// valida se o campo informado e unico
				validates_uniqueness_of('matricula', $DATA['User'], 'User', 'MATRICULA');
				
				
				// valida as funções acima caso de erro retorna p/ o usuario
				if(check_errors())
				{
					return false;
				}
				// caso não haja error o objeto DAO e instanciado
				$dao = new DAO();
				
				// caso exista o campo senha ou password
				if(array_key_exists('senha', $DATA['User']))
				{
					$DATA['User']['senha'] = md5($DATA['User']['senha']);
				}
				
				$user = batch_update($user, $DATA['User']);
				if($dao->Update($user))
				{
					$MSG->success[] = "Dados do Usuario Foram Atualizados!";
				}
			}
		}
		
		public function filter()
		{
			$dao  = new DAO();
			$sql  = "SELECT users.id FROM users ";
			$sql .= " WHERE users.deleted_at IS NULL ";
			$page = 1;
			if($_GET)
			{
				$page = @$_GET['page'] ? @$_GET['page'] : $page;
				$sql .= @$_GET['users_group_id'] ? " AND users.users_group_id LIKE '%".@$_GET['users_group_id']."%' " : "";
				$sql .= @$_GET['nome'] ? " AND users.nome LIKE '%".@$_GET['nome']."%' " : "";
				$sql .= @$_GET['cpf'] ? " AND users.cpf LIKE '%".@$_GET['cpf']."%' " : "";
				$sql .= @$_GET['email'] ? " AND users.email LIKE '%".@$_GET['email']."%' " : "";
			}
				
			$q = mysql_query($sql) or die(mysql_error());
			if (!mysql_num_rows($q)) return false;
			while ($row = mysql_fetch_assoc($q))
			{
				$this->users[] = $dao->Retrieve('Users', $row['id'], true, true);
			}
			return parent::paginate($this->users, $page, $limit);
		}
	}
?>
