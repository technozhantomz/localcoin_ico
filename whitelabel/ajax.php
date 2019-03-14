<?php
if(isset($_REQUEST['AJAX']) && $_REQUEST['AJAX'] == 'Y' && !empty($_REQUEST['email'])){
  $answer = array();
  $answer['status'] = 'error';
  if(isset($_REQUEST['g-recaptcha-response']) && !empty($_REQUEST['g-recaptcha-response'])){
    $captcha = $_POST['g-recaptcha-response'];
  }else {
    $answer['messege'] = "Failed verification reCAPTCHA.";
  }
  $secretKey = "6LdX_XoUAAAAAIt-Cde_BOIoZOfcGvzzzRgUORKD  ";
  $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
  if($response['success'] == false)
  {
    $body = '
      <p><b>Name:</b> '.$_REQUEST['name'].'</p>
      <p><b>Email:</b> '.$_REQUEST['email'].'</p>
      <p><b>Your message:</b> '.$_REQUEST['message'].'</p>
      <p><b>Page:</b> '.$_REQUEST['url'].'</p>
    ';
    if(mailMessedg($_REQUEST['emailTo'], $_REQUEST['email'], 'Test message', $body)){
      $answer['status'] = 'success';
    }
  } else {
    $answer['messege'] = "Failed verification reCAPTCHA.";
  }
  echo json_encode($answer);
}

  
function mailMessedg($emailTo, $emailFrom, $title, $body){
  $message = ' 
  <html> 
      <head> 
          <title>'.$title.'</title> 
      </head> 
      <body> 
          '.$body.'
      </body> 
  </html>'; 
  
    
  $headers  = "Content-type: text/html; charset=windows-1251 \r\n"; 
  $headers .= "From: <$emailFrom>\r\n"; 
  $headers .= "Bcc: $emailFrom\r\n";  

  if(mail($emailTo, $title, $message, $headers)){
    return true;
  }
  return false;
}
?>  