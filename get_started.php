<?php
$package_type = $_GET['pt'];
$package_name = "none";
$package_link = "none";
if ($package_type == "starter"){
    $package_name = "Starter Website Package";
    $package_link = "starter_website.php";
}
else if ($package_type == "cms"){
    $package_name = "Content Management System Package";
    $package_link = "cms_website.php";
}
else if ($package_type == "ecommerce"){
    $package_name = "Ecommerce Package";
    $package_link = "ecommerce_website.php";
}




include('includes/corefuncs.php');  
	if (function_exists('nukeMagicQuotes')){
    nukeMagicQuotes();
    }
//    include('includes/conn_mysql.inc.php');
//// create database connection
//$conn = dbConnect('query');

	// process the email
if (array_key_exists('submit_web_form', $_POST)) {
  $to = 'blair.davidson@gmail.com, blair@bdwebproduction.com'; // use your own email address
  $subject = 'Customer Website Enquiry from BDWebProduction';

// list expected fields
  $expected = array('name', 'country', 'email', 'phone', 'skype_name', 'website_name', 'domain_req', 'domain_name', 'website_purpose', 'num_pages', 'content_type', 'additional_features','other_add_features','email_addresses','add_web_info', 'num_users', 'product_types','shipping_options','tax_options','payment_options');
  // set required fields
  if ($package_type == "starter" || $package_type == "cms"){
    $required = array('name', 'country', 'email','website_name', 'domain_name','website_purpose');
  }
  if ($package_type == "ecommerce"){
    $required = array('name', 'country', 'email','website_name', 'domain_name','website_purpose', 'product_types');
  }
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
 
 $additional_features = isset($additional_features) ? $additional_features : array('');
 $additional_features = implode(', ', $additional_features);         
 
 // go ahead only if not suspect and all required fields OK
  if (!$suspect && empty($missing)) {
    // build the message
    
  
    $headers = "From: " . strip_tags($_POST['name']) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($_POST['email']) . "\r\n";
    //$headers .= "CC: susan@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  
    
$message = '<html><body>';
$message .= '<p><img src="http://bdwebproduction.com/images/BDLogo.png" /> </p>';
$message .= '<h1>Customer Website Enquiry from BDWebProduction.com</h1>';

$message .= "<h2>Contact Details\n\n</h2>";
$message .= "<p>Name: $name\n\n</p>";
$message .= "<p>Country: $country\n\n</p>";
$message .= "<p>Email: $email\n\n</p>";
$message .= "<p>Phone Number: $phone</p>";
$message .= "<p>Skype Name: $skype_name\n\n</p>";

$message .= "<h2>Website Details\n\n</h2>";
$message .= "<p>Package Type: $package_name\n\n</p>";
$message .= "<p>Website Name: $website_name\n\n</p>";
$message .= "<p>Domain Required: $domain_req\n\n</p>";
$message .= "<p>Domain Name: $domain_name\n\n</p>";
$message .= "<p>Website Purpose: $website_purpose\n\n</p>";
$message .= "<p>Number of Pages: $num_pages\n\n</p>";
$message .= "<p>Type of Content: $content_type\n\n</p>";
$message .= "<p>Additional Features: $additional_features\n\n</p>";
$message .= "<p>Other Additional Features: $other_add_features\n\n</p>";
$message .= "<p>Desired email addresses with website: $email_addresses\n\n</p>";
$message .= "<p>Additional Website Information: $add_web_info\n\n</p>";

if ($package_type == "cms" || $package_type == "ecommerce"){
$message .= "<h2>CMS\n\n</h2>";
$message .= "<p>Number of Users: $num_users\n\n</p>";
}

if ($package_type == "ecommerce"){
$message .= "<h2>Ecommerce\n\n</h2>";
$message .= "<p>Types of Products: $product_types\n\n</p>";
$message .= "<p>Shipping Options: $shipping_options\n\n</p>";
$message .= "<p>Tax Options: $tax_options\n\n</p>";
$message .= "<p>Payment Options: $payment_options\n\n</p>";
$message .= '</body></html>';
}
// list expected fields
  $expected = array('name', 'country', 'email', 'phone', 'skype_name', 'website_name', 'domain_req', 'domain_name', 'website_purpose', 'num_pages', 'content_type', 'additional_features','other_add_features','add_web_info', 'num_users', 'product_types','shipping_options','tax_options','payment_options');



    //// limit line length to 70 characters
    //$message = wordwrap($message, 70);
    //
  
  //print($message);
    // send it  
    $mailSent = mail($to, $subject, $message, $headers);
	if ($mailSent) {
	  // $missing is no longer needed if the email is sent, so unset it
	  unset($missing);
	  }


    }
  }



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<link rel="stylesheet" type="text/css" href="./css/layout.css"/>
<link rel="stylesheet" type="text/css" href="./css/main.css"/>
<link rel="stylesheet" type="text/css" href="./css/productpage.css"/>
<link rel="stylesheet" type="text/css" href="./css/contact.css"/>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.1.css" media="screen" />		
<link href="css/slider2.css" rel="stylesheet" type="text/css" media="screen" />
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
		<!--<script type="text/javascript" src="./js/slider.js"></script>-->
		<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.1.js"></script>

