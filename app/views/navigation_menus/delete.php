<?/** @author Giceu Cassiano **/?>
	<?
		auth("yes");
		if (!$navigation_menus = $dao->Retrieve('Navigation_menus', @$params[0], true, true))
		{
			error_404();
		}
		 
		$dao->Delete($navigation_menus);
		$_SESSION['deleted'] = true;
		header('location:'.$_SERVER['HTTP_REFERER']);
	?>
