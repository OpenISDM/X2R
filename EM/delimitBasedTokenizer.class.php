<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        delimitBsedTokenizer.class.php

    Abstract:

       Delimit_Based_Tokenizer is a 
        specialization of Tokenizer. 
        It realizes a heuristic of tokenization. 
        That is, delimit based heuristic.

        This tokenizer divide word when encountering
        delimit belonged to the pre-defined delimit set.

        The defined set include the all non-alphet words & 
        all the non-digit words & the underscore sign, "_".   


    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');
include_once 'tokenizer.class.php';

class Delimit_Based_Tokenizer extends Tokenizer
{

    public function tokenizeArr(array $arr)
    {

        $intmArr = array();
        foreach($arr as $str)
        {
            $tempArr = $this->tokenizeStr($str);
            $intmArr[] = $tempArr;
        }
        $resultArr = $this->arrConcatenate($intmArr);
        return $resultArr;


    }
    public function tokenizeStr($str)
    {

        $resultArr = $this->delimitizing($str);
        return $resultArr;
        
    }

    protected function delimitizing($str)
    {
        $resultStr = str_replace('_', '+', $str);
        //$resultStr = preg_replace("/[^\w\d ]/ui", ' ', $resultStr);
        $resultStr = preg_split("/[^\w\d ]/ui", $resultStr);
        return $resultStr;
    }


}

/*
$d = new Delimit_Based_Tokenizer();
$k = $d-> tokenizeStr('a+b+cd-E~G!H*&F');
print_r($k);
echo('<br>');
$j = $d-> tokenizeStr('a+b+cd-E~G!H*&F/史提芬福66_123Alf');
print_r($j);

echo('<br>');
$w = array('a+b+cd-E~G!H*&F', '史提芬福66_123Alf');
$j = $d-> tokenizeArr($w);
print_r($j);
*/