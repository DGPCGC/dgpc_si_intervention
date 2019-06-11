<?php

class Repport_materiaux extends CI_Controller {

    
    function __construct() {
        parent::__construct();
    }

    public function index() {

         $data['cppc']= $this->Model->getList('rh_cppc',array());
         $data['causes']= $this->Model->getRequete("SELECT distinct(cs.CAUSE_ID), cs.* FROM tk_causes as cs JOIN interv_materiaux as mat on mat.CAUSE_ID=cs.CAUSE_ID");
        
         if($this->input->post('cppc') == null){
            $cppcs = $this->Model->getList('rh_cppc');
         }else{
             $cppcs = array();
             foreach ($this->input->post('cppc') as $key => $value) {
                 $c= $this->Model->getOne('rh_cppc',array('CPPC_ID' => $value));
                 array_push($cppcs, array('CPPC_ID'=>$c['CPPC_ID'],'CPPC_NOM'=>$c['CPPC_NOM']));
             }
         }
         //print_r($cppcs);
         
         $liste = array();
         $i = 0;
         $category ='';
         foreach ($cppcs as $cppc) {  
         	$category .= "'".$cppc['CPPC_NOM']."',";
            //echo "CPPC ".$cppc['CPPC_ID'];  

            if($this->input->post('cause') != null){
               $materiels = $this->Model->getList('interv_materiaux',array('CAUSE_ID'=>$this->input->post('cause')));
         	}else{
               $materiels = $this->Model->getList('interv_materiaux',array());
            }
            
            //print_r($materiels);

         	foreach ($materiels as $materiel) {
         	  $indice = $materiel['MATERIEL_ID'];
              $donnee = $this->Model->getdonneeMateriels($cppc['CPPC_ID'],$materiel['MATERIEL_ID']);              

         	   $var_value = empty($donnee['nbmateriel'])?0:$donnee['nbmateriel'];
         	  // echo "MAT ".$materiel['MATERIEL_ID'].":".$var_value."<br>"; 
         	  if(array_key_exists($indice,$liste)){
         	  	$liste[$indice] .= $var_value.','; 
         	  }else{
         	  	$liste[$indice] = $var_value.','; 
         	  }  
         	}
           

         }

      /*    echo "<pre>";
          print_r($liste);
          echo "</pre>";
*/
         $serie = "";
         if(!empty($liste)){
             foreach ($liste as $key => $value) {
               $nom = $this->Model->getOne('interv_materiaux',array('MATERIEL_ID'=>$key))['MATERIEL_DESCR'];
               $txt = $value.'//';
               $txt = str_replace(',//', '', $txt);

               $serie .= "{name:'".preg_replace('/\s+/', ' ',$nom)."',data:[".$txt."]},"; 
             }

             $serie .="//";
             $serie = str_replace(',//', '', $serie);
         }
         
         $category .="//";
         $category = str_replace(',//', '', $category);


         $data['serie_mat'] = $serie;
         $data['category'] = $category;
        $data['soustitre'] = "Reporting date: " . date("F j, Y, g:i a");
        $data['title'] = "Repartition des matériaux";
        $data['CPPC_ID']= $this->input->post('cppc');
        $data['CAUSE_ID']= $this->input->post('cause');
        
        $this->load->view('Reporting_Materiaux_View', $data);
       
    }

  
}
