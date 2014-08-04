<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php
            head('Login');
            auth('no');
            $controller = new Session_Controller();
            $controller->login();
        ?>
    </head>
    <body>
        <div class="navbar navbar-top navbar-inverse">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <span class="pull-left"><div class="" align="center" style="width:130px;height:50px;background-color:#f1f1f1;border-radius: 10px 20px;"><div><img src="<?=WEBROOT?>/images/indra.png" alt="Indra Company" style="margin:9px 5px 5px 0px" height="200" width="100"></div> </div></span>
                    <ul class="nav pull-right">
                        <li class="toggle-primary-sidebar hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-primary"><button type="button" class="btn btn-navbar"><i class="icon-th-list"></i></button></li>
                        <li class="hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-top"><button type="button" class="btn btn-navbar"><i class="icon-align-justify"></i></button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="span4 offset4">
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <BR>
                <div class="padded loginContainer">
                        <?php default_messages()?>
                    <div class="login box" style="margin-top: 80px;">
                        <div class="box-header">
                            <span class="title">Login</span>
                        </div>
                        <div class="box-content padded">
                            <?php $form = new Form_html()?>
                            <?php $form->Start()?>
                            <div class="separate-sections">
                                <div class="input-prepend">
                                    <span class="add-on" href="#"><i class="icon-user"></i></span>
                                    <?php $form->Input(array('type'=>'text', 'placeholder'=>'E-mail ou Matricula'), 'Session', 'email')?>
                                </div>
                                <div class="input-prepend">
                                    <span class="add-on" href="#"><i class="icon-key"></i></span>
                                    <?php $form->Input(array('type'=>'password', 'placeholder'=>'Senha'), 'Session', 'senha')?>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-blue btn-block" >Login <i class="icon-signin"></i></button>
                                </div>
                            </div>
                            <?php $form->End()?>
                            <div>
                                <!-- <a href="sign_up.html">Don't have an account? <strong>Sign Up</strong></a> -->
                            </div>
                        </div>
                    </div>
                   <!--  <div class="row-fluid">
                       <div class="span6">
                           <a href="#" class="btn btn-facebook btn-block"><i class="icon-facebook-sign"></i> Facebook</a>
                       </div>
                       <div class="span6">
                           <a href="#" class="btn btn-twitter btn-block"><i class="icon-twitter"></i> Twitter</a>
                       </div>
                   </div> -->
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                //------------- Some fancy stuff in error pages -------------//
                $('.loginContainer').hide();
                $('.loginContainer').fadeIn(1000).animate({
                'top': "50%", 'margin-top': +($('.loginContainer').height()/-2-30)
                }, {duration: 750, queue: false}, function() {
                // Animation complete.
                });
            });
        </script>
    </body>
</html>
