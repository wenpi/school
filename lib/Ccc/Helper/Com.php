<?php

/**
 * 常用助手函数
 * @author taozywu <wutao@bwstor.com.cn>
 * @date 2013/04/27
 */
class Ccc_Helper_Com {

    /**
     * 信息提示
     * @param string $url
     * @param string $message
     * @param int $seconds
     * @param string $type = js|header|meta
     */
    public static function alertMess($url, $message, $seconds = 2, $type = "meta") {
        $where = "";
        switch ($type) {
            case "js":
                if (!empty($message)) {
                    $where .= "alert('{$message}');";
                }
                if (!empty($url)) {
                    $where .= "window.location.href='{$url}';";
                } else {
                    $where .= "javascript:history.go(-1);";
                }
                echo "<script type=\"text/javascript\">{$where}</script>";
                exit;
                break;
            case "header":
                if (!empty($message))
                    echo $message;
                header("Location:{$url}");
                exit;
                break;
            case "meta":
                if (!empty($message))
                    echo $message;
                echo "<meta http-equiv=\"refresh\" content=\"{$seconds};url={$url}\" />";
                echo "<script type=\"text/javascript\">window.location.href='{$url}';</script>";
                exit;
                break;
        }
    }

    /**
     * 获取客户端IP
     * @staticvar null $realip
     * @return mixed
     */
    public static function getIp() {
        static $realip = NULL;

        if ($realip !== NULL) {
            return $realip;
        }

        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr AS $ip) {
                    $ip = trim($ip);

                    if ($ip != 'unknown') {
                        $realip = $ip;

                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (isset($_SERVER['REMOTE_ADDR'])) {
                    $realip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $realip = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }

        return $realip;
    }

    /**
     * 截取 包括utf-8|gbk|gb2312|big5
     * @param string $str
     * @param int $start
     * @param int $length
     * @param string $charset
     * @return string|mixed
     */
    public static function msubstr($str, $start = 0, $length = 5, $charset = "utf-8") {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));

