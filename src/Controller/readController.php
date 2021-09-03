<?php


namespace Mikola\Controller;
use Mikola\Services\constService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Ods;
class readController {

    public function readProduct() {
        $constService=new constService();
        $files = glob('./cenniki/*.{ods}', GLOB_BRACE);
        $data=[];
        $i=0;
        foreach($files as $odsPath) {
            $i=$i+1;
            $reader = new Ods();
            $spreadsheet = $reader->load($odsPath);
            $reader->setReadDataOnly(true);

            $productName = $spreadsheet->getActiveSheet()->getCell( 'B4' )->getValue();
            $widthMax = $spreadsheet->getActiveSheet()->getCell( 'E4' )->getValue();
            $heightMax = $spreadsheet->getActiveSheet()->getCell( 'E5' )->getValue();

            //części
            $partsPart = $spreadsheet->getActiveSheet()->rangeToArray( 'O7:O13');
            $startPricePart = $spreadsheet->getActiveSheet()->rangeToArray( 'P7:P13');
            $discountPart = $spreadsheet->getActiveSheet()->rangeToArray( 'Q7:Q13');
            $priceDiscountPart = $spreadsheet->getActiveSheet()->rangeToArray( 'R7:R13');
            $countPart = $spreadsheet->getActiveSheet()->rangeToArray( 'S7:S13');
            $finalPricePart = $spreadsheet->getActiveSheet()->rangeToArray( 'T7:T13');
            //

            $parts=$constService->mergeConstsArray($partsPart,$startPricePart,$discountPart,$priceDiscountPart,$countPart,$finalPricePart);

            //szerokosc
            $partsWidth = $spreadsheet->getActiveSheet()->rangeToArray( 'O15:O24');
            $startPriceWidth = $spreadsheet->getActiveSheet()->rangeToArray( 'P15:P24');
            $discountWidth = $spreadsheet->getActiveSheet()->rangeToArray( 'Q15:Q24');
            $priceDiscountWidth = $spreadsheet->getActiveSheet()->rangeToArray( 'R15:R24');
            $countWidth = $spreadsheet->getActiveSheet()->rangeToArray( 'S15:S24');
            $finalPriceWidth = $spreadsheet->getActiveSheet()->rangeToArray( 'T15:T24');

            $width=$constService->mergeConstsArray($partsWidth,$startPriceWidth,$discountWidth,$priceDiscountWidth,$countWidth,$finalPriceWidth);

            //wysokosc
            $partsHeight = $spreadsheet->getActiveSheet()->rangeToArray( 'O26:O35');
            $startPriceHeight = $spreadsheet->getActiveSheet()->rangeToArray( 'P26:P35');
            $discountHeight = $spreadsheet->getActiveSheet()->rangeToArray( 'Q26:Q35');
            $priceDiscountHeight = $spreadsheet->getActiveSheet()->rangeToArray( 'R26:R35');
            $countHeight = $spreadsheet->getActiveSheet()->rangeToArray( 'S26:S35');
            $finalPriceHeight = $spreadsheet->getActiveSheet()->rangeToArray( 'T26:T35');

            $height=$constService->mergeConstsArray($partsHeight,$startPriceHeight,$discountHeight,$priceDiscountHeight,$countHeight,$finalPriceHeight);

            $colors= $spreadsheet->getActiveSheet()->rangeToArray( 'B6:G7');
            $colors=$constService->compressArray($colors);

            $partsPrice = $spreadsheet->getActiveSheet()->getCell( 'B9' )->getValue();
            $partsPrice=$constService->clearData($partsPrice);

            $job = $spreadsheet->getActiveSheet()->getCell( 'B10' )->getValue();
            $job=$constService->clearData($job);

            $profit= $spreadsheet->getActiveSheet()->getCell( 'B11' )->getValue();
            $profit=$constService->clearData($profit);

            $constPrice=$spreadsheet->getActiveSheet()->getCell( 'C12' )->getValue();
            $constPrice=$constService->clearData($constPrice);

            $widthPrice=$spreadsheet->getActiveSheet()->getCell( 'C14' )->getValue();
            $widthPrice=$constService->clearData($widthPrice);

            $heightPrice=$spreadsheet->getActiveSheet()->getCell( 'C16' )->getValue();
            $heightPrice=$constService->clearData($heightPrice);

            $materials = $spreadsheet->getActiveSheet()->rangeToArray( 'B19:B22');

            $data[$i]=[
                'productName'=>$productName,
                'widthMax'=>$widthMax,
                'heightMax'=>$heightMax,
                'parts'=>$parts,
                'width'=>$width,
                'height'=>$height,
                'colors'=>$colors,
                'partsPrice'=>$partsPrice,
                'job'=>$job,
                'profit'=>$profit,
                'constPrice'=>$constPrice,
                'widthPrice'=>$widthPrice,
                'heightPrice'=>$heightPrice,
                'materials'=>$materials,




            ];
            $spreadsheet->disconnectWorksheets();
        }

        return $data;
    }




}
