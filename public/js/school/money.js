/**
 * 费用管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Money = {
	// add学期配置
	addConfigTerm:function() { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/money/ajax.add.config.term",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_config").html(resp);
            }
        });
	},
    saveConfigTerm:function() {
        var input_year = $("#input_year").val();
        var input_term_name = $("#input_term_name").val();
        var input_type = $("#input_type").val();
        var input_start_date = $("#input_start_date").val();
        var input_end_date = $("#input_end_date").val();
        var input_comments = $("#input_comments").val();
        
        if(jQuery.trim(input_term_name) == "") {
            alert("学期名称不能为空");
            return false;
        }
        
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/money/ajax.save.config.term",
            data: {
                input_year:input_year,
                input_term_name:input_term_name,
                input_type:input_type,
                input_start_date:input_start_date,
                input_end_date:input_end_date,
                input_comments:input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp==-1) {
                    alert("该学期已存在，请重试");
                    return false;
                }
                if(resp>0) {
                    alert("添加成功");
                     window.location = "/money/list.config.term";
                }
            }
        });
    },
	// 查看学期配置信息
	viewConfigTerm:function(term_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/money/ajax.view.config.term",
            data: {
				term_id:term_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_config").html(resp);
            }
        });
	},
	// 编辑学期配置信息
	editConfigTerm:function(term_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/money/ajax.edit.config.term",
            data: {
				term_id:term_id,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_config").html(resp);
            }
        });
	},
	
    updateConfigTerm:function(term_id,from) {
        var input_start_date = $("#input_start_date").val();
        var input_end_date = $("#input_end_date").val();
        var input_comments = $("#input_comments").val();
        
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/money/ajax.update.config.term",
            data: {
				term_id:term_id,
                input_start_date:input_start_date,
                input_end_date:input_end_date,
                input_comments:input_comments,
				from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp>0) {
                    alert("修改成功");
                    window.location = "/money/list.config.term" ;
                }
            }
        });
    },
    
	//#######################
	addConfigMoneyProject:function() { 
        
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/money/ajax.add.config.money.project",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_config").html(resp);
            }
        });
	},
	viewConfigMoneyProject:function(mp_id,from) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/money/ajax.view.config.money.project",
            data: {
                mp_id:mp_id,
                from:from,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_config").html(resp);
            }
        });
	},
	getMoneyByWhere:function() { 
		var money_date = $("#money_date").val();
		var class_id = $("#class_id").val();
		var term_id = $("#term_id").val();
		var project_id = $("#project_id").val();
		if(class_id==0 || term_id==0 || project_id==0) { 
			return false;
		}
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/money/ajax.get.money.by.where",
            data: {
				money_date:money_date,
				class_id:class_id,
				term_id:term_id,
				project_id:project_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				$("#td_money").html(resp);
				$("#hidden_money").val(resp);
            }
        });
		
	},
	
	editConfigMoneyProject:function(project_id,from) { 
		var hidden_project_name = $("#hidden_project_name").val();
		var input_comments = $("#input_comments").val();
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/money/ajax.edit.config.money.project",
            data: {
				project_id:project_id,
				from:from,
				hidden_project_name:hidden_project_name,
				input_project_name:input_project_name,
				input_comments:input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_config").html(resp);
            }
        });
	},
	
	saveConfigMoneyProject:function() {
		var input_project_name = $("#input_project_name").val(); 
		var input_comments = $("#input_comments").val();
		if(jQuery.trim(input_project_name) == "") { 
			alert("项目名称不能为空");
			return false;
		}
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/money/ajax.save.config.money.project",
            data: {
				input_project_name:input_project_name,
				input_comments:input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp == -1) { 
					alert("该项目名称已存在，请重试");
					return false;
				}
				if(resp>0) { 
					alert("添加成功");
					window.location = "/money/list.config.money.project";
				}
            }
        });
	},
	
	checkConfigMoney:function() { 
		var class_id = $("#class_id").val();
		var term_id = $("#term_id").val();
		var project_id = $("#project_id").val();
		var money = $("#money").val();
		if(class_id==0) { 
			alert("班级不能为空");
			return false;
		}
		if(term_id==0) { 
			alert("学期不能为空");
			return false;
		}
		if(project_id==0) { 
			alert("费用项目不能为空");
			return false;
		}
		if(jQuery.trim(money)=="") { 
			alert("收费金额不能为空");
			return false;
		}
		
	}
	
	
	
}