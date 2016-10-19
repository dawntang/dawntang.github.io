<?php


  require(DIR_WS_INCLUDES . 'counter.php');
?></div>


<div id="footer_big">
<div id="footer">
<div class="col">
    <h3>About Us</h3>
	 <img class="zdjecie frame" src="image/av.jpg" alt="" />
Niave, maiores consequatur esse harum minim omnis, et nihil mollitia harum eligendi voluptates mollit sint voluptas rerum quibusdam corrupti blanditiis in quo sudo ea dolorum in et facilis occaecat minim alias culpa aliquip dolor optio alias magna cumque hic nihil labore optio.<br>
<br>
 Culpa voluptas saepe sunt et asperiores eos mollit proident, et, libero omnis et saepe rerum enim et aut in et, ntsu vero mollit in anim rerum aute minim ut repellat esse dolor est doloribus aut.
  </div>


   <div class="column">
   <?php echo 
    '<h3>' . FOOTER_TITLE_HEADING_LINKS . '</h3>' .
			'<ul>' .
				'<a href="' . tep_href_link(FILENAME_DEFAULT) .'"><li>' . FOOTER_TITLE_HOME . '</li></a>' .
				'<a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) .'"><li>' . FOOTER_TITLE_ADVANCED_SEARCH . '</li></a>' .
				'<a href="' . tep_href_link(FILENAME_CONTACT_US) .'"><li>' . FOOTER_TITLE_CONTACT_US . '</li></a>' .
				
				
			'</ul>';
		?>
  </div>


   <div class="column">
   <?php echo 
    '<h3>' . FOOTER_TITLE_HEADING_INFORMATION  . '</h3>' .
			'<ul>' .
				'<a href="' . tep_href_link(FILENAME_PRIVACY) .'"><li>' . FOOTER_TITLE_PRIVACY_NOTICE . '</li></a>' .
				'<a href="' . tep_href_link(FILENAME_CONDITIONS) .'"><li>' . FOOTER_TITLE_CONDITIONS_OF_USE . '</li></a>' .
				'<a href="' . tep_href_link(FILENAME_SHIPPING) .'"><li>' . FOOTER_TITLE_SHIPPING_AND_RETURNS . '</li></a>' .
				
				
			'</ul>';
		?>
  </div>

   <div class="column">
   <?php echo 
    '<h3>' . FOOTER_TITLE_HEADING_MYACCOUNT . '</h3>' .
			'<ul>' .
				'<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') .'"><li>' . FOOTER_TITLE_MYACCOUNT . '</li></a>' .
				'<a href="' . tep_href_link(FILENAME_SHOPPING_CART) .'"><li>' . FOOTER_TITLE_CART_CONTENTS . '</li></a>' .
				'<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') .'"><li>' . FOOTER_TITLE_CHECKOUT . '</li></a>' .
		
				
			'</ul>';
		?>
  </div>

<div class="column2">
    <h3>Payment Options</h3>
<img src="image/payment.png" alt=""><br><br>

<h3>Follow Us</h3>
			<div class="social_icons">
			<a href="#"><img class="tra" src="image/social/facebook.png" alt="" /> </a>
			<a href="#"><img class="tra" src="image/social/google.png" alt="" /> </a>
			<a href="#"><img class="tra" src="image/social/twitter.png" alt="" /> </a>
			<a href="#"><img class="tra" src="image/social/linked.png" alt="" /> </a>
			<a href="#"><img class="tra" src="image/social/rss.png" alt="" /> </a>


			</div>

</div>

</div>
</div>

<div id="powered"><?php echo FOOTER_TEXT_BODY; ?></div>

</div>




<script type="text/javascript">
$('.productListTable tr:nth-child(even)').addClass('alt');
</script>
