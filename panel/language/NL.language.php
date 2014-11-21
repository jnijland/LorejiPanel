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
	$_LANG['class.system.uptime.days'] = 'dagen';
	$_LANG['class.system.uptime.hours'] = 'uur';
	$_LANG['class.system.uptime.minutes'] = 'minuten';
	$_LANG['class.system.uptime.and'] = 'en';
	
	//Global
	$_LANG['global.entry.youarehere'] = 'Je bent nu hier';
	$_LANG['global.btn.save'] = 'Opslaan';

	// Top menu
	$_LANG['topmenu.nav.myaccount'] = 'Mijn Account';
	$_LANG['topmenu.nav.mysettings'] = 'Account Instellingen';
	$_LANG['topmenu.nav.help'] = 'Help';
	$_LANG['topmenu.nav.logout'] = 'Log uit';
	$_LANG['topmenu.nav.lock'] = 'Vergrendel Sessie';

	// Left menu
	$_LANG['leftmenu.nav.navigation'] = 'Navigatie';

	// Lockscreen
	$_LANG['lockscreen.unlock'] = 'Ontgrendel';
	$_LANG['lockscreen.enterpass'] = 'Voer je wachtwoord in...';

	// Popup modals
	$_LANG['global.modal.remove.title'] = '{{name}} verwijderen?';
	$_LANG['global.modal.remove.body'] = 'Weet je zeker dat je <strong>{{name}}</strong> wilt verwijderen?';

	$_LANG['global.modal.update.title'] = '{{name}} updaten?';
	$_LANG['global.modal.update.body'] = 'Weet je zeker dat je <strong>{{name}}</strong> wilt updaten?';

	$_LANG['global.modal.install.title'] = '{{name}} installeren?';
	$_LANG['global.modal.install.body'] = 'Weet je zeker dat je <strong>{{name}}</strong> wilt installeren?';

	$_LANG['global.yes'] = 'Ja';
	$_LANG['global.no'] = 'Nee';

	$_LANG['global.on'] = 'Aan';
	$_LANG['global.off'] = 'Uit';

	$_LANG['global.permission.title.view'] = 'Permissies Weergeven';
	$_LANG['global.permission.title.hide'] = 'Permissies Verbergen';

	$_LANG['PERM_RUN'] = 'Activatie van de module';
	$_LANG['PERM_DB'] = 'Mag gebruik maken van de database';
	$_LANG['PERM_FILE'] = 'Mag bestanden lezen en schrijven';
	$_LANG['PERM_INTERNET'] = 'Mag verbinding maken met een andere server';
	$_LANG['PERM_DAEMON'] = 'Mag een hook toevoegen aan de daemon';
	$_LANG['PERM_SHELL'] = 'Mag shell commando\'s invoeren  <br />&nbsp;&nbsp;-&nbsp;<i><strong>Kan gevaarlijk zijn!</strong></i>';
	$_LANG['PERM_ACCESS_MYSQL_SSL'] = 'Mag de SSL gegevens in de dadtabase benaderen <br />&nbsp;&nbsp;-&nbsp;<i><strong>Kan gevaarlijk zijn!</strong></i>';
	$_LANG['PERM_ACCESS_DIR_SSL'] = 'Mag de SSL bestanden in /etc/loreji/ssl benaderen <br />&nbsp;&nbsp;-&nbsp;<i><strong>Kan gevaarlijk zijn!</strong></i>';
	$_LANG['PERM_NO_LOCKSCREEN'] = 'Mag het paneel uit slaapstand houden';
	$_LANG['PERM_USE_LSS_KEY'] = 'Mag de LSS (Loreji Store Service) sleutel gebruiken';
	$_LANG['PERM_READ_SETTINGS'] = 'Mag de Loreji instellingen lezen';
	$_LANG['PERM_WRITE_SETTINGS'] = 'Mag de Loreji instellingen wijzigen';
	$_LANG['PERM_READ_MODULE_SETTINGS'] = 'Mag module instellingen lezen';
	$_LANG['PERM_WRITE_MODULE_SETTINGS'] = 'Mag module instellingen schrijven';
	$_LANG['PERM_READ_LOREJI_CONFIG'] = 'Mag Loreji\'s /configs bestanden lezen <br />&nbsp;&nbsp;-&nbsp;<i><strong>Kan gevaarlijk zijn!</strong></i>';
	$_LANG['PERM_WRITE_LOREJI_CONFIG'] = 'Mag Loreji\'s /configs bestanden schrijven <br />&nbsp;&nbsp;-&nbsp;<i><strong>Kan gevaarlijk zijn!</strong></i>';
	$_LANG['PERM_USE_CREDENTIALS'] = 'Mag de gegevens van de huidige gebruiker lezen';
	$_LANG['PERM_APPEND_MAIN_MENU'] = 'Mag een menu element aanmaken in hoofdmenu';

	$_LANG['global.permission.error'] = '<strong>PERMISSIE MANAGER:</strong> Illigale vraag van module <strong>{{modname}}</strong>, die de permissie: "<strong>{{permname}}</strong>" mist.<br />
		        							Het is mogelijk dat dit een vergissing was door de module auteur, maar dit kan ook een gemodificeerde module met kwaadaardige code zijn! <br /> 
		        							Wees voorzichtig als u de module.json bestand gaat bewerken of maak melding bij <a href=\'mailto:support@loreji.com\'>Loreji Support</a>'

?>
