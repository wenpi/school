/**
 * 学校管理
 * @auth taozywu
 * @date 2013/07/22
 */


var School = {
    
    edit:function(school_id) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/school/ajax.edit",
            data: {
                school_id: school_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_school").html(resp);
            }
        });
    },
    update:function(school_id,school_database_id) {
        var input_school_number = $("#input_school_number").val();
        var input_short_name = $("#input_short_name").val();
		var input_en_name = $("#input_en_name").val();
		var input_cn_name = $("#input_cn_name").val();
        var input_status = $("#input_status").val();
		
		var input_db_name = $("#input_db_name").val();
        var input_db_host = $("#input_db_host").val();
        var input_db_user = $("#input_db_user").val();
		var input_db_pass = $("#input_db_pass").val();
		var input_db_charset = $("#input_db_charset").val();
		var input_db_port = $("#input_db_port").val();
		
		var hidden_short_name = $("#hidden_short_name").val();
		
        if( jQuery.trim(input_short_name) == "" || jQuery.trim(input_cn_name) == "" ) { 
            alert("数据库标识或中文名不能为空");
            return false;
        }
        
		if(jQuery.trim(input_db_name) == "" || jQuery.trim(input_db_user) == "" || jQuery.trim(input_db_pass) == "" ) { 
			alert("数据库名称或用户名或密码不能为空");
			return false;
		}
		
		if(jQuery.trim(input_db_name) == "" || jQuery.trim(input_db_port) == "" ) { 
			alert("主机名或端口不能为空");
			return false;
		}
		
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/school/ajax.update",
            data: {
				school_id:school_id,
                input_school_number:input_school_number,
                input_short_name:input_short_name,
                input_en_name:input_en_name,
				input_cn_name:input_cn_name,
                input_status:input_status,
				hidden_short_name:hidden_short_name,
				school_database_id:school_database_id,
				input_db_name: input_db_name,
                input_db_host:input_db_host,
				input_db_user:input_db_user,
				input_db_pass:input_db_pass,
				input_db_charset:input_db_charset,
				input_db_port:input_db_port,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				if( resp == -1 ) { 
					alert("数据库标识已存在");
					return false;
				}
				if( resp == -2) { 
					alert(" 数据库连接失败. ");
					return false;
				}
				if( resp == -3 ) { 
					alert(" 未找到数据库 " + input_db_name + "." );
					return false;
				}
                if( resp == 1 ) {
                    alert("操作成功");
                    window.location = "/school/list";
                    return false;
                } 
            }
        });
    },
    
    add:function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/school/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_school").html(resp); 
            }
        });
    },
    save:function() {
        var input_school_number = $("#input_school_number").val();
        var input_short_name = $("#input_short_name").val();
        var input_en_name = $("#input_en_name").val();
        var input_cn_name = $("#input_cn_name").val();
        var input_status = $("#input_status").val();
        
        if(jQuery.trim(input_school_number) == "" || jQuery.trim(input_short_name) == "" 
                || jQuery.trim(input_cn_name) == "") { 
            alert("学校编码/数据库标识/中文名不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/school/ajax.save",
            data: {
                input_school_number:input_school_number,
                input_short_name:input_short_name,
                input_en_name:input_en_name,
                input_cn_name:input_cn_name,
                input_status:input_status,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp == -2 ) {
                    alert("学校已存在");
                    return false;
                }
                if( resp >0 ) {
                    alert("操作成功");
                    window.location = "/school/list";
                } 
            }
        });
    },
	delete:function(school_id) { 
		jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/school/ajax.delete",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp >0 ) {
                    alert("操作成功");
                    window.location = "/school/list";
                } 
            }
        });
	}
    
}