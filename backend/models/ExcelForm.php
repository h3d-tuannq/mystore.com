<?php

namespace backend\models;

use common\models\Common;
use common\models\Customer;
use common\models\Employee;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductUnit;
use Yii;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * ExcelForm form
 */
class ExcelForm extends Model
{
    public $results;

    /**
     * Loads Spreadsheet from file using automatic Reader\IReader resolution.
     *
     * @param string $file The name of the spreadsheet file
     *
     *
     * @return Spreadsheet
     */
    public function readExcel($file)
    {
        if ($file && file_exists($file)) {
            try {
                return IOFactory::load($file);
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public function saveExcel($path,$spreadsheet)
    {
        // Create new Spreadsheet object
        //$spreadsheet = new Spreadsheet();
        // Set document properties


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($path);
    }
}
