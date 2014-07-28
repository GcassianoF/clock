<?php
/*****************************
** DEFAULT LAYOUT FUNCTIONS **
*****************************/

function default_messages()
{
	global $MSG;
	global $CFG;

	if (count($MSG->success))
	{
		foreach ($MSG->success as $msg)
		{
            $id = uniqid();
            // MSG DE AVISOS C/ BOOTSTRAP
            /*echo "<div class=\"alert alert-success alert-system\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>
                <strong>Sucesso!</strong> $msg
            </div>";*/

            // MSG DE AVISOS C/ O PLUGIN JQUERY TOASTMESSAGE
           /* echo "<script>
            	$().toastmessage('showToast', {
				    text   : '<i style=\"font-family:arial black;color:#c2bcbc;font-size:18px;text-shadow: #55db84 1px 2px 5px;\">SUCESSO! </i>&nbsp; $msg',
				    sticky : true,
				    type   : 'success'
				});
			</script>";*/

            // TOAST Jquery
			echo "<script>$.toast.config.align = 'right';$.toast('<span class=\"label label-green responsive\"><i class=\"icon-ok\"></i> </span> <h4>Sucesso!</h4> $msg', {sticky: true, type: 'success'});</script>";
        }
	}
	if(count($MSG->error))
	{
		foreach ($MSG->error as $msg)
		{
            // MSG DE AVISOS C/ BOOTSTRAP
            /*echo "<div class=\"alert alert-error alert-system\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>
                $msg
            </div>";*/

            // MSG DE AVISOS C/ O PLUGIN JQUERY TOASTMESSAGE
/*            echo "<script>
            	$().toastmessage('showToast', {
				    text     : '<i style=\"font-family:arial black;color:#c2bcbc;font-size:1ç8px;text-shadow: #B32B2B 1px 2px 5px;\">ERRO! </i>&nbsp; $msg',
				    sticky   : true,
				    type     : 'error'
				});
			</script>";*/

            // TOAST Jquery
            echo "<script>$.toast.config.align = 'right';$.toast('<span class=\"label label-red responsive\"><i class=\"icon-remove\"></i> </span> <h4>Erro!</h4> $msg', {sticky: true, type: 'danger'});</script>";			
		}
	}
	if(count($MSG->alert))
	{
		foreach ($MSG->alert as $msg)
		{
            // MSG DE AVISOS C/ BOOTSTRAP
            /*echo "<div class=\"alert alert-warning alert-system\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>
                <strong>Atenção!</strong> $msg
            </div>";*/

            // MSG DE AVISOS C/ O PLUGIN JQUERY TOASTMESSAGE
  /*          echo "<script>
            	$().toastmessage('showToast', {
				    text     : '<i style=\"font-family:arial black;color:#c2bcbc;font-size:18px;text-shadow: #FCBD57 1px 2px 5px;\">ATENÇÃO! </i>&nbsp; $msg',
				    sticky   : true,
				    type     : 'warning'
				});
			</script>";*/

            // TOAST Jquery
            echo "<script>$.toast.config.align = 'right';$.toast('<span class=\"label label-orange responsive\"><i class=\"icon-warning-sign\"></i> </span> <h4>Alerta!</h4> $msg', {sticky: true, type: ''});</script>";
		}
	}
	if(count($MSG->info))
	{
		foreach ($MSG->info as $msg)
		{
            // MSG DE AVISOS C/ BOOTSTRAP
            /*echo "<div class=\"alert alert-info alert-system\">
                <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>
                 $msg
            </div>";*/

            // MSG DE AVISOS C/ O PLUGIN JQUERY TOASTMESSAGE
/*            echo "<script>
            	$().toastmessage('showToast', {
				    text     : '<i style=\"font-family:arial black;color:#c2bcbc;font-size:18px;text-shadow: #8ab6eb 1px 2px 5px;\">ATENÇÃO! </i>&nbsp; $msg',
				    sticky   : false,
				    type     : 'notice'
				});
			</script>";*/

            // TOAST Jquery
            echo "<script>$.toast.config.align = 'right';$.toast('<span class=\"label label-blue responsive\"><i class=\"icon-exclamation-sign\"></i> </span> <h4>Alerta!</h4> $msg', {sticky: true, type: 'info'});</script>";			
		}
	}
}

function title($str=false)
{
	$title = $str ? "<title>$str - Clock</title>" : "<title>Sistema de Gerenciamento de Ponto Eletronico</title>";
	echo $title;
	return false;
}

function head($title=NULL)
{
	global $CFG;
	title($title);
	include DOCROOT."/app/views/protected/head.php";
	return FALSE;
}

