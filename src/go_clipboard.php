<?php

/*
function go_clipboard() {
	add_submenu_page( 'game-on-options.php', 'Clipboard', 'Clipboard', 'manage_options', 'go_clipboard', 'go_clipboard_menu' );
}
*/

function go_clipboard_menu() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} else {
	?><div id="go_leaderboard_filters">
        <h4>Filters</h4>
        <span>Section:<?php go_make_tax_select('user_go_sections'); ?></span>
        <span>Group:<?php go_make_tax_select('user_go_groups'); ?></span>
        </div>
		<div id="records_tabs">
			<ul>
				<li><a href="#clipboard_wrap">Stats</a></li>
				<li><a href="#clipboard_messages_wrap">Messages</a></li>
				<li><a href="#clipboard_activity_wrap">Activity</a></li>
			</ul>
			<div id="clipboard_wrap">
                <?php
                go_clipboard_intable();
                /*

				<select class="menuitem" id="go_clipboard_class_a_choice" onchange="go_clipboard_class_a_choice();">
					<option>...</option>
					<?php
					$class_a = get_option( 'go_class_a' );
					if ( $class_a ) {
						foreach ( $class_a as $key => $value ) {
							echo "<option class='ui-corner-all'>{$value}</option>";
						}
					}
					?>
				</select>


			
				<div id="go_clipboard_add">
					<?php //go_options_help( 'http://maclab.guhsd.net/go/video/clipboard/clipboard.mp4', 'Clipboard Help' ); ?>
					<label for="go_clipboard_points"><?php echo get_option( 'go_points_name' ); ?>: </label><input name="go_clipboard_points" id="go_clipboard_points" class='go_clipboard_add'/> 
					<label for="go_clipboard_currency"><?php echo get_option( 'go_currency_name' ); ?>: </label><input name="go_clipboard_currency" id="go_clipboard_currency" class='go_clipboard_add'/>
					<label for="go_clipboard_bonus_currency"><?php echo get_option( 'go_bonus_currency_name' ); ?>: </label> <input name="go_clipboard_bonus_currency" id="go_clipboard_bonus_currency" class='go_clipboard_add'/>
					<label for="go_clipboard_penalty"><?php echo get_option( 'go_penalty_name' ); ?>: </label><input name="go_clipboard_penalty" id="go_clipboard_penalty" class='go_clipboard_add'/>
					<label for="go_clipboard_minutes"><?php echo get_option( 'go_minutes_name' ); ?>: </label><input name="go_clipboard_minutes" id="go_clipboard_minutes" class='go_clipboard_add'/>
					<label for="go_clipboard_badge">Badge ID:</label><input name="go_clipboard_badge" id="go_clipboard_badge" class='go_clipboard_add'/><br/>
					<label name="go_clipboard_reason">Message: </label>
					<div>
						<textarea name="go_clipboard_reason" id="go_clipboard_reason" placeholder='See me'></textarea><br/>
						<button class="ui-button-text" id="go_send_message" onclick="go_clipboard_add();">Add</button>
						<button id="go_fix_messages" onclick="go_fix_messages()">Fix Messages</button>
					</div>
                </div>

					<table id="go_clipboard_table" class="pretty">
						<thead>
							<tr>
								<th><input type="checkbox" onClick="go_toggle(this);" /></th>
								<th class="header"><a href="#" >ID</a></th>
								<th class="header"><a href="#" ><?php echo get_option( 'go_class_b_name' ); ?></a></th>
								<th class="header"><a href="#" >Student Name</a></th>
								<th class="header"><a href="#" >Display Name</a></th>
								<th class="header"><a href="#" ><?php echo get_option( 'go_level_names' ); ?></a></th>
								<?php if ( get_option( 'go_focus_switch' ) == 'On' ) { ?><th class="header"><a href="#" ><?php echo get_option( 'go_focus_name' ); ?></a></th><?php } ?>
								<th class="header"><a href="#"><?php echo get_option( 'go_points_name' ); ?></a></th>
								<th class="header"><a href="#"><?php echo get_option( 'go_currency_name' ); ?></a></th>
								<th class="header"><a href="#"><?php echo get_option( 'go_bonus_currency_name' ); ?></a></th>
								<th class="header"><a href="#"><?php echo get_option( 'go_penalty_name' ); ?></a></th>
								<th class="header"><a href="#"><?php echo get_option( 'go_minutes_name' ); ?></a></th>
								<th class="header"><a href="#"><?php echo get_option( 'go_badges_name' ); ?></a></th>
							</tr>
						</thead>
						<tbody id="go_clipboard_table_body"></tbody>
					</table>
                 */
                ?>

			</div>


			<div id="clipboard_messages_wrap">
				<select class="menuitem" id="go_clipboard_class_a_choice_messages" onchange="go_clipboard_class_a_choice_messages();">
					<option>...</option>
					<?php
					$class_a_messages = get_option( 'go_class_a' );
					if ( $class_a_messages ) {
						foreach ( $class_a_messages as $key => $value ) {
							echo "<option class='ui-corner-all'>{$value}</option>";
						}
					}
					?>
					<option>All</option>
				</select>
				<table id="go_clipboard_messages" class="pretty">
					<thead>
						<tr>
							<th class="header" width="5%" id="messages_id"><a href="#" >ID</a></th>
							<th class="header" width="5%" id="messages_computer"><a href="#"><?php echo get_option( 'go_class_b_name' ); ?></a></th>
							<th class="header" width="6.5%" id="messages_student"><a href="#">Student Name</a></th>
							<th class="header" width="6.5%" id="messages_display"><a href="#">Display Name</a></th>
							<th class="header" width="6%" id="messages_date"><a href="#">Date</a></th>
							<th class="header" id="messages_message"><a href="#">Message</a></th>
						</tr>
					</thead>
					<tbody id="go_clipboard_messages_body"></tbody>
				</table>
			</div>


			<div id="clipboard_activity_wrap">
				<select class="menuitem" id="go_clipboard_class_a_choice_activity" onchange="go_clipboard_class_a_choice_activity();">
					<option>...</option>
					<?php
					$class_a_activity = get_option( 'go_class_a' );
					if ( $class_a_activity ) {
						foreach ( $class_a_activity as $key => $value ) {
							echo "<option class='ui-corner-all'>{$value}</option>";
						}
					}
					?>
					<option>All</option>
				</select>
				<table id="go_clipboard_activity" class="pretty">
					<thead>
						<tr>
							
							<th class="header" id="activity_computer"><a href="#"><?php echo get_option( 'go_class_b_name' ); ?></a></th>
							<th class="header" id="activity_student"><a href="#">Student Name</a></th>
							<th class="header" id="activity_display"><a href="#">Display Name</a></th>
							<th class="header" id="activity_stats"><a href="#">Links</a></th>
							<th class="header" id="activity_date"><a href="#">Activity</a></th>
						</tr>
					</thead>
					<tbody id="go_clipboard_activity_body"></tbody>
				</table>
			</div>
		</div>
	<?php
	}
}

