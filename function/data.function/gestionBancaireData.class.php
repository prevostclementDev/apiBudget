<?php

    require_once 'gestionBancaire.class.php';

    class gestionBancaireData extends gestionBancaire {

        /* ACCOUNT */
        private String $number;
        private String $mail;

        private Array $all = [];

        public function __construct(String $db ,String $accountNumber ,  String $host = "localhost",String $user = "root",String $password = ""){
            parent::__construct($db,$host,$user,$password,);
            $this->number = $accountNumber;
        }

        public function __set($name, $value){
            return false;
        }

        public function __get($name){
            return false;
        }

        public function getAccount() {
            $arrAccount = [];

            $getAccount = parent::selectData('account_banks','*','id_account='.$this->number);

            foreach ($getAccount as $key => $value) {

                $arrAccount[] = $value;

            }         
            
            $this->utf8_encode_deep($arrAccount);

            return $arrAccount;

        }

        public function getAll() {
            
            $account = $this->getAccount();

            foreach($account as $key => $value) {

                $value->livrets = [];
                
                $getLivret = parent::selectData('livret','*','account_banks_id='.$value->compte_number);

                foreach ($getLivret as $key => $livret) {
    
                    $this->utf8_encode_deep($livret);

                    $changeMensualites = $this->getChangesAndMensualites($livret);

                    $livret->change = $changeMensualites['transaction'];
                    $livret->mensualites = $changeMensualites['mensualite'];

                    $value->livrets[] = $livret;
    
                }

                $value->categories = [];

                $getCategories = parent::selectData('categories','*','account_banks_id='.$value->compte_number);

                foreach ($getCategories as $keyCategorie => $categorie) {

                    $this->utf8_encode_deep($categorie);

                    $value->categories[$categorie->id] = $categorie;

                }

                $this->all[] = $value;

            }

            return $this->all;

        }

        private function getChangesAndMensualites($livret) {

            $arrChangeMensualites = [
                "transaction" => [
                    "depense" => [],
                    "gain" => [],
                ],
                "mensualite" => [
                    "depense" => [],
                    "gain" => [],
                ]
            ];

            /* GET ALL CHANGE GAIN */
            $get = parent::selectData('base_change','*','id_livret='.$livret->id.' AND type_change="gain"');
                
            foreach ($get as $key => $value) {
                $arrChangeMensualites['transaction']['gain'][] = $value;
            }

            /* GET ALL CHANGE DEPENSE */
            $get = parent::selectData('base_change','*','id_livret='.$livret->id.' AND type_change="depense"');
                
            foreach ($get as $key => $value) {
                $arrChangeMensualites['transaction']['depense'][] = $value;
            }

            /* GET ALL MENSUALITES GAIN */
            $get = parent::selectData('mensualites','*','id_livret='.$livret->id.' AND type_change="gain"');
                
            foreach ($get as $key => $value) {
                $arrChangeMensualites['mensualite']['gain'][] = $value;
            }

            /* GET ALL MENSUALITES DEPENSE */
            $get = parent::selectData('mensualites','*','id_livret='.$livret->id.' AND type_change="depense"');
                
            foreach ($get as $key => $value) {
                $arrChangeMensualites['mensualite']["depense"][] = $value;
            }

            $this->utf8_encode_deep($arrChangeMensualites);

            return $arrChangeMensualites;

        }

        public function utf8_encode_deep(&$input) {
            if (is_string($input)) {
                $input = utf8_encode($input);
            } else if (is_array($input)) {
                foreach ($input as &$value) {
                    $this->utf8_encode_deep($value);
                }
                
                unset($value);
            } else if (is_object($input)) {
                $vars = array_keys(get_object_vars($input));
                
                foreach ($vars as $var) {
                    $this->utf8_encode_deep($input->$var);
                }
            }
        }

    }