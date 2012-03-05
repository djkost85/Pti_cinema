<?php
require_once '\inc\conf.inc.php';

	class Db
	{
		public function __construct() {
			global $conf_db, $conf_dbHost, $conf_dbUser, $conf_dbPwd;
			
			mysql_connect($conf_dbHost, $conf_dbUser, $conf_dbPwd);
			mysql_select_db($conf_db);
		}
		public function queryArray($sql) {
			if($res=mysql_query($sql)) {
				$rows=array();
				while($record=mysql_fetch_object($res))
					$rows[]=$record;
				mysql_free_result($res);
				return $rows;
			}
			else
				return false;	
		}
		public function querySingle($sql) {
			if($res=mysql_query($sql)) {
				$row=mysql_fetch_object($res) ;
				mysql_free_result($res);
				return $row;
			}
			else
				return false;	
		}
	}
?>
	