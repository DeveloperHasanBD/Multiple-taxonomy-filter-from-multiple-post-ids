var url = action_url_ajax.ajax_url;
 
 
         $("body").delegate(".product_cat_filter", "click", function(e){
             let taxonomy_name = $(this).attr('taxonomy_name');
             
            // e.preventDefault();
            let spinner =   `<div class="col-md-12 text-center">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>`;
            $('.display_serie_product').html(spinner)
            var form = new FormData($('#lattu_ajax_form')[0]);
            form.append("action", 'lattu_product_cat_filter_action');
            form.append("taxonomy_name", taxonomy_name);
            jQuery.ajax({
                type: 'POST',
                url: url,
                data: form,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function (data, textStatus, XMLHttpRequest) {
                    console.log(data);
                    if (data.error == true) {
                        // alert(data.message);
                    } else {
                        $("#lattu_ajax_form").html(data.sidebar);
                        $(".display_serie_product").html(data.products);
                    }
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
    
            });
        });
 
