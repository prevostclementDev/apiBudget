<?php
    class returnAddons {

        private $returnData = array(
            'state' => false,
            'message' => 'error',
            'messageData' => 'missing parameters',
            'data' => null
        );

        public function __construct() {
            return false;
        }

        public function __set($name, $value){
            return false;
        }

        public function __get($name){
            return false;
        }

        public function returnErrorCode($code,$information) {

            $this->returnData['state'] = false;
            $this->returnData['message'] = utf8_encode($code);
            $this->returnData['messageData'] = utf8_encode($information);

            header('Content-Type: application/json; charset=utf-8');
            return json_encode($this->returnData);
        }

        public function returnGoodCode($code,$information,$data = null) {

            $this->returnData['state'] = true;
            $this->returnData['message'] = utf8_encode($code);
            $this->returnData['messageData'] = utf8_encode($information);
            $this->returnData['data'] = $data;

            header('Content-Type: application/json; charset=utf-8');
            return json_encode($this->returnData);
        }

    }