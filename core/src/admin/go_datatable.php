<?php
//https://codex.wordpress.org/Creating_Tables_with_Plugins
global $wpdb;


go_update_db_check();

function go_update_db_check() {
    $go_db_version = 5.81;
    $old_version = get_option( 'go_db_version' );

    if ( $old_version != $go_db_version ) {

        update_option('go_db_version', $go_db_version);

        go_update_db();

        if ($old_version > 3 && $old_version < 5) {
            go_update_go_to_v5();//update the tasks and blogs to v5 if this is an upgrade from v4
        }
    }

}
//add_action( 'plugins_loaded', 'go_update_db_check' );

function go_update_db() {
    go_table_totals();
    go_table_tasks();
    go_table_actions();
    go_install_data();
    //go_set_options_autoload(); //legacy function
    //go_convert_all_featured_images();
}

function go_table_tasks() {
    global $wpdb;
    $table_name = "{$wpdb->prefix}go_tasks";
    $sql = "
		CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			uid bigint(20),
			post_id bigint(20),
			status TINYINT,
			bonus_status TINYINT DEFAULT 0,
			xp INT unsigned,
			gold DECIMAL (10,2) unsigned,
			health DECIMAL (10,2) unsigned,
			badges VARCHAR (4096),
			groups VARCHAR (4096),
			start_time datetime,
			last_time datetime,
			timer_time datetime,
			class VARCHAR (4096),
			favorite TINYINT DEFAULT 0,
			PRIMARY KEY  (id),
            KEY uid (uid),
            KEY post_id (post_id),
            KEY uid_post (uid, post_id)        
		);
	";
    require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    drop_index( $table_name, 'last_time' );
}

function go_table_actions() {
    global $wpdb;
    $table_name = "{$wpdb->prefix}go_actions";
    $sql = "
		CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			uid bigint(20),
			action_type VARCHAR (200),
			source_id bigint(20),
			TIMESTAMP datetime,
			stage TINYINT,
			bonus_status TINYINT,
			check_type VARCHAR (200),
			result TEXT,
			quiz_mod DECIMAL (10,2),
			late_mod DECIMAL (10,2),
			timer_mod DECIMAL (10,2),
			global_mod DECIMAL (10,4),
			xp INT,
			gold DECIMAL (10,2),
			health DECIMAL (10,2),
			badges VARCHAR (4096),
			groups VARCHAR (4096),
			xp_total INT unsigned,
			gold_total DECIMAL (10,2) unsigned,
			health_total DECIMAL (10,2) unsigned,
			PRIMARY KEY  (id),
            KEY uid (uid),
            KEY source_id (source_id),
            KEY action_type (action_type ),
            KEY uid_source (uid, source_id)
            
		);
	";
    require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    drop_index( $table_name, 'uid_date' );
    drop_index( $table_name, 'TIMESTAMP' );

}

