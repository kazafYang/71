<?php
function machining_price () 
{
echo "comming machining_price\n";
global $stat_date,$time_hour,$time_min,$time_second,$begin_point,$code,$buy_one_price,$sell_one_price;
if ($code<500000) {
$url='http://hq.sinajs.cn/list=sz'.$code; 
}  else{
$url='http://hq.sinajs.cn/list=sh'.$code; 
} 

$html = file_get_contents($url); 
$pieces = explode(",", $html);
$begin_point=$pieces[3];
$buy_one_price=$pieces[6];  //买一价
$sell_one_price=$pieces[7]; //卖一价 
$stat_date=$pieces[30];
$pieces = explode(":", $pieces[31]);    
$time_hour=$pieces[0];
$time_min=$pieces[1];
$time_second=$pieces[2];
} 
function sleep_time () {
echo "comming sleep_time\n";
global $time_hour,$time_min;  
while(($time_hour==9 and $time_min<30) or ($time_hour<13 and $time_hour>=11) or $time_hour<9) {
machining_price();
}
                       }

function kdjfifteen () {
global $begin_point,$conn,$table_name;
machining_price();
$sql="select max(min15_point_max) from (select * from $table_name order by id desc limit 9) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_max=$row[0];
$sql="select min(min15_point_min) from (select * from $table_name order by id desc limit 9) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_min=$row[0];
echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~".$min15_point_min;
$sql="select min15_k from $table_name order by id  desc  limit 1,1;"; 
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$min15_k=$row[min15_k];   
$sql="select min15_d from $table_name order by id  desc  limit 1,1;";
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$min15_d=$row[min15_d];
echo "begin_point:$begin_point~min15_point_max:$min15_point_max~min15_point_min:$min15_point_min~min15_k:$min15_k~min15_d:$min15_d\n";                      
$rsv=($begin_point-$min15_point_min)/($min15_point_max-$min15_point_min)*100;
echo "rsv:$rsv";
$k=2/3*$min15_k+1/3*$rsv;
$d=2/3*$min15_d+1/3*$k;
$j=3*$k-2*$d;
echo "15kdj:$k,$d,$j\n";
$sql="update $table_name set min15_k='$k' , min15_d='$d' , min15_j='$j' order by id desc limit 1 ; ";
   if ($conn->query($sql) === TRUE) 
   {
    echo "15kdjupdate:update\n";
     } 
  else {
    echo "maxError: " . $sql . $conn->error."\n";
}  
}

function kdjthirty () {
global $begin_point,$conn,$table_name;
machining_price();
$sql="select max(min15_point_max) from (select * from $table_name order by id desc limit 18) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_max=$row[0];
$sql="select min(min15_point_min) from (select * from $table_name order by id desc limit 18) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_min=$row[0];

if (($time_hour_begin==9 and $time_min_begin==30) or ($time_hour_begin==10 and $time_min_begin==0) or ($time_hour_begin==10 and $time_min_begin==30) or ($time_hour_begin==11 and $time_min_begin==0) or ($time_hour_begin==13 and $time_min_begin==0) or ($time_hour_begin==13 and $time_min_begin==30) or ($time_hour_begin==14 and $time_min_begin==0)) {
$sql="select min30_k from $table_name order by id  desc  limit 1,1;";
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$min30_k=$row[min30_k]; 
$sql="select min30_d from $table_name order by id  desc  limit 1,1;";
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$min30_d=$row[min30_d];
}
else {
$sql="select min30_k from $table_name order by id  desc  limit 2,1;";
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$min30_k=$row[min30_k]; 
$sql="select min30_d from $table_name order by id  desc  limit 2,1;";
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$min30_d=$row[min30_d];
}  
echo "begin_point:$begin_point~min15_point_max:$min15_point_max~min15_point_min:$min15_point_min~min30_k:$min30_k~min30_d:$min30_d\n";                       
$rsv=($begin_point-$min15_point_min)/($min15_point_max-$min15_point_min)*100;
$k=2/3*$min30_k+1/3*$rsv;
$d=2/3*$min30_d+1/3*$k;
$j=3*$k-2*$d;
echo "30kdj:$k,$d,$j\n";
$sql="update $table_name set min30_k='$k' , min30_d='$d' , min30_j='$j' order by id desc limit 1 ; ";
   if ($conn->query($sql) === TRUE) 
   {
    echo "30kdjupdate:update\n";
     } 
  else {
    echo "maxError: " . $sql . $conn->error."\n";
}  
}  

