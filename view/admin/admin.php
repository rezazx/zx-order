<?php
// Silence is golden.
defined( 'ABSPATH' ) || exit;
//include_once( plugin_dir_path( __FILE__ ).'include/db.php');
?>
<div class="zx-order-container">
    <div class="w3-blue w3-center w3-large">درخواست های ثبت شده</div>
<?php
    $tb=array_reverse(zx_order_read('zx_order','1'));
    
    if(!empty($tb))
    {
        foreach($tb as $row)
        {
            ?>
            <div class="w3-row order">
            <?php
                echo '<div class="w3-col m12 ">تاریخ : '.parsidate("Y/m/d",date('Y/m/d',$row->rdate)).'</div>';
                echo '<div class="w3-col m4 ">نام : '.$row->name.'</div>';
                echo '<div class="w3-col m4 ">موبایل : '.$row->mobile.'</div>';
                echo '<div class="w3-col m4 ">ایمیل : '.$row->email.'</div>';
                echo '<div class="w3-col m4 ">عنوان پروژه : '.$row->title.'</div>';
                echo '<div class="w3-col m4 ">هزینه پیشنهادی : '.$row->price.' تومان</div>';
                echo '<div class="w3-col m4 ">زمان درخواستی : '.$row->days.' روز</div>';
                echo '<div class="w3-col m12 ">توضیحات : '.$row->description.'</div>';
                if(!empty($row->file))
                    {
                        $file_name=end(explode('/',$row->file));
                        echo '<div class="w3-col m12 ">فایل پیوست شده  : <a href="'.$row->file.'">'.$file_name.'</a></div>';
                    }
            ?>
            </div>
        <?php
        }
    }
?>
</div>