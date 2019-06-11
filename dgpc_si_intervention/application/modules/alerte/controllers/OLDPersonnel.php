<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Personnel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->autho();
       
    }
    public function autho()
      {
      if(empty($this->session->userdata('DGPC_USER_EMAIL'))){
          redirect(base_url());
         }
      }

    public function index()
    {

      $data['title'] = "Personnel";

      $data['mescommunes']=  $this->Model->getList('ststm_communes');
      $data['mesProvinces']=$this->Model->getList('ststm_provinces');
      $data['COMMUNE_ID']=0;
      $data['PROVINCE_ID']=0;
      

      $this->make_bread->add('Nouveau ', "alerte/Personnel", 0);
      $data['breadcrumb'] = $this->make_bread->output();
      $this->load->view('personnel_view/personnel_add',$data);

      // $province = $this->input->post("province");
    
    }

    function getCommune(){

  $province = $this->input->post("province");  

  $list_com=$this->Model->getList('ststm_communes',array('PROVINCE_ID'=>$province));
  
  $html="<label>Commune </label> 
         <select name='COMMUNE'  class='form-control ' id='commune'>";
                                 
                
                foreach($list_com as $comm)
                {
                if($comm['COMMUNE_ID']==$comm['COMMUNE_ID'])
                {
                $html.="<option value='".$comm['COMMUNE_ID']."' selected>".$comm['COMMUNE_NAME']." </option>";
                }
                else{
                $html.="<option value ='".$comm['COMMUNE_ID']."'>".$comm['COMMUNE_NAME']."</option>";
                }
                 }
                 $html.="</select>";

   
   echo $html;

}


    public function add()
  {

    $data=array(
    
    'PERSONNEL_NOM'=>$this->input->post('NON'),
    'PERSONNEL_PRENOM'=> $this->input->post('PRENOM'),
    'COMMUNE_ID'=>$this->input->post('COMMUNE'),
    'COLLINE'=> $this->input->post('COLLINE'),
    'PERSONNEL_TELEPHONE'=> $this->input->post('PHONE'),
    'PERSONNEL_EMAIL'=> $this->input->post('EMAIL'),
    );

    $this->Model->create('notif_personnel',$data);
    $data['message']='<div class="alert alert-success text-center">'."L'enregistrement de <b>".$this->input->post('NON').' - '.$this->input->post('PRENOM'). '</b> faite avec succès"</div>';
     $this->session->set_flashdata($data);

     // print_r($data['message']);
     // exit();

    redirect(base_url('alerte/Personnel/listing'));

  
  }

  public function listing(){

  	
    $personnel=$this->Model->getList('notif_personnel');

    $resultat=array();
 
    $data["table"] ="<table id='mytable' class='table table-responsive'><thead><tr><th>Nom et Prenom </th><th>Commune </th><th>Colline</th><th>Télephone </th><th>Email </th><th>Action</th></tr></thead><tbody>";
    foreach ($personnel as $value) {
    
    $comm=  $this->Model->getOne('ststm_communes',array('COMMUNE_ID' =>$value['COMMUNE_ID']));
   
    $data["table"] .= '<tr><td>'.$value["PERSONNEL_NOM"].' - '.$value["PERSONNEL_PRENOM"].'</td><td>'.$comm["COMMUNE_NAME"].'</td><td>'.$value["COLLINE"].'</td><td>'.$value["PERSONNEL_TELEPHONE"].'</td><td>'.$value["PERSONNEL_EMAIL"].'</td>
              <td>
                  <div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                     
                   
                     <li> <a href='.base_url("alerte/Personnel/getOne/").$value["PERSONNEL_ID"].'>Modufier</a></li> 

                     <li><a data-toggle="modal" data-target="#mydetail'.$value["PERSONNEL_ID"].'">Detail</a></li>

                    <li><a data-toggle="modal" data-target="#mydelete'.$value["PERSONNEL_ID"].'">Supprimer</a></li>

                    </ul>
                  </div>
              </td>


           <div class="modal fade" id="mydelete'.$value["PERSONNEL_ID"].'">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                <h5>Voulez-vous vraiment Supprimer le personnel <b style="color:black;">'.$value["PERSONNEL_NOM"].' - '.$value["PERSONNEL_PRENOM"].' </b> du systeme ...?</h5>
                </div>
                <div class="modal-footer">
                <a class="btn  btn-danger btn-md" href='.base_url("alerte/Personnel/delete/").$value["PERSONNEL_ID"].'>Supprimer</a>
                <button class="btn  btn-md" class="close" data-dismiss="modal">Annuler</button>
                </div>                             
            </div>
          </div>
        </div>

        <div class="modal fade" id="mydetail'.$value["PERSONNEL_ID"].'">
            <div class="modal-dialog">
              <div class="modal-content">

                <div class="modal-body">

                <h4>Détail du personnel</h4>
                 
                 <ul class="nav nav-second-level table table-hover table-bordered table-condensed table-striped">

                  <li style="margin-left:30px">Nom  :  '.$value["PERSONNEL_NOM"].'</li>
                  <li style="margin-left:30px">Prenom   : '.$value["PERSONNEL_PRENOM"].'</li>
                  <li style="margin-left:30px">Commune   : '.$comm["COMMUNE_NAME"].'</li>
                  <li style="margin-left:30px">Colline   : '.$value["COLLINE"].'</li>
                  <li style="margin-left:30px">Télephone   :  '.$value["PERSONNEL_TELEPHONE"].'</li>
                  <li style="margin-left:30px">Email   :  '.$value["PERSONNEL_EMAIL"].'</li>

                </ul>
                </div>

                <div class="modal-footer">
                <button class="btn  btn-md" class="close" data-dismiss="modal">Quitter</button>
                </div>   

            </div>
          </div>
        </div>
          </td></tr> ';
               
    }

      $data["table"] .= "</tbody></table>";
      $this->make_bread->add('Actif', "alerte/Personnel/listing", 0);
      $data['breadcrumb'] = $this->make_bread->output();
      $this->load->view('personnel_view/personnel_list',$data); 
  }

  function delete()
{
      $table="notif_personnel";
      $criteres['PERSONNEL_ID']=$this->uri->segment(4);
      $data['rows']= $this->Model->getOne( $table,$criteres);
      $this->Model->delete($table,$criteres);
      $data['message']='<div class="alert alert-success text-center">'."Suppression ".' '.$data['rows']['PERSONNEL_NOM']."  faite avec succès".'</div>';
      $this->session->set_flashdata($data);
      
      redirect(base_url('alerte/Personnel/listing'));
  
}


