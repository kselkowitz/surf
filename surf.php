#!/usr/bin/php -q
<?php

// Welcome to SURF
//  SAFE UFW Rule Fixer

define("MAXFRAUDSCORE",50); // value to add to UFW
define("EMAILTO","user@domain.tld");  
define("EMAILFROM","user@domain.tld");

$headers = "From: " . EMAILFROM . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$body_details = "The following IPs are now blocked on Endpoints";
$blockcount = 0;

$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/cfg/ndp-block-list");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$safearray=json_decode(curl_exec($ch));

foreach ($safearray as $ip => $count)
{
 if ($count >= MAXFRAUDSCORE)
 {
   // ufw insert
   shell_exec("ufw insert 1 deny from " . $ip ." comment 'SAFE'");

   // clear from safe
   curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/cfg/ndp-block-allow/".$ip);
   curl_exec($ch);

    // add to email
    $body_details .= "<br>".$ip;

    $blockcount++;
 }
}

if ($blockcount>0)
{
  mail(EMAILTO,"SAFE SURF has blocked IPs", $body_details,$headers);
}


// close cURL resource
curl_close($ch);

?>
