<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello,world</title>
</head>

<body>
  <p><?php
require('function.php');

   
   $yellow='玉井詩織';
   $red='百田夏菜子';
   $pink='佐々木彩夏';
   $purple='高城れに';
   $overview=<<<EOI
   ももいろクローバーZは "$red"・"$yellow"・"$pink"・$purple からなる4人組ガールズユニットである。
   2014年には、国立競技場でのライブを女性グループとしては初めて行い、2日間で11万人を動員した。
   ライブの年間動員数においては、過去2度にわたり女性アーティスト1位を記録。
   EOI;
 
   $momoclo=array("$yellow",'$pink',"${red}","$purple");

   foreach($momoclo as $momoclo_member){
     echo $momoclo_member;
     echo '<br>';
    }
  echo $overview;
  
    
      ?></p>
</body>

</html>
