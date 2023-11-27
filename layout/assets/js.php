<!-- [jQuery v3.6.4 - Bootstrap v5.3.0 - Swiper 8.4.5 - Aos ] -->
<script src="assets/js/main.js"></script>
<!-- custom scripts -->
<script src="assets/js/app.js"></script>

<script>
    $(document).ready(function () {
        removeParam('error');
        removeParam('success');
        removeParam('warning');
        setTimeout(function () {
            $('.alert').fadeOut(1000)

            // alert(myUrl)
        }, 5000)
    })

    function removeParam(parameter) {
        var url = window.location.href;
        var urlparts = url.split('?');

        if (urlparts.length >= 2) {
            var urlBase = urlparts.shift();
            var queryString = urlparts.join('?');

            var prefix = encodeURIComponent(parameter) + '=';
            var pars = queryString.split(/[&;]/g);
            for (var i = pars.length; i-- > 0;)
                if (pars[i].lastIndexOf(prefix, 0) !== -1)
                    pars.splice(i, 1);
            url = urlBase + '?' + pars.join('&');
            window.history.pushState('', document.title, url);
        }
        return url;
    }

    $(document).on('click', '.cartButton', function () {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var cart_id = $(this).data('cart');
        var input = $(`#cartInput${id}`)
        var oldQty = input.val();
        var currentUrl = window.location.href;
        if (currentUrl.includes('shopping-cart.php')) {
            var newQty = 0;
            if (type == 'plus') {
                newQty = (parseInt(parseInt(oldQty) + 1))
            } else {
                if (oldQty <= 1) {
                    newQty = (1)
                    return true;
                }
                newQty = (parseInt(parseInt(oldQty) - 1))
            }
            window.location.href = `add-to-cart.php?id=${id}&qty=${newQty}&cart_id=${cart_id}`;
        } else {
            if (type == 'plus') {
                input.val(parseInt(parseInt(oldQty) + 1))
            } else {
                if (oldQty <= 1) {
                    input.val(1)
                    return true;
                }
                input.val(parseInt(parseInt(oldQty) - 1))
            }
        }

    })

</script>