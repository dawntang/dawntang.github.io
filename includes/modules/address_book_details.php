<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if (!isset($process)) $process = false;
?>

	<div>
		<span class="inputRequirement" style="float: right;"><?php echo FORM_REQUIRED_INFORMATION; ?></span>
		<h2><?php echo NEW_ADDRESS_TITLE; ?></h2><hr>
	</div>

	<div class="contentText">
		<div id="address-book-details-wrapper">

<?php
  if (ACCOUNT_GENDER == 'true') {
    $male = $female = false;
    if (isset($gender)) {
      $male = ($gender == 'm') ? true : false;
      $female = !$male;
    } elseif (isset($entry['entry_gender'])) {
      $male = ($entry['entry_gender'] == 'm') ? true : false;
      $female = !$male;
    }
?>

      
			<div class="fieldKey"><?php echo ENTRY_GENDER; ?></div>
			<div class="fieldValue"><?php echo tep_draw_radio_field('gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></div>
    

<?php
  }
?>

     
			<div class="fieldKey"><?php echo ENTRY_FIRST_NAME; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('firstname', (isset($entry['entry_firstname']) ? $entry['entry_firstname'] : '')) . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></div>
     
     
			<div class="fieldKey"><?php echo ENTRY_LAST_NAME; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('lastname', (isset($entry['entry_lastname']) ? $entry['entry_lastname'] : '')) . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></div>
     

<?php
  if (ACCOUNT_COMPANY == 'true') {
?>

      
			<div class="fieldKey"><?php echo ENTRY_COMPANY; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('company', (isset($entry['entry_company']) ? $entry['entry_company'] : '')) . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></div>
    
<?php
  }
?>

     
			<div class="fieldKey"><?php echo ENTRY_STREET_ADDRESS; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('street_address', (isset($entry['entry_street_address']) ? $entry['entry_street_address'] : '')) . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></div>
     

<?php
  if (ACCOUNT_SUBURB == 'true') {
?>

   
			<div class="fieldKey"><?php echo ENTRY_SUBURB; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('suburb', (isset($entry['entry_suburb']) ? $entry['entry_suburb'] : '')) . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></div>
   

<?php
  }
?>

   
			<div class="fieldKey"><?php echo ENTRY_POST_CODE; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('postcode', (isset($entry['entry_postcode']) ? $entry['entry_postcode'] : '')) . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></div>
   
   
			<div class="fieldKey"><?php echo ENTRY_CITY; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('city', (isset($entry['entry_city']) ? $entry['entry_city'] : '')) . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></div>
    

<?php
  if (ACCOUNT_STATE == 'true') {
?>

     
			<div class="fieldKey"><?php echo ENTRY_STATE; ?></div>
			<div class="fieldValue">
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = tep_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo tep_draw_pull_down_menu('state', $zones_array);
      } else {
        echo tep_draw_input_field('state');
      }
    } else {
      echo tep_draw_input_field('state', (isset($entry['entry_country_id']) ? tep_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'], $entry['entry_state']) : ''));
    }

    if (tep_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>';
?>
			</div>
    

<?php
  }
?>

     
			<div class="fieldKey"><?php echo ENTRY_COUNTRY; ?></div>
			<div class="fieldValue"><?php echo tep_get_country_list('country', (isset($entry['entry_country_id']) ? $entry['entry_country_id'] : STORE_COUNTRY)) . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></div>
      

<?php
  if ((isset($HTTP_GET_VARS['edit']) && ($customer_default_address_id != $HTTP_GET_VARS['edit'])) || (isset($HTTP_GET_VARS['edit']) == false) ) {
?>

			<div class="fieldKey">&nbsp;</div>
			<div class="fieldValue"><?php echo tep_draw_checkbox_field('primary', 'on', false, 'id="primary"') . ' ' . SET_AS_PRIMARY; ?></div>
  
<?php
  }
?>
		</div>
	</div>
<div id="border-bottom"></div>