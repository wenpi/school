<?php

/**
 * Excel导入导出类
 * @author taozywu<wutao@bwstor.com.cn>
 * @date 2013/04/25
 *
 * 调用如下：
 * 1.导出
 * $configs['file_name'] 为必填项 = 导出excel名称
 * $title = array("测试1","测试2","测试3",);	// excel数据头
 * $data = array(array("2","2","3"),);		// excel数据
 * Ccc_Third_Excel::getInstance( $configs )->export( $title , $data ));
 *
 * 2.导入
 * Ccc_Third_Excel::getInstance( )->import( "e:\dd.xlsx" , $result ) ;
 *
 */
class Ccc_Third_Excel {

    /**
     * 单例
     */
    private static $_singletonObject;
    // 设置属性
    private static $_configs = array();
    // excel obj
    private static $_objExcel = null;
    // 每一列的宽度
    private static $_width = 20;

    // 构造
    private function __construct($configs) {
        self::$_configs = $configs;
        $this->_init();
    }

    /**
     * 单例
     * @param array $configs
     * @return Email
     */
    public static function getInstance($configs = array()) {
//		echo "dd";
        $className = __CLASS__;
        if (!isset(self::$_singletonObject[$className]) || !self::$_singletonObject[$className]) {
            self::$_singletonObject[$className] = new self($configs);
        }

        return self::$_singletonObject[$className];
    }

    // 初始化
    private function _init() {
        require_once 'Excel/PHPExcel.php';
        require_once 'Excel/PHPExcel/Writer/Excel2007.php';
        require_once 'Excel/PHPExcel/Writer/Excel5.php';
        require_once 'Excel/PHPExcel/IOFactory.php';
    }

    /**
     * 配置
     * $_configs['version'] = 2003|2007;
     * $_configs['file_name'] = "test";
     * $_configs['width'] = 20;
     */
    private function _setExcelOutConfig() {
        self::$_objExcel = new PHPExcel;
        if (isset(self::$_configs['creator']))
            self::$_objExcel->getProperties()->setCreator(self::$_configs['creator']);
        if (isset(self::$_configs['last_modify']))
            self::$_objExcel->getProperties()->setCreator(self::$_configs['last_modify']);
        if (isset(self::$_configs['title']))
            self::$_objExcel->getProperties()->setCreator(self::$_configs['title']);
        if (isset(self::$_configs['subject']))
            self::$_objExcel->getProperties()->setCreator(self::$_configs['subject']);
        if (isset(self::$_configs['description']))
            self::$_objExcel->getProperties()->setCreator(self::$_configs['description']);
        if (isset(self::$_configs['keywords']))
            self::$_objExcel->getProperties()->setCreator(self::$_configs['keywords']);
        if (isset(self::$_configs['category']))
            self::$_objExcel->getProperties()->setCreator(self::$_configs['category']);
        self::$_objExcel->setActiveSheetIndex(0);
    }

    /**
     * excel导出功能
     * @param array $tableTitles
     * @param array $data
     */
    public function export($tableTitles, $data) {
        $this->_setExcelOutConfig();
//		die("ddd");
        // 设置表头一些相关
        if (!is_array($tableTitles) || !is_array($data))
            return false;
        // ABC
        $abcArr = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        // 设置excel第一行
        foreach ($tableTitles as $key => $value) {
            self::$_objExcel->getActiveSheet()->setCellValue($abcArr[$key] . "1", $value);
        }

        $i = 0;

        // 写入数据
        foreach ($data as $k => $v) {
            $u1 = $i + 2;
            foreach ($tableTitles as $key => $value) {
                self::$_objExcel->getActiveSheet()->setCellValue($abcArr[$key] . $u1, $v[$key]);
            }
            $i++;
        }

        // 设置每一列宽度
        foreach ($tableTitles as $key => $value) {
            self::$_objExcel->getActiveSheet()->getColumnDimension($abcArr[$key])->setWidth(self::$_width);
        }


        self::$_objExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
        self::$_objExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . self::$_objExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // 设置页方向和规模
        self::$_objExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        self::$_objExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        self::$_objExcel->setActiveSheetIndex(0);

        if (isset(self::$_configs['version']) && self::$_configs['version'] == '2007') { //导出excel2007文档
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . self::$_configs['file_name'] . '.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter(self::$_objExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        } else {  //导出excel2003文档
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . self::$_configs['file_name'] . '.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter(self::$_objExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    // 读取文件后缀名
    private function _getFileExt($fileName) {
        $extend = pathinfo($fileName);
        $extend = strtolower($extend["extension"]);

        return !$extend ? false : $extend;
    }

    /**
     * excel导入功能，返回数组
     * @param string $fileName
     * @param array $result
     * @return array|boolean
     */
    public function import($fileName, &$result) {
        if (!$this->_getFileExt($fileName))
            return "File name's ext error.";

        if ($this->_getFileExt($fileName) == "xls") {
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
        } else {
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        }

        try {
            $objPHPExcel = $objReader->load($fileName);
        } catch (Exception $e) {
            
        }

        if (!isset($objPHPExcel))
            return "You can not read file.";

        $result = array();
        $allobjWorksheets = $objPHPExcel->getAllSheets();
        foreach ($allobjWorksheets as $objWorksheet) {
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            $highestColumn = $objWorksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 2; $row <= $highestRow; ++$row) {
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $objWorksheet->getCellByColumnAndRow($col, $row);
                    $value = $cell->getValue();
                    if ($cell->getDataType() == PHPExcel_Cell_DataType::TYPE_NUMERIC) {
                        $cellstyleformat = $cell->getParent()->getStyle($cell->getCoordinate())->getNumberFormat();
                        $formatcode = $cellstyleformat->getFormatCode();
                        if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode)) {
                            $value = gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));
                        } else {
                            $value = PHPExcel_Style_NumberFormat::toFormattedString($value, $formatcode);
                        }
                    }
                    $result[$row - 1][$col] = $value;
                }
            }
        }

        return FALSE;
    }

}