<?php

    class TaskException extends Exception{

    }

    class Task{
        private $_id;
        private $_title;
        private $_description;
        private $_deadline;
        private $_completed;

        
        public function __construct($id, $title, $description, $deadline, $completed){
            $this->setID($id);
            $this->setTitle($title);
            $this->setDescription($description);
            $this->setDeadline($deadline);
            $this->setCompleted($completed);
        }

        /**
         * Get the value of _id
         */ 
        public function getID()
        {
            return $this->_id;
        }

        /**
         * Get the value of _title
         */ 
        public function getTitle()
        {
            return $this->_title;
        }

        /**
         * Get the value of _description
         */ 
        public function getdescription()
        {
            return $this->_description;
        }

        /**
         * Get the value of _deadline
         */ 
        public function getDeadline()
        {
            return $this->_deadline;
        }

        /**
         * Get the value of _completed
         */ 
        public function getCompleted()
        {
            return $this->_completed;
        }

         /**
         * Set the value of _id
         */ 
        public function setID($id)
        {
            if(($id !== null) && (!is_numeric($id) || $id <=0 || $id > 9223372036854775807 || $this->_id !== null)){
                throw new TaskException("Task ID error!");
            }
            $this->_id = $id;
        }

        /**
         * Set the value of _title
         */ 
        public function setTitle($title)
        {
            if((strlen($title)<0 || strlen($title)>255)){
                throw new TaskException("Task title error!");
            }
            $this->_title = $title;
        }

        /**
         * Set the value of _description
         */ 
        public function setdescription($description)
        {
            if(($description !== null) && (strlen($description)>16777215)){
                throw new TaskException("Task description error!");
            }
            $this->_description = $description;
        }

        /**
         * Set the value of _deadline
         */ 
        public function setDeadline($deadline)
        {
            if(($deadline !== null) && date_format(date_create_from_format('d/m/Y H:i', $deadline),'d/m/Y H:i') != $deadline){
                throw new TaskException("Task deadline date time error! Format must be d/m/Y H:i");
            }
            $this->_deadline = $deadline;
        }

        /**
         * Set the value of _completed
         */ 
        public function setCompleted($completed)
        {
            if(strtoupper($completed) !== 'Y' && strtoupper($completed) !== 'N'){
                throw new TaskException("Task completed error! Must be Y or N");
            }
            $this->_completed = $completed;
        }

        public function returnTaskAsArray(){
            $task = [];
            $task['id'] = $this->getID();
            $task['title'] = $this->getTitle();
            $task['description'] = $this->getDescription();
            $task['deadline'] = $this->getDeadline();
            $task['completed'] = $this->getCompleted();
            return $task;
        }
    }