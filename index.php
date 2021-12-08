<?php

if ( file_exists( 'vendor/autoload.php' ) ) {
    require 'vendor/autoload.php';
}
$time_start = microtime(true);

use App\Services\Posts;
$postObj = new Posts();
if(isset($_GET['method']) && !empty($_GET['method']) && method_exists('App\Services\Posts',$_GET['method'])){
    $methodName = $_GET['method'];
    echo '<pre>';
    var_dump($postObj->$methodName());
}

echo '<br /> Total execution time in seconds: ' . (microtime(true) - $time_start);