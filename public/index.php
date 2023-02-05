<?php

session_start();

require "../app/core/init.php";

$url = $_GET['url'] ?? 'home';
$url = strtolower($url);
$url = explode("/", $url);

$page_name = trim($url[0]);
$filename = "../app/pages/" . $page_name . ".php";

// Set Page Pagination vars

$page_number = $GET['page'] ?? 1;
$page_number = empty($page_number) ? 1 : (int)$page_number;

$current_link = $_GET['url'] ?? 'home';
$current_link = ROOT . "/" . $current_link;
$query_string = "";

foreach($_GET as $key => $value){
        if($key != 'url')
        $current_link .= '&' .$key. "=" .$value;
}

$query_string = trim($query_string, "&");
if(strstr($query_string, "page=")){
        $query_string .= "&" .$key."=".$value;
}
echo $current_link;die;


if (file_exists($filename)) {
        require_once $filename;
} else {
        require_once "../app/pages/404.php";
}
   

// echo "<pre>";
// echo $filename;
// print_r($url);

// echo "u gae";
