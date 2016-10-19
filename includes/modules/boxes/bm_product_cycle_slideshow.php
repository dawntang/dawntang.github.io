<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_product_cycle_slideshow {
    var $code = 'bm_product_cycle_slideshow';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
	

    function bm_product_cycle_slideshow() {
      $this->title = MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_TITLE;
      $this->description = MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_DESCRIPTION;

      if ( defined('MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_STATUS') ) {
        $this->sort_order = MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_STATUS == 'True');

        $this->group = ((MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $currencies, $oscTemplate, $language_id;
	  
	  /*Pick news*/
	  $new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, s.specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.products_status = '1' order by p.products_date_added desc limit " . PCS_MAX_DISPLAY_NEW_PRODUCTS);
	  
	  while ($new_product = tep_db_fetch_array($new_products_query)) {
		  $new_product['products_name'] = tep_get_products_name($new_product['products_id']);
		  if ($new_product['specials_new_products_price'] == NULL){
			  $new_products.= '<div class="PCSChild" title="' .  htmlspecialchars(html_entity_decode('<a class="textBoxSlideshowLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_product['products_id']) . '"><b>' . BOX_HEADING_WHATS_NEW . '</b><br />' . $new_product['products_name'] . '<br />' . $currencies->display_price($new_product['products_price'], tep_get_tax_rate($new_product['products_tax_class_id'])) . '</a>'))  . '"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_product['products_image'], addslashes($new_product['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
		  }
		  else {
			  $new_products.= '<div class="PCSChild" title="' .  htmlspecialchars(html_entity_decode('<a class="textBoxSlideshowLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_product['products_id']) . '"><b>' . BOX_HEADING_WHATS_NEW . '</b><br />' . $new_product['products_name'] . '<br /><del><span id="price-text-boxContents">' . $currencies->display_price($new_product['products_price'], tep_get_tax_rate($new_product['products_tax_class_id'])) . '</span></del> <span class="productSpecialPrice">' . $currencies->display_price($new_product['specials_new_products_price'], tep_get_tax_rate($new_product['products_tax_class_id'])) . '</span></a>'))  . '"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_product['products_image'], addslashes($new_product['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
		  }
	  }
	  
	  /*Pick featured*/
	  if(defined('TABLE_FEATURED')) {
		  $featured_query = 'SELECT distinct p.products_id, p.products_image, p.products_tax_class_id, s.specials_new_products_price, p.products_price
		 FROM ' . TABLE_PRODUCTS . ' p LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c using(products_id)
		 LEFT JOIN ' . TABLE_CATEGORIES . ' c USING (categories_id)
		 LEFT JOIN ' . TABLE_FEATURED . ' f ON p.products_id = f.products_id
		 LEFT JOIN ' . TABLE_SPECIALS . ' s ON p.products_id = s.products_id 
		 where p.products_status = \'1\' AND f.status = \'1\'';
		 
		 if ( defined('FEATURED_PRODUCTS_SPECIALS_ONLY') AND FEATURED_PRODUCTS_SPECIALS_ONLY == 'true' ) {
			 $featured_query .= " AND s.status = '1' ";
		 }
		 $featured_query .= 'ORDER BY rand(' . rand() . ') DESC LIMIT ' . PCS_MAX_DISPLAY_FEATURED_PRODUCTS;
		 
		 $featured_products_query = tep_db_query($featured_query);
		 
		 while ($featured_product = tep_db_fetch_array($featured_products_query)) {
			 $featured_product['products_name'] = tep_get_products_name($featured_product['products_id']);
			 if ($featured_product['specials_new_products_price'] == NULL){
				 $featured_products.= '<div class="PCSChild" title="' .  htmlspecialchars(html_entity_decode('<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_product['products_id']) . '"><b>' . BOX_HEADING_FEATURED_PRODUCTS . '</b><br />' . $featured_product['products_name'] . '<br>' . $currencies->display_price($featured_product['products_price'], tep_get_tax_rate($featured_product['products_tax_class_id'])) . '</a>')) . '"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $featured_product['products_image'], addslashes($featured_product['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
			 }
			 else {
				 $featured_products.= '<div class="PCSChild" title="' .  htmlspecialchars(html_entity_decode('<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_product['products_id']) . '"><b>' . BOX_HEADING_FEATURED_PRODUCTS . '</b><br />' . $featured_product['products_name'] . '<br><del><span id="price-text-boxContents">' . $currencies->display_price($featured_product['products_price'], tep_get_tax_rate($featured_product['products_tax_class_id'])) . '</span></del> <span class="productSpecialPrice">' . $currencies->display_price($featured_product['specials_new_products_price'], tep_get_tax_rate($featured_product['products_tax_class_id'])) . '</span></a>')) . '"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $featured_product['products_image'], addslashes($featured_product['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
			}
		 }
	  }
	  else {
		  $featured_products = '';
	  }
	 
	 /*Pick specials*/
	 $special_products_query = tep_db_query("select p.products_id, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " .  TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = s.products_id and s.status = '1' order by rand() limit " . PCS_MAX_DISPLAY_SPECIALS);
	 
	 while ($special_product = tep_db_fetch_array($special_products_query)) {
		 $special_product['products_name'] = tep_get_products_name($special_product['products_id']);
		 $special_products.= '<div class="PCSChild" title="'.  htmlspecialchars(html_entity_decode('<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $special_product['products_id']) . '"><b>' . BOX_HEADING_SPECIALS . '</b><br />' . $special_product['products_name'] . '<br /><del><span id="price-text-boxContents">' . $currencies->display_price($special_product['products_price'], tep_get_tax_rate($special_product['products_tax_class_id'])) . '</span></del> <span class="productSpecialPrice">' . $currencies->display_price($special_product['specials_new_products_price'], tep_get_tax_rate($special_product['products_tax_class_id'])) . '</span></a>'))  . '"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $special_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $special_product['products_image'], addslashes($special_product['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
	 }
	 
	 /*Pick bestsellers*/
	 $best_sellers_query  = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, s.specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.products_status = '1' order by p.products_ordered desc limit " . PCS_MAX_DISPLAY_BESTSELLERS);
	 
	 while ($best_seller = tep_db_fetch_array($best_sellers_query)) {
		 $best_seller['products_name'] = tep_get_products_name($best_seller['products_id']);
		 if ($best_seller['specials_new_products_price'] == NULL){
			 $best_sellers .= '<div class="PCSChild" title="' .  htmlspecialchars(html_entity_decode('<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_seller['products_id']) . '"><b>' . BOX_HEADING_BESTSELLERS . '</b><br />' . $best_seller['products_name'] . '<br />' . $currencies->display_price($best_seller['products_price'], tep_get_tax_rate($best_seller['products_tax_class_id'])) . '</a>'))  . '"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_seller['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $best_seller['products_image'], addslashes($best_seller['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
		 }
		 else {
			 $best_sellers .= '<div class="PCSChild" title="' .  htmlspecialchars(html_entity_decode('<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_seller['products_id']) . '"><b>' . BOX_HEADING_BESTSELLERS . '</b><br />' . $best_seller['products_name'] . '<br /><del><span id="price-text-boxContents">' . $currencies->display_price($best_seller['products_price'], tep_get_tax_rate($best_seller['products_tax_class_id'])) . '</span></del> <span class="productSpecialPrice">' . $currencies->display_price($best_seller['specials_new_products_price'], tep_get_tax_rate($best_seller['products_tax_class_id'])) . '</span></a>'))  . '"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_seller['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $best_seller['products_image'], addslashes($best_seller['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
		 }
	 }
	 
	 $data = '<div class="ui-widget infoBoxContainer">' .
              //  '  <div class="infoBoxHeading headingBoxProductCycleSlideshow">' . MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_BOX_TITLE . '</div>' .
                '  <div class="infoBoxContents boxContentsProductCycleSlideshow"><div class="ProductsCycleSlideshowWrapper">'.
				'<div id="PCS1" class="ProductsCycleSlideshow">' . $new_products . $featured_products . $special_products . $best_sellers . '</div>'.
				'<div id="PCS1Output" class="PCSOutput"></div><div id="PCS1Pager" class="PCSPager"></div>' .
                '</div></div></div>';

        $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Products Cycle Slideshow Module', 'MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_SORT_ORDER', '1010', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Items - Number of Featured Products', 'PCS_MAX_DISPLAY_FEATURED_PRODUCTS', '5', '<p>How many featured products should be in the slideshow?</p><p><b>Note:</b> This is the maximum value. If fewer products are found, the found ones will be used.</p>', '6', '10', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Items - Number of New Products', 'PCS_MAX_DISPLAY_NEW_PRODUCTS', '5', '<p>How many new products should be in the slideshow?</p><p><b>Note:</b> This is the maximum value. If fewer products are found, the found ones will be used.</p>', '6', '10', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Items - Number of Specials', 'PCS_MAX_DISPLAY_SPECIALS', '5', '<p>How many specials should be in the slideshow?</p><p><b>Note:</b> This is the maximum value. If fewer products are found, the found ones will be used.</p>', '6', '10', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Items - Number of Bestsellers', 'PCS_MAX_DISPLAY_BESTSELLERS', '5', '<p>How many bestsellers should be in the slideshow?</p><p><b>Note:</b> This is the maximum value. If fewer products are found, the found ones will be used.</p>', '6', '10', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FX - Transition FX', 'PCS_FX', 'scrollHorz', '<p>Which transition FX should be used?</p>', '6', '10', 'tep_cfg_select_option(array(\'blindX\', \'blindY\', \'blindZ\', \'cover\', \'curtainX\', \'curtainY\', \'fade\', \'fadeZoom\', \'growX\', \'growY\', \'scrollUp\', \'scrollDown\', \'scrollLeft\', \'scrollRight\', \'scrollHorz\', \'scrollVert\', \'shuffle\', \'slideX\', \'slideY\', \'toss\', \'turnUp\', \'turnDown\', \'turnLeft\', \'turnRight\', \'uncover\', \'wipe\', \'zoom\'), ', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FX - Easing', 'PCS_EASING', 'None', '<p>Which easing style should be used?</p>', '6', '10', 'tep_cfg_select_option(array(\'None\',\'easeInQuad\', \'easeOutQuad\', \'easeInOutQuad\', \'easeInCubic\', \'easeOutCubic\', \'easeInOutCubic\', \'easeInQuart\', \'easeOutQuart\', \'easeInOutQuart\', \'easeInQuint\', \'easeOutQuint\', \'easeInOutQuint\', \'easeInSine\', \'easeOutSine\', \'easeInOutSine\', \'easeInExpo\', \'easeOutExpo\', \'easeInOutExpo\', \'easeInCirc\', \'easeOutCirc\', \'easeInOutCirc\', \'easeInElastic\', \'easeOutElastic\', \'easeInOutElastic\', \'easeInBack\', \'easeOutBack\', \'easeInOutBack\', \'easeInBounce\', \'easeOutBounce\', \'easeInOutBounce\'), ', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('FX - Sync transitions?', 'PCS_SYNC', 'true', 'The sync option controls whether the slide transitions occur simultaneously. The default is true which means that the current slide transitions out as the next slide transitions in.', '6', '10', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('FX - Transition Speed', 'PCS_SPEED', '2000', '<p>The duration of the transition in milliseconds</p>', '6', '10', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('FX - Timeout', 'PCS_TIMEOUT', '8000', '<p>The time in milliseconds between transitions</p>', '6', '10', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('General - Pause onMouseOver?', 'PCS_PAUSE', 'true', '<p>Pause the slideshow on mouse over?</p>', '6', '10', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('General - Display randomly?', 'PCS_RANDOM', 'true', '<p>Display the items in random order?</p>', '6', '10', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('General - Image Quality', 'PCS_IMAGE_QUALITY', '100', '<p>Which quality should the images in the slideshow have? (1-100)</p>', '6', '10', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_STATUS', 'MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_CONTENT_PLACEMENT', 'MODULE_BOXES_PRODUCT_CYCLE_SLIDESHOW_SORT_ORDER','PCS_MAX_DISPLAY_FEATURED_PRODUCTS', 'PCS_MAX_DISPLAY_NEW_PRODUCTS', 'PCS_MAX_DISPLAY_SPECIALS','PCS_MAX_DISPLAY_BESTSELLERS', 'PCS_FX', 'PCS_EASING', 'PCS_SYNC', 'PCS_SPEED', 'PCS_TIMEOUT', 'PCS_PAUSE', 'PCS_RANDOM', 'PCS_IMAGE_QUALITY');
    }
	
  }
?>
