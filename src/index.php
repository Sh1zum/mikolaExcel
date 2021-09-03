<?php
use Mikola\App;
require __DIR__ . '/../vendor/autoload.php';
$app = new \Mikola\App();

if(isset($argv[1])){

    if ($argv[1] === 'update' )
    {
        $app->updateDatabase();
    }
    elseif($argv[1] === 'run'){
        $app->run();
    }
    elseif($argv[1] === 'clear'){
        $app->clearDatabase();
    }

    elseif($argv[1] === 'api'){
        $app->returnApi();
    }
}
else{
    $app->returnApi();
}