function kdjsixty () {
global $begin_point,$conn,$table_name;
machining_price();
$sql="select max(min15_point_max) from (select * from $table_name order by id desc limit 36) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_max=$row[0];
$sql="select min(min15_point_min) from (select * from $table_name order by id desc limit 36) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_min=$row[0];

if (($time_hour_begin==9 and $time_min_begin==30) or ($time_hour_begin==10 and $time_min_begin==30) or ($time_hour_begin==13 and $time_min_begin==0) or ($time_hour_begin==14 and $time_min_begin==0)) {
$sql="select min60_k from $table_name order by id  desc  limit 1,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_k=$row[min60_k];
$sql="select min60_d from $table_name order by id  desc  limit 1,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_d=$row[min60_d];
}
elseif (($time_hour_begin==9 and $time_min_begin==45) or ($time_hour_begin==10 and $time_min_begin==45) or ($time_hour_begin==13 and $time_min_begin==15) or ($time_hour_begin==14 and $time_min_begin==15)) {
$sql="select min60_k from $table_name order by id  desc  limit 2,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_k=$row[min60_k];
$sql="select min60_d from $table_name order by id  desc  limit 2,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_d=$row[min60_d];
}
elseif(($time_hour_begin==10 and $time_min_begin==0) or ($time_hour_begin==11 and $time_min_begin==0) or ($time_hour_begin==13 and $time_min_begin==30) or ($time_hour_begin==14 and $time_min_begin==30)) {
$sql="select min60_k from $table_name order by id  desc  limit 3,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_k=$row[min60_k];
$sql="select min60_d from $table_name order by id  desc  limit 3,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_d=$row[min60_d];
}
else{
$sql="select min60_k from $table_name order by id  desc  limit 4,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_k=$row[min60_k];
$sql="select min60_d from $table_name order by id  desc  limit 4,1;";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
$min60_d=$row[min60_d];
}
echo "begin_point:$begin_point~min15_point_max:$min15_point_max~min15_point_min:$min15_point_min~min60_k:$min60_k~min60_d:$min60_d\n";   
$rsv=($begin_point-$min15_point_min)/($min15_point_max-$min15_point_min)*100;
$k=2/3*$min60_k+1/3*$rsv;
$d=2/3*$min60_d+1/3*$k;
$j=3*$k-2*$d;
echo "60kdj:$k,$d,$j\n";
$sql="update $table_name set min60_k='$k' , min60_d='$d' , min60_j='$j' order by id desc limit 1 ; ";
   if ($conn->query($sql) === TRUE) 
   {
    echo "60kdjupdate:update\n";
     } 
  else {
    echo "60kdjError: " . $sql . $conn->error."\n";
}  
}
//day kdj
function kdjday () {
global $begin_point,$conn,$table_name,$stat_date;
machining_price();
$sql="select max(min15_point_max) from (select * from $table_name order by id desc limit 144) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_max=$row[0];
$sql="select min(min15_point_min) from (select * from $table_name order by id desc limit 144) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$min15_point_min=$row[0];

$sql="select kdjday_k from $table_name where stat_date<'$stat_date' order by stat_date desc limit 1;";
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$kdjday_k=$row[kdjday_k]; 
$sql="select kdjday_d from $table_name where stat_date<'$stat_date' order by stat_date desc limit 1;";
$result = $conn->query($sql);  
$row=$result->fetch_assoc();
$kdjday_d=$row[kdjday_d];

echo "begin_point:$begin_point~min15_point_max:$min15_point_max~min15_point_min:$min15_point_min~kdjday_k:$kdjday_k~kdjday_d:$kdjday_d\n";                       
$rsv=($begin_point-$min15_point_min)/($min15_point_max-$min15_point_min)*100;
$k=2/3*$kdjday_k+1/3*$rsv;
$d=2/3*$kdjday_d+1/3*$k;
$j=3*$k-2*$d;
echo "daykdj:$k,$d,$j\n";
$sql="update $table_name set kdjday_k='$k' , kdjday_d='$d' , kdjday_j='$j' order by id desc limit 1 ; ";
   if ($conn->query($sql) === TRUE) 
   {
    echo "daykdjupdate:update\n";
     } 
  else {
    echo "daykdj:updateError: " . $sql . $conn->error."\n";
}  
}
// cci count
function cci () {
echo "comming cci\n";
$min15_point_max= array();
$min15_point_min = array();
$now_price = array();
global $conn,$table_name; 

for ($i=1;$i<15;$i++){
$sql="select max(min15_point_max) from (select * from $table_name order by id desc limit $i,1) as a;";
echo $sql."/n";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$date_point_max=$row[0];

$sql="select min(min15_point_min) from (select * from $table_name order by id desc limit $i,1) as a;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$date_point_min=$row[0];


$sql="select now_price from $table_name order by id desc limit 1,$i;";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($result);
$date_now_price=$row[0];

$min15_point_max[]=$date_point_max;
$min15_point_min[]=$date_point_min;
$now_price[]=$date_now_price;
} 

$typ1=($min15_point_max[0]+$min15_point_min[0]+$now_price[0])/3;
$typ2=($min15_point_max[1]+$min15_point_min[1]+$now_price[1])/3;
$typ3=($min15_point_max[2]+$min15_point_min[2]+$now_price[2])/3;
$typ4=($min15_point_max[3]+$min15_point_min[3]+$now_price[3])/3;
$typ5=($min15_point_max[4]+$min15_point_min[4]+$now_price[4])/3;
$typ6=($min15_point_max[5]+$min15_point_min[5]+$now_price[5])/3;
$typ7=($min15_point_max[6]+$min15_point_min[6]+$now_price[6])/3;
$typ8=($min15_point_max[7]+$min15_point_min[7]+$now_price[7])/3;
$typ9=($min15_point_max[8]+$min15_point_min[8]+$now_price[8])/3;
$typ10=($min15_point_max[9]+$min15_point_min[9]+$now_price[9])/3;
$typ11=($min15_point_max[10]+$min15_point_min[10]+$now_price[10])/3;
$typ12=($min15_point_max[11]+$min15_point_min[11]+$now_price[11])/3;
$typ13=($min15_point_max[12]+$min15_point_min[12]+$now_price[12])/3;
$typ14=($min15_point_max[13]+$min15_point_min[13]+$now_price[13])/3;
$matyp=($typ1+$typ2+$typ3+$typ4+$typ5+$typ6+$typ7+$typ8+$typ9+$typ10+$typ11+$typ12+$typ13+$typ14)/14;
$aytyp=(abs($typ1-$matyp)+abs($typ2-$matyp)+abs($typ3-$matyp)+abs($typ4-$matyp)+abs($typ5-$matyp)+abs($typ6-$matyp)+abs($typ7-$matyp)+abs($typ8-$matyp)+abs($typ9-$matyp)+abs($typ10-$matyp)+abs($typ11-$matyp)+abs($typ12-$matyp)+abs($typ13-$matyp)+abs($typ14-$matyp))/14;
$cci=($typ1-$matyp)/$aytyp/0.015;
$sql="update $table_name set cci='$cci' order by id desc limit 1 ; ";
   if ($conn->query($sql) === TRUE) {
    echo "cci:新记录更新成功\n";
     } 
  else {
    echo "cci新纪录更新Error: " . $sql . $conn->error."\n";
}
}  

