/**
 * 通用JS
 */
// 公用
String.prototype.trim= function(){return this.replace(/(^\s*)|(\s*$)/g, "");}


// 公用对象形式
var Common = {
	/**
	 * 检查日期格式 2012-04-12
	 * @param {type} str
	 * @returns {Boolean}
	 */
	checkDate: function(str)
	{
		var r = str.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/);
		if (r == null) {
			return 'null';
		}
		var d = new Date(r[1], r[3] - 1, r[4]);
		if (d.getFullYear() == r[1]
				&& (d.getMonth() + 1) == r[3]
				&& d.getDate() == r[4]) {
			return 'ok';
		}
		return 'error';
	},
	/**
	 * 检查时间 12:23:34
	 * @returns {String}
	 */
	checkTime: function(str) {
		var a = str.match(/^(\d{1,2})(:)?(\d{1,2})\2(\d{1,2})$/);
		if (a == null) {
			return 'null';
		}
		if (a[1] > 24 || a[3] > 60 || a[4] > 60)
		{
			return 'error';
		}
		return 'ok';
	},
	/**
	 * 检查字符串
	 */
	checkStr: function(str) {
		if (!/^[\.0-9a-zA-Z\u4E00-\u9FA5\/_-]+$/.test(str)) {
			return 'error';
		}
		return 'ok';
	},
	/**
	 * 检查数字
	 */
	checkNum: function(str) {
		if (!isNaN(str)) {
			return "ok";
		}
		return "error";
	},
	/**
	 * 编辑状态
	 */
	initEv: function(objid, url, parName) {
		var objid = '#' + objid;
		var obj = jQuery(objid);
		obj.click(function(e) {
			var obj_img = e.target;
			var src = obj_img.src;
			jQuery.ajax({
				type: "post",
				data: parName,
				dataType: 'text',
				url: url,
				success: function(response) {
					$.validRight(response);
					if (response == '1') {
						obj_img.src = "/imgs/bgimg/yes.gif";
					} else {
						obj_img.src = "/imgs/bgimg/no.gif";
					}
				}
			});
		});
	},
	/**
	 * 编辑输入状态
	 * @todo这个函数是可以扩展
	 * @param {type} _ipt    输入框中的id
	 * @param {type} col_v   输入框中的值 = 废弃
	 * @param {type} parVal  针对下拉中的下拉key、value
	 * @returns {String}
	 */
	initEditorInput: function(_ipt, col_v, input_type, par_val) {
		var s_append = "";
		if (input_type == null || input_type == "num") {
			input_type = "text";
		}
		// 文本字段
		if (input_type == "text")
		{
			s_append += "<span>";
			s_append += "<input type='text' id='" + _ipt + "' value='" + col_v + "' style=\"width:90%\"/>";
			s_append += "</span>";
		} else if (input_type == "select") {   // 下拉
			// 有没有下拉初始化值
			var _par_vals = par_val.split("|");
			var _ln = _par_vals.length;
			if (_ln > 0) {
				s_append += "<span><select id='" + _ipt + "' style=\"width:90%\" >";
				for (var _i = 0; _i < _ln; _i++) {
					var __par_vals = _par_vals[_i].split("=");
					if (__par_vals) {
						// parval => 1=test1|2=test2|3=test3
						if (__par_vals[0] == col_v) {
							s_append += "<option value='" + __par_vals[0] + "' selected>" + __par_vals[1];
						} else {
							s_append += "<option value='" + __par_vals[0] + "'>" + __par_vals[1];
						}
					} else {
						// parval => test1|test2|test3
						if (__par_vals[_i] == col_v) {
							s_append += "<option value='" + __par_vals[_i] + "' selected>" + __par_vals[_i];
						} else {
							s_append += "<option value='" + __par_vals[_i] + "'>" + __par_vals[_i];
						}
					}
				}
				s_append += "</option>";
				s_append += "</select></span>";
			} else {
				alert("请给下拉列表增加选项值.");
				return false;
			}
		} else if (input_type == "date") {
			s_append += "<span>";
			s_append += "<input type='text' id='" + _ipt + "' value='" + col_v + "' class='Wdate' ";
			s_append += "onClick='WdatePicker()' style=\"width:90%\" /></span>";
		} else if (input_type == "textarea") {
			s_append += "<span>";
			s_append += "<textarea id='" + _ipt + "' value='" + col_v + "' ";
			s_append += " style=\"width:90%\" ></textarea></span>";
		} else if (input_type == "file") {
			s_append += "<span>";
			s_append += "<input type='file' id='" + _ipt + "' value='" + col_v + "' ";
			s_append += " style=\"width:90%\" /></span>";
		}

		return s_append;
	},
	/**
	 * 检查编辑输入
	 * @todo这个函数是可以扩展
	 * @returns {undefined}
	 */
	initEditorCheck: function(_ipt_v, need_check, input_type, input_filter, input_filter_msg) {
		var _ck_rn = "";
		if (need_check == 1) {
			// 如果为空
			if (_ipt_v == null || _ipt_v == "") {
				alert("不能为空请重试");
				return false;
			}
			if (_ipt_v != null || _ipt_v != "") {
				if (input_type == "date") {
					_ck_rn = Common.checkDate(_ipt_v);
					if (_ck_rn == "error") {
						alert("日期格式不对请重试");
						return false;
					}
				}
				if (input_type == "num") {
					_ck_rn = Common.checkNum(_ipt_v);
					if (_ck_rn == "error") {
						alert("不是数字格式请重试");
						return false;
					}
				}
				if (input_type == "text") {
					_ck_rn = Common.checkStr(_ipt_v);
					if (_ck_rn == "error") {
						alert("不能输入\"中文，数字，字母，下划线_，中横线-\"以外的字符请重试");
						return false;
					}
				}
				if (input_filter != null || input_filter != "") {
					// 用正则来处理
					var _obj = new RegExp(input_filter);
					if (_obj.test(_ipt_v) == false) {
						alert(input_filter_msg);
						return false;
					}
				}
			}
		}

		return true;
	},
	/**
	 * 初始化编辑
	 * @param {type} objid          // id
	 * @param {type} url            // url
	 * @param {type} par_name       // 参数以及参数值
	 * @param {type} col            // 输入框的name
	 * @param {type} col_v          // 输入框的value
	 * @param {type} par_val        // 下拉中选项值，如果这项由值则必须 input_type = select
	 * @param {type} input_type     // text|num|select|date|textarea|file
	 * @param {type} need_check     // 1 = 需要做检查
	 * @param {type} input_filter       // 如果这项有值 则 need_check = 1
	 * @param {type} input_filter_msg   // 如果这项有值 则 need_check = 1
	 * @returns {undefined}
	 */
	initEditor: function(objid, url, par_name, col, col_v, par_val, input_type, need_check, input_filter, input_filter_msg) {
		var obj_id = '#' + objid;
		var obj = jQuery(obj_id);
		var _is_check = false; // 做判断后的表示
		var _is_click = false; // 做点击的表示
		var _is_cansle = false; // 做取消的表示

		var hiddenColVal = $("#hidden_" + objid).html();
		col_v = hiddenColVal == null || hiddenColVal == "undefiend" ? col_v : hiddenColVal;

		obj.hover(
				function() {
					jQuery(this).css("background-color", "yellow");
					jQuery(this).attr('title', '点击可编辑');
				},
				function() {
					jQuery(this).css("background-color", "");
					jQuery(this).attr('title', '');
				}
		);
		obj.click(function(e) {
			// 如果当前判断后的表示为false，则现实innerHTML.否则不显示
			if (!_is_check)
			{
				var obj_sp = e.target;
				var src = obj_sp.innerHTML;
				var _ipt = 'ipt_' + objid, _btn_ok = 'btn_ok_' + objid, _btn_qt = 'btn_qt_' + objid;
				var s_append = "";
				// updated by taozywu | 2013/08/16
				var hidden_col_val = $("#hidden_" + objid).html();
				col_v = hidden_col_val == null || hidden_col_val == "undefined" ? col_v : hidden_col_val;
				s_append = Common.initEditorInput(_ipt, col_v, input_type, par_val);
				s_append += '<span> <button  id="' + _btn_ok + '">确定</button> </span>';
				s_append += '<span> <button  id="' + _btn_qt + '">取消</button> </span>';
				obj_sp.innerHTML = s_append;
				// 显示html则标记_is_click为true
				_is_click = true;
			}

			var _ipt_ob = jQuery("#" + _ipt);
			var _btn_ok_ob = jQuery("#" + _btn_ok);
			var _btn_qt_ob = jQuery("#" + _btn_qt);
			//取消按钮事件
			_btn_qt_ob.click(function(e) {
				obj_sp.innerHTML = src;
				// 点击该取消标记_is_cansle为ture
				_is_cansle = true;
			});
			//确定按钮事件
			_btn_ok_ob.click(function(e) {
				var _ipt_v = _ipt_ob.val(), _check;
				// 判断检查
				_check = Common.initEditorCheck(_ipt_v, need_check, input_type, input_filter, input_filter_msg);
				if (!_check) {
					return false;
				}
				var en_str = encodeURIComponent(_ipt_v);
				var data = par_name + '&' + col + '=' + en_str;
				jQuery.ajax({
					type: "post",
					data: data,
					dataType: 'text',
					url: url,
					success: function(response) {
						$.validRight(response);
						// updated by taozywu
						obj_sp.innerHTML = response;
						var hidden_data = "<span id=\"hidden_" + objid + "\" style=\"display:none\">" + response + "</span>";
						$("" + hidden_data + "").insertAfter(obj_id);
						// 因ajax提交重新刷，只需要_is_check 为false即可。
						_is_check = false;
					}
				});
			});
			// 1.显示层同时点击取消2.没有显示层且没有点击取消
			if (_is_click && _is_cansle
					|| !_is_click && !_is_cansle) {
				_is_check = false;
			}
			// 1.显示层且没有点击取消和确定
			if (_is_click && !_is_cansle) {
				_is_check = true;
			}
			// _is_check 为false后，判断之前是否有点击过取消，有则重新为false
			if (!_is_check) {
				if (_is_cansle)
					_is_cansle = false;
			}
		});
	},
	//@todo 请编写者补全注释。
	inintEditorBlur: function(val, objShowId, objHideId)
	{
		$("#" + objShowId).click(function() {
			if (val != '' && objShowId != '' && objHideId != '')
			{
				$("#" + objShowId).hide();
				$("#" + objHideId).show();
				$("#" + objHideId).val(val);
			}
		})
	}
}