function getOne(){

      $data['mescommunes']=  $this->Model->getList('ststm_communes');
      $data['mesProvinces']=$this->Model->getList('ststm_provinces');
      $id_soc=$this->uri->segment(4);
      $personnels=$this->Model->getOne('notif_personnel',array('PERSONNEL_ID'=>$id_soc));
 
      $data['personnel']=$personnels;

      $this->make_bread->add('Update', "getOne/".$id_soc, 1);
      $data['breadcrumb'] = $this->make_bread->output();
      $this->load->view('personnel_view/personnel_update',$data); 
  }

  function update()
{
    
      $id=$this->uri->segment(4);
      $idn = $this->input->post('idn');
        
      $data=array(
    
      'PERSONNEL_NOM'=>$this->input->post('NON'),
      'PERSONNEL_PRENOM'=> $this->input->post('PRENOM'),
      'COMMUNE_ID'=>$this->input->post('COMMUNE'),
      'COLLINE'=> $this->input->post('COLLINE'),
      'PERSONNEL_TELEPHONE'=> $this->input->post('PHONE'),
      'PERSONNEL_EMAIL'=> $this->input->post('EMAIL'),

    );

      $sav=$this->Model->update('notif_personnel',array('PERSONNEL_ID'=>$idn),$data);
      $data['message']='<div class="alert alert-success text-center">'."Modufication de ".$this->input->post('NON').' - '.$this->input->post('PRENOM'). ' faite avec succès"</div>';
      $this->session->set_flashdata($data);

      redirect(base_url('alerte/Personnel/listing'));

  }

  }

