<?/** @author Giceu Cassiano **/?>
	<?
		auth("yes");
		if (!$users_groups = $dao->Retrieve('Users_groups', @$params[0], true, true))
		{
			error_404();
		}
		 
		$dao->Delete($users_groups);
		$_SESSION['deleted'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
	?>
