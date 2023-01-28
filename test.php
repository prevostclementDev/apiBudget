<?php
    
    $tabChange = array(
        [
            'date' => '2018-01-20',
            'intitule' => 'Loyer'
        ],
        [
            'date' => '2018-01-02',
            'intitule' => 'ecole'
        ],
    );

    $tabMensualites = array(
        [
            'date' => '2018-04-20',
            'intitule' => 'Loyer'
        ]
    );

    /* CHECK IF DATE IS NOT IN ARRAY WITH 30 DAY */
    function checkTheDate($tabChange,$tabMensualites) {
        $arrNow = explode('-',date('Y-m-d')); // arrNow[1] -> MONTH && arrNow[2] -> DAY
        $msg = 'default-false';
        $return = false;
        $data = [];

        foreach( $tabMensualites as $mensualites ) {
            $arrMensualitesDate = explode('-',date('Y-m-d',strtotime($mensualites['date']))); // arrMensualitesDate[1] -> MONTH && arrMensualitesDate[2] -> DAY
            foreach($tabChange as $change) {
                if ( !in_array($change, $tabMensualites) ) {
                    $arrDateChange = explode('-',date('Y-m-d',strtotime($change['date']))); // arrDate[1] -> MONTH && arrDate[2] -> DAY

                    $ifIsOtherMonth = intval($arrMensualitesDate[2]) >= intval($arrDateChange[2]);
                    $ifIsSameIntituler = $change['intitule'] == $mensualites['intitule'];

                    if ( $ifIsOtherMonth && $ifIsSameIntituler) {
                        $return = true;
                        $msg = 'passedCondition-true';
                        array_push($data,[$mensualites,$arrNow,$change]);
                    }
                } else {
                    return array(false,'isInArray-false',[]);
                }
            }
        }

        if ( $return == false ) {
            $msg = 'notPassedCondition-false';
        }

        return array($return,$msg,$data);
    }

    var_dump(checkTheDate($tabChange,$tabMensualites));