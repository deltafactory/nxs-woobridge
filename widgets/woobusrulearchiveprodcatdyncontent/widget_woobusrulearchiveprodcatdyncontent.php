<?php

function nxs_widgets_woobusrulearchiveprodcatdyncontent_geticonid() {
	$widget_name = basename(dirname(__FILE__));
	return "nxs-icon-books";
}

// Setting the widget title
function nxs_widgets_woobusrulearchiveprodcatdyncontent_gettitle() {
	return nxs_l18n__("Woo prod category archive with dynamic content", "nxs_td");
}

/* WIDGET STRUCTURE
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------- */

// Define the properties of this widget
function nxs_widgets_woobusrulearchiveprodcatdyncontent_home_getoptions($args) 
{
	// CORE WIDGET OPTIONS
	
	$options = array
	(
		"sheettitle" => nxs_widgets_woobusrulearchiveprodcatdyncontent_gettitle(),
		"sheeticonid" => nxs_widgets_woobusrulearchiveprodcatdyncontent_geticonid(),
		// "sheethelp" => nxs_l18n__("http://nexusthemes.com/bio-widget/"),
		"fields" => array
		(
			array( 
				"id" 				=> "wrapper_condition_begin",
				"type" 				=> "wrapperbegin",
				"label" 			=> nxs_l18n__("Condition", "nxs_td"),
			),
			
			array( 
				"id" 				=> "wrapper_condition_end",
				"type" 				=> "wrapperend"
			),

			array( 
				"id" 				=> "wrapper_template_begin",
				"type" 				=> "wrapperbegin",
				"label" 			=> nxs_l18n__("Template", "nxs_td"),
			),
			array
			( 
				"id"								=> "header_postid",
				"type" 							=> "selectpost",
				"previewlink_enable"=> "false",
				"label" 						=> nxs_l18n__("Header", "nxs_td"),
				"tooltip" 					=> nxs_l18n__("Select a header to show on the top of your page", "nxs_td"),
				"post_type" 				=> "nxs_header",
				"buttontext" 				=> nxs_l18n__("Style header", "nxs_td"),
				"emptyitem_enable"	=> false,
				"beforeitems" 			=> nxs_widgets_busrule_pagetemplates_getbeforeitems(),
			),
			array
			( 
				"id"								=> "footer_postid",
				"type" 							=> "selectpost",
				"previewlink_enable"=> "false",
				"label" 						=> nxs_l18n__("Footer", "nxs_td"),
				"tooltip" 					=> nxs_l18n__("Select a header to show on the top of your page", "nxs_td"),
				"post_type" 				=> "nxs_footer",
				"emptyitem_enable"	=> false,
				"beforeitems" 			=> nxs_widgets_busrule_pagetemplates_getbeforeitems(),
			),
			array
			( 
				"id"								=> "sidebar_postid",
				"type" 							=> "selectpost",
				"previewlink_enable"=> "false",
				"label" 						=> nxs_l18n__("Sidebar", "nxs_td"),
				"tooltip" 					=> nxs_l18n__("Select a sidebar to show on the right side of your page", "nxs_td"),
				"post_type" 				=> "nxs_sidebar",
				"emptyitem_enable"	=> false,
				"beforeitems" 			=> nxs_widgets_busrule_pagetemplates_getbeforeitems(),
			),
			array
			( 
				"id"								=> "subheader_postid",
				"type" 							=> "selectpost",
				"previewlink_enable"=> "false",
				"label" 						=> nxs_l18n__("Sub header", "nxs_td"),
				"tooltip" 					=> nxs_l18n__("Select a sub header to show above your main content", "nxs_td"),
				"post_type" 				=> "nxs_subheader",
				"emptyitem_enable"	=> false,
				"beforeitems" 			=> nxs_widgets_busrule_pagetemplates_getbeforeitems(),
			),
			array
			( 
				"id"								=> "subfooter_postid",
				"type" 							=> "selectpost",
				"previewlink_enable"=> "false",
				"label" 						=> nxs_l18n__("Sub footer", "nxs_td"),
				"tooltip" 					=> nxs_l18n__("Select a sub footer to show below your main content", "nxs_td"),
				"post_type" 				=> "nxs_subfooter",
				"emptyitem_enable"	=> false,
				"beforeitems" 			=> nxs_widgets_busrule_pagetemplates_getbeforeitems(),
			),
			array
			( 
				"id"								=> "pagedecorator_postid",
				"type" 							=> "selectpost",
				"post_type" 				=> "nxs_genericlist",
				"subposttype" => "pagedecorator", 
				"previewlink_enable"=> "false",
				"label" 						=> nxs_l18n__("Decorator", "nxs_td"),
				"tooltip" 					=> nxs_l18n__("Select a decorator to decorate your page", "nxs_td"),
				"emptyitem_enable"	=> false,
				"beforeitems" 			=> nxs_widgets_busrule_pagetemplates_getbeforeitems(),
			),
			array
			( 
				"id"								=> "contentslugtemplate",
				"type" 							=> "input",
				"label" 						=> nxs_l18n__("Content slug template, for example productcatarchive-{{{prodcatslug}}}-content. To change the slug of an existing template part, use the quick edit option in the backend", "nxs_td"),
			),
			array( 
				"id" 				=> "wrapper_template_end",
				"type" 				=> "wrapperend"
			),
			
			//RULE CONTROL
			
			array( 
				"id" 				=> "wrapper_flowcontrol_begin",
				"type" 				=> "wrapperbegin",
				"label" 			=> nxs_l18n__("Flowcontrol", "nxs_td"),
			),
			
			array(
				"id" 				=> "flow_stopruleprocessingonmatch",
				"type" 				=> "checkbox",
				"label" 			=> nxs_l18n__("Stop flow on match", "nxs_td"),
			),	
		
			array( 
				"id" 				=> "wrapper_flowcontrol_end",
				"type" 				=> "wrapperend"
			),			
		) 
	);
		
	return $options;
}

