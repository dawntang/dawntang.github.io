<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCTS_NEW);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCTS_NEW));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
</div></div>
<style>
#columnLeft{display:none;}
</style>
<div class="breadcrumb"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail('&raquo;'); ?></div>
<h1 class="headingwhatsnew"><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer2">
	<div class="contentText">

<?php
  $products_new_array = array();

  $products_new_query_raw = "select p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id, p.products_date_added, m.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added DESC, pd.products_name";
  $products_new_split = new splitPageResults($products_new_query_raw, MAX_DISPLAY_PRODUCTS_NEW);

  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>



    <br />

<?php
  }
?>

<?php
  if ($products_new_split->number_of_rows > 0) {
?>

    

<?php
    $products_new_query = tep_db_query($products_new_split->sql_query);
    while ($products_new = tep_db_fetch_array($products_new_query)) {
      if ($new_price = tep_get_products_special_price($products_new['products_id'])) {
        $products_price = '<del><span id="price-text-whatsnew">' . $currencies->display_price($products_new['products_price'], tep_get_tax_rate($products_new['products_tax_class_id'])) . '</span></del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($products_new['products_tax_class_id'])) . '</span>';
      } else {
        $products_price = $currencies->display_price($products_new['products_price'], tep_get_tax_rate($products_new['products_tax_class_id']));
      }
?>
		<div id="products-new-container">
			<div id="products-new-wrapper">
				<div id="products-new-image" class="main" width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>"  ><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $products_new['products_image'], $products_new['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'; ?></div>
				<div id="products-new-info" class="main" ><?php echo '<a class="link" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new['products_id']) . '">' . $products_new['products_name'] . '</a><br /><br />' . TEXT_DATE_ADDED . ' ' . tep_date_long($products_new['products_date_added']) . '<br /> <br />' . TEXT_PRICE . ' ' . $products_price . '<br /><br />' ; ?></div>
			</div>
		</div><hr>
<?php
    }
?>

   

<?php
  } else {
?>

    <div>
		<?php echo TEXT_NO_NEW_PRODUCTS; ?>
    </div>

<?php
  }

  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

    <br />

    <div>
		<span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>

		<span class="displayProductNumber"><?php echo $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW); ?></span>
    </div>

<?php
  }
?>

	</div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
