<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/assets/client/vendor/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/assets/client/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/client/bootstrap/js/bootstrap-hover-dropdown.min.js"></script>
<script src="/assets/client/vendor/owl-carousel/owl.carousel.js"></script>
<script src="/assets/client/vendor/modernizr.custom.js"></script>
<script src="/assets/client/vendor/jquery.stellar.js"></script>
<script src="/assets/client/vendor/imagesloaded.pkgd.min.js"></script>
<script src="/assets/client/vendor/masonry.pkgd.min.js"></script>
<script src="/assets/client/vendor/jquery.pricefilter.js"></script>
<script src="/assets/client/vendor/bxslider/jquery.bxslider.min.js"></script>
<script src="/assets/client/vendor/mediaelement-and-player.js"></script>
<script src="/assets/client/vendor/waypoints.min.js"></script>
<script src="/assets/client/vendor/flexslider/jquery.flexslider-min.js"></script>

<!-- Theme Initializer -->
<script src="/assets/client/js/theme.plugins.js"></script>
<script src="/assets/client/js/theme.js"></script>

<!-- Style Switcher -->
<script type="text/javascript" src="/assets/client/style-switcher/js/switcher.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js"></script>

<script src="/assets/js/increase-decrease.js"></script>
<script src="/assets/js/login.js"></script>

<script>
    $(document).on('click', '.dropdownLink', function(e) {
        if ($(window).width() > 992) {
            window.location.href = $(this).attr('href'); // Điều hướng ngay khi click.
        }
    });

    // Đảm bảo dropdown hoạt động tốt trên mobile (dùng click)
    $(document).on('mouseenter', '.dropdown', function() {
        if ($(window).width() > 992) {
            $(this).addClass('open');
        }
    }).on('mouseleave', '.dropdown', function() {
        $(this).removeClass('open');
    });
</script>

<!-- Lấy dữ liệu ajax đổ ra modal -->
<script>
    $(document).ready(function() {
        $('.view-product').click(function(e) {
            e.preventDefault();
            const productId = $(this).data('id');

            $.ajax({
                url: `/api/product/${productId}`,
                type: 'GET',
                success: function(data) {
                    $('.product_id').val(data.id);
                    $('#product-name').text(data.name);
                    $('#product-sku').text(data.SKU);
                    $('#product-description').text(data.description);
                    $('#product-content').text(data.content);
                    $('#product-price-regular').text(data.price_regular.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

                    $('#category-name').text(data.category.name);
                    $('#category-type').text(data.category.type);

                    if (data.image) {
                        $('#product-image').attr('src', `${data.image}`);
                    }

                    let size = new Set();
                    let uniqueSizes = data.sizes.filter(value => {
                        if (size.has(value.id)) {
                            return false;
                        }
                        size.add(value.id);
                        return true;
                    });

                    let color = new Set();
                    let uniqueColors = data.colors.filter(value => {
                        if (color.has(value.id)) {
                            return false;
                        }
                        color.add(value.id);
                        return true;
                    });

                    $('#size-quick').empty();
                    uniqueSizes.forEach(item => {
                        $('#size-quick').append(
                            `<button class="btn-size size-quick mr-1"
                                data-size-id="${item.id}">${item.name}</button>`
                        );
                    });

                    $('#color-quick').empty();
                    uniqueColors.forEach(item => {
                        $('#color-quick').append(
                            `<button class="btn-color color-quick mr-1" data-color-id="${item.id}"
                                style="background-color:${item.code_color}"></button>`
                        );
                    });

                    // const reviewCount = data.reviews.length;
                    // Hiển thị số lượt đánh giá
                    const reviewCount = data.reviews.length;
                    $('#review-count').text(`${reviewCount} Review${reviewCount > 1 ? 's' : ''}`);

                    $('#reviewCount').text(reviewCount); 
                    
                    data.reviews.forEach(review => {
                        let imagePath = review.user.user_image; 
                        let parts = imagePath.split('/');
                        let imagePart = parts[1];

                        let stars = '';
                        for (let i = 1; i <= 5; i++) {
                            if (i <= review.rating) {
                                stars += '<i class="fa fa-star" aria-hidden="true"></i>';
                            } else {
                                stars += '<i class="fa fa-star-o" aria-hidden="true"></i>';
                            }
                        }

                        $('#reviewsList').append(`
                            <li>
                                <div class="comment">
                                    <div class="img-circle">
                                        <img class="avatar" width="50" alt=""
                                            src="/storage/user_images/${imagePart}">
                                    </div>
                                    <div class="comment-block">
                                        <span class="comment-by">
                                            <strong>${review.user.name}</strong>
                                        </span>
                                        <span class="date">
                                            <small><i class="fa fa-clock-o"></i> ${new Date(review.created_at).toLocaleDateString()}</small>
                                        </span>
                                        <div class="rating">
                                            ${stars}
                                        </div>
                                        
                                        <p>${review.review}</p>
                                    </div>
                                </div>
                            </li>
                        `);
                    });
                },
                error: function() {
                    alert('Không tìm thấy sản phẩm!');
                }
            });
        });
    });
</script>

<!-- Xử lý cập nhật và xóa giỏ hàng qua ajax -->
<script>
    $(document).on('click', '.remove-cart', function(e) {
        e.preventDefault();

        let href = $(this).attr('href');
        let data = {
            _token: '{{ csrf_token() }}',
            _method: "DELETE"
        };

        $.post(href, data, function(res) {
            load_cart();
            load_header();
        });
    });

    function updateCart(id, productVariantId, qty) {
        let data = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            quantity: qty,
            product_variant_id: productVariantId,
        };

        $.post(`{{ route('client.home') }}/carts/${id}`, data, function(res) {
            if (res.status_code == 200) {
                load_cart();
                load_header();
                // console.log(res.message);
            } else {
                $('.qty').val(res.quantity);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: res.message,
                });
            }
        });
    }

    function load_cart() {
        $.get("{{ route('client.carts.cart') }}", function(res) {
            $('.cart-view').html(res);
        });
    }
    load_cart();

    function load_header() {
        $.get("{{ route('client.header') }}", function(res) {
            $('.header-view').html(res);
        });
    }
    load_header();
