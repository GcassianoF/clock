<?php

	class Menus_Controller extends App_Controller{

		public function add_menu()
		{
			global $DATA;
			global $MSG;

			if ($DATA)
			{
				validates_presence_of('Menu', 'nome', 'Nome');
				validates_presence_of('Menu', 'icone', 'ICONE');
				validates_presence_of('Menu', 'posicao', 'Posição');
				if (check_errors())
				{
					return false;
				}

				$dao = new DAO();

				$newmenu = new Navigation_menu($DATA['Menu']);
				if ($dao->Create($newmenu))
				{
					$MSG->success[] = 'Cadastro efetuado';
					$_POST = array();
				}
			}
		}

		public function breadcrumbs($titulo, $icone, $t_anterior, $i_anterior,$url)
		{
			$t   		  = $titulo;
			$i 	 		  = $icone;
			$t_a 		  = $t_anterior;
			$i_a 		  = $i_anterior;
			$url_anterior = $url;
			echo '
				<div class="container-fluid padded">
					<div class="row-fluid">
						<div id="breadcrumbs">
							<div class="breadcrumb-button blue">
								<span class="breadcrumb-label">
									<a href="'.WWWROOT.'">
										<i class="icon-home"></i> Home
									</a>
								</span>
								<span class="breadcrumb-arrow">
									<span></span>
								</span>
							</div>
			';
			if ($t && $i) {
				if ($t_a && $i_a) {
					echo '
						<div class="breadcrumb-button">
							<span class="breadcrumb-label">
								<a href="'.WWWROOT.$url_anterior.'">
									<i class="'.$i_a.'"></i> '.$t_a.'
								</a>
							</span>
							<span class="breadcrumb-arrow">
								<span></span>
							</span>
						</div>
						<div class="breadcrumb-button blue">
							<span class="breadcrumb-label">
									<i class="'.$i.'"></i> '.$t.'
							</span>
							<span class="breadcrumb-arrow">
								<span></span>
							</span>
						</div>
						<div class="breadcrumb-button">
							<span class="breadcrumb-label">
								&nbsp;
							</span>
							<span class="breadcrumb-arrow">
								<span></span>
							</span>
						</div>
					';
				}else{
					echo '
						<div class="breadcrumb-button">
							<span class="breadcrumb-label">
									<i class="'.$i.'"></i> '.$t.'
							</span>
							<span class="breadcrumb-arrow">
								<span></span>
							</span>
						</div>
						<div class="breadcrumb-button">
							<span class="breadcrumb-label">
								&nbsp;
							</span>
							<span class="breadcrumb-arrow">
								<span></span>
							</span>
						</div>
					';
				}
			}else{
				echo '
					<div class="breadcrumb-button">
						<span class="breadcrumb-label">
							&nbsp;
						</span>
						<span class="breadcrumb-arrow">
							<span></span>
						</span>
					</div>
				';
			}
		echo '
					</div>
				</div>
			</div>
		';
		}
	}
?>