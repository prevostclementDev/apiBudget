<?php

    require_once('function/api.folder.class.php');
    require_once('function/return.function.class.php');
    require_once('ressources/variable.php');
    $return = new returnAddons();

    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET');

    if ( isset($_GET['userId']) && isset($_GET['token']) && isset($_GET['mail']) ) {

        if ( $_GET['token'] == $acceptedToken ) {

            $apiFolder = new createApiFolder($_GET['userId'],$_GET['mail'],'./api/');

            if ( !$apiFolder->exist ) {
        
                if ( $apiFolder->createFolder() ) {

                    echo $return->returnGoodCode('Connected','connection réussie au compte créer',array(
                        "userId" => $_GET['userId'],
                        "mail" => $_GET['mail']
                    ));

                } else {

                    echo $return->returnErrorCode('ErrorConnection','Erreur lors de la préparation du compte');

                }
        
            } else {

                echo $return->returnGoodCode('Connected','connection réussie au compte existant',array(
                    "userId" => $_GET['userId'],
                    "mail" => $_GET['mail']
                ));

            }

        } else {
            
            echo $return->returnErrorCode('TokenError','token invalide');

        }

    } else {

        echo $return->returnErrorCode('MissingParameters','paramètres manquants');

    }