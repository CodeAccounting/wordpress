<?php

class provide_TeamMetabox
{

    public function __construct()
    {
        add_action('cmb2_init', array($this, 'provide_Register'));
    }

    public function provide_Register()
    {
        $settings = array(
            'id' => 'team_meta',
            'title' => esc_html__('Member Detail', 'provide'),
            'object_types' => array('pr_team'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        );
        $meta = new_cmb2_box($settings);
        $fields = $this->provide_fields();
        foreach ($fields as $field) {
            $meta->add_field($field);
        }
        $this->provide_groupFields($meta);
        $this->provide_groupFields2($meta);
    }

    public function provide_fields()
    {
        return array(
            array(
                'name' => esc_html__('Designation', 'provide'),
                'id' => 'metaDesignation',
                'type' => 'text',
            )
        );
    }

    public function provide_groupFields($meta)
    {
        $group_field_id = $meta->add_field(array(
            'id' => 'metaSocialProfiler',
            'type' => 'group',
            'options' => array(
                'group_title' => esc_html__('Social Profile {#}', 'provide'),
                'add_button' => esc_html__('Add Another', 'provide'),
                'remove_button' => esc_html__('Remove', 'provide'),
                'sortable' => false,
                'closed' => true
            ),
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Select Icon', 'provide'),
            'id' => 'metaProfileIcon',
            'type' => 'fontawesome_icon'
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Link', 'provide'),
            'id' => 'metaProfileLink',
            'type' => 'text_url'
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Color', 'provide'),
            'id' => 'metaProfileSocialColor',
            'type' => 'colorpicker'
        ));
    }

    public function provide_groupFields2($meta)
    {
        $group_field_id = $meta->add_field(array(
            'id' => 'metaMemberSkill',
            'type' => 'group',
            'options' => array(
                'group_title' => esc_html__('Skill {#}', 'provide'),
                'add_button' => esc_html__('Add Another', 'provide'),
                'remove_button' => esc_html__('Remove', 'provide'),
                'sortable' => false,
                'closed' => true
            ),
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Skill Name', 'provide'),
            'id' => 'metaSkillName',
            'type' => 'text'
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Percentage', 'provide'),
            'id' => 'metaSkillPercentage',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
            )
        ));
    }

}