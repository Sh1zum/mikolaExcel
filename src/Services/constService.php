<?php


namespace Mikola\Services;


class constService
{

    public function mergeConstsArray($parts,$startPrice,$discount,$priceDiscount,$count,$finalPrice){

        $resultsArr = [];


        for($i = 0; $i < count($parts); $i++) {

            $startPrice[$i]=self::clearData($startPrice[$i]);
            $priceDiscount[$i]=self::clearData($priceDiscount[$i]);
            $finalPrice[$i]=self::clearData($finalPrice[$i]);

            $resultsArr[$i]['part'] =  $parts[$i];
            $resultsArr[$i]['price'] =  $startPrice[$i];
            $resultsArr[$i]['discount'] = $discount[$i];
            $resultsArr[$i]['priceDiscount']=$priceDiscount[$i];
            $resultsArr[$i]['count'] = $count[$i];
            $resultsArr[$i]['finalPrice']= $finalPrice[$i] ;

            if( $resultsArr[$i]['part'][0] ==null &&
                $resultsArr[$i]['price'][0] ==null &&
                $resultsArr[$i]['discount'][0] ==null &&
                $resultsArr[$i]['priceDiscount'][0] ==null &&
                $resultsArr[$i]['count'][0] ==null &&
                $resultsArr[$i]['finalPrice'][0] ==null )
            {

                unset($resultsArr[$i]['part']);
                unset($resultsArr[$i]['price']);
                unset($resultsArr[$i]['discount']);
                unset($resultsArr[$i]['priceDiscount']);
                unset($resultsArr[$i]['count']);
                unset($resultsArr[$i]['finalPrice']);

            }


        }

        return array_filter($resultsArr);
    }

    public function clearData($param){

            $param=str_replace('zł.', '',$param);
            $param=str_replace('$', '',$param);
            $param=str_replace(',', '.',$param);

            return $param;
    }

    public function compressArray($array){
        $result = call_user_func_array('array_merge', $array);
        return array_filter($result);
    }





}