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

    $click_taxonomy_name = $_POST['taxonomy_name'] ?? '';
    $wp_products_args = array(
        'post_type'         => 'product',
        'post_status'       => 'publish',
        'posts_per_page'    => -1,
    );



    $wp_term_index = 0;

    foreach ($filter_taxonomies as $taxonomy) {
        $taxonomy_name = $taxonomy['taxonomy_name'];
        $taxonomy_heading = $taxonomy['heading'];


        if (isset($_POST[$taxonomy_name])) {
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


    $sidebar_html   = '';
    $products_html  = '';
    $site_url       = site_url();
    if ($post_query->have_posts()) {
        while ($post_query->have_posts()) {
            $post_query->the_post();
            $item_id    = get_the_ID();
            $thumb_url  = get_the_post_thumbnail_url();
            $title      = get_the_title();
            $link       = get_the_permalink();

            $imp_pcsh_section_showhideget   = get_field('imp_pcsh_section_showhide');
            $imp_co_color_picker            = get_field('imp_co_color_picker');
            $show_color = '';
            if ($imp_pcsh_section_showhideget == 1) {

                $show_color .= '<span class="pborder_color" style="background: ' . $imp_co_color_picker . '"></span>';
            }

            $product_sub_name = mb_substr($title, 0, 17);
            $lang = __("Confronta", 'lattuada');
            $lang_2 = __("Scopri la Serie", 'lattuada');

            $products_html .=   '<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" >
                                        <div class="imp_product_design">
                                            <a class="product_url_fix" href="' . $site_url . '/modello/?id=' . $item_id . '"></a>
                                            <img src="' . $thumb_url . '" alt="">
                                            <h2 class="woocommerce-loop-product__title">' . $title . '</h2>
                                            ' . $show_color . '
                                        </div>
                                        <div class="imp_p_c_checkbox_group">
                                            <div class="form-check">
                                                <div class="check-box">
                                                    <input type="checkbox" imp_product_title="' . $product_sub_name . '" imp_product_name="' . $title . '" imp_product_id="' . $item_id . '" name="imp_compare_checkbox" id="imp_compare_checkbox_' . $item_id . '" class="imp_compare_checkbox">
                                                    <label class="form-check-label imp_compare_checkbox_label_' . $item_id . '" for="imp_compare_checkbox_' . $item_id . '" style="color: black;"><span>' . $lang . '</span></label>
                                                </div>
                                            </div>
                                            <div class="snd_btn">
                                                <a href="' . $link . '#scopri">' . $lang_2 . '</a>
                                            </div>
                                        </div>
                                    </div>';
        }
    }

    $get_product_cat_terms = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
    ));


    $collapsed      = 'collapsed';
    $collapsed_ture = false;
    $collapsed_show = '';
    if ($click_taxonomy_name == 'product_cat') {
        $collapsed      = '';
        $collapsed_ture = true;
        $collapsed_show = 'show';
    }
    $sidebar_html .=    '<div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-heading_1">
                                            <button class="accordion-button ' . $collapsed . ' " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1" aria-expanded="' . $collapsed_ture . '" aria-controls="flush-collapse_1">
                                                Filter by series
                                            </button>
                                        </h2>
                                        <div id="flush-collapse_1" class="accordion-collapse collapse ' . $collapsed_show . '" aria-labelledby="flush-heading_1" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="advance_single_item">
                                                    <ul style="padding: 0px;margin-left: 0px;margin-right: 0px;list-style: none;">';

    $product_cats        = $_POST['product_cat'] ?? array();
    foreach ($get_product_cat_terms as $get_product_cat_term) {
        $checked = '';
        $single_term_id     = $get_product_cat_term->term_id;
        $single_term_name   = $get_product_cat_term->name;
        $single_term_count  = $get_product_cat_term->count;
        if (in_array($single_term_id, $product_cats)) {
            $checked = 'checked';
        }

        $sidebar_html .=    '<li>
                                                                                    <div class="">
                                                                                        <input type="checkbox" ' . $checked . ' taxonomy_name="product_cat" class="form-check-input product_cat_filter" name="product_cat[]" value="' . $single_term_id . '" id="product_cat_filter_' . $single_term_id . '">
                                                                                        <label taxonomy_name="product_cat" class="" for="product_cat_filter_' . $single_term_id . '"><span class="advance_label_text">' . $single_term_name . ' (' . $single_term_count . ')</span></label>
                                                                                    </div>
                                                                                </li>';
    }
    $sidebar_html .=                    '</ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';


    $filter_inc = 2;
    $product_final_terms = array();
    if ($post_query->have_posts()) {
        $post_ids = wp_list_pluck($post_query->posts, 'ID');


        foreach ($filter_taxonomies as $key => $taxonomy) {

            $taxonomy_name      = $taxonomy['taxonomy_name'];
            $taxonomy_heading   = $taxonomy['heading'];
            $collapsed      = 'collapsed';
            $collapsed_ture = false;
            $collapsed_show = '';
            if ($click_taxonomy_name == $taxonomy_name) {
                $collapsed      = '';
                $collapsed_ture = true;
                $collapsed_show = 'show';
            }
            if ($taxonomy_name != 'product_cat') {
                $final_inc                                  = $filter_inc++;
                $product_final_terms[$key]['taxonomy_name'] = $taxonomy_name;
                $product_final_terms[$key]['heading']       = $taxonomy_heading;

                $selected_terms = wp_get_object_terms($post_ids, $taxonomy_name);
                $product_final_terms[$key]['terms']             = $selected_terms;
                if (count($selected_terms) > 0) {
                    $sidebar_html .=    '<div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-heading_' . $final_inc . '">
                                            <button class="accordion-button ' . $collapsed . ' " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_' . $final_inc . '" aria-expanded="' . $collapsed_ture . '" aria-controls="flush-collapse_' . $final_inc . '">
                                                ' . $taxonomy_heading . '
                                            </button>
                                        </h2>
                                        <div id="flush-collapse_' . $final_inc . '" class="accordion-collapse collapse ' . $collapsed_show . '" aria-labelledby="flush-heading_' . $final_inc . '" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="advance_single_item">
                                                    <ul style="padding: 0px;margin-left: 0px;margin-right: 0px;list-style: none;">';

                    $o_product_cats        = $_POST[$taxonomy_name] ?? array();
                    foreach ($selected_terms as $selected_term) {
                        $checked            = '';
                        $single_term_id     = $selected_term->term_id;
                        $single_term_name   = $selected_term->name;
                        $single_term_count  = $selected_term->count;

                        $single_term_args = [
                            'post_type'         => 'product',
                            'post_status'       => 'publish',
                            'posts_per_page'    => -1,
                            'tax_query' => [
                                [
                                    'taxonomy' => $taxonomy_name,
                                    'field' => 'term_id',
                                    'terms' => $single_term_id
                                ]
                            ]
                        ];
                        $single_terms_posts = new WP_Query($single_term_args);
                        $single_term_post_ids = array();
                        if ($single_terms_posts->have_posts()) {
                            $single_term_post_ids = wp_list_pluck($single_terms_posts->posts, 'ID');

                            $single_term_post_ids = array_intersect($post_ids, $single_term_post_ids);
                        }

                        if (in_array($single_term_id, $o_product_cats)) {
                            $checked = 'checked';
                        }
                        if (count($single_term_post_ids) > 0) {
                            $sidebar_html .=    '<li>
                                                                                    <div class="">
                                                                                        <input type="checkbox" ' . $checked . ' taxonomy_name="' . $taxonomy_name . '" class="form-check-input product_cat_filter" name="' . $taxonomy_name . '[]" value="' . $single_term_id . '" id="product_cat_filter_' . $single_term_id . '">
                                                                                        <label taxonomy_name="' . $taxonomy_name . '" class="" for="product_cat_filter_' . $single_term_id . '"><span class="advance_label_text">' . $single_term_name . ' (' . count($single_term_post_ids) . ')</span></label>
                                                                                    </div>
                                                                                </li>';
                        }
                    }
                    $sidebar_html .=                    '</ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                }
            }
        }
    }

    $response['error']      = false;
    $response['message']    = 'success';
    $response['sidebar']    = $sidebar_html;
    $response['products']   = $products_html;

    echo json_encode($response);
    die;
}