function analyse () {
  echo "comming analyse"."\n";
global $table_name,$code,$conn; 
$trade_code=array("point_number","point_number_sz","point_number_sz100","point_number_zxb","point_number_hs","point_number_zq","point_number_jg","point_number_yh");                                                                                                                                                                                              
//$conn = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $mysql_database);                                                                                    
//foreach ($trade_code as $value)                                                                                                                                                     
//{    
    echo "comming analyse for!\n";
/*    $sql = "select id,stat_time_min from $table_name order by id desc limit 1;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();
    $row[id]=$row[id]+1;                      //先查询出数据数量  */
  
    $sql = "SELECT code,stat_date,stat_time_hour,stat_time_min,min15_k,min15_d,min15_j,min30_k,min30_d,min30_j,min60_k,min60_d,min60_j,kdjday_k,kdjday_d,kdjday_j,cci,buy_one_price,sell_one_price FROM $table_name order by id desc limit 1";                                                                  
    $result = $conn->query($sql);                                                                                                                                             
    $row = $result->fetch_assoc();
    $trade_code=$row[code];$trade_buy_price=$row[buy_one_price];$trade_sell_price=$row[sell_one_price];
    $trade_stat_date=$row[stat_date];$trade_time_hour=$row[stat_time_hour];$trade_time_min=$row[stat_time_min];
    $trade_min15_k=round($row[min15_k],2);$trade_min15_d=round($row[min15_d],2);$row[min15_j]=round($row[min15_j],2);
    $trade_min30_k=round($row[min30_k],2);$trade_min30_d=round($row[min30_d],2);$row[min30_j]=round($row[min30_j],2);
    $trade_min60_k=round($row[min60_k],2);$trade_min60_d=round($row[min60_d],2);$row[min60_j]=round($row[min60_j],2);
    $trade_day_k=round($row[kdjday_k],2);$trade_day_d=round($row[kdjday_d],2);$row[kdjday_j]=round($row[kdjday_j],2);
   //15min
   
   /* $sql = "select number,number_bate from trade_bate where code=$trade_code order by trade_type asc ;";    
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_row($result); 
    $number1=$row[0];$number_bate1=$row[1];$number2=$row[2];$number_bate2=$row[3];
    $number3=$row[4];$number_bate3=$row[5];$number4=$row[6];$number_bate4=$row[7];
    $number5=$row[8];$number_bate5=$row[9];$number6=$row[10];$number_bate6=$row[11];
    $number7=$row[12];$number_bate7=$row[13];$number8=$row[14];$number_bate8=$row[15]; */
  // echo $number1."-".$number1."-".$number1."-".$number1."-".$number1."-".$number1."-".$number1."-".$number1."-".;
  if(($trade_min15_k >= 80 and $trade_min15_k < 99 and ($trade_min60_k >= 40 or $trade_min60_d >= 40)) or ($trade_min15_d>=75 and $trade_min15_d<80 and ($trade_min60_k >= 50 or $trade_min60_d >= 50)))
    {
    echo "panduan:".$trade_min15_k."~~~~~~~comming~~~~~~~~~~~~~\n";
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=1;";    
    echo $sql."~~~~~~~~~~~~~~~~~~~~~~~~~~~@@@@@@@@@@@@@@@@@@@@@~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_row($result);
    echo $row[0]."~~~~~~~~~~~~~~~~~~~~~~~~~~~@@@@@@@@@@@@@@@@@@@@@~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";
    if($row[0]==0){
        echo $row[0]."~~~~~~~~~~~~~~~~~~~~~~~~~~~@@@@@@@comming panduan 0 number@@@@@~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";  
    //$number=$number1+$number1*$number_bate1; 
    $number="1550";  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','1','$trade_buy_price','$trade_sell_price');";                                                                  
    echo "insert into sql:".$sql;
      $result = $conn->query($sql); 
       }
    } 

//30min  
   if (($trade_min30_k >=75 and $trade_min30_k <80) or ($trade_min30_d >=75 and $trade_min30_d <80)){
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=2;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();     
    if($row[0]==0){
   // $number=$number2+$number2*$number_bate2;  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','2','$trade_buy_price','$trade_sell_price');";                                                                  
    $result = $conn->query($sql); 
       }
    } 
   
 //60分钟          
   if (($trade_min60_k >=75 and $trade_min60_k<80) or ($trade_min60_d >=75 and $trade_min60_d <80)) {
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=3;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();     
    if($row[0]==0){
    //$number=$number3+$number3*$number_bate3;  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','3','$trade_buy_price','$trade_sell_price');";                                                                  
    $result = $conn->query($sql); 
       }
    }
   
  //日线
    if (($trade_day_k >=75 and $trade_day_k<80) or ($trade_day_d >=75 and $trade_day_d <80)) {
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=4;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();     
    if($row[0]==0){
   // $number=$number4+$number4*$number_bate4;  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','4','$trade_buy_price','$trade_sell_price');";                                                                  
    $result = $conn->query($sql); 
       }
    }  
   
  //buy,分钟
    echo $trade_min15_k."-------".$trade_min15_d."~~~~~~~~~~~~~~";
    if ($trade_min15_k <20 or $trade_min15_d <20 ){
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=5;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();     
    if($row[0]==0){
   // $number=$number5+$number5*$number_bate5;  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','5','$trade_buy_price','$trade_sell_price');";                                                                  
    $result = $conn->query($sql); 
       }
    }  
    if ($trade_min30_k <20 or $trade_min30_d <20 ){
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=6;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();     
    if($row[0]==0){
   // $number=$number6+$number6*$number_bate6;  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','6','$trade_buy_price','$trade_sell_price');";                                                                  
    $result = $conn->query($sql); 
       }
    }   
    if ($trade_min60_k <20 or $trade_min60_d <20 ){
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=7;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();     
    if($row[0]==0){
   // $number=$number7+$number7*$number_bate7;  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','7','$trade_buy_price','$trade_sell_price');";                                                                  
    $result = $conn->query($sql); 
       }
    }
    if ($trade_day_k <20 or $trade_day_d <20 ){
    $sql = "select count(*) from trade_history where code='$trade_code' and stat_date='$trade_stat_date' and stat_time_hour='$trade_time_hour' and stat_time_min='$trade_time_min' and trade_type=8;";    
    $result = $conn->query($sql);
    $row=$result->fetch_assoc();     
    if($row[0]==0){
   // $number=$number8+$number8*$number_bate8;  
    $sql = "insert into trade_history (code,stat_date,stat_time_hour,stat_time_min,status,number,trade_type,trade_buy_price,trade_sell_price) values ('$trade_code','$trade_stat_date','$trade_time_hour','$trade_time_min','0','$number','8','$trade_buy_price','$trade_sell_price');";                                                                  
    $result = $conn->query($sql); 
       }
    }
//}                
}

