<?php
/**
 * JAXTO Marketplace
 * @package JAXTO
 * @author  JAXTO
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class jaxto_main_class{
	

	/**
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.1.0';
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * Unique identifier for plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	public $plugin_slug = 'wordpress-jaxto-store';
	
	public $api_endpoint_base = 'wp-jaxto-store-notify/api';
	
	public $allowed_post_types = array( 'plugin-active', 'social-login', 'register', 'login', 'forget-password','cart_items','countries_list',
	                                    'splash_products','login_website','load_products','pole_products','calculate_shipping','woo_version',
										'filter_data_price','filter_data_attribute','add_coupon','filter_products','product_variation_price',
										'filter_all_products','menu_data','payment_gateway_list','exship_data');

	/**
	 * Initialize the plugin by setting localization, filters.
	 *
	 * @since     1.0.0
	 */

	public $platform_ = 'web';
	public $user_platform = ''; // Default
	function __construct() {
		
		// Database variables
		global $wpdb;
		$this->db 					= &$wpdb;
	    add_action( 'admin_init', array( &$this, 'jaxto_register_settings' ) );	
		add_action( 'woocommerce_thankyou', array( &$this, 'jaxto_notify_tm_store_abt_new_order' ), 11, 1 );
		add_action( 'woocommerce_cancelled_order', array( &$this, 'jaxto_notify_tm_store_abt_new_order' ), 11, 1 );
		
		add_action( 'wp_ajax_save_jaxto_wo_data', array( &$this, 'jaxto_save_jaxto_data' ) );	
		add_action( 'wp_ajax_save_jaxto_storedetails', array( &$this, 'jaxto_save_store_data' ) );		
		add_action( 'wp_ajax_save_jaxto_appdetails', array( &$this, 'jaxto_save_app_data' ) );		
		
		add_action( 'wp_ajax_save_jaxto_app_style', array( &$this, 'jaxto_app_style' ) );		
		
		add_action( 'init', array( &$this, 'jaxto_add_api_endpoint' ) );
		add_action( 'template_redirect', array( &$this, 'jaxto_handle_api_endpoints' ) );
		add_action( 'init', array( &$this, 'jaxto_set_checkout_page_cookie' ) );
		add_action( 'jaxto_admin_ui_footer_end', array( &$this, 'jaxto_add_support_link' ) );
		
	}
	
	
	/**
	 * Function to register activation actions
	 * 
	 * @since 1.0.0
	 */
	function jaxto_plugin_activate(){
			
		//Check for WooCommerce Installment
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) and current_user_can( 'activate_plugins' ) ) {
			// Stop activation redirect and show error
			wp_die('Sorry, but this plugin requires the Woocommerce to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
		}
		update_option('jaxto_plugin_activate', true);
		
		$data = array(
						'site_url' => get_bloginfo('url'),
						'plugin_version' =>'1.1.0',
					); 
					
		$args = array(
			'body' => $data,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'cookies' => array()
		);
		$response = wp_remote_post( 'http://jaxto.in/api/pluginUrlDetails.php', $args );
	}	
   
 	/**
	 * Function to register deactivation actions
	 * 
	 * @since 1.0.0
	 */
	function jaxto_plugin_deactivate_plugin(){ 
	
		delete_option('jaxto_plugin_activate');
		delete_option('jaxto_settings');
	}
	
	function jaxto_add_support_link(){
		echo '<p style="float: right;">For more Details or Queries regarding JAXTO Plugin, Contact Us <a href="mailto:jaxto@twistmobile.in">jaxto@twistmobile.in</a></p>';
	}
	
	/**
	 * Function to register the plugin settings options
	 * 
	 * @since 1.0.0
	 */
	public function jaxto_register_settings() {
		register_setting('jaxto_register_settings', 'jaxto_settings' );
	}	
	
	/**
	 * Function to get end-point of API
	 * 
	 * @since 1.0.0
	 */
	function jaxto_getApiUrl(){
		if(file_exists(plugin_dir_path( __FILE__ ).'config.txt')){
			$response = file_get_contents(plugin_dir_path( __FILE__ ).'config.txt');
			$response = json_decode($response);
			if(!empty($response)){
				return $response->api_endpoint;
			}
		} 
	}
	/**
	 * Function to get userkey
	 * 
	 * @since 1.0.0
	 */
	public function jaxto_getUserKey(){
		$sq_options = get_option('jaxto_settings');
		$user_key = $sq_options['user_key'];
		return $user_key;
	}

	/**
	 * Function to check if plugin is enabled
	 * 
	 * @since 1.0.0
	 */
     public function jaxto_isEnabled(){
		$sq_options = get_option('jaxto_settings');
		$enable = $sq_options['enable'];
		return $enable;
	}	
	
	
	function jaxto_set_checkout_page_cookie(){
		
		if(isset($_REQUEST['device_type'])){
		
			$device_type = (!empty($_REQUEST['device_type'])) ? $_REQUEST['device_type']: '';
			if(!empty($device_type)){
				$tm = intval( 3600 * 24 );
				setcookie("JAXTODEVICE", $device_type, time()+$tm, "/");
			}
		}
	}
	
	function jaxto_notify_tm_store_abt_new_order( $order_id  )
	{
		if(!empty($order_id))
		{
			global $current_user;
			get_currentuserinfo();
			$user_email_id=$current_user->user_email;
			global $woocommerce;
			$order = new WC_Order( $order_id );
			$order_status = $order->get_status();
			$user_platform = (isset($_COOKIE['JAXTODEVICE'])) ? $_COOKIE['JAXTODEVICE'] : '';   
			if(!empty($user_platform))
			{
			?>
				<script type="text/javascript">
				//<![CDATA[
				var orderid = <?php echo $order_id; ?>;    
				var orderstatus = '<?php echo $order_status; ?>';      
				function sendResponse_IOS(_key, _val) {
				var iframe = document.createElement("IFRAME"); 
				iframe.setAttribute("src", _key + ":##sendToApp##" + _val); 
				document.documentElement.appendChild(iframe); 
				iframe.parentNode.removeChild(iframe); 
				iframe = null; 
				}
				function sendResponse_ANDROID(resposne)
				{
				Android.showToast(""+resposne);
				} 
				//]]>
				</script>
			<?php
				if($user_platform == 'android')
				{
					//echo 'ggoogog';
				?>
					<script type="text/javascript">    
					var email_id = '<?php echo $user_email_id; ?>';
					Android.showToast("["+orderid + "]Purchase " + orderstatus+" emailid:"+email_id);    
					</script>
				<?php 
					exit();
				}
				if( $user_platform == 'ios' )
				{
				?>
					<script type="text/javascript">    
					sendToApp( "purchase","orderid:"+orderid + ",orderstatus:" + orderstatus);
					function sendToApp(_key, _val) 
					{
						var iframe = document.createElement("IFRAME"); 
						iframe.setAttribute("src", _key + ":##sendToApp##" + _val); 
						document.documentElement.appendChild(iframe); 
						iframe.parentNode.removeChild(iframe); 
						iframe = null; 
					}    
					</script>
				<?php 		
					exit();
					if(!strcmp($platform_,'mobile'))
					{
						exit();
					}
				}
			}
		}
	}
	
	
	function jaxto_app_style()
	{
		if(isset($_POST))
		{
			if(isset($_POST['style']) && $_POST['style'] !=='')
			{
				$style =sanitize_text_field($_POST['style']);
				update_option( 'jaxto_app_link_style', $style );
			}
			if(isset($_POST['isfooter']) && $_POST['isfooter'] !=='')
			{
				$isfooter =sanitize_text_field($_POST['isfooter']);
				update_option( 'jaxto_app_link_footer', $isfooter );
			}
			if(isset($_POST['ismenu']) && $_POST['ismenu'] !=='')
			{
				$ismenu =sanitize_text_field($_POST['ismenu']);
				update_option( 'jaxto_app_link_menu', $ismenu );
				
			}
			if(isset($_POST['style_align']) && $_POST['style_align'] !=='')
			{
				$style_align =sanitize_text_field($_POST['style_align']);
				update_option( 'jaxto_app_style_align', $style_align );
				
			}
			$response_array =  array('error' =>0);
		}
		else
		{
			$response_array =  array('error' =>1);
		}
		echo json_encode($response_array);
		exit;
	}
	
	
	function jaxto_save_jaxto_data()
	{
		$response_array =  array('results' => 0,'error' => 'Data not send.1');		
		if ( !current_user_can( 'manage_options' ))
		{
          	$response_array =  array( 'results' => 0, 'error' => 'Security error.3');
			$res = json_encode($response_array);
			die($res);
		}

		if(isset($_POST))
		{
			$nonce = $_POST['_wpnonce'];								
			if ( ! wp_verify_nonce( $nonce, 'jaxto_wo_setup_form' ) ) 
			{
				$response_array =  array( 'results' => 0,'error' => 'Security error.2');				
				$res = json_encode($response_array);
				die($res);
			}
			
			$data = $_POST; 
			$insertdata = array();
			$insertdata['username'] =  (isset($_POST['txtusername'])) ? sanitize_text_field($_POST['txtusername']) : '';
			$insertdata['email'] =  (isset($_POST['txtemail'])) ? sanitize_email($_POST['txtemail']) : '';
			$insertdata['website'] =  (isset($_POST['txtwebsite'])) ? esc_url_raw($_POST['txtwebsite']) : '';
			$insertdata['apikey'] =  (isset($_POST['txtwc-api-key'])) ? sanitize_text_field($_POST['txtwc-api-key']) : '';
			$insertdata['apisecret'] =  (isset($_POST['txtwc-api-secret'])) ? sanitize_text_field($_POST['txtwc-api-secret']) : '';
			$insertdata['siteurl'] =  get_bloginfo('url');
			$insertdata['type'] ='woo_data';
			
			$args = array(
				'body' => $insertdata,
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'cookies' => array()
			);
			 
			$response = wp_remote_post( 'http://jaxto.in/api/PluginFormDetails.php', $args );
			$responce =json_decode($response['body']);
			if($responce->status!=1 && $responce->status!=2)
			{
				$response_array =  array('results' => 0,'error' => $responce->status);
			} 
			else 
			{
				if(!is_serialized( $insertdata ) )
				{
					$insertdata['userpid']=$responce->pid;
					$insertdata = maybe_serialize( $insertdata );
					update_option( 'jaxto_woo_settings_data', $insertdata );
					
					$response_array =  array('results' => 1,'error' => $responce->status);
				}
				else
				{
					$response_array =  array('results' => 0,'error' => $responce->status);
				}
			}
		}
		
		$res =json_encode($response_array);
		die($res);
	}
	
	
	function jaxto_save_store_data()
	{		
		$response_array =  array('results' => 0,'error' => 'Data not send.1');
		
		$nonce = $_POST['_wpnonce'];
								
		if ( ! wp_verify_nonce( $nonce, 'jaxto_store_form' ) ) 
		{
			$response_array =  array( 'results' => 0,'error' => 'Security error.2');				
			$res = json_encode($response_array);
			die($res);
		}
		
		if ( !current_user_can( 'manage_options' ))
		{
          	$response_array =  array( 'results' => 0, 'error' => 'Security error.3');
			$res = json_encode($response_array);
			die($res);
		}
		
		if(isset($_POST))
		{		
			$data = $_POST; 
			$insertdata = array();
			$insertdata['siteurl'] =  get_bloginfo('url');
			$insertdata['storename'] =  (isset($_POST['txtstorename'])) ? sanitize_text_field($_POST['txtstorename']) : '';
			$insertdata['storedesc'] =  (isset($_POST['txtstoredesc'])) ? sanitize_text_field($_POST['txtstoredesc']) : '';
			$insertdata['storecategory'] =  (isset($_POST['txtstorecategory'])) ? sanitize_text_field($_POST['txtstorecategory']) : '';
			$insertdata['deliverylocation'] =  (isset($_POST['deliverylocation'])) ? sanitize_text_field($_POST['deliverylocation']) : '';
			$insertdata['storelocation'] =  (isset($_POST['txtstorelocation'])) ? sanitize_text_field($_POST['txtstorelocation']) : '';
			$insertdata['keywords'] =  (isset($_POST['txtkeywords'])) ? sanitize_text_field($_POST['txtkeywords']) : '';
			$insertdata['type'] ='store_data';
			
			$args = array(
				'body' => $insertdata,
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'cookies' => array()
			);
			 
			$response = wp_remote_post( 'http://jaxto.in/api/PluginFormDetails.php', $args );
			$responce =json_decode($response['body']);
			if($responce->status!=1)
			{
				$response_array =  array('results' => 0,'error' => $responce->status);
			} 
			else 
			{
				if(!is_serialized( $insertdata ) )
				{
					$insertdata = maybe_serialize( $insertdata );
					update_option( 'jaxto_store_settings_data', $insertdata );
					
					add_option( 'jaxto_app_link_style', 'style-1' ); 
					add_option( 'jaxto_app_link_footer', true);
					add_option( 'jaxto_app_link_menu', true );
					add_option( 'jaxto_app_style_align', 'left');
					
					$response_array =  array('results' => 1,'error' => $responce->status);
				}
				else
				{
					$response_array =  array('results' => 0,'error' => $responce->status);
				}
			}
			
		}
		$res =json_encode($response_array);
		die($res);
	}
	
	function jaxto_save_app_data(){
		
		
		$response_array =  array('results' => 0,'error' => 'Data not send.1');
		
		$nonce = $_POST['_wpnonce'];
								
		if ( ! wp_verify_nonce( $nonce, 'jaxto_app_form' ) ) 
		{
			$response_array =  array( 'results' => 0,'error' => 'Security error.2');				
			$res = json_encode($response_array);
			die($res);
		}
		
		if ( !current_user_can( 'manage_options' ))
		{
          	$response_array =  array( 'results' => 0, 'error' => 'Security error.3');
			$res = json_encode($response_array);
			die($res);
		}
		
		if(isset($_POST))
		{		
			$data = $_POST; 
			$insertdata = array();
			$insertdata['siteurl'] =  get_bloginfo('url');
			$insertdata['colorheader'] =  (isset($_POST['colorheader'])) ? sanitize_text_field($_POST['colorheader']) : '';
			$insertdata['colortopheader'] =  (isset($_POST['colortopheader'])) ? sanitize_text_field($_POST['colortopheader']) : '';
			$insertdata['app_font_color'] =  (isset($_POST['app_font_color'])) ? sanitize_text_field($_POST['app_font_color']) : '';
			$insertdata['app_button_color'] =  (isset($_POST['app_button_color'])) ? sanitize_text_field($_POST['app_button_color']) : '';
			$insertdata['app_button_text_color'] =  (isset($_POST['app_button_text_color'])) ? sanitize_text_field($_POST['app_button_text_color']) : '';
			$insertdata['selected_button_color'] =  (isset($_POST['selected_button_color'])) ? sanitize_text_field($_POST['selected_button_color']) : '';
			$insertdata['selected_button_text_color'] =  (isset($_POST['selected_button_text_color'])) ? sanitize_text_field($_POST['selected_button_text_color']) : '';
			$insertdata['logourl'] =  (isset($_POST['txtlogourl'])) ? esc_url_raw($_POST['txtlogourl']) : '';
			$insertdata['type'] ='app_data';
			
			$args = array(
				'body' => $insertdata,
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'cookies' => array()
			);
			
			$response = wp_remote_post( 'http://jaxto.in/api/PluginFormDetails.php', $args );
			$responce =json_decode($response['body']);
			if($responce->status!=1)
			{
				$response_array =  array('results' => 0,'error' => $responce->status);
			} 
			else 
			{
				if(!is_serialized( $insertdata ) )
				{
					$insertdata = maybe_serialize( $insertdata );
					update_option( 'jaxto_app_settings_data', $insertdata );
					
					$response_array =  array('results' => 1,'error' => $responce->status);
				}
				else
				{
					$response_array =  array('results' => 0,'error' => $responce->status);
				}
			}
		}
		$res =json_encode($response_array);
		die($res);
	}
	
	/**
	 * Create our json endpoint by adding new rewrite rules to WordPress
	 */
	function jaxto_add_api_endpoint(){
		
		global $wp_rewrite;
		
		$post_type_tag = $this->api_endpoint_base . '_type';
		$post_id_tag   = $this->api_endpoint_base . '_id';

		add_rewrite_tag( "%{$post_type_tag}%", '([^&]+)' );
		add_rewrite_tag( "%{$post_id_tag}%", '([0-9]+)' );

		add_rewrite_rule(
			$this->api_endpoint_base . '/([^&]+)/([0-9]+)/?',
			'index.php?'.$post_type_tag.'=$matches[1]&'.$post_id_tag.'=$matches[2]',
			'top' );

	
		add_rewrite_rule(
			$this->api_endpoint_base . '/([^&]+)/?',
			'index.php?'.$post_type_tag.'=$matches[1]',
			'top' );
			
		$wp_rewrite->flush_rules( false );
	}

	/**
	 * Handle the request of an endpoint
	 */
	function jaxto_handle_api_endpoints()
	{
		
		global $wp_query;

		// get the query args and sanitize them for confidence
		$type = sanitize_text_field( $wp_query->get( $this->api_endpoint_base . '_type' ) );
		$id   = intval( $wp_query->get( $this->api_endpoint_base . '_id' ) );
		
		// only allowed post_types
		if ( ! in_array( $type, $this->allowed_post_types ) ) {
			return;
		}

		switch ( $type ) {
			
			case "plugin-active":
				$data = $this->jaxto_api_plugin_activate_status_action( $_POST );
				break;
			case "social-login":
				$data = $this->jaxto_api_social_login_action( $_POST );
				break;
			case "register":
				$data = $this->jaxto_api_register_action( $_POST );
				break;
			case "login":
				$data = $this->jaxto_api_login_action( $_POST );
				break;
			case "forget-password":
				$data = $this->jaxto_api_forget_password_action( $_POST );
				break;
			case "cart_items":
			    $data=$this->jaxto_push_to_cart($_POST);
				break;
		    case "countries_list":
			   $data=$this->jaxto_get_countries_list( $_POST);
			   break;
			case "splash_products":
			   $data=$this->jaxto_get_woocommerce_product_list($_POST);
			   break;
			case "payment_gateway_list":
			   $data=$this->jaxto_get_available_payment_gateways();
			   break;
			case "login_website":
			   $data=$this->jaxto_login_website($_POST);
			   break;
			case "load_products":
			   $data=$this->jaxto_load_products();
			    break;
			case "pole_products":
			   $data=$this->jaxto_load_pole_products($_POST);
               break;				
			case "calculate_shipping":
			   $data=$this->jaxto_calculate_shipping();
			   break;
			case "woo_version":
			   $data=$this->jaxto_get_woo_version();
			   break;
			case "filter_data_price":
			   $data=$this->jaxto_filter_data_price();
		       break;
		   case "filter_data_attribute":
		       $data=$this->jaxto_filter_data_attribute();
		       break;
		   case "add_coupon":
		       $data=$this->jaxto_add_coupon_call($_POST);
		       break;
		   case "filter_products":
			$data=$this->jaxto_filter_products($_POST);
			break;
			case "product_variation_price":
			  $data=$this->jaxto_product_variation_price($_POST);
			break;
			case "filter_all_products":
			  $data=$this->jaxto_get_category_price_range($_POST);
			break;
			case "menu_data":
			   $data=$this->jaxto_get_menu_data();
			 break;
			 case "exship_data":
			   $data=$this->jaxto_get_exship_data($_POST);
			 break;
		}	
		// data is built. print as json and stop
		if(isset($data) && !empty($data)){
			
			echo json_encode($data);
			exit();
		} else {
			$data = array(
									'status' => 'failed',
									'error' => 1,
									'message' => 'No data received.'
								);
			
			echo json_encode($data);
			exit();
		}
		echo '';
		exit;
	}
	function escapeJsonString($value) 
	{
     
		$escapers =     array("\\",     "/",   "\"",  "\n",  "\r",  "\t", "\x08", "\x0c");
		$replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t",  "\\f",  "\\b");
		$result = str_replace($escapers, $replacements, $value);
		return $result;
    }

	function jaxto_push_to_cart($postData= array()) 
	{
		if(isset($postData))
		{
			global $woocommerce;
			$woocommerce->cart->empty_cart();
			$str='
			[
				{
					"pid":458,
					"variation_id":297,
					"quantity":3,
					"attributes":[
						{
							"name":"color",
							"value":"red"
						},
						{
							"name":"size",
							"value":"small"
						}
					]
				},
				{
					"pid":459,
					"variation_id":297,
					"quantity":1,
					"attributes":[
						{
							"name":"color",
							"value":"red"
						},
						{
							"name":"size",
							"value":"small"
						}
					]
				}
			]';
			
			$recived_str = stripslashes($postData['cart_data']);
			$json =json_decode($recived_str,true);
			for($i=0;$i<count($json);$i++)
			{
				$product_id=$json[$i]["pid"];
				
				$variation_id=$json[$i]['variation_id'];
				$quantity=$json[$i]['quantity'];
				
				$spec = array();
				
				for($j=0;$j<count($json[$i]['attributes']);$j++)
				{
					$spec[$json[$i]['attributes'][$j]['name']]=$json[$i]['attributes'][$j]['value'];
				}
				
				if($variation_id!=-1)
				{
					$woocommerce->cart->add_to_cart( $product_id, $quantity, $variation_id, $spec, null );
				}
				else
				{
					$woocommerce->cart->add_to_cart( $product_id, $quantity);
				}
			}
		}

		//apply coupon code here
		$recived_str_coupon = stripslashes($postData['coupon_data']);  
		
		$coupon_data =json_decode($recived_str_coupon,true);

		
		for($i=0;$i<count($coupon_data);$i++)
		{
		$this->jaxto_add_coupon($coupon_data[$i]['code']);
		}
		$shipping_methods=$this->jaxto_calculate_shipping($postData['ship_data']);
		$payment_gateWays=$this->jaxto_get_available_payment_gateways();			
		$arr_data = array("shipping_data" => $shipping_methods,"payment"=>$payment_gateWays);
		return  $arr_data;
	 }
	 
	 function jaxto_get_woo_version()
	 {
		 global $woocommerce;
		 $meta_data= array(
            'woo_version' => $woocommerce->version,
			'ssl_enabled'    	 => ( 'yes' === get_option( 'woocommerce_force_ssl_checkout' ) ),
            'permalinks_enabled' => ( '' !== get_option( 'permalink_structure' ) ),
			'tm_version'=>'1.1.0',
        );
		return $meta_data;
	 }
	 
	 function jaxto_get_metadata()
	 {
		 global $woocommerce;
         $cart_url = $woocommerce->cart->get_cart_url();
		 $checkout_url = $woocommerce->cart->get_checkout_url();
		 $meta_data= array(
            'tz'			 => wc_timezone_string(),
            'c'       	 => get_woocommerce_currency(),
            'c_f'    => get_woocommerce_currency_symbol(),
            't_i'   	 => ( 'yes' === get_option( 'woocommerce_prices_include_tax' ) ),
            'w_u'    	 => get_option( 'woocommerce_weight_unit' ),
            'd_u' 	 => get_option( 'woocommerce_dimension_unit' ),
			'd_s' =>get_option('woocommerce_price_decimal_sep'),
			't_s' =>get_option('woocommerce_price_thousand_sep'),
			'p_d'=>absint(get_option('woocommerce_price_num_decimals', 2)),
			'c_p'=>get_option( 'woocommerce_currency_pos'),
			'cart_url'=> $cart_url,
			'checkout_url'=>$checkout_url,
			'hide_out_of_stock'=>get_option( 'woocommerce_hide_out_of_stock_items' )
        );
		return $meta_data;
	 }
	 
	 function jaxto_login_website($postData = array())
	 {
		if(isset($postData) && !empty($postData['user_emailID']))
		{
			$email_id=$postData['user_emailID'];
			$user = get_user_by('email', $email_id);
			$user_id = $user->ID;
			if($user) 
			{
				wp_set_current_user( $user_id, $user->user_login );
				wp_set_auth_cookie( $user_id );
				do_action( 'wp_login', $user->user_login );
			}
		}		
	 }
	 
	 function jaxto_get_available_payment_gateways()
	 {
		$available_payment_gateways = WC()->payment_gateways()->get_available_payment_gateways();
		
		$gateway_list = array();
	    foreach($available_payment_gateways as $key => $gateway)
		{
			$account_details=array();
			for($i=0;$i<count($gateway->account_details);$i++)
			{
				if($gateway->account_details[$i]['account_name']!="")
				{
					array_push($account_details,$gateway->account_details[$i]);
				}
			}
			$advanced_cod_array=array();
			//seetings for advanced cod
			if(isset($gateway->settings['disable_cod_adv']))
			{
				if($gateway->settings['disable_cod_adv']=='no')
				{
					$advanced_cod_array=array(
						"extra_charges"=>$gateway->settings['extra_charges'],
						"extra_charges_msg"=>$gateway->settings['extra_charges_msg'],
						"extra_charges_type"=>$gateway->settings['extra_charges_type'],
						"cod_pincodes"=>$gateway->settings['cod_pincodes'],
						"in_ex_pincode"=>$gateway->settings['in_ex_pincode']
					);
				}
			}
			$icon_url="";
			if(isset($gateway->settings['icon']))
			{
				$icon_url=$gateway->settings['icon'];
			}

			$gateway_list['gateways'][]= array(
				"id" => $gateway->id,
				"title" => $gateway->get_title(),
				"description" =>$gateway->get_description(),
				"icon" =>$icon_url,
				"chosen" =>$gateway->chosen,
				"order_button_text" =>$gateway->order_button_text,
				"enabled" =>$gateway->enabled,
				"instructions"=>$gateway->settings['instructions'],
				"account_details"=>$account_details,
				"settings"=>$advanced_cod_array
			);
        }
	    return $gateway_list;
	 }
	 
	 function jaxto_get_countries_list($postData = array())
	 {
		global $woocommerce;
		$list_countries = WC()->countries->get_allowed_countries();
        $specific_states =  WC()->countries->get_allowed_country_states();
        $list_array['list'] = array();
        $i=-1;
        foreach($list_countries as $key=>$country) {
            $list_array['list'][++$i]=array("id"=>$key,"n"=>html_entity_decode($country),"s"=>array());
            if(isset($specific_states[$key]) && is_array($specific_states[$key])){
                foreach($specific_states[$key] as $key=>$state) {
                    $list_array['list'][$i]["s"][] = array("id"=>$key,"n"=>html_entity_decode($state));
                }
            }
        }
        return $list_array;
	 }
	 
	 function jaxto_get_states_list($postData = array())
	 {
		  if(isset($postData) && !empty($postData['country_code']))
		  {
			  global $woocommerce;
			  $countries_obj   = new WC_Countries();
			  $countries   = $countries_obj->get_states($postData['country_code']);
			  return $countries;
		  }
		 return null;	 
	 }
	 
	 function jaxto_load_pole_products($postData = array())
	 {
		if(isset($postData) && !empty($postData['pole_param']))
		{
			$pole_parm_string=$postData['pole_param'];
			$pole_parma_array=explode(';', $pole_parm_string);
			$productlist = array();
			for ($i = 0; $i < count($pole_parma_array); $i++) 
			{
				if($pole_parma_array[$i]!="")
				{
					$product = wc_get_product( $pole_parma_array[$i]);
					$product_info= $this->jaxto_get_product_short_info($product,2);
					array_push($productlist,$product_info);
				}
			}
			return $productlist;
		}
		else if(isset($postData) && !empty($postData['cart_param']))
		{
			
			$recived_str = stripslashes($postData['cart_param']);  
			$json =json_decode($recived_str,true);
			$productlist = array();
			for ($i = 0; $i < count($json); $i++) 
			{
				{
					$product = wc_get_product( $json[$i]['pid']);
					$product_info= $this->jaxto_get_product_short_info($product,2);
					if($json[$i]['vid']!=-1)
					{
						$product_variation = new WC_Product_Variation($json[$i]['vid']);
						
						if($product_variation)
						{
							$product_info['manage_stock'] = $product_variation->manage_stock;
							$product_info['stock'] = $product_variation->stock;
							$product_info['stock_status'] = $product_variation->stock_status;
							$product_info['total_stock'] = $product_variation->get_total_stock();
							$product_info['price'] = $product_variation->price;
							$product_info['regular_price'] = $product_variation->regular_price;
							$product_info['sale_price'] = $product_variation->sale_price;

							$product_info['backorders'] = $product_variation->backorders;


							$img_url_arr=wp_get_attachment_image_src(get_post_thumbnail_id($json[$i]['vid']),'large');
							$img_url=$img_url_arr[0];
							if($img_url==""||$img_url==false||$img_url==0)
							{

							}
							else
							{
								$product_info['img']=$img_url;
							}
							
						}
					}
					else
					{
						$product_stockdata=new WC_Product($json[$i]['pid']);
						if($product_stockdata)
						{
							$product_info['manage_stock'] = $product_stockdata->manage_stock;
							$product_info['stock'] = $product_stockdata->stock;
							$product_info['stock_status'] = $product_stockdata->stock_status;
							$product_info['total_stock'] = $product_stockdata->get_total_stock();
							$product_info['price'] = $product_stockdata->price;
							$product_info['regular_price'] = $product_stockdata->regular_price;
							$product_info['sale_price'] = $product_stockdata->sale_price;
							$product_info['backorders'] = $product_stockdata->backorders;
						}
					}
					
					$product_info['vid']=$json[$i]['vid'];
					$product_info['pid']=$json[$i]['pid'];
					$product_info['index']=$json[$i]['index'];
					array_push($productlist,$product_info);
				}
			}
			return $productlist;
		}
		return "";
	 }
	 
	 function jaxto_load_products($postData = array())
	 {
		$product_limit=2;
		if(isset($postData) && !empty($postData['product_limit']))
		{
			$product_limit=$postData['product_limit'];
		}
		
		$product_category_list = array();
		
			$args = array(
			'number'     => $number,
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids
			);

			$product_categories = get_terms( 'product_cat', $args );
		   
			foreach( $product_categories as $cat ) 
			{ 
			         $category_info= $this->jaxto_get_category_short_info($cat,'0');  
					 $product_list=array();
					 $children = get_term_children($cat->term_id, $cat->taxonomy);
					  if(empty( $children))
					 {
					 
					  $args = array(
						'posts_per_page' =>$product_limit,
						'post_type' => 'product',
						'tax_query'     => array(
						array(
							'taxonomy'  => 'product_cat',
							'field'     => 'id', 
							'terms'     =>$cat->term_id
						)
						)
						);
						$r = new WP_Query( $args );
						if ($r->have_posts()) {
						while ($r->have_posts()) : $r->the_post(); global $product; 
					    $product_info=  $this->jaxto_get_product_short_info($product,0);
						array_push($product_list, $product_info);
						endwhile;
						} 
					  }
					  $arr = array("category" => $category_info,"products" => $product_list);
					array_push($product_category_list, $arr);
			}
			return $product_category_list;
	 }
	 
	 // according to splash requirement.
	function jaxto_get_woocommerce_product_list($postData = array()) 
	{
		$product_limit=5;
		if(isset($postData) && !empty($postData['product_limit']))
		  {
			  $product_limit=$postData['product_limit'];
		  }
		 // $product_limit=2;
		$product_category_list = array();
		
			$args = array(
			'number'     => $number,
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids
			);

			$product_categories = get_terms( 'product_cat');
			
			foreach( $product_categories as $cat ) 
			{ 
			         $category_info= $this->jaxto_get_category_short_info($cat,'1');
					   
					 $product_list=array();
					
					 {
					 
					  $args = array(
						'posts_per_page' =>$product_limit,
						'post_type' => 'product',
						'post_status' => 'publish',
						'tax_query'     => array(
						array(
							'taxonomy'  => 'product_cat',
							'field'     => 'id', 
							'terms'     =>$cat->term_id
						)
						)
						);
						$r = new WP_Query( $args );
						if ($r->have_posts()) {
						while ($r->have_posts()) : $r->the_post(); global $product; 
						
						if($category_info['img_url'][0]==""||$category_info['img_url'][0]=='')
						{
							
							$img_url=wp_get_attachment_image_src(get_post_thumbnail_id($r->post->ID),'large');
							if(count($img_url)>0)
							{
							 $category_info['img_url'] = $img_url[0];
						     break;
							}
							
						}
						
						endwhile;
						} 
					  }
					 
					   array_push($product_category_list, $category_info);				  
			}
			$meta_data=$this->jaxto_get_metadata();
			$best_selling= $this->jaxto_get_best_selling_products($product_limit);              //trending 
		    $new_arrivals=$this->jaxto_get_recent_products($product_limit);                  //new_arrivals
		    $new_sales=$this->jaxto_get_sale_products($product_limit);    
            $payment_gateWays=$this->jaxto_get_available_payment_gateways();			
			$arr_meta_product = array("category" => $product_category_list,"meta_data" => $meta_data,"best_selling" => $best_selling,"new_arrivals" => $new_arrivals,"new_sales" => $new_sales
			                           ,"payment"=>$payment_gateWays);
				
			return $arr_meta_product;
			
  }

  function jaxto_get_category_short_info($catr,$format)
	{
          $cat= get_term( $catr->term_id, 'product_cat' );
		  $category_info['id']=$cat->term_id;
		  if($format!='0')
		  {
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 
		  // get the image URL
		  $image = wp_get_attachment_url( $thumbnail_id );  
		  $category_info['parent']=$cat->parent;
		  $category_info['id']=$cat->term_id;
		  $category_info['name']=$cat->name;
		  $category_info['slug']=$cat->slug;
		  $category_info['img_url']=$image;
		  $category_info['count']=$cat->count;
                  $category_info['link']= get_category_link($cat->term_id) ;
		  }
		  return $category_info;
  }
  function jaxto_get_product_short_info($product,$format)
  {
			
			if(!is_a($product,"WC_Product"))
			
			$details['p_temp'] = 'zzz';
			$details['stock'] =$product->is_in_stock();
			$details['url'] =$product->get_permalink();
			if($format!=2)
			{
			$short_desc = apply_filters('woocommerce_mobapp_short_description', $product->get_post_data()->post_excerpt);	
			$details['desc'] =do_shortcode($short_desc);
			}
			$details['title'] = $product->post->post_title;
			
			$details['id'] = $product->post->ID;
			$temp_url=wp_get_attachment_image_src(get_post_thumbnail_id($product->post->ID),'large');
			if(count($temp_url)>0)
			{
				$details['img'] = $temp_url[0];
			}
			$details['type'] = $product->product_type;
			$details['price'] = $product->get_price();
			$details['regular_price'] = $product->get_regular_price();
			$details['sale_price'] = $product->get_sale_price();
			if($format!=0)
			{
				
				$cat_data=  wp_get_post_terms( $product->post->ID, 'product_cat' );
				
				$catarray = array();
				foreach( $cat_data as $cat ) 
				{
					array_push($catarray,$cat->term_id);
				}
				$details['category_ids'] =$catarray;
				
			}	
			if($product->product_type == 'variable')
			{
				$details['min_var_price']=$product->get_variation_price( 'min', true );
				$details['max_var_price']=$product->get_variation_price( 'max', true );
			}
			$details['created_at'] =$product->get_post_data()->post_date_gmt;
			 $details['average_rating'] =WC_format_decimal($product->get_average_rating(), 2);
			 $details['total_sales']=metadata_exists( 'post', $product->id, 'total_sales' ) ? (int) get_post_meta( $product->id, 'total_sales', true ) : 0;
			$details['featured']= $product->is_featured();
			return $details;
}

  public function jaxto_get_recent_products($product_limit){
        $atts =  array(
            'per_page' 	=> '12',
            'columns' 	=> '4',
            'orderby' 	=> 'date',
            'order' 	=> 'desc'
        );
        extract($atts);
        $meta_query = WC()->query->get_meta_query();
        $args = array(
            'post_type'				=> 'product',
            'post_status'			=> 'publish',
            'ignore_sticky_posts'	=> 1,
            'posts_per_page' 		=> $product_limit,
            'orderby' 				=> $orderby,
            'order' 				=> $order,
            'meta_query' 			=> $meta_query
        );
        $products = $this->jaxto_get_ids($args,$atts);
        return $products;
    }
    public function jaxto_get_featured_products(){
        $atts = array(
            'per_page' 	=> '12',
            'columns' 	=> '4',
            'orderby' 	=> 'date',
            'order' 	=> 'desc'
        );
        extract($atts);
        $args = array(
            'post_type'				=> 'product',
            'post_status' 			=> 'publish',
            'ignore_sticky_posts'	=> 1,
            'posts_per_page' 		=> $per_page,
            'orderby' 				=> $orderby,
            'order' 				=> $order,
            'meta_query'			=> array(
                array(
                    'key' 		=> '_visibility',
                    'value' 	=> array('catalog', 'visible'),
                    'compare'	=> 'IN'
                ),
                array(
                    'key' 		=> '_featured',
                    'value' 	=> 'yes'
                )
            )
        );

        $products = $this->jaxto_get_ids($args,$atts);
        return $products;
    }
    public function jaxto_get_sale_products($product_limit){
        $atts =  array(
            'per_page'      => '12',
            'columns'       => '4',
            'orderby'       => 'title',
            'order'         => 'asc'
        );
        extract($atts);
        // Get products on sale
        $product_ids_on_sale = wc_get_product_ids_on_sale();

        $meta_query   = array();
        $meta_query[] = WC()->query->visibility_meta_query();
        $meta_query[] = WC()->query->stock_status_meta_query();
        $meta_query   = array_filter( $meta_query );

        $args = array(
            'posts_per_page'	=> $product_limit,
            'orderby' 			=> $orderby,
            'order' 			=> $order,
            'no_found_rows' 	=> 1,
            'post_status' 		=> 'publish',
            'post_type' 		=> 'product',
            'meta_query' 		=> $meta_query,
            'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale )
        );
        $products = $this->jaxto_get_ids($args,$atts);
        return $products;
    }
    public function jaxto_get_best_selling_products($product_limit){
        $atts = array(
            'per_page'      => '12',
            'columns'       => '4'
        );
        extract($atts);
        $args = array(
            'post_type' 			=> 'product',
            'post_status' 			=> 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'		=> $product_limit,
            'meta_key' 		 		=> 'total_sales',
            'orderby' 		 		=> 'meta_value_num',
            'meta_query' 			=> array(
                array(
                    'key' 		=> '_visibility',
                    'value' 	=> array( 'catalog', 'visible' ),
                    'compare' 	=> 'IN'
                )
            )
        );

        $products = $this->jaxto_get_ids($args,$atts);
        return $products;
    }

    public function jaxto_top_rated_products(){
        $atts =  array(
            'per_page'      => '12',
            'columns'       => '4',
            'orderby'       => 'title',
            'order'         => 'asc'
        );
        extract($atts);
        $args = array(
            'post_type' 			=> 'product',
            'post_status' 			=> 'publish',
            'ignore_sticky_posts'   => 1,
            'orderby' 				=> $orderby,
            'order'					=> $order,
            'posts_per_page' 		=> $per_page,
            'meta_query' 			=> array(
                array(
                    'key' 			=> '_visibility',
                    'value' 		=> array('catalog', 'visible'),
                    'compare' 		=> 'IN'
                )
            )
        );

        $products = $this->jaxto_get_ids($args,$atts);
        return $products;
    }

    private function jaxto_get_ids($args,$atts){
        $r = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
        $product_info = array();
        if ($r->have_posts()) {
						while ($r->have_posts()) : $r->the_post(); global $product; 
						
						    $product_info[]=  $this->jaxto_get_product_short_info($product,1);
							
						endwhile;
						 } 
		
						
		
		
		
        return $product_info;
    }
	public function jaxto_get_shipping_methods()
	{	
          global $woocommerce;
		 WC()->customer->calculated_shipping( true );
		 $this->shipping_calculated = true;
		 do_action( 'woocommerce_calculated_shipping' );
		 $woocommerce->cart->calculate_shipping();
            $packages = WC()->shipping()->get_packages();
		   
		
        $return = array();
        if($woocommerce->cart->needs_shipping() ){
            $return['show_shipping'] = 1;
            $woocommerce->cart->calculate_shipping();
            $packages = WC()->shipping()->get_packages();
		   
            foreach ( $packages as $i => $package ) {
                $chosen_method = isset( WC()->session->chosen_shipping_methods[ $i ] ) ? WC()->session->chosen_shipping_methods[ $i ] : '';
                $return['shipping'][] = array('methods'=>$this->jaxto_getMethodsInArray($package['rates']),
                    'chosen'=>$chosen_method,'index'=>$i
                );
            }
        }else{
            $return['show_shipping'] = 0;
            $return['shipping'] = array();
        }
        if(empty($return['shipping']) || is_null($return['shipping']) || !is_array($return['shipping'])) {
            $return['show_shipping'] = 0;
            $return['shipping'] = array();
        }
       return $return;		
    }
    private function jaxto_getMethodsInArray($methods){
        $return = array();
        foreach($methods as $method){
            $return[]=array(
                'id'=>$method->id,
                'label'=>$method->label,
                'cost'=>$method->cost,
                'taxes'=>$method->taxes,
                'method_id'=>$method->method_id,
            );
        }
        return $return;
    }
	
	function cart()
	{
		global $woocommerce;
		return $woocommerce->cart;
	}
	
	public function jaxto_get_cart_meta($data)
	{
	    $this->cart()->calculate_shipping();
        global $woocommerce;
        $return = array(
            "count"=>$this->cart()->get_cart_contents_count(),
            "shipping_fee" =>!empty($this->cart()->shipping_total)?$this->cart()->shipping_total:0,
            "tax"=>$this->cart()->get_cart_tax(),
			"total_tax"=>WC()->cart->tax_total,
			"shipping_tax"=> WC()->cart->shipping_tax_total,
            "fees"=>$this->cart()->get_fees(),
            "currency" =>get_woocommerce_currency(),
            "currency_symbol"=>get_woocommerce_currency_symbol(),
            "total"=>$this->cart()->get_cart_subtotal(true),
            "cart_total"=>$this->cart()->cart_contents_total,
            "order_total"=>$woocommerce->cart->get_cart_total(),
            "price_format"=>get_woocommerce_price_format(),
            'timezone'			 => wc_timezone_string(),
            'tax_included'   	 => ( 'yes' === get_option( 'woocommerce_prices_include_tax' ) ),
            'weight_unit'    	 => get_option( 'woocommerce_weight_unit' ),
            'dimension_unit' 	 => get_option( 'woocommerce_dimension_unit' ),
            "can_proceed"   => true,
            "error_message"   => "",
        );
		

        return $return;
    }
	function jaxto_api_plugin_activate_status_action(){
		
		$response = array(
					'status' => 'success',
					'error' => '',
					'message' => 'Plugin is active.'
				);
				
		return $response;
	}
	
	public function jaxto_get_cart_api() 
	{
		global $woocommerce;
		$cart = array_filter( (array)$woocommerce->cart->cart_contents );
		$return =array();
		foreach($cart as $key=>$item){
		$item["key"] = $key;
		$variation = array();
		if(isset($item["variation"]) && is_array($item["variation"])){
		foreach($item["variation"] as $id=>$variation_value){
		$variation[] = array(
		"id" => str_replace('attribute_', '', $id),
		"name"   =>  wc_attribute_label(str_replace('attribute_', '', $id)),
		"value_id"  => $variation_value,
		"value"  => trim(esc_html(apply_filters('woocommerce_variation_option_name', $variation_value)))
		);
		}
		}
		$item["variation"] = $variation;
		$item = array_merge($item,$this->jaxto_get_product_short_info($item["data"],0));
		unset($item["data"]);
		$return[] = $item;
		}
		return $return;
	}
	
	function jaxto_calculate_shipping($postData1= array())
	{
		$ship_str = stripslashes($postData1);

		$postData= json_decode($ship_str,true);
		$reponseData = array();
		$data = array();
		try {

		WC()->shipping->reset_shipping();
		if(isset($postData['cal_chosen_method'])  && !empty($postData['cal_chosen_method']))
		{
		WC()->session->set('chosen_shipping_methods', array($postData['cal_chosen_method']));
		}
		$country  = $postData['cal_shipping_country'];
		$state    = $postData['cal_shipping_state'];
		$postcode = $postData['cal_shipping_postcode'];
		$city     = $postData['cal_shipping_city'];

		if ( !empty($postcode) && ! WC_Validation::is_postcode( $postcode, $country ) ) {                       
		$reponseData = array(
		'status' => 'failed',
		'error' => '',
		'message' => 'Please enter a valid postcode/ZIP.'
		);
		return $reponseData;
		} elseif ( !empty($postcode) ) {
		$postcode = wc_format_postcode( $postcode, $country );
		}
		if ( $country ) {
		WC()->customer->set_location( $country, $state, $postcode, $city );
		WC()->customer->set_shipping_location( $country, $state, $postcode, $city );
		} else {
		WC()->customer->set_to_base();
		WC()->customer->set_shipping_to_base();
		}

		WC()->customer->calculated_shipping( true );
		$this->shipping_calculated = true;
		do_action( 'woocommerce_calculated_shipping' );

		WC()->session->set('wc_shipping_calculate_details',$postData);
		$reponseData=$this->jaxto_get_shipping_methods();


		}catch (Exception $e){

		}
		return $reponseData;
    }
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	function test()
	{
	
	}
	
	function setAddress()
	{
    global $woocommerce;
    $woocommerce->customer->set_shipping_postcode( 12345 );
    $woocommerce->customer->set_postcode( 12345 );

    //get it
    $woocommerce->customer->get_shipping_postcode();    
    $woocommerce->customer->get_postcode();
	}
	function jaxto_active_widget_attribute_data()
	{
		$result_array= array();
		global $wp_registered_widgets, $wp_registered_widget_controls;
		$dummy = new WC_Widget_Layered_Nav();
        $settings = $dummy->get_settings();
		$attribute_array=array();
		foreach( $settings as $filtersetting ) 
			{
			 $matchfound=false;
		      for($j=0;$j<count($attribute_array);$j++)
			  {
				if($filtersetting['attribute']==$attribute_array[$j]['attribute'])
				{
					$matchfound=true;
				}
			   }
			if(!$matchfound)
			{
				array_push($attribute_array,$filtersetting);
			}
		}
		
		
		$total_array=array();
		for($i=0;$i<count($attribute_array);$i++)
		{
			     $taxanomyarray= wc_attribute_taxonomy_name($attribute_array[$i]['attribute']);
				 $terms = get_terms( $taxanomyarray );
				$tax_data=array('filter_array'=>$attribute_array[$i],'attributes_data'=>$terms);
				array_push($total_array,$tax_data);
		}
		///=================Attribute variations ================
		return $total_array;
	}
	function jaxto_get_category_price_range()
	{
		//==========================================
		$product_list=array();
			$product_categories = get_terms( 'product_cat' );
		    $max_cat_array=array();
			$min_price=99999;
			
	    	foreach( $product_categories as $cat ) 
			{
				$max_price=0;
				$args = array(
						'posts_per_page' => -1,
					'post_type' => 'product',
					'post_status' => 'publish',
						'tax_query'     => array(
						array(
							'taxonomy'  => 'product_cat',
				              'terms'     =>$cat->term_id
						)
						)
						);
						$loop = new WP_Query( $args );
						
						if ($loop->have_posts()) {
						while ($loop->have_posts()) : $loop->the_post(); global $product; 
					   
						if($product->get_price()>$max_price)
						{
							$max_price=$product->get_price();
						}
						if($product->get_price()<$min_price)
						{
							$min_price=$product->get_price();
						}
						if($product->product_type == 'variable')
						{
							if( $product->get_variation_price( 'max', true )>$max_price)
							{
								$max_price=$product->get_variation_price( 'max', true );
							}
							if( $product->get_variation_price( 'min', true )<$min_price)
							{
								$min_price=$product->get_variation_price( 'min', true );
							}
						}
						endwhile;
						if($max_price=="")
						{
							$max_price="0";
						}
						if($min_price=="")
						{
							$min_price="0";
						}
				$cat_array=array("c_id"=>$cat->term_id,"max_limit"=>$max_price,"min_limit"=>$min_price);
				array_push($max_cat_array,$cat_array);
			}
			
			}
			return $max_cat_array;
 return;			
	}
	function jaxto_filter_data_price() 
	{
			
		//========add attributes here=========
	    $result_array= array();
		global $wp_registered_widgets, $wp_registered_widget_controls;
		$dummy = new WC_Widget_Layered_Nav();
        $settings = $dummy->get_settings();
		$attribute_array=array();
		foreach( $settings as $filtersetting ) 
			{
			 $matchfound=false;
		      for($j=0;$j<count($attribute_array);$j++)
			  {
				if($filtersetting['attribute']==$attribute_array[$j]['attribute'])
				{
					$matchfound=true;
				}
			   }
			if(!$matchfound)
			{
				array_push($attribute_array,$filtersetting);
			}
		}
		
		
		$total_array=array();
		for($i=0;$i<count($attribute_array);$i++)
		{
			     $taxanomyarray= wc_attribute_taxonomy_name($attribute_array[$i]['attribute']);
				 $terms = get_terms( $taxanomyarray );
				$tax_data=array('attribute_name'=>$attribute_array[$i]);
				array_push($total_array,$tax_data);
		}
		///=================Attribute variations ================
	   $return_array=array('cat_price_range'=>$this->jaxto_get_category_price_range(),'attribute_avail_filters'=>$total_array);
	 
	   return $return_array;
	}
	
	function jaxto_filter_data_attribute()
	{
		$cat_attribute_array=array();
		$product_categories = get_terms( 'product_cat',null );
		foreach( $product_categories as $cat ) 
		{
		$atttibute_data=$this->jaxto_active_widget_attribute_data();
		$cat_attribute_vector=array();
		foreach( $atttibute_data as $attibute_var ) 
		{
		$attribute_tax=$attibute_var['attributes_data'];
		$temp_array=array();
		foreach($attribute_tax as $attibute_tax_var)
		{

		$attribute_taxanomy=$attibute_tax_var->taxonomy;
		$attribute_slug=$attibute_tax_var->slug;

				$args = array(
				'posts_per_page' => -1,
				'post_type' => 'product',
				'post_status' => 'publish',
				'tax_query' => array(
				   array(
						'taxonomy' => $attribute_taxanomy,
						'field' => 'slug',
						'terms' => $attribute_slug // name of publisher
					  ),
					  array(
									'taxonomy'  => 'product_cat',
									'field'     => 'id', 
									'terms'     =>$cat->term_id
								)
				   )
			   );

			$products = get_posts( $args );
			$match_found=false;
			foreach($products as $product)
			{
				 $match_found=true;
				break;		
			 }
			 if($match_found)
			 {
				 $attribute_array['term_id']=$attibute_tax_var->term_id;
				 $attribute_array['name']=$attibute_tax_var->name;
				 $attribute_array['slug']=$attibute_tax_var->slug;
				 $attribute_array['taxonomy']=$attibute_tax_var->taxonomy;
				 array_push($temp_array,$attribute_array);
			 }

				}
				if(count($temp_array)>0)
				{
					array_push($cat_attribute_vector,array("attribute_data"=>$attibute_var['filter_array'],"attribute_var_data"=>$temp_array));
				}					 
		}
			 array_push($cat_attribute_array,array("c_id"=>$cat->term_id,"attribute"=>$cat_attribute_vector));
			 
		}

		return $cat_attribute_array;
	}
	
	public function jaxto_get_error()
	{
        $notices = WC()->session->get( 'wc_notices', array() );
        if(!empty($notices['error'])){
            $return = array();
            foreach($notices['error'] as $key=>$error){
                $return ='cart_add_error_'.$key.''.html_entity_decode($error);
            }
            wc_clear_notices();
            return $return;
        }else{
            return false;
        }
    }
	public function jaxto_add_coupon_call($postData= array())
	{
		
		if(isset($postData) && !empty($postData['coupon_code']))
		{
			$coupon_code=$postData['coupon_code'];
			$return =jaxto_add_coupon($coupon_code);
			return $return;
		}
		return null;
	}
	public function jaxto_add_coupon($coupon_code)
	{
		global $woocommerce;
        $added =  $woocommerce->cart->add_discount($coupon_code);
        if(!$added)
		{   $return = $this->jaxto_get_error();
            $return = array(
										'status' => 'failed',
										'error' => 1,
										'message' => $this->jaxto_get_error()
								);
        }else
		{
            $woocommerce->cart->persistent_cart_update();
			$return = $this->jaxto_get_cart_meta();
			$return = array(
										'status' => 'success',
										'error' => '',
										'message' => 'Coupon Applied Successfully'
								);
        }
	   return $return;
    }
	
	function jaxto_filter_products($postData=array())
	{
		if(isset($postData) && !empty($postData['filter_data']))
		{
	    $recived_str = stripslashes($postData['filter_data']);     
	    $json =json_decode($recived_str,true);
		
		/*====parsed_array===*/
		$return_attribute_array=array();
		$category_slug=$json['cat_slug'];
		$min_range=$json['minPrice'];
		$max_range=$json['maxPrice'];
		$return_max_range=$min_range;
		$return_min_range=$min_range;
		$products_required=$postData['products_required'];
		
		$tax_array=array();
		//push cat data
		$category = array($category_slug);
		$cat_taxonomy=array(
							'taxonomy' => 'product_cat',
							'field' => 'slug',
							'terms' => $category,
							'operator' => 'IN'
						);
		array_push($tax_array,$cat_taxonomy);
		//push attribute_data
		$attribute_array=$json['attributes'];
		
		
		$temp_attribute_array=array();
		
		
		///======================
		for($i=0;$i<count($attribute_array);$i++)
		{   $taxonomy_name='';
			$recived_options_array=$attribute_array[$i]['options'];
			$temp_options_array=array();
			for($j=0;$j<count($recived_options_array);$j++)
			{
				$taxonomy_name=$recived_options_array[$j]['taxo'];
				array_push($temp_options_array,$recived_options_array[$j]['slug']);
			}
			$temp_array=array("taxo"=>$taxonomy_name,"options"=>$temp_options_array);
			array_push($temp_attribute_array,$temp_array);
			
		}
		//===================
		 for($i=0;$i<count($temp_attribute_array);$i++)
		{
			$attribute_array_temp=array(
							'taxonomy' => $temp_attribute_array[$i]['taxo'],
							'field' => 'slug',
							'terms' => $temp_attribute_array[$i]['options']//explode(",",$str) // name of publisher
						  );
						  array_push($tax_array,$attribute_array_temp);
		}
		$category_slug=$json['cat_slug'];
		$min_range=$json['minPrice'];
		$max_range=$json['maxPrice'];
		$onsale=false;
		if(isset($json['onsale']))
		{
			$onsale=$json['onsale'];
		}
		$isinstock=false;
		if(isset($json['chkStock']))
		{
			$isinstock=$json['chkStock'];
		}
		global $wpdb;
		$str='black,blue';
		$category = array($category_slug);
		
		$sort_type=7;
		if(isset($json['sort_type'])&&!empty($json['sort_type']))
		{
			$sort_type=$json['sort_type'];
		}
		$args=null;
		$push_meta_array=array();
		switch($sort_type)
		{
			case 0://recent
			{
				$meta_query = WC()->query->get_meta_query();
				
				$args = array(
					'post_status' => 'publish',
					'post_type' => array('product','product_variation'),
					'posts_per_page' => -1,
					'orderby' => 'date',
                    'order' => 'desc',
					'tax_query' =>$tax_array
			     );
				array_push($push_meta_array,$meta_query);
			}
			break;
			case 1://featured
			{
				$args = array(
					'post_status' => 'publish',
					'post_type' =>array('product','product_variation'),
					'posts_per_page' => -1,
					'orderby' => 'date',
                    'order' => 'desc',
					'tax_query' =>$tax_array
				);	
				array_push($push_meta_array,array(
						'key' 		=> '_featured',
						'value' 	=> 'yes'
					));
			
			}
			break;
			case 2://discount
			{
				   $meta_query   = array();
					$meta_query[] = WC()->query->visibility_meta_query();
					$meta_query[] = WC()->query->stock_status_meta_query();
					$meta_query   = array_filter( $meta_query );
				 $product_ids_on_sale = wc_get_product_ids_on_sale();
				$args = array(
					'post_status' => 'publish',
					'post_type' => array('product','product_variation'),
					'posts_per_page' => -1,
					 'ignore_sticky_posts'   => 1,
					'orderby'       => 'title',
                    'order'         => 'asc',
					'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale ),
					'tax_query' =>$tax_array,
			);
			
			array_push($push_meta_array,$meta_query);
			}
			break;
			case 3://top rated
			{
				$args = array(
				'post_status' => 'publish',
				'post_type' =>array('product','product_variation'),
				'posts_per_page' => -1,
				'meta_key'=> 'total_sales',
               'orderby' => '_wc_average_rating',
				'tax_query' =>$tax_array
			  );
			}
			break;
			case 4://price high to low
			{
				$args = array(
					'post_status' => 'publish',
					'post_type' => array('product','product_variation'),
					'posts_per_page' => -1,
					'meta_key' => '_price',
					'orderby'       => 'meta_value_num',
                    'order'         => 'desc',
					'tax_query' =>$tax_array
			);
			}
			break;
			case 5://low to high
			{
				$args = array(
					'post_status' => 'publish',
					'post_type' => array('product'),
					'posts_per_page' => -1,
					'meta_key' => '_price',
					'orderby'       => 'meta_value_num',
                    'order'         => 'asc',
					'tax_query' =>$tax_array
			);
			}
			break;
			case 6://best selling
			{
				$args = array(
				'post_status' => 'publish',
				'post_type' =>array('product','product_variation'),
				'posts_per_page' => -1,
			    'meta_key'=> 'total_sales',
                'orderby' => 'meta_value_num',
				'tax_query' =>$tax_array
			);
			}
			break;
			case 7://normal
			{
			$args = array(
				'post_status' => 'publish',
				'post_type' =>array('product','product_variation'),
				'posts_per_page' => -1,
				'tax_query' =>$tax_array,			
			);
			}
			break;
		}
		 
		if($onsale)
	     {	     $meta_query   = array();
                 $meta_query[] = WC()->query->visibility_meta_query();
				 $meta_query[] = WC()->query->stock_status_meta_query();
				 $meta_query   = array_filter( $meta_query );
				 $product_ids_on_sale = wc_get_product_ids_on_sale();
				 
				$args['ignore_sticky_posts'] =1;
				$args['post__in'] =array_merge( array( 0 ), $product_ids_on_sale );
				array_push($args,$meta_query);
		}
		if($isinstock)
		{
				array_push($push_meta_array,array(
					'key' => '_stock_status',
					'value' => 'instock'
				));
		}
		$args['meta_query']=$push_meta_array;
		
		
			$product_list=array();
			$r = new WP_Query( $args );
			if ($r->have_posts()) {
								while ($r->have_posts()) : $r->the_post(); global $product; 
								$product_info=  $this->jaxto_get_product_short_info($product,1);
								
								 $push_item=false;
								if(($product->get_price()>=$min_range && $product->get_price()<=$max_range))
									{
										$push_item=true;
										
									}else if($product->product_type == 'variable')
									{
										if( ($product->get_variation_price( 'min', true )>=$min_range && $product->get_variation_price( 'min', true )<=$max_range))
										{
											$push_item=true;
										}
										
										else if( ($product->get_variation_price( 'max', true )>=$min_range && $product->get_variation_price( 'max', true )<=$max_range))
										{
											$push_item=true;
										}
									}
									if($push_item)
									{
										array_push($product_list, $product_info);
										if($products_required==0)
								        {
												if($product->get_price()>=$return_max_range)
												{
													$return_max_range=$product->get_price();
												}
												if($product->product_type == 'variable')
												{
													if( $product->get_variation_price( 'max', true )>=$return_max_range)
													{
														$return_max_range=$product->get_variation_price( 'max', true );
													}
												}
												$attributes = $product->get_attributes();
											
												 foreach ( $attributes as $attribute ) 
												 {
													 if ( $attribute['is_taxonomy'] ) 
													 {
													     $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
														 $return_attribute_array=$this->addAttributeData($return_attribute_array,$attribute['name'],$values);
													
													  } 
												}
								      }
												
									}
									
								endwhile;
								}
							    if($products_required==0)
								{	
			                          return  array("attribute"=>$return_attribute_array,"max_limit"=>$return_max_range,"min_limit"=>$return_min_range) ;
								}else
								{
									  return  array("product_list"=>$product_list) ;
								}
		}else
		{
			return ;
		}	
	  
	}
	function addAttributeData($baseArray,$taxo,$slugarray)
	{
		{
			$main_taxo_found=false;
			for($i=0;$i<count($baseArray);$i++)
			{
				if($baseArray[$i]['taxo']==$taxo)
				{   
			        $main_taxo_found=true;
					$match_found=false;
					for($m=0;$m<count($slugarray);$m++)
					{
						for($j=0;$i<count($baseArray[$i]['name']);$j++)
					 {
						 if($baseArray[$i]['name'][$j]==$slug)
						 {
							 $match_found=true;
							break;
						 }
					 }
					
				     
					 if(!$match_found)
					 {
						 echo ''.count($baseArray[$i]['name']);
						   echo '----'.$slug.'---'.$taxo;
						 array_push($baseArray[$i]['name'],$slugarray[$m]);
						 break;
					 }
					 }
                    						 
				}
			}
			if(!$main_taxo_found)
				{
					$slug_array=array();
					array_push($slug_array,$slugarray);
					$temp_array=array("taxo"=>$taxo,"names"=>$slugarray);
					array_push($baseArray,$temp_array);
				
				}
		}
		return $baseArray;
	}
	
	function jaxto_get_main_menu_data()
	{
		$menu_array=array();
		$menus = get_terms('nav_menu');
		foreach($menus as $menu){
			   $menu_items = wp_get_nav_menu_items( $menu->name);
			   
			   $menu_data=array("name"=>$menu->name,
			   "slug"=>$menu->slug,
			   "id"=>$menu->term_id);
			   array_push($menu_array,$temp_array);
		}
	}
	function jaxto_get_menu_data()
    {
            $menu_array=array();
			$menus = get_terms('nav_menu');
			foreach($menus as $menu){
			   $menu_items = wp_get_nav_menu_items( $menu->name);
			   
			   $menu_data=array("name"=>$menu->name,
			   "slug"=>$menu->slug,
			   "id"=>$menu->term_id);
			 
			 $menu_option_array=array();
			 for($i=0;$i<count( $menu_items);$i++)
			  {
				  $menu_option=$menu_items[$i];
				  $cat_id=$this->getcategoryID($menu_option->url);
				  $redirect_url="";
				  if($cat_id==-1)
				  {
					  $redirect_url=$menu_option->url;
				  }
				 $temp_option_array=array(
				 "id"=>$menu_option->ID,
				 "parent"=>$menu_option->menu_item_parent,
				 "menu_order"=>$menu_option->menu_order,
				 "redirect_cid"=>$cat_id,
				 "redirect_url"=>$redirect_url,
				  "name"=>$menu_option->title
				 );
				 array_push($menu_option_array,$temp_option_array);
			  }
			  $temp_array=array("menu"=>$menu_data,"options"=>$menu_option_array);
			  array_push($menu_array,$temp_array);
			} 
			 return $menu_array;
    }
    function getcategoryID($caturl)
	{
		$siteURL = get_bloginfo('url');
		$product_categories = get_terms( 'product_cat');
		foreach( $product_categories as $cat ) 
		{
		   $cat_url= get_category_link($cat->term_id);
		   if($cat_url==$caturl)
		   {
			   return (int)$cat->term_id;
		   }
		}
		return -1;
	}
	function jaxto_get_exship_data($postData= array())
	{
		$shipping_type="";
		if(isset($postData) && !empty($postData['ship_type']))
		{
			$shipping_type=base64_decode($postData['ship_type']);
		}else
		{
			return;
		}
		switch($shipping_type)
		{
			case "aftership":
					if(isset($postData) && !empty($postData['order_id']))
					{
						$options = get_option('aftership_option_name');
						$plugin = $options['plugin'];
						if ($plugin == 'aftership') {
							$order_id=base64_decode($postData['order_id']);
							$tracking_provider=get_post_meta($order_id, '_aftership_tracking_provider', true);
							$tracking_number=get_post_meta($order_id, '_aftership_tracking_number', true);
							$track_data=array(
							"provider"=>$tracking_provider, 
							"tracking_id"=>$tracking_number,
							"order_id"=>$order_id
							);
							return $track_data;
						}else
						{
									 $data = array(
													'status' => 'failed',
													'error' => 1,
													'message' => 'No data received.'
												);
						}
					}else
					{
						return;
					}
			break;
		}
		
	}
}
