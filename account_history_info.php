<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  if (!isset($HTTP_GET_VARS['order_id']) || (isset($HTTP_GET_VARS['order_id']) && !is_numeric($HTTP_GET_VARS['order_id']))) {
    tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  }
  
  $customer_info_query = tep_db_query("select o.customers_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS . " s where o.orders_id = '". (int)$HTTP_GET_VARS['order_id'] . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.public_flag = '1'");
  $customer_info = tep_db_fetch_array($customer_info_query);
  if ($customer_info['customers_id'] != $customer_id) {
    tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_HISTORY_INFO);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  $breadcrumb->add(sprintf(NAVBAR_TITLE_3, $HTTP_GET_VARS['order_id']), tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $HTTP_GET_VARS['order_id'], 'SSL'));

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order($HTTP_GET_VARS['order_id']);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div class="breadcrumb"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail('&raquo;'); ?></div>
<h1 class="headingaccounthistoryinfo"><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
	<h2><?php echo sprintf(HEADING_ORDER_NUMBER, $HTTP_GET_VARS['order_id']) . ' <span class="contentText">(' . $order->info['orders_status'] . ')</span>'; ?></h2><hr>

<div class="contentText">
    <div id="border-bottom">
		<span style="float: right;"><?php echo HEADING_ORDER_TOTAL . ' ' . $order->info['total']; ?></span><?php echo HEADING_ORDER_DATE . ' ' . tep_date_long($order->info['date_purchased']); ?>
	</div>

    <div id="historyinfo"><br />
		<div>

<?php
  if ($order->delivery != false) {
?>
		<div>
		
	
       
            <div><strong><?php echo HEADING_DELIVERY_ADDRESS; ?></strong></div>
        
				<div>
					<?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?>
				</div><br />
<?php
    if (tep_not_null($order->info['shipping_method'])) {
?>
        
            <div><strong><?php echo HEADING_SHIPPING_METHOD; ?></strong></div>
        
				<div>
					<?php echo $order->info['shipping_method']; ?>
				</div><br />
<?php
    }
?>
		</div>
<?php
  }
?>
        <div style="width:<?php echo (($order->delivery != false) ? '100%' : '100%'); ?>"><div>
<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>

			<div>
				<div ><strong><?php echo HEADING_PRODUCTS; ?></strong></div>
				<div align="right"><strong><?php echo HEADING_TAX; ?></strong></div>
				<div align="right"><strong><?php echo HEADING_TOTAL; ?></strong></div>
			</div>
<?php
  } else {
?>
			<div>
				<div><strong><?php echo HEADING_PRODUCTS; ?></strong></div>
				<div align="right"><strong><?php echo HEADING_TOTAL; ?></strong></div><hr>
			</div>
<?php
  }

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    echo '          <div>' . "\n" .
         '           	 <span>' . $order->products[$i]['qty'] . '&nbsp;x&nbsp;</span>' . "\n" .
         '           	 <span style="font-weight:bold">' . $order->products[$i]['name'] . '</span>';

    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '<br /><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';
      }
    }

    echo '</span>' . "\n";

    if (sizeof($order->info['tax_groups']) > 1) {
      echo '           <br /><span style="float:right">' . tep_display_tax_value($order->products[$i]['tax']) . '%</span>' . "\n";
    }

    echo '            	<br /><span style="float:right; font-weight:bold;">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</span><br />' . "\n" .
         '          	</div>' . "\n";
  }
?>
				</div>
			</div>
		</div>
    </div>
</div>
<div id="border-bottom"></div><br />
	<h2><?php echo HEADING_BILLING_INFORMATION; ?></h2><hr>

	<div class="contentText">
		<div id="historyinfo">
			
				
				
					
				<div><strong><?php echo HEADING_BILLING_ADDRESS; ?></strong></div>
					
					<div>
						<?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?>
					</div><br />
					
				<div><strong><?php echo HEADING_PAYMENT_METHOD; ?></strong></div>
					
					<div>
						<?php echo $order->info['payment_method']; ?>
					</div>
				
				<div>
					<div>
<?php
  for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
    echo '          <div>' . "\n" .
         '            	<div style="width:100%; text-align:right">' . $order->totals[$i]['title'] . '</div>' . "\n" .
         '            	<div style="text-align:right">' . $order->totals[$i]['text'] . '</div>' . "\n" .
         '          </div>' . "\n";
  }
?>
		</div>
	</div>
		
					</div>
				</div>
<div id="border-bottom"></div><br />
	<h2><?php echo HEADING_ORDER_HISTORY; ?></h2><hr>

	<div class="contentText">
		<div id="historyinfo">
			<div>
			
<?php
  $statuses_query = tep_db_query("select os.orders_status_name, osh.date_added, osh.comments from " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh where osh.orders_id = '" . (int)$HTTP_GET_VARS['order_id'] . "' and osh.orders_status_id = os.orders_status_id and os.language_id = '" . (int)$languages_id . "' and os.public_flag = '1' order by osh.date_added");
  while ($statuses = tep_db_fetch_array($statuses_query)) {
    echo '          <div>' . "\n" .
         '            	<div width="70">' . tep_date_short($statuses['date_added']) . '</div>' . "\n" .
         '            	<div width="70">' . $statuses['orders_status_name'] . '</div>' . "\n" .
         '           	<div>' . (empty($statuses['comments']) ? '&nbsp;' : nl2br(tep_output_string_protected($statuses['comments']))) . '</div>' . "\n" .
         '          </div>' . "\n";
  }
?>
				</div>
			</div>
		</div>

<div id="border-bottom"></div><br />

<?php
  if (DOWNLOAD_ENABLED == 'true') include(DIR_WS_MODULES . 'downloads.php');
?>

	<div class="buttonSet">
		<?php echo tep_draw_button(IMAGE_BUTTON_BACK, 'triangle-1-w', tep_href_link(FILENAME_ACCOUNT_HISTORY, tep_get_all_get_params(array('order_id')), 'SSL')); ?>
	</div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
