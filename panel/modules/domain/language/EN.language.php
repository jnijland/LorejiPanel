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
	$_LANG['domain.table.title'] = 'List of all domains';
	$_LANG['domain.table.domainname'] = 'Domain name';
	$_LANG['domain.table.directoryname'] = 'Directory name';
	$_LANG['domain.table.status'] = 'Status';
	$_LANG['domain.table.status.pending'] = 'Pending';
	$_LANG['domain.table.pending'] = 'It can take 5 to 10 minutes for the domain to get live.';
	$_LANG['domain.table.status.live'] = 'Live';
	$_LANG['domain.table.dns'] = 'DNS';
	$_LANG['domain.table.dns.label.error'] = 'Error';
	$_LANG['domain.table.dns.label.ok'] = 'Ok';
	$_LANG['domain.table.dns.error'] = 'Check your DNS settings. The domain IP does not match the IP of the server.';

	// add_domain.php
	$_LANG['domain.header.name'] = 'Domains';
	$_LANG['domain.header.desc'] = 'Manage your domains';

	$_LANG['domain.form.adddomain'] = 'Add a new domain';
	$_LANG['domain.form.placeholder.domain'] = 'mydomain.com';
	$_LANG['domain.form.label.domain'] = 'Domain';
	$_LANG['domain.form.label.directory'] = 'Directory';
	$_LANG['domain.form.placeholder.newdir'] = 'New directory';

	$_LANG['domain.form.addsubdomain'] = 'Ádd a new sub-domain';
	$_LANG['domain.form.placeholder.subdomain'] = 'sub';
	$_LANG['domain.form.label.subdomain'] = 'Sub-domain';

	// edit.php
	$_LANG['domain.form.edit'] = 'Edit domain';
	$_LANG['domain.form.ssl'] = 'Enable SSL';
	$_LANG['domain.form.ssl.choose'] = 'Select Certificate';

	$_LANG['domain.alert.saved'] = 'Saved <strong>{{domainname}}</strong> successfully';

	// Menu
	$_LANG['domain.menu.title'] = 'Domains';
	$_LANG['domain.menu.overview'] = 'Overview';
	$_LANG['domain.menu.adddomain'] = 'Add domain';
?>