function go_clipboard_intable() {
	global $wpdb;
	if ( ! current_user_can( 'manage_options' ) ) {
		die( -1 );
	}
	//check_ajax_referer( 'go_clipboard_intable_' . get_current_user_id() );

    // prepares tab titles
    $xp_name = get_option( "options_go_loot_xp_name" );
    $gold_name = get_option( "options_go_loot_gold_name" );
    $c4_name = get_option( "options_go_loot_c4_name" );
    $badges_name = get_option( 'options_go_badges_name_singular' ) . " Count";
    $current_user_id =  $user_id = get_current_user_id();
    $go_totals_table_name = "{$wpdb->prefix}go_loot";
    $rows = $wpdb->get_results(
        "SELECT * 
			        FROM {$go_totals_table_name}"

    );

    $xp_toggle = get_option('options_go_loot_xp_toggle');
    $gold_toggle = get_option('options_go_loot_gold_toggle');
    $health_toggle = get_option('options_go_loot_health_toggle');
    $c4_toggle = get_option('options_go_loot_c4_toggle');
    $badges_toggle = get_option('options_go_badges_toggle');
    echo '<div id="go_clipboard_wrapper" class="go_datatables">';
    ?>
        <table id='go_clipboard_datatable' class='pretty display'>
            <thead>
            <tr>
                <th><input type="checkbox" onClick="go_toggle(this);" /></th>
                <th class="header"><a href="#" >ID</a></th>
                <th class="header"><a href="#" ><?php echo get_option( 'go_class_b_name' ); ?></a></th>
                <th class="header"><a href="#" >Student Name</a></th>
                <th class="header"><a href="#" >Display Name</a></th>
                <th class="header"><a href="#" ><?php echo get_option( 'go_level_names' ); ?></a></th>
                <th class="header"><a href="#" ><?php echo get_option( 'go_focus_name' ); ?></a></th>
                <th class="header"><a href="#"><?php echo get_option( 'go_points_name' ); ?></a></th>
                <th class="header"><a href="#"><?php echo get_option( 'go_currency_name' ); ?></a></th>
                <th class="header"><a href="#"><?php echo get_option( 'go_bonus_currency_name' ); ?></a></th>
                <th class="header"><a href="#"><?php echo get_option( 'go_penalty_name' ); ?></a></th>
                <th class="header"><a href="#"><?php echo get_option( 'go_minutes_name' ); ?></a></th>
                <th class="header"><a href="#"><?php echo get_option( 'go_badges_name' ); ?></a></th>
            </tr>
            </thead>
            <tbody>
    <?php


    foreach ( $rows as $row ) {
        $user_id = $row->uid;
        $is_admin = go_user_is_admin($user_id);
        if($is_admin){
            continue;
        }

        $group_ids = $row->groups;
        $group_ids = unserialize($group_ids);
        $group_ids = json_encode($group_ids);

        //$sections = get_user_meta($user_id, "go_sections");
        $num_terms = get_user_meta($user_id, 'go_section_and_seat', true);
        $sections = array();
        for ($i = 0; $i < $num_terms; $i++) {

            $user_period = "go_section_and_seat_" . $i . "_user-section";
            $user_period = get_user_meta($user_id, $user_period, true);
            $sections[] = $user_period;

        }
        $sections = json_encode($sections);
        $user_data = get_userdata( $user_id );
        $user_name = $user_data->display_name;
        $xp = $row->xp;
        $gold = $row->gold;
        $health = $row->health;
        $c4 = $row->c4;
        $badge_count = $row->badge_count;

        echo "<tr id='user_{$user_id}'>
					<td><input class='go_checkbox' type='checkbox' name='go_selected' value='{$user_id}'/></td>
					<td><span><a href='#' onclick='go_admin_bar_stats_page_button(&quot;{$user_id}&quot;);'>{$user_name}</a></td>
					<td>Seat #</td>
					<td>{$user_name} First Last </a></td>
					<td>{$user_name} Display Name</td>
					<td>{}Level</td>
					<td>Groups</td>
					<td class='user_points'>{$xp}</td>
					<td class='user_currency'>{$gold}</td>
					<td class='user_bonus_currency'>{$health}</td>
					<td class='user_penalty'>{$c4}</td>
					<td class='user_minutes'>NOthing</td>
					<td class='user_badge_count'>{$badge_count}</td>
				  </tr>";


    }
    ?>

            </tbody></table></div>

    <?php




}


