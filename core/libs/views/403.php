
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
            head('Acesso Negado');
        ?>

    </head>
    <body>
        <div class="navbar navbar-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="brand" href="#"><font size="400px"> 403</font></a>
                    <ul class="nav pull-right">
                        <li class="toggle-primary-sidebar hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-primary">
                            <button type="button" class="btn btn-navbar"><i class="icon-th-list"></i></button>
                        </li>
                        <li class="hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-top">
                            <button type="button" class="btn btn-navbar"><i class="icon-align-justify"></i></button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row-fluid">
                <div class="span8 offset2">
                    <div class="error-box errorContainer" style="margin-top:10px">
                        <div class="message-big">O<span style="font-size:120px">p</span>s<span style="font-size:200px;font-family: inherit">!</span>
                        </div>
                        <div class="message-small">erro <font size="400px"> #403</font></div>
                        <div class="message-small"><i class="icon-lock icon-3x"></i></div>
                        <div class="message-small">Seu acesso e RESTRITO a está pagina.</div>
                        <div style="margin-top: 50px">
                            <a class="btn btn-blue" href="<?=WWWROOT?>">
                                <i class="icon-arrow-left"></i> Voltar para o Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php die()?>
