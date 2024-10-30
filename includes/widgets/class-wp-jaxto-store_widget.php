<?php 
class Jaxto_widget extends WP_Widget {
 
	public function __construct() {
		$widget_options = array( 
			'classname' => 'jaxto_app_widget',
			'description' => 'Android app widget by jaxto',
		);
		parent::__construct( 'jaxto_app_widget', 'Jaxto App Widget', $widget_options );
  }
  
	public function widget( $args, $instance ) 
	{
		global $JAXTO_PLUGIN_URL;
		
		$options_woo_setting = get_option( 'jaxto_woo_settings_data' );
		$options_woo_setting = maybe_unserialize( $options_woo_setting );
		
		$options_store_setting = get_option( 'jaxto_store_settings_data' );
		$options_store_setting = maybe_unserialize( $options_store_setting );
			
		$pid =isset($options_woo_setting['userpid']) ?  esc_attr($options_woo_setting['userpid']) : '';
		$type =isset($options_store_setting['type']) ?  esc_attr($options_woo_setting['type']) : '';
		
		$assets_setup_base_url = JAXTO_PLUGIN_URL . 'assets/img/';
		$play_image_url ="";
		if(get_option('jaxto_app_link_style') =="style-1")
			$play_image_url =$assets_setup_base_url.'play/style_1.png';
		else if(get_option('jaxto_app_link_style') =="style-2")
			$play_image_url =$assets_setup_base_url.'play/style_2.png';
		else if(get_option('jaxto_app_link_style') =="style-3")
			$play_image_url =$assets_setup_base_url.'play/style_3.png';
		else if(get_option('jaxto_app_link_style') =="style-4")
			$play_image_url =$assets_setup_base_url.'play/style_4.png';
		
							
		if($pid !=="" && $type !=="" && $play_image_url !=="")
		{
			$actual_link = "http://$_SERVER[HTTP_HOST]";
			$title = apply_filters( 'widget_title', $instance[ 'title' ] );
			$blog_title = get_bloginfo( 'name' );
			$tagline = get_bloginfo( 'description' );
			$applink ="https://play.google.com/store/apps/details?id=com.jaxto&referrer=".urlencode("pid=$pid");
			//$applink ="http://www.jaxto.in/appuri.php/?".urlencode("pid=$pid");
			
			echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
			echo "<a href='$applink' target='_blank'>
			<img src='$play_image_url' alt='App $blog_title'></a>";
			echo $args['after_widget'];
		}
	}
}

function jaxto_sortcode_handler() {
	
	
	global $JAXTO_PLUGIN_URL;
	$options_woo_setting = get_option( 'jaxto_woo_settings_data' );
	$options_woo_setting = maybe_unserialize( $options_woo_setting );
	
	$options_store_setting = get_option( 'jaxto_store_settings_data' );
	$options_store_setting = maybe_unserialize( $options_store_setting );
		
	$pid =isset($options_woo_setting['userpid']) ?  esc_attr($options_woo_setting['userpid']) : '';
	$type =isset($options_store_setting['type']) ?  esc_attr($options_woo_setting['type']) : '';
	
	$assets_setup_base_url = JAXTO_PLUGIN_URL . 'assets/img/';
	$play_image_url ="";
	if(get_option('jaxto_app_link_style') =="style-1")
		$play_image_url =$assets_setup_base_url.'play/style_1.png';
	else if(get_option('jaxto_app_link_style') =="style-2")
		$play_image_url =$assets_setup_base_url.'play/style_2.png';
	else if(get_option('jaxto_app_link_style') =="style-3")
		$play_image_url =$assets_setup_base_url.'play/style_3.png';
	else if(get_option('jaxto_app_link_style') =="style-4")
		$play_image_url =$assets_setup_base_url.'play/style_4.png';
		
	if($pid !=="" && $type !=="")
	{
		$actual_link = "http://$_SERVER[HTTP_HOST]";
		$blog_title = get_bloginfo( 'name' );
		$applink ="https://play.google.com/store/apps/details?id=com.jaxto&referrer=".urlencode("pid=$pid");
		echo "<a href='$applink' target='_blank'><img src='$play_image_url' alt='App $blog_title'/></a>";
	}
}

