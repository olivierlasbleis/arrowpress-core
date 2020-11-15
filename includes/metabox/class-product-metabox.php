<?php

class Apr_Core_Product_Metabox extends Apr_Metabox{
    private $screen = array(
        'product',
    );

    public function add_meta_boxes()
    {
        foreach ($this->screen as $single_screen) {
            add_meta_box(
                'product_metabox',
                __('Page Options', 'apr-core'),
                array($this, 'meta_box_callback'),
                $single_screen,
                'normal',
                'default'
            );
        }
    }

    public function general_meta_fields()
    {
        $meta_fields = array(
            array(
                'title' => esc_attr__('Product', 'apr-core'),
                'id' => 'product_option',
                'fields' => array(
                    array(
                        'id'                => 'meta_single_style',
                        'type'              => 'select',
                        'label'             => esc_html__( 'Single Style', 'apr-core' ),
                        'desc'              => esc_html__( 'Choose single product style ', 'apr-core' ),
                        'options' => array(
                            'default'   => esc_html__( 'Default', 'apr-core' ),
                            'single_default'  => esc_html__( 'Single Default', 'apr-core' ),
                            'single_1'  => esc_html__( 'Single 1', 'apr-core' ),
                            'single_2'  => esc_html__( 'Single 2', 'apr-core' ),
                        ),
                        'default'       => 'default',
                    ),
					array(
                        'id' => 'sticky_product',
                        'label' => esc_attr__('Show Sticky Product', 'apr-core'),
                        'type' => 'checkbox',
                        'default' => '',
                        'desc' => esc_attr__('Choose to show the sticky product', 'apr-core'),
                    ),
                    array(
                        'id'                => 'product_thumbnail_style',
                        'type'              => 'select',
                        'label'             => esc_html__( 'Product Thumbnails Style', 'apr-core' ),
                        'desc'              => esc_html__( 'Only use width single product style 1.', 'apr-core' ),
                        'options' => array(
                            'default'   => esc_html__( 'Default', 'apr-core' ),
                            'horizontal'  => esc_html__( 'Horizontal', 'apr-core' ),
                            'vertical'  => esc_html__( 'Vertical', 'apr-core' ),
                        ),
                        'default'       => 'default',
                    ),
                    array(
                        'id'      => 'background_color_single_product',
                        'label'   => esc_attr__( 'Background Color', 'apr-core' ),
                        'desc'    => esc_attr__( 'Select background color for page', 'apr-core' ),
                        'type'    => 'color',
                        'default' => '',
                    ),
                    array(
                        'id' => 'unit_price',
                        'label' => esc_attr__('Unit Price', 'apr-core'),
                        'desc' => esc_attr__('Enter unit price for the product.', 'apr-core'),
                        'type' => 'text',
                        'default' => '',
                    ),
                    array(
                        'id' => 'video_product',
                        'label' => esc_attr__('Link Video', 'apr-core'),
                        'desc' => esc_attr__('Enter link video Youtube, Vimeo,... for the product. (Ex: https://player.vimeo.com/video/125562082?autoplay=1)', 'apr-core'),
                        'type' => 'text',
                        'default' => '',
                    ),
                    array(
                        'id'                => 'tab_width',
                        'type'              => 'select',
                        'label'             => esc_html__( 'Tab Width', 'apr-core' ),
                        'options' => array(
                            'default'   => esc_html__( 'Default', 'apr-core' ),
                            'full_width'  => esc_html__( 'Full Width', 'apr-core' ),
                        ),
                        'default'       => 'default',
                    ),
                    array(
                        'id' => 'custom_tab_title',
                        'label' => esc_attr__('Custom Tab Title', 'apr-core'),
                        'desc' => esc_attr__('Input the custom tab title.', 'apr-core'),
                        'type' => 'text',
                        'default' => '',
                    ),
                    array(
                        'id' => 'custom_tab_content',
                        'label' => esc_attr__('Content Tab', 'apr-core'),
                        'desc' => esc_attr__('Input the content tab.', 'apr-core'),
                        'type' => 'editor',
                        'default' => '',
                    ),
                    array(
                        'id' => 'related_product',
                        'label' => esc_attr__('Hide Related Product', 'apr-core'),
                        'type' => 'checkbox',
                        'default' => '',
                        'desc' => esc_attr__('Choose to hide the related product', 'apr-core'),
                    ),
                    array(
                        'id' => 'upsell_product',
                        'label' => esc_attr__('Hide Upsell Product', 'apr-core'),
                        'type' => 'checkbox',
                        'default' => '',
                        'desc' => esc_attr__('Choose to hide the upsell product', 'apr-core'),
                    ),
                    array(
                        'id'                => 'position_upsell_related',
                        'type'              => 'select',
                        'label'             => esc_html__( 'Position Related, Upsell', 'apr-core' ),
                        'options' => array(
                            'in'  => esc_html__( 'In', 'apr-core' ),
                            'out'  => esc_html__( 'Out', 'apr-core' ),
                        ),
                        'default'       => 'out',
                    ),
                    array(
                        'id' => 'image_product',
                        'label' => esc_attr__('Image Product', 'apr-core'),
                        'desc' => esc_attr__('Upload image when you use APR Single Product shortcode on Elementor.', 'apr-core'),
                        'type' => 'image',
                        'default' => '',
                    ),
                    array(
                        'id' => 'size_guide_link',
                        'label' => esc_attr__('Size Guide Link', 'apr-core'),
                        'type' => 'text',
                        'default' => '',
                    ),
                    array(
                        'id' => 'model_information',
                        'label' => esc_attr__('Model Information', 'apr-core'),
                        'type' => 'editor',
                        'default' => '',
                    ),
                    array(
                        'id' => 'sub_title',
                        'label' => esc_attr__('Subtitle Product', 'apr-core'),
                        'desc' => esc_attr__('Only works when you use APR Single Product shortcode on Elementor.', 'apr-core'),
                        'type' => 'text',
                        'default' => '',
                    ),
                ),
            ),
            $this->general_option(),
            $this->skin_option(),
            $this->header_option(),
            $this->footer_option(),
        );
        return $meta_fields;
    }
}

if (class_exists('Apr_Core_Product_Metabox')) {
    new Apr_Core_Product_Metabox;
};

