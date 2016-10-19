<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  $oscTemplate->buildBlocks();

  if (!$oscTemplate->hasBlocks('boxes_column_left')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }

  if (!$oscTemplate->hasBlocks('boxes_column_right')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo tep_output_string_protected($oscTemplate->getTitle()); ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/superfish.js"></script> 
<script type="text/javascript" src="nivo/jquery.nivo.slider.pack.js"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="superfish.css" />
<link rel="stylesheet" type="text/css" media="screen" href="slideshow.css" />


	<script type="text/javascript" src="font/cufon-yui.js">
	</script>



	<script type="text/javascript" src="font/titallium.js">
	</script>

	<script type="text/javascript">
		Cufon.replace('.box-heading') ('.headingBoxCategories') ('h2') ('.headingBoxProductSocialBookmarks') ('.headingalsopurchased') ('.headingBoxProductNotifications') ('h1') ('.left h2') ('#footer h3')('.input.button') ('.top_text2') ('.textbtn') ('#content4 h1') ('#content2 h1') ('#content3 h1');
		Cufon.replace( { hover:true, fontFamily: 'Khmer UI' });
	</script>

<script type="text/javascript">
// fix jQuery 1.8.0 and jQuery UI 1.8.22 bug with dialog buttons; http://bugs.jqueryui.com/ticket/8484
if ( $.attrFn ) { $.attrFn.text = true; }
</script>

<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="ext/jquery/ui/i18n/jquery.ui.datepicker-<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>.js"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>

<script type="text/javascript" src="ext/jquery/bxGallery/jquery.bxGallery.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="ext/jquery/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" src="ext/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="ext/960gs/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>960_24_col.css" />
<link rel="stylesheet" type="text/css" href="stylesheet.css" />

<?php echo $oscTemplate->getBlocks('header_tags'); ?>


<script type="text/javascript">
$(function() {
var button = $('#loginButton');
var box = $('#loginBox');
var form = $('#loginForm');
button.removeAttr('href');
button.mouseup(function(login) {box.toggle();
button.toggleClass('active');});
form.mouseup(function() { return false;});
$(this).mouseup(function(login) {if(!($(login.target).parent('#loginButton').length > 0)) {button.removeClass('active');
box.hide();}});});
</script>

<!-- BOF Product Cycle Slideshow -->
<script type="text/javascript" src="ext/jquery/jquery.cycle.all.min.js"></script>
<script type="text/javascript" src="ext/jquery/jquery.easing.1.3.js"></script>


<script type="text/javascript">
	$(document).ready(function(){	

		if (!$.browser.opera) {
    
			// select element styling
			$('select.jamp').each(function(){
				var title = $(this).attr('title');
				if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
				$(this)
					.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
					.after('<span class="jamp">' + title + '</span>')
					.change(function(){
						val = $('option:selected',this).text();
						$(this).next().text(val);
						})
			});

		};
		
	});
</script>

<!-- EOF Product Cycle Slideshow -->
<?php  if ( basename($PHP_SELF) == FILENAME_DEFAULT && $cPath==null) {} else { ?>
<style>
#content{display:none;}
#header{height:180px;margin-top:232px;}
.top_header{ height:171px;}

</style>

<?php } ?>

<?php  if ( basename($PHP_SELF) == FILENAME_DEFAULT && $cPath<>null) {} else { ?>
<style>
#columnLeft{display:none;}
.contentContainer{margin-left:-35px; width:1150px;  margin-top:8px;}

.breadcrumbtop{display:none;}
#new-products-heading-text{display:none;}
#new-products-wrapper{margin-left:0px; padding-top:30px; }
#new-products{margin-left:30px; margin-right:-10px;}
</style>

<?php } ?>

</head>
<body>

<div class="top_stripe">
<div id="container_top">


		<div class="links">
        <?php echo 
		
         '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . HEADER_TITLE_HOME . '</a>' .
		 
		 
		 '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') .'">' . FOOTER_TITLE_MYACCOUNT . '</a>' .
		 
		 '<a href="' . tep_href_link(FILENAME_SHOPPING_CART) .'">' . FOOTER_TITLE_CART_CONTENTS . '</a>' .
		 
		 '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') .'">' . FOOTER_TITLE_CHECKOUT . '</a>' .
		 
		 '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . HEADER_TITLE_CONTACT_US . '</a>' ;
		 
		 ?>
		</div>

		<div class="right">
      


			<div id="welcome">

