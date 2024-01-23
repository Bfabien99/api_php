<?php
    require_once('db.php');
    require_once('../model/Task.php');
    require_once('../model/Response.php');

    try{
        $writeDB = DB::connectWriteDB();
        $readDB = DB::connectReadDB();
    }catch(PDOException $pDOException){
        error_log("Connection error - ". $pDOException->getMessage(), 0);
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
            try{
                $query = $readDB->prepare('SELECT id, title, description, DATE_FORMAT(deadline, "%d/%m/%Y %H:%i") AS deadline, completed FROM tbltasks WHERE id = :taskid');
                $query->bindParam(':taskid', $taskid, PDO::PARAM_INT);
                $query->execute();

                $rowCount = $query->rowCount();

                if($rowCount == 0){
                    $response = new Response();
                    $response->setHttpStatusCode(404);
                    $response->setSuccess(false);
                    $response->addMessage("Task not found!");
                    $response->send();
                    exit;
                }

                while($row = $query->fetch()){
                    $task = new Task($row['id'], $row['title'], $row['description'],$row['deadline'],$row['completed']);
                    $taskArray[] = $task->returnTaskAsArray();
                }
                $returnData = [];
                $returnData['rows_returned'] = $rowCount;
                $returnData['tasks'] = $taskArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->toCache(true);
                $response->setData($returnData);
                $response->send();
                exit;

            }catch(PDOException $pDOException){
                error_log("Connection error - ". $pDOException->getMessage(), 0);
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Database connection error!");
                $response->send();
                exit;
            }catch(TaskException $taskException){
                error_log("Database query error - ". $taskException->getMessage(), 0);
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Failed to get Task!");
                $response->send();
                exit;
            }
        }
        elseif($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            try{
                $query = $readDB->prepare('DELETE FROM tbltasks WHERE id = :taskid');
                $query->bindParam(':taskid', $taskid, PDO::PARAM_INT);
                $query->execute();

                $rowCount = $query->rowCount();

                if($rowCount == 0){
                    $response = new Response();
                    $response->setHttpStatusCode(404);
                    $response->setSuccess(false);
                    $response->addMessage("Task not found!");
                    $response->send();
                    exit;
                }
                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Task deleted!");
                $response->send();
                exit;
            }
            catch(PDOException $pDOException){
                error_log("Connection error - ". $pDOException->getMessage(), 0);
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Database connection error!");
                $response->send();
                exit;
            }
        }
        elseif($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH'){

        }
        else{
            $response = new Response();
            $response->setHttpStatusCode(405);
            $response->setSuccess(false);
            $response->addMessage("Method Not Allowed!");
            $response->send();
            exit;
        }
    }
    // Récupérer toutes les tâches complète
    if(array_key_exists('completed', $_GET)){
        $completed = $_GET['completed'];
        // Vérifier que la valeur de completed est correcte
        if($completed !== 'Y' && $completed !== 'N'){
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage("Completed must be Y or N");
            $response->send();
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            try{
                $query = $readDB->prepare('SELECT id, title, description, DATE_FORMAT(deadline, "%d/%m/%Y %H:%i") AS deadline, completed FROM tbltasks WHERE completed = :completed');
                $query->bindParam(':completed', $completed, PDO::PARAM_STR);
                $query->execute();

                $rowCount = $query->rowCount();

                $taskArray=[];
                while($row = $query->fetch()){
                    $task = new Task($row['id'], $row['title'], $row['description'],$row['deadline'],$row['completed']);
                    $taskArray[] = $task->returnTaskAsArray();
                }
                $returnData = [];
                $returnData['rows_returned'] = $rowCount;
                $returnData['tasks'] = $taskArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->toCache(true);
                $response->setData($returnData);
                $response->send();
                exit;

            }catch(PDOException $pDOException){
                error_log("Connection error - ". $pDOException->getMessage(), 0);
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Database connection error!");
                $response->send();
                exit;
            }catch(TaskException $taskException){
                error_log("Database query error - ". $taskException->getMessage(), 0);
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Failed to get Task!");
                $response->send();
                exit;
            }
        }else{
            $response = new Response();
            $response->setHttpStatusCode(405);
            $response->setSuccess(false);
            $response->addMessage("Method not allowed!");
            $response->send();
            exit;
        }
    }