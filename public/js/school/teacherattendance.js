/**
 * 教工考勤管理
 * @auth taozywu
 * @date 2013/07/22
 */


var TeacherAttendance = {
    // 添加
    add:function(show) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/teacherattendance/ajax.add",
            data: {
				show_teacher: show,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_teacherattendance").html(resp);
            }
        });
	},
	// 保存
	save:function(show) { 
		var input_teacher_id = $("#input_teacher_id").val();
		var input_attendance_date = $("#input_attendance_date").val();
		var input_come_time = $("#input_come_time").val();
		var input_leave_time = $("#input_leave_time").val();
		var input_reason = $("#input_reason").val();
		if( input_teacher_id ==0 ) { 
			alert("请选择一个教工");
			return false;
		}
		if( jQuery.trim(input_attendance_date) == "" ) { 
			alert("请选择打卡日期");
			return false;
		}
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/teacherattendance/ajax.save",
            data: {
				input_teacher_id: input_teacher_id,
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
					window.location = show==1?"/teacherattendance/list":"/teacherattendance/my.list";
				}
            }
        });
	},
	// 编辑
	edit:function(attendance_id) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/teacherattendance/ajax.edit",
            data: {
				attendance_id: attendance_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_teacherattendance").html(resp);
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
            url: "/teacherattendance/ajax.update",
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
					window.location = "/teacherattendance/list";
				}
            }
        });
	}
}