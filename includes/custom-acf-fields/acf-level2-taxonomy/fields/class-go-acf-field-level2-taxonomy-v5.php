<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('go_acf_field_level2_taxonomy') ) :


class go_acf_field_level2_taxonomy extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct( $settings ) {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'level2_taxonomy';


		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Level 2 Taxonomy', 'acf-level2-taxonomy');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'relational';


		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
            'taxonomy' 			=> 'category',
		);

		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error!', 'acf-level2-taxonomy'),
		);
		
		
		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		
		
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/

        // default_value
        acf_render_field_setting( $field, array(
            'label'			=> __('Taxonomy','acf'),
            'instructions'	=> __('Select the taxonomy to be displayed','acf'),
            'type'			=> 'select',
            'name'			=> 'taxonomy',
            'choices'		=> acf_get_taxonomy_labels(),
        ));

        // field_type
        acf_render_field_setting( $field, array(
            'label'			=> __('Appearance','acf'),
            'instructions'	=> __('Select the appearance of this field','acf'),
            'type'			=> 'select',
            'name'			=> 'field_type',
            'optgroup'		=> true,
            'choices'		=> array(
                __("Select",'acf') => array(
                    'select' => __('Single Value', 'acf'),
                    'multi_select' => __('Multi Select', 'acf')
                )
            )
        ));

        // term to sort--if any
        acf_render_field_setting( $field, array(
            'label'			=> __('Order field ID','acf'),
            'instructions'	=> 'Enter the field ID ',
            'type'			=> 'text',
            'name'			=> 'order_field',
        ));


	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		
		
		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		/*
		echo '<pre>';
			print_r( $field );
		echo '</pre>';
		*/
		
		/*
		*  Create a simple text input using the 'font_size' setting.
		 * <select id=<?php echo esc_attr($field['name']) ?> name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>"></select>

		*/
		$class = "." . esc_attr($field['key']);
		$taxonomy = esc_attr($field['taxonomy']);
        $value = $field['value'];

        $field_type = esc_attr((isset($field['field_type']) ?  $field['field_type'] : ''));
        $order_field = esc_attr((isset($field['order_field']) ?  $field['order_field'] : 'none'));//the field id of the field to order on change, if any

        if(is_serialized($value)){
            $values = unserialize($value);
            //$values = array();
        }else if(!is_array($value)){
            $myvalue = intval($value);
            $values = array();
            $values[] = $myvalue;
        }else{
            $values = $value;
            $value = serialize($value);
        }


        $multiple = '';
        if($field_type === "multi_select"){
            $multiple = 'multiple';
        }
/*   <input type="hidden" style="display: block;" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo $value ?>" />   */
		/*?>

        <input type="hidden" class="<?php echo esc_attr($field['key']); ?>" style="display: block;" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo $value ?>" />
        <select <?php echo $multiple; ?> class="l2tax tax_<?php echo esc_attr($field['key']); ?>"  data-taxonomy="<?php echo $taxonomy; ?>" data-order_field="<?php echo $order_field; ?>" onchange='acf_level2_taxonomy_update(this);' style="width: 100%;" >
            <?php
               // $value = esc_attr($field['value']);
                if (!empty($value)){

                        foreach($values as $item){
                            $term = get_term($item);
                            if ($term){
                                $term_name = ( mb_strlen( $term->name ) > 50 ) ? mb_substr( $term->name, 0, 49 ) . '...' : $term->name;
                                //echo '<option value="' . $item. '" selected="selected">' . $term_name . '</option>';
                               //<option value="39" data-select2-id="143">Getting Started2</option>
                            }
                        }



                }
            ?>
        </select>

        <?php*/
        // Change Field into a select
        //$field= array();
        if( $field['field_type'] == 'select' ) {

            $field['multiple'] = 0;

           // $this->render_field_select( $field );

        } elseif( $field['field_type'] == 'multi_select' ) {

            $field['multiple'] = 1;

           // $this->render_field_select( $field );

        }
        $field['type'] = 'select';
        $field['ui'] = 1;
        $field['ajax'] = 1;
        $field['choices'] = array();
        $field['allow_null'] = true;

        if (!empty($value)){

            foreach($values as $item){
                $term = get_term($item);
                if ($term){
                    $term_name = ( mb_strlen( $term->name ) > 50 ) ? mb_substr( $term->name, 0, 49 ) . '...' : $term->name;
                    //echo '<option value="' . $item. '" selected="selected">' . $term_name . '</option>';
                    //<option value="39" data-select2-id="143">Getting Started2</option>
                    $field['choices'][ $item] = $term_name;
                }
            }

        }

        echo "<div class='l2select_wrapper' data-taxonomy='$taxonomy' data-order_field='$order_field'>";
        // render select
        acf_render_field( $field );
        echo "</div>";
	}
	
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/


	function input_admin_enqueue_scripts() {
		
		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];
		
		
		// register & include JS
		wp_register_script('acf-level2-taxonomy', "{$url}assets/js/input.js", array('acf-input'), $version);
		wp_enqueue_script('acf-level2-taxonomy');
		
		
		// register & include CSS
		wp_register_style('acf-level2-taxonomy', "{$url}assets/css/input.css", array('acf-input'), $version);
		wp_enqueue_style('acf-level2-taxonomy');
		
	}
	

	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_head() {
	
		
		
	}
	
	*/
	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/

	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_enqueue_scripts() {
		
	}
	
	*/

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	

	/*
	function load_value( $value, $post_id, $field ) {
        if (is_array($value)) {
            $value = $value[0];
        }
		return $value;
	}*/
	

	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	

	
	function update_value( $value, $post_id, $field ) {
	    $value = str_replace('.', ',', $value);
        //$myArray = explode(',', $value);
        if(!is_serialized($value)) {
           // $myArray = array_map('intval', explode(',', $value));
            if(is_array($value)) {
                $count = count($value);
            }else if (!empty($value)){
                $count = 1;
            }else{
                $count = 0;
            }

            if ($count === 1) {
                if(is_array($value)){
                    $value = $value[0];
                }
                $value = intval($value);
                if (!empty($value) || $value == 0) {
                    $post_id = intval($post_id);
                    $value = intval($value);
                    wp_set_object_terms($post_id, $value, $field['taxonomy']);
                }
            } else {
                $value = $value;
            }
        }else{
            $value = unserialize($value);
        }
        //$value = (array)$value;
        //wp_set_post_terms($post_id, $value);
		return $value;
	}
	

	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
		
	/*
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) ) {
		
			return $value;
			
		}
		
		
		// apply setting
		if( $field['font_size'] > 12 ) { 
			
			// format the value
			// $value = 'something';
		
		}
		
		
		// return
		return $value;
	}
	
	*/
	
	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	


	function validate_value( $valid, $value, $field, $input ){
		/*
		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}
		
		
		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','acf-level2-taxonomy');
		}
		
		*/
		// return
		return $valid;
		
	}
	

	
	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function load_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function update_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	/*
	
	function delete_field( $field ) {
		
		
		
	}	
	
	*/
	
	
}


// initialize
new go_acf_field_level2_taxonomy( $this->settings );


// class_exists check
endif;

?>