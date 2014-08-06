/**
 * 权限管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Right = {
    // 通过用户获取角色数据
    getRoleDataByUserId: function(user_id) {
        jQuery.ajax({
            type: "POST",
            url: "/right/ajax.get.role.data.by.user.id",
            data: {
                user_id: user_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_role_id").html(resp);
                $("#div_right_id").html("抱歉，请先选择某角色。");
            }
        });
    },
    // 通过角色获取权限数据
    getRightDataByRoleId: function(k, role_id) {
        // 选中
        var hidden_role_count = $("#hidden_role_count").val();
        for (var i = 0; i < hidden_role_count; i++) {
            if (i == k) {
                $("#span_role_id_" + i).css("color", "red");
            } else {
                $("#span_role_id_" + i).css("color", "");
            }
        }
        var user_id = $("#user_id").val();
        jQuery.ajax({
            type: "POST",
            url: "/right/ajax.get.right.data.by.role.id",
            data: {
                user_id: user_id,
                role_id: role_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_right_id").html(resp);
            }
        });
    },
    // @todo 用户角色权限权限全选
    checkAllRight: function(f,count) {
        var son_val = "";
        // 处理全选
        for (var i = 0; i < count; i++) {
            var obj = document.getElementById("input_right_" + i);
            son_val = son_val + "|" + obj.value;
            if( f== 1 ) {
                obj.checked = true;
            } else {
                obj.checked = false;
            }
        }
        // 保存用户角色权限
        Right.saveUserRoleRight(f, son_val);
    },
    // 用户角色权限权限选中某一个
    checkThisRight: function(check, k) {
        var son_val = $("#input_right_" + k).val();
        son_val = "|" + son_val;
        // 保存用户角色权限
        Right.saveUserRoleRight(check, son_val);
    },
    // 保存用户角色权限
    saveUserRoleRight: function(check, right_ids) {
        var user_id = $("#user_id").val();
        var role_id = $("#hidden_role_id").val();
        jQuery.ajax({
            type: "POST",
            url: "/right/ajax.save.user.role.right",
            data: {
                user_id: user_id,
                role_id: role_id,
                right_ids: right_ids,
                check: !check ? 0 : 1,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
            }
        });
    },
    // 通过权限获取资源信息
    getResourceDataByRightId:function(right_id) {
        jQuery.ajax({
            type: "POST",
            url: "/right/ajax.get.resource.data.by.right.id",
            data: {
                right_id: right_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#td_resource").html(resp);
            }
        });
    }
}