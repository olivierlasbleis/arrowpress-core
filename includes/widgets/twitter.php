<?php
	require_once dirname(__FILE__) . '/api/Abraham/TwitterOAuth/TwitterOAuth.php';
	class Apr_Core_Latest_Tweet_Settings {

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
                'APR Latest Tweets', 'APR Latest Tweets', 'manage_options', 'latest-tweet', array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option('arrowpress_latest_tweet');
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>          
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('arrowpress_latest_tweet_group');
                do_settings_sections('latest-tweet');
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
                'arrowpress_latest_tweet_group', // Option group
                'arrowpress_latest_tweet' // Option name
        );

        add_settings_section(
                'general_setting', // ID
                'Twitter Api Settings', // Title
                array($this, 'print_section_info'), // Callback
                'latest-tweet' // Page
        );

       add_settings_field(
                'username', 'Twitter Username', array($this, 'username_callback'), 'latest-tweet', 'general_setting'
        );
        
        add_settings_field(
                'consumer_key', 'Consumer Key', array($this, 'consumer_key_callback'), 'latest-tweet', 'general_setting'
        );
        
        add_settings_field(
                'consumer_secret', 'Consumer Secret', array($this, 'consumer_secret_callback'), 'latest-tweet', 'general_setting'
        );
        
        add_settings_field(
                'access_token', 'Access Token', array($this, 'access_token_callback'), 'latest-tweet', 'general_setting'
        );
        
        add_settings_field(
                'access_token_secret', 'Access Token Secret', array($this, 'access_token_secret_callback'), 'latest-tweet', 'general_setting'
        );
    }

    /**
     * Print the Section text
     */
    public function print_section_info() {
        print 'Enter your settings below:';
        ?>
			<p><?php echo __('To use Twitter counter widget and other Twitter related widgets, you need OAuth access keys. To get Twitter Access keys, you need to create Twitter Application which is mandatory to access Twitter.','apr-core'); ?></p>
            <p><?php echo __('1. Go to ', 'apr-core'); ?><a href="https://dev.twitter.com/apps/new" target="_blank"><?php echo __('https://dev.twitter.com/apps/new', 'apr-core'); ?></a> <?php echo __('and log in, if necessary', 'apr-core'); ?></p>
			<p><?php echo __('2. Enter your Application Name, Description and your website address. You can leave the callback URL empty.','apr-core'); ?></p>
			<p><?php echo __('3. Accept the TOS, and solve the CAPTCHA.','apr-core'); ?></p>
			<p><?php echo __('4. Submit the form by clicking the Create your Twitter Application','apr-core'); ?></p>
			<p><?php echo __('5. Copy the consumer key (API key) and consumer secret from the screen into your application','apr-core'); ?></p>
			<p><?php echo __('You can enter the Access token information as ','apr-core'); ?><a target="_blank" href="http://prntscr.com/kjldaq"><?php echo __('follows','apr-core'); ?></a></p>
		<?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function username_callback() {
        printf(
                '<input type="text" id="username" size="50" name="arrowpress_latest_tweet[username]" value="%s" />', isset($this->options['username']) ? esc_attr($this->options['username']) : ''
        );
    }
    
    public function consumer_key_callback() {
        printf(
                '<input type="text" size="100" name="arrowpress_latest_tweet[consumer_key]" value="%s"/><br>',
                isset($this->options['consumer_key']) ? esc_attr($this->options['consumer_key']) : ''
        );
    }
    
    public function consumer_secret_callback() {
        printf(
                '<input type="text" size="100" name="arrowpress_latest_tweet[consumer_secret]" value="%s"/><br>',
                isset($this->options['consumer_secret']) ? esc_attr($this->options['consumer_secret']) : ''
        );
    }
    
    public function access_token_callback() {
        printf(
                '<input type="text" size="100" name="arrowpress_latest_tweet[access_token]" value="%s"/><br>',
                isset($this->options['access_token']) ? esc_attr($this->options['access_token']) : ''
        );
    }
    
    public function access_token_secret_callback() {
        printf(
                '<input type="text" size="100" name="arrowpress_latest_tweet[access_token_secret]" value="%s"/><br>',
                isset($this->options['access_token_secret']) ? esc_attr($this->options['access_token_secret']) : ''
        );
    }

}

new Apr_Core_Latest_Tweet_Settings();

