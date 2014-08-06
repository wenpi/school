/**
 * 教工奖惩管理
 * @auth taozywu
 * @date 2013/07/22
 */


var TeacherDeal = {
    // 添加
    add:function(show) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/teacherdeal/ajax.add",
            data: {
				show_teacher: show,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_teacherdeal").html(resp);
            }
        });
	},
	save:function(show) { 
		var input_teacher_id = $("#input_teacher_id").val();
		var input_type_id = $("#input_type_id").val();
		var input_deal_name = $("#input_deal_name").val();
		var input_deal_date = $("#input_deal_date").val();
		var input_deal_reason = $("#input_deal_reason").val();
		if( input_teacher_id ==0 ) { 
			alert("请选择一个教工");
			return false;
		}
		if( jQuery.trim(input_deal_name) == "" || jQuery.trim(input_deal_date) == "" ) { 
			alert("处理名称或处理日期不能为空");
			return false;
		}
		
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/teacherdeal/ajax.save",
            data: {
				input_teacher_id: input_teacher_id,
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
	edit:function(deal_id,show) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/teacherdeal/ajax.edit",
            data: {
				deal_id: deal_id,
				show_teacher:show,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_teacherdeal").html(resp);
            }
        });
	},
	
	update:function(deal_id,show) { 
		var input_deal_name = $("#input_deal_name").val();
		var input_deal_reason = $("#input_deal_reason").val();
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/teacherdeal/ajax.update",
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
					window.location = show==1? "/teacherdeal/list" : "/teacherdeal/my.list";
				}
            }
        });
	}
	
}