<?php 
// echo date ( 'Y-m-d',strtotime ( '+1 years' , strtotime ( '2016-04-20' ) ) ) 
// echo getcwd();
///////////////////////////////////

$cont = unserialize('a:17:{s:11:"setting_key";s:40:"dfe2db74975e0aa9f6fdd4d61dedcb7328502456";s:13:"email_address";s:21:"info@flannagans.co.uk";s:13:"default_group";s:1:"3";s:20:"disable_registration";s:1:"0";s:22:"disable_reset_password";s:1:"0";s:24:"require_email_activation";s:1:"1";s:16:"default_language";s:5:"en_US";s:16:"enable_recaptcha";s:1:"1";s:20:"recaptcha_public_key";s:40:"6Le4CtUSAAAAAC-Cnbu_d6eshhyDyY_H1OB2cI11";s:21:"recaptcha_private_key";s:40:"6Le4CtUSAAAAAJOySWsjT1NAKtfdqJyCKomyzoKx";s:11:"enable_smtp";i:1;s:9:"smtp_host";s:20:"secure.emailsrvr.com";s:9:"smtp_port";i:465;s:9:"smtp_auth";s:3:"ssl";s:16:"enable_smtp_auth";i:1;s:12:"smtp_account";s:24:"noreply@flannagans.co.uk";s:13:"smtp_password";s:9:"F!@nn@g@n";}');
echo "<pre>";print_r($cont);
    $cont['smtp_host'] = 'smtp.mailgun.org';
    $cont['smtp_account'] = 'postmaster@wm.flannagans.co.uk';
    $cont['smtp_password'] = '7645205954dbd1e12164796c204ff340';
echo $cont = serialize($cont);


//////////////////////////////
/*$cont = unserialize('a:5:{s:11:"setting_key";s:40:"f0347ce3a03a3ba71f596438a2b80dd21c9af71b";s:17:"send_link_subject";s:29:"[Flannagans] Activate Account";s:14:"send_link_body";s:155:""Welcome {user_name},\nYou must activate your account via this message to log in.\n\nClick the following link to do so: \n{activation_link}\n\nThanks.\n\n"";s:17:"activated_subject";s:45:"[Flannagans] You have activated your account!";s:14:"activated_body";s:166:""Hi there {user_name} !\nYour account at {site_address} has been successfully activated :)\n.For your reference, your user email is  {user_email}.\nSee you soon!\n\n"";}');
//echo "<pre>";print_r($cont);
    $cont['send_link_subject'] = '[Flannagans] Activate Account';
    $cont['send_link_body'] = 'Welcome {user_name},<br>You must activate your account via this message to log in.<br><br>Click the following link to do so: <br>{activation_link}<br><br>Thanks.<br><br>';
    $cont['activated_subject'] = '[Flannagans] You have activated your account!';
    $cont['activated_body'] = 'Hi there {user_name}!<br><br>Your account at {site_address} has been successfully activated :)<br>.For your reference, your user email is  {user_email}.<br><br>See you soon!<br><br>';

echo $cont = serialize($cont);*/
//////////////////////////////

//////////////////////////////
/*$cont = unserialize('a:5:{s:11:"setting_key";s:40:"868a882a74b3f7f4cc49d8914e144ef07b3ea9d5";s:15:"request_subject";s:32:"[Flannagans] Lost your password?";s:12:"request_body";s:171:"Hi {user_name},\nYour user email is {user_email}.\nTo reset your password at AuthAcl, please click the following password reset link: \n\n{reset_link}\n\nSee you soon!\n\n";s:15:"success_subject";s:42:"[Flannagans] Your password has been reset.";s:12:"success_body";s:195:"Welcome back {user_name},\nI am just letting you know your password at {site_address} has been successfully changed.\nHopefully you were the one that requested this password reset !\n\nCheers\n\n";}');
//echo "<pre>";print_r($cont);
    $cont['request_subject'] = '[Flannagans] Lost your password?';
    $cont['request_body'] = 'Hi {user_name},<br>Your user email is {user_email}.<br>To reset your password at AuthAcl, please click the following password reset link: <br><br>{reset_link}<br><br>See you soon!<br><br>';
    $cont['success_subject'] = '[Flannagans] Your password has been reset.';
    $cont['success_body'] = 'Welcome back {user_name},<br>I am just letting you know your password at {site_address} has been successfully changed.<br>Hopefully you were the one that requested this password reset !<br><br>Cheers<br><br>';

echo $cont = serialize($cont);*/
//////////////////////////////
/*set_time_limit(0);  // run foorreeveeerr
for ($i=0; $i<1000; $i++){
    echo str_pad(round(microtime(1)-$start), 4096);
    flush();
    sleep(1);
    set_time_limit(0); // if PHP_CLI SAPI and having error messages
}
echo "completed";*/

/*function send_mailgun($email){
 
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
  $plain = strip_tags(nl2br($message));
 
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
$json = send_mailgun('smak.group@gmail.com');
print_r($json);
//{ "id": "<20160805145802.130636.36227.BDE1E0E4@wm.flannagans.co.uk>", "message": "Queued. Thank you." }
*/
?>