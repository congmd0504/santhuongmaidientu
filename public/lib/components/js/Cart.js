class Cart {

    constructor() {
        this.selectorWrapperCart = $('.cart-wrapper');
        this.cartItem = '.cart-item';
    }
    addToCart($this) {
        event.preventDefault();
        let url = $this.data('url');
        let swalOption = {
            //  title: "test",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý !',
            cancelButtonText: 'Hủy'
        }

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function($data) {
                if ($data.code === 200) {

                    swalOption.title = "Thêm sản phẩm vào giỏ hàng thành công. Bạn có muốn đi đến giỏ hàng ngay ?";
                    swalOption.icon = 'success';

                    Swal.fire(swalOption).then((result) => {
                        if (result.isConfirmed) {
                            //let hostname = window.location.hostname;
                            window.location.href = "/cart/list";

                        }
                    })
                } else {
                    swalOption.title = "Thêm sản phẩm vào giỏ hàng thất bại. Bạn có muốn đi đến giỏ hàng ngay ?";
                    Swal.fire(swalOption).then((result) => {
                        if (result.isConfirmed) {
                            //let hostname = window.location.hostname;
                            window.location.href = "/cart/list";
                        }
                    })
                }
            },
            error: function() {

            }
        });



    }
    updateCart($this) {
        event.preventDefault();
        let url = $this.data('url');
        let quantity = $this.parents('.cart-item').find("input[name='quantity']").val();
        $.ajax({
            type: "GET",
            url: url,
            data: {
                'quantity': quantity
            },
            dataType: "json",
            success: function(data) {
                if (data.code === 200) {
                    $('.cart-wrapper').html(data.htmlcart);
                    $('#total-price-cart').text(data.totalPrice);
                    alert('add to cart success');
                    location.reload();
                } else {
                    alert('add to cart error');
                }
            },
            error: function() {

            }
        });
    }
    applyCodeSale($this) {
        event.preventDefault();
        let url = $this.data('url');
        let value = $("#jsApplyCodeSale").val();
        let usePoint = $("#usePoint").val();
        $.ajax({
            type: "GET",
            url: url,
            data: {
                'code': value,
                'usePoint': usePoint,
                'useMoney': useMoney,
            },
            dataType: "json",
            success: function(data) {
                if (data.code === 200) {
                    $('.cart-wrapper').html(data.htmlcart);
                    $('#total-price-cart').text(data.totalPrice);
                    // alert('');
                    location.reload();
                } else {
                    alert('Đã có lỗi xảy ra');
                }
            },
            error: function() {

            }
        });
    }

    removeCart($this) {
        event.preventDefault();
        let url = $this.data('url');
        let usePoint = $('#usePoint').val();
        if (usePoint) {
            usePoint = parseFloat(usePoint);
        } else {
            usePoint = 0;
        }
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            data: {
                'usePoint': usePoint
            },
            success: function(data) {
                if (data.code === 200) {
                    $('.cart-wrapper').html(data.htmlcart);
                    // $('#total-price-cart').text(data.totalPrice);
                    alert('remove cart success');
                    location.reload();
                } else {
                    alert('remove cart error');
                }
            },
            error: function() {

            }
        });
    }

    clearCart($this) {
        event.preventDefault();
        let url = $this.data('url');
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(data) {
                if (data.code === 200) {
                    console.log(data.htmlcart);
                    $('.cart-wrapper').html(data.htmlcart);
                    //  $('#total-price-cart').text(data.totalPrice);
                    alert('clear cart success');
                    location.reload();
                } else {
                    alert('clear cart error');
                }
            },
            error: function() {

            }
        });
    }

}

let cart = new Cart();
$(document).on('click', '.add-to-cart', function() {
    $this = $(this);
    cart.addToCart($this);
})
$(document).on('click', '.jsBtnApplyCodeSale', function() {
    $this = $("#jsApplyCodeSale");
    cart.applyCodeSale($this);
})
$(document).on('change', '#jsApplyCodeSale', function() {
    $this = $(this);
    if(!$this.val()) {
        cart.applyCodeSale($this);
    }
})
$(document).on('click', '.update-cart', function() {
    $this = $(this);
    cart.updateCart($this);
})
$(document).on('click', '.remove-cart', function() {
    $this = $(this);
    cart.removeCart($this);
})
$(document).on('click', '.clear-cart', function() {
    $this = $(this);
    cart.clearCart($this);
})
$(document).on('click', '.quantity-cart .prev-cart', function() {
    let input = $(this).parents('.quantity-cart').find("input[type='number']");
    let value = parseFloat(input.val()) - 1;
    if (value < 1) {
        input.val(1);
    } else {
        input.val(value);
    }
    input.trigger('change');
})
$(document).on('click', '.quantity-cart .next-cart', function() {
    let input = $(this).parents('.quantity-cart').find("input[type='number']");
    let value = parseFloat(input.val()) + 1;
    input.val(value);
    input.trigger('change');
})
$(document).on('change', '.number-cart', function() {
    let url = $(this).data('url');
    let quantity = $(this).parents('.cart-item').find("input[name='quantity']").val();
    let usePoint = $('#usePoint').val();
    if (usePoint) {
        usePoint = parseFloat(usePoint);
    } else {
        usePoint = 0;
    }
    $.ajax({
        type: "GET",
        url: url,
        data: {
            'quantity': quantity,
            'usePoint': usePoint
        },
        dataType: "json",
        success: function(data) {
            if (data.code === 200) {
                $('.cart-wrapper').html(data.htmlcart);
                // $('#total-price-cart').text(data.totalPrice);
                // $('#total-price-money-cart').text(data.totalPriceMoney);
                // $('#total-price-point-cart').text(data.totalPricePoint);
                // alert('add to cart success');
                location.reload();
            } else {
                alert('add to cart error');
            }
        },
        error: function() {

        }
    });
});
$(document).on('change', '#usePoint', function() {
    let url = $(this).data('url');
    let usePoint = parseFloat($(this).val());
    if (usePoint) {
        usePoint = parseFloat(usePoint);
    } else {
        usePoint = 0;
    }
    $.ajax({
        type: "GET",
        url: url,
        data: {
            'usePoint': usePoint
        },
        dataType: "json",
        success: function(data) {
            if (data.code === 200) {
                $('.cart-wrapper').html(data.htmlcart);
                // $('#total-price-cart').text(data.totalPrice);
                // $('#total-price-money-cart').text(data.totalPriceMoney);
                // $('#total-price-point-cart').text(data.totalPricePoint);
                // alert('add to cart success');
            } else {
                alert('update cart error');
            }
        },
        error: function() {

        }
    });
});
