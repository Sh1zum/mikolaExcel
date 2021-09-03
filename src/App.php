<?php
namespace Mikola;



use Mikola\Controller\productController;
use Mikola\Repository\connect;
use Mikola\Repository\productRepository;

class App
{


    public function run(){

        $read=new Controller\readController();
        return $product=$read->readProduct();

    }

    public function updateDatabase(){
    $product=$this->run();
    $productRepository=new productRepository();
    $productRepository->clearDatabase();
    $productRepository->insertIntoDatabase($product);

    }

    public function clearDatabase(){
        $product=$this->run();
        $productRepository=new productRepository();
        $productRepository->clearDatabase();

    }

    public function returnApi(){
        $productController=new productController();
        return $productController->returnProducts();


    }

}