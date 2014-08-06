/**
 * jquery 扩展
 * @author taozywu
 * @date 2013/09/06
 */

/**
 * 处理ajax或js权限的判断 | -1000001 == 登录失效  -1000002 == 访问拒绝
 */
jQuery.validRight = function(param) {
    if (param === "-1000001") {
        alert("Session Lost.");
        return false;
    }
    if (param === "-1000002") {
        alert("Access Denied.");
        return false;
    }
    return true;
};