/**
 * 教工管理
 * @auth taozywu
 * @date 2013/07/22
 */


var Teacher = {
    check:function() {
        var cn_name = $("#cn_name").val();
        var sex = $("#sex").val();
        var birthday = $("#birthday").val();
        var address = $("#address").val();
        var id_type = $("#id_type").val();
        var id_name = $("#id_name").val();
        var mobile_phone = $("#mobile_phone").val();
        var job_id = $("#job_id").val();
        var job_date = $("#job_date").val();
        
        if(jQuery.trim(cn_name) =="") {
            alert("教工中文名称不能为空");
            return false;
        }
        if(sex<1) {
            alert("性别不能为空");
            return false;
        }
        if(jQuery.trim(birthday) == "") {
            alert("出生日期不能为空");
            return false;
        }
        if(jQuery.trim(address) == "") {
            alert("住址不能为空");
            return false;
        }
        if(jQuery.trim(id_name) == "") {
            alert("证件号码不能为空");
            return false;
        }
        if(jQuery.trim(mobile_phone) == "") {
            alert("手机号不能为空");
            return false;
        }
        if(job_id<1) {
            alert("岗位不能为空");
            return false;
        }
        if(jQuery.trim(job_date) == "") {
            alert("入职日期不能为空");
            return false;
        }
    },
	showhideByAdd:function(flag,table_dis) { 
		var val =  $("#span_"+flag).attr("value");
		if(val==1) { 
			$("#" + table_dis).hide();
			$("#span_"+flag).attr("value",0);
			$("#span_"+flag).html("↓");
		} else { 
			$("#" + table_dis).show();
			$("#span_"+flag).attr("value",1);
			$("#span_"+flag).html("↑");
		}
	}
    
}