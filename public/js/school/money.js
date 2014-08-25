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
	viewConfigMoneyProject:function(mp_id) { 
		jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/money/ajax.view.config.money.project",
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
		
	}
	
	
	
}