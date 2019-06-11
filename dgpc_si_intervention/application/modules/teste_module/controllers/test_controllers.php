<?php class test_controllers extends MY_Controller
               {
                
                function __construct()
                {
                  parent::__construct();
        
                }
                  public function index()
                  {
                     $this->load->view('test_controllers_view.php');
                  }
                }?>