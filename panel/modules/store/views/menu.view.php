<!--MySQL Module --> 
<?php 

/**
 I know, its a bit difficult to understand... 
 your controller panel.domain.com/controller/action
*/

$controller = "store"; 
?>
<li class="nav-parent <?php echo (Route::$params->controller === $controller && Cookie::get('nav_collapse') !== 'true') ? 'active nav-active' : '' ;?>"><a href="#"><i class="fa fa-shopping-cart"></i> <span>Store</span></a>
  <ul class="children" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'display:block;' : '' ;?>">

    <?php $action = 'index'; ?>
    <li><a href="<?php echo Url::site('/'.$controller.'/'.$action); ?>" style="<?php echo (Route::$params->action === $action && $controller === Route::$params->controller) ? 'color:#1caf9a;' : '' ;?>">
    <i class="fa fa-caret-right"></i> Overview</a>
    </li>

  </ul>
</li>