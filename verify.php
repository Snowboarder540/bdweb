 <?php
  require_once('recaptchalib.php');
  $privatekey = "6LeTlLsSAAAAAExoEZypVr8XpuE3Pb8NTShMgt7F";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVERREMOTE_ADDR,
                                $_POSTrecaptcha_challenge_field,
                                $_POSTrecaptcha_response_field);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } else {
    header('Location: contact.php#contact_a');// Your code here to handle a successful verification
  }
  ?>