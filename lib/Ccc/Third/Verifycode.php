<?php

class Ccc_Third_Verifycode {

    // 单例对象
    private static $_singletonObject = null;
    // 宽度
    private $width = 50;
    // 高度
    private $height = 20;
    // 参数
    private $code = "";
    // 验证码方式
    private $mode = 2;
    // 长度
    private $len = 4;

    /**
     * 构造
     * @param type $code
     * @param type $mode
     * @param type $len
     */
    private function __construct($code, $mode, $len) {
        if (!isset($_SESSION))
            session_start();
        /**
         * 1=数字 2= 数字+字母
         */
        $this->mode = $mode;
        $this->len = $len;
        $this->code = $code;
    }

    /**
     * 单例
     * @param type $code
     * @param type $mode
     * @param type $len
     * @return Ccc_Third_Verifycode
     */
    public static function getInstance($code = "", $mode = 2, $len = 4) {
        $className = __CLASS__;
        if (!isset(self::$_singletonObject[$className]) || !self::$_singletonObject[$className]) {
            self::$_singletonObject[$className] = new self($code, $mode, $len);
        }

        return self::$_singletonObject[$className];
    }

    /**
     * 获取验证码
     * @return string  返回转换后的字符串
     */
    private function _getCode() {

        $chars = $this->mode == 1 ? '0123456789' : "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $authnum = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $this->len; $i++) {
            $authnum.= $chars[mt_rand(0, $max)];
        }
        $_SESSION['_check_code_' . $this->code] = $authnum;

        return $authnum;
    }

    /**
     * 对外显示验证码图片
     * @return mixed
     */
    public function show() {
        // 获取验证码
        $authnum = $this->_getCode();
        // 绘图
        $im = imagecreate($this->width, $this->height); //制定图片背景大小
        ImageColorAllocate($im, rand(160, 255), rand(160, 255), rand(160, 255));
        // 生成曲线干扰色
        for ($i = 0; $i < 10; $i++) {
            $lc = ImageColorAllocate($im, rand(100, 255), rand(100, 255), rand(100, 255));
            imageline($im, rand(0, $this->width), rand(0, $this->height), rand(0, $this->width), rand(0, $this->height), $lc);
        }

        $gray = imagecolorallocate($im, rand(0, 160), rand(0, 160), rand(0, 160));
        imagestring($im, 5, 5, 3, $authnum, $gray);

        Header("Content-type: image/PNG");
        $a = imagepng($im);
        imagedestroy($im);

        return $a;
    }

}

?>