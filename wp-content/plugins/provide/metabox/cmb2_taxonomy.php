<?php

class CMB2_Taxonomy
{
    public function __construct()
    {
        global $wpdb;
        $wpdb->termmeta = $wpdb->prefix . 'termmeta';
        add_action('init', array($this, 'init_actions'), 9999);
    }

    function init_actions()
    {
        if (!is_admin()) {
            return;
        }
        $taxonomies = get_taxonomies(array('public' => TRUE), 'names');
        foreach ($taxonomies as $taxonomy_name) {
            add_action("{$taxonomy_name}_add_form_fields", array($this, 'render_meta_fields_add_form'), 10);
            add_action("{$taxonomy_name}_edit_form", array($this, 'render_meta_fields_edit_form'), 10, 2);

            // Save our form data
            add_action("created_{$taxonomy_name}", array($this, 'save_meta_data'));
            add_action("edited_{$taxonomy_name}", array($this, 'save_meta_data'));

            add_action("delete_{$taxonomy_name}", array($this, 'delete_meta_data'));
        }
    }

    function render_meta_fields_add_form($taxonomy_name)
    {
        $this->render_meta_fields($taxonomy_name);
    }

    function render_meta_fields_edit_form($term, $taxonomy_name)
    {
        $this->render_meta_fields($taxonomy_name, $term->term_id);
    }

    function render_meta_fields($taxonomy_name, $term_id = NULL)
    {
        $metaboxes = apply_filters('cmb2-taxonomy_meta_boxes', array());
        foreach ($metaboxes as $key => $metabox) {
            if (!in_array($taxonomy_name, $metabox['object_types'])) {
                continue;
            }
            if (NULL === $term_id) {
                $this->render_form($metabox);
            } else {
                $this->render_form($metabox, $term_id);
            }
        }
    }

    function render_form($metabox, $term_id = 0)
    {
        if (!class_exists('CMB2')) {
            return;
        }
        $cmb = cmb2_get_metabox($metabox, $term_id);
        if (!$cmb) {
            return;
        }
        $cmb->object_type('term');
        if ($cmb->prop('cmb_styles')) {
            CMB2_hookup::enqueue_cmb_css();
        }
        CMB2_hookup::enqueue_cmb_js();
        $cmb->show_form();
    }

    public function save_meta_data($term_id)
    {
        if (!isset($_POST['taxonomy'])) {
            return;
        }
        $taxonomy_name = $_POST['taxonomy'];
        if (!current_user_can(get_taxonomy($taxonomy_name)->cap->edit_terms)) {
            return;
        }
        $metaboxes = apply_filters('cmb2-taxonomy_meta_boxes', array());
        foreach ($metaboxes as $key => $metabox) {
            if (!in_array($taxonomy_name, $metabox['object_types'])) {
                continue;
            }
            $cmb = cmb2_get_metabox($metabox, $term_id);
            if (isset($_POST[$cmb->nonce()]) && wp_verify_nonce($_POST[$cmb->nonce()], $cmb->nonce())) {
                $cmb->save_fields($term_id, 'term', $_POST);
            }
        }
    }

    public function delete_meta_data($term_id)
    {
        global $wpdb;
        $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->termmeta} WHERE term_id = %s", $term_id));
    }
}