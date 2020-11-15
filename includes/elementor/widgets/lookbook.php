<?php

namespace Elementor;
if (!defined('ABSPATH')) exit;
if (class_exists('WooCommerce')) {
    class Apr_Core_Lookbook extends Widget_Base
    {

        public function get_name()
        {
            return 'apr_lookbook';
        }

        public function get_title()
        {
            return esc_html__('APR Lookbook', 'apr-core');
        }

        public function get_icon()
        {
            return 'eicon-eye';
        }

        public function get_categories()
        {
            return ['apr-core'];
        }

        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_lookbook',
                [
                    'label' => esc_html__('Contents', 'apr-core'),
                ]
            );

            $this->add_control(
                'section_lookbook_style',
                [
                    'label' => __('Lookbook Layout', 'apr-core'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style1',
                    'options' => [
                        'style1' => __('Layout 1', 'apr-core'),
                        'style2' => __('Layout 2', 'apr-core'),
                    ],
                ]
            );

            $this->add_control(
                'lookbook_image',
                [
                    'label' => __('Image', 'apr-core'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'section_lookbook_style' => ['style1'],
                    ],
                ]
            );

            $this->add_control(
                'id_product_parent',
                [
                    'label' => __('Product id', 'apr-core'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $this->get_products_group_id(),
                    'description' => __('Please choose Grouped product id.', 'apr-core'),
                    'condition' => [
                        'section_lookbook_style' => ['style2'],
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'lookbook_image_size',
                    'default' => 'full',
                    'separator' => 'none',
                    'condition' => [
                        'section_lookbook_style' => ['style1'],
                    ],
                ]
            );

            $this->add_control(
                'show_custom_image',
                [
                    'label' => __('Show Custom Image Size', 'apr-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('On', 'apr-core'),
                    'label_off' => __('Off', 'apr-core'),
                    'default' => 'Off',
                    'condition' => [
                        'section_lookbook_style' => ['style2'],
                    ],
                ]
            );

            $this->add_control(
                'custom_dimension_image',
                [
                    'label' => __('Image Size', 'apr-core'),
                    'type' => Controls_Manager::IMAGE_DIMENSIONS,
                    'description' => __('You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'apr-core'),
                    'condition' => [
                        'section_lookbook_style' => ['style2'],
                        'show_custom_image' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'box_background_overlay',
                [
                    'label' => __('Background Overlay', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner:before' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'opacity_images',
                [
                    'label' => __('Opacity', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 1,
                            'min' => 0.10,
                            'step' => 0.01,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner:before' => 'opacity: {{SIZE}};',
                    ],
                    'separator' => 'after',
                ]
            );

            $lookbook_repeater = new Repeater();

            $lookbook_repeater->add_control(
                'position_content',
                [
                    'label' => __('Alignment Content', 'apr-core'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'top' => [
                            'title' => __('Top', 'apr-core'),
                            'icon' => 'eicon-v-align-top',
                        ],
                        'right' => [
                            'title' => __('Right', 'apr-core'),
                            'icon' => 'eicon-h-align-right',
                        ],
                        'bottom' => [
                            'title' => __('Bottom', 'apr-core'),
                            'icon' => 'eicon-v-align-bottom',
                        ],
                        'left' => [
                            'title' => __('Left', 'apr-core'),
                            'icon' => 'eicon-h-align-left',
                        ],
                    ],
                    'default' => 'top',
                ]
            );

            $lookbook_repeater->add_control(
                'id_product',
                [
                    'label' => __('Product id', 'apr-core'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $this->get_products_id(),
                ]
            );
            $lookbook_repeater->add_responsive_control(
                'box_width',
                [
                    'label' => __('Min Width Of The Box', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px',],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product' => 'min-width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $lookbook_repeater->add_responsive_control(
                'images_width',
                [
                    'label' => __('Width Of The Image', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['px',],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product .images' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product .title-price' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
                    ],
                ]
            );

            $lookbook_repeater->add_responsive_control(
                'position_left',
                [
                    'label' => __('Position On The Left', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item' => 'left: {{SIZE}}%;',
                    ],
                ]
            );
            $lookbook_repeater->add_responsive_control(
                'position_top',
                [
                    'label' => __('Position On The Top', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item' => 'top: {{SIZE}}%;',
                    ],
                ]
            );

            $lookbook_repeater->add_control(
                'box_border_color_top',
                [
                    'label' => __('Border Content Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product .triangular-arrows' => 'border-color: {{VALUE}} transparent transparent transparent;',
                    ],
                    'condition' => [
                        'position_content' => 'top',
                    ],
                ]
            );

            $lookbook_repeater->add_control(
                'box_border_color_right',
                [
                    'label' => __('Border Content Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product .triangular-arrows' => 'border-color: transparent {{VALUE}} transparent transparent;',
                    ],
                    'condition' => [
                        'position_content' => 'right',
                    ],
                ]
            );

            $lookbook_repeater->add_control(
                'box_border_color_bottom',
                [
                    'label' => __('Border Content Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product .triangular-arrows' => 'border-color: transparent transparent {{VALUE}} transparent;',
                    ],
                    'condition' => [
                        'position_content' => 'bottom',
                    ],
                ]
            );

            $lookbook_repeater->add_control(
                'box_border_color_left',
                [
                    'label' => __('Border Content Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} {{CURRENT_ITEM}}.repeater-item .product-item .content-product .triangular-arrows' => 'border-color: transparent transparent transparent {{VALUE}};',
                    ],
                    'condition' => [
                        'position_content' => 'left',
                    ],
                ]
            );

            $this->add_control(
                'lookbook_repeater',
                [
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $lookbook_repeater->get_controls(),
                    'default' => [
                        [
                            'id_product' => __('', 'apr-core'),
                            'position_left' => __('', 'apr-core'),
                            'position_top' => __('', 'apr-core'),
                        ],
                    ],
                    'title_field' => '{{{ id_product }}}',
                ]
            );
            $this->add_control(
                'hide_add_to_cart',
                [
                    'label' => __('Hide Cart', 'apr-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'Yes',
                ]
            );
            $this->end_controls_section();

            //style

            $this->start_controls_section(
                'box_lookbook',
                [
                    'label' => esc_html__('Box Content', 'apr-core'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_responsive_control(
                'content_padding_box',
                [
                    'label' => esc_html__('Content Padding', 'apr-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_tags',
                [
                    'label' => __('Tags', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'Tags_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .product-tooltip .theme-icon-tag-icon' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'Tags__background_color',
                [
                    'label' => __('Background Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .product-tooltip .theme-icon-tag-icon' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .product-tooltip .theme-icon-tag-icon:after' => 'border-color: {{VALUE}} transparent transparent transparent;',
                    ],
                ]
            );

            $this->add_control(
                'product_dots',
                [
                    'label' => __('Dots', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'dots_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .product-tooltip:after' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'border_dots_color',
                [
                    'label' => __('Border Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .product-tooltip:before' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'dots_bg_color',
                [
                    'label' => __('Background Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => ['{{WRAPPER}} .lookbook-inner .repeater-item .product-item' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'content_product_parent',
                [
                    'label' => esc_html__('Product', 'apr-core'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_responsive_control(
                'content_padding_parent',
                [
                    'label' => esc_html__('Padding', 'apr-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_title_parent',
                [
                    'label' => __('Title', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'product_title_color_parent',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group .title a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'product_title_color_hover_parent',
                [
                    'label' => __('Hover Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group .title a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_title_typography_parent',
                    'selector' => '{{WRAPPER}} .contnet-product-group .title a',
                ]
            );
            $this->add_responsive_control(
                'title_spacing_parent',
                [
                    'label' => __('Spacing', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '',
                        'unit' => 'px',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_cart_parent',
                [
                    'label' => __('Cart', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'product_cart_color_parent',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group .action-item.add-cart a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'product_cart_color_hover_parent',
                [
                    'label' => __('Hover Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group .action-item.add-cart a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_cart_typography_parent',
                    'selector' => '{{WRAPPER}} .contnet-product-group .action-item.add-cart a:before',
                ]
            );
            $this->add_control(
                'product_wishlist_parent',
                [
                    'label' => __('Wishlist', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_wishlist_color_parent',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group div.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'product_wishlist_color_hover_parent',
                [
                    'label' => __('Color Hover', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group div.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'product_wishlist_active_color_parent',
                [
                    'label' => __('Added Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group div.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
                         {{WRAPPER}} .contnet-product-group div.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'icon_size_parent',
                [
                    'label' => __('Size', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['%', 'px'],
                    'range' => [
                        'px' => [
                            'min' => 6,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group div.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a,
                        {{WRAPPER}} .contnet-product-group div.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
                         {{WRAPPER}} .contnet-product-group div.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'content_product',
                [
                    'label' => esc_html__('Product Lookbook Content', 'apr-core'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_responsive_control(
                'content_padding',
                [
                    'label' => esc_html__('Content Padding', 'apr-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'product_image',
                [
                    'label' => __('Image', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_image_border',
                    'label' => esc_html__('Border', 'apr-core'),
                    'selector' => '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .images',
                ]
            );

            $this->add_control(
                'product_title',
                [
                    'label' => __('Title', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'product_title_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .title a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'product_title_color_hover',
                [
                    'label' => __('Hover Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .title a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_title_typography',
                    'selector' => '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .title a',
                ]
            );
            $this->add_responsive_control(
                'title_spacing',
                [
                    'label' => __('Spacing', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '',
                        'unit' => 'px',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_price',
                [
                    'label' => __('Price', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'product_price_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .price' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_price_typography',
                    'selector' => '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .price',
                ]
            );
            $this->add_responsive_control(
                'price_spacing',
                [
                    'label' => __('Spacing', 'apr-core'),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '',
                        'unit' => 'px',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'size_units' => ['px'],
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_cart',
                [
                    'label' => __('Cart', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'product_cart_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .action-item.add-cart a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'product_cart_color_hover',
                [
                    'label' => __('Hover Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .action-item.add-cart a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_cart_typography',
                    'selector' => '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .title-price .action-item.add-cart a',
                ]
            );

            $this->add_control(
                'btn_get_outfit_parent',
                [
                    'label' => __('Button Get the outfit', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'section_lookbook_style' => ['style2'],
                    ],
                ]
            );
            $this->add_control(
                'btn_get_outfit_color_parent',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group .button-get-outfit a' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'section_lookbook_style' => ['style2'],
                    ],
                ]
            );
            $this->add_control(
                'btn_get_outfit_color_hover_parent',
                [
                    'label' => __('Hover Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .contnet-product-group .button-get-outfit a:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .contnet-product-group .button-get-outfit a:hover i' => 'background-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'section_lookbook_style' => ['style2'],
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btn_get_outfit_typography_parent',
                    'selector' => '{{WRAPPER}} .contnet-product-group .button-get-outfit a',
                    'condition' => [
                        'section_lookbook_style' => ['style2'],
                    ],
                ]
            );
            $this->add_control(
                'product_wishlist',
                [
                    'label' => __('Wishlist', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'section_lookbook_style' => ['style1'],
                    ],
                ]
            );
            $this->add_control(
                'product_wishlist_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .images div.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'section_lookbook_style' => ['style1'],
                    ],
                ]
            );
            $this->add_control(
                'product_wishlist_active_color',
                [
                    'label' => __('Added Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .images div.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
                         {{WRAPPER}} .lookbook-inner .repeater-item .product-item .content-product .images div.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'section_lookbook_style' => ['style1'],
                    ],

                ]
            );

            $this->end_controls_section();
        }

        protected function get_products_group_id()
        {
            $results = [];
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );
            $products = get_posts($args);
            foreach ($products as $product) {
                if ((get_the_terms($product->ID, 'product_type')[0]->slug) === 'grouped') {
                    $results[$product->ID] = $product->post_title;
                }
            }
            return $results;
        }

        protected function get_products_group_children_id($children_id_product)
        {
            $results = [];
            $product_gr = wc_get_product($children_id_product)->get_children();
            foreach ($product_gr as $product) {
                $results[$product] = get_the_title($product);
            }
            return $results;
        }

        protected function get_products_id()
        {
            $results = [];
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );
            $products = get_posts($args);
            foreach ($products as $product) {
                $results[$product->ID] = $product->post_title;
            }
            return $results;
        }

        protected function render()
        {
            $settings = $this->get_settings_for_display();
            $lookbook_layout = $settings['section_lookbook_style'];
            $hide_cart = $settings['hide_add_to_cart'];
            $show_custom_image = $settings['show_custom_image'];
            $custom_dimension = $settings['custom_dimension_image'];
            if (empty($settings['lookbook_repeater'])) {
                return;
            }
            $lookbook_id = wp_rand();
            /* Import Css */
            if (is_rtl()) {
                wp_enqueue_style('apr-sc-lookbook', WP_PLUGIN_URL . '/arrowpress-core/assets/css/lookbook-rtl.css', array());
            } else {
                wp_enqueue_style('apr-sc-lookbook', WP_PLUGIN_URL . '/arrowpress-core/assets/css/lookbook.css', array());
            }
            add_action('wp_enqueue_scripts', [$this, 'apr-sc-lookbook']);

            ?>
            <div class="lookbook-inner lookbook-inner-<?php echo $lookbook_id; ?>">

                <?php
                if ($lookbook_layout === 'style1'):
                    echo Group_Control_Image_Size::get_attachment_image_html($settings, 'lookbook_image_size', 'lookbook_image');
                endif;
                ?>

                <?php
                if ($lookbook_layout === 'style2'):
                    if ($show_custom_image === 'yes') {
                        $has_custom_size = false;
                        if (!empty($custom_dimension['width'])) {
                            $has_custom_size = true;
                            $attachment_size[0] = $custom_dimension['width'];
                        }

                        if (!empty($custom_dimension['height'])) {
                            $has_custom_size = true;
                            $attachment_size[1] = $custom_dimension['height'];
                        }

                        if (!$has_custom_size) {
                            $attachment_size = 'full';
                        }
                    } else {
                        $attachment_size = 'full';
                    }
                    $full_image_size = get_the_post_thumbnail_url($settings['id_product_parent'], 'full');
                    $args = array(
                        'url' => $full_image_size,
                        'width' => $attachment_size[0],
                        'height' => $attachment_size[1],
                        'crop' => true,
                        'single' => true,
                        'upscale' => false,
                        'echo' => false,
                    );
                    $image_product = aq_resize($args['url'], $args['width'], $args['height'], $args['crop'], $args['single'], $args['upscale']);
                    if ($image_product === false) {
                        $image_product = $args['url'];
                    }
                    ?>
                    <img src="<?php echo esc_url($image_product); ?>"
                         alt="<?php get_the_title($settings['id_product_parent']); ?>"
                         height="<?php echo $attachment_size[1]; ?>" width="<?php echo $attachment_size[0]; ?>"/>

                <?php
                endif;
                foreach ($settings['lookbook_repeater'] as $key => $lookbook) :
                    $product = wc_get_product($lookbook['id_product']);
                    $lookbook_id_poppup = wp_rand();
                    ?>
                    <div class="repeater-item elementor-repeater-item-<?php echo $lookbook['_id']; ?>">
                        <div class="product-item">
                            <div class="product-tooltip">
                                <span class="theme-icon-tag-icon"></span>
                            </div>
                            <?php if ($product): ?>
                                <div class="content-product <?php echo $lookbook['position_content']; ?>"
                                     id="content-product-<?php echo $lookbook_id_poppup; ?>">
                                    <div class="images">
                                        <a href="<?php echo get_permalink($lookbook['id_product']); ?>">
                                            <?php
                                            $full_image_size = get_the_post_thumbnail_url($lookbook['id_product'], 'full');
                                            $args = array(
                                                'url' => $full_image_size,
                                                'width' => 290,
                                                'height' => 390,
                                                'crop' => true,
                                                'single' => true,
                                                'upscale' => false,
                                                'echo' => false,
                                            );
                                            $image = aq_resize($args['url'], $args['width'], $args['height'], $args['crop'], $args['single'], $args['upscale']);
                                            if ($image === false) {
                                                $image = $args['url'];
                                            }
                                            ?>
                                            <img src="<?php echo esc_url($image); ?>"
                                                 alt="<?php echo get_the_title($lookbook['id_product']); ?>"
                                                 height="<?php echo $args['height']; ?>"
                                                 width="<?php echo $args['width']; ?>"/>
                                        </a>
                                        <?php
                                        if (class_exists('YITH_WCWL') && $lookbook_layout === 'style1'):
                                            echo(do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $lookbook['id_product'] . '"]'));
                                        endif;
                                        ?>
                                    </div>
                                    <div class="title-price">
                                        <h3 class="title">
                                            <a href="<?php echo get_permalink($lookbook['id_product']); ?>">
                                                <?php
                                                $tit = get_the_title($lookbook['id_product']);
                                                echo substr($tit, 0, 45);
                                                if (strlen($tit) > 45) echo esc_html__('...', 'lusion');
                                                ?>

                                            </a>
                                        </h3>
                                        <span class="price"><?php echo $product->get_price_html(); ?></span>
                                        <?php
                                        if ($hide_cart !== 'yes'):
                                            echo(do_shortcode('[add_to_cart show_price="false" id="' . $lookbook['id_product'] . '"]'));
                                        endif;
                                        ?>
                                    </div>
                                    <span class="triangular-arrows <?php echo $lookbook['position_content']; ?>"></span>
                                </div>
                                <a data-fancybox data-width="500" data-height="700"
                                   href="#content-product-<?php echo $lookbook_id_poppup; ?>"
                                   class="poppup-lookbook"><?php echo esc_html__('Poppup', 'apr-core'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($lookbook_layout === 'style2'): ?>
            <div class="contnet-product-group">
                <h3 class="title"><a href="<?php echo get_permalink($settings['id_product_parent']); ?>">
                        <?php echo get_the_title($settings['id_product_parent']); ?>
                    </a></h3>
                <div class="button-get-outfit"><a href="<?php echo get_permalink($settings['id_product_parent']); ?>">
                        <?php echo esc_html__('Get the outfit now', 'apr-core'); ?> <i class="fas fa-play"></i></a>
                </div>
                <?php
                if (class_exists('YITH_WCWL')):
                    echo(do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $settings['id_product_parent'] . '"]'));
                endif;
                ?>
            </div>
        <?php endif; ?>

            <script>
                jQuery(document).ready(function ($) {
                    $('.lookbook-inner-<?php echo $lookbook_id ?> .product-item').mouseover(function () {
                        var lookbook_inner_width = $('.lookbook-inner-<?php echo $lookbook_id ?>').width();
                        var lookbookinner = $('.lookbook-inner-<?php echo $lookbook_id ?> .product-item').width();
                        var lookbookWidth = $(this).children('.content-product').width();
                        var offsetLookbookInner = $('.lookbook-inner-<?php echo $lookbook_id ?>').offset().left;
                        var offsetProductItem = $(this).offset().left;
                        var widthcontentproducthalf = (lookbookWidth / 2 - lookbookinner / 2) + 15;
                        if (widthcontentproducthalf >= (offsetProductItem - offsetLookbookInner)) {
                            var widthcontentproducthalf_left = widthcontentproducthalf - (offsetProductItem - offsetLookbookInner);
                            $(this).children('.content-product:not(.right):not(.left)').css({
                                'left': 'calc(50% + ' + widthcontentproducthalf_left + 'px',
                                'transform-origin': +(widthcontentproducthalf_left * (-1)) + 'px 100%'
                            });
                            $(this).children('.content-product:not(.right):not(.left)').children('.triangular-arrows').css('left', 'calc(50% - ' + widthcontentproducthalf_left + 'px');
                        } else {
                            var widthRight = (offsetLookbookInner + lookbook_inner_width) - (offsetProductItem + lookbookinner);
                            if (widthcontentproducthalf >= widthRight) {
                                var widthcontentproducthalf_right = widthcontentproducthalf - widthRight;
                                $(this).children('.content-product:not(.right):not(.left)').css({
                                    'left': 'calc(50% - ' + widthcontentproducthalf_right + 'px',
                                    'transform-origin': +widthcontentproducthalf_right + 'px 100%'
                                });
                                $(this).children('.content-product:not(.right):not(.left)').children('.triangular-arrows').css('left', 'calc(50% + ' + widthcontentproducthalf_right + 'px');
                            } else {
                                $(this).children('.content-product').removeAttr('style');
                                $(this).children('.content-product').children('.triangular-arrows').removeAttr('style');
                            }
                        }
                    });
                });
            </script>
            <?php
        }
    }

    Plugin::instance()->widgets_manager->register_widget_type(new Apr_Core_Lookbook);
}