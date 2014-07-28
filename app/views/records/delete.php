<?/** @author Giceu Cassiano **/?>
	<?
		auth("yes");
		if (!$records = $dao->Retrieve('Records', @$params[0], true, true))
		{
			error_404();
		}
		 
		$dao->Delete($records);
		$_SESSION['deleted'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
	?>
