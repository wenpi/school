/**
 * 岗位管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Job = {
    // 添加
    add: function() {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/job/ajax.add",
            data: {
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_job").html(resp);
            }
        });
    },
    save: function() {
        var input_job_level = $("#input_job_level").val();
        var input_job_name = $("#input_job_name").val();
        var input_comments = $("#input_comments").val();
        if (jQuery.trim(input_job_name) == "") {
            alert("岗位名称不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/job/ajax.save",
            data: {
                input_job_level: input_job_level,
                input_job_name: input_job_name,
                input_comments: input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if (resp == -2) {
                    alert("已有该岗位信息，请重试");
                    return false;
                }
                if (resp > 0) {
                    alert("添加成功");
                    return false;
                }
            }
        })
    },
    update: function(job_id) {
        var input_job_level = $("#input_job_level").val();
        var input_job_name = $("#input_job_name").val();
        var input_comments = $("#input_comments").val();
        var hidden_input_job_name = $("#hidden_input_job_name").val();
        if (jQuery.trim(input_job_name) == "") {
            alert("岗位名称不能为空");
            return false;
        }
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: "/job/ajax.update",
            data: {
                job_id: job_id,
                hidden_input_job_name: hidden_input_job_name,
                input_job_level: input_job_level,
                input_job_name: input_job_name,
                input_comments: input_comments,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                if(resp ==-2) {
                    alert("岗位名称已存在，请重试");
                    $("#input_job_name").val(hidden_input_job_name);
                    return false;
                }
                if (resp > 0) {
                    alert("操作成功");
                    window.location = "/job/list";
                }
            }
        });
    },
    edit:function(job_id) {
        jQuery.ajax({
            type: "POST",
            dataType: "html",
            url: "/job/ajax.edit",
            data: {
                job_id: job_id,
                j: 1,
                tt: Math.random()
            },
            success: function(resp) {
                $.validRight(resp);
                $("#div_job").html(resp);
            }
        });
    }

}