<script type="text/javascript" src="js/easySlider1.5.js"></script>

<script type="text/javascript">
		$(document).ready(function() {
			
$("#various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic'
			});

$("#various2").fancybox({
				'width'				: '50%',
				'height'			: '80%',
				'autoScale'			: false,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

$("#various3").fancybox({
				'width'				: '50%',
				'height'			: '80%',
				'autoScale'			: false,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});




		});
</script>


<title>BDWebProduction - Personal and Small Business Web Design and Development Solutions - Get Started with the <?php print($package_name); ?></title>
</head>
<body>
<?php include_once("includes/analyticstracking.inc.php") ?>
<div id="background">
<div id="wrapper">

<?php include('includes/header.inc.php'); ?>                

<div id="content" class="container_12">
<div id="main_content" class="cleft">
<div id="breadcrumbs">
    <p><a href="web_design.php">Web Design &amp; Development Solutions</a> >> <a href="<?php print($package_link); ?>"><?php print($package_name); ?></a> >> Get Started</p>
</div>
<h1>Web Design &amp; Development Solutions - <?php print($package_name); ?></h1>

<?php
	  if ($_POST && isset($missing)  && !empty($missing)) {
		?>
		<p><span class="warning">Please complete the missing item(s) indicated.</span></p>
		<?php
		  }
		elseif ($_POST && !$mailSent) {
		?><div class="message_status">
		  <p><span class="warning">Sorry, there was a problem sending your message. Please try again later.</span></p>
                  </div>
		<?php
		  }
		elseif ($_POST && $mailSent) {
		?>
                <div class="message_status">
		  <p><strong>Your Message has been sent - congratulations on taking the first step toward your new website with BDWebProduction! <br />
                  We will review your information and get back to you ASAP.  <br /><br />Thank you,<br /> <br />
                  The team at BDWebProduction</strong></p>
                  </div>
		<?php } 

if (!$_POST || $_POST&& isset($missing)  && !empty($missing)) {?>

<p>To allow us to contact you, as well as get a better idea of the requirements for your website, please fill in the following information.</p>
<p>* shows a required field</p>

<form class="Website_form" id="form1" name="form1" method="post" action="">

<h2>Personal & Contact Details</h2>
	      <div>
	        <p>
                <label for="name"><strong>Name:</strong></label>
	        <input name="name" type="text" class="widebox" id="name"
                <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['name']).'"';} ?>
				/>*
	      <?php
				if (isset($missing) && in_array('name', $missing)) { ?>
				<span class="warning">Please Enter Your Name</span><?php } ?>
            
                
                </p>
	      </div>
              <div>
	        <p>
                    <label for="country"><strong>Country:</strong></label>
	        <input name="country" type="text" class="widebox" id="country"
                <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['country']).'"';} ?>
				/>*
	      <?php
				if (isset($missing) && in_array('country', $missing)) { ?>
				<span class="warning">Please Enter Your Country</span><?php } ?>
            
   
                </p>
	      </div>
              <div>
                <p>
	        <label for="email"><strong>Email:</strong></label>
	        <input name="email" type="text" class="widebox" id="email"
                       <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['email']).'"';} ?>
				/>*
	      <?php
				if (isset($missing) && in_array('email', $missing)) { ?>
				<span class="warning">Please Enter A Valid Email Address</span><?php } ?>
            
   
                </p>
	      </div>
              <div>
                <p>
	        <label for="phone"><strong>Phone Number:</strong></label>
	        <input name="phone" type="text" class="widebox" id="phone"
                <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['phone']).'"';} ?>
				/>
                </p>
	      </div>
              <div>
                <p>
	        <label for="skype_name"><strong>Skype Name:</strong></label>
	        <input name="skype_name" type="text" class="widebox" id="skype_name"
                <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['skype_name']).'"';} ?>
				/>
                </p>
	      </div>
