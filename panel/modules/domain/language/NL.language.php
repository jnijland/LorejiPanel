<?php defined('SYSPATH') or die('No direct script access allowed.');

	/* *
	*
		Module Domains -> Language file
	*
	* @Author Ramon Smit  <ramon@daltcore.com>
	* @Version 0.1.0
	*/

	// Placeholder
	$_LANG[''] = '';

	// overview.php
	$_LANG['domain.table.title'] = 'Lijst met alle domeinen';
	$_LANG['domain.table.domainname'] = 'Domeinnaam';
	$_LANG['domain.table.directoryname'] = 'Mapnaam';
	$_LANG['domain.table.status'] = 'Status';
	$_LANG['domain.table.status.pending'] = 'Wachten';
	$_LANG['domain.table.pending'] = 'Het kan ongeveer 5 tot 10 minuten duren tot het domein als live gemarkeerd is.';
	$_LANG['domain.table.status.live'] = 'Live';
	$_LANG['domain.table.dns'] = 'DNS';
	$_LANG['domain.table.dns.label.error'] = 'Error';
	$_LANG['domain.table.dns.label.ok'] = 'Ok';
	$_LANG['domain.table.dns.error'] = 'Controleer je DNS instellingen. Het IP van de domein komt niet overeen met het IP van de server.';

	// add_domain.php
	$_LANG['domain.header.name'] = 'Domeinen';
	$_LANG['domain.header.desc'] = 'Beheer je domeinen';

	$_LANG['domain.form.adddomain'] = 'Voeg een nieuw domein toe';
	$_LANG['domain.form.placeholder.domain'] = 'mijndomein.nl';
	$_LANG['domain.form.label.domain'] = 'Domein';
	$_LANG['domain.form.label.directory'] = 'Map';
	$_LANG['domain.form.placeholder.newdir'] = 'Nieuwe map';

	$_LANG['domain.form.addsubdomain'] = 'Voeg een nieuw sub-domein toe';
	$_LANG['domain.form.placeholder.subdomain'] = 'sub';
	$_LANG['domain.form.label.subdomain'] = 'Sub-domein';

	// edit.php
	$_LANG['domain.form.edit'] = 'Domein aanpassen';
	$_LANG['domain.form.ssl'] = 'SSL';
	$_LANG['domain.form.ssl.choose'] = 'Kies certificaat';

	$_LANG['domain.alert.saved'] = '<strong>{{domainname}}</strong> is sucsessvol opgeslagen!';

	// Menu
	$_LANG['domain.menu.title'] = 'Domeinen';
	$_LANG['domain.menu.overview'] = 'Overzicht';
	$_LANG['domain.menu.adddomain'] = 'Domein toevoegen';
?>