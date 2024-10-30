<?php
/*!
* WordPress JAXTO
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function jaxto_component_jaxto_plugin_settings()
{
	
	jaxto_admin_welcome_panel();
	
	$assets_setup_base_url = JAXTO_PLUGIN_URL . 'assets/img/';
	$options_woo_setting = get_option( 'jaxto_woo_settings_data' );
	$options_woo_setting = maybe_unserialize( $options_woo_setting );
	
	$options_store_setting = get_option( 'jaxto_store_settings_data' );
	$options_store_setting = maybe_unserialize( $options_store_setting );
	
	$options_app_setting= get_option( 'jaxto_app_settings_data' );
	$options_app_setting = maybe_unserialize( $options_app_setting );
	
?>

<div class="devsite-wrapper">
	<div class="devsite-top-section-wrapper">
		<?php include('header.php'); ?>
	   
		<div class="devsite-main-content clearfix about-devsite" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">About JAXTO</h2>
					</div>
					<div class="md-ripple-container"><b>Step -1</b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
						<h5>Jaxto is a network of WooCommerce stores spread across the web. Customers can find all the independent WooCommerce stores relevant to their needs, all in one mobile app. Jaxto offers solutions for Discovery, Login, Loyalty Program, Coupon, and Expert trade for all Merchants. WooCommerce stores can also use the platform to connect with each other. Jaxto is all about discovery, whether it's by the end consumers or other Merchants. Be part of Jaxto's WooCommerce network and get discovered.</h5>
						
						<h5> You will receive your own Mobile App integrated in your website. You can promote your own Native Mobile App to increase your sales</h5>
						<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
							<h5>Steps to Receive your App</h5>
							<ol>
								<li>Complete Configration of Woocommerce API</li>
								<li>Complete your Store Details for Search</li>
								<li>Complete your Color Themes and other component</li>
								<li>Receive your App Link after completing previous three Steps</li>
								<li>Incase of any queries, additional plugins and features discuss with <a href="mailto:jaxto@twistmobile.in">jaxto@twistmobile.in</a></li>
							</ol>
						</div>
						
						<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
							<h5>Features of Jaxto (<small>eCommerce Browser for WooCommerce Stores</small>)</h5>
							<ol>
								<li>Native Mobile App Experience</li>
								<li>Unified Login</li>
								<li>Unified Loyalty Program</li>
								<li>Promote Store Coupon</li>
								<li>Google Keyword Ranking</li>
								<li>Instant Apps Enabled</li>
							</ol>
						</div>
						
						<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
							<h5>Benefits</h5>
							<ol>
								<li>Free Native Mobile App</li>
								<li>Your Mobile Web Users can use Native Mobile App</li>
								<li>New users for your store</li>
								<li>0% Commission on Sales</li>
								<li>Networking</li>
								<li>Mobile Commerce Ready</li>
							</ol>
						</div>
						
					</div>
				</div>
			</section>
			
		</div>
		
	</div>
</div>
</style>
<?php
}
jaxto_component_jaxto_plugin_settings();

// --------------------------------------------------------------------	
