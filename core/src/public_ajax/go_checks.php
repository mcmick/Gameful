<?php
/**
 * Created by PhpStorm.
 * User: mcmurray
 * Date: 4/9/18
 * Time: 10:31 PM
 */


/**
 * Prints Checks for understanding for the current stage
 * @param $custom_fields
 * @param $i
 * @param $status
 * @param $user_id
 * @param $post_id
 * @param $bonus
 * @param $bonus_status
 * @param $repeat_max
 * @param $all_content
 */
function go_checks_for_understanding ($custom_fields, $i, $status, $user_id, $post_id, $bonus, $bonus_status, $repeat_max, $all_content){
    global $wpdb;
    $go_actions_table_name = "{$wpdb->prefix}go_actions";
    $stage_count = (isset($custom_fields['go_stages'][0]) ?  $custom_fields['go_stages'][0] : null); //total # of stages

    if ($bonus){
        $check_type = (isset($custom_fields['go_bonus_stage_check_v5'][0]) ?  $custom_fields['go_bonus_stage_check_v5'][0] : null);

    }
    else{
        $check_type = 'go_stages_' . $i . '_check_v5'; //which type of check to print
        //$check_type = $custom_fields[$check_type][0];
        $check_type = (isset($custom_fields[$check_type][0]) ?  $custom_fields[$check_type][0] : null);
    }


    $instructions = go_get_instructions($custom_fields, $bonus, $i);

    if ($bonus){
        if ($i == $repeat_max - 1 && $bonus_status == $repeat_max){
            $bonus_is_complete = true;
        }else{
            $bonus_is_complete = false;
        }
    }else{
        $bonus_is_complete = false;
    }

    if ($bonus){
        $status_active_check = $bonus_status;
    }else{
        $status_active_check = $status;
    }

    if($i == $status_active_check && $bonus_is_complete == false ){
        $class = 'active';
    }else{$class = 'null';}
    echo "<div class='go_checks_and_buttons {$class} autosave_wrapper go_show_actions' style='display:block;'>";



    if($bonus){
        $stage = 'bonus';
    }else{
        $stage = ($i + 1);
    }


    $blog_post_id = null;
    if ($check_type === 'blog') {

        $blog_post_id = go_blog_check($custom_fields, $i, $status, $user_id, $post_id, $bonus, $bonus_status, $all_content, $repeat_max, $check_type, $stage_count, $instructions);
    //} else if ($check_type == 'URL') {
        //go_url_check($custom_fields, $i, $status, $go_actions_table_name, $user_id, $post_id, $bonus, $bonus_status);
    //} else if ($check_type == 'upload') {
            //go_upload_check($custom_fields, $i, $status, $go_actions_table_name, $user_id, $post_id, $bonus, $bonus_status);
    } else if ($check_type == 'password') {
        echo $instructions;
        go_password_check($custom_fields, $i, $status, $go_actions_table_name, $user_id, $post_id, $bonus, $bonus_status);
    } else if ($check_type == 'quiz') {
        echo $instructions;
        go_test_check($custom_fields, $i, $status, $go_actions_table_name, $user_id, $post_id, $bonus, $bonus_status, false);
    } else if ($check_type == 'none' || $check_type == null) {
        echo $instructions;
        go_no_check($i, $status, $custom_fields, $bonus, $bonus_status);
    }


    if ($check_type === 'blog') {
        $show_all_post_button = true;
    }else{
        $show_all_post_button = false;
    }
       //blog posts add their own buttons with some extra stuff
        //Buttons
        go_buttons($custom_fields, $i, $stage_count, $status, $check_type, $bonus, $bonus_status, $repeat_max, false, $blog_post_id, $show_all_post_button, $post_id);
   // }




    echo "</div>";
}

function go_get_instructions($custom_fields, $bonus, $i = false ){
    $instructions = null;
    if (isset($custom_fields['go_stages_' . $i . '_instructions'][0]) && (!$bonus)) {
            $add_instructions = (isset($custom_fields['go_stages_' . $i . '_add_instructions'][0]) ?  $custom_fields['go_stages_' . $i . '_add_instructions'][0] : true);
            if($add_instructions) {
                $instructions = (isset($custom_fields['go_stages_' . $i . '_instructions'][0]) ? $custom_fields['go_stages_' . $i . '_instructions'][0] : null);
            }

    } else if (isset($custom_fields['go_bonus_stage_instructions'][0]) && ($bonus)) {
            $add_instructions = (isset($custom_fields['go_bonus_stage_add_instructions'][0]) ?  $custom_fields['go_bonus_stage_add_instructions'][0] : true);
            if($add_instructions) {
                $instructions = (isset($custom_fields['go_bonus_stage_instructions'][0]) ?  $custom_fields['go_bonus_stage_instructions'][0] : null);
            }


    }

    if(!empty($instructions)) {
        $instructions = apply_filters( 'go_awesome_text', $instructions );
        $instructions = "<div class='go_call_to_action'>" . $instructions . " </div>";
    }

    return $instructions;
}

/**
 * Prints the buttons on checks for understanding/task pages
 * @param $user_id
 * @param $custom_fields
 * @param $i
 * @param $stage_count
 * @param $status
 * @param $check_type
 * @param $bonus
 * @param $bonus_status
 * @param $repeat_max
 * @param bool $outro
 * @param $blog_post_id
 */
