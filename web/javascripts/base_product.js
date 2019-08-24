function initJueryThailandEnTh(db, local, frm_id, dst_id, amp_id, pro_id, zip_id) {
	var data_form = $('#'+frm_id),
		obj_district = data_form.find("#"+dst_id),
		obj_amphoe = data_form.find("#"+amp_id),
		obj_province = data_form.find("#"+pro_id),
		obj_zipcode = data_form.find("#"+zip_id);

	$.ThaiAddressEnTh({
        lang: local,
        database: db,
        district: obj_district,
        amphoe: obj_amphoe,
        province: obj_province,
        zipcode: obj_zipcode
    });
}
/*
function initJueryThailand(db, frm_id, dst_id, amp_id, pro_id, zip_id) {
	var data_form = $('#'+frm_id),
		obj_district = data_form.find("#"+dst_id),
		obj_amphoe = data_form.find("#"+amp_id),
		obj_province = data_form.find("#"+pro_id),
		obj_zipcode = data_form.find("#"+zip_id);

	$.Thailand({
		database: db,
		$district: obj_district,
		$amphoe: obj_amphoe,
		$province: obj_province,
		$zipcode: obj_zipcode,

		onDataFill: function(data){
			// console.info('Data Filled', data);
		},
		onLoad: function(){
			// console.info('Autocomplete is ready!');
			// $('#loader').toggle();
		}
	});

	obj_district.change(function(){
		// console.log('district', this.value);
	});
	obj_amphoe.change(function(){
		// console.log('amphoe', this.value);
	});
	obj_province.change(function(){
		// console.log('province', this.value);
	});
	obj_zipcode.change(function(){
		// console.log('zipcode', this.value);
	});
}
*/
function updateCartBoxData(element, is_role_client) {

	var link_product_detail = img_box_html = variant_option = title_amount_html = sku_html = price_html = quantity_html = '';
	var NewLiElement = angular.element('<li></li>');
	var SpanItemEle = angular.element('<span class="item"></span>');
	var SpanItemLeftEle = angular.element('<span class="item-left"></span>');
	var SpanItemInfoEle = angular.element('<span class="item-info"></span>');
	var TitleBoxEle = angular.element('<div class="text-box"></div>');

	// generate link for product detail
	if (!Array.isArray(element.variant_option) || !element.variant_option.length) {
		if(element.product_option_id_query_serialized){
			link_product_detail = Routing.generate('product_detail', { id:element.product_id, slug:element.slug, product_options_id:element.product_option_id_query_serialized });
		}else{
			link_product_detail = Routing.generate('product_detail', { id:element.product_id, slug:element.slug });
		}
	}else{
		var str_variant = encodeURI(element.variant_option.join("-"));
		if(element.product_option_id_query_serialized){
			link_product_detail = Routing.generate('product_detail', { id:element.product_id, slug:element.slug, v:str_variant, product_options_id:element.product_option_id_query_serialized });
		}else{
			link_product_detail = Routing.generate('product_detail', { id:element.product_id, slug:element.slug, v:str_variant });
		}
	}

	// item image
	if(element.image_small){
		img_box_html = '<div class="img-box"><img src="'+element.image_small+'" alt="'+element.title+'" /></div>';
	}else{
		img_box_html = '<div class="img-box"><img src="/template/img/resources/header-cart-1.jpg" alt="'+element.title+'" /></div>';
	}

	// variant element
	if(element.variant_option.length>0){
		if(element.product_category.title){
			variant_option = element.product_category.title + ' ';
		}
		variant_option += element.variant_option.join(" · ");
	};

	//item title
	title_amount_html = '<a href="'+link_product_detail+'"><h4><small>'+element.title+'</small></h4> <small>'+variant_option+'</small> </a>';
	//item sku
	if(element.sku){
		sku_html = '<div class="sku"><small>SKU: '+ element.sku +'</small></div>';
	}
	//item price
	price_html = '<div class="price"><small>฿'+ numeral(element.amount).format('0,0') +'</small></div>';
	//item quantity
	quantity_html = '<div class="qty"><small> Qty: '+element.quantity+'</small></div>';

	TitleBoxEle.append(title_amount_html);
	TitleBoxEle.append(sku_html);
	TitleBoxEle.append(quantity_html);
	TitleBoxEle.append(price_html);

	/*if(element.quantity>1){
		quantity_html = '<div class="review-box"> ฿<i>'+numeral(element.price).format('0,0.00')+'</i> (Qty: '+element.quantity+') </div>';
		TitleBoxEle.append(quantity_html);
	}*/

	SpanItemInfoEle.append(TitleBoxEle);

	SpanItemLeftEle.append(img_box_html);
	SpanItemLeftEle.append(SpanItemInfoEle);

	SpanItemEle.append(SpanItemLeftEle);
	NewLiElement.append(SpanItemEle);
	// NewLiElement.append(img_box_html);

	angular.element($(".cart_list_products_item").append(NewLiElement));

}
