<?php

//add_action('wp_ajax_zx_upload_avatar','zx_upload_avatar' );
//add_action('wp_ajax_nopriv_zx_upload_avatar','zx_upload_avatar' );
function zx_order_uploader($file){        
    $errors= array();            
    $file_size = esc_html( $file['size']);            
    $file_type = esc_html($file['type']);
    $file_ext=strtolower(end(explode('.',esc_html($file['name']) )));            
    
    $expensions= array("jpg","jpeg","png","pdf");
    
    if(in_array($file_ext,$expensions)=== false){
        return false;
    }
    
    if($file_size > 1024000) {
        return false;
    }                     

    $upload_dir = wp_upload_dir(); 
    if ( ! empty( $upload_dir['basedir'] ) ) {
        $user_dirname = $upload_dir['basedir'].'/zx-order-files';
        if ( ! file_exists( $user_dirname ) ) {
            wp_mkdir_p( $user_dirname );
        }

        $filename = rand(1000000,9999999).'_'.esc_html($file['name']);
        if(move_uploaded_file(esc_html($file['tmp_name']), $user_dirname .'/'. $filename))
        {            
            $url=$upload_dir['baseurl'].'/zx-order-files/'.$filename;            
            return $url;
        }        
    } 
    return false;
}
