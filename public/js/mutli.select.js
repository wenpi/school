// JavaScript Document
/**
 * 列表操作对象
 * 方法引用例子：
 * var oListBox = document.getElementById("id");
 * ListUtil.clear(oListBox);//清空一个列表框。
 * ListUtil.clearById("oListBox");//清空一个列表框。
 * var args =  ListUtil.getSelectedIndexes(oListBox);
 *
 * 作者：wenxing
 * QQ:20076678 希望多多交流.
 */

/**
 * 多个多选下拉列表添加删除等。
 * @type Object
 */
var ListUtil = new Object();

/**
 * 返回所有被选中的索引
 * @param {Object} oListBox
 */
ListUtil.getSelectedIndexes = function(oListBox) {
    var arrIndexes = new Array;
//	alert(oListBox.options.length);
    for (var i = 0; i < oListBox.options.length; i++) {
        if (oListBox.options[i].selected) {
            arrIndexes.push(i);
        }
    }
    return arrIndexes;
};


/**
 * 增加一个项到列表中
 * @param {Object} oListBox 对象
 * @param {String} sName 要显示的文字
 * @param {String} sValue值
 */
ListUtil.add = function(oListBox, sName, sValue) {

    var oOption = document.createElement("option");

    oOption.appendChild(document.createTextNode(sName));
    if (arguments.length == 3) {
        //arguments.length 判断传入的参数是几个 ==3表达传入了sValue
        //可以利用此arguments.length方法来达到方法重载的效果
        oOption.setAttribute("value", sValue);
    }
    oListBox.appendChild(oOption);
};
/**
 * 增加一个项到列表中
 * @param {String} listBoxId
 * @param {String} sName 要显示的文字
 * @param {String} sValue值
 */
ListUtil.addById = function(listBoxId, sName, sValue) {
    var oListBox = document.getElementById(listBoxId);
    if (oListBox != null) {
        ListUtil.add(oListBox, sName, sValue);
    } else {
        alert("对象为空");
    }

};
/**
 * 根据索引删除一个项
 * @param {Object} oListBox
 * @param {int} iIndex
 */
ListUtil.remove = function(oListBox, iIndex) {
    oListBox.remove(iIndex);
};
/**
 * 根据索引删除一个项
 * @param {String} listBoxId
 * @param {int} iIndex
 */
ListUtil.removeById = function(listBoxId, iIndex) {
    var oListBox = document.getElementById(listBoxId);
    if (oListBox != null) {
        ListUtil.remove(oListBox, iIndex);
    } else {
        alert("对象为空");
    }
};
/**
 * 清除一个列表中的所有项
 * @param {Object} oListBox
 */
ListUtil.clear = function(oListBox) {
    for (var i = oListBox.options.length - 1; i >= 0; i--) {
        ListUtil.remove(oListBox, i);
    }

};
/**
 *
 * @param {string} oListBoxId
 */
ListUtil.clearById = function(oListBoxId) {
    var oListBox = document.getElementById(oListBoxId);
    if (oListBox != null) {
        ListUtil.clear(oListBox);
    } else {
        alert("对象为空");
    }


};

/**
 * 移动一个列表中的一项到另一个列表中
 * @param {Object} oListBoxForm
 * @param {Object} oListBoxTo
 * @param {int} iIndex
 */
ListUtil.move = function(oListBoxForm, oListBoxTo, iIndex) {

    var oOption = oListBoxForm.options[iIndex];
    if (oOption != null) {
        oListBox.appendChild(oOption);
    }

};

/**
 * 全选
 * @param {Object} oListBox
 */
ListUtil.SelectAll = function(oListBox) {
    for (var i = 0; i < oListBox.options.length; i++) {
        oListBox.options[i].selected = true;
    }
};
/**
 *
 * @param {String} oListBoxId
 */
ListUtil.SelectAllById = function(oListBoxId) {
    var oListBox = document.getElementById(oListBoxId);
    if (oListBox != null) {
        ListUtil.SelectAll(oListBox);
    } else {
        alert("不是有效列表对象");
    }

};
//
/**
 * 取消选择
 * @param {Object} oListBox
 */
