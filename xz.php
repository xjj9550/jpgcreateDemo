<?php
header("Content-Type:text/html;charset=utf-8");
$conn = mysqli_connect('localhost','root','xj9550','php8') or die('error connecting');
mysqli_query($conn,"set names 'utf8'");

$sql = "select * from username order by id asc limit 0,7";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result))  {   
		
    $bigImgPath = 'demo.jpg';
    $img = imagecreatefromstring(file_get_contents($bigImgPath));

    $font = 'msyh.ttf';//字体
    $black = imagecolorallocate($img, 255, 255, 255);//字体颜色 RGB
 
    $fontSize = 30;   //字体大小
    $circleSize = 0; //旋转角度

    $text = $row['name'];
    $len = abslength($text);
    

    $left = 90;      //左边距
    if($len==2){
        $top = 255;       //顶边距
    }elseif($len==3){
        $top = 245;       //顶边距
    }elseif($len==4){
        $top = 235;       //顶边距
    }elseif($len==5){
        $top = 225;       //顶边距
    }elseif($len==6){
        $top = 215;       //顶边距
    }
    
    $str = '';
    for($i=0;$i<$len;$i++){
        $txt = mb_substr($text,$i,1,'utf-8');
        imagefttext($img, $fontSize, $circleSize, $left, $top, $black, $font, $txt);
        $top = $top;//设置字体的高度
        $left = $left+50;
    }
    
     // 生成图片
    $newname = $row['id'];
    imagepng($img, $newname.'.png');
    imagedestroy($img);		
} 


function abslength($str)
{
if(empty($str)){
    return 0;
}
if(function_exists('mb_strlen')){
    return mb_strlen($str,'utf-8');
}
else {
    preg_match_all("/./u", $str, $ar);
    return count($ar[0]);
}
}
function csubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) 
{ 

if(function_exists("mb_substr")) 
{ 

   if(mb_strlen($str, $charset) <= $length) return $str; 

   $slice = mb_substr($str, $start, $length, $charset); 

} 
else
{ 

   $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/"; 

   $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/"; 

   $re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/"; 

   $re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/"; 

   preg_match_all($re[$charset], $str, $match); 

   if(count($match[0]) <= $length) return $str; 

   $slice = join("",array_slice($match[0], $start, $length)); 

} 

if($suffix) return $slice; 

return $slice; 

}