function jaxto_sortcode_handler_footer() {
	
	
	global $JAXTO_PLUGIN_URL;
	$options_woo_setting = get_option( 'jaxto_woo_settings_data' );
	$options_woo_setting = maybe_unserialize( $options_woo_setting );
	
	$options_store_setting = get_option( 'jaxto_store_settings_data' );
	$options_store_setting = maybe_unserialize( $options_store_setting );
		
	$pid =isset($options_woo_setting['userpid']) ?  esc_attr($options_woo_setting['userpid']) : '';
	$type =isset($options_store_setting['type']) ?  esc_attr($options_woo_setting['type']) : '';
	
	$isfooter =true;
	if(get_option('jaxto_app_link_footer')=='true')
		$isfooter =true;
	else
		$isfooter =false;
	
	$linkalign ='position: relative;margin:20px 0 20px 15px;float: left;';
	if(get_option('jaxto_app_style_align') =="left")
		$linkalign ='position: relative;margin:20px 0 20px 15px;float: left;';
	else if(get_option('jaxto_app_style_align') =="center")
		$linkalign ='position: relative;width: 100%;text-align: center;margin:20px 0 20px 0';
	else if(get_option('jaxto_app_style_align') =="right")
		$linkalign ='position: relative;margin:20px 0 20px 15px;float: right;';
	
	$assets_setup_base_url = JAXTO_PLUGIN_URL . 'assets/img/';
	$play_image_url ="";
	if(get_option('jaxto_app_link_style') =="style-1")
		$play_image_url =$assets_setup_base_url.'play/style_1.png';
	else if(get_option('jaxto_app_link_style') =="style-2")
		$play_image_url =$assets_setup_base_url.'play/style_2.png';
	else if(get_option('jaxto_app_link_style') =="style-3")
		$play_image_url =$assets_setup_base_url.'play/style_3.png';
	else if(get_option('jaxto_app_link_style') =="style-4")
		$play_image_url =$assets_setup_base_url.'play/style_4.png';
		
	if($pid !=="" && $type !=="" && $isfooter==true)
	{
		$actual_link = "http://$_SERVER[HTTP_HOST]";
		$blog_title = get_bloginfo( 'name' );
		$applink ="https://play.google.com/store/apps/details?id=com.jaxto&referrer=".urlencode("pid=$pid");
		echo "<div style='$linkalign'><a href='$applink' target='_blank'><img src='$play_image_url' alt='App $blog_title'/></a></div>";
	}
}

function jaxto_menu_item ( $items, $args ) {
	
	global $JAXTO_PLUGIN_URL;
	$options_woo_setting = get_option( 'jaxto_woo_settings_data' );
	$options_woo_setting = maybe_unserialize( $options_woo_setting );
	
	$options_store_setting = get_option( 'jaxto_store_settings_data' );
	$options_store_setting = maybe_unserialize( $options_store_setting );
		
	$pid =isset($options_woo_setting['userpid']) ?  esc_attr($options_woo_setting['userpid']) : '';
	$type =isset($options_store_setting['type']) ?  esc_attr($options_woo_setting['type']) : '';
	
	$ismenu =true;
	if(get_option('jaxto_app_link_menu')=='true')
		$ismenu =true;
	else
		$ismenu =false;
	
	if($pid !=="" && $type !=="")
	{
		if($ismenu==true)
		{
			$actual_link = "http://$_SERVER[HTTP_HOST]";
			$applink ="https://play.google.com/store/apps/details?id=com.jaxto&referrer=".urlencode("pid=$pid");
			$items .= "<li><a href='$applink' target='_blank'>Android App</a></li>";
		}
		else
		{
			$items .= "";
		}
	}
	return $items;
}

function jaxto_qr_code()
{
	
	global $JAXTO_PLUGIN_URL;
	$options_woo_setting = get_option( 'jaxto_woo_settings_data' );
	$options_woo_setting = maybe_unserialize( $options_woo_setting );
	
	$options_store_setting = get_option( 'jaxto_store_settings_data' );
	$options_store_setting = maybe_unserialize( $options_store_setting );
		
	$pid =isset($options_woo_setting['userpid']) ?  esc_attr($options_woo_setting['userpid']) : '';
	$type =isset($options_store_setting['type']) ?  esc_attr($options_woo_setting['type']) : '';
	if($pid !=="" && $type !=="")
	{
		require_once( JAXTO_ABS_PATH . 'includes/services/qr-code/qrlib.php' );
		//$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'jaxto-qrcode'.DIRECTORY_SEPARATOR;
		
		$upload_dir = wp_upload_dir(); //$upload_dir['baseurl']
		 
		$PNG_TEMP_DIR = $upload_dir['basedir'].DIRECTORY_SEPARATOR.'jaxto-qrcode'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = $upload_dir['baseurl'].'/jaxto-qrcode/';
		
		if (!file_exists($PNG_TEMP_DIR))
			mkdir($PNG_TEMP_DIR);
		
		$filename = $PNG_TEMP_DIR.'test.png';
		$errorCorrectionLevel = 'L';
		$matrixPointSize = 4;
		
		$actual_link = "http://$_SERVER[HTTP_HOST]";
		$qr_url ="https://play.google.com/store/apps/details?id=com.jaxto&referrer=".urlencode("pid=$pid");
		//$qr_url ="http://www.jaxto.in/appuri.php/?".urlencode("pid=$pid");
		
		if (trim($qr_url) == '')
			die('data cannot be empty! <a href="?">back</a>');

		// user data
		$filename = $PNG_TEMP_DIR.'test'.md5($qr_url.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		QRcode::png($qr_url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    

		$qe_code =$PNG_WEB_DIR.basename($filename);
		//display generated file
		echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
		
	}
}
?>