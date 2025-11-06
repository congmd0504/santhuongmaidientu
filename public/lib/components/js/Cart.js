class Cart {
    constructor() {
        this.selectorWrapperCart = $(".cart-wrapper");
        this.cartItem = ".cart-item";
    }
    addToCart($this) {
        event.preventDefault();
        let url = $this.data("url");

        let swalOption = {
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng ý!",
            cancelButtonText: "Hủy",
        };

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                if (response.code === 200) {
                    swalOption.title =
                        "Thêm sản phẩm vào giỏ hàng thành công. Bạn có muốn đi đến giỏ hàng ngay?";
                    swalOption.icon = "success";
                    Swal.fire(swalOption).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/cart/list";
                        }
                    });
                } else {
                    swalOption.title = response.message ||
                    "Thêm sản phẩm vào giỏ hàng thất bại.";
                    swalOption.icon = "error";
                    Swal.fire(swalOption);
                }
            },
            error: function (xhr) {
                let res = xhr.responseJSON;
                if (res && res.message) {
                    swalOption.title = res.message;
                } else {
                    swalOption.title = "Đã xảy ra lỗi không xác định. Vui lòng thử lại!";
                }
                Swal.fire({
                    title: swalOption.title,
                    icon: swalOption.icon,
                    showConfirmButton: false,
                    timer: 1500,
                });
            },
        });
    }

    updateCart($this) {
        event.preventDefault();
        let url = $this.data("url");
        let quantity = $this
            .parents(".cart-item")
            .find("input[name='quantity']")
            .val();
        $.ajax({
            type: "GET",
            url: url,
            data: {
                quantity: quantity,
            },
            dataType: "json",
            success: function (data) {
                if (data.code === 200) {
                    $(".cart-wrapper").html(data.htmlcart);
                    $("#total-price-cart").text(data.totalPrice);
                    alert("add to cart success");
                    location.reload();
                } else {
                    alert("add to cart error");
                }
            },
            error: function () {},
        });
    }
    
    applyCodeSale($this) {
        let url = $this.data("url");
        let value = $("#jsApplyCodeSale").val();
        let usePoint = $("#usePoint").val() || 0;
        let useMoney = $("#useMoney").val() || 0; // ✅ thêm biến này

        $.ajax({
            type: "GET",
            url: url,
            data: {
                code: value,
                usePoint: usePoint,
                useMoney: useMoney,
            },
            dataType: "json",
            success: function (data) {
                if (data.code === 200) {
                    $(".cart-wrapper").html(data.htmlcart);
                    $("#total-price-cart").text(data.totalPrice);

                    // ❌ KHÔNG reload tại đây!
                    // location.reload();

                    // ✅ Thay vì reload toàn trang, chỉ cập nhật phần cần thiết
                    // Ví dụ: cập nhật tổng tiền, hoặc hiện thông báo
                    Swal.fire({
                        icon: "success",
                        title: "Mã giảm giá áp dụng thành công!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Mã không hợp lệ hoặc đã hết hạn!",
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Không thể kết nối máy chủ.",
                });
            },
        });
    }

    removeCart($this) {
        event.preventDefault();
        let url = $this.data("url");
        let usePoint = $("#usePoint").val();
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
                usePoint: usePoint,
            },
            success: function (data) {
                if (data.code === 200) {
                    $(".cart-wrapper").html(data.htmlcart);
                    // $('#total-price-cart').text(data.totalPrice);
                    Swal.fire({
                        icon: "success",
                        title: "Xóa sản phẩm khỏi giỏ hàng thành công!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Xóa sản phẩm khỏi giỏ hàng thất bại!",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
            },
            error: function () {},
        });
    }

    clearCart($this) {
        event.preventDefault();
        let url = $this.data("url");
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (data) {
                if (data.code === 200) {
                    console.log(data.htmlcart);
                    $(".cart-wrapper").html(data.htmlcart);
                    //  $('#total-price-cart').text(data.totalPrice);
                    alert("clear cart success");
                    location.reload();
                } else {
                    alert("clear cart error");
                }
            },
            error: function () {},
        });
    }
}

let cart = new Cart();
$(document).on("click", ".add-to-cart", function () {
    $this = $(this);
    cart.addToCart($this);
});
$(document).on("click", ".jsBtnApplyCodeSale", function () {
    $this = $("#jsApplyCodeSale");
    cart.applyCodeSale($this);
});
$(document).on("change", "#jsApplyCodeSale", function () {
    $this = $(this);
    if (!$this.val()) {
        cart.applyCodeSale($this);
    }
});
$(document).on("click", ".update-cart", function () {
    $this = $(this);
    cart.updateCart($this);
});
$(document).on("click", ".remove-cart", function () {
    $this = $(this);
    cart.removeCart($this);
});
$(document).on("click", ".clear-cart", function () {
    $this = $(this);
    cart.clearCart($this);
});
$(document).on("click", ".quantity-cart .prev-cart", function () {
    let input = $(this).parents(".quantity-cart").find("input[type='number']");
    let value = parseFloat(input.val()) - 1;
    if (value < 1) {
        input.val(1);
    } else {
        input.val(value);
    }
    input.trigger("change");
});
$(document).on("click", ".quantity-cart .next-cart", function () {
    let input = $(this).parents(".quantity-cart").find("input[type='number']");
    let value = parseFloat(input.val()) + 1;
    input.val(value);
    input.trigger("change");
});
$(document).on("change", ".number-cart", function () {
    let url = $(this).data("url");
    let quantity = $(this)
        .parents(".cart-item")
        .find("input[name='quantity']")
        .val();
    let usePoint = $("#usePoint").val();
    if (usePoint) {
        usePoint = parseFloat(usePoint);
    } else {
        usePoint = 0;
    }
    $.ajax({
        type: "GET",
        url: url,
        data: {
            quantity: quantity,
            usePoint: usePoint,
        },
        dataType: "json",
        success: function (data) {
            if (data.code === 200) {
                $(".cart-wrapper").html(data.htmlcart);
                // $('#total-price-cart').text(data.totalPrice);
                // $('#total-price-money-cart').text(data.totalPriceMoney);
                // $('#total-price-point-cart').text(data.totalPricePoint);
                // alert('add to cart success');
                location.reload();
            } else {
                alert("add to cart error");
            }
        },
        error: function () {},
    });
});
$(document).on("change", "#usePoint", function () {
    let url = $(this).data("url");
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
            usePoint: usePoint,
        },
        dataType: "json",
        success: function (data) {
            if (data.code === 200) {
                $(".cart-wrapper").html(data.htmlcart);
                // $('#total-price-cart').text(data.totalPrice);
                // $('#total-price-money-cart').text(data.totalPriceMoney);
                // $('#total-price-point-cart').text(data.totalPricePoint);
                // alert('add to cart success');
            } else {
                alert("update cart error");
            }
        },
        error: function () {},
    });
});
