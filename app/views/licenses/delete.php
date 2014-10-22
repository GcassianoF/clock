<?/** @author Giceu Cassiano **/?>
	<?
		auth("yes");
		if (!$licenses = $dao->Retrieve('Licenses', @$params[0], true, true))
		{
			error_404();
		}
		 
		$dao->Delete($licenses);
		$_SESSION['deleted'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
	?>
