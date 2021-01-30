<?php   
header('Content-Type: image/png');
session_start();
    $im = imagecreate(80, 40)or die("Cannot Initialize new GD image stream");
    $background_color = imagecolorallocate($im, 238, 238, 238); 
    $red = imagecolorallocate($im, 255, 100, 100);
    $blue = imagecolorallocate($im,100,100,255);
    $green = imagecolorallocate($im,100,255,100);
    $white=imagecolorallocate($im,250,250,250);

    $num=rand(1001,9999);
    $strnum=$num."";
    $_SESSION["captcha-code"]=$num;

    for($i=0;$i<3;$i++){
        imageline ($im,  rand(2,35),  rand(0,45), rand(40,73), rand(10,40), $red);
        imageline ($im,  rand(2,35),  rand(0,45), rand(40,73), rand(10,40), $blue);        
        imageline ($im,  rand(2,35),  rand(0,45), rand(40,73), rand(10,40), $green);
        imagefilledellipse($im, rand(2,70),  rand(0,45), 10, 10, $white);
        imagefilledellipse($im, rand(2,70),  rand(0,45), 5, 10, $green);
        imagefilledellipse($im, rand(2,70),  rand(0,45), 5, 5, $blue);
        imagefilledellipse($im, rand(2,70),  rand(0,45), 7, 12, $red);
        }
        
    $ff=dirname(__FILE__) .'/font.ttf';    
    
    imagettftext($im, 22,0, 5,  rand(25,35),imagecolorallocate($im, rand(0,50), rand(0,100),rand(50,150)),$ff,$strnum[0] );
    imagettftext($im, 22,0, 22,  rand(25,35),imagecolorallocate($im, rand(0,50), rand(0,100),rand(50,150)),$ff,$strnum[1] );
    imagettftext($im, 22,0, 38,  rand(25,35),imagecolorallocate($im, rand(0,50), rand(0,100),rand(50,150)),$ff,$strnum[2] );
    imagettftext($im, 22,0, 52,  rand(25,35),imagecolorallocate($im, rand(0,50), rand(0,100),rand(50,150)),$ff,$strnum[3] );
                        
    for($i=0;$i<3;$i++){
        imageline ($im,  rand(2,35),  rand(0,45), rand(40,73), rand(10,40), $red);
        imageline ($im,  rand(2,35),  rand(0,45), rand(40,73), rand(10,40), $blue);        
        imageline ($im,  rand(2,35),  rand(0,45), rand(40,73), rand(10,40), $green);        
        }
    imagepng($im);

    imagedestroy($im);     
?>