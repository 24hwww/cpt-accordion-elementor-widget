<?php
/**
 * Elementor CPT Tab Widget
 * 
 * Widget que muestra pestañas basadas en taxonomías con listados de posts
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Elementor_Cpt_Tab extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'cpt_tab';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'CPT Tab', 'cpt-tab' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'tab', 'tabs', 'taxonomy', 'post', 'cpt' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

        // Sección de Contenido
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Contenido', 'cpt-tab' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Control para seleccionar taxonomía
        $this->add_control(
            'taxonomy',
            [
                'label' => esc_html__( 'Taxonomía', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_taxonomies_options(),
                'default' => 'category',
                'label_block' => true,
            ]
        );

        // Control para seleccionar número de posts
        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Posts por página', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 5,
            ]
        );

        // Control para ordenar posts
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Ordenar por', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__( 'Fecha', 'cpt-tab' ),
                    'title' => esc_html__( 'Título', 'cpt-tab' ),
                    'rand' => esc_html__( 'Aleatorio', 'cpt-tab' ),
                    'menu_order' => esc_html__( 'Orden del menú', 'cpt-tab' ),
                ],
            ]
        );

        // Control para dirección de orden
        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Orden', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__( 'Descendente', 'cpt-tab' ),
                    'ASC' => esc_html__( 'Ascendente', 'cpt-tab' ),
                ],
            ]
        );

        $this->end_controls_section();

        // Sección de Estilo para las Pestañas
        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => esc_html__( 'Pestañas', 'cpt-tab' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Control para el color del texto de las pestañas
        $this->add_control(
            'tab_color',
            [
                'label' => esc_html__( 'Color del texto', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cpt-tab-title' => 'color: {{VALUE}};',
                ],
                'default' => '#333333',
            ]
        );

        // Control para el color de fondo de las pestañas
        $this->add_control(
            'tab_background_color',
            [
                'label' => esc_html__( 'Color de fondo', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cpt-tab-title' => 'background-color: {{VALUE}};',
                ],
                'default' => '#f5f5f5',
            ]
        );

        // Control para el color del texto de la pestaña activa
        $this->add_control(
            'active_tab_color',
            [
                'label' => esc_html__( 'Color del texto (activo)', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cpt-tab-title.active' => 'color: {{VALUE}};',
                ],
                'default' => '#ffffff',
            ]
        );

        // Control para el color de fondo de la pestaña activa
        $this->add_control(
            'active_tab_background_color',
            [
                'label' => esc_html__( 'Color de fondo (activo)', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cpt-tab-title.active' => 'background-color: {{VALUE}};',
                ],
                'default' => '#0073aa',
            ]
        );

        $this->end_controls_section();

        // Sección de Estilo para el Contenido
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__( 'Contenido', 'cpt-tab' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Control para el color del texto del contenido
        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Color del texto', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cpt-tab-content' => 'color: {{VALUE}};',
                ],
                'default' => '#333333',
            ]
        );

        // Control para el color de fondo del contenido
        $this->add_control(
            'content_background_color',
            [
                'label' => esc_html__( 'Color de fondo', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cpt-tab-content' => 'background-color: {{VALUE}};',
                ],
                'default' => '#ffffff',
            ]
        );

        // Control para el padding del contenido
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'cpt-tab' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .cpt-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Obtener opciones de taxonomías disponibles
     */
    private function get_taxonomies_options() {
        $options = [];
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        
        if (!empty($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                $options[$taxonomy->name] = $taxonomy->label;
            }
        }
        
        return $options;
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Obtener la taxonomía seleccionada
        $taxonomy = $settings['taxonomy'] ?? 'category';
        
        // Obtener términos de la taxonomía
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ]);
        
        if (empty($terms) || is_wp_error($terms)) {
            echo esc_html__('No se encontraron términos para esta taxonomía.', 'cpt-tab');
            return;
        }
        
        // ID único para este widget
        $widget_id = $this->get_id();
        
        // Generar HTML para las pestañas
        ?>
        <div class="cpt-tabs-widget" id="cpt-tabs-<?php echo esc_attr($widget_id); ?>">
            <div class="cpt-tabs-titles">
                <?php 
                $first = true;
                foreach ($terms as $index => $term) : 
                    $active_class = $first ? 'active' : '';
                    $first = false;
                ?>
                    <div class="cpt-tab-title <?php echo esc_attr($active_class); ?>" 
                         data-tab="<?php echo esc_attr($term->slug); ?>">
                        <?php echo esc_html($term->name); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cpt-tabs-contents">
                <?php 
                $first = true;
                foreach ($terms as $index => $term) : 
                    $active_class = $first ? 'active' : '';
                    $first = false;
                    
                    // Consulta para obtener posts de este término
                    $args = [
                        'post_type' => 'post',
                        'posts_per_page' => $settings['posts_per_page'],
                        'orderby' => $settings['orderby'],
                        'order' => $settings['order'],
                        'tax_query' => [
                            [
                                'taxonomy' => $taxonomy,
                                'field' => 'term_id',
                                'terms' => $term->term_id,
                            ],
                        ],
                    ];
                    
                    $query = new \WP_Query($args);
                ?>
                    <div class="cpt-tab-content <?php echo esc_attr($active_class); ?>" 
                         data-tab="<?php echo esc_attr($term->slug); ?>">
                        
                        <?php if ($query->have_posts()) : ?>
                            <ul class="cpt-tab-posts">
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <li class="cpt-tab-post">
                                        <a href="<?php the_permalink(); ?>" class="cpt-tab-post-link">
                                            <?php the_title(); ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else : ?>
                            <p><?php echo esc_html__('No hay posts para mostrar.', 'cpt-tab'); ?></p>
                        <?php endif; ?>
                        
                        <?php wp_reset_postdata(); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <style>
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tabs-titles {
                display: flex;
                flex-wrap: wrap;
                margin-bottom: 0;
            }
            
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-title {
                padding: 10px 15px;
                margin-right: 5px;
                cursor: pointer;
                border-radius: 5px 5px 0 0;
                transition: all 0.3s ease;
            }
            
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tabs-contents {
                border: 1px solid #ddd;
                border-radius: 0 5px 5px 5px;
            }
            
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-content {
                display: none;
            }
            
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-content.active {
                display: block;
            }
            
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-posts {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-post {
                padding: 8px 0;
                border-bottom: 1px solid #eee;
            }
            
            #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-post:last-child {
                border-bottom: none;
            }
            
            /* Estilos para modo acordeón en móviles */
            @media (max-width: 767px) {
                #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tabs-titles {
                    display: block;
                    width: 100%;
                }
                
                #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-title {
                    display: block;
                    width: 100%;
                    margin-right: 0;
                    margin-bottom: 1px;
                    border-radius: 5px;
                    position: relative;
                }
                
                #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-title:after {
                    content: '+';
                    position: absolute;
                    right: 15px;
                    top: 50%;
                    transform: translateY(-50%);
                    font-size: 20px;
                    font-weight: bold;
                }
                
                #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-title.active:after {
                    content: '-';
                }
                
                #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tabs-contents {
                    border: none;
                }
                
                #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-content {
                    margin-bottom: 10px;
                    border: 1px solid #ddd;
                    border-top: none;
                    border-radius: 0 0 5px 5px;
                }
                
                #cpt-tabs-<?php echo esc_attr($widget_id); ?> .cpt-tab-content.active {
                    display: block;
                }
            }
        </style>
        
        <script>
        jQuery(document).ready(function($) {

            function isMobile() {
                return window.innerWidth <= 767;
            }
            

            function initTabsAccordion() {
                var $widget = $('#cpt-tabs-<?php echo esc_attr($widget_id); ?>');
                var $tabs = $widget.find('.cpt-tab-title');
                var $contents = $widget.find('.cpt-tab-content');
                
                if (!isMobile() && !$tabs.filter('.active').length) {
                    $tabs.first().addClass('active');
                    $contents.first().addClass('active');
                }
                

                $tabs.off('click');
                

                $tabs.on('click', function(e) {
                    e.preventDefault();
                    var tabId = $(this).data('tab');
                    console.log('Tab clicked:', tabId); 
                    
                    if (!isMobile()) {

                        $tabs.removeClass('active');
                        $(this).addClass('active');
                        
                        $contents.removeClass('active');
                        $widget.find('.cpt-tab-content[data-tab="' + tabId + '"]').addClass('active');
                        console.log('Desktop mode - showing tab:', tabId); 
                    } else {

                        if ($(this).hasClass('active')) {
                            $(this).removeClass('active');
                            $widget.find('.cpt-tab-content[data-tab="' + tabId + '"]').removeClass('active');
                            console.log('Mobile mode - hiding tab:', tabId); 
                        } else {
                            $(this).addClass('active');
                            $widget.find('.cpt-tab-content[data-tab="' + tabId + '"]').addClass('active');
                            console.log('Mobile mode - showing tab:', tabId);
                        }
                    }
                });
            }
            

            setTimeout(function() {
                initTabsAccordion();
                console.log('Tabs initialized'); 
            }, 100);
            

            var resizeTimer;
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    initTabsAccordion();
                    console.log('Tabs reinitialized after resize');
                }, 250);
            });
        });
        </script>
        <?php
    }
}