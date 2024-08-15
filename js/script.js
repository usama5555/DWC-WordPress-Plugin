jQuery(document).ready(function($){
    $(".single_category a").on("click", function(e){
        e.preventDefault();
        var cat_id = $(this).attr('category_id');
        // alert(cat_id);

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'load_products_by_cat',
                nonce: ajax_object.nonce,
                category_id: cat_id,
            },
            success: function(response){
                
                $('#product-container').html(response.data);
                $('.products-main').css('display', 'block');

                $('.categories').css('display', 'none');
            }
        });
    });

    $("#back-btn").on('click', function(){
        $(".products-main").css('display', 'none');
        $('.categories').css('display', 'block');
    })
});
