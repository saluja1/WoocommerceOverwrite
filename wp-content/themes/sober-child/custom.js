var productPageData = JSON.parse(register_ajax_obj.get_Product_discount_data);
var currentRequest = null;
var totalQuantityPrice = 0;
var totalQuantity = 0;
var inkDataObj = {};
var selectedInkArray = [];
var totalInkPriceArray = {};

for (var i = 0; i < register_ajax_obj.printingArray.length; i++) {
	totalInkPriceArray[register_ajax_obj.printingArray[i]] = {};
	inkDataObj[register_ajax_obj.printingArray[i]] = {};
}

var singleProduct = {
	getData: function($, ajaxObj, ajaxUrl, pId, type) {
		$.ajax({
			url: ajaxObj.ajaxurl,
			dataType: 'JSON',
			type: 'POST',
			data: {
				'action': ajaxUrl,
				'pId': pId,
				'nonce': window.btoa(register_ajax_obj.nonce)
			},
			success: function(data) {

				if (data.success) {
					inkDataObj[pId] = data;
					$(".singleProductTable input").prop("disabled", false);
				}
			},
			error: function(errorThrown) {}
		});
	},

	quantityPrice: function($) {

		totalQuantity = 0;
		$(".singleProductTable input").each(function() {
			totalQuantity += Number($(this).val());
		});

		if (totalQuantity > 0) {

			for (var i = 0; i < productPageData.discountProductQuantity.length; i++) {
				if (totalQuantity <= productPageData.discountProductQuantity[i] && totalQuantity >= productPageData.discountProductQuantityMin[i]) {
					var finalDiscountvalue = productPageData.discountArray[i];
				}
			}

			totalQuantityPrice = (productPageData.price * totalQuantity) - ((finalDiscountvalue / 100) * productPageData.price * totalQuantity).toFixed(2);
			var pricePerplainProduct = Number(totalQuantityPrice) / parseInt(totalQuantity);
			$("#subtot span").html("$" + Number(totalQuantityPrice));
			$(".branding-form .input-text").attr("value", parseInt(totalQuantity));
		} else {
			$(".branding-form .input-text").attr("value", 0);
			for (var i = 0; i < selectedInkArray.length; i++) {
				$("."+selectedInkArray[i]).val("");
			}
		}
	},

	inkPrice: function($, totalInkQuantity, nameArray, dataObj, parentDIv, inkPriceObj) {

		var priceperprintnode = (nameArray[1] + "_" + (Number(nameArray[2]) + 1));
		var pricetotalprintnode = (nameArray[1] + "_" + (Number(nameArray[2]) + 2));
		var finaltotalpricePrint = 0;

		if (totalInkQuantity > 0) {

			var totalproducts = Number($(".branding-form .input-text").val());

			for (var i = 0; i < dataObj.inkpricepostmaxproductquantityArray.length; i++) {

				if (Number(dataObj.inkpricepostmaxproductquantityArray[i]) >= Number(totalproducts) && Number(dataObj.inkpricepostminproductquantityArray[i]) <= Number(totalproducts)) {

					var indexofinkquantity = Number(dataObj.inkpricepostinkquantityArray[i].indexOf(String(totalInkQuantity)));
					var inkPriceperprint = Number(dataObj.singleinkpricepostArray[i][indexofinkquantity]);
					var finalpriceperPrint = (Number((dataObj.printingsetupprice / totalproducts)) * totalInkQuantity) + Number(inkPriceperprint);
					finaltotalpricePrint = finalpriceperPrint * totalproducts;
					$("." + parentDIv + " ." + priceperprintnode).html('$'+finalpriceperPrint.toFixed(2));
					$("." + parentDIv + " ." + pricetotalprintnode).html('$'+finaltotalpricePrint.toFixed(2));
					inkPriceObj[pricetotalprintnode] = finaltotalpricePrint;
					break;
				}
			}
		} else {
			$("." + parentDIv + " ." + priceperprintnode).html("");
			$("." + parentDIv + " ." + pricetotalprintnode).html("");
			inkPriceObj[pricetotalprintnode] = finaltotalpricePrint;
		}
	},

	uploadFile: function(individual_file, ajaxObj, ajaxUrl, eLement){

	    var fd = new FormData();

	    fd.append("file", individual_file);

	    fd.append('action', ajaxUrl);  

	    jQuery.ajax({
	        type: 'POST',
			url: ajaxObj.ajaxurl,
	        data: fd,
	        contentType: false,
	        processData: false,
	        success: function(response){
	        	eLement.data('image', response)
	        },
			error: function(errorThrown){
	        	console.log(errorThrown);
			}
	    });
	}
}

