<?php
namespace Elementor;
if (!defined('ABSPATH')) exit;
if (class_exists('WooCommerce')) {
    class Apr_Core_Category_dropdown extends Widget_Base{
        public function get_name()
        {
            return 'apr_category_dropdown';
        }
        public function get_title()
        {
            return __('APR Category Dropdown', '');
        }
        public function get_icon()
        {
            return 'eicon-bullet-list';
        }

        public function get_categories()
        {
            return array('apr-core');
        }

        protected function _register_controls()
        {
            $this->start_controls_section(
                'category_dropdown_section',
                [
                    'label' => __('Query', 'apr-core')
                ]
            );

            $this->add_control(
                'category-toggle-title',
                [
                    'label'   => __('Title Toggle', 'apr-core'),
                    'default' => 'Select category',
                    'type'    => Controls_Manager::TEXT,
                ]
            );
            $this->end_controls_section();
        }
        protected function render()
        {
            $settings = $this->get_settings();
            ?>
            <div class="category-dropdown">
                <div class="chosen-single">
                    <i class="menu-burger fa fa-bars"></i>
                    <span class="menu-open-label"><?php echo $settings['category-toggle-title']; ?></span>
                    <span class="arrow-opener"></span>
                </div>
                <?php
                $args = array(
                    'order'      => 'ASC',
                    'hide_empty'=> 0,
                    'taxonomy'=> 'product_cat',
                    'posts_per_page' =>'-1'
                );
                $terms = get_terms( 'product_cat', $args );
                if ( $terms ) {
                    echo '<ul class="list-cate">';
                    foreach ($terms as $term) {
                        ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>"
                               title="<?php echo esc_attr($term->name) ?>"><?php echo esc_attr($term->name) ?></a>
                        </li>
                        <?php
                    }
                    echo '</ul>';
                }
                ?>
            </div>
            <?php
        }
    }
    Plugin::instance()->widgets_manager->register_widget_type(new Apr_Core_Category_dropdown);
}
