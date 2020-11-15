<?php
class Apr_Core_Instagram_Feed_Settings {

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            'Instagram Settings', 'Instagram Settings', 'manage_options', 'instagram-feed', array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option('arrowpress_instagram');
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('arrowpress_instagram_group');
                do_settings_sections('instagram-feed');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            'arrowpress_instagram_group', // Option group
            'arrowpress_instagram' // Option name
        );

        add_settings_section(
            'general_setting', // ID
            'General Settings', // Title
            array($this, 'print_section_info'), // Callback
            'instagram-feed' // Page
        );

        add_settings_field(
            'access_token', 'Access token', array($this, 'access_token_id_callback'), 'instagram-feed', 'general_setting'
        );

        add_settings_field(
            'type', 'User ID', array($this, 'type_callback'), 'instagram-feed', 'general_setting'
        );
    }

    /**
     * Print the Section text
     */
    public function print_section_info() {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function access_token_id_callback() {
        printf(
            '<input type="text" id="access_token" size="100" name="arrowpress_instagram[access_token]" value="%s" />', isset($this->options['access_token']) ? esc_attr($this->options['access_token']) : ''
        );
    }

    public function type_callback() {
        printf(
            '<input type="text" name="arrowpress_instagram[user_id]" value="%s"/><br>',
            isset($this->options['user_id']) ? esc_attr($this->options['user_id']) : ''
        );
    }

}

new Apr_Core_Instagram_Feed_Settings();

if ( ! class_exists( 'Apr_Instagram_Widget' ) ) {

    class Apr_Instagram_Widget extends Apr_Widget  {

        public function __construct() {
            $this->widget_cssclass    = 'instagram';
            $this->widget_description = esc_html__( 'Adds support for Instagram.', 'apr-core' );
            $this->widget_id          = 'instagram-widget';
            $this->widget_name        = esc_html__( '[APR] Instagram', 'apr-core' );
            parent::__construct();
        }
        function loadJs() {
            wp_enqueue_script('arrowpress_instagram', APR_CORE_PATH . 'assets/js/instagramfeed.js', array(), APR_VERSION);
        }
        public function widget( $args, $instance ) {
            $options = get_option('arrowpress_instagram');
            $access_token = $options['access_token'];
            $user_id = $options['user_id'];

            extract( $args );
            $tag = ( ! empty( $instance['tag'] ) ) ? strip_tags( $instance['tag'] ) : '';
            $title = apply_filters( 'widget_title', $instance['title'] );
            $i=0;
            echo $before_widget;
            if ( $title )
                echo $before_title . $title . $after_title;
            ?>

            <?php if ($access_token != '' && $user_id != ''): ?>
                <?php
                $url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . $access_token;
                $all_result = $this->process_url($url);

                $decoded_results = json_decode($all_result, true);
                ?>
                <div class="instagram-container">
                    <?php if (count($decoded_results) & isset($decoded_results['data'])) : ?>
                        <?php if($instance['number'] <=9):?>
                            <div class="instagram-gallery">
                                <?php if($tag != ""):?>
                                    <?php foreach (array_slice($decoded_results['data'], 0) as $value): ?>
                                        <?php if( isset($value['tags'][0])):?>
                                            <?php if (in_array($tag, $value['tags'])):?>
                                                <?php  $i ++;?>
                                                <?php if($i <= $instance['number']):?>
                                                    <div class="instagram-img" style="background-image: url(<?php echo $value['images']['standard_resolution']['url'] ?>)">
                                                        <a title="<?php echo $value['caption']['text'] ?>" target="_blank" href="<?php echo $value['link'] ?>">
                                                        </a>
                                                    </div>
                                                <?php endif;?>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach; ?>
                                <?php else:?>
                                    <?php foreach (array_slice($decoded_results['data'], 0, $instance['number']) as $value): ?>
                                        <div class="instagram-img" style="background-image: url(<?php echo $value['images']['standard_resolution']['url'] ?>)">
                                            <a title="<?php echo $value['caption']['text'] ?>" target="_blank" href="<?php echo $value['link'] ?>">
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif;?>
                            </div>
                        <?php else:?>
                            <div class="instagram-gallery">
                                <?php foreach (array_slice($decoded_results['data'], 0, 8) as $value): ?>
                                    <div class="instagram-img" style="background-image: url(<?php echo $value['images']['standard_resolution']['url'] ?>)">
                                        <a title="<?php echo $value['caption']['text'] ?>" target="_blank" href="<?php echo $value['link'] ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif;?>

                    <?php else: ?>
                        <p> <?php echo esc_html__("Access token is not valid.",'apr-core');?></p>
                    <?php endif;?>
                </div>
            <?php endif; ?>
            <?php
            echo $after_widget;
        }
        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {
            $defaults = array(
                'title' => 'Instagram',
                'number' => 9,
                'tag' =>"",
            );
            $instance = wp_parse_args( (array) $instance, $defaults );
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" type="text" name="<?php echo $this->get_field_name('title'); ?>'" value="<?php echo $instance['title']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos to display (Less than or equal to 9):'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('tag'); ?>">Hashtag:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" type="text" name="<?php echo $this->get_field_name('tag'); ?>'" value="<?php echo $instance['tag']; ?>" />
            </p>


            <?php
        }
        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
            $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
            return $instance;
        }
        function process_url($url) {
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
    }

}
