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

function add(&$v1,$v2){
  echo  pow($v1,$v2);
}

$my_pow=function($times=2)
{
  return function ($v)use ($times) {
    return pow($v,$times);
  };
};


  class Momoclo{
    public $yellow='玉井詩織';
    public $red='百田夏菜子';
    public $pink='佐々木彩夏';
    public $purple='高城れに';

    public static $miryoku = '元気がいい';

    public function work($v){
        switch ($this->pink){
          case '佐々木彩夏':
            echo 'ぷにっぷに';
        }
    }
  } 

  $idol= new Momoclo();
  
class StarDust{
  const aa='aa';

  public $type;
  public $name;
  public function __construct($name,$type)
  {
    $this->name=$name;
    $this->type=$type;
  }
}
$ukka=new StarDust('ukka',StarDust::aa);
echo $ukka->name;
    

      ?></p>
</body>

</html>
