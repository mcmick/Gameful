jQuery( document ).ready( function() {
    jQuery( "#datepicker_clipboard" ).datepicker({ firstDay: 0 });
    jQuery("#datepicker_clipboard").datepicker('setDate', new Date());//today's date

    //Tabs
    if ( jQuery( '#records_tabs' ).length ) {
        jQuery('#records_tabs').tabs();
        jQuery( '.clipboard_tabs' ).click( function() {
        	//console.log("tabs");
            tab = jQuery(this).attr('tab');
            switch (tab) {

                case 'clipboard':
                    //console.log("stats1");
                    go_clipboard_stats_datatable(false);
                    //force window resize on load to initialize responsive behavior
                    jQuery("#go_clipboard_stats_datatable").DataTable().columns.adjust()
                        .responsive.recalc();
                    break;
                case 'store':
                    go_clipboard_store_datatable();
                    //force window resize on load to initialize responsive behavior
                    jQuery("#go_clipboard_store_datatable").DataTable().columns.adjust()
                       .responsive.recalc();
                    //add the store item filter select2
                    jQuery('#go_store_item_select').select2({
                        ajax: {
                            url: ajaxurl, // AJAX URL is predefined in WordPress admin
                            dataType: 'json',
                            delay: 400, // delay in ms while typing when to perform a AJAX search
                            data: function (params) {
                                return {
                                    q: params.term, // search query
                                    action: 'go_make_cpt_select2_ajax', // AJAX action for admin-ajax.php
                                    cpt: 'go_store'
                                };
                            },
                            processResults: function( data ) {
                                //console.log("search results: " + data);
                                var options = [];
                                if ( data ) {

                                    // data is the array of arrays, and each of them contains ID and the Label of the option
                                    jQuery.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                                        options.push( { id: text[0], text: text[1]  } );
                                    });

                                }
                                return {
                                    results: options
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 1, // the minimum of symbols to input before perform a search
                        multiple: true,
                        placeholder: "Show All"
                    });
                    break;
                case 'messages':
                    //console.log("messages");
                    go_clipboard_messages_datatable();
                    //force window resize on load to initialize responsive behavior
                    jQuery("#go_clipboard_messages_datatable").DataTable().columns.adjust()
                        .responsive.recalc();
                    break;
                case 'activity':
                    //console.log("activity");
                    go_clipboard_activity_datatable();
                    jQuery("#go_clipboard_activity_datatable").DataTable().columns.adjust()
                        .responsive.recalc();
                    //add task select2
                    jQuery('#go_task_select').select2({
                        ajax: {
                            url: ajaxurl, // AJAX URL is predefined in WordPress admin
                            dataType: 'json',
                            delay: 400, // delay in ms while typing when to perform a AJAX search
                            data: function (params) {
                                return {
                                    q: params.term, // search query
                                    action: 'go_make_cpt_select2_ajax', // AJAX action for admin-ajax.php
                                    cpt: 'tasks'
                                };
                            },
                            processResults: function( data ) {
                                //console.log("search results: " + data);
                                var options = [];
                                if ( data ) {

                                    // data is the array of arrays, and each of them contains ID and the Label of the option
                                    jQuery.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                                        options.push( { id: text[0], text: text[1]  } );
                                    });

                                }
                                return {
                                    results: options
                                };
                            },
                            cache: false
                        },
                        minimumInputLength: 1, // the minimum of symbols to input before perform a search
                        multiple: true,
                        placeholder: "Show All"
                    });
                    break;
            }
        });
	}

	if ( jQuery( "#records_tabs" ).length ) {
        //go_clipboard_stats_datatable(false);
        jQuery("#records_tabs").css("margin-left", '');

        //initialize the datepicker inputs
        //console.log('datepicker');
	}


    // Get saved data from sessionStorage
    var section = localStorage.getItem('go_clipboard_section');
    var section_name = localStorage.getItem('go_clipboard_section_name');
    var badge = localStorage.getItem('go_clipboard_badge');
    var badge_name = localStorage.getItem('go_clipboard_badge_name');
    var group = localStorage.getItem('go_clipboard_group');
    var group_name = localStorage.getItem('go_clipboard_group_name');
    var unmatched = localStorage.getItem('go_clipboard_unmatched');

    if (unmatched == true || unmatched == 'true'){
        jQuery('#go_unmatched_toggle').prop('checked', true);
    }

    jQuery('#go_clipboard_user_go_sections_select').select2({
        ajax: {
            url: ajaxurl, // AJAX URL is predefined in WordPress admin
            dataType: 'json',
            delay: 400, // delay in ms while typing when to perform a AJAX search
            data: function (params) {

                    return {
                        q: params.term, // search query
                        action: 'go_make_taxonomy_dropdown_ajax', // AJAX action for admin-ajax.php
                        taxonomy: 'user_go_sections',
                        is_hier: false
                    };


            },
            processResults: function( data ) {

                jQuery("#go_clipboard_user_go_sections_select").select2("destroy");
                jQuery('#go_clipboard_user_go_sections_select').children().remove();
                jQuery("#go_clipboard_user_go_sections_select").select2({
                    data: data,
                    placeholder: "Show All",
                    allowClear: true}).val(section).trigger("change");
                jQuery("#go_clipboard_user_go_sections_select").select2("open");
                return {
                    results: data
                };

            },
            cache: true
        },
        minimumInputLength: 0, // the minimum of symbols to input before perform a search
        multiple: false,
        placeholder: "Show All",
        allowClear: true
    });

    //jQuery('#go_clipboard_user_go_sections_select').select2({data: go_get_menu_data('go_user_sections')});
   // go_cache_menu(1, 'stats');

    //jQuery("#go_clipboard_user_go_sections_select").select2("destroy").select2({data:data});

    if( section != null && section != 'null') {
        // Fetch the preselected item, and add to the control
        var sectionSelect = jQuery('#go_clipboard_user_go_sections_select');
        // create the option and append to Select2
        var option = new Option(section_name, section, true, true);
        sectionSelect.append(option).trigger('change');
    }


    jQuery('#go_clipboard_user_go_groups_select').select2({
        ajax: {
            url: ajaxurl, // AJAX URL is predefined in WordPress admin
            dataType: 'json',
            delay: 400, // delay in ms while typing when to perform a AJAX search
            data: function (params) {
                return {
                    q: params.term, // search query
                    action: 'go_make_taxonomy_dropdown_ajax', // AJAX action for admin-ajax.php
                    taxonomy: 'user_go_groups',
                    is_hier: true
                };
            },
            processResults: function( data ) {
                jQuery("#go_clipboard_user_go_groups_select").select2("destroy");
                jQuery('#go_clipboard_user_go_groups_select').children().remove();
                jQuery("#go_clipboard_user_go_groups_select").select2({
                    data:data,
                    placeholder: "Show All",
                    allowClear: true}).val(group).trigger("change");
                jQuery("#go_clipboard_user_go_groups_select").select2("open");
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 0, // the minimum of symbols to input before perform a search
        multiple: false,
        placeholder: "Show All",
        allowClear: true
    });
    if( group != null && group != 'null') {
        // Fetch the preselected item, and add to the control
        var groupsSelect = jQuery('#go_clipboard_user_go_groups_select');
        // create the option and append to Select2
        var option = new Option(group_name, group, true, true);
        groupsSelect.append(option).trigger('change');
    }

    jQuery('#go_clipboard_go_badges_select').select2({
        ajax: {
            url: ajaxurl, // AJAX URL is predefined in WordPress admin
            dataType: 'json',
            delay: 400, // delay in ms while typing when to perform a AJAX search
            data: function (params) {
                return {
                    q: params.term, // search query
                    action: 'go_make_taxonomy_dropdown_ajax', // AJAX action for admin-ajax.php
                    taxonomy: 'go_badges',
                    is_hier: true
                };
            },
            processResults: function( data ) {

                jQuery("#go_clipboard_go_badges_select").select2("destroy");
                jQuery('#go_clipboard_go_badges_select').children().remove();
                jQuery("#go_clipboard_go_badges_select").select2({
                    data: data,
                    placeholder: "Show All",
                    allowClear: true}).val(badge).trigger("change");
                jQuery("#go_clipboard_go_badges_select").select2("open");
                return {
                    results: data
                };
            },
            cache: false
        },
        minimumInputLength: 0, // the minimum of symbols to input before perform a search
        multiple: false,
        placeholder: "Show All",
        allowClear: true
    });
    if( badge != null && badge != 'null') {
        console.log("setB");
        // Fetch the preselected item, and add to the control
        var badgesSelect = jQuery('#go_clipboard_go_badges_select');
        // create the option and append to Select2
        var option = new Option(badge_name, badge, true, true);
        badgesSelect.append(option).trigger('change');
    }

    //jQuery('#go_clipboard_user_go_sections_select').val(section).trigger('change');;
    //jQuery('#go_clipboard_user_go_groups_select').val(group);
    //jQuery('#go_clipboard_go_badges_select').val(badge);
    go_clipboard_stats_datatable();//draw the stats tab on load

    //ADD Blue background and glow to filter button
    jQuery('#datepicker_clipboard, #go_unmatched_toggle').change(function () {
        jQuery('.go_update_clipboard').addClass("bluepulse");
        jQuery('.go_update_clipboard').html('<span class="ui-button-text">Apply Filters<i class="fa fa-filter" aria-hidden="true"></i></span>');
    });

    jQuery('#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #go_task_select, #go_store_item_select').on('select2:select', function (e) {
        // Do something
        jQuery('.go_update_clipboard').addClass("bluepulse");
        jQuery('.go_update_clipboard').html('<span class="ui-button-text">Apply Filters<i class="fa fa-filter" aria-hidden="true"></i></span>');
    });
    jQuery('#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #go_task_select, #go_store_item_select').on('select2:unselect', function (e) {
        // Do something
        jQuery('.go_update_clipboard').addClass("bluepulse");
        jQuery('.go_update_clipboard').html('<span class="ui-button-text">Apply Filters<i class="fa fa-filter" aria-hidden="true"></i></span>');
    });

    jQuery('.go_reset_clipboard').on("click", function () {
        jQuery('#datepicker_clipboard').val("");
        jQuery('#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #go_task_select, #go_store_item_select').val(null).trigger('change');
        jQuery('.go_update_clipboard').addClass("bluepulse");
        jQuery('.go_update_clipboard').html('<span class="ui-button-text">Apply Filters<i class="fa fa-filter" aria-hidden="true"></i></span>');
        jQuery('#go_unmatched_toggle').prop('checked', false); // Uncheck
    });
});

//not used
function go_cache_menu( data, menu){
    // the type of the cacheData should be changed to object
    sessionStorage.setItem('go_menu_' + menu, JSON.stringify(data));
}

//not used?
function go_get_menu_data(taxonomy){
    jQuery.ajax({
        type: "get",
        url: MyAjax.ajaxurl,
        data: {
            //_ajax_nonce: nonce,
            action: 'go_clipboard_save_filters',
            section: section,
            badge: badge,
            group: group,
            unmatched: unmatched
        },
        success: function( res ) {
           return res;
        }
    });
}

function go_toggle( source ) {
	checkboxes = jQuery( '.go_checkbox' );
	for (var i = 0, n = checkboxes.length; i < n ;i++) {
		checkboxes[ i ].checked = source.checked;
	}
}

function go_clipboard_callback() {
    //*******************//
    // ALL TABS
    //*******************//
        //Apply on click to the stats and messages buttons in the table
        go_stats_links();

        //apply on click to the messages button at the top
        jQuery('.go_messages_icon_multiple_clipboard').parent().prop('onclick',null).off('click');
        jQuery(".go_messages_icon_multiple_clipboard").parent().one("click", function(e){
            go_messages_opener(null, null, "multiple_messages");
        });

        tippy('.tooltip', {
            delay: 0,
            arrow: true,
            arrowType: 'round',
            size: 'large',
            duration: 300,
            animation: 'scale',
            zIndex: 999999
        });

    //*******************//
    //GET CURRENT TAB
    //*******************//
        var current_tab = jQuery("#records_tabs").find("[aria-selected='true']").attr('aria-controls');
        console.log(current_tab);

    //IF CURRENT TAB IS . . .
        if (current_tab == "clipboard_wrap"){
            //recalculate for responsive behavior
            jQuery("#go_clipboard_stats_datatable").DataTable().columns.adjust()
                .responsive.recalc();

            //hide action filters
            jQuery('#go_action_filters').hide();

            //update button--set this table to update
            jQuery('.go_update_clipboard').prop('onclick',null).off('click');//unbind click
            jQuery('.go_update_clipboard').one("click", function () {
                Clipboard.draw();
                    //go_clipboard_stats_datatable(true);
                    go_clipboard_update();
            });

            //search
            //unbind search
            jQuery("div.dataTables_filter input").unbind();
            //search on clear with 'x'
            document.querySelector("#go_clipboard_stats_datatable_filter input").onsearch = function (e) {
                Clipboard.search( this.value ).draw();
            };
        }
        else if (current_tab == "clipboard_store_wrap") {
            //recalculate for responsive behavior
            jQuery("#go_clipboard_store_datatable").DataTable().columns.adjust()
                .responsive.recalc();

            //show action filters
            jQuery('#go_action_filters').show();
            jQuery('#go_store_filters').show();
            jQuery('#go_task_filters').hide();

            //update button--set this table to update
            jQuery('.go_update_clipboard').prop('onclick',null).off('click');//unbind click
            jQuery('.go_update_clipboard').one("click", function () {
                //go_clipboard_store_datatable(true);
                Store.draw();
                go_clipboard_update();
            });

            //search
            jQuery("div.dataTables_filter input").unbind();
            //search on clear with 'x'
            document.querySelector("#go_clipboard_store_datatable_filter input").onsearch = function (e) {
                Store.search( this.value ).draw();
            };
        }
        else if (current_tab == "clipboard_messages_wrap") {
            //recalculate for responsive behavior
            jQuery("#go_clipboard_messages_datatable").DataTable().columns.adjust()
                .responsive.recalc();

            //show/hide filters
            jQuery('#go_action_filters').show();
            jQuery('#go_store_filters').hide();
            jQuery('#go_task_filters').hide();

            //update button--set this table to update
            jQuery('.go_update_clipboard').prop('onclick',null).off('click');//unbind click
            jQuery('.go_update_clipboard').one("click", function () {
                Messages.draw();
                go_clipboard_update();
            });

            /*
            //if filters are changed, redraw the table
            jQuery('#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #datepicker_clipboard').unbind("change");
            jQuery('#go_clipboard_user_go_sections_select, #go_clipboard_user_go_groups_select, #go_clipboard_go_badges_select, #datepicker_clipboard').change(function () {
                Messages.draw();
                go_save_clipboard_filters();
                //Clear other tabs
                jQuery('#go_clipboard_stats_datatable').remove();
                jQuery('#go_clipboard_store_datatable').remove();
                //jQuery('#go_clipboard_messages_datatable').remove();
            });
            */

            //search
            jQuery("div.dataTables_filter input").unbind();
            //search on clear with 'x'
            document.querySelector("#go_clipboard_messages_datatable_filter input").onsearch = function (e) {
                Messages.search( this.value ).draw();
            };
        }
        else if (current_tab == "clipboard_activity_wrap") {
            //recalculate for responsive behavior
            jQuery("#go_clipboard_activity_datatable").DataTable().columns.adjust()
                .responsive.recalc();

            //show date filter
            jQuery('#go_action_filters').show();
            jQuery('#go_store_filters').hide();
            jQuery('#go_task_filters').show();

            //update button--set this table to update
            jQuery('.go_update_clipboard').prop('onclick',null).off('click');//unbind click
            jQuery('.go_update_clipboard').one("click", function () {
                Activity.draw();
                go_clipboard_update();
            });

            //search
            jQuery("div.dataTables_filter input").unbind();
            //search on clear with 'x'
            document.querySelector("#go_clipboard_activity_datatable_filter input").onsearch = function (e) {
                Activity.search( this.value ).draw();
            };

            /*
            //apply on click to the reset button at the top
            jQuery('.go_reset_icon').prop('onclick',null).off('click');
            jQuery(".go_reset_icon").one("click", function(e){
                go_messages_opener();
            });
            */
            go_enable_reset_buttons();
        }
}

function go_clipboard_update() {
    go_save_clipboard_filters();
    jQuery('.go_update_clipboard').removeClass("bluepulse");
    jQuery('.go_update_clipboard').html('<span class="ui-button-text">Refresh Data <span class="dashicons dashicons-update" style="vertical-align: center;"></span></span>');




    //*******************//
    //GET CURRENT TAB
    //*******************//
    var current_tab = jQuery("#records_tabs").find("[aria-selected='true']").attr('aria-controls');
    //IF CURRENT TAB IS . . .
    if (current_tab == "clipboard_wrap"){
        //Clear other tables
        //jQuery('#go_clipboard_stats_datatable').remove();
        jQuery('#go_clipboard_store_datatable').remove();
        jQuery('#go_clipboard_messages_datatable').remove();
    }
    else if (current_tab == "clipboard_store_wrap") {
        //Clear other tabs
        jQuery('#go_clipboard_stats_datatable').remove();
        //jQuery('#go_clipboard_store_datatable').remove();
        jQuery('#go_clipboard_messages_datatable').remove();
    }
    else if (current_tab == "clipboard_messages_wrap") {
        //Clear other tabs
        jQuery('#go_clipboard_stats_datatable').remove();
        jQuery('#go_clipboard_store_datatable').remove();
        //jQuery('#go_clipboard_messages_datatable').remove();
    }
    else if (current_tab == "clipboard_activity_wrap") {
    }
}

//this now saves to session data
function go_save_clipboard_filters(){
    //SESSION STORAGE
    var section = jQuery( '#go_clipboard_user_go_sections_select' ).val();
    var section_name = jQuery("#go_clipboard_user_go_sections_select option:selected").text();
    var group = jQuery( '#go_clipboard_user_go_groups_select' ).val();
    var group_name = jQuery("#go_clipboard_user_go_groups_select option:selected").text();
    var badge = jQuery( '#go_clipboard_go_badges_select' ).val();
    var badge_name = jQuery("#go_clipboard_go_badges_select option:selected").text();
    var unmatched = document.getElementById("go_unmatched_toggle").checked;

    console.log("b " + badge);


    localStorage.setItem('go_clipboard_section', section);
    localStorage.setItem('go_clipboard_badge', badge);
    localStorage.setItem('go_clipboard_group', group);
    localStorage.setItem('go_clipboard_section_name', section_name);
    localStorage.setItem('go_clipboard_badge_name', badge_name);
    localStorage.setItem('go_clipboard_group_name', group_name);
    localStorage.setItem('go_clipboard_unmatched', unmatched);

    /*
    //THIS IS FOR SAVING AS OPTION IN DB WITH AJAX
    //ajax to save the values
    var nonce = GO_CLIPBOARD_DATA.nonces.go_clipboard_save_filters;
    var section = jQuery( '#go_clipboard_user_go_sections_select' ).val();
    var group = jQuery( '#go_clipboard_user_go_groups_select' ).val();
    var badge = jQuery( '#go_clipboard_go_badges_select' ).val();
    var unmatched = document.getElementById("go_unmatched_toggle").checked;
    //alert ("badge " + badge);
    //console.log(jQuery( '#go_clipboard_user_go_sections_select' ).val());
    jQuery.ajax({
        type: "post",
        url: MyAjax.ajaxurl,
        data: {
            _ajax_nonce: nonce,
            action: 'go_clipboard_save_filters',
            section: section,
            badge: badge,
            group: group,
            unmatched: unmatched
        },
        success: function( res ) {
            console.log("values saved");
        }
    });
    */
}

/*
function go_filter_clipboard_datatables(filter_badges) { //function that filters all tables on draw
    jQuery.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var mytable = settings.sTableId;
            //if (mytable == "go_clipboard_stats_datatable" || mytable == "go_clipboard_messages_datatable" || mytable == "go_clipboard_activity_datatable") {
                var section = jQuery('#go_clipboard_user_go_sections_select').val();
                var group = jQuery('#go_clipboard_user_go_groups_select').val();
                var badge = jQuery('#go_clipboard_go_badges_select').val();
                var badges =  data[4] ;
                var groups =  data[3] ; // use data for the filter by column
                var sections = data[2]; // use data for the filter by column



                groups = JSON.parse(groups);
                //sections = JSON.parse(sections);
                badges = JSON.parse(badges);
                //console.log("badges" + badges);
                //console.log("sections" + sections);

                var inlist = true;
                if( group == "none" || jQuery.inArray(group, groups) != -1) {
                    inlist = true;
                }else {
                    inlist = false;
                }

                if (inlist){
                    if( section == "none" || sections == section) {
                        inlist = true;
                    }else {
                        inlist = false;
                    }
                }
                if (filter_badges == true) {
                    if (inlist) {
                        if (badge == "none" || jQuery.inArray(badge, badges) != -1) {
                            inlist = true;
                            //console.log(inlist);
                        } else {
                            inlist = false;
                            //console.log(inlist);
                        }
                    }
                }
                return inlist;
            //}
            //else{
             //   return true;
           // }
        });
}
*/

function go_toggle_off() {
    checkboxes = jQuery( '.go_checkbox' );
    for (var i = 0, n = checkboxes.length; i < n ;i++) {
        checkboxes[ i ].checked = false;
    }
}

function go_clipboard_stats_datatable(refresh) {
	if (jQuery("#go_clipboard_stats_datatable").length == 0  || refresh == true) {
        jQuery("#clipboard_stats_datatable_container").html("<h2>Loading . . .</h2>");
        var nonce = GO_CLIPBOARD_DATA.nonces.go_clipboard_stats;
        //console.log("refresh" + refresh);
        //console.log("stats");
        jQuery.ajax({
            type: "post",
            url: MyAjax.ajaxurl,
            data: {
                _ajax_nonce: nonce,
                action: 'go_clipboard_stats',
                refresh: refresh
            },
            success: function( res ) {
                //console.log("success");
                if (-1 !== res) {
                    jQuery('#clipboard_stats_datatable_container').html(res);

                    Clipboard = jQuery('#go_clipboard_stats_datatable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": MyAjax.ajaxurl + '?action=go_clipboard_stats_dataloader_ajax',
                            "data": function(d){
                                //d.user_id = jQuery('#go_stats_hidden_input').val();
                                //d.user_id = jQuery('#go_stats_hidden_input').val();
                                d.section = jQuery('#go_clipboard_user_go_sections_select').val();
                                d.group = jQuery('#go_clipboard_user_go_groups_select').val();
                                d.badge = jQuery('#go_clipboard_go_badges_select').val();
                            }
                        },
                        "bPaginate": true,
                        //colReorder: true,
                        "order": [[6, "desc"]],
                        responsive: true,
                        "autoWidth": false,
                        stateSave: true,
                        stateLoadParams: function( settings, data ) {
                            //if (data.order) delete data.order;
                            if (data.search) delete data.search;
                            if (data.start) delete data.start;
                        },
                        "stateDuration": 31557600,
                        searchDelay: 1000,
                        dom: 'lBfrtip',
                        "drawCallback": function( settings ) {
                            go_clipboard_callback();
                        },
                        "columnDefs": [
                            { type: 'natural', targets: '_all'  },
                            {
                                "targets": [0],
                                className: 'noVis',
                                "width": "1px",
                                sortable: false
                            },
                            {
                                "targets": [1],
                                className: 'noVis',
                                "width": "20px",
                                sortable: false
                            },
                            {
                                "targets": [7],
                                //className: 'noVis',
                                sortable: false
                            },
                            {
                                "targets": [8],
                                //className: 'noVis',
                                //sortable: false
                            },
                            {
                                "targets": [13],
                                //className: 'noVis',
                                //sortable: false
                            }
                        ],
                        buttons: [
                            {
                                text: '<span class="go_messages_icon_multiple_clipboard">Message <i class="fa fa-bullhorn" aria-hidden="true"></i><span>',
                                action: function ( e, dt, node, config ) {

                                }

                            },
                            {
                                extend: 'collection',
                                text: 'Export ...',
                                buttons: [{
                                    extend: 'pdf',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    },
                                    orientation: 'landscape'
                                },{
                                    extend: 'excel',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'csv',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }],

                            },
                            {
                                extend: 'colvis',
                                columns: ':not(.noVis)',
                                postfixButtons: ['colvisRestore'],
                                text: 'Column Visibility'
                            }


                        ]
                    });
                    //Filter the table
                    //go_filter_clipboard_datatables(true);
                    //redraw table
                    //Clipboard.draw();
                }
            }
        });
    }else{
        go_clipboard_callback();
    }
}

