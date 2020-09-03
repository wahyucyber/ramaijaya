<?php 
class Uang {

   function convert($nominal)
   {
      $text = array('','Ribu','Juta','Milyar','Trilyun');
      $input = number_format($nominal, 0, ',', '.');
      return "Rp. ".number_format(preg_replace('/^(\d+\.\d+).*/','$1',$input),2,',','.').' '.$text[substr_count($input,'.')];
   }

}