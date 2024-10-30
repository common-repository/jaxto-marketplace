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
	
	$assets_setup_base_url = JAXTO_PLUGIN_URL . 'assets/img/';
	$options_woo_setting = get_option( 'jaxto_woo_settings_data' );
	$options_woo_setting = maybe_unserialize( $options_woo_setting );
	
	$options_store_setting = get_option( 'jaxto_store_settings_data' );
	$options_store_setting = maybe_unserialize( $options_store_setting );
	
	$options_app_setting= get_option( 'jaxto_app_settings_data' );
	$options_app_setting = maybe_unserialize( $options_app_setting );
	
	$style_1 =$assets_setup_base_url.'play/style_1.png';
	$style_2 =$assets_setup_base_url.'play/style_2.png';
	$style_3 =$assets_setup_base_url.'play/style_3.png';
	$style_4 =$assets_setup_base_url.'play/style_4.png';
	
	$pid =isset($options_woo_setting['userpid']) ?  esc_attr($options_woo_setting['userpid']) : '';
	$type =isset($options_store_setting['type']) ?  esc_attr($options_woo_setting['type']) : '';
	
	
	$isfooter =true;
	if(get_option('jaxto_app_link_footer') =='true')
		$isfooter =true;
	else
		$isfooter =false;

	$ismenu =true;
	if(get_option('jaxto_app_link_menu')=='true')
		$ismenu =true;
	else
		$ismenu =false;
	
	$linkstyle ="style-1";
	if(get_option('jaxto_app_link_style') =="style-1")
		$linkstyle =get_option('jaxto_app_link_style');
	else if(get_option('jaxto_app_link_style') =="style-2")
		$linkstyle =get_option('jaxto_app_link_style');
	else if(get_option('jaxto_app_link_style') =="style-3")
		$linkstyle =get_option('jaxto_app_link_style');
	else if(get_option('jaxto_app_link_style') =="style-4")
		$linkstyle =get_option('jaxto_app_link_style');
	
	$linkalign ='left';
	if(get_option('jaxto_app_style_align') =="left")
		$linkalign ='left';
	else if(get_option('jaxto_app_style_align') =="center")
		$linkalign ='center';
	else if(get_option('jaxto_app_style_align') =="right")
		$linkalign ='right';
	//echo get_option('jaxto_app_style_align');
?>

