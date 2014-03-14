<?php
class createCode{
    
    var $str = "1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,g,k,m,n,p,q,r,s,t,u,v,w,x,y,z";//验证码字库
    private $width;
    private $height;
    
    public function __construct(){
        session_start();
        header("Content-type: image/png");
        $this->width = 58;
        $this->height = 16;
    }
    
    public function create(){
        $list = explode(",", $this->str);
        $cmax = count($list) - 1;
        $verifyCode = '';
        for ( $i=0; $i < 5; $i++ ){
            $randnum = mt_rand(0, $cmax);
            $verifyCode .= $list[$randnum];//取出字符，组合成为我们要的验证码字符
        }
        $_SESSION['verifyCode'] = $verifyCode;//将字符放入SESSION中
        
        $im = imagecreate($this->width,$this->height);//生成图片
        $black = imagecolorallocate($im, 0,0,0);//此条及以下三条为设置的颜色
        $white = imagecolorallocate($im, 255,255,255);//白色
        $gray = imagecolorallocate($im, 200,200,200);//灰色
        $red = imagecolorallocate($im, 255, 0, 0);//红色
        imagefill($im,0,0,$white);//给图片填充颜色
        
        //将验证码绘入图片
        imagestring($im, 5, 5, 0, $verifyCode, $black);
        
        for($i=0;$i<50;$i++){//加入干扰象素
            imagesetpixel($im, rand(0,$this->width) , rand(0,$this->height) , $black);//加入点状干扰素
            imagesetpixel($im, rand(0,$this->width) , rand(0,$this->height) , $red);
            imagesetpixel($im, rand(0,$this->width) , rand(0,$this->height) , $gray);
//             imagearc($im, rand(0,$this->width), rand(0,$this->height), 20, 20, 75, 170, $black);    //加入弧线状干扰素
//             imageline($im, rand()p, rand()p, rand()p, rand()p, $red);    //加入线条状干扰素
        }
        imagepng($im);
        imagedestroy($im);
    }
    
    public function checkCode($verifyCode){
        if ($verifyCode == $_SESSION['verifyCode']){
            return true;
        }else {
            return false;
        }
        
    }
    
}

$aa = new createCode();
$aa->create();

?>