function go_clipboard_intable_messages() {
	if ( ! current_user_can( 'manage_options' ) ) {
		die( -1 );
	}
	check_ajax_referer( 'go_clipboard_intable_messages_' . get_current_user_id() );

	// do not continue if a class hasn't been selected
	$class_slug = ( ! empty( $_POST['go_clipboard_class_a_choice_messages'] ) ? sanitize_text_field( $_POST['go_clipboard_class_a_choice_messages'] ) : '' );
	if ( empty( $class_slug ) ) {
		die();
	}

	// do not continue if no admin messages are registered on the current admin account
	$admin_messages = get_user_meta( get_current_user_id(), 'go_admin_message_history', true );
	if ( empty( $admin_messages ) ) {
		die();
	}

	foreach ( $admin_messages as $student_id => $messages ) {
		$class_messages_array = get_user_meta( $student_id, 'go_classifications', true );
		
		$user_data_key = get_userdata( $student_id );
		$user_login = $user_data_key->user_login;
		$user_display = $user_data_key->display_name;
		$user_first_name = $user_data_key->user_firstname;
		$user_last_name = $user_data_key->user_lastname;
		$user_url = $user_data_key->user_url;
		$array_len = count( $messages );

		if ( ! empty( $class_messages_array[ $class_slug ] ) ) {
			for ( $i = $array_len - 1; $i >= 0; $i-- ) {
				echo "<tr id='user_{$student_id}'>
					<td><span><a href='#' onclick='go_admin_bar_stats_page_button(&quot;{$student_id}&quot;);'>{$user_login}</a></td>
					<td>{$class_messages_array[ $class_slug ]}</td>
					<td><a href='{$user_url}' target='_blank'>{$user_last_name}, {$user_first_name}</a></td>
					<td>{$user_display}</td>
					<td>{$messages[$i]['time']}</td>
					<td class='message'>{$messages[$i]['message']}</td>
					</tr>";
			}
		}  elseif ( $class_slug == 'All' ) {
			if ( ! empty( $class_messages_array ) ) {
				foreach ( $class_messages_array as $key => $computer ) {
					for ( $i = $array_len - 1; $i >= 0; $i-- ) {
						echo "<tr id='user_{$student_id}'>
							<td><span><a href='#' onclick='go_admin_bar_stats_page_button(&quot;{$student_id}&quot;);'>{$user_login}</a></td>
							<td>{$computer}</td>
							<td><a href='{$user_url}' target='_blank'>{$user_last_name}, {$user_first_name}</a></td>
							<td>{$user_display}</td>
							<td>{$messages[$i]['time']}</td>
							<td class='message'>{$messages[$i]['message']}</td>
							</tr>";
					}
				}
			}
		}
	}
	die();
}


