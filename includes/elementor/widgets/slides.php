<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Repeater;
if ( ! defined( 'ABSPATH' ) ) exit;
class Apr_Core_Slides extends Widget_Base {
    public function get_name() {
        return 'apr-slides';
    }
    public function get_categories() {
        return array( 'apr-core' );
    }
    public function get_script_depends() {
        return [ 'jquery-slick' ];
    }
    public function get_title() {
        return __( ' APR Slides', 'apr-core' );
    }
    public function get_icon() {
        return 'eicon-slideshow';
    }
    public static function get_button_sizes() {
        return [
            'xs' => __( 'Extra Small', 'apr-core' ),
            'sm' => __( 'Small', 'apr-core' ),
            'md' => __( 'Medium', 'apr-core' ),
            'lg' => __( 'Large', 'apr-core' ),
            'xl' => __( 'Extra Large', 'apr-core' ),
        ];
    }
    public static function get_animation_options() {
        return [
            ''              => __( 'None', 'apr-core' ),
            'fadeInDown'    => __( 'FadeInDown', 'apr-core' ),
            'fadeInUp'      => __( 'FadeInUp', 'apr-core' ),
            'fadeInRight'   => __( 'FadeInRight', 'apr-core' ),
            'fadeInLeft'    => __( 'FadeInLeft', 'apr-core' ),
            'fadeInDownBig'    => __( 'FadeInDownBig', 'apr-core' ),
            'fadeInLeftBig'    => __( 'FadeInLeftBig', 'apr-core' ),
            'fadeInRightBig'   => __( 'FadeInRightBig', 'apr-core' ),
            'fadeInUpBig'      => __( 'FadeInUpBig', 'apr-core' ),
            'lightSpeedIn'     => __( 'LightSpeedIn', 'apr-core' ),
            'lightSpeedOut'    => __( 'LightSpeedOut', 'apr-core' ),
            'zoomIn'           => __( 'Zoom', 'apr-core' ),
            'zoomInDown'       => __( 'ZoomInDown', 'apr-core' ),
            'zoomInLeft'       => __( 'ZoomInLeft', 'apr-core' ),
            'zoomInRight'      => __( 'ZoomInRight', 'apr-core' ),
            'zoomInUp'         => __( 'ZoomInUp', 'apr-core' ),
            'pulse'         => __( 'Pulse', 'apr-core'),
            'bounceIn'      => __( 'BounceIn', 'apr-core'),
            'bounceInDown'  => __( 'BounceInDown', 'apr-core'),
            'bounceInLeft'  => __( 'BounceInLeft', 'apr-core'),
            'bounceInRight' => __( 'BounceInRight', 'apr-core'),
            'bounceInUp'    => __( 'BounceInUp', 'apr-core'),
            'rotateIn'      => __( 'RotateIn', 'apr-core'),
            'rotateInDownLeft'      => __( 'RotateInDownLeft', 'apr-core'),
            'rotateInDownRight'     => __( 'RotateInDownRight', 'apr-core'),
            'rotateInUpLeft'        => __( 'RotateInUpLeft', 'apr-core'),
            'rotateInUpRight'       => __( 'RotateInUpRight', 'apr-core'),
            'slideInUp'             => __( 'SlideInUp', 'apr-core'),
            'slideInDown'           => __( 'SlideInDown', 'apr-core'),
            'slideInLeft'           => __( 'SlideInLeft', 'apr-core'),
            'slideInRight'          => __( 'SlideInRight', 'apr-core'),
            'JackInTheBox'          => __( 'JackInTheBox', 'apr-core'),
        ];
    }
    protected function _register_controls() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => __( 'Slides', 'apr-core' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs( 'slides_repeater' );

        $repeater->start_controls_tab( 'background', [ 'label' => __( 'Background', 'apr-core' ) ] );
        $repeater->add_responsive_control(
            'content_max_width',
            [
                'label' => __( 'Content Width', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ '%', 'px' ],
                'default' => [
                    'size' => '66',
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .elementor-slide-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'background_color',
            [
                'label' => __( 'Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#bbbbbb',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-bg' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_control(
            'background_image',
            [
                'label' => _x( 'Image', 'Background Control', 'apr-core' ),
                'type' => Controls_Manager::MEDIA,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-bg' => 'background-image: url({{URL}})',
                ],
            ]
        );

        $repeater->add_control(
            'background_size',
            [
                'label' => _x( 'Size', 'Background Control', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => _x( 'Cover', 'Background Control', 'apr-core' ),
                    'contain' => _x( 'Contain', 'Background Control', 'apr-core' ),
                    'auto' => _x( 'Auto', 'Background Control', 'apr-core' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-bg' => 'background-size: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'background_image[url]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'background_ken_burns',
            [
                'label' => __( 'Ken Burns Effect', 'apr-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'separator' => 'before',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'background_image[url]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'zoom_direction',
            [
                'label' => __( 'Zoom Direction', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'in',
                'options' => [
                    'in' => __( 'In', 'apr-core' ),
                    'out' => __( 'Out', 'apr-core' ),
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'background_ken_burns',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'background_overlay',
            [
                'label' => __( 'Background Overlay', 'apr-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'separator' => 'before',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'background_image[url]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'background_overlay_color',
            [
                'label' => __( 'Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'background_overlay',
                            'value' => 'yes',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-background-overlay' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'apr-core' ) ] );
        $repeater->add_control(
            'before_heading',
            [
                'label' => __( 'Before Title', 'apr-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Find Any', 'apr-core' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'heading',
            [
                'label' => __( 'Title', 'apr-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Medicine', 'apr-core' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'after_heading',
            [
                'label' => __( 'After Title', 'apr-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'You Needs!', 'apr-core' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'animation_heading',
            [
                'label' => __( 'Heading Animation', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fadeInUp',
                'options' => self::get_animation_options(),
            ]
        );
        $repeater->add_control(
            'transition_delay_heading',
            [
                'label' => __( 'Transition Delay For Heading (ms)', 'apr-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __( 'Description', 'apr-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'apr-core' ),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'animation_descr',
            [
                'label' => __( 'Description Animation', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fadeInUp',
                'options' => self::get_animation_options(),
            ]
        );

        $repeater->add_control(
            'transition_delay_description',
            [
                'label' => __( 'Transition Delay For Description (ms)', 'apr-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'apr-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Click here', 'apr-core')
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Link', 'apr-core' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'apr-core' ),
            ]
        );

        $repeater->add_control(
            'link_click',
            [
                'label' => __( 'Apply Link On', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'slide' => __( 'Whole Slide', 'apr-core' ),
                    'button' => __( 'Button Only', 'apr-core' ),
                ],
                'default' => 'slide',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'link[url]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'animation_button',
            [
                'label' => __( 'Button Animation', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fadeInUp',
                'options' => self::get_animation_options(),
            ]
        );

         $repeater->add_control(
            'transition_delay_button',
            [
                'label' => __( 'Transition Delay for button (ms)', 'apr-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'apr-core' ) ] );

        $repeater->add_control(
            'custom_style',
            [
                'label' => __( 'Custom', 'apr-core' ),
                'type' => Controls_Manager::SWITCHER,
                'description' => __( 'Set custom style that will only affect this specific slide.', 'apr-core' ),
            ]
        );

        $repeater->add_control(
            'horizontal_position',
            [
                'label' => __( 'Horizontal Position', 'apr-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'apr-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'apr-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'apr-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-content' => '{{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'left' => 'margin-right: auto',
                    'center' => 'margin: 0 auto',
                    'right' => 'margin-left: auto',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'vertical_position',
            [
                'label' => __( 'Vertical Position', 'apr-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'top' => [
                        'title' => __( 'Top', 'apr-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => __( 'Middle', 'apr-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => __( 'Bottom', 'apr-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner' => 'align-items: {{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'top' => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'text_align',
            [
                'label' => __( 'Text Align', 'apr-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'apr-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'apr-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'apr-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner' => 'text-align: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'content_color',
            [
                'label' => __( 'Content Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-heading' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-description' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slick-slide-inner .elementor-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'custom_style',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'slides',
            [
                'label' => __( 'Slides', 'apr-core' ),
                'type' => Controls_Manager::REPEATER,
                'show_label' => true,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'heading' => __( 'Medicine', 'apr-core' ),
                        'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'apr-core' ),
                        'button_text' => __( 'Click Here', 'apr-core' ),
                        'background_color' => '#833ca3',
                        'before_heading' => __( 'Before Heading', 'apr-core'),
                        'after_heading' => __( 'After Heading', 'apr-core'),
                        'animation_heading' => __( 'zoomIn', 'apr-core' ),
                        'animation_descr' => __( 'zoomIn', 'apr-core' ),
                        'animation_button' => __( 'zoomIn', 'apr-core' ),
                        'transition_delay_heading' => __( '500', 'apr-core'),
                        'transition_delay_description' => __( '500', 'apr-core'),
                        'transition_delay_button' => __( '500', 'apr-core'),
                    ],
                    [
                        'heading' => __( 'Slide 2 Heading', 'apr-core' ),
                        'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'apr-core' ),
                        'button_text' => __( 'Click Here', 'apr-core' ),
                        'background_color' => '#4054b2',
                        'before_heading' => __( 'Before Heading', 'apr-core'),
                        'after_heading' => __( 'After Heading', 'apr-core'),
                        'animation_heading' => __( 'zoomIn', 'apr-core' ),
                        'animation_descr' => __( 'zoomIn', 'apr-core' ),
                        'animation_button' => __( 'zoomIn', 'apr-core' ),
                        'transition_delay_heading' => __( '500', 'apr-core'),
                        'transition_delay_description' => __( '500', 'apr-core'),
                        'transition_delay_button' => __( '500', 'apr-core'),
                    ],
                    [
                        'heading' => __( 'Slide 3 Heading', 'apr-core' ),
                        'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'apr-core' ),
                        'button_text' => __( 'Click Here', 'apr-core' ),
                        'background_color' => '#1abc9c',
                        'before_heading' => __( 'Before Heading', 'apr-core'),
                        'after_heading' => __( 'After Heading', 'apr-core'),
                        'animation_heading' => __( 'zoomIn', 'apr-core' ),
                        'animation_descr' => __( 'zoomIn', 'apr-core' ),
                        'animation_button' => __( 'zoomIn', 'apr-core' ),
                        'transition_delay_heading' => __( '500', 'apr-core'),
                        'transition_delay_description' => __( '500', 'apr-core'),
                        'transition_delay_button' => __( '500', 'apr-core'),
                    ],
                ],
                'title_field' => '{{{ heading }}}',
            ]
        );

        $this->add_responsive_control(
            'slides_height',
            [
                'label' => __( 'Height', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 400,
                ],
                'size_units' => [ 'px', 'vh', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_options',
            [
                'label' => __( 'Slider Options', 'apr-core' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => __( 'Navigation', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
                    'both' => __( 'Arrows and Dots', 'apr-core' ),
                    'arrows' => __( 'Arrows', 'apr-core' ),
                    'dots' => __( 'Dots', 'apr-core' ),
                    'none' => __( 'None', 'apr-core' ),
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __( 'Pause on Hover', 'apr-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __( 'Autoplay', 'apr-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __( 'Autoplay Speed', 'apr-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => __( 'Infinite Loop', 'apr-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'transition',
            [
                'label' => __( 'Transition', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __( 'Slide', 'apr-core' ),
                    'fade' => __( 'Fade', 'apr-core' ),
                ],
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label' => __( 'Transition Speed (ms)', 'apr-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_slides',
            [
                'label' => __( 'Slides', 'apr-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_layout',
            [
                'label' => __( 'Content Layout', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'container',
                'options' => [
                    'container' => __( 'Container', 'apr-core'),
                    'container-fluid' => __( 'Container Fluid', 'apr-core'),
                ],
            ]
        );


        $this->add_responsive_control(
            'slides_padding',
            [
                'label' => __( 'Padding', 'apr-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slides_horizontal_position',
            [
                'label' => __( 'Horizontal Position', 'apr-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'apr-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'apr-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'apr-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor--h-position-',
            ]
        );

        $this->add_control(
            'slides_vertical_position',
            [
                'label' => __( 'Vertical Position', 'apr-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'middle',
                'options' => [
                    'top' => [
                        'title' => __( 'Top', 'apr-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => __( 'Middle', 'apr-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => __( 'Bottom', 'apr-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor--v-position-',
            ]
        );

        $this->add_control(
            'slides_text_align',
            [
                'label' => __( 'Text Align', 'apr-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'apr-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'apr-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'apr-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-inner' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Title', 'apr-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_spacing',
            [
                'label' => __( 'Spacing', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-inner .elementor-slide-heading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'special_heading_color',
            [
                'label' => __( 'Text Color For Special Heading', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-heading .heading' => 'color: {{VALUE}}',

                ],
            ]
        );
        $this->add_control(
            'heading_color',
            [
                'label' => __( 'Text Color For Overal Heading', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-heading' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-slide-heading',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => 'Typography for special heading',
                'name' => 'special_heading_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-slide-heading .heading',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => __( 'Description', 'apr-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'description_spacing',
            [
                'label' => __( 'Spacing', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-inner .elementor-slide-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Text Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-description' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-slide-description',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __( 'Button', 'apr-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => __( 'Size', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'sm',
                'options' => self::get_button_sizes(),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-slide-button',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
            ]
        );
        $this->add_responsive_control(
            'header_padding',
            [
                'label'     => __( 'Padding', 'apr-core' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_width',
            [
                'label' => __( 'Border Width', 'apr-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'border-top-width: {{TOP}}{{UNIT}}; border-right-width:{{RIGHT}}{{UNIT}};  border-bottom-width:{{BOTTOM}}{{UNIT}}; border-left-width:{{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __( 'Border Radius', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->start_controls_tabs( 'button_tabs' );

        $this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'apr-core' ) ] );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Button Text Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Background Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => __( 'Border Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'apr-core' ) ] );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => __( 'Text Hover Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => __( 'Background Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slide-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __( 'Navigation', 'apr-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation' => [ 'arrows', 'dots', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'heading_style_arrows',
            [
                'label' => __( 'Arrows', 'apr-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_position',
            [
                'label' => __( 'Arrows Position', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => [
                    'inside' => __( 'Inside', 'apr-core' ),
                    'outside' => __( 'Outside', 'apr-core' ),
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_size',
            [
                'label' => __( 'Arrows Size', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '.elementor-slick-slider.slide .slick-next:before, .elementor-slick-slider.slide .slick-prev:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => __( 'Arrows Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => 
                ['.elementor-slick-slider.slide .slick-next:before, .elementor-slick-slider.slide .slick-prev:before' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'navigation' => [ 'arrows', 'both' ],
            ],
        ]
    );

        $this->add_control(
            'heading_style_dots',
            [
                'label' => __( 'Dots', 'apr-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' => __( 'Dots Position', 'apr-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => [
                    'outside' => __( 'Outside', 'apr-core' ),
                    'inside' => __( 'Inside', 'apr-core' ),
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'dots_width',
            [
                'label' => __( 'Dots Width', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 3,
                        'max' => 15,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slides-wrapper .elementor-slides .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );
        $this->add_control(
            'dots_height',
            [
                'label' => __( 'Dots Height', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 3,
                        'max' => 15,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slides-wrapper .elementor-slides .slick-dots li button:before' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'dots_border_radius',
            [
                'label' => __( 'Dots Radius', 'apr-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-slides-wrapper .elementor-slides .slick-dots li button:before' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => __( 'Dots Color', 'apr-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-slides-wrapper .elementor-slides .slick-dots li button:before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );

        $this->end_controls_section();
    }
    /**
     * Render slides widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings();

        if ( empty( $settings['slides'] ) ) {
            return;
        }

        $this->add_render_attribute( 'button', 'class', [ 'elementor-button', 'elementor-slide-button' ] );

        if ( ! empty( $settings['button_size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
        }

        $slides = [];
        $slide_count = 0;
        foreach ( $settings['slides'] as $slide ) {
            $slide_html = $slide_attributes = $btn_attributes = '';
            $btn_element = $slide_element = 'div';
            $slide_url = $slide['link']['url'];
            if ( ! empty( $slide_url ) ) {
                $this->add_render_attribute( 'slide_link' . $slide_count , 'href', $slide_url );

                if ( $slide['link']['is_external'] ) {
                    $this->add_render_attribute( 'slide_link' . $slide_count, 'target', '_blank' );
                }

                if ( 'button' === $slide['link_click'] ) {
                    $btn_element = 'a';
                    $btn_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
                } else {
                    $slide_element = 'a';
                    $slide_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
                }
            }

            if ( 'yes' === $slide['background_overlay'] ) {
                $slide_html .= '<div class="elementor-background-overlay"></div>';
            }

            $slide_html .= '<div class="elementor-slide-content"><div class="slider-content">';

            if ( $slide['heading'] ) {
                $slide_html .= '<div data-animation="'.$slide['animation_heading'].'" data-delay="'.$slide['transition_delay_heading'].'ms" class="elementor-slide-heading">'. $slide['before_heading'].' <span class="heading">' . $slide['heading'] .'</span> '. $slide['after_heading'] .'</div>';
            }

            if ( $slide['description'] ) {
                $slide_html .= '<div data-animation="'.$slide['animation_descr'].'" class="elementor-slide-description" data-delay="'.$slide['transition_delay_description'].'ms">' . $slide['description'] . '</div>';
            }

            if ( $slide['button_text'] ) {
                $slide_html .= '<' . $btn_element . ' ' . $btn_attributes . ' ' . $this->get_render_attribute_string( 'button' ) . ' data-animation="'.$slide['animation_button'].'" data-delay="'.$slide['transition_delay_button'].'ms">' . $slide['button_text'] . '</' . $btn_element . '>';
            }

            $ken_class = '';

            if ( '' != $slide['background_ken_burns'] ) {
                $ken_class = ' elementor-ken-' . $slide['zoom_direction'];
            }

            $slide_html .= '</div></div>';
            $slide_html = '<div class="slick-slide-bg' . $ken_class . '"></div><' . $slide_element . ' ' . $slide_attributes . ' class="slick-slide-inner '.esc_attr($settings['content_layout']).'">' . $slide_html . '</' . $slide_element . '>';
            $slides[] = '<div class="slide-animation elementor-repeater-item-' . $slide['_id'] . ' slick-slide">' . $slide_html . '</div>';
            $slide_count++;
        }

        $is_rtl = is_rtl();
        $direction = $is_rtl ? 'true' : 'false';
        $show_arr = 'false';
        $show_dot = 'false';
        if($settings['navigation'] == 'both'){
            $show_arr = 'true';
            $show_dot = 'true';
        }elseif($settings['navigation'] == 'arrows'){
            $show_arr = 'true';
        }elseif($settings['navigation'] == 'dots'){
            $show_dot = 'true';
        }
        $pause_on_hover= $autoplay = $infinite =  '';
        if($settings['pause_on_hover'] == 'yes'){
            $pause_on_hover = 'true';
        }else{
            $pause_on_hover = 'false';
        }
        if($settings['autoplay'] == 'yes'){
            $autoplay = 'true';
        }else{
            $autoplay = 'false';
        }
        if($settings['infinite'] == 'yes'){
            $infinite = 'true';
        }else{
            $infinite = 'false';
        }
        $slick_options = [
            'slidesToShow' => absint( 1 ),
            'autoplaySpeed' => absint( $settings['autoplay_speed'] ),
            'autoplay' => $autoplay,
            'infinite' => $infinite,
            'pauseOnHover' => $pause_on_hover,
            'speed' => absint( $settings['transition_speed'] ),
            'arrows' => $show_arr,
            'dots' => $show_dot,
            'rtl' => $direction,
        ];

        if ( $settings['transition'] == 'fade' ) {
            $slick_options['fade'] = 'true';
        } else {
            $slick_options['fade'] = 'false';
        }
        $carousel_classes = [ 'elementor-slides' ];

        if ( $show_arr ) {
            $carousel_classes[] = 'slick-arrows-' . $settings['arrows_position'];
        }

        if ( $show_dot ) {
            $carousel_classes[] = 'slick-dots-' . $settings['dots_position'];
        }

        $this->add_render_attribute( 'slides', [
            'class' => $carousel_classes,
        ] );
        $id =  'apr-slider-'.wp_rand();
		/* Import Css */
		if (is_rtl()) {
			wp_enqueue_style( 'apr-sc-slides', WP_PLUGIN_URL  . '/arrowpress-core/assets/css/slides-rtl.css', array());
		}else{
			wp_enqueue_style( 'apr-sc-slides', WP_PLUGIN_URL  . '/arrowpress-core/assets/css/slides.css', array());
		}
        add_action( 'wp_enqueue_scripts', [ $this, 'apr-sc-slides' ] );
        ?>
        <div id ="<?php echo esc_attr($id);?>" class="elementor-slides-wrapper elementor-slick-slider slide">
            <div class="elementor-background-overlay"></div>
            <div <?php echo $this->get_render_attribute_string( 'slides' ); ?>>
                <?php echo implode( '', $slides ); ?>
            </div>
        </div>
       <script>
            jQuery(document).ready(function($) {
                $('#<?php echo esc_js($id);?> .elementor-slides').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: <?php echo esc_attr($slick_options['autoplay']); ?>,
                    autoplaySpeed: <?php echo esc_attr($slick_options['autoplaySpeed']);?>,
                    arrows: <?php echo esc_attr($slick_options['arrows']); ?>,
                    dots: <?php echo esc_attr($slick_options['dots']); ?>,
                    rtl: <?php echo esc_attr($slick_options['rtl']);?>,
                    infinite: <?php echo esc_attr($slick_options['infinite']); ?>,
                    speed: <?php echo esc_attr($slick_options['speed']); ?>,
                    pauseOnHover: <?php echo esc_attr($slick_options['pauseOnHover']);?>,
                    fade: <?php echo esc_attr($slick_options['fade']); ?>
                });
                var $firstAnimatingElements = $('div.slide-animation:first-child').find('[data-animation]');
                doAnimations($firstAnimatingElements);    
                $('#<?php echo esc_js($id);?> .elementor-slides').on('beforeChange', function(e, slick, currentSlide, nextSlide) {
                  var $animatingElements = $('div.slide-animation[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
                  doAnimations($animatingElements);    
                });
                function doAnimations(elements) {
                    var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                    elements.each(function() {
                        var $this = $(this);
                        var $animationDelay = $this.data('delay');
                        var $animationType = 'animated ' + $this.data('animation');
                        $this.css({
                            'animation-delay': $animationDelay,
                            '-webkit-animation-delay': $animationDelay
                        });
                        $this.addClass($animationType).one(animationEndEvents, function() {
                            $this.removeClass($animationType);
                        });
                    });
                }
            });
        </script>
        <?php
    }
}
Plugin::instance()->widgets_manager->register_widget_type( new Apr_Core_Slides );