/**
 * 权限管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Auth = {
    
    add:function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/auth/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_right").html(resp); 
            }
        });
    },
	saveRightInfo:function() {
        var input_rightname = $("#input_rightname").val();
        var input_comments = $("#input_comments").val();
        
        if(jQuery.trim(input_rightname) == "" ) { 
            alert("权限名不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/auth/ajax.save.right.info",
            data: {
                input_rightname:input_rightname,
                input_comments:input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp == -2 ) {
                    alert("权限名已存在");
                    return false;
                }
                if( resp >0 ) {
                    alert("操作成功");
                    window.location = "/auth/list";
                } 
            }
        });
    },
	edit:function(right_id) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/auth/ajax.edit",
            data: {
                right_id: right_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_right").html(resp);
            }
        });
    },
    
}