function go_clipboard_intable_activity() {
	global $wpdb;
	$go_task_table_name = "{$wpdb->prefix}go";


	if ( ! current_user_can( 'manage_options' ) ) {
		die( -1 );
	}

	check_ajax_referer( 'go_clipboard_intable_activity_' . get_current_user_id() );

	// do not continue if a class hasn't been selected
	$class_slug = ( ! empty( $_POST['go_clipboard_class_a_choice_activity'] ) ? sanitize_text_field( $_POST['go_clipboard_class_a_choice_activity'] ) : '' );
	if ( empty( $class_slug ) ) {
		die();
	}
	//update_user_meta( 1, 'go_admin_activity', 'hi3' );
	// do not continue if no admin messages are registered on the current admin account
	//$admin_messages = get_user_meta( get_current_user_id(), 'go_admin_message_history', true );
	//if ( empty( $admin_messages ) ) {
	//	die();
	//}

	// grabs all user ids for non-admin users
	$table_name_user_meta = $wpdb->prefix.'usermeta';
	$uids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT user_id 
			FROM {$table_name_user_meta} 
			WHERE meta_key = %s AND meta_value NOT LIKE %s",
			"{$wpdb->prefix}capabilities",
			'%administrator%'
		)
	);
	
	foreach ( $uids as $id ) {
		$class_array = get_user_meta( $id->user_id, 'go_classifications', true );

		// continue if the user has the selected class in their class list
		if ( ! empty( $class_array[ $class_slug ] ) ) {
			$user_data_key = get_userdata( $id->user_id );
			$user_login = $user_data_key->user_login;
			$user_display_name = $user_data_key->display_name;
			$user_firstname = $user_data_key->user_firstname;
			$user_lastname = $user_data_key->user_lastname;
			$user_website = $user_data_key->user_url;
			$user_edit_link = get_edit_user_link( $id->user_id  );

			if (! empty ($user_website)) {
				$user_website = "<a href='{$user_website}' target='_blank'>Web</a>";
			}



			$task_list = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT post_id, timestamp
					FROM {$go_task_table_name} 
					WHERE uid = %d
					ORDER BY id DESC",
					$id->user_id
				)
			);

			
		
			
			echo "<tr id='user_{$id->user_id}'>
					<td>{$class_array[ $class_slug ]}</td>
					<td>{$user_lastname}, {$user_firstname}</td>
					<td>{$user_display_name}</td>
					<td><span style='float:right;'>{$user_website} <a href='{$user_edit_link}' target='_blank'>Profile</a> <a href='#' onclick='go_admin_bar_stats_page_button(&quot;{$id->user_id}&quot;);'>Stats</a></span></td>
					<td>";

			foreach ( $task_list as $task ) {
				$activityDate = date('Y-m-d', strtotime($task->timestamp));
				$today = date('Y-m-d');
				if ($activityDate == $today ){
					$task_name = get_the_title($task->post_id);

					echo $task_name . "<br>";


				}
			}
			echo "</td>	  </tr>";
		}
	}
	die();
}

 
function go_clipboard_add() {

	// the third param in the `check_ajax_referer()` call prevents the function from dying with 
	// a "-1" response
	$referer_passed = false;
	if ( current_user_can( 'manage_options' ) && check_ajax_referer( 'go_clipboard_add_' . get_current_user_id(), false, false ) ) {
		$referer_passed = true;
	}

	$status = 6;
	$bonus_loot_default = null;
	$undo_default = false;
	$show_notification = false;
	$output_data = array(
		"update_status" => false
	);

	if ( $referer_passed ) {
		$user_id_array = (array) $_POST['ids'];
		$points = (int) $_POST['points'];
		$currency = (int) $_POST['currency'];
		$bonus_currency = (int) $_POST['bonus_currency'];
		$penalty = (int) $_POST['penalty'];
		$minutes = (int) $_POST['minutes'];
		$reason = sanitize_text_field( $_POST['reason'] );
		$badge_id = (int) $_POST['badge_ID'];
	
		foreach ( $user_id_array as $key => $user_id ) {
			$user_id = (int) $user_id;
	
			if ( ! empty( $badge_id ) ) {
				if ( $badge_id > 0 ) {
	
					// the badge id is positive, so award it to the user if they don't have it
					go_award_badge(
						array(
							'id' 		=> $badge_id,
							'repeat' 	=> false,
							'uid' 		=> $user_id
						)
					);
				} else if ( $badge_id < 0 ) {
	
					// the badge id is negative, so remove that badge from the user
					$badge_id *= -1;
					go_remove_badge( $user_id, $badge_id );
				}
			}
			go_update_totals(
				$user_id,
				$points,
				$currency,
				$bonus_currency,
				$penalty,
				$minutes,
				$status,
				$bonus_loot_default,
				$undo_default,
				$show_notification
			);
			go_message_user( $user_id, $reason );
	
			// returning information to the AJAX call to update the clipboard
			$new_point_total = go_return_points( $user_id );
			$new_currency_total = go_return_currency( $user_id );
			$new_bonus_currency_total = go_return_health( $user_id );
			//$new_penalty_total = go_return_penalty( $user_id );
			$new_minute_total = go_return_c4( $user_id );
			$new_badge_count = go_return_badge_count( $user_id );
	
			if ( ! $output_data[ 'update_status' ] ) {
				$output_data[ 'update_status' ] = true;
			}
			$output_data[ $user_id ] = array(
				"points" => $new_point_total,
				"currency" => $new_currency_total,
				"bonus_currency" => $new_bonus_currency_total,
				"penalty" => $new_penalty_total,
				"minutes" => $new_minute_total,
				"badge_count" => $new_badge_count
			);
		}
	}
	wp_die( json_encode( $output_data ) );
}

