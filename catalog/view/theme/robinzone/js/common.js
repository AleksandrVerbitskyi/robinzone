function initSliderForFastorder() {
    $('.closeLookSlider').slick({
        dots: false,
        vertical: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        verticalSwiping: true,
        arrows:true,
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-up'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-down'></i></button>",
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    vertical: false,
                    prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
                    nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
                }
            },
            {
                breakpoint: 425,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    vertical: false,
                    prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
                    nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
                }
            },
        ]
    });
}

$(function () {
    initSliderForFastorder();
});

$(document).on('click', '.itemImgCover-fast', function () {
    // var data = $(this).find('img').attr('src');
    var data = $(this).find('img').data('full_image');
    $('.itemPhoto_img-fast').attr('src', data.substring(data.indexOf('/')));

    $('.itemImgCover-fast').addClass('active');
    $('.itemImgCover-fast').removeClass('active');
    $(this).addClass('active');
});

// SEARCH
function search() {
    var url = $('base').attr('href') + 'index.php?route=product/search';

    var value = $('header #search input[name=\'search\']').val();

    if (value) {
        url += '&search=' + encodeURIComponent(value);
    }

    location = url;
}

$("#inpt_search").on('focus', function () {
    $(this).parent('label').addClass('active');
});

$("#inpt_search").on('blur', function () {
    if($(this).val().length == 0)
        $(this).parent('label').removeClass('active');
});

$("#inpt_search").on('keydown', function (e) {
    if (e.keyCode === 13) {
        search();
    }
});

function stylizeSelect(select_name) {

    if (select_name !== undefined) {
        var $this = $('select[name=\'' + select_name + '\']'),
            numberOfOptions = $this.children("option").length;

        var name = $this.attr('name');

        $this.addClass("select-hidden");
        $this.wrap('<div class="select"></div>');
        $this.after('<div class="select-styled"></div>');

        var $styledSelect = $this.next("div.select-styled");
        $styledSelect.text(
            $this
                .children("option")
                .eq(0)
                .text()
        );

        var $list = $("<ul />", {
            class: "select-options",
            id: name
        }).insertAfter($styledSelect);

        for (var i = 0; i < numberOfOptions; i++) {
            $("<li />", {
                text: $this
                    .children("option")
                    .eq(i)
                    .text(),
                rel: $this
                    .children("option")
                    .eq(i)
                    .val()
            }).appendTo($list);
        }

        var $listItems = $list.children("li");

        $styledSelect.click(function(e) {
            e.stopPropagation();
            $("div.select-styled.active")
                .not(this)
                .each(function() {
                    $(this)
                        .removeClass("active")
                        .next("ul.select-options")
                        .hide();
                });
            $(this)
                .toggleClass("active")
                .next("ul.select-options")
                .toggle();
        });

        $listItems.click(function(e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass("active");
            $this.val($(this).attr("rel"));
            $list.hide();
        });

        $(document).click(function() {
            $styledSelect.removeClass("active");
            $list.hide();
        });
    } else {
        $("select").each(function() {
            var $this = $(this),
                numberOfOptions = $(this).children("option").length;

            var name, filter_name = ['shipping_area', 'shipping_city', 'shipping_warehouse'];

            if ($this.data('name') !== undefined) {
                name = $this.data('name');
            } else {
                name = $this.attr('name');
            }

            if ($.inArray(name, filter_name) !== -1) return false;

            $this.addClass("select-hidden");
            $this.wrap('<div class="select"></div>');
            $this.after('<div class="select-styled"></div>');

            var $styledSelect = $this.next("div.select-styled");
            $styledSelect.text(
                $this
                    .children("option")
                    .eq(0)
                    .text()
            );

            var $list = $("<ul />", {
                class: "select-options",
                id: name
            }).insertAfter($styledSelect);

            for (var i = 0; i < numberOfOptions; i++) {
                $("<li />", {
                    text: $this
                        .children("option")
                        .eq(i)
                        .text(),
                    rel: $this
                        .children("option")
                        .eq(i)
                        .val()
                }).appendTo($list);
            }

            var $listItems = $list.children("li");

            $styledSelect.click(function(e) {
                e.stopPropagation();
                $("div.select-styled.active")
                    .not(this)
                    .each(function() {
                        $(this)
                            .removeClass("active")
                            .next("ul.select-options")
                            .hide();
                    });
                $(this)
                    .toggleClass("active")
                    .next("ul.select-options")
                    .toggle();
            });

            $listItems.click(function(e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass("active");
                $this.val($(this).attr("rel"));
                $list.hide();
            });

            $(document).click(function() {
                $styledSelect.removeClass("active");
                $list.hide();
            });
        });
    }
}

