<?php

    class DB{
        private static $writeDBConnection;
        private static $readDBConnection;

        public static function connectWriteDB(){
            if(self::$writeDBConnection === null){
                self::$writeDBConnection = new PDO('mysql:host=localhost:3306;dbname=tasksdb;charset=utf8', 'root', '');
                self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }

            return self::$writeDBConnection;
        }

        public static function connectReadDB(){
            if(self::$readDBConnection === null){
                self::$readDBConnection = new PDO('mysql:host=localhost:3306;dbname=tasksdb;charset=utf8', 'root', '');
                self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                self::$readDBConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }

            return self::$readDBConnection;
        }

        public static function FilDB():void
        {
            $con = self::connectWriteDB();
            for($i=1;$i<=100;$i++){
                $r = rand(1, 100);
                if($r%2==0){
                    $c = 'Y';
                }else{
                    $c = 'N';
                }
                $query = $con->prepare("INSERT INTO tbltasks(title, description, deadline, completed) VALUES('title{$i}', 'description{$i}', NOW(), '$c')");
                $query->execute();

                $rowCount = $query->rowCount();

                if($rowCount != 0){
                    error_log("task $i added!");
                }else{
                    error_log("x task $i not added! x");
                }
            }
            error_log("task finished!");
        }
    }