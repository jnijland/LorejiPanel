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
-->


        <?php
        // Load the dynamic module entrys
        /**
         * 
         */
        foreach ($GLOBALS['modules_active'] as $module) {
            if(isset($module->permcheck) && $module->permcheck === true){
                foreach (glob(MODPATH."/".strtolower($module->name)."/views/menu.view.php") as $filename) {
                    require_once($filename);
                }
            }
        }
        ?>
        
        <?php
            // All admin thingys
            if(Auth::has_role('admin') === TRUE){
        ?>  
    
        <!--Store Module -->
        <?php $controller = "store"; ?>
        <li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#"><i class="fa fa-shopping-cart"></i> <span>Store</span></a>
            <ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">
            
            <?php $action = 'index'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> <?php echo Language::get('domain.menu.overview'); ?></a>
            </li>

            <?php $action = 'developer'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Developer</a>
            </li>

          </ul>
        </li> 

        <!--Apache_Management Module -->
        <?php $controller = "management" ?>
        <li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#">
        <i class="fa fa-sitemap"></i> <span>Management</span></a>
          <ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">

            <?php $action = 'modulesettings'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Module Settings</a></li>
            <!-- as last -->
            <?php $action = 'loreji'; ?>
            <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
            <i class="fa fa-caret-right"></i> Loreji Management</a></li>


          </ul>
        </li>

        <?php 
            }
        ?> 
        <?php if(Auth::has_role('ccunit')) { ?>

            <li><a href="<?php echo Url::site('/apps/ccunit/index.php?page=dashboard'); ?>">
            <i class="fa fa-life-ring"></i> <span>CC-Unit</span></a></li>
        <?php  } ?>

      </ul>

    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->