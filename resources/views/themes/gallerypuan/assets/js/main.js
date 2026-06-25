$(function () {
    /*=======================
                UI Slider Range JS
    =========================*/
    // KITA CEK DULU APAKAH ELEMEN SLIDER ADA DI HALAMAN INI
    if ($("#slider-range").length > 0) {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1000000,
            values: [$("#min_price").val() || 0, $("#max_price").val() || 1000000],
            slide: function (event, ui) {
                $("#amount").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("#amount").val($("#slider-range").slider("values", 0) +
            " - " + $("#slider-range").slider("values", 1));
    }

    /*=======================
                Checkout - Courier Selection
    =========================*/
    $('.delivery-address').change(function(){
        $('.courier-code').removeAttr('checked');
        $('.available-services').hide();
    });

    $('.courier-code').click(function(){
        let courier = $(this).val();
        let addressID = $('.delivery-address:checked').val();

        $.ajax({
            url: "/orders/shipping-fee",
            method: "POST",
            data: {
                address_id: addressID,
                courier: courier,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('.available-services').show();
                $('.available-services').html(result);
            },
            error: function(e) {
                console.log(e);
            }
        });
    });
});