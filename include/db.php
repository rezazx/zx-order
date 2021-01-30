<?php

defined( 'ABSPATH' ) || exit;


function zx_order_create_db() {
	global $wpdb;
  	$version = get_option( 'zx_order_version', '1.0' );
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'zx_order';
    if ($wpdb->get_var("show tables like '$table_name'") != $table_name){
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(128),
            mobile VARCHAR(32),
            email VARCHAR(128) ,
            title VARCHAR(128),
            price VARCHAR(32),
            days VARCHAR(32),            
            description TEXT,
            file TEXT,
            rdate varchar(255),
            PRIMARY KEY (ID)		
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    $charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'zx_order_config';
    if ($wpdb->get_var("show tables like '$table_name'") != $table_name){
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255),            
            value varchar(255),            
            PRIMARY KEY (ID)		
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}

function zx_order_insert($tb,$info){
    global $wpdb;		        
    $table_name = $wpdb->prefix . $tb;
        
    if($wpdb->insert( $table_name, $info))
        return true;
    return false;      
}

function zx_order_delete($tb,$where){
    global $wpdb;		        
    $table_name = $wpdb->prefix . $tb;
    $result = $wpdb->delete($tb,$where);
    if($result!=false)
        return true;            
    return false;
}

function zx_order_read($tb,$where='1',$cols='*'){
    global $wpdb;		
	
    $table_name = $wpdb->prefix . $tb;
    
    $result = $wpdb->get_results("SELECT $cols FROM $table_name WHERE $where ;") ;// or die(mysql_error());
    return $result;
}