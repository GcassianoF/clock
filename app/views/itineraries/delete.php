<?/** @author Giceu Cassiano **/?>
	<?
		auth("yes");
		if (!$itineraries = $dao->Retrieve('Itineraries', @$params[0], true, true))
		{
			error_404();
		}
		 
		$dao->Delete($itineraries);
		$_SESSION['deleted'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
	?>
