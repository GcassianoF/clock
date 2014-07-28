<?php

class Settings_Controller extends App_Controller
{

	public function add_page()
	{
		global $DATA;
		global $MSG;

		if ($DATA['Page'])
		{
			validates_presence_of('Page', 'nome', 'Nome');
			validates_presence_of('Page', 'url', 'URL');
			validates_presence_of('Page', 'icone', 'ICONE');
			if (check_errors())
			{
				return false;
			}

			$dao = new DAO();

			$page = new Navigation_page($DATA['Page']);
			if ($dao->Create($page))
			{
				$MSG->success[] = 'Cadastro efetuado';
				$_POST = array();
			}
		}
	}

	public function add_menu()
	{
		global $DATA;
		global $MSG;

		if ($DATA['Menu']) 
		{
			validates_presence_of('Menu', 'nome', 'NOME');
			validates_presence_of('Menu', 'icone', 'ICONE');
			validates_presence_of('Menu', 'posicao', 'POSIÇÃO');

			validates_uniqueness_of('posicao', $DATA['Menu'], 'Navigation_menus', 'POSIÇÃO');

			if (check_errors())
			{
				return false;
			}

			$dao = new DAO();
			$menu = new Navigation_menu($DATA['Menu']);
			if ($dao->Create($menu))
			{
				$MSG->success[] = 'Cadastro efetuado';
				$_POST = array();
			}/*else
			{
				$MSG->error[] = "Erro ao efetuar o Cadastro. Entre em contato com o Administrador do Sistema!";
			}*/
		}
	}

	public function update_page($pagina)
	{
		global $DATA;
		global $MSG;
		if ($DATA['Pagina'])
		{
			// escolhe os campos a serem validados
			validates_presence_of('pagina', 'nome', 'NOME');
			validates_presence_of('pagina', 'url', 'URL');
			validates_presence_of('pagina', 'icone', 'ICONE');
			//validates_presence_of('pagina', 'mostrar', 'MOSTRAR');
			// valida os campos e em caso de erro joga mensagens padrão e retorna false
			if (check_errors())
			{
				return false;
			}

			// caso tudo ocorra bem o objeto DAO é instanciado
			$dao = new DAO();

			$pagina = batch_update($pagina, $DATA['Pagina']);
			if ($dao->Update($pagina))
			{
				$MSG->success[] = 'Alteração Efetuada Com Sucesso.';
			}
		}
	}

	public function update_menu($menu)
	{
		global $DATA;
		global $MSG;
		if ($DATA['Menu'])
		{
			// escolhe os campos a serem validados
			validates_presence_of('menu', 'nome', 'NOME');
			validates_presence_of('menu', 'icone', 'ICONE');
			validates_presence_of('menu', 'posicao', 'POSIÇÃO');

			//validates_uniqueness_of('posicao', $DATA['Menu'], 'Navigation_menus', 'POSIÇÃO');

			if (check_errors())
			{
				return false;
			}

			// caso tudo ocorra bem o objeto DAO é instanciado
			$dao = new DAO();

			$menu = batch_update($menu, $DATA['Menu']);
			if ($dao->Update($menu))
			{
				$MSG->success[] = mysql_error();
			}else{
				$error= "";
				$error_number = mysql_errno();
				if ($error_number === 1062) {
					$error="Já existe menu cadastrado nesta posição";
					$MSG->error[] = $error;
				}else{
					$MSG->error[] = "Atenção contacte o administrador  do sistema <strong>DBA: ".mysql_errno()."</strong>";
				}
			}
		}
	}

