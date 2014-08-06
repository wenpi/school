/**
 * 角色管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Role = {
    
    edit:function(role_id) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/role/ajax.edit",
            data: {
                role_id: role_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_role").html(resp);
            }
        });
    },
    updateRoleInfo:function(role_id) {
        var input_rolename = $("#input_rolename").val();
        var input_comments = $("#input_comments").val();
        if( jQuery.trim(input_rolename) == "" ) {
            alert("角色名不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/role/ajax.update.role.info",
            data: {
                role_id: role_id,
                input_rolename:input_rolename,
                input_comments:input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp == 1 ) {
                    alert("操作成功");
                    $("#td_rolename_"+role_id).html(input_rolename);
                    $("#td_comments_"+role_id).html(input_comments);
                    return false;
                } 
            }
        });
    },
    add:function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/role/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_role").html(resp); 
            }
        });
    },
     saveRoleInfo:function() {
        var input_rolename = $("#input_rolename").val();
        var input_comments = $("#input_comments").val();
        
        if(jQuery.trim(input_rolename) == "" ) { 
            alert("角色名不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/role/ajax.save.role.info",
            data: {
                input_rolename:input_rolename,
                input_comments:input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp == -2 ) {
                    alert("角色名已存在");
                    return false;
                }
                if( resp >0 ) {
                    alert("操作成功");
                    window.location = "/role/list";
                } 
            }
        });
    },
    delete:function(role_id) {
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/role/ajax.delete",
            data: {
                role_id:role_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp==1) {
                    alert("操作成功");
                    window.location = "/role/list";
                }
            }
        });
    }
}