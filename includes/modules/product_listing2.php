<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
?>

	<div class="contentText">

<?php
  if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>



<?php
  }

  $prod_list_contents = '<div class="ui-widget infoBoxContainer">' .
                        '  <div class="infoBoxHeading headingProductListing">' .
                        '    <div class="productListingHeader">' .
                        '      <div id="product-listing-header-container">';

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    $lc_align = '';

    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = 'left';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = 'left';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = 'left';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'left';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'left';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'left';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'left';
        break;
      case 'PRODUCT_LIST_BUY_NOW':
        $lc_text = '<div style="margin-right:20px">' . TABLE_HEADING_BUY_NOW . '</div>';
        $lc_align = 'right';
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
    }

    $prod_list_contents .= '        <div' . (tep_not_null($lc_align) ? ' style="padding-left:40px; float:' . $lc_align . '"' : '') . '>' . $lc_text . '</div>';
  }

  $prod_list_contents .= '      </div>' .
                         '    </div>' .
                         '  </div>';

  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);

    $prod_list_contents .= '  <div class="ui-widget-content productListTable contentProductListTable">' .
                           '    <div style="width:100%; overflow:hidden;" class="productListingData">';

    while ($listing = tep_db_fetch_array($listing_query)) {
      $rows++;

      $prod_list_contents .= '      <div>';

      for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
        switch ($column_list[$col]) {
          case 'PRODUCT_LIST_MODEL':
            $prod_list_contents .= '        <div style="position:relative; top:70px; float:left; margin-right:5px; width:90px; padding-left:0px;">' . $listing['products_model'] . '</div>';
            break;
          case 'PRODUCT_LIST_NAME':
            if (isset($HTTP_GET_VARS['manufacturers_id']) && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
              $prod_list_contents .= '        <div style="position:relative;  top:70px; width:90px; float:left; margin-left:-100px"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . $listing['products_name'] . '</a></div>';
            } else {
              $prod_list_contents .= '        <div style="position:relative; top:70px; width:90px; float:left; margin-left:-100px"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . $listing['products_name'] . '</a></div>';
            }
            break;
          case 'PRODUCT_LIST_MANUFACTURER':
		   
            $prod_list_contents .= '        <div style="position:relative; top:70px; float:left; width:90px; margin-right:5px; margin-left:5px;"><a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a></div>';
			
		   break;
          case 'PRODUCT_LIST_PRICE':
            if (tep_not_null($listing['specials_new_products_price'])) {
              $prod_list_contents .= '        <div style="position:relative; top:70px; float:left; width:70px; margin-left:3px;"><del><span id="price-text-productListing">' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span></del><br /><span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span></div>';
            } else {
              $prod_list_contents .= '        <div style="position:relative; top:70px; float:left; width:70px; margin-left:3px;">' . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</div>';
            }
            break;
          case 'PRODUCT_LIST_QUANTITY':
            $prod_list_contents .= '        <div style="position:relative; top:70px; float:left; margin-right:5px; width:90px; padding-left:0px;">' . $listing['products_quantity'] . '</div>';
            break;
          case 'PRODUCT_LIST_WEIGHT':
            $prod_list_contents .= '        <div style="position:relative; top:70px; float:left; margin-right:5px; width:30px; padding-left:0px;">' . $listing['products_weight'] . '</div>';
            break;
          case 'PRODUCT_LIST_IMAGE':
            if (isset($HTTP_GET_VARS['manufacturers_id'])  && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
              $prod_list_contents .= '        <div style="float:left; clear:both; padding-left:10px;" ><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
            } else {
              $prod_list_contents .= '        <div style="float:left; clear:both; padding-left:10px;"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></div>';
            }
            break;
          case 'PRODUCT_LIST_BUY_NOW':
            $prod_list_contents .= '        <div style="position:relative; top:70px; float:right;">' . tep_draw_button(IMAGE_BUTTON_BUY_NOW, 'cart', tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id'])) . '</div>';
            break;
        }
      }

      $prod_list_contents .= '      </div>';
    }

    $prod_list_contents .= '    </div>' .
                           '  </div>' .
                           '</div>';

    echo $prod_list_contents;
  } else {
?>

    <p><?php echo TEXT_NO_PRODUCTS; ?></p>

<?php
  }

  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

    <br />

    <div>
		<span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>

		<span class="displayProductNumber"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
    </div>

<?php
  }
?>

	</div>
