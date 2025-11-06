class Cart {

    constructor() {
        this.selectorWrapperCart = $('.cart-wrapper');
        this.cartItem = '.cart-item';
    }
    addToCart($this) {
        event.preventDefault();
        let url = $this.data('url');
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function($data) {
                if ($data.code === 200) {
                    alert('add to cart success');
                } else {
                    alert('add to cart error');
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
                } else {
                    alert('add to cart error');
                }
            },
            error: function() {

            }
        });
    }

    removeCart($this) {
        event.preventDefault();
        let url = $this.data('url');
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(data) {
                if (data.code === 200) {
                    $('.cart-wrapper').html(data.htmlcart);
                    $('#total-price-cart').text(data.totalPrice);
                   Swal.fire({
                        icon: "success",
                        title: "Xóa sản phẩm khỏi giỏ hàng thành công!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Xóa sản phẩm khỏi giỏ hàng thất bại!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Xóa sản phẩm khỏi giỏ hàng thất bại!",
                    showConfirmButton: false,
                    timer: 1500,
                });
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
                    $('#total-price-cart').text(data.totalPrice);
                    alert('clear cart success');
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
                // alert('add to cart success');
            } else {
                alert('add to cart error');
            }
        },
        error: function() {

        }
    });
});