<!DOCTYPE html>
<html lang="en">

	<head>
		<title>PayWay Checkout Sample</title>

		<!— Make a copy of this code to paste into your site—>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="author" content="PayWay">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

		<!— end —>
	</head>

	<body>
		<!— Popup Checkout Form —>
			<div id="aba_main_modal" class="aba-modal">
				<!— Modal content —>
				<div class="aba-modal-content">

					<!-- Include PHP class -->
					<?php
						require_once 'PayWayApiCheckout.php';
                      $item [0]['name'] = 'test1';
                      $item [0]['quantity'] = '1';
                      $item [0]['price'] = '1';
                      $item [1]['name'] = 'test2';
                      $item [1]['quantity'] = '1';
                      $item [1]['price'] = '1';

                      $items = base64_encode(json_encode($item));

                        $req_time = time();
                        $merchant_id = "ec438740";
                        $transactionId = time();
                        $amount = '0.01';
                        $firstName = 'Makara';
                        $lastName = 'Prom';
                        $phone = '093630466';
                        $email = 'prom.makara@ababank.com';
                        $return_params = "Hello World!";
	                    // $payment_option = "abapay";
						$currency = "USD";
                      	$shipping = '2';
                  		$continue_success_url = "https://domain.gov.kh/buydomain/PurchasThank";
                 	 	$type = "purchase";
					?>

					<form method="POST" target="aba_webservice" action="<?php echo PayWayApiCheckout::getApiUrl(); ?>" id="aba_merchant_request">
						<input type="hidden" name="hash" value="<?php echo PayWayApiCheckout::getHash($req_time . ABA_PAYWAY_MERCHANT_ID . $transactionId . $amount . $items . $shipping . $firstName . $lastName . $email . $phone . $type . $currency .$return_params); ?>" id="hash"/>
						<input type="hidden" name="tran_id" value="<?php echo $transactionId; ?>" id="tran_id"/>
						<input type="hidden" name="amount" value="<?php echo $amount; ?>" id="amount"/>
						<input ype="hidden" name="items" value="<?php echo $items; ?>" id="items">
						<input type="hidden" name="shipping" value="<?php echo $shipping; ?>"/>
						<input type="hidden" name="firstname" value="<?php echo $firstName; ?>"/>
						<input type="hidden" name="lastname" value="<?php echo $lastName; ?>"/>
						<input type="hidden" name="email" value="<?php echo $email; ?>"/>
						<input type="hidden" name="phone" value="<?php echo $phone; ?>"/>
						<input type="hidden" name="type" value="<?php echo $type; ?>"/>
						<input type="hidden" name="currency" value = "<?php echo $currency; ?>">
                        <input type="hidden" name="return_params" value="<?php echo $return_params; ?>"/>
						<input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>"/>
                        <input type="hidden" name="req_time" value="<?php echo $req_time; ?>"/>
                    </form>
				</div>
				<!— end Modal content—>
			</div>
		<!— End Popup Checkout Form —>

		<!— Page Content —>
		<div class="container" style="margin-top: 75px;margin: 0 auto;">
			<div style="width: 200px;margin: 0 auto;">
				<h2>TOTAL: $2.00</h2>
				<input type="button" id="checkout_button" value="Checkout Now">
			</div>
		</div>
		<!— End Page Content —>

		<!— Make a copy this javaScript to paste into your site—>
		<!— Note: these javaScript files are using for only integration testing—>

    	<link rel="stylesheet" href="https://payway-staging.ababank.com/checkout-popup.html?file=css"/>
		<script src="https://checkout.payway.com.kh/plugins/checkout2-0.js"></script>
		<!— These javaScript files are using for only production —>
		<link rel="stylesheet" href="https://payway.ababank.com/checkout-popup.html?file=css"/>
		<script src="https://payway.ababank.com/checkout-popup.html?file=js"></script> 

		<script>
			$(document).ready(function () {
				$('#checkout_button').click(function () {
					AbaPayway.checkout();
				});
			});
		</script>
		<!— End —>
	</body>
</html>
