/**
 * 短信管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Sms = {
	showSendTimeType: function(type) {
		if (type == 1) {
			$("#span_send_time_type").show();
		} else {
			$("#span_send_time_type").hide();
		}
	},
	showUserData: function(val) {
		var type = $("#type").val();
		jQuery.ajax({
			type: "POST",
			dataType: "html",
			url: "/sms/ajax.show.user.data",
			data: {
				type: type,
				val: val,
				j: 1,
				tt: Math.random()
			},
			success: function(resp) {
				$.validRight(resp);
				$("#div_show_user_data").html(resp);
				$("#div_show_user_data").dialog({
					modal: false,
					width: 500,
					height: 300,
				});
			}
		});

	},
	
	addUserData:function() { 
		var gmChks = document.getElementsByName("user_id[]");	
		var checkVal = "";	
		var checkNo = "";
		var checkName = "";
		var checkPhone = "";
		var cCount = 0;
		for (var i=0; i<gmChks.length ; i++)
		{
			if(gmChks[i].checked) { 
				var cVal = $("#user_id_" + i).val();
				checkVal +=  "|" + cVal ;
				var cNo = $("#user_no_" + i).val();
				checkNo += "|" + cNo;
				var cName = $("#user_name_" + i).val();
				checkName += "|" + cName;
				var cPhone = $("#user_phone_" + i).val();
				checkPhone += "|" + cPhone;
 				cCount +=1;
			}
		}
		if(cCount<1) { 
			alert("请选择一个用户再操作");
			return false;
		}
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/sms/ajax.add.user.data",
            data: {
                user_ids:checkVal,
				user_nos:checkNo,
				user_names:checkName,
				user_phones:checkPhone,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				$("#div_show_user_data").dialog('close');
				$(resp).insertBefore("#div_receive_user_ids");
            }
        });
		
	},
	removeUserId:function(uid) { 
		$("#font_user_id_" + uid).remove();
	}
}