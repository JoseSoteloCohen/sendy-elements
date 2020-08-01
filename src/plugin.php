<?php
/**
 * Class Sendy_Action_After_Submit
 * @see https://developers.elementor.com/custom-form-action/
 * Custom elementor form action after submit to add a subsciber to
 * Sendy list via API
 */
class Sendy_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {
	/**
	 * Get Name
	 *
	 * Return the action name
	 *
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'sendy';
	}

	/**
	 * Get Label
	 *
	 * Returns the action label
	 *
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return __( 'Sendy', 'text-domain' );
	}

	/**
	 * Run
	 *
	 * Runs the action after submit
	 *
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );


        //  Make sure that there is a Sendy installation url
		if ( empty( $settings['sendy_url'] ) ) {
			return;
		}

		//  Make sure that there is a Sendy API Key
		if ( empty( $settings['sendy_api_field'] ) ) {
			return;
		}

		//  Make sure that there is a Sendy list ID
		if ( empty( $settings['sendy_list'] ) ) {
			return;
		}

		// Make sure that there is a Sendy Email field ID
		// which is required by Sendy's API to subsribe a user
		if ( empty( $settings['sendy_email_field'] ) ) {
			return;
		}

		// Get sumitetd Form data
		$raw_fields = $record->get( 'fields' );

		// Normalize the Form Data
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		// Make sure that the user emtered an email
		// which is required by Sendy's API to subsribe a user
		if ( empty( $fields[ $settings['sendy_email_field'] ] ) ) {
			return;
		}

		// If we got this far we can start building our request data
		// Based on the param list at https://sendy.co/api
		// 
		// Set GDPR Value
		if ('yes' === $settings['sendy_gdpr']){
			$gdpr = 'true';
		}else{
			$gdpr = 'false';
		}

        // Populate Sendy Default Fields Only
        $sendy_data = [
            'name' => ucfirst($fields[ $settings['sendy_name_field'] ]),
            'email' => $fields[ $settings['sendy_email_field'] ],
            'gdpr' => $gdpr,
            'list' => $settings['sendy_list'],
            'api_key' => $settings['sendy_api_field'],
            'ipaddress' => \ElementorPro\Core\Utils::get_client_ip(),
            'referrer' => isset( $_POST['referrer'] ) ? $_POST['referrer'] : '',
        ];

        $customFieldsLen = count($settings['sendy_custom_fields']);
        for($i = 0; $i < $customFieldsLen; $i++){
            $customFieldName = $settings['sendy_custom_fields'][$i]['custom_field_name'];
            $customFieldId = $settings['sendy_custom_fields'][$i]['custom_field_id'];
            $sendy_data[$customFieldName] = $fields[ $customFieldId ];
        }

        // Send the request
		wp_remote_post( $settings['sendy_url'] . 'subscribe', [
			'body' => $sendy_data,
		] );
	}

	/**
	 * Register Settings Section
	 *
	 * Registers the Action controls
	 *
	 * @access public
	 * @param \Elementor\Widget_Base $widget
	 */
	public function register_settings_section( $widget ) {


        $widget->start_controls_section(
			'section_sendy',
			[
				'label' => __( 'Sendy', 'text-domain' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'sendy_url',
			[
				'label' => __( 'Sendy URL', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'http://your_sendy_installation/',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the URL where you have Sendy installed, including a trailing /', 'text-domain' ),
			]
		);

		$widget->add_control(
			'sendy_api_field',
			[
				'label' => __( 'API KEY', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'To find it go to Settings (top right corner) -> Your API Key.', 'text-domain' ),
			]
		);

		$widget->add_control(
			'sendy_list',
			[
				'label' => __( 'Sendy List ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'separator' => 'before',
				'description' => __( 'The list id you want to subscribe a user to. This encrypted & hashed id can be found under View all lists section named ID.', 'text-domain' ),
			]
		);

		$widget->add_control(
			'sendy_email_field',
			[
				'label' => __( 'Email Field ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$widget->add_control(
			'sendy_name_field',
			[
				'label' => __( 'Name Field ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$widget->add_control(
			'sendy_gdpr',
			[
				'label' => __( 'GDPR/CCPA Compliant:', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'separator' => 'before',
				'return_value' => 'yes',
				'default' => 'no',
				'description' => __( 'Enable if your form is GDPR and CCPA compliant', 'text-domain' ),
			]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'custom_field_name', [
                'label' => __( 'Custom field name', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Place the Name of the Sendy Custom Field', 'text-domain' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'custom_field_id', [
                'label' => __( 'Custom field id', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Place the ID of the Elementor Field', 'text-domain' ),
                'label_block' => true,
            ]
        );

        $widget->add_control(
            'sendy_custom_fields',
            [
                'label' => __( 'Custom Fields', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ custom_field_name }}}',
                'separator' => 'before'
            ]
        );

		$widget->end_controls_section();

	}

	/**
	 * On Export
	 *
	 * Clears form settings on export
	 * @access Public
	 * @param array $element
	 */
	public function on_export( $element ) {
		unset(
			$element['sendy_url'],
			$element['sendy_list'],
			$element['sendy_name_field'],
			$element['sendy_email_field'],
			$element['sendy_api_field'],
			$element['sendy_custom_fields'],
			$element['sendy_gdpr'],
			$element['custom_field_name'],
			$element['custom_field_id'],
		);
	}
}
add_action( 'elementor_pro/init', function() {
// Here its safe to include our action class file
include_once( 'sendy-elements.php' );

// Instantiate the action class
$sendy_action = new Sendy_Action_After_Submit();

// Register the action with form widget
\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( $sendy_action->get_name(), $sendy_action );
});