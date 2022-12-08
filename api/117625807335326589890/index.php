<?php

    require_once '../../function/data.function/gestionBancaireData.class.php';
    require_once '../../ressources/variable.php';
    require_once '../../function/return.function.class.php';

    $return = new returnAddons();
    $parentFolder = explode( DIRECTORY_SEPARATOR , dirname(__FILE__) );
    
    $id = $parentFolder[count($parentFolder)-1];

    if ( $id != "api" && is_numeric($id) ) {

        if ( isset($_GET['token']) && $_GET['token'] == $acceptedToken ) {

            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Methods: GET');

            $ParentGestionBancaire = new gestionBancaire( 'gestionBancaire' );
            $gestionBancaire = new gestionBancaireData( "gestionBancaire" , $id );

            if ( isset($_GET['dataType']) ) {

                switch ( $_GET['dataType'] ) {
                    case 'account':
                        echo $return->returnGoodCode('DataSend','data as send',$gestionBancaire->getAccount());
                        break;
                    
                    case 'all':
                        echo $return->returnGoodCode('DataSend','data as send',$gestionBancaire->getAll());
                        break;
    
                    default:
                        echo $return->returnErrorCode('NoType','dataType : Type not found');
                        break;
                }

            } else if ( isset($_GET['action']) ) {

                switch ( $_GET['action'] ) {
                    case 'createAccount':

                        $act = $ParentGestionBancaire->createAccountBanks(utf8_decode($_GET['accountNumber']), utf8_decode($_GET['accountName']), $id);

                        if (isset($act[0]) && !$act[0]) {

                            echo $return->returnErrorCode('ActionError',utf8_decode('Erreur pendant la création du comptes'));

                        } else {

                            echo $return->returnGoodCode('ActionSuccess',utf8_decode('Compte créé avec succès'));

                        }

                        break;

                    case 'createLivret':

                        $act = $ParentGestionBancaire->createLivret($_GET['AccountNumber'], utf8_decode($_GET['livretName']), $_GET['livretSolde']);

                        if (isset($act[0]) && !$act[0]) {

                            echo $return->returnErrorCode('ActionError',utf8_decode('Erreur pendant la création du livret'));

                        } else {

                            echo $return->returnGoodCode('ActionSuccess',utf8_decode('Livret créé avec succès'));

                        }

                        break;

                    case 'createCategories':

                        $act = $ParentGestionBancaire->createCategorie($_GET['accountNumber'], utf8_decode($_GET['name']));
    
                        if (isset($act[0]) && !$act[0]) {
    
                            echo $return->returnErrorCode('ActionError',utf8_decode('Erreur pendant la création de la catégorie'));
    
                        } else {
    
                            echo $return->returnGoodCode('ActionSuccess',utf8_decode('Catégorie créé avec succès'));
    
                        }
    
                        break;

                    case 'createChanges':

                        $act = $ParentGestionBancaire->createChange(utf8_decode($_GET['name']), $_GET['id_livret'] , $_GET['id_categorie'] , $_GET['montant'] , utf8_decode($_GET['intitule']) , $_GET['type'] , $_GET['date'] );
    
                        if (isset($act[0]) && !$act[0]) {
    
                            echo $return->returnErrorCode('ActionError',utf8_decode('Erreur pendant la création de la change'));
    
                        } else {
    
                            echo $return->returnGoodCode('ActionSuccess',utf8_decode('change créé avec succès'));
    
                        }
    
                        break;

                    case 'createMensualites':

                        $act = $ParentGestionBancaire->createMensualite($_GET['name'], $_GET['id_livret'] , $_GET['id_categories'] , $_GET['montant'] , utf8_decode($_GET['intitule']) , $_GET['actif'] , $_GET['date'],  $_GET['type_change']  );
    
                        if (isset($act[0]) && !$act[0]) {
    
                            echo $return->returnErrorCode('ActionError',utf8_decode('Erreur pendant la création de la mensualité'));
    
                        } else {
    
                            echo $return->returnGoodCode('ActionSuccess',utf8_decode('mensualité créé avec succès'));
    
                        }
    
                        break;
                    case "deleteValue":

                        $what = $_GET['what'];
                        $where = [$_GET['whereType'],$_GET['whereEqual'],$_GET['whereValue']];

                        $act = $ParentGestionBancaire->deleteData($what , $where[0]." ".$where[1]." ".$where[2]);
    
                        if (isset($act[0]) && !$act[0]) {

                            echo $return->returnErrorCode('ActionError',utf8_decode('Erreur pendant la suppréssion de la '.$what));
    
                        } else {
    
                            echo $return->returnGoodCode('ActionSuccess',utf8_decode($what.' supprimé avec succès'));
    
                        }
                        break;
    
                    case "UpdateValue":

                        $what = $_GET['what'];
                        $modif =  utf8_decode($_GET['modif']);
                        $where = [$_GET['whereType'],$_GET['whereEqual'],$_GET['whereValue']];

                        $act = $ParentGestionBancaire->updateData($what , $modif, $where[0]." ".$where[1]." ".$where[2]);
    
                        if (isset($act[0]) && !$act[0]) {

                            echo $return->returnErrorCode('ActionError',utf8_decode('Erreur pendant la modification de la '.$what));
    
                        } else {
    
                            echo $return->returnGoodCode('ActionSuccess',utf8_decode($what.' modification avec succès'));
    
                        }
                        break;

                    default:
                        echo $return->returnErrorCode('NoAction','action : Action not found');
                        break;
                }

            } else {

                echo $return->returnErrorCode('NoType','dataType or action not found');

            }

        } else {

            echo $return->returnErrorCode('Error','invadid token or dataType attribut missing');

        }

    } else {

        echo $return->returnErrorCode('NotAviable','not aviable');

    }
    
