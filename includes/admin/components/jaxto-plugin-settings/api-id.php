<?php
/*!
* WordPress JAXTO
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function jaxto_component_jaxto_plugin_settings()
{
	
	jaxto_admin_welcome_panel();
	$options_store_setting = get_option( 'jaxto_store_settings_data' );
	$options_store_setting = maybe_unserialize( $options_store_setting );
	
?>

<div class="devsite-wrapper">
	<div class="devsite-top-section-wrapper">
		<?php include('header.php'); ?>
	   
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">API Keys & Ids</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group" style="display:;">
					<div class="card1"></div>
					<div class="card">
					<?php 
					$store = isset($options_store_setting['storename']) ?  '['.esc_attr($options_store_setting['storename']).']' : '['.$_SERVER[HTTP_HOST].']'; 
					$subject =$store.' API details for JAXTO Marketplace';
					?>
					<h6>Please submit API Keys of your Payment,Shipping and other plugin <a href="mailto:jaxto@twistmobile.in?Subject=<?php echo $subject ?>">here</a> for native integration.</h6>
					
					<small>Note:Please check the plugins supported by JAXTO in <a href="?page=wordpress-jaxto-plugin-supported">PLUGINS SUPPORTED</a> tab.</small>
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
