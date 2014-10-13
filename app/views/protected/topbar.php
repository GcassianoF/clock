    <div class="navbar navbar-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="<?=WWWROOT?>">

          </a>
	<span class="pull-left"><a href="<?=WWWROOT?>/"><div class="" align="center" style="width:130px;height:50px;background-color:#f1f1f1;border-radius: 10px 20px;"><div><img src="<?=WEBROOT?>/images/indra.png" alt="Indra Company" style="margin:9px 5px 5px 0px" height="200" width="100"></div> </div></a></span>


<!-- the new toggle buttons -->
          <ul class="nav pull-right">
            <li class="toggle-primary-sidebar hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-primary">
              <button type="button" class="btn btn-navbar"><i class="icon-th-list"></i></button>
            </li>
            <li class="hidden-desktop" data-toggle="collapse" data-target=".nav-collapse-top">
              <button type="button" class="btn btn-navbar"><i class="icon-align-justify"></i></button>
            </li>
          </ul>
          <div class="nav-collapse nav-collapse-top collapse">
            <ul class="nav full pull-right">
              <li class="dropdown user-avatar">
                <!-- the dropdown has a custom user-avatar class, this is the small avatar with the badge -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span>
                    <img class="menu-avatar" src="<?=WEBROOT?>/images/avatars/indra.jpg" />
                    <span><i class="icon-caret-down"></i></span>
                    <!-- <span class="badge badge-dark-red">5</span> -->
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- the first element is the one with the big avatar, add a with-image class to it -->
                  <li class="with-image">
                    <div class="avatar">
                      <img src="<?=WEBROOT?>/images/avatars/indra.jpg" />
                    </div>
                    <span><?=$_SESSION['user_name']?></span>
                  </li>
                  <li class="divider"></li>
                    <li><a href="<?=WWWROOT?>/users/show/<?=$_SESSION['user_id']?>"><i class="icon-user"></i> <span>Profile</span></a></li>
                    <!-- <li><a href="#"><i class="icon-cog"></i> <span>Settings</span></a></li> -->
                    <li>
                      <a href="#">
                        <!-- <i class="icon-envelope"></i> <span>Messages</span> <span class="label label-dark-red pull-right">5</span> -->
                      </a>
                    </li>
                    <li><a href="<?=WWWROOT?>/logout"><i class="icon-off"></i> <span>Logout</span></a></li>
                </ul>
              </li>
            </ul>
            <form class="navbar-search pull-right">
              <!-- <input type="text" class="search-query animated" placeholder="Search">
              <i class="icon-search"></i> -->
            </form>
              <!-- <ul class="nav pull-right">
                <li class="active"><a href="#" title="Go home"><i class="icon-home"></i> Home</a></li>
                <li><a href="#" title="Manage users"><i class="icon-user"></i> Users</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Some link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul> -->
            </div>
              <span class="pull-right"><strong style="color:#FFFFFF">Sua sessão expira em: <b><span id="minutes_left"></span>m<span id="seconds_left"></span>s</b></strong></span><br/>
              <span class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;Horas Restantes de Trabalho:&nbsp;&nbsp;&nbsp;</span>
              <span class="pull-left"><div id="retroclockbox1"></div></span>
              <span class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;Horario do Servidor:&nbsp;&nbsp;&nbsp;</span>
              <span class="pull-left"><div id="retroclockbox2"></div></span>
          </div>
        </div>
      </div>