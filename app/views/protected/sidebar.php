<?php
    // filtra a URL correta
    $request_uri = $_SERVER['REQUEST_URI'];
    $query_string = '?'.$_SERVER['QUERY_STRING'];
    $active = str_replace($query_string, '', $request_uri);
    $active = str_replace(DIR, '', $active);
?>
<div class="sidebar-background">
    <div class="primary-sidebar-background"></div>
</div>
<div class="primary-sidebar">
    <!-- INICIO MENU VERTICAL -->
        <ul class="nav nav-collapse collapse nav-collapse-primary">
            <li class="active">
                <span class="glow"></span>
                <a href="<?=WWWROOT?>"><i class="icon-home icon-2x"></i><span>Home</span></a>
            </li>
            <?if ($entrada = $dao->get("Navigation_menus", " INNER JOIN navigation_pages NP ON (NP.navigation_menu_id = navigation_menus.id)
                                INNER JOIN permissions P ON (P.navigation_page_id = NP.id)
                                WHERE NP.mostrar = '1' AND navigation_menus.nome = 'Dashboard'
                                AND P.users_group_id = '{$USER->users_group_id}'")):?>
                        <li class="active">
                                    <span class="glow"></span>
                                    <a href="<?=WWWROOT?>/dashboard"><i class="icon-dashboard icon-2x"></i><span>Dashboard</span></a>
                        </li>
            <?else:?>

            <?endif?>
	 <!--  <li class="active dark-nav">
                <span class="glow"></span>
                <a href="<?=WWWROOT.'/records/'?>"><i class="icon-time icon-2x"></i><span>Registrar Hora</span></a> -->
            </li>
                <?php
                    $sql = "SELECT  NM.id AS menu_id, NM.nome AS menu_name, NM.icone AS icon_m, NP.icone AS icon_p, NP.nome AS page_name, NP.url AS url
                    FROM navigation_menus NM
                    INNER JOIN navigation_pages NP ON (NP.navigation_menu_id = NM.id)
                    INNER JOIN permissions P ON (P.navigation_page_id = NP.id)
                    WHERE NP.mostrar = '1' AND NM.nome != 'Dashboard'
                    AND P.users_group_id = '{$USER->users_group_id}'
                    ORDER BY NM.posicao, NM.id, NP.id";
                    //echo $sql;
                    $q = mysql_query($sql) or die(mysql_error());
                    $menu = false;
                    while ($row = mysql_fetch_assoc($q))
                    {
                        if ($menu != $row['menu_name'])
                        {
                            if ($menu)
                            {
                                echo '
                                    </ul>
                                        </li>
                                ';
                            }
                            echo '
                                <li class="dark-nav ">
                                    <span class="glow"></span>
                                    <a class="accordion-toggle collapsed " data-toggle="collapse" href="#app'.$row['menu_id'].'">
                                        <i class="'.$row['icon_m'].' icon-2x"></i>
                                        <span>'.$row['menu_name'].'<i class="icon-caret-down"></i></span>
                                    </a>
                                    <ul id="app'.$row['menu_id'].'" class="collapse ">
                            ';
                            $menu = $row['menu_name'];
                        }
                        echo '
                            <li class="">
                                <a href="'.WWWROOT.$row['url'].'">
                                    <i class="'.$row['icon_p'].'"></i> '.$row['page_name'].'
                                </a>
                            </li>
                        ';
                    }
                    echo '
                            </ul>
                        </li>
                    ';
                ?>
        </ul>
    <!--FIM MENU VERTICAL-->

    <!--INICIO CHARTS MENU VERTICAL-->
    <div class="hidden-tablet hidden-phone">
        <div class="text-center" style="margin-top: 60px">
            <div class="easy-pie-chart-percent" style="display: inline-block" data-percent="100"><span>100%</span></div>
            <div style="padding-top: 20px"><b>CPU Usage</b></div>
        </div>

        <hr class="divider" style="margin-top: 60px">
        <!-- <div class="sparkline-box side">
            <div class="sparkline-row">
                <h4 class="gray"><span>Orders</span> 847</h4>
                <div class="sparkline big" data-color="gray">28,11,24,24,8,20,26,22,16,6,12,15</div>
            </div>
            <hr class="divider">
            <div class="sparkline-row">
                <h4 class="dark-green"><span>Income</span> $43.330</h4>
                <div class="sparkline big" data-color="darkGreen">16,20,6,19,25,22,9,13,7,10,15,4</div>
            </div>
            <hr class="divider">
            <div class="sparkline-row">
                <h4 class="blue"><span>Reviews</span> 223</h4>
                <div class="sparkline big" data-color="blue">20,18,21,17,5,7,29,9,8,14,23,8</div>
            </div>
            <hr class="divider">
        </div> -->

    </div>
</div>
<!-- FIM CHARTS MENU VERTICAL -->

<!-- INICIO MODAL CONFIRMAÇÃO DE DELEÇÃO -->
<div id="confirmation_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Confirmação</h3>
    </div>
    <div class="modal-body">
        <p>Tem certeza que deseja executar esta ação?</p>
        <p>Não será possível desfazer esta ação.</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-gold" data-dismiss="modal" aria-hidden="true"><i class="icon-remove-sign"></i> Cancelar</a>
        <a href="#" class="btn btn-blue" id="confirm_danger"><i class="icon-check-sign"></i> Continuar</a>
    </div>
</div>
<!-- FIM MODAL CONFIRMAÇÃO DE DELEÇÃO -->
<!-- INICIO MODAL FIM DE SESSÃO -->
        <div id="confirmation_modal_expired_session" data-backdrop="static" class="modal hide fade" tabindex="-1" role="modal" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-header">
        <h3 id="myModalLabel">Sessão Expirada</h3>
        </div>
        <div class="modal-body">
        <h2><?=$_SESSION['user_name'];?></h2>
        <h5>Atenção sua sessão expirou efetue o login novamente</h5>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-gray "onclick="time_out_new_login()" ><i class="icon-signin"></i> Ok</button>
        </div>
        </div>
<!-- FIM MODAL FIM DE SESSÃO -->

