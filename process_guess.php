<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: game.php'); exit; }
$gy = (int)$_POST['year_guess'];
$glat = (float)$_POST['lat_guess'];
$glng = (float)$_POST['lng_guess'];
$cy = (int)$_SESSION['correct_year'];
$clat = (float)$_SESSION['correct_lat'];
$clng = (float)$_SESSION['correct_lng'];
$ydiff = abs($gy - $cy);
if ($ydiff==0) $ys=5000;
elseif ($ydiff==1) $ys=4950;
elseif ($ydiff<=5) $ys=5000-($ydiff*50);
elseif ($ydiff<=10) $ys=4750-(($ydiff-5)*50);
elseif ($ydiff<=25) $ys=4500-(($ydiff-10)*50);
elseif ($ydiff<=50) $ys=3750-(($ydiff-25)*50);
elseif ($ydiff<=100) $ys=2500-(($ydiff-50)*50);
else $ys=0;
$ys=max(0,$ys);
function dist($lat1,$lon1,$lat2,$lon2){
    $r=6371;
    $a=sin(deg2rad($lat2-$lat1)/2)**2+cos(deg2rad($lat1))*cos(deg2rad($lat2))*sin(deg2rad($lon2-$lon1)/2)**2;
    return $r*2*atan2(sqrt($a),sqrt(1-$a));
}
$dkm=dist($glat,$glng,$clat,$clng);
if ($dkm<=10) $ds=5000;
elseif ($dkm<=50) $ds=5000-(($dkm-10)*12.5);
elseif ($dkm<=200) $ds=4500-(($dkm-50)*3.33);
elseif ($dkm<=500) $ds=4000-(($dkm-200)*3.33);
elseif ($dkm<=1000) $ds=3000-(($dkm-500)*2);
elseif ($dkm<=5000) $ds=2000-(($dkm-1000)*0.25);
else $ds=max(0,1000-($dkm-5000)*0.05);
$ds=max(0,round($ds));
$_SESSION['user_guess_year']=$gy;
$_SESSION['user_guess_lat']=$glat;
$_SESSION['user_guess_lng']=$glng;
$_SESSION['year_difference']=$ydiff;
$_SESSION['distance_km']=round($dkm);
$_SESSION['year_score']=$ys;
$_SESSION['distance_score']=$ds;
$_SESSION['score']=$ys+$ds;
$_SESSION['total_score']+=$ys+$ds;
$_SESSION['rounds_played']+=1;
if (!isset($_SESSION['total_year_difference'])) $_SESSION['total_year_difference']=0;
if (!isset($_SESSION['total_distance'])) $_SESSION['total_distance']=0;
$_SESSION['total_year_difference']+=$ydiff;
$_SESSION['total_distance']+=$dkm;
require_once 'includes/db.php';
$images=Database::getInstance()->getAllImages();
$_SESSION['image_index']=($_SESSION['image_index']+1)%count($images);
header('Location: result.php');
exit;
?>
