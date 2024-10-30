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
	
	$ion =isset($options_woo_setting['type']) ?  'display: inline-block;' : 'display:none;';
	
	$pid =isset($options_woo_setting['userpid']) ?  esc_attr($options_woo_setting['userpid']) : '';
	$type =isset($options_store_setting['type']) ?  esc_attr($options_woo_setting['type']) : '';
?>
<div class="devsite-wrapper">
	<div class="devsite-top-section-wrapper">
		<?php include('header.php'); ?>
	</div>
</div>
	
<div class="devsite-wrapper">
	<div class="devsite-top-section-wrapper">
	   <div class="devsite-main-content half-col clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Configure Woocommerce</h2>
					</div>
					<div class="md-ripple-container"><b>Step 1</b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group" style="display:;">
					<div class="card1"></div>
					<div class="card">
						<form method="post" id="jaxto_wo_setup_form" name="jaxto_wo_setup_form" action="">
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<div class="input-container">
									<input type="text" name="txtusername" id="txtusername" value="<?php echo isset($options_woo_setting['username']) ?  esc_attr($options_woo_setting['username']) : ''; ?>" autocomplete="off" required="required"/>
									<label for="txtusername">Username</label>
									<div class="bar"></div>
								</div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<div class="input-container">
									<input type="text" name="txtemail" id="txtemail" value="<?php echo isset($options_woo_setting['email']) ?  esc_attr($options_woo_setting['email']) : ''; ?>" autocomplete="off" required="required"/>
									<label for="txtemail">Email</label>
									 
									<div class="bar"></div>
								</div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<div class="input-container">
									<input type="text" name="txtwebsite" id="txtwebsite" value="<?php echo isset($options_woo_setting['website']) ?  esc_attr($options_woo_setting['website']) : ''; ?>" autocomplete="off" required="required"/>
									<label for="txtwebsite">Website URL</label>
									<div class="bar"></div>
								</div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<div class="input-container">
									<input type="text" name="txtwc-api-key" id="txtwc-api-key" value="<?php echo isset($options_woo_setting['apikey']) ?  esc_attr($options_woo_setting['apikey']) : ''; ?>" autocomplete="off" required="required"/>
									<label for="txtwc-api-key">Woocommerce API Consumer Key</label>
									<div class="bar"></div>
								</div>
								<div class="tooltip"><i id="tooltipbox_key" class="fa fa-question-circle"><span class="tooltiptext">How to get Woocommerce API Consumer Key</span></i></div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<div class="input-container">
									<input type="text" name="txtwc-api-secret" id="txtwc-api-secret" value="<?php echo isset($options_woo_setting['apisecret']) ?  esc_attr($options_woo_setting['apisecret']) : ''; ?>" autocomplete="off" required="required"/>
									<label for="txtwc-api-secret">Woocommerce API Consumer Secret </label>
									<div class="bar"></div>
								</div>
								<div class="tooltip"><i id="tooltipbox_sec" class="fa fa-question-circle"><span class="tooltiptext">How to get Woocommerce API Consumer Secret</span></i></div>
							</div>
							<input type="hidden" name="txtsiteurl" value="<?php echo get_bloginfo('url');?>"/>
							<div class="devsite-landing-row-item1 devsite-landing-row-item-no-image full" id="jaxto_form_footer">
								<?php 
								if(!isset($options_woo_setting['type']))
								{
								?>
								<input type="submit" value="Submit" class="cmdSubmitWoData" id="save-jaxto-settings"/>
								<?php
								}
								else
								{
								?>
								<div class="md-ripple-container"><button class="editbutton" data-form="jaxto_wo_setup_form" type="button"> Edit </button></div>
								<?php
								}
								?>
							</div>
							<?php wp_nonce_field( 'jaxto_wo_setup_form' ); ?>
						</form>
					</div>
				</div>
			</section>
		</div>
		
		<?php
		$str = file_get_contents("http://jaxto.in/api/list.json");
		$json = json_decode($str, true);
		
		$category =$json['category'];
		$deliveryLocation =$json['region'];
		$keywords =json_encode($json['keywords']);
		
		$colortopheader         = isset($options_app_setting['colortopheader']) ?  esc_attr($options_app_setting['colortopheader']) :'#0294ca';
		$colorheader            = isset($options_app_setting['colorheader']) ?  esc_attr($options_app_setting['colorheader']) :'#03aeef';
		$app_font_color         = isset($options_app_setting['app_font_color']) ?  esc_attr($options_app_setting['app_font_color']) :'#ffffff';
		$app_button_color       = isset($options_app_setting['app_button_color']) ?  esc_attr($options_app_setting['app_button_color']) :'#03aeef';
		$app_button_text_color  = isset($options_app_setting['app_button_text_color']) ?  esc_attr($options_app_setting['app_button_text_color']) :'#ffffff';
		$selected_button_text_color  = isset($options_app_setting['selected_button_text_color']) ?  esc_attr($options_app_setting['selected_button_text_color']) :'#ffffff';
		$selected_button_color  = isset($options_app_setting['selected_button_color']) ?  esc_attr($options_app_setting['selected_button_color']) :'#0294ca';
		
		$applogo = isset($options_app_setting['logourl']) ?  esc_attr($options_app_setting['logourl']) : '';
	
		?>
		<div class="devsite-main-content half-col clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Store Details</h2>
					</div>
					<div class="md-ripple-container"><b>Step 2</b></div>
				</header>
			</section>
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">
				<div class="devsite-landing-row-group" id="row_group_store" style="<?php echo $ion; ?>">
					  <div class="card1"></div>
					  <div class="card">
					  
						<form method="post" id="jaxto_store_form" name="jaxto_store_form" action="#">
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<label for="txtemail">Store Name</label>
								<div class="input-container">
									<input type="text" name="txtstorename" id="txtstorename" placeholder="<?php echo $_SERVER[HTTP_HOST]; ?>" value="<?php echo isset($options_store_setting['storename']) ?  esc_attr($options_store_setting['storename']) : ''; ?>"  autocomplete="off" required="required"/>
									<div class="bar"></div>
								</div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<label for="txtemail">Store Description</label>
								<div class="input-container">
									<input type="text" name="txtstoredesc" id="txtstoredesc" placeholder="Write here about yout store"  value="<?php echo isset($options_store_setting['storedesc']) ?  esc_attr($options_store_setting['storedesc']) : ''; ?>" autocomplete="off" required="required"/>
									<div class="bar"></div>
								</div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image">
								<div class="layout-row"><label>Store Category</label></div>
								<div class="input-container">
									<select class="md-select selectpicker" name="txtstorecategory" id="txtstorecategory" data-width="100%" data-live-search="true">
										<option value="">Select Category</option>
										<?php
										$mycategory = isset($options_store_setting['storecategory']) ?  esc_attr($options_store_setting['storecategory']) : '';
										foreach($category as $categoryname)
										{
										?>
										<option value="<?php echo strtolower($categoryname); ?>" <?php if(strtolower($categoryname)==$mycategory){ ?> selected="selected" <?php } ?>><?php echo ucfirst($categoryname); ?></option>
										<?php
										}
										?>
									</select>
								  </div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image">
								<div class="layout-row"><label>Store Country</label></div>
								<div class="input-container">
									<select class="md-select selectpicker" name="txtstorelocation" id="txtstorelocation" data-width="100%" data-live-search="true">
										<option>Select Store Country</option>
										<?php
										$slocation =isset($options_store_setting['storelocation']) ?  esc_attr($options_store_setting['storelocation']) : '';
										foreach($deliveryLocation as $mylocation)
										{
										?>
										<option value="<?php echo $mylocation['id']; ?>" <?php if($mylocation['id'] ==$slocation){ ?> selected="selected" <?php } ?>><?php echo $mylocation['n']; ?></option>
										<?php
										}
										?>
									</select>
								  </div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<div class="layout-row"><label>Shipping/Delivery Countries</label></div>
								<div class="input-container">
									<select class="md-select selectpicker" data-placeholder="Select an option" name="txtdeliverylocation" id="txtdeliverylocation" data-width="100%" multiple>
										<?php
										$dlocation = isset($options_store_setting['deliverylocation']) ?  esc_attr($options_store_setting['deliverylocation']) : '';
										
										$dlocation = explode(',',$dlocation);
										
										foreach($deliveryLocation as $delivery)
										{
										?>
										<option value="<?php echo $delivery['id']; ?>" <?php if(in_array($delivery['id'], $dlocation)){ ?> selected="selected" <?php } ?>><?php echo $delivery['n']; ?></option>
										<?php
										}
										?>
									</select>
								  </div>
							</div>
							
							<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
								<div class="layout-row"><label>Keywords</label></div>
								<div class="input-container">
									<input type="hidden" name="txtkeywords" id="mySingleField" value="<?php echo isset($options_store_setting['keywords']) ?  esc_attr($options_store_setting['keywords']) : ''; ?>">
									<ul id="singleFieldTags"></ul>
									<div class="bar"></div>
								  </div>
							</div>
							<input type="hidden" name="txtsiteurl" value="<?php echo get_bloginfo('url');?>"/>
							<?php wp_nonce_field( 'jaxto_store_form' ); ?>
							<div class="devsite-landing-row-item1 devsite-landing-row-item-no-image full" id="jaxto_form_footer">
								<?php 
								if(!isset($options_store_setting['type']))
								{
								?>
								<input type="submit" value="Submit" class="cmdSubmitStoreData" id="save-jaxto-settings" />
								<?php
								}
								else
								{
								?>
								<div class="md-ripple-container"><button class="editbutton" data-form="jaxto_store_form" type="button"> Edit </button></div>
								<?php
								}
								?>
								
								
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">APP Details</h2>
					</div>
					<div class="md-ripple-container"><b>Step 3</b></div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">
				
				<div class="devsite-landing-row-group" id="row_group_app" style="background: #ffffff;width: 100%;<?php echo $ion; ?>">
					<div class="devsite-landing-row-item devsite-landing-row-item-no-image" id="layoutSetting">
						<form method="post" id="jaxto_app_form" name="jaxto_app_form" action="#">
						
							<div class="form-group">
								<label>Store Logo</label>
								<img id="blah" src="<?php if($applogo=='') { echo plugins_url().'/jaxto/assets/img/noimage.png';}else{ echo $applogo; } ?>" alt="No Image" height="50px"/>
								<button type="button" id="insert-my-media" class="fileUpload" data-editor="txtlogourl"> Upload Logo</button>
								(Recommended size-512x512)
							</div>
							<input type="hidden" name="txtlogourl" id="txtlogourl" value="<?php echo $applogo; ?>"/>
							
							<div class="form-group">
								<label>App Theme Color</label>
								<input type="text" class="form-control" id="colorheader" name="colorheader" value="<?php echo $colorheader;?>" />
							</div>
							
							<div class="form-group">
								<label>Status Bar Color</label>
								<input type="text" class="form-control" id="colortopheader" name="colortopheader" value="<?php echo $colortopheader;?>"  />
							</div>

							<div class="form-group">
								<label>App Font Color</label>
								<input type="text" class="form-control" id="app_font_color" name="app_font_color"  value="<?php echo $app_font_color;?>" />
								<div class="bar"></div>
							</div>

							<div class="form-group">
								<label>Button Color</label>
								<input type="text" class="form-control" id="app_button_color" name="app_button_color"  value="<?php echo $app_button_color;?>" />
								<div class="bar"></div>
							</div>

							<div class="form-group">
								<label>Button Text Color</label>
								<input type="text" class="form-control" id="app_button_text_color" name="app_button_text_color" value="<?php echo $app_button_text_color;?>"  />
								<div class="bar"></div>
							</div>

							<div class="form-group">
								<label>Selected Button Color</label>
								<input type="text" class="form-control" id="selected_button_color" name="selected_button_color"  value="<?php echo $selected_button_color;?>" />
								<div class="bar"></div>
							</div>
							
							<div class="form-group">
								<label>Selected Button Font Color</label>
								<input name="selected_button_text_color" id="selected_button_text_color" value="<?php echo $selected_button_text_color;?>" type="text" class="form-control iris-color" />
								<div class="bar"></div>
							</div>
							<?php wp_nonce_field( 'jaxto_app_form' ); ?>
							<input type="hidden" name="txtsiteurl" value="<?php echo get_bloginfo('url');?>"/>
							<br>
							<div class="form-group" id="jaxto_form_footer">
							<?php 
							if(!isset($options_app_setting['type']))
							{
							?>
							<input type="submit" value="Submit" class="cmdSubmitAppData" id="save-jaxto-settings" />
							<?php
							}
							else
							{
							?>
							<button class="editbutton" type="button" data-form="jaxto_app_form"> Edit </button>
							<?php
							}
							?>
							</div>
						</form>	
					</div>
					
					<div class="devsite-landing-row-item devsite-landing-row-item-no-image">
						<!--<div id="phone_area" style="position: relative; display: inline-block;">-->
							<div id="phone_placeholder" style="background-repeat: no-repeat; width: 345px; height: 700px;">
								<div id="iphone_5_emulator" style="background-repeat: no-repeat;">
									<div id="frame_iphone_5_emulator" style="padding: 0" class="frame_scroller">
										<div id="myframe" style="background-color: #fff;">
											<div>		
												<div id="colortopheader" style=" height:10px; background: #0294ca;"></div>
												<div id="colorheader" style="height: 50px; padding:0; background: #00aff0;margin-top: 0px;">
													<div id="app_font_color" style="color:#fff; font-size:18px; line-height:50px">
														<div class="main_title pull-left" style="font-size:20px;">
															<i class="fa  fa-navicon" style="margin:0px 10px;"></i>Jaxto Store 
														</div>
														<div class="pull-right">
														<i class="fa fa-shopping-cart" style="margin:0px 10px;"></i>
														<i class="fa fa-heart-o" style="margin:0px 10px;"></i>
														<i class="fa fa-search" style="margin:0px 10px;"></i>
														</div>
													</div>
												</div>
											</div>
											<div class="container1">
											<!-- Example row of columns -->
												<div class="row" style="background-color: #fafafa;">
													<div class="col-md-12" >
														<div class="content-area">
															<div class="col-md-12">
																<div class="content-area">
																	<img src="http://manage.thetmstore.com/public/images/picture.jpg" class="img-model" style=" display:block; margin:auto; margin-top:4px;">
																	<div class="description" style="padding-top: 15px;">
																		<span style="display:inline-block;  color:#424242; width:80%">
																		<b > Cool Summer Blue Top </b>
																		</span>   
																		<span style="color: red; font-size: 17px; display:inline-block">$ 999</span>
																	</div>
																	<hr style="margin-top: 12px; margin-bottom: 12px; border: 1px; border-top: 1px solid #000;" >
																	<div class="size-info">
																		<span style="display:inline-block;  color:#424242; width:50%"> 
																		<h4 style=" color:#424242; "> Size: M   </h4> </span>
																		<span style="display:inline-block; color:#424242"> <h4>Color: Blue</h4></span>
																		<hr style="margin-top: 10px; margin-bottom: 12px; border-top: 1px solid #000;">
																	</div>
																	<a id="mybutton" class="btn btn-default" href="javascript:void(0)"  role="button" style="background-color:#03aeef;color: #ffffff; display:block;font-size:120%; text-decoration:none;">
																	<b  id="buytext">BUY</b>
																	</a>
																	<hr style="margin-top: 12px; margin-bottom: 12px; border-top: 1px solid #000;">
																	<h4 style=" color:#424242;">Product Description:</h4>
																	<p style=" color:#424242;" class="info-text">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac.   </p>
																</div>
																<!--content-area-->
															</div>
														</div>
													</div>
													<hr/>
												</div>
											</div>
											<!--container1-->
										</div>
									</div>
								</div>
							</div>
						<!--</div>-->
					</div>
				</div>
			</section>
		</div>
		
		<div class="devsite-main-content clearfix" style="margin-top: 0px;" id="apphelp">
			<section class="devsite-landing-row devsite-landing-row-1-up">
				<header class="devsite-landing-row-header">
					<div class="devsite-landing-row-header-text">
						<h2 id="firebase-by-platform">Follow below Steps to complete your Configration of WooCommerce API:</h2>
					</div>
				</header>
			</section>
			
			<section class="devsite-landing-row devsite-landing-row-3-up devsite-landing-row-light-grey firebase-hp-rowgroup gmp-icons-container1 gmp-icons-container-grayscale">	
				<div class="devsite-landing-row-group">
				<div class="card1"></div>
					<div class="card">
						<div class="devsite-landing-row-item devsite-landing-row-item-no-image">
							<p>Step 1: Fill form above with unique username, email and website url for which you need mobile app.</p>

							<p>Step 2: JAXTO Store plugin requires WooCommerce Consumer/Secert Keys to create application.</p>

							<p>Simple steps for getting WooCommerce Consumer Key and Secert Key.</p>

							<p>Step 2.1 You enable REST API access in WooCommerce Plugin.</p>

							<p>Step 2.2 You create new KEY in WooCommerce and give access of read/write in it.</p>

							<p>Step 2.3 Then you copy/paste API code in JAXTO Store plugin</p>

							<p>Detailed steps to get WooCommerce "CONSUMER KEY" and "CONSUMER SECRET".</p>

							<p>a. Open new window on web browser of Wordpress Admin Panel to follow below steps.</p>

							<p>b. Go to WooCommerce Plugin in new window and find WooCommerce &gt; Settings &gt; API</p>

							<p>c. In "API" Page, find Settings, Keys/Apps, and Webhooks Tabs.</p>

							<p>d. Go to "Settings" tab, Click on "Enable REST API" and then click on "Save Changes".</p>

							<p>e. Go to WooCommerce &gt; Settings &gt; API &gt; Key/Apps &gt; Add Key. Click Button Add Key.</p>

							<p>f. Add Key Name and Set Read/Write permission in permission field.</p>

							<p>g. Press "Generate API Key" button</p>

							<p>h. Nice now you have Consumer Key and Consumer Secert with you.</p>

							<p>i. Just Copy paste them in Jaxto Store Plugin form.</p>

							<p>j. Incase of problem email. <a href="mailto:jaxto@twistmobile.in">jaxto@twistmobile.in</a></p>

							<p>Step 3: Just press Submit and wait for Demo Mobile app.</p>

							<p>Step 4: Once you approve Demo App we will create thetmstore free account for your application.</p>

							<p>Step 5: Start publishing your App in Google Play and iOS App Store.</p>
						</div>
												
						<div class="devsite-landing-row-item devsite-landing-row-item-no-image full">
						<p>Incase of any issues in understanding the above steps, Please email us at <a href="mailto:jaxto@twistmobile.in">jaxto@twistmobile.in</a>
						Also please note in order to allow the Mobile App APIs to work properly please do not set the "Permalink Settings" to "Plain options".</p>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div> 
<script>
<?php
if(isset($options_woo_setting['type']))
{
?>
var formid ='#jaxto_wo_setup_form';
jQuery(formid+' input').prop('disabled', true);
jQuery(formid+' label').css('top', '-18px');
jQuery(formid+' label').css('font-size', '12px');
<?php
}
if(isset($options_store_setting['type']))
{
?>
var formid ='#jaxto_store_form';
jQuery(formid+' input').prop('disabled', true);
jQuery(formid+' label').css('top', '-18px');
jQuery(formid+' label').css('font-size', '12px');
jQuery(formid+' select').attr('disabled','disabled');
<?php
}
if(isset($options_app_setting['type']))
{
?>
var formid ='#jaxto_app_form';
jQuery(formid+' input').prop('disabled', true);
jQuery(formid+' label').css('top', '-18px');
jQuery(formid+' label').css('font-size', '12px');
<?php
}
?>
keywords_list =<?php echo $keywords; ?>;
</script>
<?php
}

jaxto_component_jaxto_plugin_settings();

// --------------------------------------------------------------------	
