<?php

include('includes/corefuncs.php');  
	if (function_exists('nukeMagicQuotes')){
    nukeMagicQuotes();
    }
//    include('includes/conn_mysql.inc.php');
//// create database connection
//$conn = dbConnect('query');

	// process the email
if (array_key_exists('send', $_POST)) {
  $to = 'blair.davidson@gmail.com, blair@bdwebproduction.com'; // use your own email address
  $subject = 'Enquiry from BDWebProduction';

// list expected fields
  $expected = array('name', 'email', 'comments');
  // set required fields
  $required = array('name', 'email', 'comments');
  // create empty array for any missing fields
  $missing = array();
 
 
 // assume that there is nothing suspect
  $suspect = false;
  // create a pattern to locate suspect phrases
  $pattern = '/Content-Type:|Bcc:|Cc:/i';
  // function to check for suspect phrases
  function isSuspect($val, $pattern, &$suspect) {
    // if the variable is an array, loop through each element
	// and pass it recursively back to the same function
	if (is_array($val)) {
      foreach ($val as $item) {
	    isSuspect($item, $pattern, $suspect);
	    }
	  }
    else {
      // if one of the suspect phrases is found, set Boolean to true
	  if (preg_match($pattern, $val)) {
        $suspect = true;
	    }
	  }
    }
  
  // check the $_POST array and any sub-arrays for suspect content
  isSuspect($_POST, $pattern, $suspect);
  
  if ($suspect) {
    $mailSent = false;
	unset($missing);
	}
  else { 
  // process the $_POST variables
  foreach ($_POST as $key => $value) {
  
  
    // assign to temporary variable and strip whitespace if not an array
    $temp = is_array($value) ? $value : trim($value);
	// if empty and required, add to $missing array
	if (empty($temp) && in_array($key, $required)) {
	  array_push($missing, $key);
	  }
	// otherwise, assign to a variable of the same name as $key
	elseif (in_array($key, $expected)) {
	  ${$key} = $temp;
	  }
	}
  }
 require_once('recaptchalib.php');
  $privatekey = "6LeTlLsSAAAAAExoEZypVr8XpuE3Pb8NTShMgt7F ";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    array_push($missing, 'captcha');
//die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
    //     "(reCAPTCHA said: " . $resp->error . ")");
    
  }
  
  /*else {
    // Your code here to handle a successful verification
  }*/
 
 // go ahead only if not suspect and all required fields OK
  if (!$suspect && empty($missing)) {
    // build the message
    
  
    //$headers = "From: " . strip_tags($_POST['name']) . "\r\n";
    $headers = "From: " . strip_tags($name) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($email) . "\r\n";
    //$headers .= "Reply-To: ". strip_tags($_POST['email']) . "\r\n";
    //$headers .= "CC: susan@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  
    
$message = '<html><body>';
$message .= '<p><img src="http://bdwebproduction.com/images/BDLogo.png" /> </p>';
$message .= '<h1>General Contact Message from BDWebProduction.com</h1>';
$message .= "<p>Name: $name\n\n</p>";
$message .= "<p>Email: $email\n\n</p>";
$message .= "<p>Comments: $comments</p>";
$message .= '</body></html>';

    //// limit line length to 70 characters
    //$message = wordwrap($message, 70);
    //
  
  
    // send it  
    $mailSent = mail($to, $subject, $message, $headers);
	if ($mailSent) {
	  // $missing is no longer needed if the email is sent, so unset it
	  unset($missing);
	  }
    }
  }
  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>BDWebProduction - Online Web Development Portfolio of Blair Davidson</title>    
<!--<link rel="stylesheet" type="text/css" href="./css/boxgrid.css"/>-->
<link rel="stylesheet" type="text/css" href="./css/main.css"/>
<link rel="stylesheet" type="text/css" href="./css/contact.css"/>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.1.css" media="screen" />


<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
</head>
<body>
<?php include_once("includes/analyticstracking.inc.php") ?>
<!--<div style="display: none;">-->

		<div id="enquiries" style="width:auto;overflow:auto;">
			

			
			<h3 id="contact_a">Enquiries </h3>
			  <?php
	  if ($_POST && isset($missing)  && !empty($missing)) {
		?>
		<p class="warning">Please complete the missing item(s) indicated.</p>
		<?php
		  }
		elseif ($_POST && !$mailSent) {
		?>
		  <p class="warning">Sorry, there was a problem sending your message. Please try again later.</p>
		<?php
		  }
		elseif ($_POST && $mailSent) {
		?>
		  <p><strong>Your message has been sent. Thank you for your interest.</strong></p>
		<?php } ?>
      
      
      <form id="feedback" method="post" action="#contact_a">
            <div>
                <label for="name">Name:  </label>
                <input name="name" id="name" type="text" class="formbox" 
				<?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['name']).'"';} ?>
				/>
	      <?php
				if (isset($missing) && in_array('name', $missing)) { ?>
				<p><span class="warning">Please enter your name</span></p><?php } ?>
            </div>
            <div>
                <label for="email">Email:  </label>
                <input name="email" id="email" type="text" class="formbox" 
				<?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['email']).'"';} ?>/>
	       <?php
				if (isset($missing) && in_array('email', $missing)) { ?>
				<p><span class="warning">Please enter a valid email address</span></p><?php } ?>
	    </div>
            <div>
                <label for="comments">Message:  </label>
                <textarea name="comments" id="comments" cols="60" rows="8"><?php 
				if (isset($missing)) {
				  echo htmlentities($_POST['comments']);
				  } ?></textarea>
		<?php
				if (isset($missing) && in_array('comments', $missing)) { ?>
				<p><span class="warning">Please enter your message</span></p><?php } ?>
            </div>
            
	     <div id="captcha">    
        
        <?php
        
          require_once('recaptchalib.php');
          $publickey = "6LeTlLsSAAAAAPGDcHlZXQPFfrX7YVhAC3Uj-HZX"; // you got this from the signup page
          echo recaptcha_get_html($publickey);
        ?>
</div>        
        <?php
				if (isset($missing) && in_array('captcha', $missing)) { ?>
				<p><span class="warning">The reCaptcha was entered incorrectly, please try again.</span></p><?php } ?>
        
<div>
                <br />
	    
	 <div class="send_message">
                
                <input name="send" id="send" type="submit" value="Send message"/>
            
	 </div>
        </form>
			
			
			
		</div>
	<!--</div>-->
</body>
</html>
