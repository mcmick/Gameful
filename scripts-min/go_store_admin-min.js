function go_badge_filter_on_load(){var e=".cmb-type-go_badge_input.cmb_id_go_mta_badge_filter",_=jQuery(e+" .go_badge_input_toggle"),o=jQuery(e+" .go_badge_input_add"),t=jQuery(e+" .go_badge_input_del");1===_.length&&_.change(go_badge_filter_checkbox_on_change),o.length>=1&&o.click(go_badge_filter_add_field),t.length>=1&&(1==t.length&&t.hide(),t.click(go_badge_filter_del_field))}function go_badge_filter_on_toggle(){var e=".cmb-type-go_badge_input.cmb_id_go_mta_badge_filter",_=jQuery(e+" .go_badge_input_toggle"),o=jQuery(e+" .go_stage_badge_container");_.show();var t=!1;1===_.length&&_.is(":checked")&&(t=!0),jQuery(e).show(),t?jQuery(o).show():jQuery(o).hide()}function go_badge_filter_checkbox_on_change(e){var _=e.target,o=jQuery(_).is(":checked"),t=jQuery(_).siblings("ul.go_stage_badge_container"),r=!1;t.is(":visible")&&(r=!0),o&&!r?t.show():!o&&r&&t.hide()}function go_badge_filter_add_field(e){var _=e.target,o=jQuery(_).siblings(".go_badge_input_del").eq(0),t=jQuery(_).siblings(".go_badge_input")[0],r=jQuery(_).parents().eq(1),i=jQuery(_).parents().eq(0),g=["type","name","class","stage","placeholder"],u=["type","class","value"],c=document.createElement("li");jQuery(i).after(c);var l=document.createElement("input");jQuery(c).append(l);var n=document.createElement("input");jQuery(c).append(n);var s=document.createElement("input");jQuery(c).append(s);for(var d="",a=0;a<g.length;a++)d=jQuery(t).attr(g[a]),jQuery(l).attr(g[a],d);for(var h=0;h<u.length;h++)d=jQuery(_).attr(u[h]),jQuery(n).attr(u[h],d);if(jQuery(n).click(go_badge_filter_add_field),o.length>0){for(var y=0;y<u.length;y++)d=jQuery(o).attr(u[y]),jQuery(s).attr(u[y],d);jQuery(s).click(go_badge_filter_del_field)}var j=r.children("li");if(j.length>0){var Q=jQuery(j[0]).children(".go_badge_input_del").eq(0);Q.is(":visible")||Q.show()}}function go_badge_filter_del_field(e){var _=e.target,o=jQuery(_).parents().eq(1),t=jQuery(_).parents().eq(0);jQuery(t).remove();var r=o.children("li");1===r.length&&jQuery(r[0]).children(".go_badge_input_del").hide()}jQuery(document).ready(function(){jQuery("#go_store_limit_checkbox").prop("checked")?jQuery("#go_store_limit_input").show("slow"):jQuery("#go_store_limit_input").hide("slow"),jQuery("#go_store_limit_checkbox").click(function(){jQuery("#go_store_limit_checkbox").prop("checked")?jQuery("#go_store_limit_input").show("slow"):jQuery("#go_store_limit_input").hide("slow")}),jQuery("#go_store_filter_checkbox").prop("checked")?jQuery(".go_store_filter_input").show("slow"):jQuery(".go_store_filter_input").hide("slow"),jQuery("#go_store_filter_checkbox").click(function(){jQuery("#go_store_filter_checkbox").prop("checked")?jQuery(".go_store_filter_input").show("slow"):jQuery(".go_store_filter_input").hide("slow")}),go_badge_filter_on_load(),jQuery(".go_badge_input_toggle").toggle(go_badge_filter_on_toggle),jQuery("#go_store_gift_checkbox").prop("checked")?jQuery(".go_store_gift_input").show("slow"):jQuery(".go_store_gift_input").hide("slow"),jQuery("#go_store_gift_checkbox").click(function(){jQuery("#go_store_gift_checkbox").prop("checked")?jQuery(".go_store_gift_input").show("slow"):jQuery(".go_store_gift_input").hide("slow")}),jQuery("#go_store_focus_checkbox").prop("checked")?jQuery("#go_store_focus_select").show("slow"):jQuery("#go_store_focus_select").hide("slow"),jQuery("#go_store_focus_checkbox").click(function(){jQuery("#go_store_focus_checkbox").prop("checked")?jQuery("#go_store_focus_select").show("slow"):jQuery("#go_store_focus_select").hide("slow")})});