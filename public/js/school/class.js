/**
 * 班级管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Class = {
    
    setStudent:function(class_id,from) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/class/ajax.set.student",
            data: {
				class_id:class_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp ==-1) {
                    alert("该班级不是特长班，请重试");
                    return false;
                }
                $("#div_class").html(resp);
            }
        });
    },
	view:function(class_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/class/ajax.view",
            data: {
				class_id:class_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_class").html(resp);
            }
        });
	},
	
	showSpecial:function(val) { 
		$("#td_special").html("班主任：");
		if(val==1) $("#td_special").html("授课教师：");
	},
    // 添加
    add: function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/class/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_class").html(resp);
            }
        });
    },
    // 保存科目
    save: function() {
        var input_property = $("#input_property").val();
        var input_teacher_id = $("#input_teacher_id").val();
        var input_class_name = $("#input_class_name").val();
        var input_amount = $("#input_amount").val();
		var input_class_minute = $("#input_class_minute").val();
		var input_class_address = $("#input_class_address").val();
		var input_class_time = $("#input_class_time").val();
		var input_open_date = $("#input_open_date").val();
		var input_comments = $("#input_comments").val();
        if( jQuery.trim(input_class_name) == "" ) {
            alert("班级名称不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/class/ajax.save",
            data: {
                input_property: input_property,
                input_teacher_id: input_teacher_id,
                input_class_name: input_class_name,
                input_amount: input_amount,
				input_class_minute: input_class_minute,
				input_class_address: input_class_address,
				input_class_time: input_class_time,
				input_open_date: input_open_date,
				input_comments: input_comments,
				j:1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp>0 ) {
                    alert("添加成功");
                    window.location = "/class/list";
                }
                if( resp == -2 ) {
                    alert("该班级名称已存在，请重试");
                    return false;
                }
            }
        });
    },
    // 编辑
    edit: function(class_id,from) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/class/ajax.edit",
            data: {
                class_id: class_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_class").html(resp);
            }
        });
    },
    // 更新
    update:function(class_id) {
        var input_property = $("#input_property").val();
        var input_teacher_id = $("#input_teacher_id").val();
        var input_class_name = $("#input_class_name").val();
        var input_amount = $("#input_amount").val();
		var input_class_minute = $("#input_class_minute").val();
		var input_class_address = $("#input_class_address").val();
		var input_class_time = $("#input_class_time").val();
		var input_open_date = $("#input_open_date").val();
		var input_comments = $("#input_comments").val();
		
		var hidden_class_name = $("#hidden_class_name").val();
		var hidden_from = $("#hidden_from").val();
		if( jQuery.trim(input_class_name) == "" ) {
            alert("班级名称不能为空");
            return false;
        }
		
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/class/ajax.update",
            data: {
                input_property: input_property,
                input_teacher_id: input_teacher_id,
                input_class_name: input_class_name,
                input_amount: input_amount,
				input_class_minute: input_class_minute,
				input_class_address: input_class_address,
				input_class_time: input_class_time,
				input_open_date: input_open_date,
				input_comments: input_comments,
				class_id:class_id,
				hidden_input_class_name:hidden_class_name,
				hidden_from:hidden_from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				var data = resp.data;
                if( data.update ==1 ) {
                    alert("保存成功");
                    window.location = "/class/list" + data.from;
                }
                if( data.update == -2 ) {
                    alert("已有该班级名称，请重试");
					$("#input_class_name").val(hidden_class_name);
                    return false;
                }
            }
        });
    }

}