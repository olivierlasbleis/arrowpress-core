<?php
class Apr_Metabox {
    private $screen = array(
        'page',
    );
    private $metakey ;
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_fields' ) );
    }
    public function add_meta_boxes() {
        foreach ( $this->screen as $single_screen ) {
            add_meta_box(
                'new',
                __( 'Page Options', 'apr-core' ),
                array( $this, 'meta_box_callback' ),
                $single_screen,
                'normal',
                'default'
            );
        }
    }
    public function general_option(){
        $apr_sidebars = Lusion_Helper::get_registered_sidebars($default_option = true);
        return array(
            'title'     => esc_attr__( 'General', 'apr-core' ),
            'id'        => 'general',
            'fields'    => array(
                array(
                    'id'      => 'site_layout',
                    'label'   => esc_attr__( 'Layout', 'apr-core' ),
                    'desc'    => esc_attr__( 'Controls the layout of this page.', 'apr-core' ),
                    'type'    => 'button_set',
                    'options' => array(
                        'default'      => esc_html__( 'Default', 'apr-core' ),
                        'wide'         => esc_html__( 'Wide', 'apr-core' ),
                        'full-width'   => esc_html__( 'Full width', 'apr-core' ),
                        'boxed'        => esc_html__( 'Boxed', 'apr-core' ),
                    ),
                    'default' => 'default',
                ),
                array(
                    'id'      => 'site_width',
                    'label'   => esc_attr__( 'Site width', 'apr-core' ),
                    'desc'    => esc_attr__( 'Controls the site width for this page (Only works with Full Width layout). Enter value including any valid CSS unit, ex: 1200px. Leave blank to use global setting.', 'apr-core' ),
                    'type'    => 'text',
                    'default' => '',
                ),
                array(
                    'id'      => 'preload',
                    'label'   => esc_attr__( 'Preload Layout', 'apr-core' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => array(
                        'default' => esc_html__('Default Preload', 'apr-core'),
                        'preload-1' => esc_html__('Preload Type 1', 'apr-core'),
                        'preload-2' => esc_html__('Preload Type 2', 'apr-core'),
                        'preload-3' => esc_html__('Preload Type 3', 'apr-core'),
                        'preload-4' => esc_html__('Preload Type 4', 'apr-core'),
                        'preload-5' => esc_html__('Preload Type 5', 'apr-core'),
                        'preload-6' => esc_html__('Preload Type 6', 'apr-core'),
                        'preload-7' => esc_html__('Preload Type 7', 'apr-core'),
                        'preload-8' => esc_html__('Preload Type 8', 'apr-core'),
                        'preload-9' => esc_html__('Preload Type 9', 'apr-core'),
                    ),
                    'desc'    => esc_attr__( '', 'apr-core' ),
                ),
                array(
                    'id'      => 'left_sidebar_general',
                    'label'   => esc_attr__( 'Left Sidebar', 'apr-core' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => $apr_sidebars,
                    'desc'    => esc_attr__( '', 'apr-core' ),
                ),
                array(
                    'id'      => 'right_sidebar_general',
                    'label'   => esc_attr__( 'Right Sidebar', 'apr-core' ),
                    'type'    => 'select',
                    'default' => 'default',
                    'options' => $apr_sidebars,
                    'desc'    => esc_attr__( '', 'apr-core' ),
                ),
                array(
                    'id'      => 'remove_space_top',
                    'label'   => esc_attr__( 'Remove top space', 'apr-core' ),
                    'type'    => 'checkbox',
                    'default' => '',
                    'desc'    => esc_attr__( 'Remove top space', 'apr-core' ),
                ),
                array(
                    'id'      => 'remove_space_bottom',
                    'label'   => esc_attr__( 'Remove bottom space', 'apr-core' ),
                    'type'    => 'checkbox',
                    'default' => '',
                    'desc'    => esc_attr__( 'Remove bottom space', 'apr-core' ),
                ),
                 array(
                    'id'      => 'scroll_chevron_enable',
                    'label'   => esc_attr__( 'Enable scroll chevron', 'apr-core' ),
                    'type'    => 'checkbox',
                    'default' => '',
                    'desc'    => esc_attr__( 'Enable scroll chevron', 'apr-core' ),
                ),
            ),
        );

    }
    public function skin_option(){
        return  array(
            'title'   => esc_attr__( 'Skin', 'apr-core' ),
            'id'      => 'skin',
            'fields'  => array(
                array(
                    'id'      => 'site_color',
                    'label'   => esc_attr__( 'Primary Color', 'apr-core' ),
                    'desc'    => esc_attr__( 'Select different main color for page', 'apr-core' ),
                    'type'    => 'color',
                    'default' => ''
                ),
                array(
                    'id'      => 'site_background',
                    'label'   => esc_attr__( 'Body Background Color', 'apr-core' ),
                    'desc'    => 'You should input hex color(ex: #e1e1e1)',
                    'type'    => 'color',
                    'default' => ''
                ),
                array(
                    'id'      => 'body_bg_image',
                    'label'   => esc_attr__( 'Body Background Image', 'apr-core' ),
                    'desc'    => '',
                    'type'    => 'image',
                    'default' => ''
                ),
                array(
                    'id'      => 'scroll_top_color',
                    'label'   => esc_attr__( 'Scroll to top color', 'apr-core' ),
                    'type'    => 'color',
                    'default' => '',
                    'desc'    => esc_attr__( 'Scroll to top button color', 'apr-core' ),
                ),
            )
        );
    }
    public function breadcrumbs_option(){
        return  array(
            'title'   => esc_attr__( 'Breadcrumbs & Page title', 'apr-core' ),
            'id'      => 'breadcrumbs_title',
            'fields'  => array(
                array(
                    'id'      => 'breadcrumbs',
                    'label'   => esc_attr__( 'Hide Breadcrumbs', 'apr-core' ),
                    'type'    => 'checkbox',
                    'default' => '',
                ),
                array(
                    'id' => 'page_title',
                    'label' => esc_html__('Hide Page Title', 'apr-core'),
                    'desc' => esc_html__('Hide Page Title', 'apr-core'),
                    'type' => 'checkbox',
                    'default' => '',
                ),
                array(
                    'id' => 'align_breadcrumbs',
                    'label' => esc_html__('Align Breadcrumb', 'apr-core'),
                    'type' => 'select',
                    'options' => array(
                        'default'  => esc_html__( 'Default', 'apr-core' ),
                        'left'  => esc_html__( 'Left', 'apr-core' ),
                        'center'  => esc_html__( 'Center', 'apr-core' ),
                        'right'  => esc_html__( 'Right', 'apr-core' ),
                    ),
                    'default' => '',
                ),
                array(
                    "id" => "breadcrumbs_bg",
                    "label" => esc_html__("Breadcrumbs Background", 'apr-core'),
                    'desc' => esc_html__("Upload breadcrumbs background", 'apr-core'),
                    "type" => "image",
                    'default' => '',
                ),
                array(
                    "id" => "title_color",
                    "label" => esc_html__("Page Title Color", 'apr-core'),
                    "type" => "color",
                    'default' => '',
                ),
                array(
                    "id" => "breadcrumbs_color",
                    "label" => esc_html__("Breadcrumbs Color", 'apr-core'),
                    "type" => "color",
                    'default' => '',
                ),
                 array(
                    "id" => "link_color",
                    "label" => esc_html__("Breadcrumb Link Color", 'apr-core'),
                    "type" => "color",
                    'default' => '',
                ),
                array(
                    "id" => "breadcrumbs_bg_overlay",
                    "label" => esc_html__("Breadcrumbs Background Overlay ", 'apr-core'),
                    "type" => "color",
                    'default' => '',
                ),
                array(
                    "id" => "breadcrumbs_opacity",
                    "label" => esc_html__("Breadcrumbs Opacity Background Overlay ", 'apr-core'),
                    "type" => "text",
                    'default' => '',
                ),
            )
        );
    }
    private function get_post_type_data($post_type = 'post') {

        $data = array();
        $args = array(
            'post_type'      => 'header',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        $data['default'] = esc_html__( 'Default', 'apr-core' );
        if ($posts = get_posts( $args )){
            foreach ($posts as $post) {
                /**
                 * @var $post WP_Post
                 */
                $data[$post->post_name] = $post->post_title;
            }
        }

        return $data;
    }
    public function header_option(){
        return  array(
            'title'   => esc_attr__( 'Header', 'apr-core' ),
            'id'     => 'header',
            'fields'    => array(
                array(
                    'id'      => 'header_type',
                    'label'   => esc_attr__( 'Header Type', 'apr-core' ),
                    'desc'    => esc_attr__( 'Select header type that displays on this page.', 'apr-core' ),
                    'type'    => 'select',
                    'options' => $this->get_post_type_data('header'),
                    'default' => 'default',
                ),
                array(
                    'id'      => 'menu_display',
                    'label'   => esc_attr__( 'Primary menu', 'apr-core' ),
                    'desc'    => esc_attr__( 'Select the menu displayed on this page. Only applies to the default header', 'apr-core' ),
                    'type'    => 'select',
                    'options' => Lusion_Helper::get_all_menus(),
                    'default' => '',
                ),
                array(
                    'id'      => 'hide_header',
                    'label'   => esc_attr__( 'Hide Header', 'apr-core' ),
                    'desc'    => esc_attr__( 'Turn on hide status.', 'apr-core' ),
                    'type'    => 'checkbox',
                    'default' => '',
                ),
                array(
                    'id'      => 'fixed_header',
                    'label'   => esc_attr__( 'Header fixed', 'apr-core' ),
                    'desc'    => esc_attr__( 'Switch header fixed ON or OFF?', 'apr-core' ),
                    'type'    => 'button_set',
                    'options' => array(
                        ''      => esc_html__( 'Default', 'apr-core' ),
                        'on'         => esc_html__( 'On', 'apr-core' ),
                        'off'   => esc_html__( 'Off', 'apr-core' ),
                    ),
                    'default' => '',
                ),

                array(
                    'id'      => 'meta_header_sticky',
                    'label'   => esc_attr__( 'Header Sticky', 'apr-core' ),
                    'desc'    => esc_attr__( 'Switch header sticky ON or OFF?', 'apr-core' ),
                    'type'    => 'button_set',
                    'options' => array(
                        ''      => esc_html__( 'Default', 'apr-core' ),
                        'on'         => esc_html__( 'On', 'apr-core' ),
                        'off'   => esc_html__( 'Off', 'apr-core' ),
                    ),
                    'default' => '',
                ),
                array(
                    'id'      => 'sticky_bg',
                    'label'   => esc_attr__( 'Header Sticky Background', 'apr-core' ),
                    'desc'    => esc_html__("You should input hex color(ex: #ffffff).", 'apr-core'),
                    'type'    => 'color',
                    'default' => '',
                ),
            )
        );
    }
    private function get_post_type_data_footer($post_type = 'post') {

        $data = array();
        $args = array(
            'post_type'      => 'footer',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        $data['default'] = esc_html__( 'Default', 'apr-core' );
        if ($posts = get_posts( $args )){
            foreach ($posts as $post) {
                /**
                 * @var $post WP_Post
                 */
                $data[$post->post_name] = $post->post_title;
            }
        }

        return $data;
    }
    public function footer_option(){
        return  array(
            'title'   => esc_attr__( 'Footer', 'apr-core' ),
            'id'     => 'footer','fields'    => array(
                array(
                    'id'      => 'footer_type',
                    'label'   => esc_attr__( 'Footer Type', 'apr-core' ),
                    'desc'    => esc_attr__( 'Select footer type that displays on this page.', 'apr-core' ),
                    'type'    => 'select',
                    'options' => $this->get_post_type_data_footer('footer'),
                    'default' => 'default',
                ),
                array(
                    'id'      => 'hide_footer',
                    'label'   => esc_attr__( 'Hide Footer', 'apr-core' ),
                    'desc'    => esc_attr__( 'Turn on hide status.', 'apr-core' ),
                    'type'    => 'checkbox',
                    'default' => '',
                ),
            )
        );
    }
    public function general_meta_fields(){
        $meta_fields = array(
            $this -> general_option(),
            $this -> skin_option(),
            $this -> breadcrumbs_option(),
            $this -> header_option(),
            $this -> footer_option(),
        );
        return $meta_fields;
    }

    public function meta_box_callback( $post ) {
        wp_nonce_field( 'new_data', 'new_nonce' );
        $this->field_generator( $post );
    }

    public function field_generator( $post ) {
        ?>
        <div class="metabox-tabs-container">
            <div class="tab-bg"></div>
            <ul class="metabox-tabs" id="metabox-tabs">
                <?php foreach ($this->general_meta_fields() as $meta_fields){ ?>
                    <li><a href="#<?php echo esc_attr( $meta_fields['id']);?>"><?php echo esc_html( $meta_fields['title'] );?></a></li>
                <?php } ?>
            </ul>
            <ul class="metabox-content">
                <?php
                foreach ($this->general_meta_fields() as $list_meta){
                    ?>
                    <li id="<?php echo esc_attr($list_meta['id']); ?>" class="<?php echo 'meta-content-'.esc_attr($list_meta['id'])?>">
                        <?php
                        foreach ($list_meta['fields'] as  $meta_field){
                            $meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
                            if ( empty( $meta_value ) ) {
                                $meta_value = $meta_field['default'];
                            }

                            if ($meta_field['type'] == 'checkbox'){
                                $class = 'field-checkbox';
                            }else{
                                $class = '';
                            }
                            if ($meta_field['type'] == 'button_set'){
                                $class_button_set = 'wp-button-set-inner';
                            }else{
                                $class_button_set = '';
                            }
                            ?>
                            <div class="section-row field-row" >
                                <label for="<?php echo $meta_field['id']; ?>"><?php echo $meta_field['label']; ?></label>
                                <div class="section-row-right <?php echo $class .$class_button_set;?>">
                                    <?php
                                    switch ($meta_field['type']){
                                        case 'select':
                                            $input = sprintf(
                                                '<select id="%s" name="%s">',
                                                $meta_field['id'],
                                                $meta_field['id']
                                            );
                                            foreach ( $meta_field['options'] as $key => $value ) {
                                                $meta_field_value =  $key;
                                                $input .= sprintf(
                                                    '<option %s value="%s">%s</option>',
                                                    $meta_value === $meta_field_value ? 'selected="selected"' : '',
                                                    $meta_field_value,
                                                    $value
                                                );
                                            }
                                            $input .= '</select>';
                                            break;
                                        case 'button_set':
                                            $input = sprintf(
                                                '<input id="%s" name="%s" type="hidden" value="%s">',
                                                $meta_field['id'],
                                                $meta_field['id'],
                                                $meta_value
                                            );
                                            $input .= '<div class="button-set-inner">';
                                            foreach ( $meta_field['options'] as $key => $value ) {
                                                $meta_field_value =  $key;
                                                $input .= sprintf(
                                                    '<label %s data-value="%s"><span>%s</span></label>',
                                                    $meta_value == $meta_field_value ? ' class="selected"' : '',
                                                    $meta_field_value,
                                                    $value
                                                );
                                            }
                                            $input .= '</div>';
                                            break;
                                        case 'hidden':
                                            $input ='<span class="mk-toggle-button"  data-on="ON" data-off="OFF">';
                                            $input .= sprintf(
                                                '<input type="hidden" value="%s" name="%s" id="%s">',
                                                $meta_value,
                                                $meta_field['id'],
                                                $meta_field['id']
                                            );
                                            $input .= '</span>';
                                            break;
                                        case 'checkbox':
                                            $input = sprintf(
                                                '<input %s id="%s" name="%s" type="checkbox" value="1"><label for="%s" data-on="ON" data-off="OFF"></label>',
                                                $meta_value === '1' ? 'checked="checked"' : '',
                                                $meta_field['id'],
                                                $meta_field['id'],
                                                $meta_field['id']
                                            );
                                            break;
                                        case 'color':
                                            $input = sprintf(
                                                '<div class="apr-meta-color"><input %s id="%s" name="%s" type="text" value="%s"  class="apr-color-field"><label class="apr-transparency-check" for="%s-transparency"><input type="checkbox" value="1" id="%s-transparency" class="checkbox apr-color-transparency"> Transparent</label></div>',
                                                $meta_field['type'] !== 'color' ? 'style=""' : '',
                                                $meta_field['id'],
                                                $meta_field['id'],
                                                $meta_value,
                                                $meta_field['id'],
                                                $meta_field['id']
                                            );
                                            break;
                                        case 'textarea':
                                            $input = sprintf(
                                                '<textarea  %s id="%s" name="%s"  type="textarea" >',
                                                $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                                                $meta_field['id'],
                                                $meta_field['id'],
                                                $meta_value,
                                                $meta_field['id'],
                                                $meta_field['id']
                                            );

                                            $input .= '</textarea>';
                                            break;
                                        case 'editor':
                                            $input = wp_editor($meta_value, $meta_field['id']);
                                            break;
                                        case 'image':
                                            $input = sprintf(
                                                '<input %s id="%s" type="text" name="%s" value="%s"><br/><input type="button" id="% s" class="button_upload_image button" value="Upload File"><input type="button" id="% s" class="button_remove_image button" value="Remove File">',
                                                $meta_field['type'] == 'image' ? 'style="width: 100%; margin-bottom:5px;"' : '',
                                                $meta_field['id'],
                                                $meta_field['id'],
                                                $meta_value,
                                                $meta_field['id'],
                                                $meta_field['id']
                                            );
                                            break;

                                        case 'gallery':
                                            $input = sprintf('
                                                    <div id="gallery-metabox">
                                                        <div class="sn-gallery-wrap">
                                                            <div class="sn-gallery-inner">
                                                                <a href="#" class="button gallery-add-images"
                                                                    title="%s"
                                                                    data-uploader-title="%s"
                                                                    data-uploader-button-text="%s">%s</a>
                                                                <ul class="images-list">
                                                                %s
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>',
                                                __( 'Add image(s) to gallery', 'apr-core' ),
                                                __( 'Add image(s)', 'apr-core'),
                                                __( 'Add image(s)', 'apr-core'),
                                                __( 'Add image(s)', 'apr-core' ),
                                                $this->getGalleryImageInput($meta_value)
                                            );
                                            break;
                                        default:
                                            $input = sprintf(
                                                '<input %s id="%s" name="%s" type="%s" value="%s">',
                                                $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                                                $meta_field['id'],
                                                $meta_field['id'],
                                                $meta_field['type'],
                                                $meta_value
                                            );
                                    }
                                    echo $input;
                                    ?>
                                    <?php if (isset($meta_field['desc'])){?>
                                        <p class="meta-description"><?php echo esc_attr($meta_field['desc']);?></p>
                                    <?php }?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php

                        ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }

    protected function getGalleryImageInput($images) {
        $imgsHtml = '';
        if (is_array($images) && count($images)) {
            foreach ($images as $key => $value) {
                $imgSrc = wp_get_attachment_image_src($value );
                $imgsHtml .= '<li>
                            <input type="hidden" name="sn-gallery-id['.esc_attr($key).']" value="'.esc_attr($value).'"/>
                            <img class="image-preview" src="'.esc_url($imgSrc[0]).'" width="80" height="80"/>
                            <a href="#" class="change-image"
                            title="'.esc_html__( 'Change image', 'apr-core' ).'"
                            data-uploader-title="'.esc_html__( 'Change image', 'apr-core' ).'"
                            data-uploader-button-text="'.esc_html__( 'Change image', 'apr-core' ).'"><i class="dashicons dashicons-edit"></i></a>
                            <a href="#" class="remove-image" title="'.esc_html__( 'Remove Image', 'apr-core' ).'"><i class="dashicons dashicons-no"></i></a>
                            </li>';
            }
        }
        return $imgsHtml;
    }

    /* Save Metabox */
    public function save_fields( $post_id ) {
        if ( ! isset( $_POST['new_nonce'] ) )
            return $post_id;
        $nonce = $_POST['new_nonce'];
        if ( !wp_verify_nonce( $nonce, 'new_data' ) )
            return $post_id;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        foreach ($this->general_meta_fields() as $list_meta){
            foreach ($list_meta['fields'] as $k => $meta_field){
                if (isset($_POST[$meta_field['id']])){
                    switch ($meta_field['type']){
                        case 'email':
                            $_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
                            break;
                        case 'text':
                            $_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
                            break;
                        case 'button_set':
                            $_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
                            break;
                        case 'hidden':
                            $_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
                            break;
                        case 'textarea':
                            $_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
                            break;
                    }
                    update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
                }else if ( $meta_field['type'] === 'checkbox' ) {
                    update_post_meta( $post_id, $meta_field['id'], '0' );
                }
            }
        }

        $this->saveGalleryImage($post_id);

    }

    protected function saveGalleryImage($post_id) {
        $new_meta_data = array();
        $old_meta_data = get_post_meta( $post_id, 'gallery_metabox', true );

        if ( isset ($_POST['sn-gallery-id'] ) ) {
            $new_meta_data = $_POST['sn-gallery-id'];
        }

        if ( ! empty( $new_meta_data ) ) {
            if ( empty($old_meta_data) ) {
                add_post_meta( $post_id, 'gallery_metabox', $new_meta_data, true );
            }
            elseif ( array_diff( $old_meta_data, $new_meta_data ) || $old_meta_data !== $new_meta_data ) {
                update_post_meta( $post_id, 'gallery_metabox', $new_meta_data );
            }
        }
        else {
            delete_post_meta( $post_id, 'gallery_metabox' );
        }
    }
}
if (class_exists('Apr_Metabox')) {
    new Apr_Metabox;
};
require_once(APR_CORE_SERVER_PATH . '/includes/metabox/class-header-metabox.php');
require_once(APR_CORE_SERVER_PATH . '/includes/metabox/class-post-metabox.php');
require_once(APR_CORE_SERVER_PATH . '/includes/metabox/class-product-metabox.php');
require_once(APR_CORE_SERVER_PATH . '/includes/metabox/class-portfolio-metabox.php');