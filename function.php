<?php 

add_action('wp_ajax_lattu_product_cat_filter_action', 'lattu_product_cat_filter_action');
add_action('wp_ajax_nopriv_lattu_product_cat_filter_action', 'lattu_product_cat_filter_action');

function lattu_product_cat_filter_action()
{
    $filter_taxonomies = [
        [
            'taxonomy_name'     => 'product_cat',
            'heading'           => 'Filter by series',
        ],
        [
            'taxonomy_name'     => 'imp_product_cat',
            'heading'           => 'Filter by category',
        ],
        [
            'taxonomy_name'     => 'filtra_per_velocita',
            'heading'           => 'Speed',
        ],
        [
            'taxonomy_name'     => 'filtra_per_dimensioni_minime_lav',
            'heading'           => 'Minimum Glass Size',
        ],
        [
            'taxonomy_name'     => 'filtra_per_spessore_vetro_lavora',
            'heading'           => 'Workable Glass Thickness',
        ],
        [
            'taxonomy_name'     => 'filtra_per_potenza_installata',
            'heading'           => 'Installed Power',
        ],
        [
            'taxonomy_name'     => 'filtra_per_ingombri',
            'heading'           => 'Dimensions',
        ],
        [
            'taxonomy_name'     => 'filtra_per_peso',
            'heading'           => 'Weight',
        ],
        [
            'taxonomy_name'     => 'filtra_per_pesi_caricabili__su_c',
            'heading'           => 'Max Glass Load (on the conveyor)',
        ],
        [
            'taxonomy_name'     => 'filtra_per_pesi_caricabili__tota',
            'heading'           => 'Max Glass Load (total)',
        ],
        [
            'taxonomy_name'     => 'diametro_foratura_1_testa',
            'heading'           => 'Drilling Diameter (1 tip)',
        ],
        [
            'taxonomy_name'     => 'diametro_foratura__2_teste',
            'heading'           => 'Drilling Diameter (2 tip)',
        ],
        [
            'taxonomy_name'     => 'sbraccio',
            'heading'           => 'Outreach',
        ],
    
    ];

    $wp_products_args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
        );
        
    
    
    $wp_term_index = 0;
    
    foreach($filter_taxonomies as $taxonomy)
    {
        $taxonomy_name = $taxonomy['taxonomy_name'];
        $taxonomy_heading = $taxonomy['heading'];
        
        
        if(isset($_POST[$taxonomy_name]))
        {
            $terms_ids = $_POST[$taxonomy_name];
            
            
            $wp_products_args['tax_query'][$wp_term_index] = array(
                'taxonomy' => $taxonomy_name,
                'field'    => 'term_id',
                'terms'    => $terms_ids,
            );
            
            $wp_term_index++;
        }
    }
    
    $post_query = new WP_Query($wp_products_args);
    
    $product_final_terms = array();
    if ($post_query->have_posts()) {
        $post_ids = wp_list_pluck ($post_query->posts, 'ID');

        foreach($filter_taxonomies as $key=>$taxonomy)
        {
            $taxonomy_name = $taxonomy['taxonomy_name'];
            $taxonomy_heading = $taxonomy['heading'];
            
            $product_final_terms[$key]['taxonomy_name'] = $taxonomy_name;
            $product_final_terms[$key]['heading']       = $taxonomy_heading;
            
            $selected_terms = wp_get_object_terms ($post_ids, $taxonomy_name);
            $product_final_terms[$key]['terms']             = $selected_terms;
        }
    }
    
    
    // echo '<pre>';
    // print_r($product_final_terms);
    
    
    // echo '<pre>';
    // print_r($post_query->posts);
    // print_r($_POST);
    // die;
    
    
    
    // $my_terms    = wp_get_object_terms ($my_post_ids, 'imp_product_cat');
    // echo '<pre>';
    // print_r($my_post_ids);
    // print_r($my_terms);
    // print_r($_POST);
    // die;
}
