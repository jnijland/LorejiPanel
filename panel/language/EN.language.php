<?php defined('SYSPATH') or die('No direct script access allowed.');

	/* *
	*
		Loreji Main -> Language file
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	*/

	// Placeholder
	$_LANG[''] = '';

	// index.php
	$_LANG['class.system.uptime.days'] = 'Days';
	$_LANG['class.system.uptime.hours'] = 'Hours';
	$_LANG['class.system.uptime.minutes'] = 'Minutes';
	$_LANG['class.system.uptime.and'] = 'and';
	
	//Global
	$_LANG['global.entry.youarehere'] = 'You are here';
	$_LANG['global.btn.save'] = 'Save';

	// Top menu
	$_LANG['topmenu.nav.myaccount'] = 'My Account';
	$_LANG['topmenu.nav.mysettings'] = 'Account Settings';
	$_LANG['topmenu.nav.help'] = 'Help';
	$_LANG['topmenu.nav.logout'] = 'Log out';
	$_LANG['topmenu.nav.lock'] = 'Lock Session';

	// Left menu
	$_LANG['leftmenu.nav.navigation'] = 'Navigation';

	// Lockscreen
	$_LANG['lockscreen.unlock'] = 'Unlock';
	$_LANG['lockscreen.enterpass'] = 'Enter your password...';

	// Popup modals
	$_LANG['global.modal.remove.title'] = 'Remove {{name}}?';
	$_LANG['global.modal.remove.body'] = 'Are you sure you want to remove <strong>{{name}}</strong>?';

	$_LANG['global.modal.update.title'] = 'Update {{name}}?';
	$_LANG['global.modal.update.body'] = 'Are you sure you want to update <strong>{{name}}</strong>?';

	$_LANG['global.yes'] = 'Yes';
	$_LANG['global.no'] = 'No';

	$_LANG['global.permission.title.view'] = 'View Permissions';
	$_LANG['global.permission.title.hide'] = 'Hide Permissions';

	$_LANG['PERM_RUN'] = 'Activating the module';
	$_LANG['PERM_DB'] = 'May read/write the database';
	$_LANG['PERM_FILE'] = 'May read/write the filesystem';
	$_LANG['PERM_INTERNET'] = 'May create a internet socket';
	$_LANG['PERM_DAEMON'] = 'May run with daemon';
	$_LANG['PERM_SHELL'] = 'May run shell commands <br />&nbsp;&nbsp;-&nbsp;<i><strong>May be dangerous!</strong></i>';
	$_LANG['PERM_ACCESS_MYSQL_SSL'] = 'May access SSL settings in the database <br />&nbsp;&nbsp;-&nbsp;<i><strong>May be dangerous!</strong></i>';
	$_LANG['PERM_ACCESS_DIR_SSL'] = 'May access SSL files in /etc/loreji/ssl <br />&nbsp;&nbsp;-&nbsp;<i><strong>May be dangerous!</strong></i>';
	$_LANG['PERM_NO_LOCKSCREEN'] = 'May hold system back from going into lockscreen';
	$_LANG['PERM_USE_LSS_KEY'] = 'May reads Loreji Store Service (LSS) key';
	$_LANG['PERM_READ_SETTINGS'] = 'May read Loreji system settings';
	$_LANG['PERM_WRITE_SETTINGS'] = 'May write Loreji system settings';
	$_LANG['PERM_READ_MODULE_SETTINGS'] = 'May read module settings';
	$_LANG['PERM_WRITE_MODULE_SETTINGS'] = 'May write module settings';
	$_LANG['PERM_READ_LOREJI_CONFIG'] = 'May read loreji /configs files <br />&nbsp;&nbsp;-&nbsp;<i><strong>May be dangerous!</strong></i>';
	$_LANG['PERM_WRITE_LOREJI_CONFIG'] = 'May write loreji /configs files <br />&nbsp;&nbsp;-&nbsp;<i><strong>May be dangerous!</strong></i>';
	$_LANG['PERM_USE_CREDENTIALS'] = 'May read the current user\'s information';
	$_LANG['PERM_APPEND_MAIN_MENU'] = 'May add a menu entry to the left main menu';
	
	// Toggles
	$_LANG['global.on'] = 'On';
	$_LANG['global.off'] = 'Off';

	// Illigal module call popup
	$_LANG['global.permission.error'] = '<strong>PERMISSION MANAGER:</strong> Illegal call from module <strong>{{modname}}</strong>, It\'s missing the permission: "<strong>{{permname}}</strong>"<br />
		        							It is possible that this was a mistake by the module author, but this can also be a modificated module with malicious code!<br />
		        							Please be careful if you are editting the module.json file or report this to <a href=\'mailto:support@loreji.com\'>Loreji Support</a>'
?>