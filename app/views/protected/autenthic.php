<?

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
?>