/**
 * 班级管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Class = {
	// 合并选择以谁为主
	showMergeTable:function(class_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/class/ajax.show.merge.table",
            data: {
				class_id:class_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				$("#div_merge").html(resp);
            }
        });
	},
	// 升级
	upgrade:function(class_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/class/ajax.upgrade",
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
	// 撤销
    cansle:function(class_id,from) {
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/class/ajax.cansle",
            data: {
				class_id:class_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
               
               if(resp ==-1) {
                    alert("该班级有幼儿数据，请先删除其下幼儿数据再重试");
                    return false;
                }
                
                if(resp.data.update>0) { 
					alert("撤销成功");
					window.location = "/class/list" + resp.data.from;
				}
                
                
            }
        });
    },
	
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
    // 保存班级
    save: function() {
		var input_type = $("#input_type").val();
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
				input_type: input_type,
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
		var input_type = $("#input_type").val();
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
				input_type: input_type,
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
    },
	merge:function(from) { 
		var gmChks = document.getElementsByName("class_id[]");	
		var checkVal = "";	
		var cCount = 0;
		for (var i=0; i<gmChks.length ; i++)
		{
			if(gmChks[i].checked) { 
				var cVal = $("#class_id_" + i).val();
				checkVal +=  "|" + cVal ;
				cCount +=1;
			}
		}
		if(cCount<2) { 
			alert("合并至少需要两个班级才能进行，请重试");
			return false;
		}
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/class/ajax.merge",
            data: {
                class_ids:checkVal,
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
	// 保存合并
	saveMerge:function( from ) {
		var hidden_class_ids = $("#hidden_class_ids").val();
		var input_type = $("#input_type").val();
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
            url: "/class/ajax.save.merge",
            data: {
				hidden_class_ids: hidden_class_ids,
				input_type: input_type,
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
				if(resp ==1) { 
					alert("合并成功");
					window.location = "/class/list" + from ;
				}
            }
        });
	},
	// 保存升级
	saveUpgrade:function(class_id,from) { 
		var input_type = $("#input_type").val();
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/class/ajax.save.upgrade",
            data: {
                class_id: class_id,
				input_type: input_type,
				from: from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp.data.update>0) { 
					alert("升级成功");
					window.location = "/class/list" + resp.data.from;
				}
            }
        });
	} 

}