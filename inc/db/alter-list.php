<?php
global $wpdb;
$list_table = $this->lists_table();
if( $wpdb->get_var("SHOW COLUMNS FROM ". $list_table ." LIKE 'public'") == false) {
	$wpdb->query("ALTER TABLE ".$this->lists_table()." ADD COLUMN `public` TINYINT(1) DEFAULT 1");
}