ListUtil.UnSelectAll = function(oListBox) {
    for (var i = 0; i < oListBox.options.length; i++) {
        oListBox.options[i].selected = false;
    }
};
/**
 * 取消选择
 * @param {String} oListBoxId
 */
ListUtil.UnSelectAllById = function(oListBoxId) {
    var oListBox = document.getElementById(oListBoxId);
    if (oListBox != null) {
        ListUtil.UnSelectAll(oListBox);
    } else {
        alert("不是有效列表对象");
    }
};

/**
 * 将leftListBox列表中的所有已经选择的项移动到rightListBox列表中
 * @param {Object} leftListBox
 * @param {Object} rightListBox
 */
ListUtil.LeftMoveSelected = function(leftListBox, rightListBox) {

    for (var i = leftListBox.options.length - 1; i >= 0; i--) {
        if (leftListBox.options[i].selected) {
            rightListBox.appendChild(leftListBox.options[i]);
            //ListUtil.remove(leftListBox,i);
        }
    }
};
/**
 * 将leftListBox列表中的所有已经选择的项移动到rightListBox列表中
 * 传列表的id名称即可
 * @param {string} leftListBoxId
 * @param {string} rightListBoxId
 */
ListUtil.LeftMoveSelectedById = function(leftListBoxId, rightListBoxId) {
    var rightListBox = document.getElementById(rightListBoxId);
    var leftListBox = document.getElementById(leftListBoxId);
    ListUtil.LeftMoveSelected(leftListBox, rightListBox);
};
/**
 * 将rightListBox列表中的所有已经选择的项移动到leftListBox列表中
 * @param {Object} rightListBox
 * @param {Object} leftListBox
 */
ListUtil.RightMoveSelected = function(rightListBox, leftListBox) {
    ListUtil.LeftMoveSelected(rightListBox, leftListBox);
};
/**
 * 将rightListBox列表中的所有已经选择的项移动到leftListBox列表中
 * 传列表的id名称即可
 * @param {String} rightListBoxId
 * @param {String} leftListBoxId
 */
ListUtil.RightMoveSelectedById = function(rightListBoxId, leftListBoxId) {
    var rightListBox = document.getElementById(rightListBoxId);
    var leftListBox = document.getElementById(leftListBoxId);
    ListUtil.LeftMoveSelected(rightListBox, leftListBox);
};

/**
 * 将A列表中的所有项移动到B列表中
 * @param {Object} leftListBox
 * @param {Object} rightListBox
 */
ListUtil.LeftMoveAll = function(leftListBox, rightListBox) {

    for (var i = leftListBox.options.length - 1; i >= 0; i--) {

        rightListBox.appendChild(leftListBox.options[i]);
        //ListUtil.remove(leftListBox,i);

    }
};
/**
 * 将rightListBox列表中的所有项移动到leftListBox列表中
 * @param {Object} rightListBox
 * @param {Object} leftListBox
 */
ListUtil.RightMoveAll = function(rightListBox, leftListBox) {
    ListUtil.LeftMoveAll(rightListBox, leftListBox);
};
/**
 * 将rightListBox列表中的所有项移动到leftListBox列表中
 * @param {String} rightListBoxId
 * @param {String} leftListBoxId
 */
ListUtil.RightMoveAllById = function(rightListBoxId, leftListBoxId) {
    var rightListBox = document.getElementById(rightListBoxId);
    var leftListBox = document.getElementById(leftListBoxId);
    ListUtil.LeftMoveAll(rightListBox, leftListBox);
};

/**
 * leftListBoxId 列表中移动全部项到rightListBoxId
 * @param {String} leftListBoxId
 * @param {String} rightListBoxId
 */
ListUtil.LeftMoveAllById = function(leftListBoxId, rightListBoxId) {
    var rightListBox = document.getElementById(rightListBoxId);
    var leftListBox = document.getElementById(leftListBoxId);
    ListUtil.LeftMoveAll(leftListBox, rightListBox);
};