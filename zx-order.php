<?php
/*
 * Plugin Name: zx Order
 * Plugin URI: https://mrzx.ir/
 * Description: برای سفارس و ثبت پروژه درخواستی .
 * Version: 1.0
 * Author: Reza.zx 
 * Author URI: https://mrzx.ir/
 * Text Domain: zx-order
 */

defined( 'ABSPATH' ) || exit;

define( 'zx_order_url', plugin_dir_url( __FILE__ ) );
define( 'zx_order_path', plugin_dir_path( __FILE__ ) );
define( 'zx_order_plugin', plugin_basename( __FILE__ ) );

include_once('include/db.php');

//active and deactive hook
register_activation_hook(__FILE__,'zx_order_activate_plugin');
register_deactivation_hook(__FILE__,'zx_order_deactivate_plugin');
register_uninstall_hook( __FILE__, 'zx_order_delete_plugin');

function zx_order_activate_plugin(){
    zx_order_create_db();        

    $my_post = array(
        'post_title'    => 'سفارش پروژه',
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'page',
        'post_slug' => 'سفارس-پروژه',
        //'page_template'  => 'zx-w-user-form.php'
      );
  
      // Insert the post into the database
      if(get_page_by_title( 'سفارش پروژه')==NULL)     
        $page_id=wp_insert_post( $my_post );        
}

function zx_order_deactivate_plugin(){

}

function zx_order_delete_plugin(){

}

add_action( 'admin_menu', 'zx_order_admin_menu', 99 );
function zx_order_admin_menu(){
    add_menu_page(__('سفارش پروژه'),__('سفارش پروژه'),
    'manage_options',
    'zx_order','zx_order_admin_page' ,zx_order_url.'assets/img/icon.png',25);        
    wp_enqueue_style( 'w3_css',zx_order_url.'assets/css/w3.css' );        
    wp_enqueue_style( 'zx-order-admin',zx_order_url.'assets/css/zx-order.css' );        
}

function zx_order_admin_page(){
    //echo 'hello rest';
    return require_once( 'view/admin/admin.php' );    
}

include_once('include/rest.php');

add_filter( 'page_template', 'zx_order_public_page_template',999);
function zx_order_public_page_template( $page_template )
{
    if ( is_page('سفارش پروژه') ) {
        $page_template = dirname( __FILE__ ). '/view/public/index.php';
    }
    return $page_template;
}