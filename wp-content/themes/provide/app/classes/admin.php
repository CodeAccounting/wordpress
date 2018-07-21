<?php

class provide_admin
{

    private static $instance;

    public function __call($method, $args)
    {
        echo esc_html__("unknown method ", "provide") . $method;

        return FALSE;
    }

    public function init()
    {
        add_action('admin_enqueue_scripts', array(provide_Media::provide_singleton(), 'provide_RenderAdminStyles'));
        add_action('widgets_init', array(provide_sidebar::provide_singleton(), 'init'));
        add_action('admin_init', array($this, 'provide_roles'));
        add_action('save_post', array($this, 'provide_teamMember'));
        add_action('wp_trash_post', array($this, 'provide_deleteUser'));
        require_once provide_Root . 'app/lib/widgets.php';
        add_action('widgets_init', array('provide_Widgets', 'register'));
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        $this->provide_dummy();
        if (is_plugin_active('provide/provide.php')) {
            $path = ABSPATH . 'wp-content/plugins/provide/panel/';
            if (file_exists($path . 'panel-init.php')) {
                require_once $path . 'panel-init.php';
            }
        }
        require_once provide_Root . 'app/lib/3rdparty/tgm/tgm.php';
    }

    public function provide_teamMember($post_id)
    {
        global $post_type;
        if ($post_type == 'team') {
            $h = new provide_Helper();
            $checkEmail = get_post_meta($post_id, 'metaEmail', TRUE);
            $email = $h->provide_set($_POST, 'metaEmail');
            if (!empty($checkEmail) && $checkEmail != $email) {
                $user = get_user_by('email', $checkEmail);
                if ($user) {
                    wp_update_user(array('ID' => $user->data->ID, 'user_email' => $email));
                }
            }
            if (!empty($email)) {
                $siplitMail = explode('@', $email);
                $user = $h->provide_set($siplitMail, '0');
                if (!username_exists($user) && !email_exists($email)) {
                    $pass = wp_generate_password(12, TRUE, TRUE);
                    $user_id = wp_create_user($user, $pass, $email);
                    if (is_int($user_id)) {
                        $wp_user_object = new WP_User($user_id);
                        $wp_user_object->set_role('provide_team');
                        $getL = get_option('bootLoginForm');
                        $user = get_userdata($wp_user_object->ID);
                        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                        $message = sprintf(esc_html__('User Information of %s:', 'provide'), $blogname) . "\r\n\r\n";
                        $message .= sprintf(esc_html__('Username: %s', 'provide'), $user->user_login) . "\r\n\r\n";
                        $message .= sprintf(esc_html__('Password: %s', 'provide'), $pass) . "\r\n\r\n";
                        $message .= sprintf(esc_html__('Email: %s', 'provide'), $user->user_email) . "\r\n\r\n";
                        $message .= sprintf(esc_html__('Please Login from this link: %s', 'provide'), get_page_link($getL)) . "\r\n";
                        if (!class_exists('PHPMailer')) {
                            include(ABSPATH . 'wp-includes/class-phpmailer.php');
                        }
                        wp_mail($user->user_email, sprintf(esc_html__('[%s] Your username and password info', 'provide'), $blogname), $message);
                    } else {
                        wp_send_json(array('status' => FALSE, 'msg' => esc_html_e('Error with wp_insert_user. No users were created.', 'provide')));
                    }
                }
            }
        }
    }

    public function provide_roles()
    {
        $cap = array(
            'read' => TRUE,
        );
        add_role('provide_team', esc_html__('provide Team', 'provide'), $cap);
        add_role('provide_appointment', esc_html__('provide Appointment', 'provide'), $cap);
    }

    public function provide_deleteUser($post_id)
    {
        global $post_type;
        if ($post_type == 'team') {
            $mail = get_post_meta($post_id, 'metaEmail', TRUE);
            $user = get_user_by('email', $mail);
            wp_delete_user($user->data->ID);
            wp_delete_post($post_id, TRUE);
        }
    }

    public function provide_dummy()
    {
        $h = new provide_Helper();
        if ($h->provide_set($_GET, 'page') == 'themeOptions' && $h->provide_set($_GET, 'dummy') == true) {
            include_once ABSPATH . '/wp-content/plugins/provide/import_export.php';
            $importer = new provide_import_export();
            $importer->provide_export();
        }
    }

    public static function provide_singleton()
    {
        if (!isset(self::$instance)) {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }

        return self::$instance;
    }

    public function __clone()
    {
        trigger_error(esc_html__('Cloning the registry is not permitted', 'provide'), E_USER_ERROR);
    }

}