<!--Company -->
<!--*Country-->
<!--*Email -->
<!--Phone Number-->
<!--Skype Name-->
<div>
<h2>Website Information and Concept</h2>

            <div>
                <p>
	        <label for="website_name"><strong>Website Name:</strong></label>
	        <input name="website_name" type="text" class="widebox" id="website_name"
                <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['website_name']).'"';} ?>
				/>*
	      <?php
				if (isset($missing) && in_array('website_name', $missing)) { ?>
				<span class="warning">Please Enter The Name Of Your Website Or Business</span><?php } ?>
            
                </p>
	      </div>
              
              <div>
                
                <fieldset id="domain_req">
              <p>
              <label for="domain_req"><strong>Domain Name Required:</strong></label>
              <!--<strong><span>Domain Name Required:</span></strong>-->
	      <input name="domain_req" type="radio" value="Yes" id="domain_req_yes"
                        <?php
                        $OK = isset($_POST['domain_req']) ? true : false;
                        ?>
                        checked="checked"
                        />
                                <label for="domain_req_yes">Yes</label>
                
                <input name="domain_req" type="radio" value="No" id="domain_req_no"
                        <?php
                        if ($OK && isset($missing) && $_POST['domain_req'] =='No'){ ?>
                        checked="checked"<?php } ?>
                        />
                                <label for="domain_req_no">No</label>
                 </p>               
              </fieldset>
                
                </div>

              <div>
                <p>
	        <label for="domain_name"><strong>Current or Desired Domain Name:</strong></label>
	        <input name="domain_name" type="text" class="widebox" id="domain_name"
                <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['domain_name']).'"';} ?>
				/>* for example: www.bdwebproduction.com
	      <?php
				if (isset($missing) && in_array('domain_name', $missing)) { ?>
				<span class="warning">Please Enter The Domain Name Of Your Website</span><?php } ?>
            
                </p>
	      </div>
              <div>
                <p>
	        <label for="website_purpose"><strong>Purpose of Website:</strong></label>
	        <textarea name="website_purpose" type="text" class="widebox" id="website_purpose" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['website_purpose']);} ?></textarea>*
                
	      <?php
				if (isset($missing) && in_array('website_purpose', $missing)) { ?>
				<br /><span class="warning">Please Enter The Main Purpose Of Your Website</span><?php } ?>
            
            
                </p>
	      </div>
              <div>
                <p>
	        <label for="num_pages"><strong>Approx Number of Pages:</strong></label>
	        <input name="num_pages" type="text" class="widebox" id="num_pages"
                       <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['num_pages']).'"';} ?>
				/>
                </p>
	      </div>

            <div>
                <p>
	        <label for="content_type"><strong>Type of Content your website will display:</strong></label>
	        <textarea name="content_type" type="text" class="widebox" id="content_type" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['content_type']);} ?></textarea>
                </p>
	      </div>
            
            
            
            <div>
            
            
              
                <fieldset id="additional_features">
                    <p>
                <label><strong>Additional <br />Features:</strong></label>
                
	    
	          <input type="checkbox" name="additional_features[]" value="gallery" id="gallery" 
				<?php
				$OK = isset($_POST['additional_features']) ? true : false;
                                if ($OK && isset($missing) && in_array('gallery', $_POST['additional_features'])) { ?>
				checked="checked"
				<?php } ?>
		    />
		    <label for="gallery">Image Gallery</label>
		  
		    
		  
		    <input type="checkbox" name="additional_features[]" value="blog" id="blog" 
				<?php
				if ($OK && isset($missing) && in_array('blog', $_POST['additional_features'])) { ?>
				checked="checked"
				<?php }
                                ?>
              			
                    />
		    <label for="blog">Latest News / Blog</label>
		  
		  
		  
		</p>  
		</fieldset>
              </div>
            






