<?php

 class Fonctionnalites extends MY_Controller
 {
  
  function __construct()
  {
    parent::__construct();
    $this->make_bread->add('Fonctionnalités', "administration/Fonctionnalites", 0);
    $this->breadcrumb = $this->make_bread->output();

   // $this->permission();
  }

  public function permission(){
         if($this->mylibrary->get_permission('Fonctionnalites') ==0){
          redirect(base_url());
         }
  }

    public function index()
    {
      
      $data['title'] = "Nouvelle fonctionnalité";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('fonctionnalites/Fonctionnalite_Nouvelle_View',$data);
    }

    public function save()
    {
       $this->form_validation->set_rules('FONCTIONNALITE_DESCR', 'Description', 'required');
       $this->form_validation->set_rules('FONCTIONNALITE_URL', 'Url', 'required|is_unique[admin_fonctionnalites.FONCTIONNALITE_URL]',array("is_unique"=>"<font color='red'>Url est déjà utilisé</font>"));
       $this->form_validation->set_rules('MODULE','Module','required|is_unique[admin_fonctionnalites.MODULE]',array("is_unique"=>"<font color='red'>La module existe déjà</font>"));
       
        if ($this->form_validation->run() == FALSE) {            
            $data['title'] = "Nouvelle fonctionnalité";      
            $data['breadcrumb'] = $this->make_bread->output();

            $this->load->view('fonctionnalites/Fonctionnalite_Nouvelle_View',$data);
        }else{
          $url=$this->input->post('FONCTIONNALITE_URL');
          $module=$this->input->post('MODULE');
            
          $controller = $url;
          $view = $url."_view.php";
          $modules = $module;

          //CREATE FOLDER
            $repertoire=APPPATH.'modules/'.$modules;
            //echo $rep;
            //exit();
            //$folder = $modules;

            if (!is_dir($repertoire)){
                mkdir ($repertoire, 0777,TRUE)or die("Folder exists");
                $controllers='controllers';
                $views='views';
                $repertoirecontroller=APPPATH.'modules/'.$modules.'/'.$controllers;
                $repertoireview=APPPATH.'modules/'.$modules.'/'.$views;
                mkdir ($repertoirecontroller, 0777,TRUE)or die("Folder exists");
                mkdir ($repertoireview, 0777,TRUE)or die("Folder exists");
                //CREATE FILE
                $destination_file=APPPATH.'modules/'.$modules.'/'.$controllers.'/';
                $newfname = $destination_file .''.$controller.'.php';
                $myfile=fopen($newfname, "w+")or die("Unable to open file!");

                $t='$';

            $txt = "<?php class ".$controller." extends MY_Controller
               {
                
                function __construct()
                {
                  parent::__construct();
        
                }
                  public function index()
                  {
                     ".$t."this->load->view('".$view."');
                  }
                }?>";
                fwrite($myfile, $txt);
                fclose($myfile);
              
              $destination_file_view = APPPATH.'modules/'.$modules.'/'.$views.'/';
              $newfnameview = $destination_file_view .''.$controller.'_view.php';
              $myfileview = fopen($newfnameview, "w+");

              $txtview = 
"<!DOCTYPE html>
<html lang='en'>

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class='container-fluid' style='background-color: white'>
        <div id='wrapper'>
            <!-- Navigation -->
            <nav class='navbar navbar-default navbar-static-top' role='navigation' style='margin-bottom: 5px' id='navp'>
                <!-- /.navbar-top-links -->
                <?php include VIEWPATH.'includes/menu_principal.php' ?>
                <!-- /.navbar-static-side -->
            </nav>
            <!-- Page Content -->
            <div id='page-wrapper'>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-lg-12' style='margin-bottom: 5px'>
                             <div class='row' style='' id='conta'>
                                
                             </div>
                            <div class='row' id='conta' style='margin-top: -10px'>
                                 <div class='col-lg-6 col-md-6'>                                  
                                   <h4 class=''><b></b></h4>  
                                </div>
                                <div class='col-lg-6 col-md-6' style='padding-bottom: 3px'>
                                    <!--<?php include 'menu_fonctionnalite.php' ?>-->
                                </div>
                            </div>  
                        </div>
                      </div>
                    </div>
                  </div>    
        </div>
    </div>
</body>
</head>
</html>";

             fwrite($myfileview, $txtview);
             fclose($myfileview);
                
          
            $array_fonctionnalite = array(
                                'FONCTIONNALITE_DESCR'=>$this->input->post('FONCTIONNALITE_DESCR'),
                                'FONCTIONNALITE_URL'=>$this->input->post('FONCTIONNALITE_URL'),
                                'MODULE'=>$this->input->post('MODULE')
                                );
            $fonctionnalite_id = $this->Model->insert_last_id('admin_fonctionnalites',$array_fonctionnalite);
            
            if($fonctionnalite_id>=0){
              $msg = "<font color='green'>Cette fonctionnalite <b>".$this->input->post('FONCTIONNALITE_DESCR')."</b> a été enregistré.</font>";           
            }else{
              $msg = "<font color='red'>Erreur</font>";
            }
          }else{
            $msg = "<font color='red'>Cette fonctionnalite n'a pas été enregistré.Le dossier existe deja</font>";
          }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);
            redirect(base_url().'administration/Fonctionnalites/liste');
        }
    }

    public function liste()
    {
        $fetch_profiles = $this->Model->getList('admin_fonctionnalites');

        $liste_fonctionnalite = array();
        foreach ($fetch_profiles as $row) {
            $sub_array = array();
                      
            $sub_array[] = $row['FONCTIONNALITE_DESCR'];
            $sub_array[] = $row['MODULE'];
            $sub_array[] = $row['FONCTIONNALITE_URL']; 
            
            if($this->mylibrary->verify_is_admin() ==1){
            $options = '<div class="dropdown ">
                        <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Options
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            ';
            
            $options .= "<li><a href='" . base_url('administration/Fonctionnalites/Modifier/' . $row['FONCTIONNALITE_ID']) . "'>
                                        Modifier</li>";
            //}
            

            $options .= "<li><a href='#' data-toggle='modal' 
                                  data-target='#mydelete" . $row['FONCTIONNALITE_ID'] . "'><font color='red'>Supprimer</font></button></li></ul>
                                   </div>
                                    <div class='modal fade' id='mydelete" . $row['FONCTIONNALITE_ID'] . "'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>

                                                <div class='modal-body'>
                                                    <h5>Supprimer :<b>" . $row['FONCTIONNALITE_DESCR']. "</b>?</h5>
                                                </div>

                                                <div class='modal-footer'>
                                                    <a class='btn btn-danger btn-md' href='" . base_url('administration/Fonctionnalites/supprimer/' . $row['FONCTIONNALITE_ID']) . "'>Supprimer</a>
                                                    <button class='btn btn-primary btn-md' class='close' data-dismiss='modal'>Annuler</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    ";

            $sub_array[] = $options;
          }

          $liste_fonctionnalite[] = $sub_array;
        }
       $data['liste_fonctionnalite'] = $liste_fonctionnalite;
        
        $template = array(
            'table_open' => '<table id="liste_fonctionnalite" class="table table-bordered table-stripped table-hover table-condensed">',
            'table_close' => '</table>'
        );
        if($this->mylibrary->verify_is_admin() ==1){
        $this->table->set_heading('DESCRIPTION','MODULE','URL','OPTIONS');
        }else{
          $this->table->set_heading('DESCRIPTION','MODULE','URL');
        }
        $this->table->set_template($template);

      $data['title'] = "Liste des fonctionnalités";      
      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('fonctionnalites/Fonctionnalite_Liste_View',$data);
    }

   
    public function modifier()
    {
      $fonctionnalite_id = $this->uri->segment(4);

      $data['title'] = "Modifier une fonctionnalite";
      $data['fonction'] = $this->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));

      $data['breadcrumb'] = $this->make_bread->output();

      $this->load->view('fonctionnalites/Fonctionnalite_Modifier_View',$data);
    }

    public function save_modification()
    {       
       $this->form_validation->set_rules('FONCTIONNALITE_DESCR', 'Description', 'required');
       $this->form_validation->set_rules('FONCTIONNALITE_URL', 'Url', 'required');
       $this->form_validation->set_rules('MODULE', 'Module', 'required');
       
      $fonctionnalite_id = $this->uri->segment(4);
               
        if ($this->form_validation->run() == FALSE) {           

            $data['title'] = "Mofidier une fonctionnalité";      
            $data['breadcrumb'] = $this->make_bread->output();
            $data['fonction'] = $this->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));

            $this->load->view('fonctionnalites/Fonctionnalite_Modifier_View',$data);
          }else{
           
            $array_profile = array(
                                'FONCTIONNALITE_DESCR'=>$this->input->post('FONCTIONNALITE_DESCR'),
                                'FONCTIONNALITE_URL'=>$this->input->post('FONCTIONNALITE_URL'),
                                'MODULE'=>$this->input->post('MODULE'),
                                );
            $msg = "<font color='red'>La fonctionnalité <b>".$this->input->post('FONCTIONNALITE_DESCR')."</b> n'a pas été modifié.</font>";

             //if($this->Model->update_table('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id),$array_profile)){
            if($array_profile){
            if($array_profile){

              $module=$this->input->post('MODULE');

              $row = $this->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));
              $destination_file = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$row['MODULE'];
              $new_destination_file = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$module;
              $rename=rename("".$destination_file."", "".$new_destination_file."");
              if($rename==0){
                   echo "string";
              }else{
                print_r($rename);
              
              }exit();
              
            //UPDATE FILE
            // $url=$this->input->post('FONCTIONNALITE_URL');
            // $module=$this->input->post('MODULE');
            
            // $controller = $url;
            // $view = $url."_view.php";
            // $modules = $module;
            
           // $row = $this->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));

          //DELETE FOLDER

            // $destination_file = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$row['MODULE'];
            // $deletefolder=rmdir ($destination_file);
            // print_r($deletefolder);
            // exit();
          //DELETE FILE
            
            // $destination_file = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$row['MODULE'].'/controllers/';
            // $newfname = $destination_file .''.$row['FONCTIONNALITE_URL'].'.php'; //set your file ext
            // $delete=unlink($newfname);

          //CREATE NEW FILE

//            $data_to_write = "$_POST[FONCTIONNALITE_URL]";
//            $destination_file = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$modules.'/controllers/';
//           $newfname = $destination_file .''.$controller.'.php'; //set your file ext
//           $file_path = $newfname;









// $file_handle = fopen($file_path, 'w'); 
// fwrite($file_handle, $data_to_write);
// fclose($file_handle);

              $msg = "<font color='green'> La fonctionnalité <b>".$this->input->post('FONCTIONNALITE_DESCR')."</b> a été modifié.</font>";
            }
            $donne['msg'] =$msg;
            $this->session->set_flashdata($donne);

            redirect(base_url().'administration/Fonctionnalites/liste');
        }
    }
  }
    
    public function supprimer()
    {
      $fonctionnalite_id =$this->uri->segment(4);

      $fonctionnalite = $this->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));  
      $admin_profiles_fonctionnalites = $this->Model->getList('admin_fonctionnalite_profil',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));
      
       $msg = '';
      if(!empty($fonctionnalite)){
        if(empty($admin_profiles_fonctionnalites)){
         $this->Model->delete('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));

          //$row = $this->Model->getOne('admin_fonctionnalites',array('FONCTIONNALITE_ID'=>$fonctionnalite_id));
          //DELETE FOLDER

            // $destination_file = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$row['MODULE'];
            // $deletefolder=rmdir ($destination_file);

          //DELETE FILE
            
            // $destination_file = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$row['MODULE'].'/controllers/';
            //  $destination_fileview = $_SERVER['DOCUMENT_ROOT'].'/dgpc/application/modules/'.$row['MODULE'].'/views/';
            // $newfname = $destination_file .''.$row['FONCTIONNALITE_URL'].'.php'; //set your file ext
            // $newfnameview = $destination_fileview .''.$row['FONCTIONNALITE_URL'].'_view.php'; //set your file ext
            // $delete=unlink($newfname);
            // $deleteview=unlink($newfnameview);
            // print_r($deleteview);
            // exit();
           



          $msg = "<font color='green'>La fonctionnalité <b>".$fonctionnalite['FONCTIONNALITE_DESCR']."</b> a été supprimée</font>";
        }else{
          $msg = "<font color='red'>Pour supprimer la fonctionnalité <b>".$fonctionnalite['FONCTIONNALITE_DESCR']."</b> commencer à supprimer les liens entre différents profiles.</font>"; 
        }
      }else{
        $msg = "<font color='red'>La fonctionnalité que vous voulez n'existe plus.</font>";        
      }
      $donne['msg'] =$msg;
      $this->session->set_flashdata($donne);

      redirect(base_url().'administration/Fonctionnalites/liste');
    }
    
 }