<?php
class ElementorContentIntegrator {

    public function __construct() {
        // Attachez vos fonctions aux hooks appropriés d'Elementor
        add_action('elementor/widgets/widgets_registered', [$this, 'on_widgets_registered']);
    }

    public function on_widgets_registered() {
        require_once('path/to/your/custom-widget.php'); // Assurez-vous de mettre le chemin correct vers votre fichier de widget personnalisé
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Custom_Widget());
    }
}

// Classe de widget personnalisée pour Elementor
class Elementor_Custom_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_elementor_widget';
    }

    public function get_title() {
        return __('Custom Elementor Widget', 'elementor-content-integrator');
    }

    public function get_icon() {
        return 'eicon-text-area';
    }

    protected function _register_controls() {
        
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'elementor-content-integrator'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'elementor-content-integrator'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __('Enter your title here', 'elementor-content-integrator'),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __('Text', 'elementor-content-integrator'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Enter your text', 'elementor-content-integrator'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'elementor-content-integrator'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['image']['url'])) {
            echo '<img src="' . esc_url($settings['image']['url']) . '" alt="' . esc_attr(get_post_meta($settings['image']['id'], '_wp_attachment_image_alt', true)) . '">';
        }
        
        if (!empty($settings['title'])) {
            echo '<h2>' . esc_html($settings['title']) . '</h2>';
        }
        
        if (!empty($settings['text'])) {
            echo '<p>' . esc_html($settings['text']) . '</p>';
        }
    }
}

new ElementorContentIntegrator();
