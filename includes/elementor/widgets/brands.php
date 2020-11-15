<?php

namespace Elementor;
if (!defined('ABSPATH')) exit;
if (class_exists('YITH_WCBR')) {
    class Apr_Core_Brands extends Widget_Base
    {
        public function get_categories()
        {
            return array('apr-core');
        }

        public function get_name()
        {
            return 'apr_brands';
        }

        public function get_title()
        {
            return __('APR Brands', 'apr-core');
        }

        public function get_icon()
        {
            return 'eicon-logo';
        }

        protected function _register_controls()
        {
            $this->start_controls_section(
                'section_brands',
                [
                    'label' => __('Brands', 'apr-core'),
                ]
            );
            $this->add_control(
                'brand_select_cat',
                [
                    'label'         =>  __( 'Select brands', 'apr-core' ),
                    'type'          =>  Controls_Manager::SELECT2,
                    'options'       =>  apr_core_check_get_cat( 'yith_product_brand' ),
                    'multiple'      =>  true,
                    'label_block'   =>  true,
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
                ]
            );
            $this->add_control(
                'custom_dimension',
                [
                    'label' => __('Image Size', 'apr-core'),
                    'type' => Controls_Manager::IMAGE_DIMENSIONS,
                    'description' => __('You can crop the original image size to any custom size. You can also set a single value for width in order to keep the original size ratio.', 'apr-core'),
                    'condition' => [
                        'show_custom_image' => 'yes',
                    ],
                ]
            );

            $this->add_responsive_control(
                'slidestoshow',
                [
                    'label' => __('Slides To Show', 'apr-core'),
                    'type' => Controls_Manager::NUMBER,
                    'devices' => ['desktop', 'tablet', 'mobile'],
                    'desktop_default' => '6',
                    'tablet_default' => '4',
                    'mobile_default' => '2',
                ]
            );

            $this->add_control(
                'slidestoshow_desktop',
                [
                    'label' => __('Slides To Show', 'apr-core'),
                    'description' => __('1025px < Set how many item for screen < 1400px.', 'apr-core'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '4',
                ]
            );

            $this->add_responsive_control(
                'slidestoscroll',
                [
                    'label' => __('Slides To Scroll', 'apr-core'),
                    'type' => Controls_Manager::NUMBER,
                    'devices' => ['desktop', 'tablet', 'mobile'],
                    'desktop_default' => '2',
                    'tablet_default' => '2',
                    'mobile_default' => '2',
                ]
            );

            $this->add_responsive_control(
                'slidesrow',
                [
                    'label' => __('Row', 'apr-core'),
                    'type' => Controls_Manager::NUMBER,
                    'devices' => ['desktop', 'tablet', 'mobile'],
                    'desktop_default' => '1',
                    'tablet_default' => '1',
                    'mobile_default' => '1',
                ]
            );

            $this->add_control(
                'navigation',
                [
                    'label' => __('Navigation', 'apr-core'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'arrows',
                    'options' => [
                        'both' => __('Arrows and Dots', 'apr-core'),
                        'arrows' => __('Arrows', 'apr-core'),
                        'dots' => __('Dots', 'apr-core'),
                        'none' => __('None', 'apr-core'),
                    ],
                ]
            );
            $this->add_control(
                'transition_speed',
                [
                    'label' => __('Transition Speed (ms)', 'apr-core'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 500,
                ]
            );

            $this->add_control(
                'centermode',
                [
                    'label' => __('Center Mode', 'apr-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'condition' => [
                        'variablewidth!' => 'yes',
                    ],
                ]
            );

            $this->add_responsive_control(
                'centerpadding',
                [
                    'label' => __('Center Padding', 'apr-core'),
                    'type' => Controls_Manager::NUMBER,
                    'devices' => ['desktop', 'tablet', 'mobile'],
                    'desktop_default' => '60',
                    'tablet_default' => '30',
                    'mobile_default' => '10',
                    'condition' => [
                        'centermode' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'variablewidth',
                [
                    'label' => __('Variable Width', 'apr-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'condition' => [
                        'centermode!' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'autoplay',
                [
                    'label' => __('Autoplay', 'apr-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                ]
            );

            $this->add_control(
                'autoplay_speed',
                [
                    'label' => __('Autoplay Speed', 'apr-core'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 5000,
                    'condition' => [
                        'autoplay' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'infinite',
                [
                    'label' => __('Infinite Loop', 'apr-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'pause_on_hover',
                [
                    'label' => __('Pause on Hover', 'apr-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );

            $this->end_controls_section();

            //style
            $this->start_controls_section(
                'content_brands',
                [
                    'label' => esc_html__('Content', 'apr-core'),
                    'tab' => Controls_Manager::TAB_STYLE
                ]
            );

            $this->add_control(
                'box_content_style',
                [
                    'label' => __('Box Content', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'content_padding',
                [
                    'label' => esc_html__('Content Padding', 'apr-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .brands-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'content_margin',
                [
                    'label' => esc_html__('Content Margin', 'apr-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .brands-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'content_border',
                    'label' => esc_html__('Border', 'apr-core'),
                    'selector' => '{{WRAPPER}} .main-brands .brands-content',
                ]
            );

            $this->add_control(
                'border_last_size',
                [
                    'label' => __( 'Border Fist And Last Size', 'apr-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .slick-list:before,
                         {{WRAPPER}} .main-brands .slick-list:after' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'border_last_color',
                [
                    'label' => __('Border Last Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .slick-list:before,
                         {{WRAPPER}} .main-brands .slick-list:after' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            //text content

            $this->add_control(
                'text_content_style',
                [
                    'label' => __('Text Content', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'text_content_padding',
                [
                    'label' => esc_html__('Padding', 'apr-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .brands-content .info-brands' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'text_content_margin',
                [
                    'label' => esc_html__('Margin', 'apr-core'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .brands-content .info-brands' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


            //title
            $this->add_control(
                'title_style',
                [
                    'label' => __('Title', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .main-brands .brands-content .info-brands h3 a',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .brands-content .info-brands h3 a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'title_color_hover',
                [
                    'label' => __('Color Hover', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .brands-content .info-brands h3 a:hover' => 'color: {{VALUE}};',
                    ],
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
                        '{{WRAPPER}} .main-brands .brands-content .info-brands h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            //cvcv
            $this->add_control(
                'number_style',
                [
                    'label' => __('Quantity', 'apr-core'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'number_typography',
                    'selector' => '{{WRAPPER}} .main-brands .brands-content .info-brands span',
                ]
            );

            $this->add_control(
                'number_color',
                [
                    'label' => __('Color', 'apr-core'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .main-brands .brands-content .info-brands span' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'number_spacing_parent',
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
                        '{{WRAPPER}} .main-brands .brands-content .info-brands span' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render()
        {
            /* Import Css */
            if (is_rtl()) {
                wp_enqueue_style('apr-sc-brand', WP_PLUGIN_URL . '/arrowpress-core/assets/css/brand-rtl.css', array());
            } else {
                wp_enqueue_style('apr-sc-brand', WP_PLUGIN_URL . '/arrowpress-core/assets/css/brand.css', array());
            }
            add_action('wp_enqueue_scripts', [$this, 'apr-sc-brand']);

            $settings = $this->get_settings_for_display();
            $id = 'apr_brand_' . wp_rand();
            $is_rtl = is_rtl();
            $direction = $is_rtl ? 'true' : 'false';
            $show_arr = 'false';
            $show_dot = 'false';
            $select_brand = $settings['brand_select_cat'];
            $show_custom_image = $settings['show_custom_image'];
            $custom_dimension = $settings['custom_dimension'];
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
            }
            if ($settings['navigation'] == 'both') {
                $show_arr = 'true';
                $show_dot = 'true';
            } elseif ($settings['navigation'] == 'arrows') {
                $show_arr = 'true';
            } elseif ($settings['navigation'] == 'dots') {
                $show_dot = 'true';
            }
            if ($settings['centermode'] == 'yes') {
                $centermode = 'true';
            } else {
                $centermode = 'false';
            }
            if ($settings['autoplay'] == 'yes') {
                $autoplay = 'true';
            } else {
                $autoplay = 'false';
            }
            if ($settings['variablewidth'] == 'yes') {
                $variablewidth = 'true';
            } else {
                $variablewidth = 'false';
            }
            if ($settings['infinite'] == 'yes') {
                $infinite = 'true';
            } else {
                $infinite = 'false';
            }
            if ($settings['pause_on_hover'] == 'yes') {
                $pauseonhover = 'true';
            } else {
                $pauseonhover = 'false';
            }
            ?>
            <div class="main-brands" id="<?php echo esc_attr($id); ?>">
                <?php
                $args = array();
                $brands = get_terms('yith_product_brand', $args);
                if (is_array($brands) || is_object($brands)) {
                    foreach ($brands as $_brand) {
                        if(in_array($_brand->slug, $select_brand) || empty($select_brand)){
                            $thumbnail_id = get_term_meta($_brand->term_id, 'thumbnail_id', true);
                            $_brand->brand_url = get_term_link($_brand->slug, 'yith_product_brand');
                            $image = wp_get_attachment_image_src($thumbnail_id, 'full');
                            $size_wh['width'] = $size_wh['height'] = 'full';
                            if ($image) {
                                $url_image = $image[0];
                            } else {
                                $url_image = wc_placeholder_img_src('full');
                            }
                            if ($show_custom_image === 'yes') {
                                $results_returned = lusion_crop_images_custom($url_image,$custom_dimension);
                                $url_image=$results_returned['url_img'];
                                $size_wh['width']=$results_returned['width_height']['width'];
                                $size_wh['height']=$results_returned['width_height']['height'];
                            }
                        ?>
                        <div class="brands-content">
                            <div class="brands-img">
                                <a href="<?php echo get_term_link($_brand); ?>">
                                    <img src="<?php echo $url_image; ?>" alt="<?php echo $_brand->name; ?>"
                                         width="<?php echo $size_wh['width']; ?>"
                                         height="<?php echo $size_wh['height']; ?>">
                                </a>
                            </div>
                            <div class="info-brands">
                                <h3><a href="<?php echo get_term_link($_brand); ?>"><?php echo $_brand->name; ?></a>
                                </h3>
                                <span><?php
                                    if ($_brand->count <= 1) {
                                        echo $_brand->count . esc_html__(' item', 'apr-core');
                                    } else {
                                        echo $_brand->count . esc_html__(' items', 'apr-core');
                                    }
                                    ?></span>
                                <div class="arrowAnim">
                                    <div class="arrowSliding delay1"><i class="theme-icon-download"></i></div>
                                    <div class="arrowSliding delay2"><i class="theme-icon-download"></i></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                }
                ?>
            </div>
            <script>
                jQuery(document).ready(function ($) {
                    $('#<?php echo esc_js($id);?>').slick({
                        slidesToShow: <?php echo absint($settings['slidestoshow']);?>,
                        slidesToScroll: <?php echo absint($settings['slidestoscroll']);?>,
                        rows: <?php echo absint($settings['slidesrow']);?>,
                        dots: <?php echo esc_attr($show_dot);?>,
                        arrows: <?php echo esc_attr($show_arr);?>,
                        nextArrow: '<button class="slick-next"><i class="theme-icon-right-arrow"></i></button>',
                        prevArrow: '<button class="slick-prev"><i class="theme-icon-left-arrow"></i></button>',
                        speed: <?php echo absint($settings['transition_speed']);?>,
                        autoplay: <?php echo esc_attr($autoplay);?>,
                        autoplaySpeed: <?php echo absint($settings['autoplay_speed']);?>,
                        infinite: <?php echo esc_attr($infinite);?>,
                        rtl: <?php echo esc_attr($direction);?>,
                        centerMode: <?php echo esc_attr($centermode);?>,
                        centerPadding: '<?php echo absint($settings["centerpadding"]);?>px',
                        pauseOnHover: <?php echo esc_attr($pauseonhover);?>,
                        variableWidth: <?php echo esc_attr($variablewidth);?>,
                        responsive: [
                            {
                                breakpoint: 1400,
                                settings: {
                                    slidesToShow: <?php echo absint($settings['slidestoshow_desktop']);?>,
                                }
                            },
                            {
                                breakpoint: 1025,
                                settings: {
                                    slidesToShow: <?php echo absint($settings['slidestoshow_tablet']);?>,
                                    slidesToScroll: <?php echo absint($settings['slidestoscroll_tablet']);?>,
                                    rows: <?php echo absint($settings['slidesrow_tablet']);?>,
                                    centerPadding: '<?php echo absint($settings["centerpadding_tablet"]);?>px',
                                }
                            },
                            {
                                breakpoint: 767.2,
                                settings: {
                                    slidesToShow: <?php echo absint($settings['slidestoshow_mobile']);?>,
                                    slidesToScroll: <?php echo absint($settings['slidestoscroll_mobile']);?>,
                                    rows: <?php echo absint($settings['slidesrow_mobile']);?>,
                                    centerPadding: '<?php echo absint($settings["centerpadding_mobile"]);?>px',
                                }
                            },
                        ]
                    });

                    var slick_slider = $('#<?php echo esc_attr($id); ?>.slick-slider');
                    $( ".slick-slide:not(.slick-active)" ).removeClass('is-slick-active');
                    slick_slider.find('.slick-active').last().addClass('is-slick-active');
                    slick_slider.on('beforeChange', function(event, slick, currentSlide, nextSlide){
                        $(this).find('.slick-active').removeClass('is-slick-active');
                    });
                    slick_slider.on('afterChange', function(event, slick, currentSlide, nextSlide){
                        $(this).find('.slick-active').last().addClass('is-slick-active');
                    });
                });
            </script>
        <?php }

        protected function content_template()
        {
        }

    }

    Plugin::instance()->widgets_manager->register_widget_type(new Apr_Core_Brands);
}