/**
 * 学生管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Student = {
	
	check:function() { 
		var cn_name = $("#cn_name").val();
		var birthday = $("#birthday").val();
		var id_name = $("#id_name").val();
		var class_id = $("#class_id").val();
		var entrance_date = $("#entrance_date").val();
		if(jQuery.trim(cn_name)=="") { 
			alert("学生中文名称不能为空");
			return false;
		}
		if(jQuery.trim(birthday)=="") { 
			alert("生日不能为空");
			return false;
		}
		if(jQuery.trim(id_name)=="") { 
			alert("证件号码不能为空");
			return false;
		}
		if(class_id==0) { 
			alert("请选择一个班级");
			return false;
		}
		if(jQuery.trim(entrance_date)=="") { 
			alert("入学日期不能为空");
			return false;
		}
		
		var check_1 = 0;
		var check_2 = 0;
		// 判断短信
		for(var i =0;i<=3;i++) { 
			var parent_cn_name = $("#parent_cn_name_"+i).val();
			var parent_mobile_phone = $("#parent_mobile_phone_"+i).val();
			// parent_is_message_1
			if(jQuery.trim(parent_mobile_phone)==""||jQuery.trim(parent_cn_name)=="") { 
				check_1++;
			}
			var parent_is_message = $("#parent_is_message_"+i).val();
			if(parent_is_message==1) { 
				check_2++;
			}
		}
		
		if(check_1==4) { 
			alert("请填写至少一条家长信息"); 
			return false;
		}
		if(check_2<1) { 
			alert("请选中一个优先短信联系");
			return false;
		}
		if(check_2>1) { 
			alert("只能选中一个作为优先短信联系");
			return false;
		}
	},
           
    showhideByAdd:function(flag,table_dis) { 
		var val =  $("#span_"+flag).attr("value");
		if(val==1) { 
			$("#" + table_dis).hide();
			$("#span_"+flag).attr("value",0);
			$("#span_"+flag).html("↓");
		} else { 
			$("#" + table_dis).show();
			$("#span_"+flag).attr("value",1);
			$("#span_"+flag).html("↑");
		}
	}
}