<?php

/*++
    Copyright (c) 2014  OpenISDM

    Project Name: 

        OpenISDM VR X2R

    Version:

        0.1 
    
    File Name:

        caseBasedTokenizer.class.php

    Abstract:

        Case_Based_Tokenizer is a 
        specialization of Tokenizer. 
        It realizes a heuristic of tokenization. 
        That is, case-based heuristic. 

        This heuristic consists of two rules:
          1. Continuous upper cases treated 
             as one atomic trunk
          2. Divide when encountering 
             case-changes from lower case 
             to upper case
        Noth that rule 1 is precedent to rule 2. 
        For example, "camelCASExample" will be 
        tokenized as "camel CASE xample." 



    Authors:      

        Feng-Pu Yang, fengpuyang@gmail.com

    Major Revision History:
    
--*/
header ('Content-Type: text/html; charset=utf-8');
include_once 'tokenizer.class.php';


class Case_Based_Tokenizer extends Tokenizer
{

    public function tokenizeArr(array $arr_to_tok)
    {

        $intmArr = array();
        foreach($arr_to_tok as $str)
        {
            $tempArr = $this->allCaptial($str);
            $intmArr[] = $tempArr;
        }
        $intmArr2 = $this->arrConcatenate($intmArr);


        $intmArr3 = array();
        foreach($intmArr2 as $str)
        {
            $tempArr = $this->pascalCase($str);
            $intmArr3[] = $tempArr;
        }
        $resultArr = $this->arrConcatenate($intmArr3);

        return $resultArr;
        

    }
    public function tokenizeStr($arr_to_tok)
    {
        
        $intmArr = $this->allCaptial($arr_to_tok);


        $intmArr2 = array();
        foreach($intmArr as $str)
        {
            $tempArr = $this->pascalCase($str);
            $intmArr2[] = $tempArr;
        }
        $resultArr = $this->arrConcatenate($intmArr2);

        
         return $resultArr;
    }

    
    protected function allCaptial($str)
    {
        $strNac = preg_split("([A-Z]{2,})", $str);
        $strAc = preg_match_all("([A-Z]{2,})", $str, $out);
        $aCs = $out[0]; 
        $result = $this->array_zip_merge($strNac, $aCs);
        $result = array_values(array_filter($result));
        return $result;
    }

    protected function pascalCase($str)
    {
        
        $resultStr = preg_split("([A-Z][a-z]+)", $str);
        $r2 = preg_match_all("([A-Z][a-z]+)", $str, $out);
        $strNpc = $resultStr;
        $pCs = $out[0];
        $result = $this->array_zip_merge($strNpc, $pCs);
        $result = array_values(array_filter($result));
        return $result;
    }


    protected function array_zip_merge() {
      $output = array();
      // The loop incrementer takes each array out of the loop as it gets emptied by array_shift().
      for ($args = func_get_args(); count($args); $args = array_filter($args)) {
        // &$arg allows array_shift() to change the original.
        foreach ($args as &$arg) {
          $output[] = array_shift($arg);
        }
      }
      return $output;
    }



}


/*
$d = new Case_Based_Tokenizer();
$r = array('tokenizeArrALF12kkDDdfasdfa', 'aaaALF12kkDDdfasdfasdDdfasdfa');
$t = 'tokenizeArrALF12kkDDdfasdfa aaaALF12kkDDdfasdfasdDdfasdfa';
$d-> tokenizeStr('aaaALF12kkDDdfasdfasdDdfasdfa');
echo('<br>');
print_r($d-> tokenizeArr($r));
echo('<br>');
print_r($d-> tokenizeStr($t));
*/