<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

  class bm_side_banners {
    var $code = 'bm_side_banners';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_side_banners() {
      $this->title = MODULE_BOXES_SIDE_BANNERS_TITLE;
      $this->description = MODULE_BOXES_SIDE_BANNERS_DESCRIPTION;

      if ( defined('MODULE_BOXES_SIDE_BANNERS_STATUS') ) {
        $this->sort_order = MODULE_BOXES_SIDE_BANNERS_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_SIDE_BANNERS_STATUS == 'True');

        $this->group = ((MODULE_BOXES_SIDE_BANNERS_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $HTTP_GET_VARS, $current_category_id, $languages_id, $oscTemplate;

		$side_banners_query = tep_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '250x80'" . " limit " . MODULE_BOXES_SIDE_BANNERS_MAX);
	  if (tep_db_num_rows($side_banners_query) > 0) {
	  	  $side_banners_list = '';
          while ($side_banners = tep_db_fetch_array($side_banners_query)) {
          	$side_banner_id = $side_banners['banners_id'];
          	if (tep_not_null($side_banners['banners_html_text'])) {
          	 $sidebanner_href = ' href="' . tep_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $side_banner_id ) . '" target="_blank" '; 
     		 $side_banner_string = '<div id="side' .
			  $side_banner_id . '" class="sideBannerHTML">' .
			  str_replace('$sidebanner_href',$sidebanner_href, 
			  				$side_banners['banners_html_text']) .
			  '</div>';
    		} else {
     		 $side_banner_string = '<div id="side' .
			  $side_banner_id . '" class="sideBannerPIC" style="text-align:center">' .
			  '<a href="' . tep_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $side_banner_id ) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $side_banners['banners_image'], $side_banners['banners_title']) . '</a>' .
			  '</div>';
    		}
        	$side_banners_list .= $side_banner_string;
        	tep_update_banner_display_count($side_banner_id);
          }

          $data = '<div class="ui-widget infoBoxContainer">' .
                  '  <div class="infoBoxHeading headingBoxSideBanner">' . MODULE_BOXES_SIDE_BANNERS_BOX_TITLE . '</div>' .
                  '  <div class="infoBoxContents boxContentsSideBanner">' . $side_banners_list . '</div>' .
                  '</div>';

          $oscTemplate->addBlock($data, $this->group);
		}	  	
     }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_SIDE_BANNERS_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Side Banners Module', 'MODULE_BOXES_SIDE_BANNERS_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_SIDE_BANNERS_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_SIDE_BANNERS_SORT_ORDER', '5100', 'Sort order of display. Lowest is displayed first.', '6', '5100', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Maximum number Side banners', 'MODULE_BOXES_SIDE_BANNERS_MAX', '5', 'The maximum number side-banners to show', '6', '1', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_SIDE_BANNERS_STATUS', 'MODULE_BOXES_SIDE_BANNERS_CONTENT_PLACEMENT', 'MODULE_BOXES_SIDE_BANNERS_SORT_ORDER', 'MODULE_BOXES_SIDE_BANNERS_MAX');
    }
  }
 ?>
