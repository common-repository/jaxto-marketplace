<?php
/*!
* WordPress JAXTO
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

// --------------------------------------------------------------------

function jaxto_component_jaxto_plugin_settings()
{
	
	jaxto_admin_welcome_panel();
	
	$assets_plugin_url_img = JAXTO_PLUGIN_URL . 'assets/img/plugins';
	
?>

<div class="devsite-wrapper">
	<div class="devsite-top-section-wrapper">
		<?php include('header.php'); ?>
	   
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Payment Gateways</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="l-section-h i-cf">
							<div class="g-cols offset_small">
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/paypal.png" alt="Paypal Standard"><b>Paypal Standard</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/paypal.png" alt="Paypal Payments Pro"><b>Paypal Pro</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/paypal.png" alt="Paypal Payflow Pro"><b>Paypal Payflow</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/stripe.png" style="padding: 10px;border-radius: 20px;" alt="Stripe"><b>Stripe</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/56192ee42acf2-resize-710x380.png" alt="PesaPal"><b>PesaPal</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon">
											<img src="<?php echo $assets_plugin_url_img; ?>/7tap-1.png" alt="Tap"><b>Tap</b>
										</div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/8sagepay-1.png" alt="Sage Pay"><b>Sage Pay</b></div>
									</div>
								</div>
								
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/9dusupay.png" alt="<b>DUSU Pay</b>"><b>DUSU Pay</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/Apple_Pay_logo.svg_.png" alt="<b>Apple Pay</b>"><b>Apple Pay</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/11senang-1.png" alt="<b>Senang Pay</b>"><b>Apple Pay</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/dgdg.png" alt="<b>MyGate</b>"><b>MyGate</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/561954f6812a9-resize-710x380.png" alt="<b>BrainTree</b>"><b>BrainTree</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/13instamojo-1.png" alt="<b>Instamojo</b>"><b>Instamojo</b> </div>
									</div>
								</div>
								
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/14razorpay-1.png" alt="<b>RazorPay</b>"><b>RazorPay</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/15Paytm-1.png" alt="<b>Paytm</b>"><b>Paytm</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/20authorizenet-1.png" alt="<b>Authorize.net</b>"><b>Authorize.net</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/gestpay.png" alt="<b>Gest Pay</b>"><b>Gest Pay</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/18paystack.png" alt="<b>PayStack</b>"><b>PayStack</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/19ccavenue-1.png" alt="<b>CC Avenue</b>"><b>CC Avenue</b></div>
									</div>
								</div>
								
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/pay3.png" alt="<b>PayUMoney</b>"><b>PayUMoney</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/24PayuBiz-1.png" alt="<b>PayUBiz</b>"><b>PayUBiz</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/PAYU_01.png" alt="<b>PayU SA</b>"><b>PayU SA</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/0004991_400.png" alt="<b>PayU LATAM</b>"><b>PayU LATAM</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/ind_pic_02.png" alt="<b>Veritrans</b>"><b>Veritrans</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/22payle-1.png" alt="<b>Payle</b>"><b>Payle</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/mollie.png" style="padding: 10px;border-radius: 20px;" alt="<b>Mollie</b>"><b>Mollie</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/plugnpay.png" alt="<b>PlugnPay</b>"><b>PlugnPay</b></div>
									</div>
								</div>
							</div>
							<!---xs-->
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Shipping, Tracking and Delivery Slot Plugins</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="l-section-h i-cf">
							<div class="g-cols offset_small">
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/26rajaongkir.png" alt="<b>Raja Ongkir</b>"><b>Raja Ongkir</b>
										</div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/Epeken-JNE-Shipping.png" alt="<b>JNE Shipping</b>"><b>JNE Shipping</b>
										</div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/Epeken-All-Kurir.png" alt="<b>JNE All Kurrir</b>"><b>JNE All Kurrir</b>
										</div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/28aftership.png" alt="<b>After Ship</b>"><b>After Ship</b>
										</div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/woo.png" alt="<b>Delivery Slots</b>"><b>Delivery Slots</b>
										</div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/woo.png" alt="<b>Time Slots</b>"><b>Time Slots</b>
										</div>
									</div>
								</div>
							</div>
							<!---xs-->
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Multi Vendor Plugins</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="l-section-h i-cf">
							<div class="g-cols offset_small">
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/Dokan_MultiVendor-1.png" alt="<small><b>Dokan</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></small>"><b>Dokan</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/29wc-vendors-logo-1.png" alt="<small><b>WC Vendors</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></small>"><b>WC Vendors</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/Yith-Multivendor.jpg" alt="<small><b>YITH MultiVendor</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></small>"><b>YITH MultiVendor</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/31wcmarketplace.png" alt="<small><b>WC Marketplace</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></small>"><b>WC Marketplace</b><small>( See Marketplace / Multi Vendor Pricing Plan )</small></div>
									</div>
								</div>
								
							</div>
							<!---xs-->
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Reward Points, Sponsor a Friend, Waitlist</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="l-section-h i-cf">
							<div class="g-cols offset_small">
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/woo.png" alt="<b>WooCommerce Points and Rewards</b>"><b>WooCommerce Points and Rewards</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/woo.png" alt="<b>WoooCommerce Sponsor a Friend</b>"><b>WoooCommerce Sponsor a Friend</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/woo.png" alt="<b>WooCommerce Waitlist</b> "><b>WooCommerce Waitlist</b> </div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/SUMO.png" alt="<b>SUMO Reward Points</b>"><b>SUMO Reward Points</b></div>
									</div>
								</div>
								
							</div>
							<!---xs-->
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Customer Support & Live Chat</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="l-section-h i-cf">
							<div class="g-cols offset_small">
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/Hotline.png" alt="<b>Hotline.io</b>"><b>Hotline.io</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/zendesk.jpg" alt="<b>Zendesk</b>"><b>Zendesk</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/live-chat-inc.png" alt="<b>Live Chat Inc</b>"><b>Live Chat Inc</b></div>
									</div>
								</div>
								
							</div>
							<!---xs-->
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Miscellaneous</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="l-section-h i-cf">
							<div class="g-cols offset_small">
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/AutoCoupons-1.png" alt="<b>AutoCoupons</b>"><b>AutoCoupons</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/Jetpack.png" alt="<b>Minimum Order</b>"><b>Minimum Order</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/contact-form-7-1.png" alt="<b>Contact Form 7</b>"><b>Contact Form 7</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/translation-ready-1.png" alt="<b>WPML</b>"><b>WPML</b></div>
									</div>
								</div>
								<div class=" one-sixth">
									<div class="w-iconbox iconpos_top size_huge style_default color_primary icontype_img">
										<div class="w-iconbox-icon"><img src="<?php echo $assets_plugin_url_img; ?>/woo.png" alt="<b>WooCommerce Early Booking</b>"><b>WooCommerce Early Booking</b></div>
									</div>
								</div>
								
							</div>
							<!---xs-->
						</div>
					</div>
				</div>
			</section>
		</div>
		
		
	</div>
</div> 
<style>
.button-secondary
{
    background: #e5e5e5 !important;
}
#wpbody-content .metabox-holder {
    padding-top: 0px;
}
h2 {
    margin-bottom: 0;
}
</style>
<?php
}
jaxto_component_jaxto_plugin_settings();

// --------------------------------------------------------------------	
