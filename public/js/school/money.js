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
	}
	
}