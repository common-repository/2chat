<?php
/**
 * Plugin Name: 2Chat Whatsapp Button
 * Description: Use this free tool to create a custom WhatsApp floating button that you can place on your own website.
 * Version: 1.0
 * License: GPL v2 or later
 * Requires PHP: ^7.2
 * Author URI: https://2chat.co
 */

function w2chat_getLnag()
{
    $language = substr(get_locale(), 0, 2);
    $language = preg_match('/^(es|en|pt)$/', $language) ? $language : 'en';
    $langPath = "location/{$language}.json";
    ob_start();
    require_once($langPath);
    $jsonString = ob_get_clean();
    return json_decode($jsonString,1);
}

//Create the table in the database when activating the plugin
function w2chat_create_custom_table()
{
    global $wpdb;
    $table = $wpdb->prefix . '2chat_button_generator';

    $charset_collate = $wpdb->get_charset_collate();

    $consulta_sql = "CREATE TABLE IF NOT EXISTS $table (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        alias VARCHAR(100) NOT NULL,
        chat_box_title VARCHAR(200) NOT NULL,
        status_text VARCHAR(200) NOT NULL,
        greeting_message VARCHAR(500) NOT NULL,
        phone_number VARCHAR(20) NOT NULL,
        visitor_message_placeholder VARCHAR(200) NOT NULL,
        color_sheme VARCHAR(20) NOT NULL,
        position VARCHAR(10) NOT NULL,
        show_notification_badge VARCHAR(3) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($consulta_sql);
}
register_activation_hook(__FILE__, 'w2chat_create_custom_table');

// Add menu in WordPress admin area
function w2chat_add_setting_menu()
{
    $url_base = plugins_url('', __FILE__);
    add_menu_page(
        '2Chat',
        '2Chat',
        'manage_options',
        '2chat-plugin',
        'w2chat_management',
        $url_base . '/images/2chat-icon.png',
        30
    );
}
add_action('admin_menu', 'w2chat_add_setting_menu');

// Validate nonce
function w2chat_validateNonceByAction($action)
{
    // ignore nonce cases for list data and edit view;
    if (
        (!isset($_POST['save-data']) || $action===false) && $action!=='delete'
    ) {
        return true;
    }

    $id = '';
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $nonceName = '2chat_nounce_control-'.$action.$id;
    $nonce = '';
    if (isset($_POST['_wpnonce'])) {
        $nonce = $_POST['_wpnonce'];
    } else
    if (isset($_GET['_wpnonce'])) {
        $nonce = $_GET['_wpnonce'];
    }
    return wp_verify_nonce($nonce, $nonceName);
}

// Create Nonce
function w2chat_createNonce($action)
{
    $nonceName = '2chat_nounce_control-'.$action;
    return wp_create_nonce($nonceName);
}

// Sanitized, Escaped, and Validated form variables
function w2chat_sanitizedEscapedAndValidatedData($_LANG, $params=[])
{

    $defaultParams = [
        'alias' => [
            'default' => 'Alias 1',
            'control' => [
                'string' => [0, 100]
            ]
        ],
        'chat_box_title' => [
            'default' => $_LANG['tool_wa_button_generator_input_chat_box_default_value'],
            'control' => [
                'string' => [0, 100]
            ]
        ],
        'status_text' => [
            'default' => $_LANG['tool_wa_button_generator_input_status_text_default_value'],
            'control' => [
                'string' => [0, 500]
            ]
        ],
        'greeting_message' => [
            'default' => $_LANG['tool_wa_button_generator_input_greeting_message_default_value'],
            'control' => [
                'string' => [0, 500]
            ]
        ],
        'phone_number' => [
            'default' => '+1',
            'control' => [
                'string' => [0, 30]
            ]
        ],
        'visitor_message_placeholder' => [
            'default' => $_LANG['tool_wa_button_generator_input_visitor_message_placeholder_default_value'],
            'control' => [
                'string' => [0, 200]
            ]
        ],
        'color_sheme' => [
            'default' => 'automatic',
            'control' => [
                'match' => 'automatic|light|dark'
            ]
        ],
        'position' => [
            'default' => 'rigth',
            'control' => [
                'match' => 'right|left'
            ]
        ],
        'show_notification_badge' => [
            'default' => 'yes',
            'control' => [
                'match' => 'yes|no'
            ]
        ]
    ];

    $finalParams = [];
    foreach ($defaultParams as $index => $data) {
        $value = isset($params[$index]) ? $params[$index] : $data['default'];
        $value = sanitize_text_field($value);
        $value = esc_html($value);

        if ($index==='phone_number') {
            $finalParams[$index] = '+' . substr(preg_replace('/[^0-9]+/', '', $value), $data['control'][0], $data['control'][1]);

        } else
        if (isset($data['control']['string'])) {
            $finalParams[$index] = substr($value, $data['control'][0], $data['control'][1]);

        } else
        if (isset($data['control']['match'])) {
            $default = sanitize_text_field($data['default']);
            $default = esc_html($data['default']);
            $finalParams[$index] = preg_match('/^(' . $data['control']['match'] . ')$/', $value) ? $value : $default;
        }
    }

    return $finalParams;

}

