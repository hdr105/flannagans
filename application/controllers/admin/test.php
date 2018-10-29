<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends Admin_Controller {
  function send_mailgun(){
 $email=$_GET['email'];
    $config = array();
 
    $config['api_key'] = "key-e6fdfc933522a5c93c6780a395bcf107";
 
    $config['api_url'] = "https://api.mailgun.net/v3/wm.flannagans.co.uk";
 
    $message = array();
 
    $message['from'] = "Flannagans<info@wm.flannagans.co.uk>";
 
    $message['to'] = $email;
 
    $message['h:Reply-To'] = "info@flannagans.co.uk";
 
    $message['subject'] = "Eye-Catching Subject Line";
 
    $message['html'] = "</<!DOCTYPE html>
    <html>
    <head>
        <title></title>
    </head>
    <body>
    hi
    </body>
    </html>";
 
  $ch = curl_init();
  $plain = strip_tags(nl2br($message['html']));
 
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$config['api_key']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/wm.flannagans.co.uk/messages');
  curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'support@flannagans.co.uk',
        'to' => $message['to'],
        'subject' => $message['subject'],
        'h:Reply-To' => $message['h:Reply-To'],
        'html' => $message['html'],
        'text' => $plain));

  $j = curl_exec($ch);
  $info = curl_getinfo($ch);

  if($info['http_code'] != 200)
        error("Fel 313: Vänligen meddela detta via E-post till support@".DOMAIN);

  curl_close($ch);

  return $info;
  
}
}