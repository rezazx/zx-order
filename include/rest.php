<?php
//ajax.php
//implement my rest api
defined( 'ABSPATH' ) || exit;

include_once('db.php');
include_once('uploader.php');


function zx_order_register_new(WP_REST_Request $req){
    session_start();    
    
    if( empty($req['captchaCode']) || sanitize_text_field($req['captchaCode'])!=$_SESSION['captcha-code'] )
        return rest_ensure_response( 
            array(
                'code'=>'error',
                'message'=>'خطا: کد امنیتی اشتباه است',            
            ));
    
    $_SESSION["captcha-code"]=rand(1001,9999)."";
    if(intval($_SESSION['zx-order-count'])>4)
        return rest_ensure_response( 
            array(
                'code'=>'error',
                'message'=>'خطا : شما بیش از حد مجاز اقدام به ثبت درخواست نموده اید',
            ));

    $name=sanitize_text_field($req['userName'] );
    $mobile=sanitize_text_field($req['userPhone'] );
    $email=sanitize_email($req['userEmail'] );
    $title=sanitize_text_field($req['projectTitle'] );
    $price=sanitize_text_field($req['projectPrice'] );
    $days=sanitize_text_field($req['projectTime'] );
    $description=sanitize_text_field($req['projectDescription'] );
    //$file=esc_url_raw($req['projectFile'] );
    $rdate=current_time( 'timestamp'); 
    $files = $req->get_file_params();
    $fileUrl='';
    if ( !empty( $files ) && !empty($files['projectFile']) ) 
    {
        $file = $files['projectFile'];        
        $fileUrl=zx_order_uploader($file);
    }    

    if(empty($name)|| empty($mobile) || empty($email) || empty($title)|| empty($description))
        return rest_ensure_response( 
            array(
                'code'=>'error',
                'message'=>'خطا: فیلدهای ورودی را درست وارد کنید.',            
            ));
    
    if(zx_order_insert('zx_order',
        array(
            'name'=>$name,
            'mobile'=>$mobile,
            'email'=>$email,
            'title'=>$title,
            'price'=>$price,
            'days'=>$days,
            'description'=>$description,
            'file'=>$fileUrl,
            'rdate'=>$rdate
    )) )
    {
        $to = get_option('admin_email');
        $subject = 'سفارش پروژه - mrzx.ir';
        $body = '<p style="direction:rtl"> <b> سفارش پروژه </b><br>'.
                'تاریخ : '.parsidate("Y/m/d",date('Y/m/d',$rdate)).' <br>'.
                'نام : '.$name.' <br>'.
                'موبایل : '.$mobile.' <br>'.
                'ایمیل : '.$email.' <br>'.
                'عنوان : '.$title.' <br>'.
                'قیمت : '.$price.' تومان <br>'.
                'تایم : '.$days.' روز <br>'.
                'توضیحات : '.$description.' <br>'.
                'فایل پیوست شده  : <a href="'.$fileUrl.'">'.$fileUrl.'</a> </p>';
        $headers = array('Content-Type: text/html; charset=UTF-8');        
        if(!empty($to))
            wp_mail( $to, $subject, $body, $headers );

        $_SESSION['zx-order-count']=intval($_SESSION['zx-order-count'])+1;

        return rest_ensure_response( 
            array(
                'code'=>'success',
                'message'=>'درخواست شما با موفقیت ثبت شد',                
            ));
    }

    return rest_ensure_response( 
        array(
            'code'=>'error',
            'message'=>'خطا : انجام عملیات ممکن نیست  از راههای دیگر با ما در ارتباط باشید',                
        ));
}

function zx_order_rest_api_routes_registr(){
    register_rest_route( 'zx-order/v1', '/new-order',
        array(
            'methods'=>WP_REST_Server::CREATABLE,
            'callback'=>'zx_order_register_new',
            'permission_callback' => function() {return true;}
        ) );
}

add_action( 'rest_api_init','zx_order_rest_api_routes_registr',100,0);