</script>

<!-- Xử lý logic chọn màu và thêm giỏ hàng modal qua ajax -->
<script>
    $(document).ready(function() {
        let selectedColor = null;
        let selectedSize = null;

        $('#color-quick').on('click', '.color-quick', function(e) {
            e.preventDefault();
            $('.color-quick').removeClass('color-active');
            $(this).addClass('color-active');

            selectedColor = $(this).data('color-id');
            // console.log(selectedColor);
            getInStock(selectedSize, selectedColor);
            // fetchAvailableSizes(selectedColor);
        });

        $('#size-quick').on('click', '.size-quick', function(e) {
            e.preventDefault();
            $('.size-quick').removeClass('btn-active');
            $(this).addClass('btn-active');

            selectedSize = $(this).data('size-id');
            // console.log(selectedSize);
            getInStock(selectedSize, selectedColor);
            fetchAvailableColors(selectedSize);
        });

        $('#addToCartQuick').on('submit', function(e) {
            e.preventDefault();
            let productId = $('.product_id').val();
            let quantity = $('#quantity').val();
            let dataCart = {
                product_id: productId,
                color_id: selectedColor,
                size_id: selectedSize,
                quantity: quantity,
                _token: '{{ csrf_token() }}',
            }
            // console.log(dataCart);


            if (selectedColor && selectedSize) {
                $.post("{{ route('client.carts.add') }}", dataCart, function(res) {
                    if (res.status_code == 200) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: `<span style="font-size: 1.5rem">${res.message}</span>`,
                            width: 450
                        });

                        quantity = $('#quantity').val(1);
                        selectedColor = null;
                        selectedSize = null;
                        $('#productModal').modal('hide');
                        load_header();
                    } else {
                        // console.log(res.errors);

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: res.message,
                        });
                    }
                })
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Vui lòng chọn phân loại!",
                });
            }
        });

        function fetchAvailableColors(sizeId) {
            let productId = $('.product_id').val();
            let dataColor = {
                product_id: productId,
                size_id: sizeId
            }
            $.get("{{ route('get.color') }}", dataColor, function(res) {
                $('.color-quick').hide();
                $('.color-quick').removeClass('color-active');
                res.forEach(item => {
                    $(`.color-quick[data-color-id="${item.color_id}"]`).show();
                    // console.log(item.color_id);
                });
            });
        }

        function getInStock(sizeId = null, colorId = null) {
            let productId = $('.product_id').val();

            data = {
                product_id: productId,
                size_id: sizeId,
                color_id: colorId,
            }

            $.get("{{ route('get.stock') }}", data, function(res) {
                if (Array.isArray(res)) {
                    res.forEach(item => {
                        $('.stock').text(item.stock);
                        $('.amount').text(item.price + ' VND');
                    });
                } else {
                    $('.stock').text(res);
                    $('#stock').val(res);
                }
            })
        }
    });
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
        $('.saveVoucher').on('click', function () {
            swal({
                title: "Thông báo !",
                text: "Bạn cần đăng nhập mới có thể sử dụng mã giảm giá.",
                icon: "warning",
            });
        })
</script>
