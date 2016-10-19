<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
if( defined('FEATURED_PRODUCTS_DISPLAY') AND FEATURED_PRODUCTS_DISPLAY == 'true' ) {

  $featured_products_category_id =  (isset($new_products_category_id))?$new_products_category_id:'0';
  $cat_name_query = tep_db_query('SELECT `categories_name` FROM ' . TABLE_CATEGORIES_DESCRIPTION . " WHERE `categories_id` = '" . $featured_products_category_id . "' limit 1");
  $cat_name_fetch = tep_db_fetch_array($cat_name_query);
  $cat_name = $cat_name_fetch['categories_name'];
  $info_box_contents = array();

  list($usec, $sec) = explode(' ', microtime());
  srand( (float) $sec + ((float) $usec * 100000) );
  $mtm= rand();
  	
  if ( (!isset($featured_products_category_id)) || ($featured_products_category_id == '0') ) {
    $title = '<a href="' . tep_href_link(FILENAME_FEATURED_PRODUCTS) . '">' . TABLE_HEADING_FEATURED_PRODUCTS . '</a>';

    // Phocea Optimize featured query
    // Ben: Option to only show featured products on sale
    $query = 'SELECT p.products_id, p.products_image, p.products_tax_class_id, IF (s.status, s.specials_new_products_price, NULL) AS specials_new_products_price, p.products_price, pd.products_name ';

	if ( defined('FEATURED_PRODUCTS_SPECIALS_ONLY') AND FEATURED_PRODUCTS_SPECIALS_ONLY == 'true' ) {
      $query .= 'FROM ' . TABLE_SPECIALS . ' s LEFT JOIN ' . TABLE_PRODUCTS . ' p ON s.products_id = p.products_id ';
	} else {
      $query .= 'FROM ' . TABLE_PRODUCTS . ' p LEFT JOIN ' . TABLE_SPECIALS . ' s ON p.products_id = s.products_id ';
	}

    $query .= 'LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id AND pd.language_id = '" . $languages_id . "'
    LEFT JOIN " . TABLE_FEATURED . " f ON p.products_id = f.products_id
    WHERE p.products_status = '1' AND f.status = '1' order by rand($mtm) DESC limit " . MAX_DISPLAY_FEATURED_PRODUCTS;

    $featured_products_query = tep_db_query( $query );	
  } else {
    $title = sprintf(TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY, $cat_name);
    $subcategories_array = array();
    tep_get_subcategories($subcategories_array, $featured_products_category_id);
    $featured_products_category_id_list = tep_array_values_to_string($subcategories_array);
    if ($featured_products_category_id_list == '') {
      $featured_products_category_id_list .= $featured_products_category_id;
    } else {
      $featured_products_category_id_list .= ',' . $featured_products_category_id;
    }

	if ( defined('FEATURED_PRODUCTS_SUB_CATEGORIES') AND FEATURED_PRODUCTS_SUB_CATEGORIES == 'true' ) {
      // current catID as starting value
      $cats[] = $new_products_category_id; 
      // put cat-IDs of all cats nested in current branch into $cats array, 
      // go through all subbranches
      for($i=0; $i<count($cats); $i++) {
        $categorie_query = tep_db_query('SELECT `categories_id` FROM ' . TABLE_CATEGORIES . " WHERE parent_id = '" . (int)$cats[$i] . "'"); 
        while ($categorie = tep_db_fetch_array($categorie_query)) {
          $cats[] = $categorie['categories_id'];
        }
	    // sort out doubles
        $cats = array_unique($cats);
      }
      $catIdSql = implode(', ', $cats);
	} else {
      $catIdSql = $featured_products_category_id_list;
	}

    // Phocea Optimize featured query
	$query = 'SELECT distinct p.products_id, p.products_image, p.products_tax_class_id, IF (s.status, s.specials_new_products_price, NULL) AS specials_new_products_price, p.products_price, pd.products_name
    FROM ' . TABLE_PRODUCTS . ' p LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c using(products_id)
    LEFT JOIN ' . TABLE_CATEGORIES . ' c USING (categories_id)
    LEFT JOIN ' . TABLE_FEATURED . ' f ON p.products_id = f.products_id
    LEFT JOIN ' . TABLE_SPECIALS . ' s ON p.products_id = s.products_id
    LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id AND pd.language_id = '" . $languages_id . "' 
    where c.categories_id IN(" . $catIdSql . ") AND p.products_status = '1' AND f.status = '1' ";

	if ( defined('FEATURED_PRODUCTS_SPECIALS_ONLY') AND FEATURED_PRODUCTS_SPECIALS_ONLY == 'true' ) {
		$query .= " AND s.status = '1' ";
	}
	$query .= 'ORDER BY rand(' . $mtm . ') DESC LIMIT ' . MAX_DISPLAY_FEATURED_PRODUCTS;

    $featured_products_query = tep_db_query( $query );
}

  $num_featured_products = tep_db_num_rows($featured_products_query);

  if ($num_featured_products > 0) {
    $counter = 0;
    $col = 0;

    $featured_prods_content = '<div id="featured-container">';
    while ($featured_products = tep_db_fetch_array($featured_products_query)) {
      $counter++;

      if ($col === 0) {
        $featured_prods_content .= '<div id="featured-wrapper">';
      }

      $featured_prods_content .= '<div id="featured-products"><span id="box-link"><a class="link" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '">' . $featured_products['products_name'] . '</a></span><br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $featured_products['products_image'], $featured_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br /><br /><div id="price-text">' . $currencies->display_price($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</div><br />' . tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', tep_href_link(FILENAME_DEFAULT, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured_products['products_id'])) . '<br /><br />' . '</div>';

      $col ++;

      if (($col > 2) || ($counter == $num_featured_products)) {
        $featured_prods_content .= '</div>';

        $col = 0;
      }
    }

    $featured_prods_content .= '</div>';
?>

  <h2 id="featured-heading-text"><?php echo '<span class="featuredProductsImg">' . tep_image(DIR_WS_IMAGES . 'feature.png') . '</span>' . $title; ?></h2>

  <div class="contentText">
		<?php echo $featured_prods_content; ?>
  </div>

<?php
  }
}
?>
