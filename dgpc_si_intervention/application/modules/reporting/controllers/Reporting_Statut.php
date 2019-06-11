<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting_Statut extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['cppc']= $this->Model->getList('rh_cppc',array());

        $month_year = date('Y-m');

        $date_courant = date($month_year . '-d');

        $dateA = new DateTime($date_courant);
        $dateB = new DateTime($date_courant);

        $dateC = $dateA->sub(DateInterval::createFromDateString('30 days'));
        $dateD = $dateB->sub(DateInterval::createFromDateString('60 days'));

        $date1 = $month_year;
        $date2 = $dateC->format('Y-m');
        $date3 = $dateD->format('Y-m');

     //echo $date3;

        $m_0 = date('M/Y');
        $m_1 = $dateC->format('M/Y');
        $m_2 = $dateD->format('M/Y');
        $etats = $this->Model->getList('tk_statuts');
         //print_r($etats);

        $reportZone1 = NULL;
        $reportZone2 = NULL;
        $reportZone3 = NULL;

     if(count($etats))
        {

        foreach ($etats as $etat) {


      

        $nbr1 = $this->Model->reportingstatut($etat['STATUT_ID'],$date1);

        $nbr2 = $this->Model->reportingstatut($etat['STATUT_ID'],$date2);

        $nbr3 = $this->Model->reportingstatut($etat['STATUT_ID'],$date3);

       //print_r($nbr1);

          //echo 'ok';


            $test1 = '{name :"' . $etat['STATUT_DESCR'] . '" ,y:' . $nbr1['nbre'] . ',color: Highcharts.getOptions().colors[' . $etat['STATUT_ID'] . ']},';
            $reportZone1 = $reportZone1 . $test1;



            $test2 = '{name :"' . $etat['STATUT_DESCR'] . '" ,y:' . $nbr2['nbre'] . ',color: Highcharts.getOptions().colors[' . $etat['STATUT_ID'] . ']},';
            $reportZone2 = $reportZone2 . $test2;

            $test3 = '{name :"' . $etat['STATUT_DESCR'] . '" ,y:' . $nbr3['nbre'] . ',color: Highcharts.getOptions().colors[' . $etat['STATUT_ID'] . ']},';
            $reportZone3 = $reportZone3 . $test3;

        /*echo '<pre>';
      print_r($reportZone1);
    echo '</pre>';*/
        }
     }
        $reportZone1 = $reportZone1 . '/';
        $reportZone1 = str_replace("},/", "}", $reportZone1);

        

      
        $reportZone2 = $reportZone2 . '/';
        $reportZone2 = str_replace("},/", "}", $reportZone2);


        

   
        $reportZone3 = $reportZone3 . '/';
        $reportZone3 = str_replace("},/", "}", $reportZone3);

        $array['series1'] = $reportZone1;
        $array['series2'] = $reportZone2;
        $array['series3'] = $reportZone3;
        $array['CRITERE'] = '';

       

        $mois = array(0 => '', 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        );

        $array['titre1'] = $m_0;
        $array['titre2'] = $m_1;
        $array['titre3'] = $m_2;

        $array['soustitre'] = "Reporting date: " . date("F j, Y, g:i a");
        $array['title'] = "Intervention par statut";
        $this->load->view('Reporting_Statut_View', $array);
       
    }

  
}
