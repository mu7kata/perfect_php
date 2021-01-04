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
   $momoclo= array("$yellow","$pink","${red}","$purple");

function add($v1,$v2){
  return $v1+$v2;
}
echo call_user_func('add',1,2);
    

      ?></p>
</body>

</html>
