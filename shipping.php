<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHIPPING);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHIPPING));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
</div></div>
<style>
#columnLeft{display:none;}
</style>
<div class="breadcrumb"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail('&raquo;'); ?></div>
<h1 class="headingshipping"><?php echo HEADING_TITLE; ?></h1>

<div id="shippingContainer" class="contentContainer2">
	<div class="contentText">
		<?php echo TEXT_INFORMATION; ?>
	</div>

	<div class="buttonSet">
		<span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?></span>
	</div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
