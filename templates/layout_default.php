<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?= $title ? $title . ' - ' : '' ?>Овощи & Фрукты</title>
	<link href="http://fonts.googleapis.com/css?family=Lobster&subset=latin,cyrillic" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Noto+Serif:400,400italic&subset=latin,cyrillic" rel="stylesheet" type="text/css">
	<link href="/css/style.css" rel="stylesheet" type="text/css">
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script>
		var InfoPopup = {
			show: function (content, autohide) {
				var popup = $('<div>')
					.addClass('info-popup')
					.hide()
					.html(content)
					.appendTo($('.info-popup-wrapper'))
					.fadeIn();

				if (autohide) {
					setTimeout(function () { InfoPopup.hide(popup) }, 3000);
				} else {
					$('<button>')
						.html('&times;')
						.prependTo(popup)
						.click(function () {
							InfoPopup.hide(popup);
						})
				}
			},
			hide: function (popup) {
				popup.slideUp(function () { $(this).remove() });
			}
		};

		$(function () {
			$('.btn-basket-add, .btn-basket-remove').click(function () {
				var isAdding = $(this).hasClass('btn-basket-add');
				$.get(this.href, {ajax: true}, function (data) {
					if (data && data.ok) {
						$('#basket-total-items').text(data.basketTotalItems);
						$('#basket-total-price').html(data.basketTotalPriceFormatted);
						var $count = $('.product-item-bought-count[data-product=' + data.productId + ']');
						$count.text(data.productNewCount);
						if (data.basketTotalItems > 0) {
							$('#basket-info').show();
						} else {
							$('#basket-info').hide();
						}
						if (data.productNewCount > 0) {
							$count.closest('.product-item-bought').show();
						} else {
							$count.closest('.product-item-bought').hide();
						}

						var infoText = '<b>' + data.productName + '</b> - ' +
							(isAdding ? 'добавлено в корзину' : 'убрано из корзины');

						InfoPopup.show(infoText, true);
					}
				}, 'json');
				return false;
			})
		});
	</script>
</head>
<body>
	<div class="info-popup-wrapper"></div>

	<div style="position: absolute; right: 0; top: -20px">
		<a href="/admin">вход для персонала</a>
	</div>
	<header onclick="location.href = '/'">
		<h1>Овощи & Фрукты</h1>
		<h2>—— Интернет-магазин ——</h2>
	</header>

	<article>
		<? require \DemoShop\App::getTemplatePath($template); ?>
	</article>

	<footer>
	</footer>
</body>
</html>