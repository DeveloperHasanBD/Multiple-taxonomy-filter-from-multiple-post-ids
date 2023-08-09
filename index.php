
<div class="imp_shop_page_design">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <div class="imp-shop-left-sidebar">
                    <div class="advance_left_pro_filter">

                        <?php


                        // start filter taxonomy 
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

                        $product_cat = $_GET['cat-ids'] ?? '';
                        $product_cat_ids = array();
                        if ($product_cat) {
                            $product_cats = explode(",", $product_cat);
                            $product_cat_query = [
                                'post_type'         => 'product',
                                'post_status'       => 'publish',
                                'posts_per_page'    => -1,
                                'tax_query' => [
                                    [
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $product_cats
                                    ]
                                ]
                            ];
                            $product_cat_posts = new WP_Query($product_cat_query);
                            $product_cat_ids   = $product_cats;
                            $post_ids          = wp_list_pluck($product_cat_posts->posts, 'ID');
                            $selected_terms    = wp_get_object_terms($post_ids, $taxonomy_name);
                        }


                        $filter_inc = 1;
                        ?>
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <form id="lattu_ajax_form">
                                <?php

                                if (count($product_cat_ids) == 0) {
                                    foreach ($filter_taxonomies as $single_taxo) {
                                        $final_inc              = $filter_inc++;
                                        $single_taxo_name       = $single_taxo['taxonomy_name'];
                                        $single_taxo_heading    = $single_taxo['heading'];

                                        $get_terms = get_terms(array(
                                            'taxonomy'   => $single_taxo_name,
                                            'hide_empty' => true,
                                        ));
                                ?>


                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading_<?php echo $final_inc; ?>">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_<?php echo $final_inc; ?>" aria-expanded="false" aria-controls="flush-collapse_<?php echo $final_inc; ?>">
                                                    <?php echo $single_taxo_heading; ?>
                                                </button>
                                            </h2>
                                            <div id="flush-collapse_<?php echo $final_inc; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading_<?php echo $final_inc; ?>" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <div class="advance_single_item">
                                                        <ul style="padding: 0px;margin-left: 0px;margin-right: 0px;list-style: none;">

                                                            <?php
                                                            foreach ($get_terms as $single_term) {
                                                                $single_term_id     = $single_term->term_id;
                                                                $single_term_name   = $single_term->name;

                                                            ?>
                                                                <li>
                                                                    <div class="">
                                                                        <input type="checkbox" class="form-check-input product_cat_filter" taxonomy_name="<?php echo $single_taxo_name; ?>" name="<?php echo $single_taxo_name; ?>[]" value="<?php echo $single_term_id; ?>" id="product_cat_filter_<?php echo $single_term_id; ?>">
                                                                        <label taxonomy_name="<?php echo $single_taxo_name; ?>" class="" for="product_cat_filter_<?php echo $single_term_id; ?>"><span class="advance_label_text"><?php echo $single_term_name; ?> (<?php echo $single_term->count; ?>)</span></label>
                                                                    </div>
                                                                </li>

                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                <?php } else {
                                    $get_product_cat_terms = get_terms(array(
                                        'taxonomy'   => 'product_cat',
                                        'hide_empty' => true,
                                    ));

                                ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-heading_1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_1" aria-expanded="true" aria-controls="flush-collapse_1">
                                                Filter by series
                                            </button>
                                        </h2>
                                        <div id="flush-collapse_1" class="accordion-collapse collapse show" aria-labelledby="flush-heading_1" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="advance_single_item">
                                                    <ul style="padding: 0px;margin-left: 0px;margin-right: 0px;list-style: none;">
                                                        <?php
                                                        foreach ($get_product_cat_terms as $get_product_cat_term) {
                                                            $checked = '';
                                                            $single_term_id     = $get_product_cat_term->term_id;
                                                            $single_term_name   = $get_product_cat_term->name;
                                                            $single_term_count  = $get_product_cat_term->count;
                                                            if (in_array($single_term_id, $product_cats)) {
                                                                $checked = 'checked';
                                                            }
                                                        ?>
                                                            <li>
                                                                <div class="">
                                                                    <input type="checkbox" <?php echo $checked; ?> taxonomy_name="product_cat" class="form-check-input product_cat_filter" name="product_cat[]" value="<?php echo $single_term_id ?>" id="product_cat_filter_<?php echo $single_term_id ?>">
                                                                    <label taxonomy_name="product_cat" class="" for="product_cat_filter_<?php echo $single_term_id ?>"><span class="advance_label_text"><?php echo $single_term_name ?> (<?php echo $single_term_count ?>)</span></label>
                                                                </div>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $filter_inc = 2;
                                    foreach ($filter_taxonomies as $key => $taxonomy) {
                                        $taxonomy_name      = $taxonomy['taxonomy_name'];
                                        $taxonomy_heading   = $taxonomy['heading'];

                                        if ($taxonomy_name != 'product_cat') {
                                            $final_inc                                  = $filter_inc++;

                                            $selected_terms = wp_get_object_terms($post_ids, $taxonomy_name);
                                            if (count($selected_terms) > 0) {

                                    ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-heading_<?php echo $final_inc ?>">
                                                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_<?php echo $final_inc ?>" aria-expanded="false" aria-controls="flush-collapse_<?php echo $final_inc ?>">
                                                            <?php echo $taxonomy_heading ?>
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapse_<?php echo $final_inc ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading_<?php echo $final_inc ?>" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <div class="advance_single_item">
                                                                <ul style="padding: 0px;margin-left: 0px;margin-right: 0px;list-style: none;">
                                                                    <?php
                                                                    $o_product_cats = $_POST[$taxonomy_name] ?? array();
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
                                                                    ?>
                                                                            <li>
                                                                                <div class="">
                                                                                    <input type="checkbox" <?php echo $checked ?> taxonomy_name="<?php echo $taxonomy_name ?>" class="form-check-input product_cat_filter" name="<?php echo $taxonomy_name ?>[]" value="<?php echo $single_term_id ?>" id="product_cat_filter_<?php echo $single_term_id ?>">
                                                                                    <label taxonomy_name="<?php echo $taxonomy_name ?>" class="" for="product_cat_filter_<?php echo $single_term_id ?>"><span class="advance_label_text"><?php echo $single_term_name ?> (<?php echo count($single_term_post_ids) ?>)</span></label>
                                                                                </div>
                                                                            </li>
                                                                    <?php }
                                                                    } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php }
                                        }
                                    } ?>
                                <?php } ?>
                            </form>
                        </div>

                          <div class="reset_srch_filter">
                            <a href="<?php echo site_url();?>/ricerca-avanzata">Reset filter</a>
                        </div>

                        <?php

                        // end filter taxonomy 



                        ?>
                    </div>
                    
                    <?php
                    if (is_active_sidebar('shop-sidebar')) {
                        // dynamic_sidebar('shop-sidebar');
                    }
                    ?>

                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
              <div class="imp-shop-page-design">
                    <?php


                    if (count($product_cat_ids) > 0) {
                    ?>
                        <div class="container-fluid">
                            <div class="row display_serie_product">
                                <?php
                                $sft_product_cat_ids = array();

                                if ($product_cat_posts->have_posts()) {
                                    while ($product_cat_posts->have_posts()) {
                                        $product_cat_posts->the_post();
                                        wc_get_template_part('content', 'product');
                                    }
                                } else {
                                    do_action('woocommerce_no_products_found');
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    } else {
                        if (woocommerce_product_loop()) {

                            /**
                             * Hook: woocommerce_before_shop_loop.
                             *
                             * @hooked woocommerce_output_all_notices - 10
                             * @hooked woocommerce_result_count - 20
                             * @hooked woocommerce_catalog_ordering - 30
                             */
                            do_action('woocommerce_before_shop_loop');

                            woocommerce_product_loop_start();

                            if (wc_get_loop_prop('total')) {
                                while (have_posts()) {
                                    the_post();

                                    /**
                                     * Hook: woocommerce_shop_loop.
                                     */
                                    do_action('woocommerce_shop_loop');

                                    wc_get_template_part('content', 'product');
                                }
                            }

                            woocommerce_product_loop_end();

                            /**
                             * Hook: woocommerce_after_shop_loop.
                             *
                             * @hooked woocommerce_pagination - 10
                             */
                            do_action('woocommerce_after_shop_loop');
                        } else {
                            /**
                             * Hook: woocommerce_no_products_found.
                             *
                             * @hooked wc_no_products_found - 10
                             */

                            do_action('woocommerce_no_products_found');
                        }
                    }
                    /**
                     * Hook: woocommerce_after_main_content.
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action('woocommerce_after_main_content');

                    /**
                     * Hook: woocommerce_sidebar.
                     *
                     * @hooked woocommerce_get_sidebar - 10
                     */

                    do_action('woocommerce_sidebar');

                    get_footer('shop');
                    ?>


                </div>
            </div>
                   


                   
                   