<div class="devsite-wrapper">
	<div class="devsite-top-section-wrapper">
		<?php include('header.php'); ?>
		
		
		<?php 
		if($pid !=="" && $type !=="")
		{
			$actual_link = "http://$_SERVER[HTTP_HOST]";
			//$applink ="http://www.jaxto.in/appuri.php/?".urlencode("pid=$pid");
			$applink ="https://play.google.com/store/apps/details?id=com.jaxto&referrer=".urlencode("pid=$pid");
		?>
		
		<div class="devsite-main-content half-col clearfix" id="app_link" style="margin-top: 0px;">
			
			<div class=" clearfix" style="margin-top: 0px;">
				<section class="devsite-landing-row devsite-landing-row-1-up">
					<header class="devsite-landing-row-header">
						<div class="devsite-landing-row-header-text">
							<h2 id="firebase-by-platform">Store App Link</h2>
						</div>
						<div class="md-ripple-container"><b></b></div>
					</header>
				</section>
				
				<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
					<div class="devsite-landing-row-group">
						<div class="card1"></div>
						<div class="card">
						
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								
								<div class="form-group">
									<label><h5>Start Marketing your Mobile App</h5></label>
									<div class="cls_padding_left"><input type="text" class="textLink" id="copyAppLinkText" value="<?php echo $applink; ?>" disabled />
									<button data-copy="copyAppLinkText" id="copyAppLink">Copy</button></div>
									<div class="cls_padding_left"><a href="<?php echo $applink; ?>" target="_blank">Click Here</a> to go this link</div>
								</div>
								
							</div>
						</div>
					</div>
				</section>
			</div>
			
			<div class=" clearfix" style="margin-top: 0px;">
				<section class="devsite-landing-row devsite-landing-row-1-up">
					<header class="devsite-landing-row-header">
						<div class="devsite-landing-row-header-text">
							<h2 id="firebase-by-platform">QR Code to Download Android App</h2>
						</div>
						<div class="md-ripple-container"><b></b></div>
					</header>
				</section>
				
				<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
					<div class="devsite-landing-row-group">
						<div class="card1"></div>
						<div class="card">
						
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								
								<div class="form-group">
									<div class="cls_padding_left"><?php echo do_shortcode('[jaxto-qrcode-app-link]'); ?></div>
								</div>
								
							</div>
						</div>
					</div>
				</section>
			</div>
			
			<div class=" clearfix" style="margin-top: 0px;">
			
				<section class="devsite-landing-row devsite-landing-row-1-up">
					<header class="devsite-landing-row-header">
						<div class="devsite-landing-row-header-text">
							<h2 id="firebase-by-platform">Shortcode and Widgets</h2>
						</div>
						<div class="md-ripple-container"><b></b></div>
					</header>
				</section>
				
				<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
					<div class="devsite-landing-row-group">
						<div class="card1"></div>
						<div class="card">
						
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image">
								
								<h5>App Shortcode for Html </h5>
								<div class="cls_padding_left"><b>Android App Link</b> <br>[jaxto-app-link]</div><br/>
								<div class="cls_padding_left"><b>QR Code</b> <br>[jaxto-qrcode-app-link]</div><br/>
								
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image">
								
								<h5>App Widget</h5>
								<img src="<?php echo $assets_setup_base_url . '/widget.png';?>" /><br/><br/><br/>
							</div>
						</div>
					</div>
				</section>
			</div>
			
			<div class=" clearfix" style="margin-top: 0px;">
				<section class="devsite-landing-row devsite-landing-row-1-up">
					<header class="devsite-landing-row-header">
						<div class="devsite-landing-row-header-text">
							<h2 id="firebase-by-platform">App Link on Main Menu & Footer</h2>
						</div>
						<div class="md-ripple-container"><b></b></div>
					</header>
				</section>
				
				<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
					<div class="devsite-landing-row-group">
						<div class="card1"></div>
						<div class="card">
						
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<form method="post" id="jaxto_link_style" name="jaxto_link_style" action="">
									<div class="form-group2">
										<label><input type="checkbox" name="integrateToMenu" <?php if($ismenu=='true'){?>checked="checked"<?php } ?> /><b>Integrate on Main Menu</b></label><br>
									</div>
									<div class="form-group2">
										<label><input type="checkbox" name="integrateToFooter" <?php if($isfooter=='true'){?>checked="checked"<?php } ?> /><b>Integrate on Footer</b></label><br>
									</div>
									<div class="form-group2">
										<label class="col-3">
										<input type="radio" name="appLinkType" value="style-1" <?php if($linkstyle=='style-1'){?>checked="checked"<?php } ?>/><b>Style 1</b>
										<img src="<?php echo $style_1; ?>" height="50px" alt="MYApp Launch"></label>
										
										<label class="col-3"><input type="radio" name="appLinkType" value="style-2" <?php if($linkstyle=='style-2'){?>checked="checked"<?php } ?>/><b>Style 2</b>
										<img src="<?php echo $style_2; ?>" height="50px" alt="MYApp Launch"></label>
										
										<label class="col-3"><input type="radio" name="appLinkType" value="style-3" <?php if($linkstyle=='style-3'){?>checked="checked"<?php } ?>/><b>Style 3</b>
										<img src="<?php echo $style_3; ?>" height="50px" alt="MYApp Launch"></label>
										
										<label class="col-3"><input type="radio" name="appLinkType" value="style-4" <?php if($linkstyle=='style-4'){?>checked="checked"<?php } ?>/><b>Style 4</b>
										<img src="<?php echo $style_4; ?>" height="50px" alt="MYApp Launch"></label>
									</div><br><br>
									<div class="form-group2"><br><br>
									<b>Image Alignment</b><br/>
										<label class="col-3"><input type="radio" name="appLinkAlign" value="left" <?php if($linkalign=='left'){?>checked="checked"<?php } ?>/><b>Left</b></label>
										
										<label class="col-3"><input type="radio" name="appLinkAlign" value="center" <?php if($linkalign=='center'){?>checked="checked"<?php } ?>/><b>Center</b></label>
										
										<label class="col-3"><input type="radio" name="appLinkAlign" value="right" <?php if($linkalign=='right'){?>checked="checked"<?php } ?>/><b>Right</b></label>
										<label class="col-3"></label>
									</div><br><br>
									<?php wp_nonce_field( 'jaxto_link_style' ); ?>
									<div class="form-group" id="jaxto_form_footer">
										<div class="md-ripple-container"><button class="editbutton" data-form="jaxto_link_style" type="button"> Edit </button></div>
									</div>
								</form>
							</div>
							
						</div>
					</div>
				</section>
			</div>
		</div>
		
		
		<?php
		}
		else
		{
		?>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Jaxto Test App Link</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
							<div class="form-group">
								<label><h5>Jaxto Test App Link</h5></label>
								<div class="cls_padding_left"><a href="https://play.google.com/store/apps/details?id=com.jaxto" target="_blank">https://play.google.com/store/apps/details?id=com.jaxto</a></div>
							</div> <br />
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">App</h2>
					</div>
					<div class="md-ripple-container"><b></b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
					<div class="card1"></div>
					<div class="card">
					
						<div class="devsite-landing-row-item devsite-landing-row-item-no-image">
							<h6>STEP 1 -: Configure WooComerce.</h6>
							<h6>STEP 2 -: Configure Store Details</h6>
							<h6>STEP 3 -: Configure APP Details</h6>
							<h6><a href="?page=wordpress-jaxto-store">Click Here</a> to complete all three steps in configuration</h6>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php
		}
		?>
	</div>
</div> 
<?php
}
jaxto_component_jaxto_plugin_settings();

// --------------------------------------------------------------------	