function go_clipboard_store_datatable(refresh) {

    if ( jQuery( "#go_clipboard_store_datatable" ).length == 0  || refresh == true) {
        jQuery("#clipboard_store_datatable_container").html("<h2>Loading . . .</h2>");
        var nonce = GO_CLIPBOARD_DATA.nonces.go_clipboard_store;
        jQuery.ajax({
            type: "post",
            url: MyAjax.ajaxurl,
            data: {
                _ajax_nonce: nonce,
                action: 'go_clipboard_store'
                //go_clipboard_messages_datatable: jQuery( '#go_clipboard_store_datatable' ).val()
            },
            success: function( res ) {
                //console.log("success");
                if (-1 !== res) {
                    jQuery('#clipboard_store_datatable_container').html(res);
                    //go_filter_datatables();
                    Store = jQuery('#go_clipboard_store_datatable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": MyAjax.ajaxurl + '?action=go_clipboard_store_dataloader_ajax',
                            "data": function(d){
                                //d.user_id = jQuery('#go_stats_hidden_input').val();
                                d.date = jQuery( '#datepicker_clipboard' ).val();
                                d.section = jQuery('#go_clipboard_user_go_sections_select').val();
                                d.group = jQuery('#go_clipboard_user_go_groups_select').val();
                                d.badge = jQuery('#go_clipboard_go_badges_select').val();
                                d.unmatched = document.getElementById("go_unmatched_toggle").checked;
                                d.store_item = jQuery("#go_store_item_select").val();
                            }
                        },
                        "bPaginate": true,
                        //colReorder: true,
                        "order": [[8, "desc"]],
                        responsive: true,
                        "autoWidth": false,
                        stateSave: true,
                        stateLoadParams: function( settings, data ) {
                            //if (data.order) delete data.order;
                            if (data.search) delete data.search;
                            if (data.start) delete data.start;
                        },
                        "stateDuration": 31557600,
                        searchDelay: 1000,
                        dom: 'lBfrtip',
                        "drawCallback": function( settings ) {
                            go_clipboard_callback();
                        },
                        "columnDefs": [
                            { type: 'natural', targets: '_all' },
                            {
                                "targets": [0],
                                className: 'noVis',
                                "width": "5px",
                                sortable: false
                            },
                            {
                                "targets": [1],
                                className: 'noVis',
                                "width": "20px",
                                sortable: false
                            },
                            {
                                "targets": [7],
                                sortable: false
                            },
                            {
                                "targets": [9],
                                sortable: true
                            },
                            {
                                "targets": [13],
                                sortable: false
                            }
                        ],
                        buttons: [
                            {
                                text: '<span class="go_messages_icon_multiple_clipboard">Message <i class="fa fa-bullhorn" aria-hidden="true"></i><span>',
                                action: function ( e, dt, node, config ) {
                                }
                            },
                            {
                                extend: 'collection',
                                text: 'Export ...',
                                buttons: [{
                                    extend: 'pdf',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    },
                                    orientation: 'landscape'
                                },{
                                    extend: 'excel',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'csv',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }],
                            },
                            {
                                extend: 'colvis',
                                columns: ':not(.noVis)',
                                postfixButtons: ['colvisRestore'],
                                text: 'Column Visibility'
                            }
                        ]
                    });
                }
            }
        });
    }
    else{
        go_clipboard_callback();
    }
}

