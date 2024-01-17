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
        $response->addMessage("Database connection error");
        $response->send();
        exit;
    }
