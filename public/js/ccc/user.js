/**
 * 用户管理
 * @auth taozywu
 * @date 2013/07/22
 */


var User = {
    
    edit:function(user_id) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/user/ajax.edit",
            data: {
                user_id: user_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_user").html(resp);
            }
        });
    },
    updateUserInfo:function(user_id) {
        var input_realname = $("#input_realname").val();
        var input_ip = $("#input_ip").val();
        var input_status = $("#input_status").val();
        if(jQuery.trim(input_realname) == "") { 
            alert("用户名称不能为空");
            return false;
        }
        var input_status_name = "";
        if( input_status == 1 ) input_status_name = "[已激活]";
        if( input_status == 2 ) input_status_name = "[未激活]";
        if( input_status == 3 ) input_status_name = "[已冻结]";
        if( input_status == 4 ) input_status_name = "<font color='red'>[已删除]</font>";
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/user/ajax.update.user.info",
            data: {
                user_id: user_id,
                input_realname:input_realname,
                input_ip:input_ip,
                input_status:input_status,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp == 1 ) {
                    alert("操作成功");
                    $("#td_"+user_id).html(input_status_name+input_realname);
                    return false;
                } 
            }
        });
    },
    updateUserPass:function(user_id) {
        var input_newpass = $("#input_newpass").val();
        var input_renewpass = $("#input_renewpass").val();
        if( jQuery.trim(input_newpass) == "" ) {
            alert("输入新密码不能为空");
            return false;
        }
        if( input_newpass !== input_renewpass ) {
            alert("两次密码输入不同");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/user/ajax.update.user.pass",
            data: {
                user_id: user_id,
                input_newpass:input_newpass,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp === 1 ) {
                    alert("操作成功");
                    return false;
                } 
            }
        });
    },
    add:function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/user/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_user").html(resp); 
            }
        });
    },
    saveUserInfo:function() {
        var input_username = $("#input_username").val();
        var input_realname = $("#input_realname").val();
        var input_ip = $("#input_ip").val();
        var input_status = $("#input_status").val();
        var input_newpass = $("#input_newpass").val();
        var input_renewpass = $("#input_renewpass").val();
        
        if(jQuery.trim(input_username) == "" || jQuery.trim(input_realname) == "" 
                || jQuery.trim(input_newpass) == "") { 
            alert("用户名/用户名称/密码不能为空");
            return false;
        }
        if(input_newpass != input_renewpass) { 
            alert("两次密码输入不同");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/user/ajax.save.user.info",
            data: {
                input_username:input_username,
                input_realname:input_realname,
                input_ip:input_ip,
                input_status:input_status,
                input_newpass:input_newpass,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp == -2 ) {
                    alert("用户名已存在");
                    return false;
                }
                if( resp >0 ) {
                    alert("操作成功");
                    window.location = "/user/list";
                } 
            }
        });
    },
    showData:function(type_id) { 
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/user/ajax.show.data",
            data: {
                type_id: type_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#left_select").html(resp.data.left); 
                $("#right_select").html(resp.data.right); 
            }
        });
    }
    
}