<?php

//var_dump(e107::getPref('membersonly_enabled'));

class theme_settings
{
   public function layout_header($elements = array())  {
 
        $defaults['search_shortcode'] = "{SEARCH}";
        $defaults['topnav_shortcode'] = '{SIGNIN}';
        $defaults['navbar_shortcode'] = '{NAVIGATION}';
        $defaults['slogan_shortcode'] = '{SITETAG}';
        $defaults['sitename_shortcode'] = '{SITENAME}';  
        $defaults['layout_sidebar']     = '{SETSTYLE=block-sidebar}{MENU=1}'; 
        
        $parms = array_merge($defaults, $elements);
 
        extract($parms);
 
        $LAYOUT_HEADER = 
        '<div class="login"><span class="fa fa-sign-in"></span> '.$topnav_shortcode.' '.$search_shortcode.'</div>
         <div id="sitename">'.$sitename_shortcode.'</div>
         <div id="spacer"></div>
         <div id="slogan">'.$slogan_shortcode.'</div>
         <div id="menu">'.$navbar_shortcode.'</div>
         <div class="grid-wrapper container">	
         <div class="gb-full content">'	 		
        ;
        return $LAYOUT_HEADER;  
    }
    
    
    public function layout_footer($elements = array())  {
 
        $defaults['footer_message'] = "";
        $defaults['skinchange_block'] = '';
        
        $parms = array_merge($defaults, $elements);
 
        extract($parms);

        $LAYOUT_FOOTER  = 
          ' 
              <!-- START BLOCK : footer -->
              <div class="gb-full footer">
          		<hr />
          		'.$footer_message.'
          		{SITEDISCLAIMER}
          		<div class="copyright">{THEME_DISCLAIMER}</div>'.$skinchange_block.'
              </div>
          </div> <!-- closing content grid -->   			
          <!-- END BLOCK : footer -->
          </div><!-- closing container -->'; 
                 
         
        
        return $LAYOUT_FOOTER;  
    }
    
    public static function login_template_settings()
    {
    
       if(e107::getPref('membersonly_enabled')) {
         return self::get_membersonly_template();
       }
        /* this is workaround for e_IFRAME fatal error in PHP 8 to display standalone login page */       	
     	$tmp['page_start'] =  self::layout_header();
        $tmp['page_end']   =  self::layout_footer();
        $tmp['page_logo'] = "";
        return $tmp;    
    
    }        
    
    public static function signup_template_settings()
    {
    
       if(e107::getPref('membersonly_enabled')) {
         return self::get_membersonly_template();
       }
       else {
         return self::login_template_settings();
       }
    } 
    
    public static function get_membersonly_template()
    {
        
        /* let there only what you want for quests to see or use HTML markup directly */
        $defaults['search_shortcode'] = " ";
        $defaults['topnav_shortcode'] = '{SIGNIN}';
        $defaults['navbar_shortcode'] = ' ';
        $defaults['slogan_shortcode'] = '{SITETAG}';
        $defaults['sitename_shortcode'] = '{SITENAME}';  
        $defaults['layout_sidebar']     = ' '; 
        
        
        /* this is workaround for e_IFRAME fatal error in PHP 8 to display standalone login page */       	
     	$tmp['page_start'] =  self::layout_header($defaults);
        $tmp['page_end']   =  self::layout_footer($defaults);
        $tmp['page_logo'] = "";

        return $tmp;
    }
 
    public static function get_linkstyle() {
    
 
            $link_settings['main']['dropdown_on'] = " ";
    
            /* 1.st level ul */
            $link_settings['main']['prelink'] = '<ul class="sitelinks-navbar navbar-nav mx-auto">';
            $link_settings['main']['postlink'] = '</ul>';
            /* 1.st level li */ 
            $link_settings['main']['linkstart'] = '<li class="nav-item">';
            $link_settings['main']['linkstart_hilite'] = '<li id="menu_current"  class="nav-item active">';  //because bg hover otherwise a active is enough
            $link_settings['main']['linkstart_sub'] = '<li class="nav-item">';
            $link_settings['main']['linkstart_sub_hilite'] = '<li  class="nav-item active">';
            $link_settings['main']['linkcaret'] = '';
            $link_settings['main']['linkend'] = "</li>";
            
            /* 1.st level a */
            $link_settings['main']['linkclass'] = 'nav-link'; 
	        $link_settings['main']['linkclass_hilite'] = 'nav-link active';
            $link_settings['main']['linkclass_sub'] = 'nav-link'; 
            $link_settings['main']['linkclass_sub_hilite'] = 'nav-link';
 

            $link_settings['main_sub']['prelink'] = '<ul class="dropdown-menu">';
            $link_settings['main_sub']['postlink'] = '</ul>';
            
            $link_settings['main_sub']['linkstart'] = '<li class="linkstart">';
            $link_settings['main_sub']['linkstart_hilite'] = '<li class="linkstart active">';
            $link_settings['main_sub']['linkstart_sub'] = '<li class="dropend lower">';
            $link_settings['main_sub']['linkstart_sub_hilite'] = '<li class="active dropend lower">';
            $link_settings['main_sub']['linkcaret'] = '';
            $link_settings['main_sub']['linkend'] = '';
            
            $link_settings['main_sub']['linkclass'] = 'dropdown-item'; 
	        $link_settings['main_sub']['linkclass_hilite'] = 'dropdown-item active';
            $link_settings['main_sub']['linkclass_sub'] = 'dropdown-item dropdown-toggle'; 
            $link_settings['main_sub']['linkclass_sub_hilite'] = 'dropdown-item dropdown-toggle active';       
 
            $link_settings['main_sub_sub']['prelink'] = '<ul class="dropdown-menu">';
            $link_settings['main_sub_sub']['postlink'] = '</ul>';
  
            /* used for signin */ 
            $link_settings['alt'] = $link_settings['main'];
        
            $link_settings['alt']['prelink'] = '<ul class="navbar-nav">';
            $link_settings['alt']['linkdivider'] = '<li class="divider-vertical"></li>';
            $link_settings['alt']['linkcaret'] = '';
          
            $link_settings['alt_sub']['linkdivider'] = '<li><hr class="dropdown-divider"></li>';
            return $link_settings;
    }
    
    public static function class_submit_button($name ='') {
		$tmp ='btn btn-primary button';
		return $tmp;
	}
    
    //'.$theme_settings['forum_header_background'].'
    //'.$theme_settings['forum_table_background'].'
    //'.$theme_settings['forum_card_background'].'
    public static function get_forumstyle() {
    
        // use card only if something fails, maybe bootstrap update
    	$style['forum-card'] = 'card mb-3 ';
        
        // use card-header only if something fails, maybe bootstrap update
        $style['forum-card-header'] = 'card-header';
        
        //column labels, formelly th 
        //forumname uses wrapper f.e. h3
        $style['forum-card-title'] = 'card-title fw-bold ';
        
         //list-group-flush - use only if you need condensed look 
         //list-group is part of template
        $style['forum-list-group'] = ' list-group-striped list-group-hover';
       
        // bg-transparent -doesn't work with list-group-striped
        $style['forum-list-group-item'] = 'list-group-item p-3  ';
 
  
        return $style;
	}
    
}