stylizeSelect();

function refreshSelect () {
    var select_list = {}, name;
    $('select').each(function () {
        if ($(this).data('name') !== undefined) {
            name = $(this).data('name');
        } else {
            name = $(this).attr('name');
        }
        select_list[name] = {};
        select_list[name] = $('option:selected', this).val();
    });
    $.each(select_list, function (name, active) {
        $('#' + name + ' li').each(function () {
            var $this = $(this);
            var rel = $this.attr('rel');
            if (rel == active) {
                $this.toggleClass("active");
                $($this.parents('.select').find('.select-styled')).text($this.text());
            }
        });
    });
}

$(function () {
    refreshSelect();
    $('.delivery_list').click(function() {
        $('input[name=\'shipping_method\']').attr('checked', false);
        $(this).find('input[type=\'radio\']').attr('checked', true);
        $('input:checked[name=\'shipping_method\']').trigger('change');
    });
    $('.payment_list').click(function() {
        $('input[name=\'payment_method\']').attr('checked', false);
        $(this).find('input[type=\'radio\']').attr('checked', true);
    });
    $(document).on('click', '.sizesList', function() {
        var name = $(this).data('name'),
            inputs = $(this).parents('.product-form-cover').find('input[name=\'' + name + '\']'),
            goal = $(this).parents('.product-form-cover').find('input[name=\'' + name + '\'][value=\'' + $(this).data('value') + '\']');
        inputs.attr('checked', false);
        goal.attr('checked', true);
        $('.sizesList').removeClass('active');
        $(this).addClass('active');
    });
    $('.star.rating').click(function() {
        var value = $(this).data('rating'), name = 'rating';
        $('input:radio[name=\'' + name + '\']').attr('checked', false);
        $('input:radio[name=\'' + name + '\'][value=\'' + value + '\']').attr('checked', true);
    });
});

