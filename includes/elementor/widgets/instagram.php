<?php
namespace Elementor;
if (!defined('ABSPATH')) exit;
class Apr_Core_Instagram extends Widget_Base
{
    public function get_name()
    {
        return 'apr_instagram';
    }

    public function get_title()
    {
        return __('APR Instagram', '');
    }

    public function get_icon()
    {
        return 'fab fa-instagram';
    }

    public function get_categories()
    {
        return array('apr-core');
    }

    public function get_script_depends()
    {
        return ['jquery-swiper'];
    }

    public function process_url($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 2
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function loadJs()
    {
        wp_enqueue_script('arrowpress_instagram', APR_CORE_PATH . 'assets/js/instagramfeed.js', array(), APR_VERSION);
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'instagram_section',
            [
                'label' => __('Instagram', 'apr-core')
            ]
        );

        $this->add_control(
            'instagram_tag',
            [
                'label' => __('Enter Tags', 'apr-core'),
                'description' => __('To distinguish tags, separate them with a pipe char ("|"). For example: Name|f_name', 'apr-core'),
                'default' => '',
                'type' => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'instagram_content_align',
            [
                'label' => __('Alignment', 'apr-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'apr-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'apr-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'apr-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .sc-instagram .content' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $slides_per_view = range(1, 6);
        $slides_per_view = array_combine($slides_per_view, $slides_per_view);
        $this->add_responsive_control(
            'instagram_per_view',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Number item per view', 'apr-core'),
                'options' => [
                    'auto' => __('Auto', 'apr-core'),
                    '1' => __('1', 'apr-core'),
                    '2' => __('2', 'apr-core'),
                    '3' => __('3', 'apr-core'),
                    '4' => __('4', 'apr-core'),
                    '5' => __('5', 'apr-core'),
                    '6' => __('6', 'apr-core'),
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 5,
                'tablet_default' => 4,
                'mobile_default' => 2,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'width_item',
            [
                'label' => __('Width Item', 'apr-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => __('Only works when the number of items per view is equal to "auto".', 'apr-core'),
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 40,
                'tablet_default' => 40,
                'mobile_default' => 40,
                'selectors' => [
                    '{{WRAPPER}} .sc-instagram .swiper-slide' => 'width: {{SIZE}}%;',
                ],
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => __('Space between items', 'apr-core'),
                'type' => Controls_Manager::NUMBER,
                'step' => 1,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 30,
                'tablet_default' => 30,
                'mobile_default' => 30,
                'min' => 0,
                'max' => 100,
            ]
        );

        $this->add_responsive_control(
            'number_column_fill',
            [
                'label' => __('Number Column Fill', 'apr-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'row' => __('Row', 'apr-core'),
                    'column' => __('Column', 'apr-core'),
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 'row',
                'tablet_default' => 'row',
                'mobile_default' => 'row',
            ]
        );

        $this->add_control(
            'instagram_slides_number_column',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Number Column', 'apr-core'),
                'options' => $slides_per_view,
                'default' => '1',
                'condition' => [
                    'number_column_fill' => 'row'
                ],
            ]
        );

        $this->add_control(
            'instagram_loop',
            [
                'label' => esc_html__('Loop', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'instagram_autoplay',
            [
                'label' => esc_html__('Autoplay', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'instagram_centeredSlides',
            [
                'label' => esc_html__('Centered Slides', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => __('Autoplay Delay', 'apr-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'effect',
            [
                'label' => __('Effect', 'apr-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', 'apr-core'),
                    'fade' => __('Fade', 'apr-core'),
                    'cube' => __('Cube', 'apr-core'),
                    'coverflow' => __('Coverflow ', 'apr-core'),
                    'flip' => __('Flip ', 'apr-core'),
                ],
            ]
        );
        $this->add_control(
            'instagram_enable_pagination',
            [
                'label' => esc_html__('Display Tablet And Mobile Pagination', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'instagram_enable_content',
            [
                'label' => esc_html__('Display Hover Content ', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control(
            'instagram_enable_social',
            [
                'label' => esc_html__('Display Social', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'instagram_enable_content' => 'yes',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'instagram_facebook',
            [
                'label' => __('Facebook', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'instagram_enable_social' => 'yes',
                    'instagram_enable_content' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'instagram_twitter',
            [
                'label' => __('Twitter', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'instagram_enable_social' => 'yes',
                    'instagram_enable_content' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'instagram_pinterest',
            [
                'label' => __('Pinterest', 'apr-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'instagram_enable_social' => 'yes',
                    'instagram_enable_content' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
        /*-----------------------------------------------------------------------------------*/
        /*  Style TAB
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'slider_style_section',
            array(
                'label' => __('Slider', 'apr-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_responsive_control(
            'slider_padding',
            [
                'label' => __('Padding', 'apr-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'user_name_style_section',
            array(
                'label' => __('Content', 'apr-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'instagram_enable_content!' => '',
                ],
            )
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('Padding', 'apr-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .content' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'user_name_content',
            [
                'type' => Controls_Manager::HEADING,
                'label' => 'User Name',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'user_name_color',
            [
                'label' => __('Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content .user-name' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'user_name_color_hover',
            [
                'label' => __('Hover Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content .user-name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_name_typo',
                'label' => __('Typography', 'apr-core'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .content .user-name',
            ]
        );
        $this->add_responsive_control(
            'user_name_margin_bottom',
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
                    '{{WRAPPER}} .content .user-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'edge_media_to_caption',
            [
                'type' => Controls_Manager::HEADING,
                'label' => 'Caption',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'caption_color',
            [
                'label' => __('Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'caption_tags_color_hover',
            [
                'label' => __('Tag Color Hover', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content p a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typo',
                'label' => __('Typography', 'apr-core'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .content p',
            ]
        );
        $this->add_responsive_control(
            'caption_margin_bottom',
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
                    '{{WRAPPER}} .content p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'social_style_section',
            array(
                'label' => __('Social', 'apr-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'instagram_enable_social!' => '',
                    'instagram_enable_content!' => '',
                ],
            )
        );
        $this->start_controls_tabs(
            'tabs_social'
        );
        $this->start_controls_tab(
            'social_normal',
            [
                'label' => __('Normal', 'apr-core'),
            ]
        );
        $this->add_control(
            'social_primary_color',
            [
                'label' => __('Primary Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content ul li a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'social_secondary_color',
            [
                'label' => __('Secondary Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content ul li a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'social_hover',
            [
                'label' => __('Hover', 'apr-core'),
            ]
        );
        $this->add_control(
            'social_primary_color_hover',
            [
                'label' => __('Primary Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content ul li a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'social_secondary_color_hover',
            [
                'label' => __('Secondary Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .content ul li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'social_size',
            [
                'label' => __('Size', 'apr-core'),
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
                    '{{WRAPPER}} .content ul li a' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'social_padding',
            [
                'label' => __('Padding Title', 'apr-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .content ul li a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'social_spacing',
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
                    '{{WRAPPER}} .content ul li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'social_border',
                'selector' => '{{WRAPPER}} .content ul li a',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'social_border_radius',
            [
                'label' => __('Border Radius', 'apr-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .content ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'pagination_style_section',
            array(
                'label' => __('Pagination', 'apr-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'instagram_enable_pagination!' => '',
                ],
            )
        );
        $this->add_control(
            'pagination_color',
            [
                'label' => __('Progressbar Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .swiper-pagination-progressbar' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'progressbar_fill_color',
            [
                'label' => __('Progressbar Fill Color', 'apr-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => ['
                    {{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pagination_height',
            [
                'label' => __('Height', 'apr-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '2',
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
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'progressbar_offset_orientation_v',
            [
                'label' => __('Vertical Orientation', 'apr-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => __('Top', 'apr-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => __('Bottom', 'apr-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );
        $this->add_responsive_control(
            'progressbar_offset_y',
            [
                'label' => __('Offset', 'apr-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'vh', 'vw'],
                'default' => [
                    'size' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'top: {{SIZE}}{{UNIT}};bottom: auto;',
                ],
                'condition' => [
                    'progressbar_offset_orientation_v!' => 'end',
                ],
            ]
        );
        $this->add_responsive_control(
            'progressbar_offset_y_end',
            [
                'label' => __('Offset', 'apr-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'vh', 'vw'],
                'default' => [
                    'size' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'bottom: {{SIZE}}{{UNIT}};top:auto;',
                ],
                'condition' => [
                    'progressbar_offset_orientation_v' => 'end',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $instagram_tag = $settings['instagram_tag'];
        $loop = $autoplay = $centeredSlides = '';
        if ($settings['instagram_loop'] === 'yes') {
            $loop = 'true';
        } else {
            $loop = 'false';
        }
        if ($settings['instagram_autoplay'] === 'yes') {
            $autoplay = 'true';
        } else {
            $autoplay = 'false';
        }
        if ($settings['instagram_centeredSlides'] === 'yes') {
            $centeredSlides = 'true';
        } else {
            $centeredSlides = 'false';
        }
        if ($settings['instagram_enable_pagination'] === 'yes') {
            $enable_pagination = 'progressbar';
        } else {
            $enable_pagination = 'none';
        }
        $instagram_enable_content = $settings['instagram_enable_content'];

        $instagram_facebook = $settings['instagram_facebook'];

        $instagram_twitter = $settings['instagram_twitter'];

        $instagram_pinterest = $settings['instagram_pinterest'];


        $id = 'sc-instagram-' . wp_rand();
        $instagram_content_align = $settings['instagram_content_align'];

        $options = get_option('arrowpress_instagram');
        $access_token = $options['access_token'];
        $user_id = $options['user_id'];
		/* Import Css */
		if (is_rtl()) {
			wp_enqueue_style( 'apr-sc-instagram', WP_PLUGIN_URL  . '/arrowpress-core/assets/css/instagram-rtl.css', array());
		}else{
			wp_enqueue_style( 'apr-sc-instagram', WP_PLUGIN_URL  . '/arrowpress-core/assets/css/instagram.css', array());
		}
        add_action( 'wp_enqueue_scripts', [ $this, 'apr-sc-instagram' ] );
        if ($access_token != '' && $user_id != ''):
            $url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . $access_token;
            $all_result = $this->process_url($url);
            $decoded_results = json_decode($all_result, true);
            ?>
            <div id="<?php echo esc_attr($id); ?>"
                 class="sc-instagram <?php echo esc_attr($instagram_content_align);
                 if ($settings['instagram_enable_pagination'] === 'yes') {
                     echo ' mobile-pagination';
                 } ?>">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php if (count($decoded_results) & isset($decoded_results['data'])) :
                            ?>
                            <?php foreach ($decoded_results['data'] as $value):
                            if ($instagram_tag != ""):
                                $instagram_tag_array = explode('|', $instagram_tag);
                                if (isset($value['tags'])):
                                    foreach ($instagram_tag_array as $tag):
                                        if (in_array($tag, $value['tags'])):?>
                                            <div class="swiper-slide">
                                                <div class="instagram-image"
                                                     style="background-image: url(<?php echo $value['images']['standard_resolution']['url']; ?>); ">
                                                    <a title="<?php echo esc_attr( $value['caption']['text'] );?>" target="_blank"
                                                       href="<?php echo $value['link'] ?>">
                                                    </a>
                                                </div>
                                                <?php if ($instagram_enable_content != ''): ?>
                                                    <div class="content">
                                                        <a class="user-name"
                                                           href="https://www.instagram.com/<?php echo esc_attr($value['user']['username']); ?>/" target="_blank"><?php echo '@' . $value['user']['full_name']; ?></a>
                                                        <?php if ($value['caption']['text']) { ?>
                                                            <p>
                                                                <?php if (isset($value['tags'])):
                                                                    foreach ($value['tags'] as $tag):
                                                                        $value['sc_tags_instagram'][] = '#' . $tag;
                                                                        $value['sc_tags_instagram_link'][] = '<a href="'. $tag . '/" target="_blank">#' . $tag . '</a>';
                                                                        $str = $value['caption']['text'];
                                                                        $str = str_replace($value['sc_tags_instagram'], $value['sc_tags_instagram_link'], $str);
                                                                    endforeach;
                                                                    echo $str;
                                                                else: echo $value['caption']['text']; endif; ?>
                                                            </p>
                                                        <?php } ?>
                                                        <ul class="socials">
                                                            <?php if (!empty($instagram_facebook)) : ?>
                                                                <li>
                                                                <a href="https://www.facebook.com/sharer.php?u=<?php echo $value['link']; ?>"
                                                                   target="_blank"><i
                                                                            class="theme-icon-facebook"></i></a>
                                                                </li><?php endif; ?>
                                                            <?php if (!empty($instagram_twitter)) : ?>
                                                                <li>
                                                                <a href="https://twitter.com/share?url=<?php echo $value['link']; ?>"><i
                                                                            class="theme-icon-twitter"></i></a>
                                                                </li><?php endif; ?>
                                                            <?php if (!empty($instagram_pinterest)) : ?>
                                                                <li>
                                                                <a href="http://pinterest.com/pin/create/button/?url=<?php echo $value['link']; ?>&amp;media=<?php echo $value['type']; ?>"><i
                                                                            class="theme-icon-pinterest"></i></a></li><?php endif; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; endforeach; endif;
                            else: ?>
                                <div class="swiper-slide">
                                    <div class="instagram-image"
                                         style="background-image: url(<?php echo $value['images']['standard_resolution']['url']; ?>);">
                                        <a title="<?php echo $value['caption']['text'] ?>" target="_blank"
                                           href="<?php echo $value['link'] ?>">
                                        </a>
                                    </div>
                                    <?php if ($instagram_enable_content != ''): ?>
                                        <div class="content">
                                            <a class="user-name"
                                               href="https://www.instagram.com/<?php echo $value['user']['username']; ?>/" target="_blank"><?php echo '@' . $value['user']['full_name']; ?></a>
                                            <?php if ($value['caption']['text']) { ?>
                                                <p>
                                                    <?php if (isset($value['tags'])):
                                                        foreach ($value['tags'] as $tag):
                                                            $value['sc_tags_instagram'][] = '#' . $tag;
                                                            $value['sc_tags_instagram_link'][] = '<a href="' . $tag . '/" target="_blank">#' . $tag . '</a>';
                                                            $str = $value['caption']['text'];
                                                            $str = str_replace($value['sc_tags_instagram'], $value['sc_tags_instagram_link'], $str);
                                                        endforeach;
                                                        echo $str;
                                                    else: echo $value['caption']['text']; endif; ?>
                                                </p>
                                            <?php } ?>
                                            <ul class="socials">
                                                <?php if (!empty($instagram_facebook)) : ?>
                                                    <li>
                                                    <a href="https://www.facebook.com/sharer.php?u=<?php echo $value['link']; ?>"
                                                       target="_blank"><i class="theme-icon-facebook"></i></a>
                                                    </li><?php endif; ?>
                                                <?php if (!empty($instagram_twitter)) : ?>
                                                    <li>
                                                    <a href="https://twitter.com/share?url=<?php echo $value['link']; ?>&amp;text=<?php echo $value['caption']['text']; ?>"><i class="theme-icon-twitter"></i></a>
                                                    </li><?php endif; ?>
                                                <?php if (!empty($instagram_pinterest)) : ?>
                                                    <li>
                                                    <a href="http://pinterest.com/pin/create/button/?url=<?php echo $value['link']; ?>&amp;description=<?php echo $value['caption']['text']; ?>&amp;media=<?php echo $value['type']; ?>"><i
                                                                class="theme-icon-pinterest"></i></a></li><?php endif; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <p class="err-messen-instagram"> <?php echo esc_html__("Access token is not valid.", 'apr-core'); ?></p>
                        <?php endif; ?>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        <?php endif; ?>
        <script>
            jQuery(document).ready(function ($) {
                $(window).load(function () {
                    if (($('#<?php echo esc_attr($id); ?> .swiper-container .swiper-wrapper').find('.instagram-image').length) == 0) {
                        $("#<?php echo esc_attr($id); ?> .swiper-container .swiper-wrapper").html('<p class="err-messen-instagram">Instagram has returned invalid data.</p>');
                    }
                    if (($('#<?php echo esc_attr($id); ?> .swiper-container').find('.err-messen-instagram').length) == 0) {
                        var swiper = new Swiper('#<?php echo esc_attr($id); ?> .swiper-container', {
                            loop: <?php echo esc_attr($loop);?>,
                            slidesPerColumn: '<?php echo esc_attr($settings['instagram_slides_number_column']);?>',
                            slidesPerView: '<?php echo esc_attr($settings['instagram_per_view']);?>',
                            slidesPerColumnFill: '<?php echo esc_attr($settings['number_column_fill']);?>',
                            autoplay: <?php echo $autoplay;?>,
                            effect: '<?php echo esc_attr($settings['effect']);?>',
                            spaceBetween: <?php echo esc_attr($settings['space_between']);?>,
                            centeredSlides: <?php echo esc_attr($centeredSlides);?>,
                            pagination: {
                                el: '.swiper-pagination',
                                type: '<?php echo esc_attr($enable_pagination);?>',
                            },
                            breakpoints: {
                                1025: {
                                    slidesPerView: '<?php echo esc_attr($settings['instagram_per_view']);?>',
                                    spaceBetween: <?php echo esc_attr($settings['space_between']);?>,
                                },
                                768: {
                                    slidesPerView: '<?php echo esc_attr($settings['instagram_per_view_tablet']);?>',
                                    spaceBetween: <?php echo esc_attr($settings['space_between_tablet']);?>,
                                },
                                320: {
                                    slidesPerView: '<?php echo esc_attr($settings['instagram_per_view_mobile']);?>',
                                    spaceBetween: <?php echo esc_attr($settings['space_between_mobile']);?>,
                                },
                            }
                        });
                    }
                    var instagram_image_resize = '#<?php echo esc_attr($id); ?>.sc-instagram  .swiper-slide .instagram-image';
                    var heightInstagram_resize = $(instagram_image_resize).width();
                    $(instagram_image_resize).css('height', heightInstagram_resize + 'px');

                    $(window).resize(function () {
                        var instagram_image_resize = '#<?php echo esc_attr($id); ?>.sc-instagram  .swiper-slide .instagram-image';
                        var heightInstagram_resize = $(instagram_image_resize).width();
                        $(instagram_image_resize).css('height', heightInstagram_resize + 'px');
                    });
                });
            });
        </script>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Apr_Core_Instagram);

