<?php

if(!defined('e107_INIT'))
{
	exit();
}

if (!defined('e107_INIT')) {
    exit();
}
 
 $sitetheme = deftrue('USERTHEME', e107::getPref('sitetheme'));  
e107::getSingleton('theme_settings', e_THEME.$sitetheme."/theme_settings.php");

////// Multilanguages/ /////////////////////////////////////////////////////////
e107::lan('theme');

////////////////////////////////////////////////////////////////////////////////
define("THEME_LEGACY",false); //warning it is ignored somewhere
define("THEME_DISCLAIMER", 'Copyright &copy; 2015 Skin by <a href="http://artphilia.de">Artphilia Designs</a>. All rights reserved.');
////// Your own css fixes ////////////////////////////////////////////////////
define("CORE_CSS", true);  //copy core e107.css to theme and remove problematic rules 

/* way how to avoid loading libraries by core **********************************/
define("BOOTSTRAP",  5);
define("FONTAWESOME",  5);

e107::getParser()->setBootstrap(5);
e107::getParser()->setFontAwesome(5);

function fake() {
  $fake = "font-awesome.min.css";
  $fake = "bootstrap.min.js";
  $fake = "bootstrap.min.css";
}

/* LAYOUTS */
$layout = '_default';

/* we need 2 headers */
$LAYOUT['_header_'] = '';
$LAYOUT['_footer_'] = '';

/*  default values */ 
$elements['search_shortcode'] = "{SEARCH}";
$elements['topnav_shortcode'] = '{SIGNIN}';
$elements['navbar_shortcode'] = '{NAVIGATION=main}';
$elements['slogan_shortcode'] = '{SITETAG}';
$elements['sitename_shortcode'] = '{SITENAME}';
$elements['footer_message'] = ''; 
$elements['skinchange_block'] = '{SETSTYLE=default}{MENU: path=skinchange/skinchange}'; 

$LAYOUT_SIDEBAR = 
'{SETSTYLE=block-sidebar}
  {MENU=1}
  {DEFAULT_MENUAREA=1}
  
  {SETSTYLE=sidebar}
  {MENU=2}
  {DEFAULT_MENUAREA=2}
  
  {SETSTYLE=block-sidebar}
  {MENU=3}
  {DEFAULT_MENUAREA=3}
  <div class="text-center">'.$elements['search_shortcode'].'</div>
 ';
$elements['layout_sidebar']     = $LAYOUT_SIDEBAR; 


$LAYOUT_HEADER =  theme_settings::layout_header($elements);
$LAYOUT_FOOTER =  theme_settings::layout_footer($elements);

$LAYOUT['index'] = $LAYOUT_HEADER.'
<div class="gb-full">
	<div class="gb-50">{WMESSAGE}</div>
	<div class="gb-50">{ALERTS}{SETSTYLE=main}{---}{MENU=4}</div>
</div>'.$LAYOUT_FOOTER;

$LAYOUT['full'] = $LAYOUT_HEADER.' 
{ALERTS}{SETSTYLE=main}<div class="gb-full">{---}</div>'.$LAYOUT_FOOTER;

$LAYOUT['default'] = $LAYOUT_HEADER.'
<div class="gb-full">
	<div class="gb-70">{ALERTS}{SETSTYLE=main}{---}</div>
	<div class="gb-30">'.$LAYOUT_SIDEBAR.'</div>
</div>'.$LAYOUT_FOOTER;

/* only in case efiction plugin is installed, otherwise use default shortcodes */
if(e107::isInstalled('efiction'))
{ 
    $elements['search_shortcode'] = "{EFICTION_BLOCK_CONTENT: key=search}";
    $elements['topnav_shortcode'] = '<span class="fa fa-power-off"></span> {adminarea}{SIGNIN}';
    $elements['navbar_shortcode'] = '{EFICTION_BLOCK_CONTENT: key=menu}';
    $elements['slogan_shortcode'] = '{SITETAG}';
    $elements['sitename_shortcode'] = '{SITENAME}';  
    $elements['layout_sidebar']     = ''; 
    $elements['skinchange_block']  = "{SETSTYLE=default}{MENU: path=skinchange/skinchange}";
    $elements['footer_message'] = "{footer}"; 
 
    $LAYOUT_HEADER =  theme_settings::layout_header($elements);
    $LAYOUT_FOOTER =  theme_settings::layout_footer($elements);
}

