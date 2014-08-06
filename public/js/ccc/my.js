/**
 * 个人管理
 * @auth taozywu
 * @date 2013/07/22
 */


var My = {
    
    getpass:function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/my/ajax.getpass",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_my").html(resp);
            }
        });
    },
    
    updatepass:function() {
        var old_pass = $("#old_pass").val();
        var new_pass = $("#new_pass").val();
		var two_newpass = $("#two_newpass").val();
        if( jQuery.trim(old_pass) == "" ) {
            alert("请输入原密码！");
            return false;
        }
        if( jQuery.trim(new_pass) !== jQuery.trim(two_newpass) ) {
            alert("两次密码输入不同！");
            return false;
        }
		if( jQuery.trim(new_pass) == jQuery.trim(old_pass) ) { 
			alert("新密码不能和原密码一样！");
			return false;
		}
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/my/ajax.updatepass",
            data: {
				old_pass:old_pass,
                new_pass:new_pass,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
				if( resp == -1 ) { 
					alert("原密码输入不正确，请重试！");
					return false;
				}
                if( resp == 1 ) {
                    alert("操作成功，请重新登录！");
                    window.location = "/admin/logout";
					//$("#div_my").html("操作成功，请重新登录！");
                } 
            }
        });
    },
    
    
}