function go_clipboard_messages_datatable(refresh) {
    if ( jQuery( "#go_clipboard_messages_datatable" ).length == 0  || refresh == true) {
        jQuery("#clipboard_messages_datatable_container").html("<h2>Loading . . .</h2>");

        var nonce = GO_CLIPBOARD_DATA.nonces.go_clipboard_messages;

        jQuery.ajax({
            type: "post",
            url: MyAjax.ajaxurl,
            data: {
                _ajax_nonce: nonce,
                action: 'go_clipboard_messages'
                //go_clipboard_messages_datatable: jQuery( '#go_clipboard_messages_datatable' ).val()
            },
            success: function( res ) {
                //console.log("success");
                if (-1 !== res) {
                    jQuery('#clipboard_messages_datatable_container').html(res);
                    //go_filter_datatables();
                    Messages = jQuery('#go_clipboard_messages_datatable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": MyAjax.ajaxurl + '?action=go_clipboard_messages_dataloader_ajax',
                            "data": function(d){
                                //d.user_id = jQuery('#go_stats_hidden_input').val();
                                d.date = jQuery( '#datepicker_clipboard' ).val();
                                d.section = jQuery('#go_clipboard_user_go_sections_select').val();
                                d.group = jQuery('#go_clipboard_user_go_groups_select').val();
                                d.badge = jQuery('#go_clipboard_go_badges_select').val();
                                d.unmatched = document.getElementById("go_unmatched_toggle").checked;
                            }
                        },
                        "bPaginate": true,
                        //colReorder: true,
                        "order": [[8, "desc"]],
                        responsive: true,
                        "autoWidth": false,
                        searchDelay: 1000,
                        stateSave: true,
                        stateLoadParams: function( settings, data ) {
                            //if (data.order) delete data.order;
                            if (data.search) delete data.search;
                            if (data.start) delete data.start;
                        },
                        "stateDuration": 31557600,
                        dom: 'lBfrtip',
                        "drawCallback": function( settings ) {
                            go_clipboard_callback();
                        },
                        "columnDefs": [
                            { type: 'natural', targets: '_all' },
                            {
                                "targets": [0],
                                className: 'noVis',
                                "width": "5px",
                                sortable: false
                            },
                            {
                                "targets": [1],
                                className: 'noVis',
                                "width": "20px",
                                sortable: false
                            },
                            {
                                "targets": [7],
                                sortable: false
                            },
                            {
                                "targets": [9],
                                sortable: false
                            },
                            {
                                "targets": [13],
                                sortable: false
                            }
                        ],
                        buttons: [
                            {
                                text: '<span class="go_messages_icon_multiple_clipboard">Message <i class="fa fa-bullhorn" aria-hidden="true"></i><span>',
                                action: function ( e, dt, node, config ) {
                                }
                            },
                            {
                                extend: 'collection',
                                text: 'Export ...',
                                buttons: [{
                                    extend: 'pdf',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    },
                                    orientation: 'landscape'
                                },{
                                    extend: 'excel',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'csv',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }],
                            },
                            {
                                extend: 'colvis',
                                columns: ':not(.noVis)',
                                postfixButtons: ['colvisRestore'],
                                text: 'Column Visibility'
                            }
                        ]
                    });
                    //search only on enter key
                    jQuery("div.dataTables_filter input").unbind();
                    jQuery("div.dataTables_filter input").keyup( function (e) {
                        if (e.keyCode == 13) {
                            Messages.search( this.value ).draw();
                        }
                    });
                }
            }
        });
    }
    else{
        go_clipboard_callback();
    }
}

