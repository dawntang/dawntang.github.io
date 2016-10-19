<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ADVANCED_SEARCH);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ADVANCED_SEARCH));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
</div></div>
<style>
#columnLeft{display:none;}
</style>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript"><!--
function check_form() {
  var error_message = "<?php echo JS_ERROR; ?>";
  var error_found = false;
  var error_field;
  var keywords = document.advanced_search.keywords.value;
  var dfrom = document.advanced_search.dfrom.value;
  var dto = document.advanced_search.dto.value;
  var pfrom = document.advanced_search.pfrom.value;
  var pto = document.advanced_search.pto.value;
  var pfrom_float;
  var pto_float;

  if ( ((keywords == '') || (keywords.length < 1)) && ((dfrom == '') || (dfrom.length < 1)) && ((dto == '') || (dto.length < 1)) && ((pfrom == '') || (pfrom.length < 1)) && ((pto == '') || (pto.length < 1)) ) {
    error_message = error_message + "* <?php echo ERROR_AT_LEAST_ONE_INPUT; ?>\n";
    error_field = document.advanced_search.keywords;
    error_found = true;
  }

  if (dfrom.length > 0) {
    if (!IsValidDate(dfrom, '<?php echo DOB_FORMAT_STRING; ?>')) {
      error_message = error_message + "* <?php echo ERROR_INVALID_FROM_DATE; ?>\n";
      error_field = document.advanced_search.dfrom;
      error_found = true;
    }
  }

  if (dto.length > 0) {
    if (!IsValidDate(dto, '<?php echo DOB_FORMAT_STRING; ?>')) {
      error_message = error_message + "* <?php echo ERROR_INVALID_TO_DATE; ?>\n";
      error_field = document.advanced_search.dto;
      error_found = true;
    }
  }

  if ((dfrom.length > 0) && (IsValidDate(dfrom, '<?php echo DOB_FORMAT_STRING; ?>')) && (dto.length > 0) && (IsValidDate(dto, '<?php echo DOB_FORMAT_STRING; ?>'))) {
    if (!CheckDateRange(document.advanced_search.dfrom, document.advanced_search.dto)) {
      error_message = error_message + "* <?php echo ERROR_TO_DATE_LESS_THAN_FROM_DATE; ?>\n";
      error_field = document.advanced_search.dto;
      error_found = true;
    }
  }

  if (pfrom.length > 0) {
    pfrom_float = parseFloat(pfrom);
    if (isNaN(pfrom_float)) {
      error_message = error_message + "* <?php echo ERROR_PRICE_FROM_MUST_BE_NUM; ?>\n";
      error_field = document.advanced_search.pfrom;
      error_found = true;
    }
  } else {
    pfrom_float = 0;
  }

  if (pto.length > 0) {
    pto_float = parseFloat(pto);
    if (isNaN(pto_float)) {
      error_message = error_message + "* <?php echo ERROR_PRICE_TO_MUST_BE_NUM; ?>\n";
      error_field = document.advanced_search.pto;
      error_found = true;
    }
  } else {
    pto_float = 0;
  }

  if ( (pfrom.length > 0) && (pto.length > 0) ) {
    if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
      error_message = error_message + "* <?php echo ERROR_PRICE_TO_LESS_THAN_PRICE_FROM; ?>\n";
      error_field = document.advanced_search.pto;
      error_found = true;
    }
  }

  if (error_found == true) {
    alert(error_message);
    error_field.focus();
    return false;
  } else {
    return true;
  }
}

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>

<div class="breadcrumb"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail('&raquo;'); ?></div>
<h1 class="headingadvancedsearch"><?php echo HEADING_TITLE_1; ?></h1>
<div class="messagestack">
<?php
  if ($messageStack->size('search') > 0) {
    echo $messageStack->output('search');
  }
?>
</div>
<?php echo tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', 'onsubmit="return check_form(this);"') . tep_hide_session_id(); ?>

<div class="contentContainer2">
	<h2 class="head_2"><?php echo HEADING_SEARCH_CRITERIA; ?></h2>

	<div class="contentText2">
		<div>
			<?php echo tep_draw_input_field('keywords', 'Enter your text here','onblur="if(this.value==\'\')this.value=\'Enter your text here\'"' . 'onfocus="if(this.value==\'Enter your text here\')this.value=\'\'"' . 'style="color:#7c7c7c; width:100%; padding-top:2px; padding-bottom:2px;"') . tep_draw_hidden_field('search_in_description', '1'); ?>
		</div>

		<br />

		<div>
			
			<span style="float: right;"><?php echo tep_draw_button(IMAGE_BUTTON_SEARCH, 'search', null, 'primary'); ?></span>
		</div>

		<div id="helpSearch" title="<?php echo HEADING_SEARCH_HELP; ?>">
			<p><?php echo TEXT_SEARCH_HELP; ?></p>
		</div>

<script type="text/javascript">
jQuery(document).ready(function () {$('#helpSearch').dialog({
  autoOpen: false,
  buttons: {
    Ok: function() {
      $(this).dialog('close');
    }
  }
});});
</script>


    <br />

		<div id="advanced-search-wrapper">
		
			<div class="fieldKey"><?php echo ENTRY_CATEGORIES; ?></div>
			<div class="fieldValue"><?php echo tep_draw_pull_down_menu('categories_id', tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES)))); ?></div>
		
			
			<div class="fieldKey">&nbsp;&nbsp;</div>
			<div class="fieldValue"><?php echo tep_draw_checkbox_field('inc_subcat', '1', true) . ' ' . ENTRY_INCLUDE_SUBCATEGORIES; ?></div>
			
		
			<div class="fieldKey"><?php echo ENTRY_MANUFACTURERS; ?></div>
			<div class="fieldValue"><?php echo tep_draw_pull_down_menu('manufacturers_id', tep_get_manufacturers(array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS)))); ?></div>
		
		
			<div class="fieldKey"><?php echo ENTRY_PRICE_FROM; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('pfrom'); ?></div>
		
		
			<div class="fieldKey"><?php echo ENTRY_PRICE_TO; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('pto'); ?></div>
	
		
			<div class="fieldKey"><?php echo ENTRY_DATE_FROM; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('dfrom', '', 'id="dfrom"'); ?><script type="text/javascript">jQuery(document).ready(function () {$('#dfrom').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-10:+0'});});</script></div>
		
	
			<div class="fieldKey"><?php echo ENTRY_DATE_TO; ?></div>
			<div class="fieldValue"><?php echo tep_draw_input_field('dto', '', 'id="dto"'); ?><script type="text/javascript">jQuery(document).ready(function () {$('#dto').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-10:+0'});});</script></div>
		
		</div>
	</div>
</div>

</form>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
