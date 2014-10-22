<?php
/*
* config file: contains default definitions
*/
header('Content-type: text/html; charset=utf-8');
session_name('e70003eea15fb1ddfdef0d330fff32ff');
session_start();
ob_start();
set_time_limit(2000);
date_default_timezone_set('America/Recife');
ini_set('display_errors', 0);// 0 for production
//ini_set('track_errors', 0);// 0 for production

$request_uri = explode('/', $_SERVER['REQUEST_URI']);

$DOCUMENT_ROOT = dirname(__FILE__);
$DOCUMENT_ROOT = substr($DOCUMENT_ROOT, 0, strpos($DOCUMENT_ROOT, "/config"));

// default configs
define('DS', DIRECTORY_SEPARATOR);
define('RAIZ', "clock");
define('DIR', DS.RAIZ);
define('DOCROOT', $DOCUMENT_ROOT);
define('WWWROOT', "http://".$_SERVER['SERVER_NAME'].DIR);
define('WEBROOT', WWWROOT."/webroot");
define('APP', "app");
define('APPROOT', DOCROOT.DS.APP);
define('ACTION', '');// deprecated
define('UPLOADFILES', DOCROOT."/core/uploadfiles/");

// define the configuration receive email (IMAP / POP)
// IMAP
define('IMAPPROTOCOLO', "imap");
define('IMAPSERVIDOR', "gmail.com");
define('IMAPPORTA', "993");
define('IMAPCONTA', "gmail.com");
// POP
define('POPPROTOCOLO', "pop");
define('POPSERVIDOR', "gmail.com");
define('POPPORTA', "995");
define('POPCONTA', "gmail.com");


// database config
define('HOST', 'localhost');
define('DATABASE', 'clock');
define('USERNAME', 'root');
define('PASSWORD', '@indra123');

// include stuff
$helpers_dir     	= DOCROOT."/core/helpers/";
$inc_dir         	= DOCROOT."/core/libs/controllers/";
$core_dir        	= DOCROOT."/core/libs/models/";
$class_dir       	= DOCROOT."/app/models/";
$controllers_dir 	= DOCROOT."/app/controllers/";
$system_controllers = DOCROOT."/core/system/";

// inc core models
if ($files = scandir($core_dir))
{
	foreach ($files as $f)
	{
		if (strstr($f, ".class.php"))
		{
			include_once $core_dir.$f;
		}
	}
}
else
{
	die("<div class='well btn-danger'><h1>Houve um problema ao incluir as classes do sistema. Procure o administrador do sistema.</h1></div>");
}

// inc helpers
if ($files = scandir($helpers_dir))
{
  	include_once $helpers_dir."PHPMailer.class.php";
	include_once $helpers_dir."SimpleImage.class.php";
	include_once $helpers_dir."SMTP.class.php";
}

// inc core controllers
if ($files = scandir($inc_dir))
{
  	include_once $inc_dir."app_controller.php";
	include_once $inc_dir."util_layout.php";
	include_once $inc_dir."util_general.php";
	include_once $inc_dir."util_time_date.php";
}
else
{
	die("<div class='well btn-danger'><h1>Houve um problema ao incluir os arquivos do sistema. Procure o administrador do sistema.</h1></div>");
}

// inc app models
if ($files = scandir($class_dir))
{
	foreach ($files as $f)
	{
		if (substr($f, -10) == ".class.php")
		{
			include_once $class_dir.$f;
		}
	}
}
else
{
	die("<div class='well btn-danger'><h1>Houve um problema ao incluir as classes do usu&aacute;rio. Procure o administrador do sistema.</h1></div>");
}

// inc app controllers
if ($files = scandir($controllers_dir))
{
	foreach ($files as $f)
	{
		if (substr($f, -4) == ".php")
		{
			include_once $controllers_dir.$f;
		}
	}
}
else
{
	die("<div class='well btn-danger'><h1>Houve um problema ao incluir as fun&ccedil;&otilde;es do usu&aacute;rio. Procure o administrador do sistema.</h1></div>");
}

// inc system controllers
if ($files = scandir($system_controllers))
{
	foreach ($files as $f)
	{
		if (substr($f, -4) == ".php")
		{
			include_once $system_controllers.$f;
		}
	}
}
else
{
	die("<div class='well btn-danger'><h1>Houve um problema ao incluir os arquivos do sistema. Procure o administrador do sistema.</h1></div>");
}


include ('globals.php');

?>
