<?php

mysql_connect('localhost', 'root', 'root');
mysql_select_db('test');

if ($_GET['action'] == 'login') {
	$res = query('SELECT username FROM oauth_users WHERE username = %1 AND password = MD5(%2)', $_POST['client_id']);
	if (mysql_fetch_row($res)) {
		
	} else {
		
	}
}

if ($_REQUEST['response_type'] == 'code') {
	if ($_REQUEST['client_id']) {
		$res = query('SELECT client_name, redirect_uri FROM oauth_clients WHERE id_client = %1', $_REQUEST['client_id']);
		if (mysql_fetch_row($res)) {
			require('authentication.php');
		}
	}
}

/* *** END OF MAIN *** */

function query($query) {
	$search = array();
	$replace = array();
	for ($i = 0; $i < func_num_args(); $i++) {
		$search[] = '%'.($i+1);
		$replace[] = '"'.mysql_real_escape_string(func_get_arg($i)).'"';
	}
	$res = mysql_query(str_replace($search, $replace, $query));
	if (mysql_errno()) die(mysql_errno().': '.mysql_error());
	return $res;
}