function go_clipboard_activity_datatable(refresh) {
    if ( jQuery( "#go_clipboard_activity_datatable" ).length == 0  || refresh == true) {
        jQuery("#clipboard_activity_datatable_container").html("<h2>Loading . . .</h2>");

        var nonce = GO_CLIPBOARD_DATA.nonces.go_clipboard_activity;

        console.log("date: " + jQuery( '#datepicker_clipboard' ).val());
        console.log("section: " + jQuery('#go_clipboard_user_go_sections_select').val());
        console.log("group: " + jQuery('#go_clipboard_user_go_groups_select').val());
        console.log("badges: " + jQuery('#go_clipboard_go_badges_select').val());
        console.log("unmatched: " + document.getElementById("go_unmatched_toggle").checked);
        console.log("tasks: " + jQuery("#go_task_select").val());

        //console.log(date);
        jQuery.ajax({
            type: "post",
            url: MyAjax.ajaxurl,
            data: {
                _ajax_nonce: nonce,
                action: 'go_clipboard_activity',
                date: jQuery( '#datepicker_clipboard' ).val()
            },
            success: function( res ) {
                //console.log("success");
                if (-1 !== res) {
                    jQuery('#clipboard_activity_datatable_container').html(res);
                    //go_filter_datatables();
                    Activity = jQuery('#go_clipboard_activity_datatable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": MyAjax.ajaxurl + '?action=go_clipboard_activity_dataloader_ajax',
                            "data": function(d){
                                //d.user_id = jQuery('#go_stats_hidden_input').val();
                                d.date = jQuery( '#datepicker_clipboard' ).val();
                                d.section = jQuery('#go_clipboard_user_go_sections_select').val();
                                d.group = jQuery('#go_clipboard_user_go_groups_select').val();
                                d.badge = jQuery('#go_clipboard_go_badges_select').val();
                                d.unmatched = document.getElementById("go_unmatched_toggle").checked;
                                d.tasks = jQuery("#go_task_select").val();
                                for (var i = 0, len = d.columns.length; i < len; i++) {
                                    if (! d.columns[i].search.value) delete d.columns[i].search;
                                    if (d.columns[i].searchable === true) delete d.columns[i].searchable;
                                    if (d.columns[i].orderable === true) delete d.columns[i].orderable;
                                    if (d.columns[i].data === d.columns[i].name) delete d.columns[i].name;
                                }
                                delete d.search.regex;
                            }
                        },
                        deferRender: true,
                        "bPaginate": true,
                        //colReorder: true,
                        "order": [11, "asc"],
                        responsive: true,
                        "autoWidth": false,
                        //stateSave: true,
                        stateLoadParams: function( settings, data ) {
                            //if (data.order) delete data.order;
                            if (data.search) delete data.search;
                            if (data.start) delete data.start;
                        },
                        "stateDuration": 31557600,
                        dom: 'lBfrtip',
                        "drawCallback": function( settings ) {
                            go_clipboard_callback();
                        },
                        "columnDefs": [
                            { type: 'natural', targets: '_all' },
                            {
                                "targets": [0],
                                className: 'noVis',
                                "width": "5px",
                                sortable: false
                            },
                            {
                                "targets": [1],
                                className: 'noVis',
                                "width": "20px",
                                sortable: false
                            },
                            {
                                "targets": [7, 9, 14],
                                sortable: false
                            }
                        ],
                        buttons: [
                            {
                                text: '<span class="go_messages_icon_multiple_clipboard">Message <i class="fa fa-bullhorn" aria-hidden="true"></i><span>',
                                action: function ( e, dt, node, config ) {
                                }
                            },
                            {
                                text: '<span class="go_tasks_reset_multiple_clipboard">Reset <i class="fa fa-times-circle" aria-hidden="true"></i><span>',
                                action: function ( e, dt, node, config ) {
                                }
                            },

                            {
                                extend: 'collection',
                                text: 'Export ...',
                                buttons: [{
                                    extend: 'pdf',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    },
                                    orientation: 'landscape'
                                },{
                                    extend: 'excel',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }, {
                                    extend: 'csv',
                                    title: 'Game On Data Export',
                                    exportOptions: {
                                        columns: "thead th:not(.noExport)"
                                    }
                                }],

                            },
                            {
                                extend: 'colvis',
                                columns: ':not(.noVis)',
                                postfixButtons: ['colvisRestore'],
                                text: 'Column Visibility'
                            },


                        ]

                    });

                    // Add event listener for opening and closing more actions
                    jQuery('#go_clipboard_activity_datatable .show_more').click( function () {
                        var hidden = jQuery(this).hasClass('shown');
                        //console.log(hidden);
                        if (hidden == false) {
                            jQuery(this).addClass('shown');
                            jQuery(this).siblings('.hidden_action').show();
                            jQuery(this).find('.hide_more_actions').show();
                            jQuery(this).find('.show_more_actions').hide();
                            //console.log("show");
                        }else{
                            jQuery(this).removeClass('shown');
                            jQuery(this).siblings('.hidden_action').hide();
                            jQuery(this).find('.hide_more_actions').hide();
                            jQuery(this).find('.show_more_actions').show();
                            //console.log("hide");
                        }
                    });

                }
            }
        });
    }else{
        go_clipboard_callback();
    }
}