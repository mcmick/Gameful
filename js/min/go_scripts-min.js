function go_user_profile_link(e){jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{action:"go_user_profile_link",uid:e},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){window.open(e)}})}function go_noty_close_oldest(){Noty.setMaxVisible(6);var e=jQuery("#noty_layout__topRight > div").length;0==e&&jQuery("#noty_layout__topRight").remove(),e>=5&&jQuery("#noty_layout__topRight > div").first().trigger("click")}function go_lightbox_blog_img(){jQuery("[class*= wp-image]").each(function(){var e;if(1==jQuery(this).hasClass("size-full"))var t=jQuery(this).attr("src");else var a,o=/.*wp-image/,r=jQuery(this).attr("class").replace(o,"wp-image"),s=jQuery(this).attr("src"),i=/-([^-]+).$/,_=/\.[0-9a-z]+$/i,n=s.match(_),t=s.replace(i,n);jQuery(this).featherlight(t)})}function go_admin_bar_stats_page_button(e){var t=GO_EVERY_PAGE_DATA.nonces.go_admin_bar_stats;jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:t,action:"go_admin_bar_stats",uid:e},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){console.log(e),"refresh"!==e?-1!==e&&(jQuery.featherlight(e,{variant:"stats"}),go_stats_task_list(),jQuery("#stats_tabs").tabs(),jQuery(".stats_tabs").click(function(){switch(tab=jQuery(this).attr("tab"),tab){case"about":go_stats_about();break;case"tasks":go_stats_task_list();break;case"store":go_stats_item_list();break;case"history":go_stats_activity_list();break;case"messages":go_stats_messages();break;case"badges":go_stats_badges_list();break;case"groups":go_stats_groups_list();break;case"leaderboard":go_stats_leaderboard();break}})):go_refresh_page_on_error()}})}function go_stats_links(){jQuery(".go_user_link_stats").prop("onclick",null).off("click"),jQuery(".go_user_link_stats").one("click",function(){var e;go_admin_bar_stats_page_button(jQuery(this).attr("name"))}),jQuery(".go_stats_messages_icon").prop("onclick",null).off("click"),jQuery(".go_stats_messages_icon").one("click",function(e){var t;go_messages_opener(this.getAttribute("data-uid"),null,"single_message",this)})}function go_leaderboard_menus_select2(){0==jQuery("#select2-go_user_go_sections_select-container").length&&jQuery("#go_user_go_sections_select").select2({ajax:{url:MyAjax.ajaxurl,dataType:"json",delay:400,data:function(e){return{q:e.term,action:"go_make_taxonomy_dropdown_ajax",taxonomy:"user_go_sections",is_hier:!1}},processResults:function(e){return jQuery("#go_user_go_sections_select").select2("destroy"),jQuery("#go_user_go_sections_select").children().remove(),jQuery("#go_user_go_sections_select").select2({data:e,placeholder:"Show All",allowClear:!0}).val(group).trigger("change"),jQuery("#go_user_go_sections_select").select2("open"),{results:e}},cache:!0},minimumInputLength:0,multiple:!1,placeholder:"Show All",allowClear:!0}),0==jQuery("#select2-go_user_go_groups_select-container").length&&jQuery("#go_user_go_groups_select").select2({ajax:{url:MyAjax.ajaxurl,dataType:"json",delay:400,data:function(e){return{q:e.term,action:"go_make_taxonomy_dropdown_ajax",taxonomy:"user_go_groups",is_hier:!1}},processResults:function(e){return jQuery("#go_user_go_groups_select").select2("destroy"),jQuery("#go_user_go_groups_select").children().remove(),jQuery("#go_user_go_groups_select").select2({data:e,placeholder:"Show All",allowClear:!0}).val(group).trigger("change"),jQuery("#go_user_go_groups_select").select2("open"),{results:e}},minimumInputLength:0,multiple:!1,placeholder:"Show All",allowClear:!0},minimumInputLength:0,multiple:!1,placeholder:"Show All",allowClear:!0})}function go_stats_about(e){var t=GO_EVERY_PAGE_DATA.nonces.go_stats_about;0==jQuery("#go_stats_about").length&&jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:t,action:"go_stats_about",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&jQuery("#stats_about").html(e)}})}function go_stats_task_list(){var e=GO_EVERY_PAGE_DATA.nonces.go_stats_task_list;0==jQuery("#go_tasks_datatable").length?jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:e,action:"go_stats_task_list",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&(jQuery("#stats_tasks").html(e),jQuery("#go_tasks_datatable").dataTable({processing:!0,serverSide:!0,ajax:{url:MyAjax.ajaxurl+"?action=go_tasks_dataloader_ajax",data:function(e){e.user_id=jQuery("#go_stats_hidden_input").val()}},responsive:!0,autoWidth:!1,columnDefs:[{targets:"_all",orderable:!1}],searching:!0,drawCallback:function(e){go_enable_reset_buttons()},order:[[3,"desc"]]})),go_reset_opener(null)}}):(jQuery("#go_task_list").show(),jQuery("#go_task_list_single").hide())}function go_enable_reset_buttons(){jQuery(".go_reset_task_clipboard").prop("onclick",null).off("click"),jQuery(".go_reset_task_clipboard").one("click",function(){go_messages_opener(this.getAttribute("data-uid"),this.getAttribute("data-task"),"single_reset",this)}),jQuery(".go_tasks_reset_multiple_clipboard").parent().prop("onclick",null).off("click"),jQuery(".go_tasks_reset_multiple_clipboard").parent().one("click",function(){go_messages_opener(null,null,"multiple_reset",this)})}function go_close_single_history(){jQuery("#go_task_list").show(),jQuery("#go_task_list_single").hide()}function go_stats_single_task_activity_list(e){var t=GO_EVERY_PAGE_DATA.nonces.go_stats_single_task_activity_list;jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:t,action:"go_stats_single_task_activity_list",user_id:jQuery("#go_stats_hidden_input").val(),postID:e},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&(jQuery("#go_task_list_single").remove(),jQuery("#go_task_list").hide(),jQuery("#stats_tasks").append(e),jQuery("#go_single_task_datatable").dataTable({bPaginate:!0,order:[[0,"desc"]],responsive:!0,autoWidth:!1}))}})}function go_stats_item_list(){var e=GO_EVERY_PAGE_DATA.nonces.go_stats_item_list;0==jQuery("#go_store_datatable").length&&jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:e,action:"go_stats_item_list",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&(jQuery("#stats_store").html(e),jQuery("#go_store_datatable").dataTable({processing:!0,serverSide:!0,ajax:{url:MyAjax.ajaxurl+"?action=go_stats_store_item_dataloader",data:function(e){e.user_id=jQuery("#go_stats_hidden_input").val()}},responsive:!0,autoWidth:!1,columnDefs:[{targets:"_all",orderable:!1}],searching:!0,order:[[0,"desc"]]}))}})}function go_stats_activity_list(){var e=GO_EVERY_PAGE_DATA.nonces.go_stats_activity_list;0==jQuery("#go_activity_datatable").length&&jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:e,action:"go_stats_activity_list",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&(jQuery("#stats_history").html(e),jQuery("#go_activity_datatable").dataTable({processing:!0,serverSide:!0,ajax:{url:MyAjax.ajaxurl+"?action=go_activity_dataloader_ajax",data:function(e){e.user_id=jQuery("#go_stats_hidden_input").val()}},responsive:!0,autoWidth:!1,columnDefs:[{targets:"_all",orderable:!1}],searching:!0,order:[[0,"desc"]]}))}})}function go_stats_messages(){var e=GO_EVERY_PAGE_DATA.nonces.go_stats_messages;0==jQuery("#go_messages_datatable").length&&jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:e,action:"go_stats_messages",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&(jQuery("#stats_messages").html(e),jQuery("#go_messages_datatable").dataTable({processing:!0,serverSide:!0,ajax:{url:MyAjax.ajaxurl+"?action=go_messages_dataloader_ajax",data:function(e){e.user_id=jQuery("#go_stats_hidden_input").val()}},responsive:!0,autoWidth:!1,columnDefs:[{targets:"_all",orderable:!1}],searching:!0,order:[[0,"desc"]]}))}})}function go_stats_badges_list(){var e=GO_EVERY_PAGE_DATA.nonces.go_stats_badges_list;0==jQuery("#go_badges_list").length&&jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:e,action:"go_stats_badges_list",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&jQuery("#stats_badges").html(e)}})}function go_stats_groups_list(){var e=GO_EVERY_PAGE_DATA.nonces.go_stats_groups_list;0==jQuery("#go_groups_list").length&&jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:e,action:"go_stats_groups_list",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&jQuery("#stats_groups").html(e)}})}function go_stats_leaderboard(){var e=GO_EVERY_PAGE_DATA.nonces.go_stats_leaderboard,t=GO_EVERY_PAGE_DATA.go_is_admin,a=3;1==t&&(a=4),0==jQuery("#go_leaderboard_wrapper").length&&(jQuery(".go_leaderboard_wrapper").show(),jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:e,action:"go_stats_leaderboard",user_id:jQuery("#go_stats_hidden_input").val()},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){jQuery("#stats_leaderboard").html(e);var t=jQuery("#go_leaders_datatable").DataTable({processing:!0,serverSide:!0,ajax:{url:MyAjax.ajaxurl+"?action=go_stats_leaderboard_dataloader_ajax",data:function(e){e.section=jQuery("#go_user_go_sections_select").val(),e.group=jQuery("#go_user_go_groups_select").val()}},responsive:!1,autoWidth:!1,paging:!0,order:[[a,"desc"]],drawCallback:function(e){go_stats_links(),go_leaderboard_menus_select2()},searching:!1,columnDefs:[{type:"natural",targets:"_all"},{targets:[0],sortable:!1},{targets:[1],sortable:!1},{targets:[2],sortable:!1},{targets:[3],sortable:!1},{targets:[4],sortable:!0,orderSequence:["desc"]},{targets:[5],sortable:!0,orderSequence:["desc"]},{targets:[6],sortable:!0,orderSequence:["desc"]}]});jQuery("#go_user_go_sections_select, #go_user_go_groups_select").change(function(){var e=jQuery("#go_user_go_sections_select").val();console.log(e),jQuery("#go_leaders_datatable").length&&t.draw()})}}))}function go_stats_lite(e){var t=GO_EVERY_PAGE_DATA.nonces.go_stats_lite;jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:t,action:"go_stats_lite",uid:e},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){jQuery.featherlight(e,{variant:"stats_lite"}),-1!==e&&jQuery("#go_tasks_datatable_lite").dataTable({destroy:!0,responsive:!0,autoWidth:!1,drawCallback:function(e){go_stats_links()},searching:!1})}})}function go_activate_apply_filters(){console.log("go_activate_apply_filters"),jQuery(".go_update_clipboard").addClass("bluepulse"),jQuery(".go_update_clipboard").html('<span class="ui-button-text">Apply Filters<i class="fa fa-filter" aria-hidden="true"></i></span>')}function go_date_loader(e,t,a){1==a?(e=moment(),t=moment()):go_activate_apply_filters(),jQuery("#go_datepicker").html(e.format("MMMM D, YYYY")+" - "+t.format("MMMM D, YYYY"))}function go_load_daterangepicker(e){console.log("go_load_daterangepicker"),jQuery("#go_datepicker_clipboard").daterangepicker({ranges:{Today:[moment(),moment()],Yesterday:[moment().subtract(1,"days"),moment().subtract(1,"days")],"Last 7 Days":[moment().subtract(6,"days"),moment()],"Last 30 Days":[moment().subtract(29,"days"),moment()],"This Month":[moment().startOf("month"),moment().endOf("month")],"Last Month":[moment().subtract(1,"month").startOf("month"),moment().subtract(1,"month").endOf("month")]},startDate:moment(),endDate:moment(),opens:"center",locale:{cancelLabel:"Clear"}},function(e,t,a){console.log("New date range selected: "+e.format("YYYY-MM-DD")+" to "+t.format("YYYY-MM-DD")+" (predefined range: "+a+")"),go_date_loader(e,t,!1)}),jQuery("#go_datepicker_clipboard").on("cancel.daterangepicker",function(e,t){jQuery("#go_datepicker_clipboard span").html("")}),go_date_loader(null,null,!0)}function go_load_daterangepicker_empty(){jQuery("#go_datepicker_clipboard").daterangepicker({autoUpdateInput:!1,locale:{cancelLabel:"Clear"}}),jQuery("#go_datepicker_clipboard").on("apply.daterangepicker",function(e,t){jQuery("#go_datepicker_clipboard span").html(t.startDate.format("MM/DD/YYYY")+" - "+t.endDate.format("MM/DD/YYYY"))}),jQuery("#go_datepicker_clipboard").on("cancel.daterangepicker",function(e,t){jQuery("#go_datepicker_clipboard span").html("")})}function go_make_select2_filter(e,t,a){if(a)var o=localStorage.getItem("go_clipboard_"+t),r=localStorage.getItem("go_clipboard_"+t+"_name");if(jQuery("#go_clipboard_"+e+"_select").select2({ajax:{url:ajaxurl,dataType:"json",delay:400,data:function(t){return{q:t.term,action:"go_make_taxonomy_dropdown_ajax",taxonomy:e,is_hier:!1}},processResults:function(t){return jQuery("#go_clipboard_"+e+"_select").select2("destroy"),jQuery("#go_clipboard_"+e+"_select").children().remove(),jQuery("#go_clipboard_"+e+"_select").select2({data:t,placeholder:"Show All",allowClear:!0}).val(o).trigger("change"),jQuery("#go_clipboard_"+e+"_select").select2("open"),{results:t}},cache:!0},minimumInputLength:0,multiple:!1,placeholder:"Show All",allowClear:!0}),null!=o&&"null"!=o){var s=jQuery("#go_clipboard_"+e+"_select"),i=new Option(r,o,!0,!0);s.append(i).trigger("change")}}function go_make_select2_cpt(e,t){jQuery(e).select2({ajax:{url:ajaxurl,dataType:"json",delay:400,data:function(e){return{q:e.term,action:"go_make_cpt_select2_ajax",cpt:t}},processResults:function(e){var t=[];return e&&jQuery.each(e,function(e,a){t.push({id:a[0],text:a[1]})}),{results:t}},cache:!1},minimumInputLength:1,multiple:!0,placeholder:"Show All"})}function go_setup_reset_filter_button(e){jQuery("#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #go_task_select, #go_store_item_select").on("select2:select",function(e){go_activate_apply_filters()}),jQuery("#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #go_task_select, #go_store_item_select").on("select2:unselect",function(e){go_activate_apply_filters()}),jQuery(".go_reset_clipboard").on("click",function(){jQuery("#go_datepicker").html(""),jQuery("#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #go_task_select, #go_store_item_select").val(null).trigger("change"),e?(jQuery("#go_reader_read, #go_reader_reset, #go_reader_trash, #go_reader_draft").prop("checked",!1),jQuery("#go_reader_unread").prop("checked",!0),jQuery("#go_reader_order_oldest").prop("checked",!0),jQuery("#go_posts_num").val("10")):jQuery("#go_unmatched_toggle").prop("checked",!1),go_activate_apply_filters()}),go_daterange_clear()}function go_daterange_clear(){jQuery("#go_reset_datepicker").on("click",function(e){e.stopPropagation(),jQuery("#go_datepicker_container").html('<div id="go_datepicker_clipboard"><i class="fa fa-calendar" style="float: left;"></i><span id="go_datepicker"></span> <i id="go_reset_datepicker" class=""select2-selection__clear><b> × </b></i><i class="fa fa-caret-down"></i></div>'),jQuery("#go_reset_datepicker").hide(),jQuery("#go_datepicker_container").one("click",function(){go_load_daterangepicker("clear"),jQuery("#go_reset_datepicker").show(),go_daterange_clear()}),go_activate_apply_filters()})}function go_clear_daterange(){}function go_refresh_page_on_error(){Swal.fire({title:"Error",text:"Refresh the page and then try again? You will lose unsaved changes. You can cancel and copy any unsaved changes to a safe location before refresh.",type:"warning",confirmButtonText:"Refresh Now",reverseButtons:!0,customClass:{confirmButton:"btn btn-success",cancelButton:"btn btn-danger"}}).then(e=>{e.value&&location.reload()})}function go_save_clipboard_filters(){var e=jQuery("#go_clipboard_user_go_sections_select").val(),t=jQuery("#go_clipboard_user_go_sections_select option:selected").text(),a=jQuery("#go_clipboard_user_go_groups_select").val(),o=jQuery("#go_clipboard_user_go_groups_select option:selected").text(),r=jQuery("#go_clipboard_go_badges_select").val(),s=jQuery("#go_clipboard_go_badges_select option:selected").text(),i=document.getElementById("go_unmatched_toggle").checked;console.log("b "+r),localStorage.setItem("go_clipboard_section",e),localStorage.setItem("go_clipboard_badge",r),localStorage.setItem("go_clipboard_group",a),localStorage.setItem("go_clipboard_section_name",t),localStorage.setItem("go_clipboard_badge_name",s),localStorage.setItem("go_clipboard_group_name",o),localStorage.setItem("go_clipboard_unmatched",i)}function go_make_store_clickable(){jQuery(".clickable").keyup(function(e){13===e.which&&jQuery("#go_store_pass_button").click()})}function go_lb_opener(e){if(jQuery("#light").css("display","block"),jQuery(".go_str_item").prop("onclick",null).off("click"),!jQuery.trim(jQuery("#lb-content").html()).length){var t=e,a,o={action:"go_the_lb_ajax",_ajax_nonce:GO_EVERY_PAGE_DATA.nonces.go_the_lb_ajax,the_item_id:t};jQuery.ajax({url:MyAjax.ajaxurl,type:"POST",data:o,beforeSend:function(){jQuery("#lb-content").append('<div class="go-lb-loading"></div>')},cache:!1,error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(t){console.log("success"),console.log(t);var a=JSON.parse(t);try{var a=JSON.parse(t)}catch(e){a={json_status:"101",html:""}}if(jQuery("#lb-content").innerHTML="",jQuery("#lb-content").html(""),jQuery.featherlight(a.html,{variant:"store",afterOpen:function(e){console.log("store-fitvids3"),go_fit_and_max_only("#go_store_description")}}),"101"===Number.parseInt(a.json_status)){console.log(101),jQuery("#go_store_error_msg").show();var o="Server Error.";jQuery("#go_store_error_msg").text()!=o?jQuery("#go_store_error_msg").text(o):flash_error_msg_store("#go_store_error_msg")}else 302===Number.parseInt(a.json_status)&&(console.log(302),window.location=a.location);jQuery(".go_str_item").one("click",function(e){go_lb_opener(this.id)}),jQuery("#go_store_pass_button").one("click",function(t){go_store_password(e)}),go_max_purchase_limit()}})}}function goBuytheItem(e,t){var a=GO_BUY_ITEM_DATA.nonces.go_buy_item,o=GO_BUY_ITEM_DATA.userID;jQuery(document).ready(function(t){var r={_ajax_nonce:a,action:"go_buy_item",the_id:e,qty:t("#go_qty").val(),user_id:o};t.ajax({url:MyAjax.ajaxurl,type:"POST",data:r,beforeSend:function(){t("#golb-fr-buy").innerHTML="",t("#golb-fr-buy").html(""),t("#golb-fr-buy").append('<div id="go-buy-loading" class="buy_gold"></div>')},error:function(e,a,o){400===e.status&&t(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){var a={};try{var a=JSON.parse(e)}catch(e){a={json_status:"101",html:"101 Error: Please try again."}}-1!==e.indexOf("Error")?t("#light").html(e):t("#light").html(a.html)}})})}function flash_error_msg_store(e){var t=jQuery(e).css("background-color");void 0===typeof t&&(t="white"),jQuery(e).animate({color:t},200,function(){jQuery(e).animate({color:"red"},200)})}function go_store_password(e){var t;if(!(jQuery("#go_store_password_result").attr("value").length>0)){jQuery("#go_store_error_msg").show();var a="Please enter a password.";return jQuery("#go_store_error_msg").text()!=a?jQuery("#go_store_error_msg").text(a):flash_error_msg_store("#go_store_error_msg"),void jQuery("#go_store_pass_button").one("click",function(t){go_store_password(e)})}var o=jQuery("#go_store_password_result").attr("value");if(jQuery("#light").css("display","block"),!jQuery.trim(jQuery("#lb-content").html()).length){var r=e,s,i={action:"go_the_lb_ajax",_ajax_nonce:GO_EVERY_PAGE_DATA.nonces.go_the_lb_ajax,the_item_id:r,skip_locks:!0,result:o};jQuery.ajax({url:MyAjax.ajaxurl,type:"POST",data:i,cache:!1,error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(t){var a=JSON.parse(t);try{var a=JSON.parse(t)}catch(e){a={json_status:"101",html:""}}if("101"===Number.parseInt(a.json_status)){console.log(101),jQuery("#go_store_error_msg").show();var o="Server Error.";jQuery("#go_store_error_msg").text()!=o?jQuery("#go_store_error_msg").text(o):flash_error_msg_store("#go_store_error_msg")}else if(302===Number.parseInt(a.json_status))console.log(302),window.location=a.location;else if("bad_password"==a.json_status){jQuery("#go_store_error_msg").show();var o="Invalid password.";jQuery("#go_store_error_msg").text()!=o?jQuery("#go_store_error_msg").text(o):flash_error_msg_store("#go_store_error_msg"),jQuery("#go_store_pass_button").one("click",function(t){go_store_password(e)})}else jQuery("#go_store_pass_button").one("click",function(t){go_store_password(e)}),jQuery("#go_store_lightbox_container").hide(),jQuery(".featherlight-content").html(a.html),go_max_purchase_limit()}})}}function go_max_purchase_limit(){window.go_purchase_limit=jQuery("#golb-fr-purchase-limit").attr("val");var e=go_purchase_limit;jQuery("#go_qty").spinner({max:e,min:1,stop:function(){jQuery(this).change()}}),go_make_store_clickable(),jQuery("#go_store_admin_override").one("click",function(e){jQuery(".go_store_lock").show(),jQuery("#go_store_admin_override").hide(),go_make_store_clickable()})}function go_count_item(e){var t=GO_BUY_ITEM_DATA.nonces.go_get_purchase_count;jQuery.ajax({url:MyAjax.ajaxurl,type:"POST",data:{_ajax_nonce:t,action:"go_get_purchase_count",item_id:e},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){if(-1!==e){var t=e.toString();jQuery("#golb-purchased").html("Quantity purchased: "+t)}}})}function go_reset_opener(e){console.log("go_reset_opener"),"multiple_messages"!=e&&null!=e||(jQuery(".go_messages_icon_multiple_clipboard").parent().prop("onclick",null).off("click"),jQuery(".go_messages_icon_multiple_clipboard").parent().one("click",function(e){go_messages_opener(null,null,"multiple_messages")})),"single_reset"!=e&&null!=e||(jQuery(".go_reset_task_clipboard").prop("onclick",null).off("click"),jQuery(".go_reset_task_clipboard").one("click",function(){go_messages_opener(this.getAttribute("data-uid"),this.getAttribute("data-task"),"single_reset",this)})),"multiple_reset"!=e&&null!=e||(jQuery(".go_tasks_reset_multiple_clipboard").parent().prop("onclick",null).off("click"),jQuery(".go_tasks_reset_multiple_clipboard").parent().one("click",function(){go_messages_opener(null,null,"multiple_reset",this)})),"single_message"!=e&&null!=e||(jQuery(".go_stats_messages_icon").prop("onclick",null).off("click"),jQuery(".go_stats_messages_icon").one("click",function(e){var t;go_messages_opener(this.getAttribute("data-uid"),null,"single_message",this)})),"reset_stage"!=e&&null!=e||(jQuery(".go_reset_task_clipboard").prop("onclick",null).off("click"),jQuery(".go_reset_task_clipboard").one("click",function(){go_messages_opener(this.getAttribute("data-uid"),this.getAttribute("data-task"),"reset_stage",this)}))}function go_messages_opener(e,t,a,o){t=void 0!==t?t:null,a=void 0!==a?a:null,console.log("type: "+a),console.log("UID: "+e),console.log("post_id: "+t),jQuery(".go_tasks_reset_multiple_clipboard").prop("onclick",null).off("click");var r=[];if("multiple_messages"==a||"multiple_reset"==a){for(var s=jQuery(".go_checkbox:visible"),i=0;i<s.length;i++)if(!0===s[i].checked){var _=s[i].getAttribute("data-uid"),n=s[i].getAttribute("data-task");"multiple_messages"==a&&(n=""),r.push({uid:_,task:n})}}else"single_reset"!=a&&"single_message"!=a&&"reset_stage"!=a||(r.push({uid:e,task:t}),"reset_stage"==a&&(console.log("target: "+o),jQuery(o).find(".go_round_inner").html("<i class='fa fa-spinner fa-pulse'></i>")));var l,c={action:"go_create_admin_message",_ajax_nonce:GO_EVERY_PAGE_DATA.nonces.go_create_admin_message,message_type:a,reset_vars:r};jQuery.ajax({url:MyAjax.ajaxurl,type:"POST",data:c,error:function(e,t,o){go_reset_opener(a),400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){var s=jQuery.parseJSON(e);if("reset"==s.type)var i="",_=!0,n=!0,l="IndianRed",c='<i class="fa fa-paper-plane"></i> Send',u='<i class="fa fa-times-circle"></i> Cancel';else if("no_users"==s.type)var i="error",_=!0,n=!1,l="grey",u='<i class="fa fa-times-circle"></i> Try again!',c="Cancel";else var i="",_=!0,n=!0,l="",c='<i class="fa fa-paper-plane"></i> Send Message',u='<i class="fa fa-times-circle"></i> Cancel';swal.fire({title:s.title,html:s.message,type:i,showCancelButton:_,showConfirmButton:n,reverseButtons:!0,confirmButtonColor:l,confirmButtonText:c,cancelButtonText:u}).then(e=>{e.value&&go_send_message(r,a,t)}),jQuery(o).find(".go_round_inner").html('<i class="fa fa-times-circle"></i>'),go_reset_opener(a),jQuery(".go-acf-switch").click(function(){console.log("click"),0==jQuery(this).hasClass("-on")?(jQuery(this).prev("input").prop("checked",!0),jQuery(this).addClass("-on"),jQuery(this).removeClass("-off")):(jQuery(this).prev("input").prop("checked",!1),jQuery(this).removeClass("-on"),jQuery(this).addClass("-off"))}),jQuery("#go_messages_go_badges_select").select2({ajax:{url:ajaxurl,dataType:"json",delay:400,data:function(e){return{q:e.term,action:"go_make_taxonomy_dropdown_ajax",taxonomy:"go_badges",is_hier:!0}},processResults:function(e){return{results:e}},cache:!1},minimumInputLength:0,multiple:!0,placeholder:"Show All",allowClear:!0}),jQuery("#go_messages_user_go_groups_select").select2({ajax:{url:ajaxurl,dataType:"json",delay:400,data:function(e){return{q:e.term,action:"go_make_taxonomy_dropdown_ajax",taxonomy:"user_go_groups",is_hier:!0}},processResults:function(e){return{results:e}},cache:!0},minimumInputLength:0,multiple:!0,placeholder:"Show All",allowClear:!0}),tippy(".tooltip",{delay:0,arrow:!0,arrowType:"round",size:"large",duration:300,animation:"scale",zIndex:999999}),jQuery("#go_additional_penalty_toggle").change(function(){var e;1==document.getElementById("go_additional_penalty_toggle").checked?jQuery(".go_penalty_table").css("display","block"):jQuery(".go_penalty_table").css("display","none")}),jQuery("#go_custom_message_toggle").change(function(){var e;1==document.getElementById("go_custom_message_toggle").checked?jQuery("#go_custom_message_table").css("display","block"):jQuery("#go_custom_message_table").css("display","none")})}})}function go_send_message(e,t,a){var o=jQuery("[name=title]").val();if("reset"==(t="multiple_reset"==t||"single_reset"==t?"reset":"reset_stage"==t?"reset_stage":"message")||"reset_stage"==t)var r=document.getElementById("go_custom_message_toggle").checked,s=document.getElementById("go_additional_penalty_toggle").checked;else var r=null,s=null;if("message"==t||("reset"==t||"reset_stage"==t)&&1==r)var i=jQuery("[name=message]").val();else var i="";if("message"==t||("reset"==t||"reset_stage"==t)&&1==s){if("message"==t)var _=jQuery("[name=xp_toggle]").siblings().hasClass("-on")?1:-1,n=jQuery("[name=gold_toggle]").siblings().hasClass("-on")?1:-1,l=jQuery("[name=health_toggle]").siblings().hasClass("-on")?1:-1,c=jQuery("[name=badges_toggle]").siblings().hasClass("-on"),u=jQuery("[name=groups_toggle]").siblings().hasClass("-on");else var _=-1,n=-1,l=-1,c=!1,u=!1;console.log("xp: "+jQuery(".xp_messages").val());var g=jQuery(".xp_messages").val()*_,d=jQuery(".gold_messages").val()*n,p=jQuery(".health_messages").val()*l,h=jQuery("#go_messages_go_badges_select").val(),y=jQuery("#go_messages_user_go_groups_select").val()}else if(("reset"==t||"reset_stage"==t)&&0==s)var c=!1,u=!1,g=0,d=0,p=0,h=null,y=null;var m,j={action:"go_send_message",_ajax_nonce:GO_EVERY_PAGE_DATA.nonces.go_send_message,reset_vars:e,message_type:t,title:o,message:i,xp:g,gold:d,health:p,badges_toggle:c,badges:h,groups_toggle:u,groups:y,penalty:s};jQuery.ajax({url:MyAjax.ajaxurl,type:"POST",data:j,error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){if(console.log("send successful"),Swal.fire("Success!","","success"),jQuery("#go_tasks_datatable").remove(),go_stats_task_list(),"reset_stage"==t){var o=".go_blog_post_wrapper_"+a;jQuery(o+" .go_reset_task_clipboard").hide(),jQuery(o+" .go_status_icon .tooltip").html('<i class="fa fa-times-circle fa-2x"></i>')}else go_toggle_off()}})}function go_Vids_Fit_and_Box(e){runmefirst(e,function(){go_Max_width_and_LightboxNow()})}function runmefirst(e,t){jQuery(e).fitVids(),t()}function go_fit_and_max_only(e){go_fit_and_max_only_first(e,function(){go_Max_width()})}function go_fit_and_max_only_first(e,t){jQuery(e).fitVids(),t()}function go_video_resize(){var e=jQuery(".featherlight-content .fluid-width-video-wrapper").css("padding-top"),t=jQuery(".featherlight-content .fluid-width-video-wrapper").css("width"),a=(e=parseFloat(e))/(t=parseFloat(t));console.log("Vratio:"+a);var o=jQuery(window).width();console.log("vW:"+o);var r=o,s=jQuery(window).height();console.log("vH:"+s);var i=o*a;console.log("cH1:"+i),i>s&&(i=s-50,console.log("cH2:"+i),r=i/a,console.log("cW:"+r)),jQuery(".featherlight-content").css("width",r),jQuery(".featherlight-content").css("height",i)}function go_Max_width(){var e=GO_EVERY_PAGE_DATA.go_fitvids_maxwidth;console.log("max"+e),jQuery(".fluid-width-video-wrapper:not(.fit)").each(function(){jQuery(this).wrap('<div class="max-width-video-wrapper" style="position:relative;"><div>'),jQuery(this).addClass("fit"),jQuery(".max-width-video-wrapper").css("max-width",e)}),jQuery(".wp-video:not(.fit)").each(function(){jQuery(this).wrap('<div class="max-width-video-wrapper" style="position:relative;"><div>'),jQuery(this).addClass("fit"),jQuery(".max-width-video-wrapper").css("max-width",e)})}function go_Max_width_and_LightboxNow(){var e;if(go_Max_width(),"1"===GO_EVERY_PAGE_DATA.go_lightbox_switch){jQuery(".max-width-video-wrapper:not(.wrapped):has(iframe)").each(function(){jQuery(this).prepend('<a style="display:block;" class="featherlight_wrapper_iframe" href="#" ><div style="position:absolute; width:100%; height:100%; top:0; left: 0; z-index: 1;"></div></a>'),jQuery(".max-width-video-wrapper").children().unbind(),jQuery(this).addClass("wrapped")}),jQuery('[class^="featherlight_wrapper_iframe"]').each(function(){var e=jQuery(this).parent().find(".fluid-width-video-wrapper").parent().html();jQuery(this).attr("href",'<div id="go_video_container" style=" overflow: hidden;">'+e+"</div>"),jQuery(".featherlight_wrapper_iframe").featherlight({targetAttr:"href",closeOnEsc:!0,variant:"fit_and_box",afterOpen:function(e){jQuery(".featherlight-content").css({width:"100%",overflow:"hidden"}),jQuery(".featherlight-content iframe").attr("src",jQuery(".featherlight-content iframe").attr("src")+"&autoplay=1"),go_video_resize(),jQuery(window).resize(function(){go_video_resize()})}})});var t=setInterval(function(){jQuery(".max-width-video-wrapper:not(.wrapped):has(video)").length&&(console.log("Exists!"),clearInterval(t),jQuery(".max-width-video-wrapper:not(.wrapped):has(video)").each(function(){var e=jQuery(this).find("video").attr("src");console.log("src:"+e),
jQuery(this).prepend('<a href=\'#\' class=\'featherlight_wrapper_vid_shortcode\' data-featherlight=\'<div id="go_video_container" style="height: 90vh; overflow: hidden; text-align: center;"> <video controls autoplay style="height: 100%; max-width: 100%;"><source src="'+e+"\" type=\"video/mp4\">Your browser does not support the video tag.</video></div>'  data-featherlight-close-on-esc='true' data-featherlight-variant='fit_and_box native2' ><span style=\"position:absolute; width:100%; height:100%; top:0; left: 0; z-index: 4;\"></span></a> "),jQuery(this).addClass("wrapped")}))},100)}}function go_to_this_map(e){var t=GO_EVERY_PAGE_DATA.nonces.go_to_this_map;jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:t,action:"go_to_this_map",map_id:e},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){console.log("success"),window.location.href=e}})}function go_show_map(e){document.getElementById("maps").style.display="none",document.getElementById("loader_container").style.display="block";var t=GO_EVERY_PAGE_DATA.nonces.go_update_last_map,a=jQuery("#go_map_user").data("uid");console.log(e),jQuery.ajax({type:"POST",url:MyAjax.ajaxurl,data:{action:"go_update_last_map",goLastMap:e,_ajax_nonce:t,uid:a},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){jQuery("#mapwrapper").html(e),console.log("success!"),go_resizeMap(),document.getElementById("loader_container").style.display="none",document.getElementById("maps").style.display="block"}})}function go_resizeMap(){console.log("resize");var e,t="#map_"+jQuery("#maps").data("mapid"),a=jQuery(t+" .primaryNav > li").length-1;0==a&&(a=1),a==1/0&&(a=1);var o=100/a,r=jQuery(t).width()/a;100==o?(jQuery(t+" .primaryNav > li").css("width","90%"),jQuery(t+" .primaryNav li").css("float","right"),jQuery(t+" .tasks > li").css("width","80%"),jQuery(t+" .primaryNav li").addClass("singleCol")):r>=130?(jQuery(t+" .primaryNav li").css("float","left"),jQuery(t+" .primaryNav li").css("width",o+"%"),jQuery(t+" .tasks > li").css("width","100%"),jQuery(t+" .primaryNav li").css("background","")):(jQuery(t+" .primaryNav > li").css("width","100%"),jQuery(t+" .primaryNav li").css("float","right"),jQuery(t+" .tasks > li").css("width","95%"),jQuery(t+" .primaryNav li").addClass("singleCol")),jQuery("#sitemap").css("visibility","visible"),jQuery("#maps").css("visibility","visible")}function go_map_dropDown(){document.getElementById("go_Dropdown").classList.toggle("show")}function go_user_map(e){console.log("map");var t=GO_EVERY_PAGE_DATA.nonces.go_user_map_ajax;jQuery.ajax({type:"post",url:MyAjax.ajaxurl,data:{_ajax_nonce:t,action:"go_user_map_ajax",uid:e},error:function(e,t,a){400===e.status&&jQuery(document).trigger("heartbeat-tick.wp-auth-check",[{"wp-auth-check":!1}])},success:function(e){-1!==e&&jQuery.featherlight(e,{variant:"map",afterOpen:function(){console.log("after"),go_resizeMap(),jQuery(window).resize(function(){}),jQuery(window).on("resize",function(){go_resizeMap()})}})}})}jQuery(document).ready(function(){jQuery(".go_str_item").one("click",function(e){go_lb_opener(this.id)})}),function(e){"use strict";e.fn.fitVids=function(t){var a={customSelector:null,ignore:null};if(!document.getElementById("fit-vids-style")){var o=document.head||document.getElementsByTagName("head")[0],r=".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}",s=document.createElement("div");s.innerHTML='<p>x</p><style id="fit-vids-style">'+r+"</style>",o.appendChild(s.childNodes[1])}return t&&e.extend(a,t),this.each(function(){var t=['iframe[src*="player.vimeo.com"]','iframe[src*="youtube.com"]','iframe[src*="youtube-nocookie.com"]','iframe[src*="kickstarter.com"][src*="video.html"]',"object","embed"];a.customSelector&&t.push(a.customSelector);var o=".fitvidsignore";a.ignore&&(o=o+", "+a.ignore);var r=e(this).find(t.join(","));(r=(r=r.not("object object")).not(o)).each(function(){var t=e(this);if(!(t.parents(o).length>0||"embed"===this.tagName.toLowerCase()&&t.parent("object").length||t.parent(".fluid-width-video-wrapper").length)){t.css("height")||t.css("width")||!isNaN(t.attr("height"))&&!isNaN(t.attr("width"))||(t.attr("height",9),t.attr("width",16));var a,r,s=("object"===this.tagName.toLowerCase()||t.attr("height")&&!isNaN(parseInt(t.attr("height"),10))?parseInt(t.attr("height"),10):t.height())/(isNaN(parseInt(t.attr("width"),10))?t.width():parseInt(t.attr("width"),10));if(!t.attr("name")){var i="fitvid"+e.fn.fitVids._count;t.attr("name",i),e.fn.fitVids._count++}t.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",100*s+"%"),t.removeAttr("height").removeAttr("width")}})})},e.fn.fitVids._count=0}(window.jQuery||window.Zepto),jQuery(window).ready(function(){go_Vids_Fit_and_Box("body")}),window.onclick=function(e){if(!e.target.matches(".dropbtn")){var t=document.getElementsByClassName("dropdown-content"),a;for(a=0;a<t.length;a++){var o=t[a];o.classList.contains("show")&&o.classList.remove("show")}}};