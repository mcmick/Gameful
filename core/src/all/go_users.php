<?php
/**
 * Created by PhpStorm.
 * User: mmcmurray
 * Date: 10/13/18
 * Time: 8:06 PM
 */





/**
 * Get user's first and last name, else just their first name, else their
 * display name. Defalts to the current user if $user_id is not provided.
 *
 * @param  mixed  $user_id The user ID or object. Default is current user.
 * @return string          The user's name.
 */
function go_get_users_name( $user_id = null ) {
    $user_info = $user_id ? new WP_User( $user_id ) : wp_get_current_user();
    if ( $user_info->first_name ) {
        if ( $user_info->last_name ) {
            return $user_info->first_name . ' ' . $user_info->last_name;
        }
        return $user_info->first_name;
    }
    return $user_info->display_name;
}

/**
 * Determines whether or not a user is an administrator with management capabilities.
 *
 * @since 3.0.0
 *
 * @param int $user_id Optional. The user ID.
 * @return boolean True if the user has the 'administrator' role and has the 'manage_options'
 *                 capability. False otherwise.
 */
function go_user_is_admin( $user_id = null ) {
    if ( empty( $user_id ) ) {
        $user_id = get_current_user_id();
    } else {
        $user_id = (int) $user_id;
    }

    if(user_can( $user_id, 'manage_options' )) {
        return true;
    }
    return false;
}



// Adds user id to the totals table upon user creation.
function go_user_registration ( $user_id ) {
    global $wpdb;
    $table_name_go_totals = "{$wpdb->prefix}go_loot";
    $table_name_capabilities = "{$wpdb->prefix}capabilities";
    $role = get_option( 'go_role', 'subscriber' );
    $user_role = get_user_option("{$table_name_capabilities}", $user_id);
    if ( array_search( 1, $user_role ) == $role || array_search( 1, $user_role ) == 'administrator' ) {

        // this should update the user's rank metadata
        //go_update_ranks( $user_id, 0 );

        // this should set the user's points to 0
        $wpdb->insert( $table_name_go_totals, array( 'uid' => $user_id), array( '%s' ) );
    }
}

// Deletes all rows related to a user in the individual and total tables upon deleting said user.
function go_user_delete( $user_id ) {
    global $wpdb;
    $table_name_go_totals = "{$wpdb->prefix}go_loot";
    $table_name_go_tasks = "{$wpdb->prefix}go_tasks";
    $table_name_go_actions = "{$wpdb->prefix}go_actions";

    $wpdb->delete( $table_name_go_totals, array( 'uid' => $user_id ) );
    $wpdb->delete( $table_name_go_tasks, array( 'uid' => $user_id ) );
    $wpdb->delete( $table_name_go_actions, array( 'uid' => $user_id ) );
}


function go_add_user_to_totals_table_at_login($user_login, $user){
    $user_id = $user->ID;

    go_add_user_to_totals_table($user_id);
}
add_action('wp_login', 'go_add_user_to_totals_table_at_login', 10, 2);


