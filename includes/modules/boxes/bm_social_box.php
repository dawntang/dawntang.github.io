<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_social_box {
    var $code = 'bm_social_box';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_social_box() {
      $this->title = MODULE_BOXES_SOCIAL_TITLE;
      $this->description = MODULE_BOXES_SOCIAL_DESCRIPTION;

      if ( defined('MODULE_BOXES_SOCIAL_STATUS') ) {
        $this->sort_order = MODULE_BOXES_SOCIAL_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_SOCIAL_STATUS == 'True');

        $this->group = ((MODULE_BOXES_SOCIAL_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;

      $data = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="infoBoxHeading headingBoxSocialBox">' . MODULE_BOXES_SOCIAL_BOX_TITLE . '</div>' .
              '  <div class="infoBoxContents boxContentsSocialBox" style="text-align: center;">' .
              '  <a href="http://www.new.facebook.com/' . MODULE_BOXES_FACEBOOK_ACCOUNT_NAME . '" target="_new">' . tep_image(DIR_WS_IMAGES . 'follow-us-on-facebook.png', 'Follow us on Facebook') . '</a><br><a href="http://twitter.com/' . MODULE_BOXES_TWITTER_ACCOUNT_NAME . '" target="_new">' . tep_image(DIR_WS_IMAGES . 'follow_us_twitter.png', 'Tweet Us!') . '</a>' .
              '  </div>' .
              '</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_SOCIAL_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Social Box Module', 'MODULE_BOXES_SOCIAL_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_SOCIAL_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_SOCIAL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Facebook Account Name', 'MODULE_BOXES_FACEBOOK_ACCOUNT_NAME', '', 'Add your facebook account name here', '6', '1', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Twitter id', 'MODULE_BOXES_TWITTER_ACCOUNT_NAME', '', 'Add your twitter id here', '6', '1', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_SOCIAL_STATUS', 'MODULE_BOXES_SOCIAL_CONTENT_PLACEMENT', 'MODULE_BOXES_SOCIAL_SORT_ORDER', 'MODULE_BOXES_FACEBOOK_ACCOUNT_NAME', 'MODULE_BOXES_TWITTER_ACCOUNT_NAME');
    }
  }
?>