$(function() {
    var timeout = null;
    $(document).on('click', '.quantity .button', function() {
        var $button = $(this);
        var $quantity = $button.parent().find("input[name='quantity']");
        var oldValue = $button.parent().find("input[name=\'quantity\']").val();

        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $quantity.val(newVal);

        clearTimeout(timeout);
        timeout = setTimeout(function () {
            $quantity.trigger('change');
        }, 500);
    });

    $(document).on('change', 'input.input-qty-in-cart', function () {
        var value = this.value;
        if (parseInt(value) === 0) {
            $(this).val(1);
        }
        var cart_id = $(this).data('cart_id'), data = {};
        data['quantity'] = {};
        data['quantity'][cart_id] = this.value;
        cart.update(data, this, function (json, input) {
            if (json['error'] && json['error']['qty']) {
                $(input).val(json['error']['qty']['value']);
                $(input).parents('tr').find('.item__title').after('<span class="text-danger error-qty-in-cart">' + json['error']['qty']['message'] + '</span>');
                data['quantity'][cart_id] = $(input).val();
                cart.update(data, input);
            }

        });
    });

    $(document).on('change input', 'input.qty-in-product-card', function () {
        var value = this.value;
        if (parseInt(value) === 0) {
            $(this).val(1);
        }
        var data = {}, size = $('.sizesList.active'), color = $('.select-product-color'), input = this;
        data['product_id'] = $($(this).parents('.itemPhoto_characteristics_sizes').find('input[name=\'product_id\']')).val();
        data['qty'] = this.value;
        if ($(size).data('value') !== undefined) {
            data['size'] = $(size).data('value');
        }
        if ($(color).val() !== '') {
            data['color'] = $(color).val();
        }

        checkIfProductQtyAvailable(input, data);

    });

});
var input_timeout = null;
var checkIfProductQtyAvailable = function (input, data, callback) {
    $.ajax({
        url: 'index.php?route=checkout/cart/checkProductAvailable',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function (json) {
            var successfully = false;
            if (json['error'] && json['error']['qty']) {
                clearTimeout(input_timeout);
                input_timeout = setTimeout(function () {
                    showMessage(json['error']['qty']['message'], 'warning');
                }, 1000);
                setTimeout(function () {
                    $(input).val(json['error']['qty']['value']);
                }, 500);
            } else successfully = true;
            if (callback !== undefined) {
                callback(successfully);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
};

$(function() {

    $(document).on('click', "a.look, a.look2", function(e) {
        var data = {};
        e.preventDefault();
        data['product_id'] = $(this).parent().find('input:hidden[name=\'product_id\']').val();

        $.ajax({
            url: 'index.php?route=product/product/getProductInfo',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(json) {
                if (json['success']) {
                    $('#popup-product-image').html('');
                    $('#popup-product-images').html('');
                    if (json['images'].length !== 0) {
                        var images_html = '';
                        if (json['thumb'] !== '') {
                            images_html += '<div><div class="itemImgCover itemImgCover-fast active"><img src="' + json['thumb'] + '" data-full_image="' + json['popup'] + '" title="' + json['text']['heading_title'] + '" alt="' + json['text']['heading_title'] + '" class="itemSlider_img"></div></div>';
                        }
                        $.each(json['images'], function (i, item) {
                            images_html += '<div><div class="itemImgCover itemImgCover-fast"><img src="' + item['thumb'] + '" data-full_image="' + item['popup'] + '" title="' + json['text']['heading_title'] + '" alt="' + json['text']['heading_title'] + '" class="itemSlider_img"></div></div>';
                        });
                        $('#popup-product-images').html(images_html);
                        $('.closeLookSlider').slick('unslick');
                        initSliderForFastorder();
                    }
                    if (json['thumb'] !== '') {
                        $('#popup-product-image').html('<img src="' + json['popup'] + '" title="' + json['text']['heading_title'] + '" alt="' + json['text']['heading_title'] + '"  class="itemPhoto_img itemPhoto_img-fast light-zoom" />');
                    }
                    $('#popup-product-title').html(json['name']);
                    $('#popup-product-title').attr('href', json['link']);
                    $('#popup-product-text-model').text(json['text']['model']);
                    $('#popup-product-model').text(json['model']);

                    $('#popup-product-facebook').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + json['link'] + '&title=' + json['name']);
                    $('#popup-product-google').attr('href', 'https://plus.google.com/share?url=' + json['link']);

                    $('#popup-product-wishlist').attr('title', json['text']['button_wishlist']);
                    $('#popup-product-wishlist').on('click', function () {
                        wishlist.add(json['product_id'])
                    });
                    $('#popup-product-compare').attr('title', json['text']['button_compare']);
                    $('#popup-product-compare').on('click', function () {
                        compare.add(json['product_id'])
                    });
                    var stock;
                    if (json['in_stock'] === true) {
                        stock = '<i class="fas fa-check"></i> <span>' + json['stock'] + '</span>';
                    } else {
                        stock = '<i class="fas fa-times" style="color:red;"></i> <span>' + json['stock'] + '</span>';
                    }
                    $('#popup-product-instock').html(stock);
                    if (json['review_status'] && parseInt(json['rating']) > 0) {
                        $('#popup-product-feedback-count').html('<a href="' + json['link_reviews'] + '">' + json['reviews'] + '</a>');
                        $('#popup-product-feedback-rating').data('stars', parseInt(json['rating']));
                        $('#popup-product-feedback-all').css('display', 'block');
                    } else {
                        $('#popup-product-feedback-all').css('display', 'none');
                    }
                    var new_price = json['special'], price = json['price'], price_html = '';
                    if (json['special'] === false) {
                        price_html = '<span class="itemPhoto_characteristics_newPrice">' + price + '</span>';
                    } else {
                        price_html = '<span class="itemPhoto_characteristics_oldPrice">' + price + '</span>';
                        price_html += '<span class="itemPhoto_characteristics_newPrice">' + new_price + '</span>';
                    }
                    $('#popup-product-price').html(price_html);
                    if (json['options'].length > 0) {
                        var options_html = '', selects = [];
                        $.each(json['options'], function (index, option) {
                            options_html += '<div class="error-after-me">';
                            var required = parseInt(option['required']) !== 0 ? ' required-field' : '';
                            options_html += '<span class="itemPhoto_characteristics_sizesTitle ' + required + '">' +  option['name'] + ': </span>';
                            if (option['type'] === 'select') {
                                selects.push('option[' + option['product_option_id'] + '-' + json['product_id'] + ']');
                                options_html += '<select name="option[' + option['product_option_id'] + '-' + json['product_id'] + ']" id="input-option-fast' + option['product_option_id'] + '">';
                                options_html += '<option value="">' + json['text']['text_select'] + '</option>';
                                $.each(option['product_option_value'], function (i, option_value) {
                                    options_html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'] + '</option>';
                                });
                                options_html += '</select>';
                            } else if (option['type'] === 'radio') {
                                options_html += '<ul class="slideSizes" id="input-option-fast' + option['product_option_id'] + '">';
                                $.each(option['product_option_value'], function (i, option_value) {
                                    options_html += '<li class="sizesList" data-name="option[' + option['product_option_id'] + ']" data-value="' + option_value['product_option_value_id'] + '" ><span class="sizeColor">' + option_value['name'] + '</span></li>';
                                    options_html += '<div class="radio" style="display: none;">';
                                    options_html += '<label>';

                                    options_html += '<input type="radio" name="option[' + option['product_option_id'] + ']" value="' + option_value['product_option_value_id'] + '" />';
                                    options_html += option_value['name'];

                                    options_html += '</label>';
                                    options_html += '</div>';
                                });
                                options_html += '</ul>';
                            }
                            options_html += '</div>';
                            options_html += '</div>';
                        });
                        $('#popup-product-options').html(options_html);
                        $.each(selects, function (i, name) {
                            stylizeSelect(name);
                        });
                    }
                    $('#popup-product-sizes-table').text(json['text']['text_size_table']);
                    $('#popup-product-sizes-table').attr('href', json['link_sizes_table']);
                    $('#popup-product-sizes-table').css('margin-top', '14px');

                    var product_qty_html = '';
                    product_qty_html += '<div class="clearfix quantity" style="user-select: none;">';
                    product_qty_html += '<div class="dec button">+</div>';
                    product_qty_html += '<input type="text" name="quantity" id="input-quantity-fast" value="' + json['minimum'] + '" size="1" class="form-control cart-q" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\\..*)\\./g, \'$1\');" >';
                    product_qty_html += '<div class="inc button">-</div>';
                    product_qty_html += '</div>';
                    product_qty_html += '<button type="button" id="button-fast-order" class="itemPhoto_characteristics_button">' + json['text']['button_cart'] +'</button>';
                    product_qty_html += '<span class="itemPhoto_characteristics_order fast-order"><i class="far fa-hand-point-up"></i>' + json['text']['text_fast_order'] +'</span>';
                    $('#popup-product-quantity').html(product_qty_html);
                    $('#popup-product-id').remove();
                    $('#popup-product-quantity').after('<input type="hidden" id="popup-product-id" name="product_id" value="' + json['product_id'] + '" />');

                }
            },
            error: function (error) {
                alert(error);
            }
        });

    });

    $(document).on('click touchstart', 'a.product-compare', function (e) {
        e.preventDefault();
        var product_id = $(this).data('product_id');
        compare.add(product_id);
    });
    $(document).on('click touchstart', 'a.product-wishlist', function (e) {
        e.preventDefault();
        var product_id = $(this).data('product_id');
        wishlist.add(product_id);
    });
});
//                                                    |||||||||| CART OBSERVABLE START ||||||||
// [Observer]
function Observer (behavior) {
    this.notify = function (msg) {
        behavior(msg);
    }
}
// [Observable]
function Observable () {
    var observers = [];
    this.sendMessage = function (msg) {
        for (var i = 0, len = observers.length; i < len; i++) {
            observers[i].notify(msg);
        }
    };
    this.addObserver = function (observer) {
        observers.push(observer);
    }
}

var CartObservable = new Observable();

var showMessageObserver = new Observer(function (data) {
    var msg = data['msg'];
    showMessage(msg);
});
var updateProductsQty = new Observer(function (data) {
    var $cover = $('#qty-in-cart'), qty;
    qty = data['inCart'];
    $cover.html('<style>#count_in_cart:after {content: "' + qty + '";} </style>');
});
var updateProductsItems = new Observer(function (data) {
    $.ajax({
        url: 'index.php?route=common/cart',
        type: 'post',
        data: {action: 'getProductsItems'},
        dataType: 'json',
        success: function (json) {
            var cartHtml = renderCommonCartHtml(json)
            $('.basket__details').html(cartHtml);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

function renderCommonCartHtml(data) {
    var products = data['products'], totals = data['totals'];
    var html = '';
    html += '<div class="basket__item_static">';
    products.map(function (item) {
        html += '<div class="basket__item">';
        html += '<div class="basket__item_block">';
            html += '<a href="' + item['href'] + '"><img src="' + item['thumb'] + '" alt="' + item['name'] + '" title="' + item['name'] + '" class="img-basket__item_img" /></a>';
        html += '</div>';
        html += '<div class="item_description">';
            html += '<a href="#" class="remove-from-cart" data-product_id="' + item['cart_id'] + '" title="' + item['button_remove'] + '"><i class="far fa-times-circle"></i></a>';
            html += '<a href="' + item['href'] + '"><h6 class="item__title">' + item['name'] + '</h6></a>';
            html += '<p class="item__model"><span>' + item['text_model'] + '</span><span> ' + item['model'] + '</span></p>';
            html += '<p class="item__quantity"><span>' + item['text_qty'] + '</span><span> ' + item['quantity'] + '</span></p>';
            if (item['option']) {
                $.each(item['option'], function (index, option) {
                    html += '<p class="item__color"><span>' + option['name'] + ': </span><span> ' + option['value'] + '</span></p>';
                });
            }
            html += '<p class="item__price">' + item['total'] + '</p>';
        html += '</div>';
        html += '</div>';

    });
    html += '</div>';

    html += '<div class="cart_static">';
    html += '<div class="basket__sum">';
        $.each(totals, function (index, total) {
            if (total['code'] === 'total') {
                html += '<span class="basket__sum_title">' + total['title'] + '</span>';
                html += '<span class="basket__sum_number">' + total['text'] + '</span>';
            }
        });
    html += '</div>';
    html += '<a href="' + data['checkout'] + '" class="basket__order_button">' + data['text_checkout'] + '</a>';
    html += '</div>';

    return html;
}

var updateTotalsInCart = function (input, total, totals) {
    var $total_block = $(input).parents('tr').find('.product-total-in-cart'),
        $totals_block = $('.cart_item_row_discount').find('.totals-in-cart');
    $total_block.text(total);
    var html = '';
    $.each(totals, function (index, total) {
        if (total['code'] === 'total' || total['code'] === 'coupon' || total['code'] === 'reward') {
            html += '<p class="cart_finalPrice">' + total['title'] + '</p>';
            html += '<p class="cart_finalPrice_number">' + total['value'] + '</p>';
        }
    });
    $totals_block.html(html);
};

CartObservable.addObserver(showMessageObserver);
CartObservable.addObserver(updateProductsQty);
CartObservable.addObserver(updateProductsItems);
//                                                    |||||||||| CART OBSERVABLE END ||||||||


                                                                    // ADD TO CART (FAST-ORDER)
$(document).on('click', '#button-fast-order', function() {
    var data = $('#product-form-in-fast-order input[type=\'text\'], #product-form-in-fast-order input[type=\'hidden\'], #product-form-in-fast-order input[type=\'radio\']:checked, #product-form-in-fast-order input[type=\'checkbox\']:checked, #product-form-in-fast-order select, #product-form-in-fast-order textarea');
    data.each(function (index, item) {
        if ($(item).is('SELECT')) {
            let name = $(item).attr('name'), regex = /(\[.*)(-.*)(\])/i;
            $(item).attr('name', name.replace(regex, '$1$3', name));
            data[index] = item;
        }
    });

    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function(json) {
            $('.text-danger').remove();
            $('.form-group').removeClass('has-error');
            if (json['error']) {
                if (json['error']['option']) {
                    for (i in json['error']['option']) {
                        var product_card_error_class = ' text-danger-product-card';
                        var element = $('#input-option-fast' + i.replace('_', '-'));
                        if (element.parent().hasClass('input-group')) {
                            element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                        } else {
                            if (element.is('SELECT')) {
                                product_card_error_class += ' text-danger-select';
                            }
                            element.parents('.error-after-me').after('<div class="text-danger' + product_card_error_class + '">' + json['error']['option'][i] + '</div>');
                        }
                    }
                }

                if (json['error']['recurring']) {
                    $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                }
            }

            if (json['success']) {
                $('#overlay3, #modal_close_closeLook').trigger('click')
                CartObservable.sendMessage(json['success']);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

$(document).on('click', '.fabricTypes_general', function(event){
    event.preventDefault();
    var image = $($(this).find('.fabricTypes_img')).attr('src'),
        title = $($(this).find('.textile-title')).val(),
        text = $($(this).find('.textile-description')).val();
    var $img = $('.fabric_close_img'), $title_el = $('.fabric_close_title'), $text_el = $('.fabric_close_text');
    $img.attr('src', image);
    $img.attr('alt', title);
    $img.attr('title', title);
    $title_el.text(title);
    $text_el.text(text);
    $('#overlay4').addClass('is-visible');
});

$(document).on('click', '.filtration_form a input[type=\'checkbox\']', function () {
    var link = $(this).parent('a');
    window.location.assign($(link).attr('href'));
});