if ( ! class_exists( 'Apr_Tweet_Widget' ) ) {

	class Apr_Tweet_Widget extends WP_Widget {

	    /**
	     * Register widget with WordPress.
	     */
	    function __construct() {
	        parent::__construct(
	                'arrowpress_latest_tweet', // Base ID
	                __('[APR] Latest Tweet', 'apr-core'), // Name
	                array('description' => __('This Widget show the Latest Tweets', 'apr-core'),) // Args
	        );
	    }

	    /**
	     * Front-end display of widget.
	     *
	     * @see WP_Widget::widget()
	     *
	     * @param array $args     Widget arguments.
	     * @param array $instance Saved values from database.
	     */
	    public function widget($args, $instance) {
	        echo $args['before_widget'];
	        if (!empty($instance['title'])) {
	            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
	        }
	        $number_tweets = 5;
	        if (!empty($instance['tweet_limit']) && $instance['tweet_limit'] >= 0) {
	            $number_tweets = $instance['tweet_limit'];
	        }
	        $options = get_option('arrowpress_latest_tweet');
	        $username = $options['username'];
	        $consumer_key = $options['consumer_key'];
	        $consumer_secret = $options['consumer_secret'];
	        $access_token = $options['access_token'];
	        $access_token_secret = $options['access_token_secret'];
	        if(empty($username) || empty($consumer_key) || empty($consumer_secret) 
	                || empty($access_token) || empty($access_token_secret)) {
	        	echo '<p>';
	        	echo esc_html__('Something wrong, please check the connection or the api config!');
	        	echo '</p>';
	        	echo $args['after_widget'];
	            return false;
	        }
	        # Create the connection
	        $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	        # Migrate over to SSL/TLS
	        $twitter->ssl_verifypeer = false;
	        # Load the Tweets
	        try {
	            $tweets = $twitter->get('statuses/user_timeline', array('screen_name' => $username, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => $number_tweets));
	            # Example output
	            if (!empty($tweets)) {
	                echo '<div class="latest-tweets"><ul>';
	                foreach($tweets as $_tweet) {
	                    $user = $_tweet->user;
	                    $handle = $user->screen_name;
	                    $id_str = $_tweet->id_str;
	                    $link = esc_html( 'http://twitter.com/'.$handle.'/status/'.$id_str);
	                    $date = DateTime::createFromFormat('D M d H:i:s O Y', $_tweet->created_at );
	                    $output ='<li>';
	                    $output .= '<div class="twitter-tweet"><i class="fa fa-twitter"></i><div class ="tweet-text">'. tp_convert_links($_tweet->text).'<p class="twitter_time"><a target="_blank" href = "' . esc_url($link) . '">' .esc_attr($date->format('g:i A - j M Y')).'</a></p></div>';
	                    $output .= '</div></li>';
	                    echo $output;
	                }
	                echo '</ul></div>';
	            }
	        } catch (Exception $exc) {
	        	echo '<p>';
	            echo esc_html__('Something wrong, please check the connection or the api config!');
	            echo '</p>';
	        }
	        echo $args['after_widget'];
	    }

	    /**
	     * Back-end widget form.
	     *
	     * @see WP_Widget::form()
	     *
	     * @param array $instance Previously saved values from database.
	     */
	    public function form($instance) {
	        $title = !empty($instance['title']) ? $instance['title'] : __('Latest Twitter', 'apr-core');
	        ?>
	        <p>
	            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
	            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
	        </p>
	        <?php
	        $tweet_limit = !empty($instance['tweet_limit']) ? $instance['tweet_limit'] : 5;
	        ?>
	        <p>
	            <label for="<?php echo $this->get_field_id('tweet_limit'); ?>"><?php _e('Number of tweets:'); ?></label> 
	            <input class="widefat" id="<?php echo $this->get_field_id('tweet_limit'); ?>" name="<?php echo $this->get_field_name('tweet_limit'); ?>" type="text" value="<?php echo esc_attr($tweet_limit); ?>">
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
	    public function update($new_instance, $old_instance) {
	        $instance = array();
	        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
	        $instance['tweet_limit'] = (!empty($new_instance['tweet_limit']) ) ? strip_tags($new_instance['tweet_limit']) : '';

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
	//convert links to clickable format
	if (!function_exists('tp_convert_links')) {
		function tp_convert_links($status,$targetBlank=true,$linkMaxLen=250){
		 
			// the target
				$target=$targetBlank ? " target=\"_blank\" " : "";
			 
			// convert link to url								
				$status = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]/i', '<a href="\0" target="_blank">\0</a>', $status);
			 
			// convert @ to follow
				$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);
			 
			// convert # to search
				$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);
			 
			// return the status
				return $status;
		}
	}
}
