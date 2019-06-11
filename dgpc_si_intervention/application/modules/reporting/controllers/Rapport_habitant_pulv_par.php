<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rapport_habitant_pulv_par extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database('default');
    }

    function index(){
    $data['cate'] = $data['moins5'] = $data['plus5'] ="";
    $som = 0;
    $moy= 0;
    if($this->input->post('cate') == 2){
        $data['c']=2;
         $habitant= $this->Model->habitant_pulverise_par(2);
    
    foreach($habitant as $p){
      $com= $this->Model->getOne('communes',array('COMMUNE_NAME'=>$p['COMMUNE_NAME']));
      $cond= array('pulv.COMMUNE_ID'=> $com['COMMUNE_ID']);

      $habitant_rejet= $this->Model->habitant_pulverise_par_rejet($cond);
      $moins= $habitant_rejet['moins5'] + $p['moins5'];
      $plus= $habitant_rejet['plus5'] + $p['plus5'];

      $moy= $moy + $p['nbrM'] + $habitant_rejet['nbrM'];

      $data['cate'] .= "'".$p['COMMUNE_NAME']." (<b>".number_format((float)($p['nbrM']+$habitant_rejet['nbrM']), 2, '.', '')."</b>)',";
      $data['moins5'].=  $moins.",";
      $data['plus5'] .= $plus.",";
      $som= $som + $moins + $plus;
    }
    $data['title']= "Habitants dénombrés protégés par commune => <b>".number_format($som,0,","," ")."</b> habitants, soit <b>".number_format((float)($moy), 2, '.', '')."</b>";

    }else if($this->input->post('cate') == 3){
         $data['c']=3;
         $habitant= $this->Model->habitant_pulverise_par(3);
    foreach($habitant as $p){

      $zon= $this->Model->getOne('zones',array('ZONE_NAME'=>$p['ZONE_NAME']));
      $cond= array('pulv.ZONE_ID'=> $zon['ZONE_ID']);

      $habitant_rejet= $this->Model->habitant_pulverise_par_rejet($cond);
      $moins= $habitant_rejet['moins5'] + $p['moins5'];
      $plus= $habitant_rejet['plus5'] + $p['plus5'];

      $moy= $moy + $p['nbrM'] + $habitant_rejet['nbrM'];

      $data['cate'] .= "'".$p['ZONE_NAME']." (<b>".number_format((float)($p['nbrM']+$habitant_rejet['nbrM']), 2, '.', '')."</b>)',";
      $data['moins5'].=  $moins.",";
      $data['plus5'] .= $plus.",";
      $som= $som + $moins + $plus;
    }
    $data['title']= "Habitants dénombrés protégés par zone => <b>".number_format($som,0,","," ")."</b> habitants, soit <b>".number_format((float)($moy), 2, '.', '')."</b>";

    }else if($this->input->post('cate') == 4){
         $data['c']=4;

        $data['table']= "<table id='mytable' class='table table-hover table-striped table-condensed table-bordered'><thead><tr><th>Colline</th><th>Moins de 5</th><th>Plus de 5</th></tr></thead>";
         $habitant= $this->Model->habitant_pulverise_par(4);
    foreach($habitant as $p){
      
      $col= $this->Model->getOne('collines',array('COLLINE_NAME'=>$p['COLLINE_NAME']));

      $cond= array('pulv.COLLINE_ID'=> $col['COLLINE_ID']);

      $habitant_rejet= $this->Model->habitant_pulverise_par_rejet($cond);
      $moins= $habitant_rejet['moins5'] + $p['moins5'];
      $plus= $habitant_rejet['plus5'] + $p['plus5'];

      $moy= $moy + $p['nbrM'] + $habitant_rejet['nbrM'];

       $data['moins5'].=  $moins.",";
      $data['plus5'] .= $plus.",";

       $data['table'] .= "<tr><td>".$p['COLLINE_NAME']." (<b>".number_format((float)($p['nbrM']+$habitant_rejet['nbrM']), 2, '.', '')."</b>)</td><td>".$moins."</td><td>".$plus."</td></tr>";
       $som= $som + $moins + $plus;
    }

    $data['table'].= "</table>";
    $data['title']= "Habitants dénombrés protégés par colline => <b>".number_format($som,0,","," ")."</b> habitants, soit <b>".number_format((float)($moy), 2, '.', '')."</b>";
    }else{
         $data['c']=1;
         $habitant= $this->Model->habitant_pulverise_par(1);
    foreach($habitant as $p){

      $pr= $this->Model->getOne('provinces',array('PROVINCE_NAME'=>$p['PROVINCE_NAME']));
      $cond= array('pulv.PROVINCE_ID'=> $pr['PROVINCE_ID']);

      $habitant_rejet= $this->Model->habitant_pulverise_par_rejet($cond);
      $moins= $habitant_rejet['moins5'] + $p['moins5'];
      $plus= $habitant_rejet['plus5'] + $p['plus5'];

      $moy= $moy + $p['nbrM'] + $habitant_rejet['nbrM'];

      $data['cate'] .= "'".$p['PROVINCE_NAME']." (<b>".number_format((float)($p['nbrM']+$habitant_rejet['nbrM']), 2, '.', '')."</b>)',";
      $data['moins5'].=  $moins.",";
      $data['plus5'] .= $plus.",";
      $som= $som + $moins + $plus;
    }
    
    $data['type']= 1;
    $data['title']= "Habitants dénombrés protégés par province => <b>".number_format($som,0,","," ")."</b> habitants, soit <b>".number_format((float)($moy), 2, '.', '')."</b>";
    }
    //print_r($data['c']);
    $data['cate'].= "//";
    $data['cate'] = str_replace(",//","",$data['cate']);
    $data['moins5'].= "//";
    $data['moins5'] = str_replace(",//","",$data['moins5']);
    $data['plus5'].= "//";
    $data['plus5'] = str_replace(",//","",$data['plus5']);

       $this->load->view('Rapport_habitant_pulv_par_view',$data);
    }

    function get_habitant($cond){

  
    }

}