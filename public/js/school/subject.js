/**
 * 科目管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Subject = {
    // 添加
    add: function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/subject/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_subject").html(resp);
            }
        });
    },
    // 保存科目
    save: function() {
        var input_type_id = $("#input_type_id").val();
        var input_class_id = $("#input_class_id").val();
        var input_subject_name = $("#input_subject_name").val();
        var input_comments = $("#input_comments").val();
        if( input_class_id == 0 ) {
            alert("请选择一个班级");
            return false;
        }
        if( jQuery.trim(input_subject_name) == "" ) {
            alert("科目名称不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/subject/ajax.save",
            data: {
                input_type_id: input_type_id,
                input_class_id: input_class_id,
                input_subject_name: input_subject_name,
                input_comments: input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp>0 ) {
                    alert("添加成功");
                    window.location = "/subject/list";
                }
                if( resp == -2 ) {
                    alert("该班已有该科目名称，请重试");
                    return false;
                }
            }
        });
    },
    // 编辑
    edit: function(subject_id) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/subject/ajax.edit",
            data: {
                subject_id: subject_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_subject").html(resp);
            }
        });
    },
    // 更新
    update:function(subject_id) {
        var input_type_id = $("#input_type_id").val();
        var input_class_id = $("#input_class_id").val();
        var input_subject_name = $("#input_subject_name").val();
        var input_comments = $("#input_comments").val();
        
        var hidden_class_id = $("#hidden_class_id").val();
        var hidden_subject_name = $("#hidden_subject_name").val();
        if( jQuery.trim(input_subject_name) == "" ) {
            alert("科目名称不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/subject/ajax.update",
            data: {
                subject_id: subject_id,
                input_type_id: input_type_id,
                input_subject_name: input_subject_name,
                input_comments: input_comments,
                hidden_class_id: hidden_class_id,
                hidden_subject_name: hidden_subject_name,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if( resp>0 ) {
                    alert("保存成功");
                    window.location = "/subject/list";
                }
                if( resp == -2 ) {
                    alert("该班已有该科目名称，请重试");
                    return false;
                }
            }
        });
    }

}