	public function permissions()
	{
		global $MSG;
		if ($_POST)
		{
			$dao = new DAO();
			// remove todas as permissões do grupo
			if ($current_permissions = $dao->Retrieve('Permissions', array('users_group_id'=>$_GET['users_group_id'])))
			{
				$dao->Remove($current_permissions);
			}
			// adiciona as novas permissões
			if (!array_key_exists('page_id', $_POST)) return false;
			foreach ($_POST['page_id'] as $p)
			{
				$data = array(
					'users_group_id' => $_GET['users_group_id'],
					'navigation_page_id' => $p
				);
				$permission = new Permission($data);
				$id = $dao->Create($permission);
			}
			$MSG->success[] = 'Cadastro efetuado';
			return $id;
		}
	}

	public function TBpermissions($users_group_id)
	{
		if ($_GET)
		{
			$dao = new DAO();
			$sql = "SELECT NM.nome AS menu_name, NM.icone AS icon_m, NP.nome AS page_name, NP.icone AS icon_p ,NP.id AS page_id, NP.url AS url FROM navigation_menus NM
			INNER JOIN navigation_pages NP ON (NP.navigation_menu_id = NM.id)
			WHERE NM.deleted_at IS NULL AND NP.deleted_at IS NULL
			ORDER BY NM.id, NP.id";
			$q = mysql_query($sql);
			$menu = '';
			echo '
				<form action="" method="post">
					<div class="padded">
			';
            		while ($row = mysql_fetch_assoc($q)):
             			if ($menu != $row['menu_name']):
              			if ($menu)
			echo '</tbody></table></fieldset>';
			$menu = $row['menu_name'];
			echo '
			<fieldset>
			<table class="table table-bordered table-condensed" style="">';
			echo '				<thead>
			<tr>
			<th colspan="3" class="left" style="text-align:center; width:100%">
			<span class="pull-left">
			<input type="checkbox" class="checkall" id="icheck1">
			<span class="label label-blue">Marca Todos</span>
			</span>
			<i class="'.$row['icon_m'].'"></i>&nbsp;&nbsp;&nbsp;'.$menu.'
			</th>
			</tr>
			</thead>
			<hr class="divider"></hr>
			<tbody>';
			endif;
			$check = $dao->Retrieve('Permission', array('users_group_id'=>$users_group_id, 'navigation_page_id'=>$row['page_id']), true, true) ? ' checked="checked"' : '';
			echo '						<tr>
			<td>
			<input name="page_id[]" value="'.$row['page_id'].'" type="checkbox"'.$check.'  class="iButton-icons"/>
			</td>
			<td>
			<i class="'.$row['icon_p'].'"></i>&nbsp;&nbsp;&nbsp;'.$row['page_name'].'
			</td>
			<td>
			<span class="label">'.$row['url'].'</span>
			</td>
			</tr>';
			endwhile;
			echo '						</tbody>
			</table>
			</fieldset>
			</div>
			<div class="form-actions">
			<button type="submit" class="btn btn-blue"><i class="icon-check"></i>   Confirmar</button>
			</div>
			</form>';
		}
	}

	public function pagetabmenu()
	{
	        $dao = new DAO();
	        $pages = $dao->Retrieve('Navigation_pages', 'ORDER BY navigation_menu_id ASC');
	        foreach($pages as $page)
	        {
			if ($menu != $page->rel['navigation_menu']->nome || $icone != $page->rel['navigation_menu']->icone)
			{
			$menu = $page->rel['navigation_menu']->nome;
			$icone = $page->rel['navigation_menu']->icone;
			echo '
				<li class="">
					<a href="#'.$menu.'" data-toggle="tab">
						<i class="'.$icone.'"></i> <span>'.$menu.'</span>
					</a>
				</li>
			';
			}
	         }
	       	// var_dump($pages);
	}