function go_buttons($custom_fields, $i, $stage_count, $status, $check_type, $bonus, $bonus_status, $repeat_max, $outro = false, $blog_post_id = null, $show_all_post_button = false, $post_id = null){

    //$custom_fields //meta of the task_id
    //$i
    //stage_count
    //$status,
    // $check_type,
    // $bonus,
    // $bonus_status,
    // $repeat_max,
    // $outro = false,
    // $blog_post_id = null

    $user_id = get_current_user_id();
    //$admin_view = ($is_admin ?  get_user_option('go_admin_view', $user_id) : null);

    $undo = 'undo';
    $abandon = 'abandon';

    if ($bonus != true) {//not a bonus stage
        //$url_toggle = (isset($custom_fields['go_stages_' . $i . '_blog_options_url_toggle'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_url_toggle'][0] : null);
        //$file_toggle = (isset($custom_fields['go_stages_' . $i . '_blog_options_attach_file_toggle'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_attach_file_toggle'][0] : null);
        //$video_toggle = (isset($custom_fields['go_stages_' . $i . '_blog_options_video'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_video'][0] : null);
        $opts = (isset($custom_fields['go_stages_' . $i . '_blog_options_v5_opts'][0]) ? true : false);
        if(!$opts){
            $text_toggle = (isset($custom_fields['go_stages_' . $i . '_blog_options_v5_blog_text_toggle'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_v5_blog_text_toggle'][0] : null);

        }else{
            $text_toggle = 0;
        }
        //$restrict_mime_types = (isset($custom_fields['go_stages_' . $i . '_blog_options_attach_file_restrict_file_types'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_attach_file_restrict_file_types'][0] : null);
        $min_words = (isset($custom_fields['go_stages_' . $i . '_blog_options_v5_blog_text_minimum_length'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_v5_blog_text_minimum_length'][0] : null);
        //$required_string = (isset($custom_fields['go_stages_'.$i.'_blog_options_url_url_validation'][0]) ?  $custom_fields['go_stages_'.$stage.'_blog_options_url_url_validation'][0] : null);

    }
    else{//this is a bonus stage blog
        //$url_toggle = (isset($custom_fields['go_bonus_stage_blog_options_bonus_url_toggle'][0]) ? $custom_fields['go_bonus_stage_blog_options_bonus_url_toggle'][0] : null);
        //$file_toggle = (isset($custom_fields['go_bonus_stage_blog_options_bonus_attach_file_toggle'][0]) ? $custom_fields['go_bonus_stage_blog_options_bonus_attach_file_toggle'][0] : null);
        //$video_toggle = (isset($custom_fields['go_bonus_stage_blog_options_bonus_video'][0]) ? $custom_fields['go_bonus_stage_blog_options_bonus_video'][0] : null);
        $opts = (isset($custom_fields['go_bonus_stage_blog_options_v5_opts'][0]) ? true : false);
        if(!$opts){
            $text_toggle = (isset($custom_fields['go_bonus_stage_blog_options_v5_blog_text_toggle'][0]) ? $custom_fields['go_bonus_stage_blog_options_v5_blog_text_toggle'][0] : null);
        }else{
            $text_toggle = 0;
        }

        //$restrict_mime_types = (isset($custom_fields['go_bonus_stage_blog_options_bonus_attach_file_restrict_file_types'][0]) ? $custom_fields['go_bonus_stage_blog_options_bonus_attach_file_restrict_file_types'][0] : null);
        $min_words = (isset($custom_fields['go_bonus_stage_blog_options_v5_blog_text_minimum_length'][0]) ? $custom_fields['go_bonus_stage_blog_options_v5_blog_text_minimum_length'][0] : null);
        //$required_string = (isset($custom_fields['go_bonus_stage_blog_options_url_url_validation'][0]) ?  $custom_fields['go_stages_'.$stage.'_blog_options_url_url_validation'][0] : null);

    }

    $bonus_is_complete = false;
    if ($bonus){
        $stage_count = $repeat_max;
        $undo = 'undo_bonus';
        $abandon = 'abandon_bonus';
        if ($i == $repeat_max - 1 && $bonus_status == $repeat_max){
            $bonus_is_complete = true;
            $undo = 'undo_last_bonus';
        }
        $status = $bonus_status;
        $post_id = wp_get_post_parent_id($blog_post_id);
        $undo_blog_post_id = go_get_bonus_blog_post_id($post_id, $user_id, 0, false, 'DESC' );
    }
    else{
        $undo_blog_post_id = $blog_post_id;
    }

    //Buttons
    if ($outro || $check_type == 'show_bonus' || $bonus_is_complete) {
        if (! $bonus_is_complete ){
            $undo = 'undo_last';
        }
        echo "<div id='go_buttons'>";
        echo "<button id='go_back_button' class='go_buttons' undo='true' button_type='{$undo}' status='{$status}' check_type='{$check_type}' blog_post_id='{$undo_blog_post_id}'><i class=\"fas fa-arrow-square-up\"></i> Undo</button>";
        if ($custom_fields['bonus_switch'][0] && ! $bonus_is_complete) {
            //echo "There is a bonus stage.";
            echo "<button id='go_button' class='show_bonus go_buttons' status='{$status}' check_type='{$check_type}' button_type='show_bonus'  admin_lock='true' >Show Bonus Challenge</button> ";
            //go_autosave_info();
        }
        echo "</div>";
    }
    else  {//admin_view for guest

        echo "<div id='go_buttons'>";
        if ( $i == $status || $status == 'unlock' ) {
            if ($i == 0 ) {
                echo "<button id='go_back_button'  class='go_buttons' undo='true' button_type='{$abandon}' status='{$status}' check_type='{$check_type}' blog_post_id='{$undo_blog_post_id}'><i class=\"fas fa-arrow-square-left\"></i> Abandon</button>";
            } else {
                echo "<button id='go_back_button' class='go_buttons' undo='true' button_type='{$undo}' status='{$status}' check_type='{$check_type}' blog_post_id='{$undo_blog_post_id}'><i class=\"fas fa-arrow-square-up\"></i> Undo</button>";
            }
        }

        if($show_all_post_button){
            global $last_bonus_printed_done;
            $is_admin = go_user_is_admin();
            $displayed = false;
            $uniqueid = false;
            $all_posts_button_toggle = get_option('options_social_options_show_all_posts');
            if ($all_posts_button_toggle !== '0' ) {
                $task_version = (isset($custom_fields['go_task_version'][0]) ? $custom_fields['go_task_version'][0] : false);
                //$show = false;
                if ($bonus && $last_bonus_printed_done) {
                    $uniqueid = 'bonus';
                    if($task_version) {
                        $opts = (isset($custom_fields['go_bonus_stage_blog_options_v5_opts'][0]) ? $custom_fields['go_bonus_stage_blog_options_v5_opts'][0] : false);
                        $opts = unserialize($opts);
                        if (is_array($opts)) {
                            $displayed = in_array('show_posts', $opts);
                        }
                    }else{
                        $displayed = (isset($custom_fields['go_bonus_stage_blog_options_v5_view_posts_button_show'][0]) ? $custom_fields['go_bonus_stage_blog_options_v5_view_posts_button_show'][0] : false);
                        $displayed = intval($displayed);
                    }
                    //$when = (isset($custom_fields['go_bonus_stage_blog_options_v5_view_posts_button_when'][0]) ? $custom_fields['go_bonus_stage_blog_options_v5_view_posts_button_when'][0] : "after");
                    //$is_private = (isset($custom_fields['go_bonus_stage_blog_options_v5_private'][0]) ?  $custom_fields['go_bonus_stage_blog_options_v5_private'][0] : false);

                //} else if($status > $i) {
                } else if($status > $i || $is_admin) {
                    $uniqueid = (isset($custom_fields['go_stages_' . $i . '_uniqueid'][0]) ?  $custom_fields['go_stages_' . $i . '_uniqueid'][0] : false);
                    if($task_version) {
                        $opts = (isset($custom_fields['go_stages_' . $i . '_blog_options_v5_opts'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_v5_opts'][0] : false);
                        $opts = unserialize($opts);
                        if (is_array($opts)) {
                            $displayed = in_array('show_posts', $opts);
                        }
                    }else{
                        $displayed = (isset($custom_fields['go_stages_' . $i . '_blog_options_v5_view_posts_button_show'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_v5_view_posts_button_show'][0] : "1");
                        $displayed = intval($displayed);
                    }

                    if($is_admin){
                        $displayed = true;
                    }

                    //$when = (isset($custom_fields['go_stages_' . $i . '_blog_options_v5_view_posts_button_when'][0]) ? $custom_fields['go_stages_' . $i . '_blog_options_v5_view_posts_button_when'][0] : "after");
                    //$is_private = (isset($custom_fields['go_stages_'.$i.'_blog_options_v5_private'][0]) ?  $custom_fields['go_stages_'.$i.'_blog_options_v5_private'][0] : false);

                }
                $button_text = "See All Posts";



                //if($is_private){
                //$show = false;
                // }
                /*
                if ($show) {
                    //if ($when != 'after' || $stage <= $status || ($stage == 'bonus' && $bonus_status > 0)) {
                    if ($is_admin || $stage <= $status || ($stage == 'bonus' && $bonus_status > 0)) {
                        $displayed = true;
                    }

                }*/
                /* if (!$displayed) {
                     $button_text = "See All Posts (admin only)";
                 }*/

                //if ($is_admin || $displayed) {
                if ($displayed) {
                    echo "<button class='go_buttons go_quest_reader_lightbox_button' data-post_id='" . intval($post_id) . "' data-stage='" . $uniqueid . "'><i class='fas fa-book-open'></i> $button_text</button>";
                }
            }
        }

        if ( $i == $status || $status == 'unlock' ) {
            if (($i + 1) == $stage_count) {
                $button_text = "Complete";
                if ($bonus) {
                    $button_type = 'complete_bonus';
                } else {
                    $button_type = 'complete';
                }

            } else {
                $button_text = "Continue";
                if ($bonus) {
                    $button_type = 'continue_bonus';
                } else {
                    $button_type = 'continue';
                }

                //echo "<button id='go_button' class='progress go_buttons' status='{$status}' check_type='{$check_type}' button_type='{$continue}' admin_lock='true' min_words='{$min_words}' blog_suffix ='' text_toggle='{$text_toggle}' blog_post_id='{$blog_post_id}'>Continue</button>";
            }
            echo "<button id='go_button' class='progress go_buttons go_blog_autosave_button' status='{$status}' check_type='{$check_type}' button_type='{$button_type}' admin_lock='true' min_words='{$min_words}' blog_suffix ='' text_toggle='{$text_toggle}' blog_post_id='{$blog_post_id}'>{$button_text}</button> ";
            //go_autosave_info();
        }
        echo "</div>";
        echo "<p id='go_stage_error_msg' style='display: none; color: red;'></p>";
    }
}

/**
 * @param $i
 * @param $status
 * @param $custom_fields
 * @param $bonus
 * @param $bonus_status
 */
function go_no_check ($i, $status, $custom_fields, $bonus, $bonus_status){
    //for bonus stages
    if ($bonus){
        $status = $bonus_status;
    }
    if ($i !=$status) {
        echo "Stage complete!";
    }
}

/**
 * @param $custom_fields
 * @param $i
 * @param $status
 * @param $go_actions_table_name
 * @param $user_id
 * @param $post_id
 * @param $bonus
 * @param $bonus_status
 */
function go_password_check ($custom_fields, $i, $status, $go_actions_table_name, $user_id, $post_id, $bonus, $bonus_status){
    global $wpdb;

    //for bonus stages
    $stage = 'stage';
    if ($bonus){
        $status = $bonus_status;
        $stage = 'bonus_status';
    }
    //end for bonus stages

    if ($i == $status) {
        echo "<input id='go_result' class='clickable' type='password' placeholder='Enter Password'/>";
    }
    else {
        $i++;
        $password_type = (string) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT result 
				FROM {$go_actions_table_name} 
				WHERE uid = %d AND source_id = %d AND {$stage} = %d
				ORDER BY id DESC LIMIT 1",
                $user_id,
                $post_id,
                $i
            )
        );
        go_print_password_check_result($password_type);

    }
}

/**
 * @param $password_type
 */
function go_print_password_check_result($password_type){
    echo "The " . $password_type . " was entered correctly.";
}


/**
 * @param $custom_fields
 * @param $i    //the stage # being printed
 * @param $status //the current stage of this user
 * @param $go_actions_table_name
 * @param $user_id
 * @param $post_id
 * @param $bonus bool (are we printing a bonus stage
 * @param $bonus_status
 * @param $all_content //if true, print a form that can't be edited if in the visitor/all content for admin view
 * @param $repeat_max
 * @param $check_type
 * @param $stage_count
 * @param $instructions
 * @return |null
 */
function go_blog_check ($custom_fields, $i, $status, $user_id, $post_id, $bonus, $bonus_status, $all_content, $repeat_max, $check_type, $stage_count, $instructions){

    if (!$bonus){//if this is not a bonus
        //check the task meta for a uniqueid
        $uniqueid = (isset($custom_fields['go_stages_' . $i . '_uniqueid'][0]) ?  $custom_fields['go_stages_' . $i . '_uniqueid'][0] : false);

        //if uniqueid found then get the blog_post_id with the meta data
        if ($uniqueid){
            $blog_post_id = go_get_blog_post_id($post_id,$user_id, 'go_stage_uniqueid', $uniqueid, null  );
        }
        if(empty($blog_post_id)) {
            //if no uniqueid was set or the blog post couldn't be found
            //search using the v4 methods where that was saved with the stage# in the meta
            $blog_post_id = go_get_blog_post_id($post_id, $user_id, 'go_blog_task_stage', null, $i  );
        }

        if ($i != $status && !$all_content){//if this is a complete stage, print the result

            echo $instructions;

            go_blog_post($blog_post_id, $post_id, true, true, false, true, $i, false);
        }
        else{//this is the current stage and print the form (or all content is on)
            if (empty($blog_post_id)) {
                $blog_post_id = go_add_new_blog_post('', $user_id, $post_id, $i, $bonus, $uniqueid);
            }
            $check_autosave = false;
            if($blog_post_id){
                $post = get_post($blog_post_id);
                $autosave = wp_get_post_autosave($blog_post_id);

                if($autosave) {
                    $autosave_time = strtotime($autosave->post_modified);
                    $post_time = strtotime($post->post_modified);


                    if ($post_time < $autosave_time) {
                        $check_autosave = true;
                        go_check_autosave($post, $autosave);


                    }
                }

            }
            if(!$check_autosave){
                go_blog_form($blog_post_id, '', $post_id, $i, $bonus_status, true, $all_content);
                //go_buttons($custom_fields, $i, $stage_count, $status, $check_type, $bonus, $bonus_status, $repeat_max, false, $blog_post_id);
            }
           // go_buttons($custom_fields, $i, $stage_count, $status, $check_type, $bonus, $bonus_status, $repeat_max, false, $blog_post_id, true, $post_id);

            return $blog_post_id;
        }
    }
    else{//this is a bonus
        global $last_bonus_printed_done;
        global $go_bonus_direction;//was it a continue or undo button that got us here
        $go_bonus_direction  = (isset($go_bonus_direction) ?  $go_bonus_direction : null);


        global $go_bonus_count;//the number of stages that have been printed
        //global $go_print_next;//the bonus stage to be printed, they print by last modified, published posts first.
       // $go_print_next = (isset($go_print_next) ?  $go_print_next : 0);
        if($go_bonus_direction === 'up') {
            $go_bonus_count = (isset($go_bonus_count) ? $go_bonus_count : $bonus_status-1);
        }
        $go_bonus_count++;

        //LOGIC
        //the first time bonus_status == x and bonus_count == 1
        //if x >= bonus count, print the first bonus that isn't trash
        //else then print the form
            //print the first that isn't trash
            //if that doesn't exist, print first that is trash
            //else print blank form

        //the $go_print_next variable is set as the status in the buttons function

        if (($bonus_status >= $go_bonus_count && !$all_content) && $go_bonus_direction != 'down') {//if this is a complete stage
            $last_bonus_printed_done = true;
           // if($go_bonus_direction === 'up'){//if this was a continue button, just print the post submitted

           // }else {//get the next blog post to print
                $blog_post_id = go_get_bonus_blog_post_id($post_id, $user_id, $go_bonus_count - 1, false, 'ASC');
                if($go_bonus_direction === 'up') {//if this was a continue button, test that the posts are in order and reload if not
                    //duplicate posts can print if posts were resubmitted after there was a reset.  This fixes that.
                    $my_blog_post_id = $_POST['blog_post_id'];
                    if ($my_blog_post_id != $blog_post_id) {
                        echo "<script>location.reload();</script>";
                        //die();
                    }
                }
           // }


            echo $instructions;


            go_blog_post($blog_post_id, $post_id, true, true, false, true, null, false);
            if($bonus_status == $go_bonus_count){
                go_buttons($custom_fields, $i, $stage_count, $status, $check_type, $bonus, $bonus_status, $repeat_max, false, $blog_post_id, true, $post_id);

            }
           // $go_print_next++;
            return $blog_post_id;
        }
        else{//this is the current bonus stage and print the form
            $last_bonus_printed_done = false;
            //get the next,
            $blog_post_id = (isset($_POST['blog_post)id']) ? $_POST['blog_post)id']  : false);
            if(!$blog_post_id) {
                if (!$all_content) {

                    /*
                     *
                     */

                    //if this is a continue, get any post, offset by the number already printed
                    if($go_bonus_direction == 'up') {
                        $blog_post_id = go_get_bonus_blog_post_id($post_id, $user_id, $go_bonus_count - 1, false, 'ASC');
                    }
                    if(empty($blog_post_id)) {
                        $blog_post_id = go_get_bonus_blog_post_id($post_id, $user_id, 0, true, 'ASC');
                    }
                    /*
                    if($go_bonus_direction === 'up' || empty($go_bonus_direction)){
                        $blog_post_id = go_get_bonus_blog_post_id($post_id,$user_id, 0, true, 'ASC' );
                    }else{//if undo, check for last published post
                        //check for published posts first
                        $blog_post_id = go_get_bonus_blog_post_id($post_id,$user_id, 0, true, 'ASC' );
                    }*/


                    if ($blog_post_id === null){
                        //then get the trash
                    } // end if
                }
            }
            $blog_post_id = (isset($blog_post_id) ?  $blog_post_id : null);



            if (empty($blog_post_id)) {
                $blog_post_id = go_add_new_blog_post('', $user_id, $post_id, $i, $bonus, null);
            }

            $check_autosave = false;
            if($blog_post_id){
                $post = get_post($blog_post_id);
                $autosave = wp_get_post_autosave($blog_post_id);

                if($autosave) {
                    $autosave_time = strtotime($autosave->post_modified);
                    $post_time = strtotime($post->post_modified);


                    if ($post_time < $autosave_time) {
                        $check_autosave = true;
                        go_check_autosave($post, $autosave);
                    }
                }
            }
            if(!$check_autosave){
                go_blog_form($blog_post_id, '', $post_id, $i, $bonus, true, $all_content);
            }
            go_buttons($custom_fields, $i, $stage_count, $status, $check_type, $bonus, $bonus_status, $repeat_max, false, $blog_post_id, true, $post_id);
            //if($blog_post_id){do_action('go_blog_template_after_post', $blog_post_id, false);}

            return $blog_post_id;

        }
    }
}

function go_check_autosave($post, $autosave){
    //echo a div with side by side posts
    $post_id = $post->ID;
    echo "<div class='go_check_autosave_{$post_id}'>";
        echo "<h2>Choose Current Post or Autosave</h2>";
        echo "<div id='go_check_autosave_post' class='go_check_autosave_wrapper'>";
            go_blog_post($post_id);
            ?>
            <div style="text-align:right;">
                <button class="go_restore_revision" data-post_id="<?php echo $post_id; ?>"
                         data-autosave="false" data-form="true" data-load_current="true" >Load Current Post
                </button>
            </div>
            <?php
        echo "</div>";
        echo "<div id='go_check_autosave_autosave' class='go_check_autosave_wrapper'>";
            $autosave_id = $autosave->ID;
            go_blog_post($autosave_id);
            $parent = wp_get_post_parent_id($autosave_id);
            ?>
            <div style="text-align:right;">
                <button class="go_restore_revision" data-post_id="<?php echo $autosave_id; ?>"
                        data-parent_id="<?php echo $parent; ?>" data-autosave="true" data-form="true">Restore Autosave
                </button>
            </div>
            <script>

                jQuery( document ).ready( function() {
                    jQuery('.go_restore_revision').off().one("click", function () {
                        go_restore_revision(this);
                    });
                    jQuery('#go_buttons').hide();
                    swal.fire({//sw2 OK
                            text: "There is an autosave of this blog post that is newer than the last save. Choose which version of this post you would like to use.",
                            type: 'warning'
                        }
                    );
                });
            </script>
            <?php


        echo "</div>";
    echo "</div>";
}

function go_add_new_blog_post($title, $user_id, $go_blog_task_id, $i, $bonus, $uniqueid){

    if(empty($user_id)){
        return;
    }

    $my_post = array(
        'post_type' => 'go_blogs',
        'post_title' => $title,
        'post_content' => '',
        'post_status' => 'initial',
        'post_author' => $user_id,
        'post_parent' => $go_blog_task_id,
        'meta_input' => array(
            'go_stage_uniqueid' => $uniqueid,
            'go_blog_task_stage' => $i,
            'go_blog_bonus_stage' => $bonus,
        )
    );

    $blog_post_id = wp_insert_post($my_post);
    go_update_actions($user_id, 'blog_post', $go_blog_task_id, $i, $bonus, null, $blog_post_id, null, null, null, null, null, null, null, null, null, false);

    return $blog_post_id;
}
/**
 * @param $post_id
 * @param $user_id
 * @param $key
 * @return |null
 */
function go_get_blog_post_id($post_id, $user_id, $key, $uniqueid, $stage_num ){
    if(empty($user_id)){
        return null;
    }
    //v4.6 method
    if (isset($uniqueid)) {
        $args = array(
            'post_status' => array('any', 'trash'),//'initial', 'draft', 'unread', 'read', 'publish', 'reset', 'revise', 'trash
            'post_type' => 'go_blogs',
            'post_parent' => intval($post_id),
            'author' => $user_id,
            'posts_per_page' => 1,
            'meta_key' => $key,
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => $key,
                    'value' => $uniqueid,
                    'compare' => '=',
                )
            )
        );

        $my_query = new WP_Query($args);

        //get the blog post id from the query loop(only 1 post, so it doesn't actually loop
        if ($my_query->have_posts()) {
            while ($my_query->have_posts()) {
                // Do your work...
                $my_query->the_post();
                $blog_post_id = get_the_ID();
            } // end while
        } // end if
        wp_reset_postdata();
    }

    else if(isset($stage_num)){
        $stage_num++;
        global $wpdb;
        $go_actions_table_name = "{$wpdb->prefix}go_actions";

        $blog_post_id = (string) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT result 
				FROM {$go_actions_table_name} 
				WHERE uid = %d AND source_id = %d AND stage = %d AND action_type = %s
				ORDER BY id DESC LIMIT 1",
                $user_id,
                $post_id,
                $stage_num,
                'blog_post'
            )
        );
    }
    $blog_post_id = (!empty($blog_post_id) ?  $blog_post_id : null);

    return $blog_post_id;
}

/**
 * @param $post_id
 * @param $user_id
 * @param $offset
 * @param bool $get_trash
 * @param  $order
 */
function go_get_bonus_blog_post_id($post_id, $user_id, $offset, $get_trash, $order ){

    if ($get_trash){
        $statuses = array('initial', 'reset', 'trash');
        //$order = 'ASC';
    }
    else{
        $statuses = array( 'draft', 'unread', 'read', 'publish', 'revise');
    }

    $args = array(
        'post_status' => $statuses,
        'post_type' => 'go_blogs',
        'post_parent'=> intval($post_id),
        'author'    => $user_id,
        'posts_per_page' => 1,
        'offset'    => $offset,
        'meta_query' => array(
            array(
                'key' => 'go_blog_bonus_stage',
                'value' => 1,
                'compare' => '>=',
            )
        ),
        'orderby' => 'post_date',
        'order' => $order
    );
    $my_query = new WP_Query($args);


    if( $my_query->have_posts() ) {
        while( $my_query->have_posts() ) {
            // Do your work...
            $my_query->the_post();
            $blog_post_id = get_the_ID() ;
        } // end while
    } // end if
    wp_reset_postdata();
    $blog_post_id = (isset($blog_post_id) ?  $blog_post_id : null);
    return $blog_post_id;
}


/**
 * @param $custom_fields
 * @param $i
 * @param $status
 * @param $go_actions_table_name
 * @param $user_id
 * @param $post_id
 * @param $bonus
 * @param $bonus_status
 */
/*
function go_url_check ($i, $go_actions_table_name, $user_id, $post_id, $bonus){
    global $wpdb;


    $stage = 'stage';
    if ($bonus){
        $stage = 'bonus_status';
    }

    $i++;
    $url = (string) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT result
            FROM {$go_actions_table_name}
            WHERE uid = %d AND source_id = %d AND {$stage}  = %d
            ORDER BY id DESC LIMIT 1",
            $user_id,
            $post_id,
            $i
        )
    );
    go_print_URL_check_result($url);
}
*/
/*
function go_url_check ($custom_fields, $i, $status, $go_actions_table_name, $user_id, $post_id, $bonus, $bonus_status){
    global $wpdb;

    //for bonus stages
    $stage = 'stage';
    if ($bonus){
        $status = $bonus_status;
        $stage = 'bonus_status';
    }
    //end for bonus stages

    if ($i == $status) {//the form
        $i++;
        $url = (string)$wpdb->get_var($wpdb->prepare("SELECT result
				FROM {$go_actions_table_name}
				WHERE uid = %d AND source_id = %d AND {$stage}  = %d AND action_type = %s
				ORDER BY id DESC LIMIT 1", $user_id, $post_id, $i, 'task'));

        echo "<div class='go_url_div'>";
        echo "<input id='go_result' class='clickable' type='url' placeholder='Enter URL' value='{$url}'>";
        echo "</div>";
    }
    else {//the result
        $i++;
        $url = (string) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT result
				FROM {$go_actions_table_name}
				WHERE uid = %d AND source_id = %d AND {$stage}  = %d
				ORDER BY id DESC LIMIT 1",
                $user_id,
                $post_id,
                $i
            )
        );
        //add lightbox to this--NOPE too many protected URLs
        go_print_URL_check_result($url);
        //Too many security errors with Lightbox
        //echo "<br><a href='" . $url . "' data-featherlight='iframe'>Open in a lightbox.</a>";
    }
}
*/

/**
 * @param string $placeholder
 * @param string $id
 * @param null $url
 * @param string $data_type
 * @param null $required_string
 * @param null $uniqueID
 */
function go_canvas_blog ($placeholder = 'http://website.com', $id = 'go_result', $url = null, $data_type = 'sketch', $required_string = null, $uniqueID = null){
    $snapshot = json_encode(unserialize($url));
    echo "<div class='my-drawing go_blog_element_input' type='sketch' data-type='{$data_type}' data-required='{$required_string}' data-uniqueID='{$uniqueID}' placeholder='{$placeholder}' value='{$snapshot}'></div>";
}

/**
 * @param $url
 */
function go_print_canvas_result($url){
    $snapshot = json_encode(unserialize($url));
    echo "<div class='go_required_blog_content width100'>";
    echo "<div class='my-drawing-image' value='{$snapshot}'><div class='my-drawing-svg'></div></div>";
    echo "</div>";
}

/**
 * @param string $placeholder
 * @param string $id
 * @param null $url
 * @param string $data_type
 * @param null $required_string
 * @param null $uniqueID
 */
function go_url_check_blog ($placeholder = 'http://website.com', $id = 'go_result', $url = null, $data_type = 'url', $required_string = null, $uniqueID = null){
    echo "<div class='go_url_div'>";
    echo "<input id='{$id}' class='go_blog_element_input' type='url' data-type='{$data_type}' data-required='{$required_string}' data-uniqueID='{$uniqueID}' placeholder='{$placeholder}' value='{$url}' style='width: 90%;'>";
    echo "</div>";
}

/**
 * Prints form field for text area
 * @param string $placeholder
 * @param string $id
 * @param null $text
 * @param string $data_type
 * @param null $uniqueID
 * @param int $height
 */
/*
function go_text_check_blog ($id = 'go_result', $text = null, $data_type = 'text',  $uniqueID = null, $height = 1){
    $height = intval($height);
    echo "<div class='go_url_div'>";
    echo "<textarea id='{$id}' class='go_blog_element_input {$id}'  data-type='{$data_type}'  data-uniqueID='{$uniqueID}'  value='{$text}' style='width: 90%;' rows='{$height}'>{$text}</textarea>";
    echo "</div>";
}*/

/**
 * @param $url
 */
function go_print_URL_check_result($url){
    echo "<div class='go_required_blog_content width100'>";
    echo "<div>URL Submitted: <a href='" . $url . "' target='blank'>" . $url . "</a></div>";
    echo "</div>";
}

/**
 * Print result of text area
 * @param $url
 */
function go_print_text_check_result($text){
    $text = apply_filters( 'go_awesome_text', $text );

    echo "<div class='go_required_blog_content width100' style='margin-bottom: 10px;'>". $text ."</div>";
}

/**
 * @param $custom_fields
 * @param $i
 * @param $status
 * @param $go_actions_table_name
 * @param $user_id
 * @param $post_id
 * @param $bonus
 * @param $bonus_status
 */
function go_upload_check ($i, $go_actions_table_name, $user_id, $post_id, $bonus) {
    global $wpdb;

    $stage = 'stage';
    if ($bonus){
        $stage = 'bonus_status';
    }

    $i++;
    $media_id = (int)$wpdb->get_var($wpdb->prepare("SELECT result 
            FROM {$go_actions_table_name} 
            WHERE uid = %d AND source_id = %d AND {$stage}  = %d
            ORDER BY id DESC LIMIT 1", $user_id, $post_id, $i));

    go_print_upload_check_result($media_id);

}

/**
 * @param null $media_id
 * @param $div_id
 * @param $mime_types
 * @param null $uniqueID
 */
function go_upload_check_blog ($media_id = null, $div_id, $mime_types, $uniqueID = null) {

    $attachment_type = get_post_type($media_id);
    if (empty($media_id) || ($attachment_type !== 'attachment')) {
        echo do_shortcode('[frontend-button div_id="'.$div_id.'" mime_types="'.$mime_types.'" uniqueid="'.$uniqueID.'"]');
    }else{
        echo do_shortcode( '[frontend_submitted_media div_id="'.$div_id.'" id="'.$media_id.'" mime_types="'.$mime_types.'" uniqueid="'.$uniqueID.'" class="go_blog_element_input" ]' );
    }
}

/**
 * @param $media_id
 */
function go_print_upload_check_result($media_id){
    $type = get_post_mime_type($media_id);

    //return $icon;
    switch ($type) {
        case 'image/jpeg':
        case 'image/png':
        case 'image/gif':
            $type = 'image';
            break;
        case 'video/mp4':
            $type = 'video';
            $video_type = 'mp4';
            break;
        case 'video/m4v':
            $type = 'video';
            $video_type = 'm4v';
            break;
        case 'video/ogg':
            $type = 'video';
            $video_type = 'oog';
            break;
        case 'video/webm':
            $type = 'video';
            $video_type = 'webm';
            break;
        case 'video/flv':
            $type = 'video';
            $video_type = 'flv';
            break;
        default:
            $type_image = false;
    }
   // echo "<div class='go_required_blog_content go_blog_element_input'>";
    if ($type === 'image'){
        $med = wp_get_attachment_image_src( $media_id, 'medium' );
        $full = wp_get_attachment_image_src( $media_id, 'full' );
        //echo "<img src='" . $thumb[0] . "' >" ;
        echo '<a href="#" data-featherlight="' . $full[0] . '"><img src="' . $med[0] . '"></a>';

    }
    else if ($type === 'video'){
        echo "</div>";
        //echo "<img src='" . $thumb[0] . "' >" ;
        $url = wp_get_attachment_url( $media_id );
        $content = '[video '.$video_type.'="'.$url.'"][/video]';
        //$content = '[video width="1152" height="720" mp4="http://gameondev/site3/wp-content/uploads/sites/43/2019/09/test.mp4"][/video]';
        $content = apply_filters( 'go_awesome_text', $content );
        echo $content;
        echo "<div class='go_blog_elements'>";

    }
    else{
        // $img = wp_mime_type_icon($type);
        //echo "<img src='" . $img . "' >";
        $url = wp_get_attachment_url( $media_id );
        $thumb = wp_get_attachment_image_src( $media_id, 'thumbnail',true );
        echo "<a href='{$url}'>";
        echo "<img src='" . $thumb[0] . "' >" ;
        echo "<div>" . get_the_title($media_id) . "</div>" ;
        echo "</a>";
    }
   // echo "</div>";
}

/**
 * @param $custom_fields
 * @param $i
 * @param $status
 * @param $go_actions_table_name
 * @param $user_id
 * @param $post_id
 * @param $bonus
 * @param $bonus_status
 * @param $show_first
 */
function go_test_check ($custom_fields, $i, $status, $go_actions_table_name, $user_id, $post_id, $bonus, $bonus_status, $show_first){
    global $wpdb;
    $go_actions_table_name = (isset($go_actions_table_name) ?  $go_actions_table_name : $wpdb->prefix ."go_actions");
    if ($i === $status) {

        $test_array = $custom_fields['go_stages_' . $i . '_quiz'][0];

        $atts['quiz'] = $test_array;
        $atts['stage'] = $i + 1;

        go_test_shortcode( $atts );
            //do_shortcode("[go_test $atts ]");

    }
    else {
        //for bonus stages
        $stage = 'stage';
        if ($bonus){
            $status = $bonus_status;
            $stage = 'bonus_status';
        }
        //end for bonus stages
        //echo "Questions answered correctly.";
        $i++;



        //LOGIC:
        //get the first attempt
        //get the score
        //if on task and not 100%
        //then get the most recent attempt

        //build the html
        //if on task
            //if 100%
                //echo the score
                //echo first
            //else
                //echo link to first
                //echo recent
        //else if on clipboard
            //echo message with score

                //echo first

        //get the first attempt
        $first = (string) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT result 
				FROM {$go_actions_table_name} 
				WHERE uid = %d AND source_id = %d AND {$stage}  = %d AND action_type = %s
				ORDER BY id ASC LIMIT 1",
                $user_id,
                $post_id,
                $i,
                'quiz_result'
            )
        );
        $first = stripslashes($first);

        //get the score
        //$quiz_mod = go_get_quiz_mod($user_id, $post_id, $i,  );
        $quiz_result = go_get_quiz_result($user_id, $post_id, $i, 'array' );
        $quiz_mod = (isset($quiz_result[0]['result']) ?  $quiz_result[0]['result'] : null);
        $total_questions = (isset($quiz_result[0]['check_type']) ?  $quiz_result[0]['check_type'] : null);
        //$total_questions = $quiz_result[0]['check_type'];
        $score = ($total_questions - $quiz_mod )."/".$total_questions;

        //if on task and not 100%
        //then get the most recent attempt
        echo "<div class='go_quiz_results'>";
        if (!$show_first) {//on a task
            if ($quiz_mod == 0) {
                echo "<div>You got {$score} correct. 100% Good job!</div>";
            }
            else if ($quiz_mod > 0) {//not 100%
                echo "<div>On your <a href='#' data-featherlight='#go_first_quiz_attempt_{$i} '>first attempt</a> you got {$score} correct.</div>";


            }

            //Get the most recent attempt
            $recent = (string)$wpdb->get_var(
                $wpdb->prepare(
                    "SELECT result 
				FROM {$go_actions_table_name} 
				WHERE uid = %d AND source_id = %d AND {$stage}  = %d AND action_type = %s
				ORDER BY id DESC LIMIT 1",
                    $user_id,
                    $post_id,
                    $i,
                    'quiz_result'
                )
            );
            $recent = stripslashes($recent);

            //print the hidden div for the lightbox
            echo "<div id='go_first_quiz_attempt_{$i}' class='go_first_quiz_attempt' >{$first}</div>";
            echo "<div>{$recent}</div>";

        }
        else {//on the clipboard
            echo "<h3>{$score}</h3>";

            echo "<div>{$first}</div>";


        }
        echo "</div>";
        /*
        if ($quiz_mod > 0) {


             //$html = '<ul><li><div>Do it 50%<span class="go_correct_answer_marker">correct</span></div></li><li><input type="radio" value="Yes" checked="checked"> Yes</li><li><input type="radio" name="go_test_answer_0" value="no"> no</li></ul><ul><li><div >Nope<span class="go_wrong_answer_marker" style="">wrong</span></div></li><li class="go_test go_test_element"><input type="radio"  value="yup" checked="checked"> yup</li><li class="go_test go_test_element"><input type="radio" value="nope"> nope</li></ul>';
            $show = '';
            if ($show_first) {
                $show = 'show';
            }
            //echo "<br>On your first attempt you missed {$quiz_mod}.";
            $first_link = "<div>On your <a href='#' data-featherlight='#go_first_quiz_attempt_{$i} '>first attempt</a> you got {$score} correct.</div>";
            $first = "<div id='go_first_quiz_attempt_{$i}' class='go_first_quiz_attempt{$show}' >{$html}</div>";

        }else{
            $first_link = "<div>You got 100% correct!</div>";

        }



        $html = (string) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT result
				FROM {$go_actions_table_name}
				WHERE uid = %d AND source_id = %d AND {$stage}  = %d AND action_type = %s
				ORDER BY id DESC LIMIT 1",
                $user_id,
                $post_id,
                $i,
                'quiz_result'
            )
        );

        if ($show_first){//only show the first attempt if on the clipboard

            echo $first;
            return;
        }else{//this is a view for the user regular check for understanding
            echo $first_link;
            echo $first;
            echo "<div>".stripslashes($html)."</div>";
        }


        */

    }


}

//Quiz function
/**
 * Retrieves and formulates test meta data from a specific task and stage.
 *
 */
function go_task_get_test_meta($custom_fields, $stage ) {

    $test_array = $custom_fields['go_stages_' . $stage . '_quiz'][0];
    $test_array = unserialize($test_array);
    if ( ! empty( $test_array ) ) {
        $test_num = $test_array[3];
        $test_all_questions = array();
        foreach ( $test_array[0] as $question ) {
            $esc_question = htmlspecialchars( $question, ENT_QUOTES );
            if ( preg_match( "/[\\\[\]]/", $question ) ) {
                $str = preg_replace( array( "/\[/", "/\]/", "/\\\/" ), array( '&#91;', '&#93;', '\\\\\\\\\\\\' ), $esc_question );
                $test_all_questions[] = $str;
            } else {
                $test_all_questions[] = $esc_question;
            }
        }
        $test_all_types = $test_array[2];
        $test_all_inputs = $test_array[1];
        $test_all_input_num = $test_array[4];
        $test_all_answers = array();
        $test_all_keys = array();
        for ( $i = 0; $i < count( $test_all_inputs ); $i++ ) {
            if ( ! empty( $test_all_inputs[ $i ][0] ) ) {
                $answer_temp = implode( "###", $test_all_inputs[ $i ][0] );
                $esc_answer = htmlspecialchars( $answer_temp, ENT_QUOTES );
                if ( preg_match( "/[\\\[\]]/", $answer_temp ) ) {
                    $str = preg_replace( array( "/\[/", "/\]/", "/\\\/" ), array( '&#91;', '&#93;', '\\\\\\\\\\\\' ), $esc_answer );
                    $test_all_answers[] = $str;
                } else {
                    $test_all_answers[] = $esc_answer;
                }
            }
            if ( ! empty( $test_all_inputs[ $i ][1] ) ) {
                $key_temp = implode( "###", $test_all_inputs[ $i ][1] );
                $esc_key = htmlspecialchars( $key_temp, ENT_QUOTES );
                if (preg_match( "/[\\\[\]]/", $key_temp) ) {
                    $str = preg_replace( array( "/\[/", "/\]/", "/\\\/" ), array( '&#91;', '&#93;', '\\\\\\\\\\\\' ), $esc_key );
                    $test_all_keys[] = $str;
                } else {
                    $test_all_keys[] = $esc_key;
                }
            }
        }

        return array( $test_num, array( $test_all_questions, $test_all_types, $test_all_answers, $test_all_keys ) );
    } else {
        return null;
    }
}


