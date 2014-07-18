<div class="leftpanelinner">    
        
        <!-- This is only visible to small devices -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">   
           <!-- <div class="media userlogged">
                <div class="media-body">
                    <h4>Ramon Test</h4>
                    <span>"Life is so..."</span>
                </div>
            </div> -->
          
            <h5 class="sidebartitle actitle"><?php echo Auth::$instance->au_fullname_vc; ?></h5>
            <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                 <li><a href="#"><i class="glyphicon glyphicon-user"></i> <?php echo Language::get('topmenu.nav.myaccount'); ?></a></li>
                <li><a href="#"><i class="glyphicon glyphicon-cog"></i> <?php echo Language::get('topmenu.nav.mysettings'); ?></a></li>
                <li><a href="<?php echo Url::site('/guide/index'); ?>"><i class="glyphicon glyphicon-question-sign"></i> <?php echo Language::get('topmenu.nav.help'); ?></a></li>
                <li><a href="<?php echo Url::site('/lock'); ?>"><i class="glyphicon glyphicon-lock"></i> <?php echo Language::get('topmenu.nav.lock'); ?></a></li>
                <li><a href="<?php echo Url::site('/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i> <?php echo Language::get('topmenu.nav.logout'); ?></a></li>
            </ul>
        </div>
      
      <h5 class="sidebartitle"><?php echo Language::get('leftmenu.nav.navigation'); ?></h5>
      <ul class="nav nav-pills nav-stacked nav-bracket">

        <!-- Dashboard Module -->
        <li class="<?php echo (Route::$params->controller === 'home') ? 'active' : '' ;?>"><a href="<?php echo Url::site('/home/index'); ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

        <!--Domains Module --> 
        <?php $controller = "domain"; ?>
        <li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#"><i class="fa fa-globe"></i> <span><?php echo Language::get('domain.menu.title'); ?></span></a>
        <ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">


            <?php $action = 'index'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> <?php echo Language::get('domain.menu.overview'); ?></a>
            </li>

            <?php $action = 'domains'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> <?php echo Language::get('domain.menu.adddomain'); ?></a>
            </li>

          </ul>
        </li>

        <!--MySQL Module -- 
        <?php $controller = "mysql"; ?>
        <li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#"><i class="fa icon-mysql size-36"></i> <span>MySQL</span></a>
            <ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">
            <?php $action = 'index'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Databases</a>
            </li>

            <?php $action = 'users'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Users</a>
            </li>

          </ul>
        </li>

        <!--Email Module -- 
        <?php $controller = "mail"; ?>
        <li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#"><i class="fa fa-envelope-o"></i> <span>Email</span></a>
          <ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">

            <?php $action = 'index'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>"><i class="fa fa-caret-right"></i> Mailboxes</a></li>

            <?php $action = 'aliasses'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>"><i class="fa fa-caret-right"></i> Aliasses</a></li>

            <?php $action = 'distlist'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller ) ? 'color:#1caf9a;' : '' ;?>"><i class="fa fa-caret-right"></i> Distribution Lists</a></li>

          </ul>
        </li>

        <!--NodeJS Module -
        <?php $controller = "nodejs"; ?>
        <li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#"><i class="fa icon-nodejs size-36"></i> <span>Node.JS</span></a>
            <ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">
            <?php $action = 'index'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Overview</a>
            </li>

          </ul>
        </li> -->


        <?php
        foreach ($GLOBALS['modules'] as $value) {
            foreach (glob(MODPATH."/".$value->name."/views/menu.view.php") as $filename) {
              //  require_once($filename);
            }
        }
        ?>
        <!--
        <?php
            // All admin thingys
            if(Auth::has_role('admin') === TRUE){
        ?>  
        
        <!--Apache_Management Module --
        <?php $controller = "management" ?>
        <li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#">
        <i class="fa fa-sitemap"></i> <span>Management</span></a>
          <ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">
            
            <?php $action = 'index'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Overview</a></li>

            <?php $action = 'users'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> User Management</a></li>

            <?php $action = 'packages'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Package Management</a></li>

            <?php $action = 'services'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Service Management</a></li>

            <?php $action = 'apache'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Apache Management</a></li>

            <?php $action = 'php'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> PHP Management</a></li>


            <!-- as last --
            <?php $action = 'loreji'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Loreji Management</a></li>

            <!-- kind of hidden feature --
                <?php $action = 'repman'; ?>
                <li id="hiddenmenu" style="display:none;"><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
                <i class="fa fa-caret-right"></i> REPO Management</a></li>

          </ul>
        </li>

        <?php 
            }
        ?> -->
        <!--
        <li class="nav-parent"><a href="#"><i class="fa fa-suitcase"></i> <span>UI Elements</span></a>
          <ul class="children">
            <li><a href="buttons.html"><i class="fa fa-caret-right"></i> Buttons</a></li>
            <li><a href="icons.html"><i class="fa fa-caret-right"></i> Icons</a></li>
            <li><a href="typography.html"><i class="fa fa-caret-right"></i> Typography</a></li>
            <li><a href="alerts.html"><i class="fa fa-caret-right"></i> Alerts &amp; Notifications</a></li>
            <li><a href="tabs-accordions.html"><i class="fa fa-caret-right"></i> Tabs &amp; Accordions</a></li>
            <li><a href="sliders.html"><i class="fa fa-caret-right"></i> Sliders</a></li>
            <li><a href="graphs.html"><i class="fa fa-caret-right"></i> Graphs &amp; Charts</a></li>
            <li><a href="widgets.html"><i class="fa fa-caret-right"></i> Panels &amp; Widgets</a></li>
            <li><a href="extras.html"><i class="fa fa-caret-right"></i> Extras</a></li>
          </ul>
        </li>
        <li><a href="tables.html"><i class="fa fa-th-list"></i> <span>Tables</span></a></li>
        <li><a href="maps.html"><i class="fa fa-map-marker"></i> <span>Maps</span></a></li>
        <li class="nav-parent"><a href="#"><i class="fa fa-file-text"></i> <span>Pages</span></a>
          <ul class="children">
            <li><a href="calendar.html"><i class="fa fa-caret-right"></i> Calendar</a></li>
            <li><a href="media-manager.html"><i class="fa fa-caret-right"></i> Media Manager</a></li>
            <li><a href="timeline.html"><i class="fa fa-caret-right"></i> Timeline</a></li>
            <li><a href="blog-list.html"><i class="fa fa-caret-right"></i> Blog List</a></li>
            <li><a href="blog-single.html"><i class="fa fa-caret-right"></i> Blog Single</a></li>
            <li><a href="people-directory.html"><i class="fa fa-caret-right"></i> People Directory</a></li>
            <li><a href="profile.html"><i class="fa fa-caret-right"></i> Profile</a></li>
            <li><a href="invoice.html"><i class="fa fa-caret-right"></i> Invoice</a></li>
            <li><a href="search-results.html"><i class="fa fa-caret-right"></i> Search Results</a></li>
            <li><a href="blank.html"><i class="fa fa-caret-right"></i> Blank Page</a></li>
            <li><a href="notfound.html"><i class="fa fa-caret-right"></i> 404 Page</a></li>
            <li><a href="locked.html"><i class="fa fa-caret-right"></i> Locked Screen</a></li>
            <li><a href="signin.html"><i class="fa fa-caret-right"></i> Sign In</a></li>
            <li><a href="signup.html"><i class="fa fa-caret-right"></i> Sign Up</a></li>
          </ul>
        </li>
        <li><a href="layouts.html"><i class="fa fa-laptop"></i> <span>Skins &amp; Layouts</span></a></li> -->
      </ul>
      
     <!-- <div class="infosummary">
        <h5 class="sidebartitle">Information Summary</h5>    
        <ul>
            <li>
                <div class="datainfo">
                    <span class="text-muted">Daily Traffic</span>
                    <h4>630, 201</h4>
                </div>
                <div id="sidebar-chart" class="chart"></div>   
            </li>
            <li>
                <div class="datainfo">
                    <span class="text-muted">Average Users</span>
                    <h4>1, 332, 801</h4>
                </div>
                <div id="sidebar-chart2" class="chart"></div>   
            </li>
            <li>
                <div class="datainfo">
                    <span class="text-muted">Disk Usage</span>
                    <h4>82.2%</h4>
                </div>
                <div id="sidebar-chart3" class="chart"></div>   
            </li>
            <li>
                <div class="datainfo">
                    <span class="text-muted">CPU Usage</span>
                    <h4>140.05 - 32</h4>
                </div>
                <div id="sidebar-chart4" class="chart"></div>   
            </li>
            <li>
                <div class="datainfo">
                    <span class="text-muted">Memory Usage</span>
                    <h4>32.2%</h4>
                </div>
                <div id="sidebar-chart5" class="chart"></div>   
            </li>
        </ul>
      </div> infosummary -->
    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->