	public function menusList()
	{
		$dao = new DAO();
		if ($menus = $dao->Retrieve('Navigation_menus', ' WHERE navigation_menus.deleted_at IS NULL ORDER BY posicao DESC'))
		{	
			echo '<div id="dataTables">
				<table cellpadding="0" cellspacing="0" border="0"  class="dTable responsive">';
			echo '<div id="breadcrumbs">
							<div class="breadcrumb-button blue" style="" >
								<span class="breadcrumb-label" style="color:#000;width:170px">
										<i class="icon-sitemap"></i><strong> Menus Do Sistema</strong>
								</span>
							</div>
						</div>
					<thead>
						<tr>
							<td style="text-align:center; width:300px">NOME</td>
							<td style="text-align:center; width:300px">ICONE</td>
							<td style="text-align:center; width:40px">POSIÇÃO</td>
							<td style="text-align:center; width:80px">Opções</td>
						</tr>
					</thead>
					<tbody>
						'
			;
			foreach($menus as $menu)
			{
				echo '
					<tr>
						<td>'.$menu->nome.'</td>
						<td><i class="'.$menu->icone.'"> ' .$menu->icone.'</i></td>
						<td style="text-align:center"><span class="label label-red">'.$menu->posicao.'</span></td>
						<td style="text-align:center">
							<a class="btn btn-mini btn-gray" href="'.WWWROOT.'/settings/updateMenus/'.$menu->id.'"><i class="icon-edit"></i></a>
							<a class="btn btn-mini btn-red" href="'.WWWROOT.'/settings/deleteMenus/'.$menu->id.'"><i class="icon-trash"></i></a>
						</td>
					</tr>'
				;
			}
			echo '
						
					</tbody>
				</table></div>';
		}else{
			echo '<div class="alert alert-info">Sem resultados</div>';
		}
	}

	public function pagesList()
 	{
		$dao = new DAO();
		if ($pages = $dao->Retrieve('Navigation_pages', ' WHERE navigation_pages.deleted_at IS NULL ORDER BY navigation_menu_id ASC'))
		{
			$menu = '';
			echo '
			<div class="tab-pane" id="paginasForMenus">
				<div class="row-fluid">
					<div class="span10 offset1">
						<div class="box">
							<div class="box-header">
								<span class="title"><i class="icon-edit"></i> Lista de Paginas Cadastradas no Sistema</span>
							</div>
						<div class="box-content">
							<div class="padded">';
							echo '<table cellpadding="0" cellspacing="0" border="0"  class="dTable responsive">';
			foreach($pages as $page)
			{
				if ($menu != $page->rel['navigation_menu']->nome)
				{
					$menu = $page->rel['navigation_menu']->nome;
					$ico = $page->rel['navigation_menu']->icone;
					echo '<thead><td colspan="1" >
					<p>&nbsp;</p><div id="breadcrumbs">
						<div class="breadcrumb-button blue" style="" >
							<span class="breadcrumb-label" style="color:#000;width:400px">
								<i class="'.$ico.'"></i><strong> '.$menu.'</strong>
							</span>
						</div>
					</div>
					</td>
					<tr>
					<td style="text-align:center; width:300px">Nome</td>
					<td style="text-align:center; width:300px">URL</td>
					<td style="text-align:center; width:40px">Exibir</td>
					<td style="text-align:center; width:80px">Opções</td>
					</tr>
					</thead>';
				}
				echo '
				<tbody>
				<tr>
				<td>'.$page->nome.'</td>
				<td><span class="label">'.$page->url.'</span></td>
				<td style="text-align:center">'.$page->status().'</td>
				<td style="text-align:center;border-bottom-width:1">
				<a class="btn btn-mini btn-gray" href="'.WWWROOT.'/settings/updatePages/'.$page->id.'"><i class="icon-edit"></i></a>
				<a class="btn btn-mini btn-red" href="'.WWWROOT.'/settings/deletePages/'.$page->id.'"><i class="icon-trash"></i></a>
				</td>
				</tr>
				</tbody>';
			}
			echo '</table><br /><br />';
			echo '  </div>
			</div>
			</div>
			</div>
			</div>
			</div>';
		}else{
			echo '<div class="alert alert-info">Sem resultados</div>';
		}
         }
}

?>