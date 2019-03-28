<?php

class pm_debit extends PaymentRoot{
    
    function showPaymentForm($params, $pmconfigs){
        if (!isset($params['acc_holder'])) $params['acc_holder'] = '';
        if (!isset($params['acc_number'])) $params['acc_number'] = '';
        if (!isset($params['bank_bic'])) $params['bank_bic'] = '';
        if (!isset($params['bank'])) $params['bank'] = '';
    	include(dirname(__FILE__)."/paymentform.php");
    }

    function int_5_8($value){
       $reg = '/^[0-9]{5,8}$/';
    return (preg_match($reg, $value));
    }

    function checkPaymentInfo($params, $pmconfigs){
        if (!$this->int_5_8($params['bank_bic'])){
            return 0;
        } else {
            return 1;
        }
    }

    function getDisplayNameParams(){
        $names = array('acc_holder' => _JSHOP_ACCOUNT_HOLDER, 'acc_number' => _JSHOP_ACCOUNT_NUMBER, 'bank_bic' => _JSHOP_BIC, 'bank' => _JSHOP_BANK );
        return $names;
    }

}
?>