<div id="footer_container">
    

<div id="bottom_nav">
            <ul>
				<!--<li><a href="index.php"><span>Home</span></a></li>-->
				<li><a href="web_design.php"><span>Website Solutions</span></a>
                                    <ul>
                                    <li><a href="starter_website.php"><span>Starter Website Package</span></a></li>
                                    <li><a href="cms_website.php"><span>CMS Package</span></a></li>
                                    <li><a href="ecommerce_website.php"><span>Ecommerce Package</span></a></li>
                                    </ul>
                                </li>
				<li><a href="portfolio.php"><span>Portfolio</span></a>
                                    <ul>
                                    <li><a href="portfolio.php"><span>Web Portfolio</span></a></li>
                                    <li><a href="images.php"><span>Image / Graphic Design Portfolio</span></a></li>
                                    </ul>
                                </li>
				<li><a href="about.php"><span>About</span></a></li>
				<li><a id="various3" href="contact.php?iframe"><span>Contact Us</span></a></li>
                                <li><a href="index.php"><span>Home</span></a></li>
	</ul>
        
    </div>

<div id="footer" class="container 12">
    
    <p>Copyright &copy;
    <?php
    ini_set('date.timezone','Europe/London');
    $startYear = 2010;
    $thisYear = date('Y');
    if ($startYear == $thisYear) {
        echo $startYear;
        }
        else {
            echo "{$startYear}-{$thisYear}";
        }
    ?>
    Blair Davidson</p>
      </div>

</div>