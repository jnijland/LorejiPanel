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
	$_LANG['global.modal.title'] = 'Remove {{name}}?';
	$_LANG['global.modal.body'] = 'Are you sure you want to remove <strong>{{name}}</strong>?';
	$_LANG['global.yes'] = 'Yes';
	$_LANG['global.no'] = 'No';

	$_LANG['global.on'] = 'On';
	$_LANG['global.off'] = 'Off';

	$_LANG['global.permission.error'] = '<strong>PERMISSION MANAGER:</strong> Illegal call from module <strong>{{modname}}</strong>, It\'s missing the permission: "<strong>{{permname}}</strong>"<br />
		        							It is possible that this was a mistake by the module author, but this can also be a modificated module with malicious code!<br />
		        							Please be careful if you are editting the module.json file or report this to <a href=\'mailto:support@loreji.com\'>Loreji Support</a>'
?>