jQuery(document).ready(function($) {

	if ($("body").hasClass("woocommerce-cart")) {
		$('.product-quantity.remove-controls .decrease').remove();
		$('.product-quantity.remove-controls .increase').remove();
	}

	if ($("body").hasClass("single-product")) {

		$( ".singleProductTable input, .singleColorTable input" ).prop("disabled", true);

		$(".branding-form .input-text").attr('readonly', true);

		$(".branding-form .decrease, .branding-form .increase").hide();

		for (var i = 0; i < register_ajax_obj.printingArray.length; i++) {
			singleProduct.getData($, register_ajax_obj, 'inkprice_ajax_request', register_ajax_obj.printingArray[i], "InkDataScreen");
		}

		$(".singleProductTable input").on('change keyup', function() {
			singleProduct.quantityPrice($);
		});

		$("input").on('change keyup', function() {
			var totalInkprinting = 0;
			selectedInkArray = [];

			var totalQuantity = Number($(".branding-form .input-text").val());

			if (totalQuantity > 0) {
				$(".singleColorTable input").prop("disabled", false);
			} else {
				$(".singleColorTable input").prop("disabled", true);
			}

			Object.keys(totalInkPriceArray).forEach(function(key) {
				var printingClass = 'singleColorTable.printing_' + key + '';
				var inkPriceObj = totalInkPriceArray[key];
				var dataObj = inkDataObj[key];

				var inputQuantity = 0;

				$("." + printingClass + " input").each(function() {
					inputQuantity = Number($(this).val());

					if (inputQuantity > 6) {
						$(this).val(6);
						inputQuantity = 6;
					}

					if (inputQuantity > 0) {
						selectedInkArray.push(printingClass +" input[name='"+$(this).attr('name')+"']" );
					}

					if (inputQuantity >= 0) {
						var nameArray = $(this).attr('name').split("_");
						singleProduct.inkPrice($, inputQuantity, nameArray, dataObj, printingClass, inkPriceObj);
					}
				});

				var array = totalInkPriceArray[key];
				var parskey = 0;
				var sum = 0;

				for (var value in array) {
					parskey = array[value];

					if (isNaN(parskey)) {
						parskey = 0;
					}

					sum += parskey;
				}

				totalInkprinting += sum;
			});

			var totalFinalPrice = (totalInkprinting + totalQuantityPrice).toFixed(2);

			var totalindividualPrice = ((totalFinalPrice) / totalQuantity).toFixed(2);

			if (isNaN(totalFinalPrice) || isNaN(totalindividualPrice) || totalQuantity == 0) {
				totalFinalPrice = "0.00";
				totalindividualPrice = "0.00";
			}

			$(".finalPrice .totalFinalPrice").html(totalFinalPrice);
			$(".finalPrice .singleFinalPrice").html(totalindividualPrice);

			currentRequest = $.ajax({
				url: register_ajax_obj.ajaxurl,
				dataType: 'JSON',
				type: 'POST',
				data: {
					'action': "addtocartprice_ajax_request",
					'price': window.btoa(totalindividualPrice),
					'id': register_ajax_obj.productId,
					'nonce': window.btoa(register_ajax_obj.nonce)
				},

				beforeSend: function() {
					if (currentRequest !== null) {
						currentRequest.abort();
						currentRequest = null;
					}
				},

				success: function(data) {},
				error: function(errorThrown) {}
			});
		});

		$("input:file").change(function (){
	        var individual_file = $(this).prop('files')[0];
	        singleProduct.uploadFile(individual_file, register_ajax_obj, "file_upload", $(this));
		});

		$('.enable-branding').change(function() {

			var isChecked = $(this).prop('checked');

			if (isChecked) {
				$('.custom-branding').show();
			} else {
				$('.custom-branding').hide();
			}
		});

		$('.cart.branding-form').on('submit', function() {
			var totalQuantity = Number($(".branding-form .input-text").val());
			var submitForm = true;

			var size_color = '';

			var logo_quantity = '';

			var isChecked = $('.enable-branding').prop('checked');

			$('.branding-form .cart-error-message').text('');

			if (totalQuantity == 0) {
				$('.branding-form .cart-error-message').text('Please select quantity.');
				return false;
			}

			$('.size_color_inner input').each(function() {

				if($(this).val()) {
					var name = $(this).data('colorn');
					var size = $(this).data('size');
					var color = $(this).data('color');
					var quantity = $(this).val();

					if (Number(quantity) > 0) {
						size_color += name+'_'+size+'_'+color+'_'+quantity+'~';
					}
				}
			});

			$('.size_color').val(size_color);

			if (isChecked) {

				for (var i = 0; i < selectedInkArray.length; i++) {
					if ($("."+selectedInkArray[i].slice(0, selectedInkArray[i].length-3)+"1']").val() == "" || $("."+selectedInkArray[i].slice(0, selectedInkArray[i].length-3)+"1']").val() == undefined) {
						submitForm = false;
					}
				}

				if (submitForm == false) {
					$('.branding-form .cart-error-message').text('Please add logo files.');
					return false;
				}

				$('.size_logo_inner').each(function() {
					var thirTR = $(this).find('tr');
					var hasValue = false;

					thirTR.each(function() {
						var image = $(this).find('.printing_file').data('image');
						var printing = $(this).find('.printing_position').data('printing');
						var position = $(this).find('.printing_position').text();
						var quantity = $(this).find('.printing_quantity').val();
						var single_price = $(this).find('td:nth-of-type(4) .printing_single_price').text();
						var total_price = $(this).find('td:nth-of-type(5) .printing_single_price').text();

						if (image && quantity) {
							logo_quantity += image+'^'+position+'^'+quantity+'^'+single_price+'^'+total_price+'^'+printing+'~';

							hasValue = true;
						}
					});

					if (hasValue) {
						logo_quantity += '&';
					}
				});

				$('.logo_quantity').val(logo_quantity);
			}
		});
	}
});