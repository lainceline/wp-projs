jQuery(document).ready(function($) {
    // Add to cart functionality
    $('.add-to-cart').on('click', function() {
        var product_id = $(this).closest('.product').data('id');
        $.ajax({
            url: ajax_object.ajax_url,
            method: 'POST',
            data: {
                action: 'add_to_cart',
                product_id: product_id,
                quantity: 1
            },
            success: function(response) {
                if (response.success) {
                    alert('Product added to cart!');
                } else {
                    alert('Failed to add product to cart.');
                }
            }
        });
    });

    // Display cart items
    function loadCart() {
        var cart = JSON.parse(sessionStorage.getItem('cart')) || {};
        var cart_items = $('.cart-items');
        cart_items.empty();
        $.each(cart, function(product_id, quantity) {
            var product = $('[data-id="' + product_id + '"]').clone();
            product.find('.add-to-cart').remove();
            product.append('<div class="cart-item-quantity">Quantity: ' + quantity + '</div>');
            cart_items.append(product);
        });
    }

    loadCart();

    // Checkout functionality
    $('.checkout').on('click', function() {
        var cart = JSON.parse(sessionStorage.getItem('cart')) || {};
        if ($.isEmptyObject(cart)) {
            alert('Your cart is empty!');
            return;
        }

        var total = 0;
        $.each(cart, function(product_id, quantity) {
            var price = parseFloat($('[data-id="' + product_id + '"]').find('.product-price').text());
            total += price * quantity;
        });

        $.ajax({
            url: ajax_object.ajax_url,
            method: 'POST',
            data: {
                action: 'create_paypal_payment',
                amount: total,
                currency: 'USD'
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.data.approval_url;
                } else {
                    alert('Failed to create PayPal payment.');
                }
            }
        });
    });
});
