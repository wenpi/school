/**
 * 学生考勤管理
 * @auth taozywu
 * @date 2014/08/08
 */


var StudentAttendance = {
	// 查看
	view:function(attendance_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/studentattendance/ajax.view",
            data: {
				attendance_id: attendance_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_studentattendance").html(resp);
            }
        });
	},
    // 添加
    add:function() { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/studentattendance/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_studentattendance").html(resp);
            }
        });
	},
	// 保存
	save:function() { 
		var input_student_id = $("#input_student_id").val();
		var input_attendance_date = $("#input_attendance_date").val();
		var input_come_time = $("#input_come_time").val();
		var input_leave_time = $("#input_leave_time").val();
		var input_reason = $("#input_reason").val();
		if( input_student_id ==0 ) { 
			alert("请选择一个学生");
			return false;
		}
		if( jQuery.trim(input_attendance_date) == "" ) { 
			alert("请选择打卡日期");
			return false;
		}
		if(jQuery.trim(input_come_time) == "" && jQuery.trim(input_leave_time) == "" ) { 
			alert("到校时间与离校时间不能同时为空");
			return false;
		}
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/studentattendance/ajax.save",
            data: {
				input_student_id: input_student_id,
				input_attendance_date: input_attendance_date,
				input_come_time: input_come_time,
				input_leave_time: input_leave_time,
				input_reason: input_reason,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				if( resp == -2 ) { 
					alert("已有考勤数据，请重试");
					return false;
				}
				if( resp >0 ) { 
					alert("添加成功");
					window.location = "/studentattendance/list";
				}
            }
        });
	},
	// 编辑
	edit:function(attendance_id) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/studentattendance/ajax.edit",
            data: {
				attendance_id: attendance_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_studentattendance").html(resp);
            }
        });
	},
	// 修改提交
	update:function(attendance_id) { 
		var input_come_time = $("#input_come_time").val();
		var input_leave_time = $("#input_leave_time").val();
		var input_reason = $("#input_reason").val();
		var hidden_attendance_date = $("#hidden_attendance_date").val();
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/studentattendance/ajax.update",
            data: {
				attendance_id: attendance_id,
				input_come_time: input_come_time,
				input_leave_time: input_leave_time,
				input_reason: input_reason,
				hidden_attendance_date:hidden_attendance_date,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp == 1) { 
					alert("操作成功");
					window.location = "/studentattendance/list";
				}
            }
        });
	}
}