<?php

namespace backend\models;

use common\models\base\Activity;
use common\models\base\ReportCustomer;
use common\models\base\ReportEmployee;
use common\models\base\ReportPayment;
use common\models\base\ReportProduct;
use common\models\base\ReportRevenue;
use common\models\base\ReportService;
use common\models\Common;
use common\models\Customer;
use common\models\Employee;
use common\models\Product;
use common\models\ProductType;
use common\models\ProductUnit;
use common\models\search\ActivitySearch;
use common\models\Service;
use common\models\ServiceProduct;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * ExportForm form
 */
class ExportForm extends ExcelForm
{
    public $export;

    public function export()
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/product.xlsx');

        if ($spreadsheet) {
            $path = '/export/product_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

//            $spreadsheet->getProperties()->setCreator('MySpa')
//                ->setLastModifiedBy('Admin')
//                ->setTitle('Report')
//                ->setSubject('Report Subject')
//                ->setDescription('Description.')
//                ->setKeywords('report')
//                ->setCategory('Test result file');

            // Thêm từ dòng 4
            $line = 3;
            $products = Product::findAll(['status' => 1]);;
            $worksheet = $spreadsheet->setActiveSheetIndex(0);
            foreach ($products as $product) {
                //$product
                $worksheet->setCellValue('A'.$line, $product->slug)
                    ->setCellValue('B'.$line, $product->name)
                    ->setCellValue('C'.$line, $product->product_type)
                    ->setCellValue('D'.$line, $product->input_price)
                    ->setCellValue('E'.$line, $product->retail_price)
                    ->setCellValue('F'.$line, $product->product_unit)
                    ->setCellValue('G'.$line, $product->quantity)
                    ->setCellValue('H'.$line, $product->quantity * $product->input_price)
                    ->setCellValue('I'.$line, $product->specification);
                $line++;
            }

            // Rename worksheet
            //$spreadsheet->getActiveSheet()->setTitle('Simple');

            $this->saveExcel($exportFile, $spreadsheet);
        }
    }

    public function exportService()
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/service.xlsx');

        if ($spreadsheet) {
            $path = '/export/service_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            // Thêm từ dòng 4
            $line = 3;
            $services = Service::find()->all();
            $worksheet = $spreadsheet->setActiveSheetIndex(0);
            foreach ($services as $service) {
                //$product
               // tên sp tiêu hao - số lượng sp -ddvt - giá nhập
                $serviceProducts = ServiceProduct::find()->where(['service_id'=>$service->id])->all();
                $start = $line;
                foreach ($serviceProducts as $serviceProduct) {
                    if($serviceProduct->product){
                        $worksheet->setCellValue('A'.$line, $service->slug)
                            ->setCellValue('B'.$line, $service->name)
                            ->setCellValue('C'.$line, $service->retail_price)
                            ->setCellValue('D'.$line, $serviceProduct->product->slug)
                            ->setCellValue('E'.$line, $serviceProduct->product->name)
                            ->setCellValue('F'.$line, $serviceProduct->amount)
                            ->setCellValue('G'.$line, $serviceProduct->unit)
                            ->setCellValue('H'.$line, $serviceProduct->product->input_price)
                            //->setCellValue('I'.$line, $service->total_price);
                            ->setCellValue('I'.$line, $serviceProduct->amount * $serviceProduct->product->input_price);
                        $line++;
                    }
                }
//                $worksheet->mergeCells("A$start:A$line");
//                $worksheet->setCellValueByColumnAndRow(0, $start, $service->slug);
//
//                $worksheet->mergeCells("B$start:B$line");
//                $worksheet->setCellValueByColumnAndRow(1, $start, $service->name);
//                $worksheet->mergeCells("C$start:C$line");
//                $worksheet->setCellValueByColumnAndRow(2, $start, $service->retail_price);
//                $worksheet->mergeCells("I$start:I$line");
//                $worksheet->setCellValueByColumnAndRow(8, $start, $service->total_price);
            }

            // Rename worksheet
            //$spreadsheet->getActiveSheet()->setTitle('Simple');

            $this->saveExcel($exportFile, $spreadsheet);
        }
    }

    public function exportRevenueDay($from,$to)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/revenue_day.xlsx');

        if ($spreadsheet) {
            $path = '/export/revenue_day_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            // Thêm từ dòng 4
            $line = 3;
            if($from && $to){
                $revenues = ReportRevenue::find()->where(['between','report_date',$from,$to])->orderBy('report_date desc')->all();
            }else{
                $revenues = ReportRevenue::find()->orderBy('report_date desc')->all();
            }

            if($revenues) {

                // Tổng hợp
                $worksheet = $spreadsheet->setActiveSheetIndex(0);
                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->report_date)
                        ->setCellValue('B' . $line, $revenue->revenue)
                        ->setCellValue('C' . $line, $revenue->revenue_order)
                        ->setCellValue('D' . $line, $revenue->loan);
                    $line++;
                }
                //Total
                $worksheet->setCellValue('A' . $line, "Tổng");
                $worksheet->setCellValue('B' . $line, "=SUM(B3:B" . ($line - 1) . ")");

                $worksheet->setCellValue('C' . $line, "Nợ");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');

                // Khách hàng
                $all_customers = ArrayHelper::map(Customer::find()->all(),'id','remain_money');
                // Thêm từ dòng 4
                $line = 3;
                $query = ReportCustomer::find();
                if($from && $to) {
                    $revenues = ReportCustomer::find()
                        ->where(['between','report_date',$from,$to])
                        ->orderBy('report_date desc')
                        ->all();
                }else{
                    $revenues = ReportCustomer::find()->orderBy('report_date desc')->all();
                }
                $worksheet = $spreadsheet->getSheet(1);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->customer_code)
                        ->setCellValue('B' . $line, $revenue->customer_name)
                        ->setCellValue('C' . $line, $revenue->report_date)
                        ->setCellValue('D' . $line, $revenue->revenue)
                        ->setCellValue('E' . $line, $all_customers[$revenue->customer_id]);
                    $line++;
                }

                //Total
                $worksheet->setCellValue('C' . $line, "Tổng");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
                $worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");


                //Dịch vụ
                $line = 3;
                if($from && $to){
                    $revenues = ReportService::find()->where(['between','report_date',$from,$to])->orderBy('report_date desc')->all();
                }else{
                    $revenues = ReportService::find()->orderBy('report_date desc')->all();
                }

                $worksheet = $spreadsheet->getSheet(2);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->service_code)
                        ->setCellValue('B' . $line, $revenue->service_name)
                        ->setCellValue('C' . $line, $revenue->report_date)
                        //->setCellValue('D' . $line, $revenue->revenue_order)
                        //->setCellValue('E' . $line, $revenue->revenue_order_quantity)
                        //->setCellValue('F' . $line, $revenue->revenue_activity)
                        //->setCellValue('G' . $line, $revenue->revenue_activity_quantity)
                        ->setCellValue('D' . $line, $revenue->revenue);
                    $line++;
                }
                //Total
                $worksheet->setCellValue('C' . $line, "Tổng");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");

                // Sản phẩm
                $line = 3;
                if($from && $to){
                    $revenues = ReportProduct::find()->where(['between','report_date',$from,$to])->orderBy('report_date desc')->all();
                }else{
                    $revenues = ReportProduct::find()->orderBy('report_date desc')->all();
                }
                $worksheet = $spreadsheet->getSheet(3);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->product_code)
                        ->setCellValue('B' . $line, $revenue->product_name)
                        ->setCellValue('C' . $line, $revenue->report_date)
                        ->setCellValue('D' . $line, $revenue->quantity_sell)
                        ->setCellValue('E' . $line, $revenue->quantity_use)
                        ->setCellValue('F' . $line, $revenue->quantity)
                        ->setCellValue('H' . $line, $revenue->unit)
                        ->setCellValue('H' . $line, $revenue->unit)
                        ->setCellValue('I' . $line, $revenue->revenue);
                    //->setCellValue('E' . $line, $revenue->);
                    $line++;
                }
                //Total
                $worksheet->setCellValue('C' . $line, "Tổng");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
                $worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                $worksheet->setCellValue('F' . $line, "=SUM(F3:F" . ($line - 1) . ")");
                $worksheet->setCellValue('I' . $line, "=SUM(I3:I" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');


                // Kết thúc set sheet đầu tiên là active
                $spreadsheet->setActiveSheetIndex(0);

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }

            //TODO
            return false;
        }
    }

    // Báo cáo cho khách hàng
    public function exportRevenueCustomer($customer_code,$from,$to)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/revenue_customer.xlsx');

        if ($spreadsheet) {
            $path = '/export/revenue_customer_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            $all_customers = ArrayHelper::map(Customer::find()->all(),'id','remain_money');
            // Thêm từ dòng 4
            $line = 3;
            $query = ReportCustomer::find();
            if($from && $to){
                $query->filterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $from), 'Y-m-d')
                    ,date_format(date_create_from_format('d/m/Y', $to),'Y-m-d')]);
            }
            $revenues = $query
                ->andFilterWhere(['like', 'customer_code', $customer_code])
                ->all();
            if($revenues) {
                $worksheet = $spreadsheet->setActiveSheetIndex(0);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->customer_code)
                        ->setCellValue('B' . $line, $revenue->customer_name)
                        ->setCellValue('C' . $line, $revenue->report_date)
                        ->setCellValue('D' . $line, $revenue->revenue)
                        ->setCellValue('E' . $line, $all_customers[$revenue->customer_id]);
                    $line++;
                }
                //Total
                $worksheet->setCellValue('C' . $line, "Tổng");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
                $worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }else{
                return false;
            }
        }
    }

    // Báo cáo cho sản phẩm
    public function exportRevenueProduct($code,$from,$to)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/revenue_product.xlsx');

        if ($spreadsheet) {
            $path = '/export/revenue_product_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            //$all_employees = ArrayHelper::map(Product::find()->all(),'id','slug');
            // Thêm từ dòng 4
            $line = 3;
            $query = ReportProduct::find();
            if($from && $to){
                $query->filterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $from), 'Y-m-d')
                    ,date_format(date_create_from_format('d/m/Y', $to),'Y-m-d')]);
            }
            $revenues = $query
                ->andFilterWhere(['like', 'product_code', $code])
                ->all();
            if($revenues) {
                $worksheet = $spreadsheet->setActiveSheetIndex(0);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->product_code)
                        ->setCellValue('B' . $line, $revenue->product_name)
                        ->setCellValue('C' . $line, $revenue->report_date)
                        ->setCellValue('D' . $line, $revenue->quantity_sell)
                        ->setCellValue('E' . $line, $revenue->quantity_use)
                        ->setCellValue('F' . $line, $revenue->quantity)
                        ->setCellValue('H' . $line, $revenue->unit)
                        ->setCellValue('H' . $line, $revenue->unit)
                        ->setCellValue('I' . $line, $revenue->revenue);
                        //->setCellValue('E' . $line, $revenue->);
                    $line++;
                }
                //Total
                $worksheet->setCellValue('C' . $line, "Tổng");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
                $worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                $worksheet->setCellValue('F' . $line, "=SUM(F3:F" . ($line - 1) . ")");
                $worksheet->setCellValue('I' . $line, "=SUM(I3:I" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }else{
                return false;
            }
        }
    }

    // Báo cáo cho nhân viên
    public function exportRevenueEmployee($employee_code,$from,$to)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/revenue_employee.xlsx');

        if ($spreadsheet) {
            $path = '/export/revenue_employee_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            $all_employees = ArrayHelper::map(Employee::find()->all(),'id','slug');
            // Thêm từ dòng 4
            $line = 3;
            $query = ReportEmployee::find();
            if($from && $to){
                $query->filterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $from), 'Y-m-d')
                    ,date_format(date_create_from_format('d/m/Y', $to),'Y-m-d')]);
            }
            $revenues = $query
                ->andFilterWhere(['like', 'employee_code', $employee_code])
                ->all();
            if($revenues) {
                $worksheet = $spreadsheet->setActiveSheetIndex(0);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->employee_code)
                        ->setCellValue('B' . $line, $revenue->employee_name)
                        ->setCellValue('C' . $line, $revenue->report_date)
                        ->setCellValue('D' . $line, $revenue->revenue_order)
                        ->setCellValue('E' . $line, $revenue->revenue_order_quantity)
                        ->setCellValue('F' . $line, $revenue->revenue_activity)
                        ->setCellValue('G' . $line, $revenue->revenue_activity_quantity)
                        ->setCellValue('H' . $line, $revenue->revenue);
                    $line++;
                }
                //Total
                $worksheet->setCellValue('C' . $line, "Tổng");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
                $worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                $worksheet->setCellValue('F' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                $worksheet->setCellValue('G' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                $worksheet->setCellValue('H' . $line, "=SUM(H3:H" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }else{
                return false;
            }
        }
    }

    public function exportRevenueService($code,$from,$to)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/revenue_service.xlsx');

        if ($spreadsheet) {
            $path = '/export/revenue_service_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            $all_services = ArrayHelper::map(Service::find()->all(),'id','slug');
            // Thêm từ dòng 4
            $line = 3;
            $query = ReportService::find();
            if($from && $to){
                $query->filterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $from), 'Y-m-d')
                    ,date_format(date_create_from_format('d/m/Y', $to),'Y-m-d')]);
            }
            $revenues = $query
                ->andFilterWhere(['like', 'service_code', $code])
                ->all();
            if($revenues) {
                $worksheet = $spreadsheet->setActiveSheetIndex(0);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->service_code)
                        ->setCellValue('B' . $line, $revenue->service_name)
                        ->setCellValue('C' . $line, $revenue->report_date)
                        //->setCellValue('D' . $line, $revenue->revenue_order)
                        //->setCellValue('E' . $line, $revenue->revenue_order_quantity)
                        //->setCellValue('F' . $line, $revenue->revenue_activity)
                        //->setCellValue('G' . $line, $revenue->revenue_activity_quantity)
                        ->setCellValue('D' . $line, $revenue->revenue)
                        ->setCellValue('E' . $line, $revenue->sell)
                        ->setCellValue('F' . $line, $revenue->use)
                        ->setCellValue('G' . $line, intval($revenue->spend))
                        ->setCellValue('H' . $line, intval($revenue->proceed))
                        ->setCellValue('I' . $line, intval($revenue->interest))
                        ->setCellValue('K' . $line, $revenue->quantity)
                        ->setCellValue('L' . $line, $revenue->employee_service);

                    $line++;
                }
                //Total
                $worksheet->setCellValue('C' . $line, "Tổng");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
                $worksheet->setCellValue('G' . $line, "=SUM(G3:G" . ($line - 1) . ")");
                $worksheet->setCellValue('H' . $line, "=SUM(H3:H" . ($line - 1) . ")");
                $worksheet->setCellValue('I' . $line, "=SUM(I3:I" . ($line - 1) . ")");
                //$worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('F' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('G' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('H' . $line, "=SUM(H3:H" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }else{
                return false;
            }
        }
    }

    public function exportRevenuePayment($code,$from,$to)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/revenue_payment.xlsx');

        if ($spreadsheet) {
            $path = '/export/revenue_payment_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            $all_services = ArrayHelper::map(Service::find()->all(),'id','slug');
            // Thêm từ dòng 4
            $line = 3;
            $query = ReportPayment::find()->filterWhere(['<>','payment_id',6]);
            if($from && $to){
                $query->filterWhere(['between', 'report_date', date_format(date_create_from_format('d/m/Y', $from), 'Y-m-d')
                    ,date_format(date_create_from_format('d/m/Y', $to),'Y-m-d')]);
            }
            $revenues = $query
                ->andFilterWhere(['payment_id'=>$code])
                ->all();
            //var_dump($revenues);die;
            if($revenues) {
                $worksheet = $spreadsheet->setActiveSheetIndex(0);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->report_date)
                        ->setCellValue('B' . $line, $revenue->month)
                        ->setCellValue('C' . $line, $revenue->year)
                        ->setCellValue('D' . $line, $revenue->payment_name)
                        ->setCellValue('E' . $line, $revenue->revenue);
                    $line++;
                }
                //Total
                $worksheet->setCellValue('D' . $line, "Tổng");
                $worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('F' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('G' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('H' . $line, "=SUM(H3:H" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }else{
                return false;
            }
        }
    }

    public function exportRevenueServiceMonth($code,$year,$month)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/revenue_service_month.xlsx');

        if ($spreadsheet) {
            $path = '/export/revenue_service_month_' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            $all_services = ArrayHelper::map(Service::find()->all(),'id','slug');
            // Thêm từ dòng 4
            $line = 3;
            $revenues = ReportService::find()
                    ->select('year,month, service_id, service_name, service_code, sum(`use`) as `use`')
                    ->where(['>','use',0])
                    ->andFilterWhere(['year' =>$year])
                    ->andFilterWhere(['month' =>$month])
                    ->andFilterWhere(['like', 'service_code', $code])
                    ->groupBy(['month','year','service_id'])
                    ->all();
            if($revenues) {
                $worksheet = $spreadsheet->setActiveSheetIndex(0);

                foreach ($revenues as $revenue) {
                    $worksheet->setCellValue('A' . $line, $revenue->year)
                        ->setCellValue('B' . $line, $revenue->month)
                        ->setCellValue('C' . $line, $revenue->service_code)
                        ->setCellValue('D' . $line, $revenue->service_name)
                        ->setCellValue('E' . $line, $revenue->use);

                    $line++;
                }
                //Total
                $worksheet->setCellValue('D' . $line, "Tổng");
                $worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }else{
                return false;
            }
        }
    }
    public function exportEmployeeService($id,$from,$to)
    {
        $spreadsheet = $this->readExcel(Yii::getAlias('@backend') . '/web/template/report/employee_service.xlsx');

        if ($spreadsheet) {
            $path = '/export/employee_service' . date('Y-m-d-his') . '.xlsx';
            $this->export = Yii::getAlias('@backendUrl') . $path;
            $exportFile = Yii::getAlias('@backend') . '/web' . $path;

            $all_services = ArrayHelper::map(Service::find()->all(),'id','slug');

            // Thêm từ dòng 4
            $line = 3;
            $query = Activity::find()->select(['*','count(service_id) as count_time','sum(discount) as total_money']);
            if($from && $to){
                $query->andFilterWhere(['between', 'start_time', strtotime(date_format(date_create_from_format('d/m/Y', $from), 'Y-m-d'))
                    ,strtotime(date_format(date_create_from_format('d/m/Y', $to),'Y-m-d'))]);
            }
            $query->orderBy('start_time desc');
            $query->groupBy('service_id');
            $revenues = $query
                ->andWhere(['employee_id'=> $id])
                ->all();

            if($revenues) {
                $worksheet = $spreadsheet->setActiveSheetIndex(0);
                $employee = Employee::findOne($id);
                $worksheet->setCellValue('A1' , " Nhân viên $employee->slug : $employee->name làm dịch vụ từ ngày $from đến ngày $to");
                foreach ($revenues as $revenue) {
                    if($revenue->service) {
                        $worksheet->setCellValue('A' . $line, $revenue->service->slug)
                            ->setCellValue('B' . $line, $revenue->service->name)
                            ->setCellValue('C' . $line, $revenue->count_time)
                            ->setCellValue('D' . $line, $revenue->total_money);

                        $line++;
                    }
                }
                //Total
                $worksheet->setCellValue('B' . $line, "Tổng");
                $worksheet->setCellValue('C' . $line, "=SUM(C3:C" . ($line - 1) . ")");
                $worksheet->setCellValue('D' . $line, "=SUM(D3:D" . ($line - 1) . ")");
//                $worksheet->setCellValue('H' . $line, "=SUM(H3:H" . ($line - 1) . ")");
//                $worksheet->setCellValue('I' . $line, "=SUM(I3:I" . ($line - 1) . ")");
                //$worksheet->setCellValue('E' . $line, "=SUM(E3:E" . ($line - 1) . ")");s
                //$worksheet->setCellValue('F' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('G' . $line, "=SUM(E3:E" . ($line - 1) . ")");
                //$worksheet->setCellValue('H' . $line, "=SUM(H3:H" . ($line - 1) . ")");
                // Rename worksheet
                //$spreadsheet->getActiveSheet()->setTitle('Simple');

                $this->saveExcel($exportFile, $spreadsheet);
                return true;
            }else{
                return false;
            }
        }
    }

}