// get the table name
function w2chat_getTableName()
{
    global $wpdb;
    return $wpdb->prefix . '2chat_button_generator';
}

// save data to DB
function w2chat_saveData($formValues, $ID)
{
    global $wpdb;
    $table = w2chat_getTableName();
    $sqlValue = ['%s','%s','%s','%s','%s','%s','%s','%s','%s'];
    if (!is_null($ID)) {

        $wpdb->update(
            $table,
            $formValues,
            array('id' => $ID),
            $sqlValue,
            array('%d')
        );
    } else {
        $wpdb->insert(
            $table,
            $formValues,
            $sqlValue
        );
    }
}

// show plugin view
function w2chat_showView($_LANG, $action)
{
    global $wpdb;
    $messageError = null;
    $formUrl = admin_url('admin.php?page=2chat-plugin');

    // Set default data
    $formValues = w2chat_sanitizedEscapedAndValidatedData($_LANG);

    // Process the add/modify data form
    if (isset($_POST['save-data'])) {

        // Senitize $_POST data, limit string length and set default variables
       $formValues = w2chat_sanitizedEscapedAndValidatedData($_LANG, $_POST);

        // Setting DB ID
        $getID = isset($_POST['id']) ? absint($_POST['id']) : null;

        // Get request by alias
        $data = $wpdb->get_row($wpdb->prepare("SELECT id,alias FROM " . w2chat_getTableName() . " WHERE alias = %s LIMIT 1", $formValues['alias']));

        if (!is_null($data) && $getID!=$data->id) {
            $action = is_null($getID) ? 'new' : 'edit';
            $messageError = $_LANG['tool_wa_button_generator_alias_repeat'];
        }

        // Update or create button if do not have message error
        if (is_null($messageError)) {
            w2chat_saveData($formValues, $getID);
            $action = null;
        }

    // Process delete or edit view actions
    } else if ($action) {

        // Setting DB ID
        $getID = isset($_GET['id']) ? absint($_GET['id']) : null;

        // Process the action of deleting data
        if ($action === 'delete' && !empty($getID)) {

            $wpdb->delete(w2chat_getTableName(), array('id' => $getID), array('%d'));
            $action = null;

        } else

        // Show the form view to add or modify data
        if ($action === 'edit' && !is_null($getID)) {

            $data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . w2chat_getTableName() . " WHERE id = %d", $getID));

            if ($data) {
                $formValues = w2chat_sanitizedEscapedAndValidatedData($_LANG, (array) $data);
            }
        }
    }


    if ($action && $action!=='delete') {


        if ($action) {
            $formUrl.= "&action={$action}";
        }
        if ($getID) {
            $formUrl.= "&id={$getID}";
        }

        // Create nonce code
        $nounceCode = w2chat_createNonce($action.(string)$getID);
        require_once 'includes/form.php';

    } else {

        $data = $wpdb->get_results("SELECT * FROM " . w2chat_getTableName());
        foreach ($data as $i => $value) {
            $value->nounceCode = w2chat_createNonce('delete'.$value->id);
            $data[$i] = $value;
        }
        require_once 'includes/table.php';
    }
}

// show plugin error view
function w2chat_showErrorView($url, $title, $errorCode, $messageError=null)
{
    require_once 'includes/error.php';
}

// Plugin admin page
function w2chat_management()
{
    $action = isset($_GET['action']) && preg_match('/^(edit|new|delete)$/', $_GET['action']) ? $_GET['action'] : false;
    $_LANG = w2chat_getLnag();

    $url = admin_url('admin.php?page=2chat-plugin');
    $messageError = $_LANG['tool_wa_button_generator_back_to_dashboard'];

    try {
        if (!current_user_can('manage_options') || !w2chat_validateNonceByAction($action)) {
            $url = admin_url('admin.php?page=2chat-plugin');
            w2chat_showErrorView($url, $messageError, '403');
        } else {
            w2chat_showView($_LANG, $action);
        }
    } catch (\Throwable $th) {
        w2chat_showErrorView($url, $messageError, '500');
    }
}

// Shortcode to display the data according to the Alias
function w2chat_shortcode($atts)
{
    $atts = shortcode_atts(array('alias' => ''), $atts);
    $alias = sanitize_text_field($atts['alias']);

    global $wpdb;
    $data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . w2chat_getTableName() . " WHERE alias = %s", $alias));

    if ($data) {
        $_2chatConfig = [
            "phoneNumber" => $data->phone_number,
            "accountName" => $data->chat_box_title,
            "statusMessage" => $data->status_text,
            "chatMessage" => $data->greeting_message,
            "placeholder" => $data->visitor_message_placeholder,
            "position" =>  $data->position,
            "colorScheme" => $data->color_sheme,
            "showNotification" => $data->show_notification_badge=='yes'
        ];
        ob_start();
        ?>
        <script>
            window._2chatConfig=<?php echo wp_json_encode($_2chatConfig)?>;
            <?php require_once 'includes/script.php'; ?>
        </script>
        <?php
        return ob_get_clean();
    } else {
        $_LANG = w2chat_getLnag();
        return $_LANG['tool_wa_button_generator_alias_unknow'];
    }
}
add_shortcode('2chat_whatsapp_button', 'w2chat_shortcode');
