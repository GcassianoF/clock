<?php

auth('yes');

if (!$pages = $dao->Retrieve('Navigation_pages', $params[0], true, true))
{
	error_404();
}
$dao->Delete($pages);
$_SESSION['deleted'] = true;
header('location:'.$_SERVER['HTTP_REFERER']);

?>