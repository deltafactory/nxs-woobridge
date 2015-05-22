<?php
/*
Plugin Name: Nexus WooCommerce bridge
Version: 1.0.0
Plugin URI: http://nexusthemes.com
Description: Helper
Author: Gert-Jan Bark
Author URI: http://nexusthemes.com
*/

//log all!
error_reporting(-1);	

function nxs_woobridge_init()
{
	
	if (!defined('NXS_FRAMEWORKLOADED'))
	{
		function nxs_woobridge_frameworkmissing() {
	    ?>
	    <div class="error">
	      <p>The nxs_woobridge plugin is not initialized; NexusFramework dependency is missing (hint: activate a WordPress theme from NexusThemes.com first)</p>
	    </div>
	    <?php
		}
		add_action( 'admin_notices', 'nxs_woobridge_frameworkmissing' );
		return;
	}
	
	// WOO widgets
	nxs_lazyload_plugin_widget(__FILE__, "wooproductdetail");
	nxs_lazyload_plugin_widget(__FILE__, "woomessages");
	nxs_lazyload_plugin_widget(__FILE__, "woocheckout");
	nxs_lazyload_plugin_widget(__FILE__, "woothankyou");
	nxs_lazyload_plugin_widget(__FILE__, "woocart");
	nxs_lazyload_plugin_widget(__FILE__, "wooprodlist");
	nxs_lazyload_plugin_widget(__FILE__, "wooaddtocart");
	nxs_lazyload_plugin_widget(__FILE__, "woogotocart");
	nxs_lazyload_plugin_widget(__FILE__, "wooproductreference");
	nxs_lazyload_plugin_widget(__FILE__, "woominicart");
	
	// WOO business rules
	nxs_lazyload_plugin_widget(__FILE__, "woobusrulearchiveprodcatdyncontent");
	nxs_lazyload_plugin_widget(__FILE__, "woobusrulewoopage");
	nxs_lazyload_plugin_widget(__FILE__, "woobusruleproduct");
	nxs_lazyload_plugin_widget(__FILE__, "woobusrulecategory");
	nxs_lazyload_plugin_widget(__FILE__, "woobusrulearchiveprodcat");
	
	function nxs_woobridge_links_getposttypes($result)
	{
		$result[] = "product";
		return $result;
	}   
	add_filter("nxs_links_getposttypes", "nxs_woobridge_links_getposttypes");

	function nxs_woobridge_add_to_cart_fragments($result)
	{
		$shoppingcartcontent = $result["div.widget_shopping_cart_content"];
		$result["div.widget_shopping_cart_content"] = nxs_woobridge_decoratetemplate_impl($shoppingcartcontent, "minicart");
		return $result;
	}
	add_filter("add_to_cart_fragments", "nxs_woobridge_add_to_cart_fragments", 99);

}
add_action("init", "nxs_woobridge_init");


function nxs_woobridge_getwidgets($result, $widgetargs)
{
	// No modifications necessary if WooCommerce is not active.
	if ( ! isset( $GLOBALS['woocommerce'] ) ) {
		return $result;
	}

	$nxsposttype = $widgetargs["nxsposttype"];
	
	if ($nxsposttype == "busrulesset")
	{
		$result[] = array("widgetid" => "woobusrulearchiveprodcatdyncontent");
		$result[] = array("widgetid" => "woobusrulewoopage");
		$result[] = array("widgetid" => "woobusruleproduct");
		$result[] = array("widgetid" => "woobusrulecategory");
		$result[] = array("widgetid" => "woobusrulearchiveprodcat");
	}
	
	if 
	(
		$nxsposttype == "post" || 
		$nxsposttype == "footer" || 
		$nxsposttype == "header" || 
		$nxsposttype == "subheader" ||
		$nxsposttype == "subfooter" ||
		$nxsposttype == "pagelet" ||
		$nxsposttype == "sidebar"
	)
	{
		$result[] = array("widgetid" => "wooproductdetail");
		$result[] = array("widgetid" => "woomessages");
		$result[] = array("widgetid" => "wooprodlist");
		$result[] = array("widgetid" => "woocheckout");
		$result[] = array("widgetid" => "woothankyou");
		$result[] = array("widgetid" => "woocart");
		$result[] = array("widgetid" => "wooaddtocart");
		$result[] = array("widgetid" => "woogotocart");
		$result[] = array("widgetid" => "wooproductreference");
		$result[] = array("widgetid" => "woominicart");
	}
	
	//		
	return $result;
}
add_action("nxs_getwidgets", "nxs_woobridge_getwidgets", 10, 2);	// default prio 10, 2 parameters (result, args)

function nxs_woobridge_decoratetemplate($buffer)
{
	return nxs_woobridge_decoratetemplate_impl($buffer, "pagerendering");
}

function nxs_woobridge_decoratetemplate_impl($buffer, $type)
{
	// do the replacements here...
	//$buffer = str_replace("button alt", "button alt nxsbutton1", $buffer);
	
	if ($type == "pagerendering")
	{
		// convert form into nexusform
		$buffer = str_replace("<form ", "<form class='nxs-form' ", $buffer);	
		$buffer = str_replace("class=\"button\"", "class=\"button nxs-button nxs-button-scale-2-0 nxs-colorzen nxs-colorzen-c22\"", $buffer);
		$buffer = str_replace("button alt", "button alt nxs-button nxs-button-scale-2-0  nxs-colorzen nxs-colorzen-c22 ", $buffer);
	}
	else if ($type == "minicart")
	{
		$buffer = str_replace("button", "button nxs-button nxs-button-scale-1-0 nxs-colorzen nxs-colorzen-c22", $buffer);
	}
	
	return $buffer;
}

// template decorating...
function nxs_woobridge_beforetemplate()
{
	ob_start("nxs_woobridge_decoratetemplate");
}
function nxs_woobridge_aftertemplate()
{
	ob_end_flush();	// will invoke nxs_woobridge_beforetemplate
}

add_action("woocommerce_before_template_part", "nxs_woobridge_beforetemplate");
add_action("woocommerce_after_template_part", "nxs_woobridge_aftertemplate");

function nxs_woobridge_styles()
{
	wp_register_style('nxs-woobridge-style', 
    plugins_url( 'css/nxswoobridge.css', __FILE__), 
    array(), 
    nxs_getthemeversion(),    
    'all' );
  
  $iswordpressbackendshowing = is_admin();
	if (!$iswordpressbackendshowing)
	{
		wp_enqueue_style('nxs-woobridge-style');
	}
}
add_action('wp_enqueue_scripts', 'nxs_woobridge_styles');

/* --------------------------------------------------------------------- */
?>