<?php echo tep_customer_greeting(); ?>

						</div>


		</div>

	</div>
 	</div>
	<div class="top_header">
	</div>



<div id="container">

		<div id="header">
			
			<div id="logo"> <?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES . 'store_logo.png', STORE_NAME) . '</a>'; ?>
			</div>

<div id="language">
<?php
 if (!isset($lng) || (isset($lng) && !is_object($lng))) {
 include(DIR_WS_CLASSES . 'language.php');
 $lng = new language;
 }
 $languages_string = '';
 reset($lng->catalog_languages);
 while (list($key, $value) = each($lng->catalog_languages)) {
 $languages_string .='<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type) . '">' . tep_image(DIR_WS_LANGUAGES . $value['directory'] . '/images/' . $value['image'], $value['name']) . '</a>&nbsp;&nbsp;';
 }
 echo $languages_string;
?>	
</div>

  <div id="currency">
<?php
    echo tep_draw_form('currencies', tep_href_link(basename($PHP_SELF), '', $request_type, false), 'get');
    reset($currencies->currencies);
    $currencies_array = array();
    while (list($key, $value) = each($currencies->currencies)) {
      $currencies_array[] = array('id' => $key, 'text' => $value['title']);
    }
    $hidden_get_variables = '';
    reset($HTTP_GET_VARS);
    while (list($key, $value) = each($HTTP_GET_VARS)) {
      if ( ($key != 'currency') && ($key != tep_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= tep_draw_hidden_field($key, $value);
      }
    }
    echo tep_draw_pull_down_menu('currency', $currencies_array, $currency, 'onChange="this.form.submit();" class="jamp"') . $hidden_get_variables . tep_hide_session_id();
    echo '</form>';
?>
  </div>

 <a href="shopping_cart.php">
			<div id="cart">
  <div class="heading">
    <h4>&nbsp;</h4>
    <span id="cart-total"><?php echo
		
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.sizeof($products = $cart->get_products()).' - Item(s) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>';
?>    
    
    </span></div>
  <div class="content">
        <div class="empty">Your shopping cart is empty!</div>
      </div>
</div>
</a>

			<div id="search">

  <?php
		echo tep_draw_form('quick_find', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get');
		echo '<div class="inputsearch">' . tep_draw_input_field('keywords', 'Search', 'onblur="if(this.value==\'\')this.value=\'Search\'"' . 'onfocus="if(this.value==\'Search\')this.value=\'\'"' . 'size="12" maxlength="30" ') . '&nbsp;' . tep_draw_hidden_field('search_in_description', '1') . tep_hide_session_id() . '</div>';
		echo '</form>';
		
  ?>
		</div>


<!--start navigation bar -->
<?php
if ( file_exists('cat_navbar.php') ) {
require('cat_navbar.php');
}
?>
<!-- end navigation bar -->






<div id="content">
	<div class="slideshow">
		<div id="slideshow0" class="nivoSlider">
			<a href="index.php?route=product/product&amp;path=57&amp;product_id=49">
			<img src="http://x4-design.eu/preview/banda/image/cache/data/samsung_banner-960x280.jpg" alt="Samsung Tab 10.1" /> </a> 
			<a href="index.php?route=product/product&amp;path=57&amp;product_id=49">
			<img src="http://x4-design.eu/preview/banda/image/cache/data/samsung_banner-960x280.jpg" alt="Samsung Tab 10.1" /> </a> 		
        </div>

	</div>

<script type="text/javascript">
	<!--
	$(document).ready(function() {
	$('#slideshow0').nivoSlider();
	});
	-->
</script>


	<div class="top_text2" >
		<div class="col1">You like this template? Buy now! Don't lose more clients!<br>
			Clean and Modern design, this is all what you need to be the Best!
        </div>
	</div>

</div>
<div class="seprator_shadow"></div>



</div>
</div>














<div id="bodyWrapper" class="container_<?php echo $oscTemplate->getGridContainerWidth(); ?>">

<?php  if ( basename($PHP_SELF) == FILENAME_DEFAULT && $cPath==null) {} else { ?>

<div id="headerWrapper">

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

</div>


<div id="bodyContainer" class="grid_<?php $oscTemplate->getGridContainerWidth(); ?> ">


<div id="bodyContent" class="grid_19 push_5">

<?php } ?>

