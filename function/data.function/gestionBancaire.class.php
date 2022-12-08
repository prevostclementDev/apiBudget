<?php

    class gestionBancaire {

        private $cursor;

        private $host;
        private $user;
        private $password;
        private $db;	

        public $connectStatus = false;

        /* CONSTRUCTEUR */
        public function __construct(String $db, String $host = "localhost",String $user = "root",String $password = "") {

            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->db = $db;

            if ( $this->connect()[0] ) {
                $this->connectStatus = true;
            } else {
                $this->connectStatus = false;
                return $this->connect();
            }

        }

        /* SETTEUR */
        public function __set($name, $value){
            return false;
        }

        /* GETTEUR */
        public function __get($name){
            return false;
        }

        /* CONNECTION WITH DB */
        protected function connect() : array {

            $this->cursor = new PDO("mysql:host=$this->host;dbname=$this->db",$this->user,$this->password);
            if($this->cursor->errorInfo()[2] == null){
                return array(true,'connected');
            } else {
                return $this->cursor->errorInfo();
            }

        }

        protected function verificationInteraction(String $requete) : array {

            if ($this->cursor->errorInfo()[2] == null) {
                return array(true,$requete);
            }else {
                return array(false,$requete,$this->cursor->errorInfo());
            }

        }

        /* ############## */
        /* DB INTERACTION */
        /* ############## */

        public function addData(String $table, String $type , String $value) {

            $requete = 'INSERT INTO '.$table.' ('.$type.') VALUES ('.$value.');';
            
            $insert = $this->cursor->exec($requete);

            $verification = $this->verificationInteraction($requete);

            if ( !$verification[0] ) {
                return $verification;
            }

            return true;

        }

        public function deleteData(String $table, String $where) {

            $requete = 'DELETE FROM '.$table.' WHERE '.$where.' ;';

            $delete = $this->cursor->exec($requete);

            $verification = $this->verificationInteraction($requete);

            if ( !$verification[0] ) {
                return $verification;
            }

            return true;

        }

        public function updateData(String $table, String $modification , String $where) {

            $requete = 'UPDATE '.$table.' SET '.$modification.' WHERE '.$where.';';

            $update = $this->cursor->exec($requete);

            $verification = $this->verificationInteraction($requete);

            if ( !$verification[0] ) {
                return $verification;
            }

            return true;

        }

        public function selectData($table,$selection='*',$where="1") {
            $returnValue = [];   
            
            $requete = 'SELECT '.$selection.' FROM '.$table.' WHERE '.$where.';';

            if($select = $this->cursor->query($requete)) {
                while($value = $select->fetch(PDO::FETCH_OBJ)) {
                    array_push($returnValue,$value);
                }
                return $returnValue;
            } else {
                return array(false,$requete,$this->cursor->errorInfo());
            }
        }

        /* ############# */
        /* CREATION DATA */
        /* ############# */

        public function createAccount(String $id, String $mail) {

            return $this->addData('account','id,mail','"'.$id.'","'.$mail.'"');

        }


        /* ADD ACCOUNT TO GESTION SYSTEME */
        public function createAccountBanks(Int $accountNumber, String $name, String $id_account) {

            return $this->addData('account_banks','compte_number,name,id_account','"'.$accountNumber.'","'.$name.'","'.$id_account.'"');

        }

        /* ADD CATEGORIE TO SPECIFIC ACCOUNT NUMBER */
        public function createCategorie(Int $accountNumber, String $name) {

            return $this->addData('categories','name,account_banks_id','"'.$name.'"'.',"'.$accountNumber.'"');

        }

        /* ADD LIVRET TO SPECIFIC ACCOUNT NUMBER */
        public function createLivret(Int $accountNumber, String $name, Int $solde_base = 0) {

            return $this->addData('livret','name,solde_base,account_banks_id','"'.$name.'"'.',"'.$solde_base.'"'.',"'.$accountNumber.'"');

        } 

        /* ADD CHANGE TO SPECIFIC LIVRET AND CATEGORIE */
        public function createChange(String $name, Int $id_livret, Int $id_categorie, Int $montant , String $intitule , String $type_change , String $date) {

            return $this->addData('base_change','name,id_livret,id_categorie,montant,intitule,type_change,date','"'.$name.'"'.',"'.$id_livret.'"'.',"'.$id_categorie.'"'.',"'.$montant.'"'.',"'.$intitule.'"'.',"'.$type_change.'"'.',"'.$date.'"');

        } 

        /* ADD MENSUALITE TO SPECIFIC LIVRET AND CATEGORIE */
        public function createMensualite(String $name, Int $id_livret, Int $id_categorie, Int $montant , String $intitule ,Bool $actif , String $date , String $type_change) {

            return $this->addData('mensualites','name,id_livret,id_categorie,montant,intitule,actif,date,type_change','"'.$name.'"'.',"'.$id_livret.'"'.',"'.$id_categorie.'"'.',"'.$montant.'"'.',"'.$intitule.'"'.',"'.$actif.'"'.',"'.$date.'"'.',"'.$type_change.'"');

        }

    }