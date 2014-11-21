<?php $controller = "ftp"; ?>
<li class="nav-parent <?php echo (Route::$params->controller === $controller) ? 'active nav-active' : '' ;?>"><a href="#"><i class="fa fa-upload"></i> <span>FTP</span></a>
<ul class="children" style="<?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'display:block;' : '' ;?>">
<?php $action = 'index'; ?>
<li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
<i class="fa fa-caret-right"></i> <?php echo Language::get('ftp.menu.overview'); ?></a>
</li>
<?php $action = 'createuser'; ?>
<li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
<i class="fa fa-caret-right"></i> <?php echo Language::get('ftp.menu.adduser'); ?></a>
</li>

</ul>
</li>