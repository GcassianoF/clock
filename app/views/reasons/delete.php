<?/** @author Giceu Cassiano **/?>
	<?
		auth("yes");
		if (!$reasons = $dao->Retrieve('Reasons', @$params[0], true, true))
		{
			error_404();
		}
		 
		$dao->Delete($reasons);
		$_SESSION['deleted'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
	?>