$LAYOUT['efiction'] = $LAYOUT_HEADER.'{ALERTS}
{---}'.$LAYOUT_FOOTER;

 
 
 
////// Theme meta tags /////////////////////////////////////////////////////////
set_metas();

/////// Theme css  /////////////////////////////////////////////////////////////
register_css();

/////// Theme js  /////////////////////////////////////////////////////////////
register_js();

/////// Theme fonts ///////////////////////////////////////////////////////////
register_fonts();

/////// Theme icons ///////////////////////////////////////////////////////////
register_icons();

getInlineCodes();
 
function set_metas()
{
    e107::meta('viewport', 'width=device-width, initial-scale=1.0');
}

function register_css()
{
    e107::css('theme', 'css/bootstrap.css');
	e107::css('theme', 'css/skin.css');
 
	e107::css('theme', 'e107.css');
}
            
function register_js()
{
    e107::js('theme', 'js/bootstrap.bundle.min.js', 'jquery');

	e107::js('theme', 'fix.js', 'jquery'); 
}
           
function register_fonts()
{
 
  e107::css('url', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=latin-ext');
  e107::css('url', 'https://fonts.googleapis.com/css?family=Courgette&display=swap&subset=latin-ext');
  e107::css('url', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');
}
          
function register_icons()
{
}
function getInlineCodes()
{
	$inlinecss = e107::pref('theme', 'custom_css', false);
	if ($inlinecss) {
		e107::css("inline", $inlinecss);
	}
	$inlinejs = e107::pref('theme', 'inlinejs');
	if ($inlinejs) {
		e107::js("footer-inline", $inlinejs);
	}
}

/**
 * @param string $text
 * @return string without p tags added always with bbcodes
 * note: this solves W3C validation issue and CSS style problems
 * use this carefully, mainly for custom menus, let decision on theme developers
 */

function remove_ptags($text = '') // FIXME this is a bug in e107 if this is required.
{
	$text = str_replace(array("<!-- bbcode-html-start --><p>", "</p><!-- bbcode-html-end -->"), "", $text);

	return $text;
}


	function tablestyle($caption, $text, $mode, $options = array())
	{

		$style = varset($options['setStyle'], 'default');
		
		if (e_DEBUG) {
			echo "
			<!-- tablestyle initial:  style=" . $style . "  mode=" . $mode . "  UniqueId=" . varset($options['uniqueId']) . " -->
			";
			echo "\n<!-- \n";

			echo json_encode($options, JSON_PRETTY_PRINT);

			echo "\n-->\n\n";
		}

		switch ($mode) {
			case 'wmessage':
			case 'wm':
				$style = 'wmessage';
			break;
			case 'login_page':
				$style = 'none';

			case "news":
					
			break;

		}

		if (e_DEBUG) {
			echo "
			<!-- tablestyle initial:  style=" . $style . "  mode=" . $mode . "  UniqueId=" . varset($options['uniqueId']) . " -->
			";
			echo "\n<!-- \n";

			echo json_encode($options, JSON_PRETTY_PRINT);

			echo "\n-->\n\n";
		}

		switch($style)
		{
 	
			//      <h1><span>{news_title}</span></h1>{news_content}
			case 'main': 
			case 'wmessage':	
					if(!empty($caption))
					{
						echo '<h1><span>' . $caption . '</span></h1><br>';
					}
					echo $text;      

			break;  
			
			case 'none':
			case 'nocaption':			
					echo $text;
			break;

			case "block-sidebar": {
				
				if (!empty($caption)) {
					echo '<h3><span>' . $caption . '</span></h3>';   
					//  echo $caption;
				}
				echo $text;
				echo "<br /><br />";  //fix me with margin
				break;
			}     

			case "sidebar": {
				echo '<div align="center">';
				if (!empty($caption)) {
					 echo $caption;
				}
				echo $text;
				echo "</div>";  //fix me with margin
				break;
			}
			   
			default:

			// default style
			// only if this always work, play with different styles

			if(!empty($caption))
			{
				echo  $caption  ;
			}
			echo $text;

			return;      
		}

	}

    
    
 



 