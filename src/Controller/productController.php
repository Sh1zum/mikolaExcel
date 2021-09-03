<?php


namespace Mikola\Controller;


use Mikola\Repository\productRepository;

class productController
{

    public function returnProducts(){

        $productRepository=new productRepository();

        $response = empty($_GET['id']) ? $productRepository->getProducts() : $productRepository->getSingleProduct($_GET['id']);
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        echo $response;
        
    }

}