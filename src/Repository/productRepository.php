<?php


namespace Mikola\Repository;

use Mikola\Connection\Connect;

class productRepository
{
    public function clearDatabase(){

        $sql = "
        TRUNCATE TABLE `consts`;
          TRUNCATE TABLE `economy`;
           TRUNCATE TABLE `materials`;
             TRUNCATE TABLE `Products`;
             TRUNCATE TABLE `colors`;
                 TRUNCATE TABLE `type`; ";

        try {
            $core = Connect::getInstance();
            $stmt = $core->dbh->prepare($sql);
            $stmt->execute();

        }catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function insertIntoDatabase($products)
    {


        $typeData= [];
        self::insertIntoTable("type","name"," ('czesc'),('szerokosc'),('wysokosc')",$typeData);

        foreach ($products as $product){

            $productData = [
                'name' => $product['productName'],
                'width_max' => $product['widthMax'],
                'height_max' => $product['heightMax'],
            ];
            self::insertIntoTable("Products","name, width_max, height_max","(:name, :width_max, :height_max)",$productData);

            $core = Connect::getInstance();
            $lastProductId = $core->dbh->lastInsertId();

            $materialData = [
                'product_id'=>$lastProductId,
                'group1' => $product['materials'][0][0],
                'group2' => $product['materials'][1][0],
                'group3' => $product['materials'][2][0],
                'group4' => $product['materials'][3][0],
            ];
            self::insertIntoTable("materials","product_id, group_1, group_2,group_3,group_4","(:product_id,:group1,:group2,:group3,:group4)",$materialData);


            $economyData = [
                'product_id'=>$lastProductId,
                'partsPrice'=>$product['partsPrice'],
                'job'=>$product['job'],
                'profit'=>$product['profit'],
                'constPrice'=>$product['constPrice'],
                'widthPrice'=>$product['widthPrice'],
                'heightPrice'=>$product['heightPrice'],

            ];
            self::insertIntoTable("economy","product_id,parts_price, job,profit,const_price,width_price,height_price","(:product_id,:partsPrice,:job,:profit,:constPrice,:widthPrice,:heightPrice)",$economyData);

            $constsData=[];
            foreach ($product['parts'] as $part){

                $constsData= [
                'product_id'=>$lastProductId,
                'part'=>$part['part'][0],
                'start_price'=>$part['price'][0],
                'discount'=>$part['discount'][0],
                'price_discount'=>$part['priceDiscount'][0],
                'count'=>$part['count'][0],
                'final_price'=>$part['finalPrice'][0],
                'type_id'=>'1',
            ];

                self::insertIntoTable("consts","product_id, part, start_price,discount,price_discount,count,final_price,type_id","(:product_id, :part, :start_price,:discount,:price_discount,:count,:final_price,:type_id)",$constsData);

            }

            $constsData=[];
            foreach ($product['width'] as $width){

                $constsData= [
                'product_id'=>$lastProductId,
                'part'=>$width['part'][0],
                'start_price'=>$width['price'][0],
                'discount'=>$width['discount'][0],
                'price_discount'=>$width['priceDiscount'][0],
                'count'=>$width['count'][0],
                'final_price'=>$width['finalPrice'][0],
                'type_id'=>'2',
            ];

                self::insertIntoTable("consts","product_id, part, start_price,discount,price_discount,count,final_price,type_id","(:product_id, :part, :start_price,:discount,:price_discount,:count,:final_price,:type_id)",$constsData);

            }

            $constsData=[];
            foreach ($product['height'] as $height){

                $constsData= [
                'product_id'=>$lastProductId,
                'part'=>$height['part'][0],
                'start_price'=>$height['price'][0],
                'discount'=>$height['discount'][0],
                'price_discount'=>$height['priceDiscount'][0],
                'count'=>$height['count'][0],
                'final_price'=>$height['finalPrice'][0],
                'type_id'=>'3',
            ];

                self::insertIntoTable("consts","product_id, part, start_price,discount,price_discount,count,final_price,type_id","(:product_id, :part, :start_price,:discount,:price_discount,:count,:final_price,:type_id)",$constsData);

            }

            $colorData=[];
            foreach ($product['colors'] as $color){

                $colorData= [
                    'product_id'=>$lastProductId,
                    'color'=>$color,

                ];
                self::insertIntoTable("colors","product_id,color_name","(:product_id,:color)",$colorData);

            }

        }




    }


    public function insertIntoTable($tableName,$tableColumns,$values,$data)
    {
        $sql="INSERT INTO ".$tableName." (".$tableColumns.") VALUES ".$values;

        try {
            $core = Connect::getInstance();
            $stmt = $core->dbh->prepare($sql);
            if($data!==[]){
                $stmt->execute($data);
            }else{
                $stmt->execute();
            }


        }catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function selectFromTable($tableName,$values)
    {
        $sql="SELECT ".$values." FROM ".$tableName

        ;
        $return=[];
        try {
            $core = Connect::getInstance();
            $stmt = $core->dbh->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
               $return[]=$row;
            }

        }catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return $return;

    }

    public function selectAllFromTableWithParam($tableName,$value,$param)
    {
        $core = Connect::getInstance();
        $sql="SELECT * FROM ".$tableName." WHERE ".$value."=?";
        $return=[];
        try {
            $stmt = $core->dbh->prepare($sql);
            $stmt->execute([$param]);
            while ($row = $stmt->fetch()) {
                $return[]=$row;
            }

        }
        catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return $return;

    }



    public function getProducts(){
        $sql="SELECT id as product_id,name FROM Products";
        $return=[];
        try {
            $core = Connect::getInstance();
            $stmt = $core->dbh->prepare($sql);
            $stmt->execute();

            $mock=[
                'shortDesc'=>'Lorem Ipsum',
                'imgUrl'=>'https://www.knall.com.pl/media/towary/big/88/88e97dfae1b48eea8a2e3028f8358d38.jpg' ,
                'startPrice'=>'34',
            ];
            while ($row = $stmt->fetch()) {
                $row=array_merge($row,$mock);
                $return[]=$row;

            }

        }catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

return json_encode($return,JSON_PRETTY_PRINT);

    }

    public function getSingleProduct($id){
$mock= ['imgUrl'=>'https://www.knall.com.pl/media/towary/big/88/88e97dfae1b48eea8a2e3028f8358d38.jpg'] ;
$product=self::selectAllFromTableWithParam('Products','id',$id);
$product[0]['images']=$mock;

$result=[
        'productData'=>$product[0],
        'colors'=>self::selectAllFromTableWithParam('colors ','product_id',$id),
        'consts'=>self::selectAllFromTableWithParam('consts ','product_id',$id),
        'economy'=>self::selectAllFromTableWithParam('economy ','product_id',$id),
        'materials'=>self::selectAllFromTableWithParam('materials ','product_id',$id),
        'type'=>self::selectFromTable('type','*'),
];


//        $result['colors']['asdasd']=$result['colors']['product_id'];
//        unset($result['colors']['product_id']);


        return json_encode($result,JSON_PRETTY_PRINT);
    }







}