<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!tep_session_is_registered('shipping')) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

  if (!tep_session_is_registered('payment')) tep_session_register('payment');
  if (isset($HTTP_POST_VARS['payment'])) $payment = $HTTP_POST_VARS['payment'];

  if (!tep_session_is_registered('comments')) tep_session_register('comments');
  if (isset($HTTP_POST_VARS['comments']) && tep_not_null($HTTP_POST_VARS['comments'])) {
    $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
  }

// load the selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  $payment_modules->update_status();

  if ( ($payment_modules->selected_module != $payment) || ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
  }

  if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
  }

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;
  $order_total_modules->process();

// Stock Check
  $any_out_of_stock = false;
  if (STOCK_CHECK == 'true') {
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      if (tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
        $any_out_of_stock = true;
      }
    }
    // Out of Stock
    if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
      tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
    }
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_CONFIRMATION);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
</div></div>
<style>
#columnLeft{display:none;}
</style>
<div class="breadcrumb"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail('&raquo;'); ?></div>
<h1 class="headingcontactus"><?php echo HEADING_TITLE; ?></h1>

<?php
  if (isset($$payment->form_action_url)) {
    $form_action_url = $$payment->form_action_url;
  } else {
    $form_action_url = tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
  }

  echo tep_draw_form('checkout_confirmation', $form_action_url, 'post');
?>

<div class="contentContainer2">
	<h2><?php echo HEADING_SHIPPING_INFORMATION; ?></h2><hr>

	<div class="contentText">
		<div>
			<div>

<?php
  if ($sendto != false) {
?>

    <div style="width:30%;">
		
			
		<div><?php echo '<strong>' . HEADING_DELIVERY_ADDRESS . '</strong> <a class="orderEdit" href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">' . '(' . TEXT_EDIT . ')' . '</a>'; ?></div>
			
			
		<div><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></div>
			

<?php
    if ($order->info['shipping_method']) {
?>

		<br />	
		<div><?php echo '<strong>' . HEADING_SHIPPING_METHOD . '</strong> <a class="orderEdit" href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . '(' . TEXT_EDIT . ')' . '</a>'; ?></div>
			
			
		<div><?php echo $order->info['shipping_method']; ?></div><br />
			
<?php
    }
?>

        
	</div>

<?php
  }
?>

        <div style="width:<?php echo (($sendto != false) ? '100%' : '100%'); ?>"><div>

<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>

			<div>
				<div><?php echo '<strong>' . HEADING_PRODUCTS . '</strong> <a class="orderEdit" href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . '(' . TEXT_EDIT . ')' . '</a>'; ?></div>
				<div style="text-align:right "><strong><?php echo HEADING_TAX; ?></strong></div>
				<div style="text-align:right "><strong><?php echo HEADING_TOTAL; ?></strong></div>
			</div>

<?php
  } else {
?>

			
				<div><?php echo '<strong>' . HEADING_PRODUCTS . '</strong> <a class="orderEdit" href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . '(' . TEXT_EDIT . ')' . '</a>'; ?></div>
			

<?php
  }

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    echo '          <div>' . "\n" .
         '            <span style="text-align:right; ">' . $order->products[$i]['qty'] . '&nbsp;x</span>' . "\n" .
         '            <span style="font-weight:bold">' . $order->products[$i]['name'] . '</span>';

    if (STOCK_CHECK == 'true') {
      echo tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty']);
    }

    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '<br /><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';
      }
    }

    echo '</div>' . "\n";

    if (sizeof($order->info['tax_groups']) > 1) echo '            <div style="text-align:right">' . tep_display_tax_value($order->products[$i]['tax']) . '%</div>' . "\n";

    echo '            <div style="text-align:right; width:100%; font-weight:bold;">' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . '</div><br />' . "\n" .
         '          </span>' . "\n";
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
		
			
				<div style="width:30%;">
					
						
					<div><?php echo '<strong>' . HEADING_BILLING_ADDRESS . '</strong><a class="orderEdit" href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . '(' . TEXT_EDIT . ')' . '</a>'; ?></div>
						
						
					<div><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></div>
					
					<br />	
					<div><?php echo '<strong>' . HEADING_PAYMENT_METHOD . '</strong> <a class="orderEdit" href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '">' . '(' . TEXT_EDIT . ')' . '</a>'; ?></div>
					
						
					<div><?php echo $order->info['payment_method']; ?></div>
						
					
				</div>
			
					
					<div id="CheckoutConfirmationTotalPrice">
<?php
  if (MODULE_ORDER_TOTAL_INSTALLED) {
    echo $order_total_modules->output();
  }
?>		
					</div>
			
			
		
	</div>

<?php
  if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) {
?>

	<h2><?php echo HEADING_PAYMENT_INFORMATION; ?></h2><hr>

	<div class="contentText">
		
			
		<div><?php echo $confirmation['title']; ?></div>
			

<?php
      for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {
?>

		
		<div><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></div>
		<div class="main"><?php echo $confirmation['fields'][$i]['title']; ?></div>
		<div><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></div>
		<div class="main"><?php echo $confirmation['fields'][$i]['field']; ?></div>
			

<?php
      }
?>

	
	</div>

<?php
    }
  }

  if (tep_not_null($order->info['comments'])) {
?>
<div id="border-bottom"></div><br />
	<h2><?php echo '' . HEADING_ORDER_COMMENTS . '<a class="orderEdit" href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '">' . '(' . TEXT_EDIT . ')' . '</a>'; ?></h2><hr>

	<div class="contentText">
		<?php echo nl2br(tep_output_string_protected($order->info['comments'])) . tep_draw_hidden_field('comments', $order->info['comments']); ?>
	</div>

<?php
  }
?>
<div id="border-bottom"></div><br />
	<div id="checkout-confirmation-container" class="contentText">
		<div id="checkout-confirmation-wrapper">
			<div class="checkoutBarFrom"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '" >' . CHECKOUT_BAR_DELIVERY . '</a>'; ?></div>
			<div class="checkoutBarFrom"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '" >' . CHECKOUT_BAR_PAYMENT . '</a>'; ?></div>
			<div class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></div>
		</div>
<br />
		<div style="float: right;">

<?php
  if (is_array($payment_modules->modules)) {
    echo $payment_modules->process_button();
  }

  echo tep_draw_button(IMAGE_BUTTON_CONFIRM_ORDER, 'check', null, 'primary');
?>

		</div>
	</div>

</div>

<script type="text/javascript">
$('#coProgressBar').progressbar({
  value: 100
});
</script>

</form>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
