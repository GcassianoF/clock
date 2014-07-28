<?php

class Session_Controller extends App_Controller {

	// loga o usuário no sistema e inicia a sessão com dados úteis
	public static function login()
	{
		// variáveis globais a serem usadas, basicamente são sempre essas
		global $DATA;
		global $MSG;

		// verifica se houve envio de formulário
		if ($DATA)
		{
			// escolhe os campos a serem validados
			validates_presence_of('Session', 'email', 'E-mail');
			validates_presence_of('Session', 'senha', 'Senha');
			// valida os campos e em caso de erro joga mensagens padrão e retorna false
			if (check_errors())
			{
				return false;
			}

			// caso tudo ocorra bem o objeto DAO é instanciado
			$dao = new DAO();

			// e os dados do login são informados neste bonito array
			$data = array(
				'email' => $DATA['Session']['email'],
				'senha' => md5($DATA['Session']['senha'])
			);

			// se houver um usuário no banco de dados com essas credenciais inicia-se a sessão
			if ($user = $dao->Retrieve('Users', $data, true, true))
			{
				$_SESSION['logged_in']      = true;
				$_SESSION['user_id']        = $user->id;
				$_SESSION['user_email']     = $user->email;
				$_SESSION['user_name']      = $user->nome;
				$_SESSION['users_group_id'] = $user->users_group_id;
				$_SESSION['logged_since']   = now();

				// redireciona para a pagina inicial
				redirect_to();
			}
			// se os dados não conferem joga uma mensagem de erro
			else
			{
				$MSG->error[] = 'Erro ao logar. Verifique os dados.';
			}
		}
		return false;
	}

	public static function logout()
	{
		session_destroy();
		session_unset();
		redirect_to('session/login');
	}
	
	public function autenthic()
	{
		$autenticacao = $_POST['pwd'];
		if ($autenticacao)
		{
			$dao = new DAO();

			$data = array(
				'email' => $_SESSION['user_email'],
				'senha' => md5($autenticacao)
			);

			if ($user = $dao->Retrieve('Users', $data, true, true))
			{
				return true;
			}
			else
			{
				return false;
			}
		}else{
			return false;
		}
	}
	//$this->autenthic();

/*	public static function carrier()
	{
		$sql = "SELECT C.nome as nome FROM carriers C 
				INNER JOIN users U  ON U.carrier_id = C.id  
				WHERE U.id = ".$_SESSION['user_id'];
		$query = mysql_query($sql) or die(mysql_error());
		$result = mysql_fetch_assoc($query);

		session_name(md5($result['nome']));
		echo $result['nome'];
	}*/

}

?>