function go_table_totals() {
    global $wpdb;
    $table_name = "{$wpdb->prefix}go_loot";
    $sql = "
		CREATE TABLE $table_name (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			uid bigint(20) NOT NULL UNIQUE,
			xp INT unsigned DEFAULT 0,
			gold DECIMAL (10,2) unsigned DEFAULT 0,
			health DECIMAL (10,2) unsigned DEFAULT 0, 
			badge_count INT DEFAULT 0,
			PRIMARY KEY (id)               
		);
	";

    require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/*
//this is just for older installs (before v4) that didn't have the autoload on
function go_set_options_autoload(){
    $options_array = array(
        'options_go_tasks_name_singular',
        'options_go_tasks_name_plural',
        'options_go_tasks_stage_name_singular',
        'options_go_tasks_stage_name_plural',
        'options_go_tasks_optional_task',
        'options_go_tasks_bonus_stage',
        'options_go_store_toggle',
        'options_go_store_name',
        'options_go_store_store_link',
        'options_go_store_store_receipts',
        'options_go_badges_toggle',
        'options_go_badges_name_singular',
        'options_go_badges_name_plural',
        'options_go_groups_toggle',
        'options_go_groups_name_singular',
        'options_go_groups_name_plural',
        'options_go_stats_toggle',
        'options_go_blogs_toggle',
        'options_go_stats_name',
        'options_go_stats_leaderboard_toggle',
        'options_go_stats_leaderboard_name',
        'options_go_locations_map_toggle',
        'options_go_locations_map_title',
        'options_go_locations_map_map_link',
        'options_go_loot_name',
        'options_go_loot_xp_toggle',
        'options_go_loot_gold_toggle',
        'options_go_loot_health_toggle',

        'options_go_loot_xp_name',
        'options_go_loot_gold_name',
        'options_go_loot_health_name',

        'options_go_loot_xp_abbreviation',
        'options_go_loot_gold_abbreviation',
        'options_go_loot_health_abbreviation',

        'options_go_loot_xp_levels_name_singular',
        'options_go_loot_xp_levels_name_plural',
        'options_go_loot_xp_levels_growth',

        'options_go_loot_bonus_loot_toggle',
        'options_go_loot_bonus_loot_name',

        'options_go_seats_name',
        'options_go_seats_number',

        'options_go_video_width_unit',
        'options_go_video_width_pixels',
        'options_go_video_lightbox',

        //'options_go_images_resize_toggle',
        //'options_go_images_resize_longest_side',

        'options_go_guest_global',
        'options_go_full-names_toggle',
        'options_go_search_toggle',

        'options_go_dashboard_toggle',
        'options_go_admin_bar_toggle',

        'options_go_slugs_toggle',

        'options_go_avatars_local'

    );

    foreach ( $options_array as $option ) {//autoload must be set on creation of option
        $value = get_option($option); //get the value if it exists
        if ($value) {//if value already exists, set the value
            delete_option($option);
        }
        update_option( $option, $value, true );//update the value
    }
}
*/

function go_install_data ($reset = false) {

    $options_array = array(
        'options_go_tasks_name_singular' => 'Quest',
        'options_go_tasks_name_plural' => 'Quests',
        'options_go_tasks_stage_name_singular' => 'Stage',
        'options_go_tasks_stage_name_plural' => 'Stages',
        'options_go_tasks_optional_task' => 'Bonus',
        'options_go_tasks_bonus_stage' => 'Bonus Stage',
        'options_go_store_toggle' => 1,
        'options_go_store_name' => 'Store',
        'options_go_store_store_link' => 'store',
        'options_go_store_store_receipts' => 0,
        'options_go_badges_toggle' => 1,
        'options_go_badges_name_singular' => 'Badge',
        'options_go_badges_name_plural' => 'Badges',
        'options_go_groups_toggle' => 1,
        'options_go_groups_name_singular' => 'Group',
        'options_go_groups_name_plural' => 'Groups',
        'options_go_stats_toggle' => 1,
        'options_go_blogs_toggle' => 1,
        'options_go_stats_name' => 'Stats',
        'options_go_stats_leaderboard_toggle' => 1,
        'options_go_stats_leaderboard_name' => 'Leaderboard',
        'options_go_locations_map_toggle' => 1,
        'options_go_locations_map_name' => 'Map',
        'options_go_locations_map_title' => 'Map',
        'options_go_locations_map_map_link' => 'map',
        'options_go_loot_name' => 'Loot',
        'options_go_loot_xp_toggle' => 1,
        'options_go_loot_gold_toggle' => 1,
        'options_go_loot_health_toggle' => 1,

        'options_go_loot_xp_name' => 'Experience Points',
        'options_go_loot_gold_name' => 'Gold',
        'options_go_loot_health_name' => 'Reputation',

        'options_go_loot_xp_abbreviation' => 'XP',
        'options_go_loot_gold_abbreviation' => 'G',
        'options_go_loot_health_abbreviation' => 'REP',

        'options_go_loot_gold_currency' => 'coins',
        'options_go_loot_gold_coin_names_gold_coin_name' => 'Gold',
        'options_go_loot_gold_coin_names_gold_coin_abbreviation' => 'G',
        'options_go_loot_gold_coin_names_silver_name' => 'Silver',
        'options_go_loot_gold_coin_names_silver_abbreviation' => 'S',
        'options_go_loot_gold_coin_names_copper_name' => 'Copper',
        'options_go_loot_gold_coin_names_copper_abbreviation' => 'C',

        'options_go_loot_health_starting' => 50,
        'options_go_loot_health_bankruptcy_penalty' => 5,
        'options_go_loot_health_max_health_mod' => 200,

        'options_go_loot_xp_levels_name_singular' => 'Level',
        'options_go_loot_xp_levels_name_plural' => 'Levels',
        'options_go_loot_xp_levels_growth' => '5',
        'options_go_loot_xp_levels_go_first_level_up' => 50,

        'options_go_loot_bonus_loot_toggle' => 1,
        'options_go_loot_bonus_loot_name' => 'Bonus Loot',

        'options_go_seats_name' => 'Seat',
        'options_go_seats_number' => '40',

        'options_go_video_width_unit' => 'px',
        'options_go_video_width_pixels' => '500',
        'options_go_video_lightbox' => '1',

        'options_go_images_resize_toggle' => 1,

        'options_go_guest_global' => 'regular',
        'options_go_full-names_toggle' => false,
        'options_go_search_toggle' => 0,

        'options_go_dashboard_toggle' => 0,
        'options_go_admin_bar_toggle' => 1,

        'options_go_slugs_toggle' => 1,

        'options_go_avatars_local' => 1,

        'options_go_user_bar_background_color' => '#268FBB',
        'options_go_user_bar_link_color' => '#FFFFFF',
        'options_go_user_bar_hover_color' => '#a0a5aa',
        'options_go_home_toggle' => 1,
    );
    foreach ( $options_array as $key => $value ) {
        add_option( $key, $value, '', 'yes' );
    }
    if($reset){
        update_option( $key, $value, true );
    }

    //For Repeater Fields Sections
    $isset = get_option('options_go_sections'); //if there are no sections at all
    if ($isset == false){
        add_option('options_go_sections', 7);
        add_option('options_go_sections_0_section', 'Period 1');
        add_option('options_go_sections_1_section', 'Period 2');
        add_option('options_go_sections_2_section', 'Period 3');
        add_option('options_go_sections_3_section', 'Period 4');
        add_option('options_go_sections_4_section', 'Period 5');
        add_option('options_go_sections_5_section', 'Period 6');
        add_option('options_go_sections_6_section', 'Period 7');

    }

    //For Levels
    $isset = get_option('options_go_loot_xp_levels_level'); //if there are no level at all
    if ($isset == false){
        add_option('options_go_loot_xp_levels_level', 15);
        add_option('options_go_loot_xp_levels_level_0_xp', 0);
        add_option('options_go_loot_xp_levels_level_1_xp', 100);
        add_option('options_go_loot_xp_levels_level_2_xp', 150);
        add_option('options_go_loot_xp_levels_level_3_xp', 225);
        add_option('options_go_loot_xp_levels_level_4_xp', 337);
        add_option('options_go_loot_xp_levels_level_5_xp', 505);
        add_option('options_go_loot_xp_levels_level_6_xp', 757);
        add_option('options_go_loot_xp_levels_level_7_xp', 1135);
        add_option('options_go_loot_xp_levels_level_8_xp', 1702);
        add_option('options_go_loot_xp_levels_level_9_xp', 2553);
        add_option('options_go_loot_xp_levels_level_10_xp', 3829);
        add_option('options_go_loot_xp_levels_level_11_xp', 5743);
        add_option('options_go_loot_xp_levels_level_12_xp', 8614);
        add_option('options_go_loot_xp_levels_level_13_xp', 12921);
        add_option('options_go_loot_xp_levels_level_14_xp', 19381);
        add_option('options_go_loot_xp_levels_level_14_name', 'Guru');
    }

    //For Levels
    $isset = get_option('options_go_feedback_canned'); //if there is no canned feedback, add the defaults
    if ($isset == false){
        add_option('options_go_feedback_canned', 3);
        add_option('options_go_feedback_canned_0_title', 'Needs revision');
        add_option('options_go_feedback_canned_0_message', 'Please revise this post.');
        add_option('options_go_feedback_canned_0_defaults_xp', 0);
        add_option('options_go_feedback_canned_0_defaults_gold', 0);
        add_option('options_go_feedback_canned_0_defaults_health', 0);
        add_option('options_go_feedback_canned_1_title', 'Great work');
        add_option('options_go_feedback_canned_1_message', 'Great job!  Here is some extra loot.');
        add_option('options_go_feedback_canned_1_defaults_xp', 10);
        add_option('options_go_feedback_canned_1_defaults_gold', 10);
        add_option('options_go_feedback_canned_1_defaults_health', 0);
    }
}

//not sure what this does, but it is in an activation hook
function go_open_comments() {
    global $wpdb;
    $wpdb->update( $wpdb->posts, array( 'comment_status' => 'open', 'ping_status' => 'open' ), array( 'post_type' => 'tasks' ) );
}


function go_convert_all_featured_images(){
    //get all posts
    //for each post
    $args = array(
        'post_type' => 'tasks',
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
            )
        )
    );
    $query = new WP_Query($args);

    $posts = $query->posts;
    foreach($posts as $post){
        $image_id = get_post_meta($post->ID,'_thumbnail_id');
        $image_id = $image_id[0];
        $post_id = $post->ID;
        update_post_meta( $post_id, 'go_featured_image', $image_id );
        //delete_post_meta( $post_id, '_thumbnail_id' );
        $key = 'go_post_data_' . $post_id;
        go_delete_transient($key);

    }


    //if it has featured image
    //set new featured image
    //remove old retured image
}



?>