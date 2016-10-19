<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $expected_query = tep_db_query("select p.products_id, pd.products_name, products_date_available as date_expected from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where to_days(products_date_available) >= to_days(now()) and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by " . EXPECTED_PRODUCTS_FIELD . " " . EXPECTED_PRODUCTS_SORT . " limit " . MAX_DISPLAY_UPCOMING_PRODUCTS);
  if (tep_db_num_rows($expected_query) > 0) {
?>

	<div class="ui-widget infoBoxContainer">
		<div class="headingUpcomingProduct infoBoxHeading">
			<span><?php echo TABLE_HEADING_UPCOMING_PRODUCTS; ?></span>
			<span id="upcomingHeadingDate"><?php echo '<span class="upcomingImageDate">' . tep_image(DIR_WS_IMAGES . 'date.png', ' ') . '</span>&nbsp;<span id="dateExpected">' . TABLE_HEADING_DATE_EXPECTED;?></span></span>
		</div>

		<div class="contentContainer">
			<div id="upcomingProductContent" class="productListTable">
<?php
    while ($expected = tep_db_fetch_array($expected_query)) {
      echo '        <div>' . "\n" .
           '         	<span><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $expected['products_id']) . '">' . $expected['products_name'] . '</a></span>' . "\n" .
           '          	<span style="float:right">' . tep_date_short($expected['date_expected']) . '</span>' . "\n" .
           '        </div><hr>' . "\n";
    }
?>

			</div>
		</div>
	</div>

<?php
  }
?>
