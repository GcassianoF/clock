<?/** @author Giceu Cassiano **/?>
	<?
		auth("yes");
		if (!$users = $dao->Retrieve('Users', @$params[0], true, true))
		{
			error_404();
		}
		 
		$dao->Delete($users);
		$_SESSION['deleted'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
	?>