function nine_count () {
global $time_hour,$time_min,$time_second,$begin_point,$table_name,$time_out_begin,$conn,$buy_one_price,$sell_one_price;
echo "comming nine_count\n";
machining_price();   
$max=$begin_point;
$min=$begin_point;
$time_out_now=($time_hour*3600)+($time_min*60);  
$sql="update $table_name set min15_point_max=$max,min15_point_min=$min order by id desc limit 1 ;";
$conn->query($sql);  
while( $time_out_now < $time_out_begin) {
echo "time_out_now:$time_out_now~time_out_begin:$time_out_begin\n"; 
machining_price();
$time_out_now=($time_hour*3600)+($time_min*60);
  echo "$max--$begin_point\n";  
if ($begin_point>=$max)
{
    $max=$begin_point;
    echo "$max\n";
    $sql="update $table_name set min15_point_max=$max order by id desc limit 1 ;";
    echo $sql."\n";
}
   if ($conn->query($sql)=== TRUE)
   {
    echo "max新纪录更新成功\n";
     } 
  else {
    echo "max新纪录更新Error: " . $sql . $conn->error."\n";
}
  
if ($begin_point<=$min)
{
    $min=$begin_point; 
    $sql="update " .$table_name." set min15_point_min=$min order by id desc limit 1 ; ";
} 
   if ($conn->query($sql) === TRUE) {
    echo "min:新记录更新成功\n";
     } 
  else {
    echo "min新纪录更新Error: " . $sql . $conn->error."\n";
}
//更新买一，卖一实时价格  
$sql="update $table_name set now_price=$begin_point,buy_one_price=$buy_one_price,sell_one_price=$sell_one_price order by id desc limit 1 ;";
$conn->query($sql);
  
kdjfifteen(); #begin:kdj
kdjthirty();
kdjsixty(); 
kdjday();
analyse();  
cci();
} 
}
?>
