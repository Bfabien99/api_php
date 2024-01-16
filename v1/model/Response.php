<?php

    class Response{
        private $_success;
        private $_httpStatusCode;
        private $_messages = [];
        private $_data;
        private $_toCache = false;
        private $_responseData = [];
        

        /**
         * Set the value of _success
         *
         * @return  self
         */ 
        public function setSuccess($success)
        {
            $this->_success = $success;

            return $this;
        }

        /**
         * Set the value of _httpStatusCode
         *
         * @return  self
         */ 
        public function setHttpStatusCode($httpStatusCode)
        {
            $this->_httpStatusCode = $httpStatusCode;

            return $this;
        }

        /**
         * Set the value of _messages
         *
         * @return  self
         */ 
        public function addMessage($messages)
        {
            $this->_messages[] = $messages;

            return $this;
        }

        /**
         * Set the value of _data
         *
         * @return  self
         */ 
        public function setData($data)
        {
            $this->_data = $data;

            return $this;
        }

        /**
         * Set the value of _toCache
         *
         * @return  self
         */ 
        public function toCache($toCache)
        {
            $this->_toCache = $toCache;

            return $this;
        }

        public function send(){
            // Content-type: application/json => on retournera du json
            header('Content-type: application/json;charset=utf-8');

            // Cache-control: max-age=60 => autorisés à mettre en cache la ressource (telle qu'une page web ou une image) pendant 60 secondes
            if($this->_toCache == true){
                header('Cache-control: max-age=60');
            }else{
                header('Cache-control: no-cache, no-store');
            }

            // Vérifie si _success et _httpStatusCode sont correctes
            if(($this->_success !== true && $this->_success !== false) || (!is_numeric($this->_httpStatusCode))){
                http_response_code(500);
                $this->_responseData['statusCode'] = 500;
                $this->_responseData['success'] = false;
                $this->addMessage("Response creation error");
                $this->_responseData['messages'] = $this->_messages;
            }
            else{
                http_response_code($this->_httpStatusCode);
                $this->_responseData['statusCode'] = $this->_httpStatusCode;
                $this->_responseData['success'] = $this->_success;
                $this->_responseData['messages'] = $this->_messages;
                $this->_responseData['data'] = $this->_data;
            }

            echo json_encode($this->_responseData);
        }
    }