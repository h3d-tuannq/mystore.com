<?php

namespace backend\models;

use common\models\base\CustomerType;
use common\models\Common;
use common\models\Customer;
use common\models\Employee;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductUnit;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * ImportForm form
 */
class ImportForm extends ExcelForm
{
    public $attachment;
    public $result;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment'], 'required'],
        ];
    }

    public function import()
    {
        if(!$this->validate()){
            return false;
        }

        $objPHPExcel = $this->readExcel(Yii::getAlias('@storage') . '/web/source/' . $this->attachment['path']);
        if ($objPHPExcel) {
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $count = 0;
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($row == 1) {
                    continue;
                }

                $employee = new Employee();
                $employee->slug = $rowData[0][0]; // Mã nhân viên
                $employee->name = $rowData[0][1]; // Tên nhân viên
                $employee->gender = $rowData[0][2]; // Giới tính
                $employee->birth_of_date = $rowData[0][3]; // Ngày sinh nhật
                $employee->phone = $rowData[0][4]; // Số điện thoại
                $employee->email = $rowData[0][5]; // email
                $employee->identify = $rowData[0][6]; // CMT
                $employee->status = Common::STATUS_ACTIVE;
                $employee->save();
                $count++;
                //print_r($employee->getErrors());
            }
            $this->result = $count;
            return true;
        }
        return false;
    }

    // Import customer
    public function importCustomer()
    {
        if(!$this->validate()){
            return false;
        }
        $objPHPExcel = $this->readExcel(Yii::getAlias('@storage') . '/web/source/' . $this->attachment['path']);
        if ($objPHPExcel) {
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $count = 0;
            $countNew = 0;
            $countUpdate = 0;

            $customerTypes = ArrayHelper::map(CustomerType::find()->all(),'slug','id');
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($row == 1) {
                    continue;
                }
                $code = $rowData[0][0];
                $customer = Customer::findOne(['slug' => $code]);
                if ($customer) {
                    // Đã có
                    $countUpdate++;
                } else {
                    $customer = new Customer();
                    $customer->slug = $rowData[0][0]; // Mã nhân viên
                    $countNew++;
                }

                $customer->name = $rowData[0][1]; // Tên nhân viên
                $customer->phone = $rowData[0][2]; // Điện thoai
                $customer->address = $rowData[0][3]; // Dia chi
                $customer->email = $rowData[0][4]; // Email
                $customer->group = $rowData[0][5]; // nhom khach
                $customer->source = $rowData[0][6]; // nguon khach
                //$customer->city  = $rowData[0][7]; // Tinh thanh
                //$customer->province  = $rowData[0][8]; // Quan huyen
                //$customer->gender  = $rowData[0][9]; // Gioi tinh
                //TODO sua truong ngay sinh
                if ($rowData[0][10]) {
                    //$customer->birth_of_date = '' . \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][10]); // ngay sinh
                    $birth_of_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($rowData[0][10]); // ngay sinh
                    $customer->birth_of_date = date('Y-m-d',$birth_of_date);
                    $customer->day = date('d', $birth_of_date);
                    $customer->month = date('m', $birth_of_date);
                    $customer->year = date('Y', $birth_of_date);
                }
                //$customer->created_at  = strtotime(date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][11]))); // Ngay tao
                //$customer->updated_at  = strtotime(date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($rowData[0][12]))); // Ngay sua
                $customer->status = Common::STATUS_ACTIVE;
                $customer->is_notification_birthday = Common::STATUS_ACTIVE;
                $customer->is_notification_service = Common::STATUS_ACTIVE;
                //Cột N kiểu khách hàng
                if($rowData[0][13] && $customerTypes[$rowData[0][13]]){
                    $customer->customer_type_id = $customerTypes[$rowData[0][13]];
                }
                //$customer->save();
                if(!$customer->save()){
                    var_dump($customer->slug);
                    var_dump($customer->birth_of_date);
                    var_dump($customer->getErrors());die;
                }

                $count++;
            }
            $this->result = $count;
            return true;
        }
        return false;
    }


    // Import customer
    public function importProduct()
    {
        if(!$this->validate()){
            return false;
        }
        $objPHPExcel = $this->readExcel(Yii::getAlias('@storage') . '/web/source/' . $this->attachment['path']);
        if ($objPHPExcel) {
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $count = 0;
            $countUpdate = 0;
            $countNew = 0;
            $errorSlugs = [];
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($row == 1 || is_null($rowData[0][1])) {
                    continue;
                }

                $code = $rowData[0][1];
                $product = Product::findOne(['slug' => $code]);
                if ($product) {
                    // Đã có
                    $countUpdate++;
                } else {
                    $product = new Product();
                    $countNew++;
                }

                $product->product_type = $rowData[0][0]; // A Nhóm hàng
                $product->slug = strval($rowData[0][1]); // B Mã Hàng

                $product->name = $rowData[0][2]; // C Tên hàng
                //$product->product_unit_id  = $rowData[0][3]; //  D Đơn vị tính
                $product->product_unit = $rowData[0][3]; //  D Đơn vị tính
                $product->retail_price = (int)$rowData[0][4]; // E Giá bán
                $product->input_price = (int)$rowData[0][5]; // F Giá nhập
                $product->specification = $rowData[0][6]; // G Quy cách
                $product->made_in = $rowData[0][7]; // H Xuất xứ
                $product->quantity = $rowData[0][10]; // Số lượng
                $product->status = Common::STATUS_ACTIVE;
                if($rowData[0][11] || $rowData[0][11] == '0'){
                    $product->is_notification = $rowData[0][11]; // L Thông báo
                }else{
                    $product->is_notification = Common::STATUS_ACTIVE;
                }

                if($rowData[0][12]){
                    $product->limit_quantity = $rowData[0][12]; // M Ngưỡng thông báo
                }

                if ($product->save()) {
                    $count++;
                } else {
                    $errorSlugs[] = 'Line ' . $row . ': ' . implode(', ',$product->getFirstErrors());
                }
            }
            $this->result = $count;
            $this->results = array(
                'new' => $countNew,
                'updated' => $countUpdate,
                'errorSlugs' => $errorSlugs,
            );
            return true;
        }
        return false;
    }


    // Import customer
    public function importProductType()
    {
        if(!$this->validate()){
            return false;
        }
        $objPHPExcel = $this->readExcel(Yii::getAlias('@storage') . '/web/source/' . $this->attachment['path']);
        if ($objPHPExcel) {

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $count = 0;
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($row == 1) {
                    continue;
                }

                $product = new ProductType();
                $product->slug = $rowData[0][0]; // Mã nhân viên
                $product->name = $rowData[0][1]; // Tên nhân viên
                $product->group = $rowData[0][2]; // Nhóm
                $product->status = Common::STATUS_ACTIVE;
                $product->save();
                $count++;
            }
            $this->result = $count;
            return true;
        }
        return false;
    }


    // Import customer
    public function importProductUnit()
    {
        if(!$this->validate()){
            return false;
        }
        $objPHPExcel = $this->readExcel(Yii::getAlias('@storage') . '/web/source/' . $this->attachment['path']);
        if ($objPHPExcel) {

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $count = 0;
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($row == 1) {
                    continue;
                }

                $unit = new ProductUnit();
                $unit->slug = $rowData[0][0]; // Mã nhân viên
                $unit->name = $rowData[0][1]; // Tên nhân viên
                $unit->description = $rowData[0][2]; // Nhóm
                $unit->status = Common::STATUS_ACTIVE;
                $unit->save();
                $count++;
            }
            $this->result = $count;
            return true;
        }
        return false;
    }
}
