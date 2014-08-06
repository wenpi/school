/**
 * 短信管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Sms = {
	showReceiveType: function(type) {
		if (type == 1) {
			$("#span_receive_type").show();
		} else {
			$("#span_receive_type").hide();
		}
	},
	showUserData: function(val) {
		jQuery.ajax({
			type: "POST",
			dataType: "html",
			url: "/sms/ajax.show.user.data",
			data: {
				val: val,
				j: 1,
				tt: Math.random()
			},
			success: function(resp) {
				$.validRight(resp);
				$("#div_show_user_data").html(resp);
				$("#div_show_user_data").dialog({
					modal: false,
					width: 400,
					height: 400,
					bgiframe: true,
					hide:true,
					overlay: {opacity: 0.5, background: "black" ,overflow:'auto'},
				});
			}
		});

	},
}