<div>
    <p>
	        <label for="other_add_features"><strong>Other Additional Features:</strong></label>
	        <textarea name="other_add_features" type="text" class="widebox" id="other_add_features" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['other_add_features']);} ?></textarea>
                </p>
	      </div>

<div>
    <p>
	        <label for="email_addresses"><strong>Desired email addresses with website:</strong></label>
	        <textarea name="email_addresses" type="text" class="widebox" id="email_addresses" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['email_addresses']);} ?></textarea>
                </p>
	      </div>

<div>
        <p>
	        <label for="add_web_info"><strong>Anything else you'd like to tell us about your website:</strong></label>
	        <textarea name="add_web_info" type="text" class="widebox" id="add_web_info" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['add_web_info']);} ?></textarea>
                </p>
	      </div>

</div>    
<!--Website Information and Concept-->
<!--*Website Name -->
<!--*Domain Name Required Y / N-->
<!--*Current or Desired Domain Name-->
<!--*Purpose of Website-->
<!--Number of Pages-->
<!--Type of content website will display.-->
<!--Additional Features - Gallery, Latest News / Blog-->
<!--Other Additional Features:-->
<!--Anything else you'd like to tell us about your website-->
<?php if($package_type == "cms" || $package_type == "ecommerce"){?>

<h2>Content Management</h2>

<div>
        <p>
	        <label for="num_users"><strong>Number of Users / Content Administrators:</strong></label>
	        <input name="num_users" type="text" class="widebox" id="num_users"
                <?php if (isset($missing)) {
				  echo 'value="'.htmlentities($_POST['num_users']).'"';} ?>
				/>
                </p>
	      </div>
<!--Content Management-->
<!--Number of Users / Content Administrators-->


    
<?php }

if($package_type == "ecommerce"){?>
<div>
<h2>Ecommerce</h2>
<div>
        <p>
	        <label for="product_types"><strong>Type of Products you'll be selling online:</strong></label>
	        <textarea name="product_types" type="text" class="widebox" id="product_types" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['product_types']);} ?></textarea>*
                
	      <?php
				if (isset($missing) && in_array('product_types', $missing)) { ?>
				<br /><span class="warning">Please Enter The Type Of Products / Services You'll Be Selling Online</span><?php } ?>
            
                </p>
	      </div>
<div>
        <p>

	        <label for="shipping_options"><strong>Shipping Option Information:</strong></label>
	        <textarea name="shipping_options" type="text" class="widebox" id="shipping_options" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['shipping_options']);} ?></textarea>
                </p>
	      </div>
<div>
        <p>
	        <label for="tax_options"><strong>Tax Option Information:</strong></label>
	        <textarea name="tax_options" type="text" class="widebox" id="tax_options" cols="60" rows="3"><?php if (isset($missing)) {
				  echo htmlentities($_POST['tax_options']);} ?></textarea>
                    </p>
	      </div>
<div>
    <p>
	        <label for="payment_options"><strong>Your Website Payment Option Information:</strong></label>
	        <textarea name="payment_options" type="text" class="widebox" id="payment_options" cols="60" rows="3"><?php if (isset($missing)) { echo htmlentities($_POST['payment_options']);}?></textarea>
                </p>
	      </div>
</div>
<!--Ecommerce-->
<!--Type of Products-->
<!--Shipping Options-->
<!--Tax Options-->
<!--Payment Options:    Credit Card through Paypal, Credit Card through DPS, Customer Pickup, Cheque or Bank Transfer-->
<?php } ?>



<div>
    <p>
		<input class="submit" type="submit" name="submit_web_form" value="Submit" />
		<input name="package_type" type="hidden" value ="<?php echo $package_type; ?>"/> 
	        </p>
    </div>
    </form>
<?php } ?>
		</div>
	      
<!--</div>-->
<?php include('includes/about.inc.php'); ?>  



</div>

                
</div>

 <?php include('includes/footer.inc.php'); ?>  


            
</body>
</html>