function go_update_user_focuses() {
	if ( ! current_user_can( 'manage_options' ) ) {
		die( -1 );
	}
	check_ajax_referer( 'go_update_user_focuses_' . get_current_user_id() );

	$new_user_focus = sanitize_text_field( stripslashes( $_POST['new_user_focus'] ) );
	$user_id = (int) $_POST['user_id'];
	if ( $new_user_focus != 'No '.get_option( 'go_focus_name' ) ) {
		update_user_meta( $user_id, 'go_focus', array( $new_user_focus ) );
	} else {
		update_user_meta( $user_id, 'go_focus', array() );
	}
	echo $new_user_focus;
	die();	
}

function go_fix_messages() {
	if ( ! current_user_can( 'manage_options' ) ) {
		die( -1 );
	}
	check_ajax_referer( 'go_fix_messages_' . get_current_user_id() );

	$users = get_users(array( 'role' => 'Subscriber' ) );
	foreach ( $users as $user ) {
		$messages = get_user_meta( $user->ID, 'go_admin_messages',true );
		$messages_array = $messages[1];
		$messages_unread = array_values( $messages_array );
		$messages_unread_count = 0;
		foreach ( $messages_unread as $message_unread ) {
			if ( $message_unread[1] == 1) {
				$messages_unread_count++;	
			}
		}
		if ( $messages[0] != $message_unread_count ) {
			$messages[0] = $messages_unread_count;
			update_user_meta( $user->ID, 'go_admin_messages', $messages );
		}
	}
	
	die();
}
?>