/* WIDGET HTML
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------- */

function nxs_widgets_woobusrulearchiveprodcatdyncontent_render_webpart_render_htmlvisualization($args) 
{	
	// Importing variables
	extract($args);

	// Setting the widget name variable to the folder name
	$widget_name = basename(dirname(__FILE__));

	// Every widget needs it's own unique id for all sorts of purposes
	// The $postid and $placeholderid are used when building the HTML later on
	$temp_array = nxs_getwidgetmetadata($postid, $placeholderid);
	
	// The $mixedattributes is an array which will be used to set various widget specific variables (and non-specific).
	$mixedattributes = array_merge($temp_array, $args);
	
	// Output the result array and setting the "result" position to "OK"
	$result = array();
	$result["result"] = "OK";
	
	// Widget specific variables
	extract($mixedattributes);
	
	$hovermenuargs = array();
	$hovermenuargs["postid"] = $postid;
	$hovermenuargs["placeholderid"] = $placeholderid;
	$hovermenuargs["placeholdertemplate"] = $placeholdertemplate;
	$hovermenuargs["enable_decoratewidget"] = false;
	$hovermenuargs["enable_deletewidget"] = false;
	$hovermenuargs["enable_deleterow"] = true;
	$hovermenuargs["metadata"] = $mixedattributes;
	nxs_widgets_setgenericwidgethovermenu_v2($hovermenuargs);

	
	// Turn on output buffering
	ob_start();
	
	global $nxs_global_placeholder_render_statebag;
	if ($shouldrenderalternative == true) {
		$nxs_global_placeholder_render_statebag["widgetclass"] = "nxs-" . $widget_name . "-warning ";
	} else {
		// Appending custom widget class
		$nxs_global_placeholder_render_statebag["widgetclass"] = "nxs-" . $widget_name . " ";
	}
	
	
	/* EXPRESSIONS
	---------------------------------------------------------------------------------------------------- */
	// Check if specific variables are empty
	// If so > $shouldrenderalternative = true, which triggers the error message
	$shouldrenderalternative = false;
	/*
	if (
	$person == "" &&
	nxs_has_adminpermissions()) {
		$shouldrenderalternative = true;
	}
	*/
	
	/* OUTPUT
	---------------------------------------------------------------------------------------------------- */

	if ($shouldrenderalternative) 
	{
		nxs_renderplaceholderwarning(nxs_l18n__("Missing input", "nxs_td")); 
	} 
	else 
	{
		
		$output = "Woo Product in product category having matching content template";
		$filteritemshtml = $output;
		$iconids = array("nxs-icon-cart", nxs_widgets_woobusrulearchiveprodcatdyncontent_geticonid(), "nxs-icon-shuffle");
		
		$mixedattributes["content_postid"] = "@template@Slug " . $contentslugtemplate;
		nxs_widgets_busrule_pagetemplate_renderrow($iconids, $filteritemshtml, $mixedattributes);
	} 
	
	/* ------------------------------------------------------------------------------------------------- */
	 
	// Setting the contents of the output buffer into a variable and cleaning up te buffer
	$html = ob_get_contents();
	ob_end_clean();
	
	// Setting the contents of the variable to the appropriate array position
	// The framework uses this array with its accompanying values to render the page
	$result["html"] = $html;	
	$result["replacedomid"] = 'nxs-widget-' . $placeholderid;
	return $result;
}