function bar($icon, $titulo, $descricao, $inner=NULL)
{
	if ($icon == null)
		$icon = "icon-home";
	if ($titulo == null)
		$titulo = "Page App";
	if ($descricao == null)
		$descricao = "Page create for My";

	global $CFG;
	include DOCROOT."/app/views/protected/bar.php";
	return false;
}

function scripts()
{
	global $CFG;
	include DOCROOT.'/app/views/protected/scripts.php';
	return FALSE;
}

function icons()
{
	global $CFG;
	include DOCROOT.'/app/views/protected/icon.php';
	return FALSE;
}

function topbar()
{
	global $CFG;
	include DOCROOT."/app/views/protected/topbar.php";
	return FALSE;
}

function topbarUID()
{
	global $CFG;
	include DOCROOT."/app/views/protected/topbarUID.php";
	return FALSE;
}

function footer()
{
    global $CFG;
    include DOCROOT."/app/views/protected/footer.php";
    return FALSE;
}

function menu_framework()
{
    global $CFG;
	include DOCROOT."/app/views/protected/menu.php";
    return FALSE;
}

function error_404()
{
	include DOCROOT."/core/libs/views/404.php";
	die();
}

function block_app()
{
	include DOCROOT."/core/libs/views/block.php";
	die();
}

function arvore($dir)
{
	$dirr = $dir;
	$var1 = '';
	$var2 = '';
	foreach (new DirectoryIterator($dirr) as $diretorio) 
	{
		if($diretorio->isDot()) continue;
		echo '<ul style="list-style-type: none;"><li style="list-style-type: none;">↳&nbsp;<a href="#"  id="'.$diretorio->getFilename().'_id"><i id="'.$diretorio->getFilename().'_icon" class="icon-folder-close"></i><strong style="color:#000"> '.$diretorio->getFilename().'</strong></a><div id="'.$diretorio->getFilename().'">';
		$var1 .= '	<script>
					$(document).ready(function(){
						$("#'.$diretorio->getFilename().'").hide();
						$(".exemplo #'.$diretorio->getFilename().'_id").dblclick(function(){
							$(".exemplo #'.$diretorio->getFilename().'_icon").removeClass("icon-folder-close");
							$(".exemplo #'.$diretorio->getFilename().'_icon").addClass("icon-folder-open-alt");
							$("#'.$diretorio->getFilename().'").slideDown();
						}).click(function(){
							$(".exemplo #'.$diretorio->getFilename().'_icon").removeClass("icon-folder-open-alt");
							$(".exemplo #'.$diretorio->getFilename().'_icon").addClass("icon-folder-close");
							$("#'.$diretorio->getFilename().'").slideUp();
						});
					});
				</script>
		';
		$dirr = $dirr.'/'.$diretorio->getFilename();
		foreach (new DirectoryIterator($dirr) as $fileNo1) 
		{
			if($fileNo1->isDot()) continue;
			if($fileNo1->isFile())
			{
				echo '<ol style="list-style-type: none;"><li style="list-style-type: none;">↳&nbsp;<i class="icon-file-alt"></i> '.$fileNo1->getFilename().'</li></ol>';
			}
			else
			{
				$dor = $dirr.'/'.$fileNo1->getFilename();
				echo '<ul style="list-style-type: none;"><li style="list-style-type: none;">↳&nbsp;<a href="#"  id="'.$fileNo1->getFilename().'_id"><i id="'.$fileNo1->getFilename().'_icon" class="icon-folder-close"></i><strong style="color:#000"> '.$fileNo1->getFilename().'</strong></a><div id="'.$fileNo1->getFilename().'">';
				$var2 .= '	<script>
							$(document).ready(function(){
								$("#'.$fileNo1->getFilename().'").hide();
								$(".exemplo #'.$fileNo1->getFilename().'_id").dblclick(function(){
									$(".exemplo #'.$fileNo1->getFilename().'_icon").removeClass("icon-folder-close");
									$(".exemplo #'.$fileNo1->getFilename().'_icon").addClass("icon-folder-open-alt");
									$("#'.$fileNo1->getFilename().'").slideDown();
								}).click(function(){
									$(".exemplo #'.$fileNo1->getFilename().'_icon").removeClass("icon-folder-open-alt");
									$(".exemplo #'.$fileNo1->getFilename().'_icon").addClass("icon-folder-close");
									$("#'.$fileNo1->getFilename().'").slideUp();
								});
							});
						</script>
				';
				foreach (new DirectoryIterator($dor) as $files)
				{	if($files->isDot()) continue;
					echo '<ol style="list-style-type: none;"><li style="list-style-type: none;">↳&nbsp;<i class="icon-file-alt"></i> '.$files->getFilename().'</li></ol>';
				$dor = $dirr.'/'.$files->getFilename();
				}
				echo '</div></li></ul>';
			}
		}
		echo '</div></li></ul>';
		$dirr = $dir;
	}
	print $var1.$var2;
}

?>
