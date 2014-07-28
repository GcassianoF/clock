<?php

	auth('yes');

	if (!$menus = $dao->Retrieve('Navigation_menus', $params[0], true, true))
	{
		error_404();
	}

	$dao->Remove($menus);
	$_SESSION['deleted'] = true;
	header('location:'.$_SERVER['HTTP_REFERER']); 
?>