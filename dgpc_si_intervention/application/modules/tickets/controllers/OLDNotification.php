<?php

 class Notification extends MY_Controller
 {
 	
 	function __construct()
 	{
 	  parent::__construct();
    $this->make_bread->add('Notifications', "tickets/Notification", 0);
    $this->breadcrumb = $this->make_bread->output();
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
      if($this->mylibrary->get_permission('Notification/index') ==0){
          redirect(base_url());
         }
     $fetch_notification = $this->Model->fetch_notification(array());
     $critere_array = array();
     foreach ($fetch_notification as $row) {
          $sub_array = array();
           
            $nom = $row['PERSONNEL_NOM'].' '.$row['PERSONNEL_PRENOM'];
            $message = $row['MESSAGE_TEL'];
            $ticket_code = $row['TICKET_CODE'];
            $localite = $row['LOCALITE'];
            $date_intervation = $row['DATE_INTERVENTION'];
            $cppc = $row['CPPC_NOM'];
           
            $sub_array[] = $nom; 
            $sub_array[] = $message;
            $sub_array[] = $cppc;
            $sub_array[] = $ticket_code;
            $sub_array[] = $localite;
            $sub_array[] = $date_intervation;  

      $critere_array[]=$sub_array;
     }

        $template = array(
            'table_open' => '<table id="table_notification" class="table table-bordered table-stripped table-hover table-condensed">',
            'table_close' => '</table>'
        );
        $this->table->set_template($template);
        $this->table->set_heading("NOM & PRENOM","MESSAGE","CPPC","CODE DU TICKET","LOCALITE","DATE D'INTERVENTION");
        $data['sub_array']=$critere_array;
        $data['msg']="";
        $data['title'] ="Les Notifications d'intervention";
        $data['breadcrumb'] = $this->make_bread->output();
        $this->load->view('notification/Notification_View',$data);
    }
     public function liste()
    {
        $data['title'] = "Les Notifications d'intervention";
        $data['breadcrumb'] = $this->make_bread->output();
        $this->load->view('notification/Notification_View', $data);
    }
    public function get_notification(){
      
      $var_search = $_POST['search']['value'];
      $table = "interv_notification";
      $critere_txt = !empty($_POST['search']['value']) ? ("TICKET_ID LIKE '%$var_search%' OR DATE_INSERTION LIKE '%$var_search%' OR MESSAGE_TEL LIKE '%$var_search%' OR DATE_INSERTION LIKE '%$var_search%'") : NULL;
      $critere_array = array();
      $order_column = array('TICKET_ID','MESSAGE_TEL', 'EQUIPE_ID','TELEPHONE'.'DATE_INSERTION');
      $order_by = isset($_POST['order']) ? array($order_column[$_POST['order']['0']['column']] => $_POST['order']['0']['dir']) : array('NOTIFICATION_ID' => 'DESC');
      $select_column = array('NOTIFICATION_ID', 'TICKET_ID','MESSAGE_TEL', 'EQUIPE_ID', 'TELEPHONE','DATE_INSERTION');

      $fetch_notification = $this->Model->make_datatables($table,$select_column, $critere_txt, $critere_array,$order_by);
      //$fetch_notification = $this->Model->fetch_notification($critere_array);
      //print_r($fetch_notification);
      $is_standard = $this->mylibrary->verify_standard_dgpc($this->session->userdata('DGPC_USER_ID'));
      $data = array();
        foreach ($fetch_notification as $row) {
            $sub_array = array();
           
            $ticket_code = $this->Model->getOne('tk_ticket',array('TICKET_ID'=>$row->TICKET_ID));
            $message = $row->MESSAGE_TEL;
            $intervenant = $this->Model->getOne('interv_intervenants',array('TICKET_CODE'=>$ticket_code['TICKET_CODE']));
            $nom = $this->Model->getOne('rh_personnel_dgpc',array('PERSONNEL_ID'=>$intervenant['PERSONNEL_ID']));
            $localite = $ticket_code['LOCALITE'];
            $date_intervation = $ticket_code['DATE_INTERVENTION'];
           
            $sub_array[] = $nom['PERSONNEL_NOM'].' '.$nom['PERSONNEL_PRENOM']; 
            $sub_array[] = $message;
            $sub_array[] = $ticket_code['TICKET_CODE'];
            $sub_array[] = $localite;
            $sub_array[] = $date_intervation;           

            $data[] = $sub_array;    

    }
    $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $this->Model->count_all_data($table, $critere_array),
            "recordsFiltered" => $this->Model->get_filtered_data($table, $select_column, $critere_txt, $critere_array, $order_by),
            "data" => $data
        );
        echo json_encode($output);
    
  }


}