<?php

//require_once 'secu.php';

if (isset($_REQUEST['user']) && isset($_REQUEST['pwd']))
	echo secu_gethashedpwd($_REQUEST['user'], $_REQUEST['pwd']);
	
function secu_gethashedpwd($user, $pwd)
{
	hashed_pwd = crypt($pwd);
	
	return hashed_pwd;
}



?>