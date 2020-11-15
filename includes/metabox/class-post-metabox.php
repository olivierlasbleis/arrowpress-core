<?php
class Apr_Core_Post_Metabox extends Apr_Metabox {
    private $screen = array(
        'post',
    );
    public function add_meta_boxes() {
        foreach ( $this->screen as $single_screen ) {
            add_meta_box(
                'post_metabox',
                __( 'Post Options', 'apr-core' ),
                array( $this, 'meta_box_callback' ),
                $single_screen,
                'normal',
                'default'
            );
        }
    }
    public function general_meta_fields(){
        $meta_fields = array(
            array(
                'title'     => esc_attr__( 'Post', 'apr-core' ),
                'id'        => 'post_option',
                'fields'    => array(
                    array(
                        'id'                =>'gallery_metabox',
                        'type'              =>'gallery',
                        'label'             => esc_html__( 'Galery Format', 'apr-core' ),
                        'desc'              => esc_html__( ' Upload images gallery ', 'apr-core' ),
                        'default'           => '',
                    ),
                    array(
                        'id'                => 'post_video',
                        'label'             => esc_attr__( 'Video Format', 'apr-core' ),
                        'desc'              => esc_attr__( 'Insert link video. (Ex: https://vimeo.com/322065821)', 'apr-core' ),
                        'type'              => 'text',
                        'default'           => '',
                        'display_condition' => 'post-type-video', 
                    ),
                    array(
                        'id'                => 'post_audio',
                        'label'             => esc_attr__( 'Audio Format', 'apr-core' ),
                        'desc'              => esc_attr__( 'Insert link audio(Ex: https://soundcloud.com/powfu/death-bed-prod-otterpop).', 'apr-core' ),
                        'type'              => 'text',
                        'default'           => '',
                        'display_condition' => 'post-type-video', 
                    ),
                    array(
                        'id'                => 'post_quote_text',
                        'label'             => esc_attr__( 'Quote Format - Source Text', 'apr-core' ),
                        'desc'              => esc_attr__( 'Insert Quote Format - Source Text.', 'apr-core' ),
                        'type'              => 'text',
                        'default'           => '',
                        'display_condition' => 'post-type-quote',
                    ),
                    array(
                        'id'                => 'post_link',
                        'label'             => esc_attr__( 'Link Format', 'apr-core' ),
                        'desc'              => esc_attr__( 'Insert Link Format', 'apr-core' ),
                        'type'              => 'text',
                        'default'           => '',
                        'display_condition' => 'post-type-link', 
                    ),
                    array(
                        'id'      => 'featured_post',
                        'label'   => esc_attr__( 'Featured Post', 'apr-core' ),
                        'type'    => 'checkbox',
                        'default' => '',
                    ),
                ),
            ),
            $this -> general_option(),
            $this -> skin_option(),
            $this -> breadcrumbs_option(),
            $this -> header_option(),
            $this -> footer_option(),
        );
        return $meta_fields;  
    }
}
if (class_exists('Apr_Core_Post_Metabox')) {
    new Apr_Core_Post_Metabox;
};

