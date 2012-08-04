<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<link rel="stylesheet" type="text/css" href="./css/layout.css"/>
<link rel="stylesheet" type="text/css" href="./css/main.css"/>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.1.css" media="screen" />		
<link href="css/slider2.css" rel="stylesheet" type="text/css" media="screen" />


		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
		<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.1.js"></script>

<script type="text/javascript" src="js/galleria-1.2.3.min.js"></script>

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


<meta name="keywords" content="photoshop, digital art, graphic design web design, websites, content management, ecommerce, e-commerce, web development, New Zealand, Whangarei, Northland" />
<meta name="description" content="BDWebproduction Portfolio - View examples of work by BDWebProduction including our latest websites, digital art and graphic design." />

<title>BDWebProduction - The Online Web Development Portfolio of Blair Davidson - Photoshop, Graphic Design, Digital Art</title>
</head>
<body>
<?php include_once("includes/analyticstracking.inc.php") ?>
<div id="background">
<div id="wrapper">
		
<?php include('includes/header.inc.php'); ?>   

<div id="content" class="container_12">
		<div id="main_content" class="cleft">
<h1>Graphic Design &amp; Digital Art Portfolio</h1>
<div id="galleria_border">
        <div id="galleria">
            
            <img title="Dylan Davidson &amp; Carly Gmeiner Engagement Day"
            	     alt="Combination of Engagement day photographs from Aspen Highlands Bowl.  Printed and framed as a 30th Birthday gift.  Colorado, 2011." 
            	     src="images/CBday.jpg" />
            
            <img title="Wanaka Meets Colorado Part 1"
            	     alt="Landscape photograph of Wanaka in New Zealand combined with a snowboard photograph in Steamboat Springs, Colorado.  Printed and Block Mounted as a 30th Birthday gift.  Colorado, 2010." 
            	     src="images/DP1.jpg" />
        	
            <img title="Wanaka Meets Colorado Part 2"
                     alt="Landscape photograph of Wanaka in New Zealand combined with a snowboard photograph in Steamboat Springs, Colorado.  Printed and Block Mounted as a 30th Birthday gift.  Colorado, 2010."
                     src="images/DP2.jpg" />
            
            <img title="Untitled"
                     alt="Commisioned collage of running photograph's.  Printed and framed as a farewell gift.  Sydney, 2009"
                     src="images/Ben_Running.jpg" />
            
            <img title="Snowboard Business Card"
                     alt="Both sides of a personal business card - Snowboard Instructing during the 2010/11 Colorado season."
                     src="images/BD_card.jpg" />
            
            </div>


</div>
<div id="Nav">
		<ul>
				<li><a href="portfolio.php" class="webNav">Web</a></li>
		<li><a href="images.php" class="imageNav this">Leaf</a></li>
		</ul>
		
		</div>
		


<script type="text/javascript">

    // Load the classic theme
    Galleria.loadTheme('galleria.classic.js');
    
    // Initialize Galleria
    $('#galleria').galleria();

    </script>

</div>
<?php include('includes/about.inc.php'); ?>  


</div>

                
</div>

 <?php include('includes/footer.inc.php'); ?>  


            
</body>
</html>
