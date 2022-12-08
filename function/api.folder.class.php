<?php 

    require(__DIR__.DIRECTORY_SEPARATOR.'data.function'.DIRECTORY_SEPARATOR.'gestionBancaire.class.php');

    class createApiFolder {

        protected String $folderAcces;
        private String $userId;
        private String $mail;
        private bool $exist;

        public function __construct(String $userId, String $mail ,String $acces) {

            $this->userId = $userId;
            $this->folderAcces = $acces;
            $this->mail = $mail;

            $matches = is_numeric($this->userId);

            if ( strlen($userId) > 0 && $matches ) {

                $this->userId = $userId;
                $this->exist = $this->checkFolderExist();

            } else {

                $this->exist = false;

            } 

        }

        public function __set($name, $value){
            return false;
        }
        
        public function __get($name){
            return $this->$name;
        }

        private function createDBaccount() {

            $gestionBancaire = new gestionBancaire('gestionBancaire','localhost','root','');

            if ( $gestionBancaire->connectStatus ) {

                $exc = $gestionBancaire->createAccount($this->userId,$this->mail);
                return $exc;

            }

        }
        
        private function checkFolderExist() : bool {

            if ( is_dir($this->folderAcces) ) {

                $apiScan = scandir($this->folderAcces);

                if ( $apiScan != false ) {

                    foreach ( $apiScan as $apiFolder ) {

                        if ( is_dir($this->folderAcces.$apiFolder."/") && $apiFolder == $this->userId ) {

                            return true;

                        }

                    }

                }

            }

            return false;

        }

        public function createFolder() : bool {

            if ( !$this->exist ) {

                if ( $this->createDBaccount() ) {

                    if ( mkdir($this->folderAcces.$this->userId."/") ) {

                        copy($this->folderAcces."index.php",$this->folderAcces.$this->userId."/index.php");
    
                        return true;
    
                    }

                }

            }

            return false;

        }

    }