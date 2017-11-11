<?php
class IP {
  public function ngecurl($url, $str){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.$str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  }
  public function dataIP($ip, $data){
    $result = $this->ngecurl("http://extreme-ip-lookup.com/json/", $ip);
    if($result == false){
      return "127.0.0.1";
    }
    $detect = json_decode($result);
    switch($data){
      case "code":
        $str = $detect->countryCode;
        break;
      case "country":
        $str = $detect->country;
        break;
      case "city":
        $str = $detect->city;
        break;
      case "state":
        $str = $detect->region;
        break;
      case "isp":
        $str = $detect->isp;
        break;
      case "ip":
        $str = $detect->query;
        break;
      default:
        $str = $detect->status;
    }
    return $str;
  }
}
$run  = new IP();
$ip   = $_SERVER['REMOTE_ADDR'];
$data = array(
  "countrycode" => $run->dataIP($ip, "code"),
  "country"     => $run->dataIP($ip, "country"),
  "city"        => $run->dataIP($ip, "city"),
  "state"       => $run->dataIP($ip, "state"),
  "isp"         => $run->dataIP($ip, "isp"),
  "ip"          => $run->dataIP($ip, "ip")
);
$result = json_encode($data, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $result;
?>
