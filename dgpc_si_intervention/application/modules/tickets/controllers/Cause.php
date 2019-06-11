<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cause extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->is_Oauth();
       
    }

     public function is_Oauth()
    {
       if($this->session->userdata('DGPC_USER_EMAIL') == NULL)
        redirect(base_url());
    }


    public function index()
    {

      $data['title'] = "Personnel";

      $this->make_bread->add('Nouveau ', "tickets/Cause", 0);
      $data['breadcrumb'] = $this->make_bread->output();

      $id=$this->Model->get_Max_ID('CAUSE_ID','tk_causes');     
      $code=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$id['id_max']));
      $data['code']=$code['CAUSE_CODE'];
      $this->load->view('cause_view/cause_add',$data);

      // $province = $this->input->post("province");
    
    }


    public function add()
  {
    $check_code=$this->Model->checkvalue('tk_causes', array('CAUSE_CODE'=>$this->input->post('code'),));
    if ($check_code!=1) {
      
    
    $data=array(
    
    'CAUSE_DESCR'=>$this->input->post('cause'),
    'CAUSE_CODE'=> $this->input->post('code'),
    'NOTIFIE_DAHMI'=>$this->input->post('check'),
    
    );
    $this->Model->create('tk_causes',$data);
    $data['message']='<div class="alert alert-success text-center">'."L'enregistrement de <b>".$this->input->post('cause').' a pour code '.$this->input->post('code'). '</b> faite avec succès"</div>';
     $this->session->set_flashdata($data);
     redirect(base_url('tickets/Cause/listing'));

  }else{
       $data['message']='<div class="alert alert-success text-center">'."Il existe déjà une cause  avec le code <b>".$this->input->post('code'). '</b> choisi un autre code s.v.p </div>';
     $this->session->set_flashdata($data);
     redirect(base_url('tickets/Cause'));

  }
  
  }

  public function listing(){

  	
    $cause=$this->Model->getList('tk_causes');

    $resultat=array();
 
    $data["table"] ="<table id='mytable' class='table table-responsive'><thead><tr><th>Description</th><th>Code </th><th>Type Explosif</th><th>Action</th></tr></thead><tbody>";
    foreach ($cause as $value) {
    
    if ($value["NOTIFIE_DAHMI"]==1) {
      $DHMI="Oui";
    }else{
     $DHMI="Non";

    }
   
    $data["table"] .= '<tr><td>'.$value["CAUSE_DESCR"].'</td><td>'.$value["CAUSE_CODE"].'</td><td>'.$DHMI.'</td>
              <td>
                  <div class="dropdown ">
                    <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left">
                     
                   
                     <li> <a href='.base_url("tickets/Cause/getOne/").$value["CAUSE_ID"].'>Modufier</a></li> 
                    <li><a data-toggle="modal" data-target="#mydelete'.$value["CAUSE_ID"].'">Supprimer</a></li>

                    </ul>
                  </div>
              </td>


           <div class="modal fade" id="mydelete'.$value["CAUSE_ID"].'">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                <h5>Voulez-vous vraiment Supprimer la cause  <b style="color:black;">'.$value["CAUSE_DESCR"].' </b> de la liste des causes d\'intervation ?</h5>
                </div>
                <div class="modal-footer">
                <a class="btn  btn-danger btn-md" href='.base_url("tickets/Cause/delete/").$value["CAUSE_ID"].'>Supprimer</a>
                <button class="btn  btn-md" class="close" data-dismiss="modal">Annuler</button>
                </div>                             
            </div>
          </div>
        </div>
          </tr> ';
               
    }

      $data["table"] .= "</tbody></table>";
      $this->make_bread->add('Actif', "tickets/Cause/listing", 0);
      $data['breadcrumb'] = $this->make_bread->output();
      $this->load->view('cause_view/cause_list',$data); 
  }

  function delete()
{
      $table="tk_causes";
      $criteres['CAUSE_ID']=$this->uri->segment(4);
      $data['rows']= $this->Model->getOne( $table,$criteres);
      $this->Model->delete($table,$criteres);
      $data['message']='<div class="alert alert-success text-center">'."Suppression ".' '.$data['rows']['CAUSE_DESCR']."  faite avec succès".'</div>';
      $this->session->set_flashdata($data);
      
      redirect(base_url('tickets/Cause/listing'));
  
}


function getOne(){

  
      $id_soc=$this->uri->segment(4);
      $cause=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$id_soc));
 
      $data['cause']=$cause;

      $this->make_bread->add('Update', "getOne/".$id_soc, 1);
      $data['breadcrumb'] = $this->make_bread->output();
       $id=$this->Model->get_Max_ID('CAUSE_ID','tk_causes');     
      $code=$this->Model->getOne('tk_causes',array('CAUSE_ID'=>$id['id_max']));
      $data['code']=$code['CAUSE_CODE'];
      $this->load->view('cause_view/cause_update',$data); 
  }

  function update()
{
    
      $id=$this->uri->segment(4);
      $idn = $this->input->post('idn');
        
      $data=array(
    
    'CAUSE_DESCR'=>$this->input->post('cause'),
    'CAUSE_CODE'=> $this->input->post('code'),
    'NOTIFIE_DAHMI'=>$this->input->post('check'),

    );

      $sav=$this->Model->update('tk_causes',array('CAUSE_ID'=>$idn),$data);
      $data['message']='<div class="alert alert-success text-center">'."Modufication de ".$this->input->post('CAUSE_DESCR').' faite avec succès"</div>';
      $this->session->set_flashdata($data);

      redirect(base_url('tickets/Cause/listing'));

  }

  }