function nxs_widgets_woobusrulearchiveprodcatdyncontent_initplaceholderdata($args)
{
	extract($args);

	$args["flow_stopruleprocessingonmatch"] = "true";
	// add more initialization here if needed ...
	
	nxs_mergewidgetmetadata_internal($postid, $placeholderid, $args);
	
	$result = array();
	$result["result"] = "OK";
	
	return $result;
}

function nxs_busrule_woobusrulearchiveprodcatdyncontent_process($args, &$statebag)
{
	$result = array();
	$result["result"] = "OK";

	$metadata = $args["metadata"];
	
	if (false) // is_product_category()) // deze functie zou niet bestaan?
	{		
		$result["ismatch"] = "false";
		$contentslugtemplate = $metadata["contentslugtemplate"];	
		// contentslugtemplate example: "productcatarchive-{{{prodcatslug}}}-content";

		if ($contentslugtemplate != "")
		{
			$token = "{{{prodcatslug}}}";
			
			// get terms of "this" product
			global $post;
			$terms = get_the_terms( $post->ID, 'product_cat' ); 
			foreach ($terms as $currentterm) 
			{
				// derive the slug of the content templatepart to look for
				$prodcatslug = $currentterm->slug;
				$contentslug = str_replace($token, $prodcatslug, $contentslugtemplate);
  			// see if there's posts that match
				$posts = get_posts(array('name' => $contentslug, 'post_type' => 'nxs_templatepart'));
				if (count($posts) == 0)
				{
					// no content templatepart found with that slug; ignoring
				}
				else if (count($posts) == 1)
				{
					// found exactly one match for this slug
	  			$result["ismatch"] = "true";
	  			
	  			// process configured site wide elements
	  			$sitewideelements = nxs_pagetemplates_getsitewideelements();
	  			foreach($sitewideelements as $currentsitewideelement)
	  			{
	  				if ($currentsitewideelement == "content_postid")
	  				{
	  					$selectedvalue = $posts[0]->ID;
	  					$statebag["out"][$currentsitewideelement] = $selectedvalue;
	  				}
	  				else
	  				{
		  				$selectedvalue = $metadata[$currentsitewideelement];
		  				if ($selectedvalue == "")
		  				{
		  					// skip
		  				} 
							else if ($selectedvalue == "@leaveasis")
		  				{
		  					// skip
		  				}
		  				else if ($selectedvalue == "@suppressed")
		  				{
		  					// reset
		  					$statebag["out"][$currentsitewideelement] = 0;
		  				}
		  				else
		  				{
		  					// set the value as selected
								$statebag["out"][$currentsitewideelement] = $metadata[$currentsitewideelement];
		  				}
		  			}
	  			}
	
					// instruct rule engine to stop further processing if configured to do so (=default)
	  			$flow_stopruleprocessingonmatch = $metadata["flow_stopruleprocessingonmatch"];
	  			if ($flow_stopruleprocessingonmatch != "")
	  			{
						$result["stopruleprocessingonmatch"] = "true";
					}
					break;
				}
				else
				{
					// multiple ones found?
					nxs_webmethod_return_nack("warning; multiple slugs found; $contentslug");
				}
			}		
		}
		else
		{
			// empty template is ignored
		}
	}
	else
	{
		$result["ismatch"] = "false";
	}
	
	return $result;
}

?>