        return $slice;
    }

    /**
     * 无限分类
     * @param array $items
     * $items = array(
      1 => array('id' => 1, 'pid' => 0, 'name' => '江西省'),
      2 => array('id' => 2, 'pid' => 0, 'name' => '黑龙江省'),
     * )
     */
    public static function genTree($items) {
        foreach ($items as $item)
            $items[$item['pid']]['son'][$item['id']] = &$items[$item['id']];

        return isset($items[0]['son']) ? $items[0]['son'] : array();
    }

    /**
     * 通过生日来计算年龄
     */
    public static function genAgeByBirth($birthDate) {
        if (empty($birthDate))
            return 0;
        try {
            list($by, $bm, $bd) = explode('-', $birthDate);
            $cm = date('n');
            $cd = date('j');
            $age = date('Y') - $by - 1;
            if ($cm > $bm || $cm == $bm && $cd > $bd)
                $age++;
        } catch (Exception $e) {
            $age = 0;
        }

        return $age;
    }

    /**
     * 通过身份证来获取年龄
     * @param type $idNumber
     * @return int
     */
    public static function genAgeByIdNumber($idNumber) {
        if (empty($idNumber))
            return 0;
        $birthDate = substr($idNumber, 6, 8);
        $birthDateResult = $birthDate[0] . $birthDate[1] . $birthDate[2] . $birthDate[3] . "-";
        $birthDateResult .= $birthDate[4] . $birthDate[5] . "-";
        $birthDateResult .= $birthDate[6] . $birthDate[7];

        return self::genAgeByBirth($birthDateResult);
    }

    /**
     * 创建文件
     * @param type $fileName
     * @return boolean
     */
    public static function createFile($fileName, $mode = 0777) {
        if (file_exists($fileName))
            return false;
        self::createDir(dirname($fileName)); //创建目录
        @touch($fileName);
        @file_put_contents($fileName, "");

        return true;
    }

    /**
     * 创建目录
     * @param type $path
     * @param type $mode
     */
    public static function createDir($path, $mode = 0777) {
        if (is_dir($path))
            return false;
        self::createDir(dirname($path));
        @mkdir($path);
        @chmod($path, $mode);

        return true;
    }

    /**
     * 删除目录 递归
     * @param type $path
     * @param type $mode
     * @return boolean
     */
    public static function delDir($path, $mode = 0777) {
        $succeed = true;
        if (file_exists($path)) {
            $objDir = opendir($path);
            while (false !== ($fileName = readdir($objDir))) {
                if (($fileName != '.') && ($fileName != '..')) {
                    @chmod("{$path}/{$fileName}", $mode);
                    if (!is_dir("{$path}/{$fileName}")) {
                        if (!@unlink("{$path}/{$fileName}")) {
                            $succeed = false;
                            break;
                        }
                    } else {
                        self::delDir("{$path}/{$fileName}");
                    }
                }
            }
            if (!readdir($objDir)) {
                @closedir($objDir);
                if (!@rmdir($path)) {
                    $succeed = false;
                }
            }
        }

        return $succeed;
    }

    /**
     * 邮件发送
     * @param type $mailConfig
     * @param type $mailTo
     * @param type $mailSubject
     * @param type $mailContent
     */
    public static function sendMail($mailConfigArray, $mailToArray, $mailSubject, $mailContent) {
        //echo $mailConfigArray['host']."<br>";
        //print_r($mailConfigArray);exit;
        // 配置
//		$mailConfigArray = array(
//			"host" => "smtp.bwstor.com.cn",
//			"port" => 25,
//			"user_name" => "tianya@bwstor.com.cn",
//			"password" => "tianya,./" ,
//			"from" => "tianya@bwstor.com.cn",
//			"from_name" => "tianya@bwstor.com.cn",
//		);
        // 邮件人
//		$mailToArray = array(
//			"tianya@bwstor.com.cn" , "wutao@bwstor.com.cn"
//		);
        require_once '../ext/email/class.phpmailer.php';

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->IsHTML(true);
        $mail->Host = "{$mailConfigArray['host']}";
        $mail->Port = $mailConfigArray['port'];
        $mail->SMTPAuth = true;
        $mail->Username = "{$mailConfigArray['user_name']}";
        $mail->Password = "{$mailConfigArray['password']}";
        $mail->From = isset($mailConfigArray['from']) ? "{$mailConfigArray['from']}" : "{$mailConfigArray['user_name']}";
        $mail->FromName = isset($mailConfigArray['from_name']) ? "{$mailConfigArray['from_name']}" : "{$mailConfigArray['user_name']}";

        if (!empty($mailToArray)) {
            if (is_array($mailToArray)) {
                foreach ($mailToArray as $mailTo) {
                    $mail->AddAddress($mailTo);
                }
            } else {
                $mail->AddAddress($mailToArray);
            }
        }

        $mail->CharSet = "GBK";
        $mail->Subject = $mailSubject;
        $mail->Body = $mailContent;

        //print_r($mail);exit();
        if (!$mail->Send()) {

            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        } else {
            //echo "ok";
            return true;
        }
        //return !$mail->Send() ? false : true;
    }

    // excel 导出
    function outputExcel($datas, $titlename, $title, $filename) {
        $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">
	\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
        $str .= "<table border=1><tr>" . $titlename . "</tr>\r\n";
        $str .= $title;
        foreach ($datas as $key => $rt) {
            $str .= "<tr>";
            foreach ($rt as $k => $v) {
                $str .= "<td>{$v}</td>";
            }
            $str .= "</tr>\r\n";
        }
        $str .= "</table></body></html>";
        //echo $str;die();
        header("Content-Type: application/vnd.ms-excel; name='excel'");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        header("Expires: 0");
        exit($str);
    }

}

?>