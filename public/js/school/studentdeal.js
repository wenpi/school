/**
 * 学生奖惩管理
 * @auth taozywu
 * @date 2013/07/22
 */

var StudentDeal = {
	// 查看
	view:function(deal_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/studentdeal/ajax.view",
            data: {
				deal_id: deal_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_studentdeal").html(resp);
            }
        });
	},
    // 添加
    add:function() {
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/studentdeal/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_studentdeal").html(resp);
            }
        });
	},
	save:function() {
		var input_student_id = $("#input_student_id").val();
		var input_type_id = $("#input_type_id").val();
		var input_deal_name = $("#input_deal_name").val();
		var input_deal_date = $("#input_deal_date").val();
		var input_deal_reason = $("#input_deal_reason").val();
		if( input_student_id ==0 ) {
			alert("请选择一个学生");
			return false;
		}
		if( jQuery.trim(input_deal_name) == "" || jQuery.trim(input_deal_date) == "" ) {
			alert("处理名称或处理日期不能为空");
			return false;
		}

		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/studentdeal/ajax.save",
            data: {
				input_student_id: input_student_id,
				input_type_id: input_type_id,
				input_deal_name: input_deal_name,
				input_deal_date: input_deal_date,
				input_deal_reason: input_deal_reason,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				if( resp == -2 ) {
					alert("已有奖惩数据，请重试");
					return false;
				}
				if( resp >0 ) {
					alert("添加成功");
					window.location =  show==1 ? "/teacherdeal/list" : "/teacherdeal/my.list";
				}
            }
        });
	},
	// 编辑
	edit:function(deal_id) {
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/studentdeal/ajax.edit",
            data: {
				deal_id: deal_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_studentdeal").html(resp);
            }
        });
	},

	update:function(deal_id) {
		var input_deal_name = $("#input_deal_name").val();
		var input_deal_reason = $("#input_deal_reason").val();
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/studentdeal/ajax.update",
            data: {
				deal_id: deal_id,
				input_deal_name: input_deal_name,
				input_deal_reason: input_deal_reason,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp == 1) {
					alert("操作成功");
					window.location = "/studentdeal/list";
				}
            }
        });
	}

}