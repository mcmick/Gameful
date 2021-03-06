<?php
/**
 * Created by PhpStorm.
 * User: mmcmurray
 * Date: 1/2/19
 * Time: 12:51 AM
 */


/**
 *
 */
function go_make_map($taxonomy = 'task_chains', $link_to_tasks = true) {
    if($taxonomy === 'store_types'){
        $is_store = true;
    }else{
        $is_store = false;
    }
    echo "<div id='go_map_container' >";
    //$map_title = get_option( 'options_go_locations_map_title');
    //echo "<h1>{$map_title}</h1>";

    if($is_store) {
        $header = get_option('options_go_store_store_header');
    }else{
        $header = get_option( 'options_go_locations_map_map_header');
    }

    if($header){
        $header = apply_filters( 'go_awesome_text', $header );
        echo "<div class='map_header'>$header</div>";
    }
    //go_make_map_dropdown();
    go_make_single_map($link_to_tasks,null, false, $taxonomy);// do your thing
    echo "</div>";

}
add_shortcode('go_make_map', 'go_make_map');

//this can't be wrapped in the toggle = true because it needs to be available on activation
add_action('init', 'go_map_page');
function go_map_page(){
    if(is_gameful() && is_main_site()){
    	$hide = true;
    }
    else{
    	$hide = false;
    }
    if (!$hide) {
        $map_name = get_option('options_go_locations_map_map_link');
        //add_rewrite_rule( "store", 'index.php?query_type=user_blog&uname=$matches[1]', "top");
        add_rewrite_rule($map_name, 'index.php?' . $map_name . '=true', "top");
    }
}



$go_map_switch = get_option( 'options_go_locations_map_toggle' );

if ($go_map_switch) {

// Query Vars
    add_filter('query_vars', 'go_map_register_query_var');
    function go_map_register_query_var($vars)
    {
        $map_name = get_option('options_go_locations_map_map_link');
        $vars[] = $map_name;
        return $vars;
    }


    /* Template Include */
    add_filter('template_include', 'go_map_template_include', 1, 1);
    function go_map_template_include($template)
    {
        if(is_gameful() && is_main_site()){
    		$hide = true;
    	}
    	else{
    		$hide = false;
  	 	}
  	  	if (!$hide) {

            $map_name = get_option('options_go_locations_map_map_link');
            $map_name = (isset($map_name) ?  $map_name : 'map');
            global $wp_query; //Load $wp_query object

            $page_value = (isset($wp_query->query_vars[$map_name]) ? $wp_query->query_vars[$map_name] : false); //Check for query var "blah"

            if ($page_value && $page_value == "true") { //Verify "blah" exists and value is "true".
                $GLOBALS['current_theme_template'] = 'map';
                return plugin_dir_path(__FILE__) . 'templates/go_map_template.php'; //Load your template or file
            }

            /*
            $page_name = (isset($wp_query->query_vars['pagename']) ? $wp_query->query_vars['pagename'] : false);
            if ($page_name == $map_name) { //Verify "blah" exists and value is "true".
                return plugin_dir_path(__FILE__) . 'templates/go_map_template.php'; //Load your template or file
            }*/


        }
        return $template; //Load normal template when $page_value != "true" as a fallback
    }

}

