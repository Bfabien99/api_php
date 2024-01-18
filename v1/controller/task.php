<?php
    require_once('db.php');
    require_once('../model/Task.php');
    require_once('../model/Response.php');

    try{
        $writeDB = DB::connectWriteDB();
        $readDB = DB::connectReadDB();
    }catch(PDOException $pDOException){
        error_log("Connection error - ", $pDOException->getMessage(), 0);
        $response = new Response();
        $response->setHttpStatusCode(500);
        $response->setSuccess(false);
        $response->addMessage("Database connection error!");
        $response->send();
        exit;
    }

    // Vérifier s'il y a un paramètre 'taskid'
    if(array_key_exists('taskid', $_GET)){
        $taskid = $_GET['taskid'];
        // Vérifier que la valeur de taskid est correcte
        if($taskid == '' || $taskid<=0 || !is_numeric($taskid)){
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("Invalid taskid! Must be numeric and greater than 0");
            $response->send();
            exit;
        }

        // Agir en fonction de la méthode utilisée
        if($_SERVER['REQUEST_METHOD'] === 'GET'){

        }
        elseif($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH'){

        }
        elseif($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            
        }else{
            $response = new Response();
            $response->setHttpStatusCode(405);
            $response->setSuccess(false);
            $response->addMessage("Method Not Allowed!");
            $response->send();
            exit;
        }
    }