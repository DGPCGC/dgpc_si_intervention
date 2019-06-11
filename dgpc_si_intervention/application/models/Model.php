<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model{

  function update_table($table, $criteres, $data) {
        foreach ($data as $key => $value) {
          $this->db->set($key,$value);
        }
        $this->db->where($criteres);
        $query = $this->db->update($table);
        return ($query) ? true : false;
    }  

    function insert_last_id($table, $data) {

        $query = $this->db->insert($table, $data);
       
       if ($query) {
            return $this->db->insert_id();
        }

    }
    public function getFonctionnalites($PROFILE_ID)
    {
      $this->db->select("fnlt.*");
      $this->db->from("admin_fonctionnalites as fnlt");
      $this->db->join("admin_fonctionnalite_profil as fpf","fpf.FONCTIONNALITE_ID=fnlt.FONCTIONNALITE_ID");
      $this->db->where("fpf.PROFILE_ID",$PROFILE_ID);

      $query = $this->db->get(); 

      if($query){
         return $query->result_array();
      }
    }
    
    public function getUsersProfile($PROFILE_ID)
    {
      $this->db->select("usr.*");
      $this->db->from("admin_users as usr");
      $this->db->join("admin_profiles_users as pusr","pusr.USER_ID=usr.USER_ID");
      $this->db->where("pusr.PROFILE_ID",$PROFILE_ID);

      $query = $this->db->get();

      if($query){
         return $query->result_array();
      }
    }


    public function getMois()
    {
     $this->db->select("DISTINCT(date_format(DATE_INSERTION,'%Y-%m')) as mois");
     $query = $this->db->get("tk_ticket");
 
      if($query){
        return $query->result_array();
      }
   }
    public function getLast($table,$array= array(),$order_champ)
       {
         $this->db->where($array);        
         $this->db->order_by($order_champ,'DESC');        
        
         $query = $this->db->get($table);

         if($query){
          return $query->row_array();
         }
       }

    public function getOne($table,$array= array())
       {
         $this->db->where($array);        
        
         $query = $this->db->get($table);

         if($query){
          return $query->row_array();
         }
       }   

    function sum_effet_tk($table,$criteredate,$criteres = array()) {
        $this->db->select("SUM(NOMBRE_MORT) as nb_mort, SUM(NOMBRE_BLESSE) as nb_blesse");
        $this->db->where($criteres);
        $this->db->where($criteredate);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    public function sum_effet_tk_dgpc($critere = array())
    {
        $this->db->select("COUNT(dhd.DEGAT_HUMAIN_ID) as nb_info");
        $this->db->from('interv_odk_degat_humain dhd');
        $this->db->join('tk_ticket tt','tt.TICKET_CODE = dhd.TICKET_CODE');
        $this->db->where($critere);
        $query = $this->db->get();

        if($query)
          {
            return $query->row_array();
          }
    }

    function getList($table,$criteres = array()) {
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    
    function getList2($table,$criteres = array(),$criteres2 = array(),$criteres3 = array(),$criteres4 = array()) {
        $this->db->where($criteres);
        $this->db->where($criteres2);
        $this->db->where($criteres3);
        $this->db->where($criteres4);
        $query = $this->db->get($table);
        return $query->result_array();
    }

   function delete($table,$criteres){
        $this->db->where($criteres);
        $query = $this->db->delete($table);
        return ($query) ? true : false;
    }

    function getListDistinct($table,$criteres = array(),$distinctions) {
        $this->db->select("DISTINCT($distinctions)");
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }


   function getDate($table, $whereDate,$criteres = array()) {
        $this->db->where($whereDate);
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function make_query($table,$select_column=array(),$critere_txt = NULL,$critere_array=array(),$order_by=array())
    {
        $this->db->select($select_column);
        $this->db->from($table);

        if($critere_txt != NULL){
            $this->db->where($critere_txt);
        }
        if(!empty($critere_array))
          $this->db->where($critere_array);

        if(!empty($order_by)){
            $key = key($order_by);
          $this->db->order_by($key,$order_by[$key]);  
        }        
          
    }
    
    public function make_datatables($table,$select_column,$critere_txt,$critere_array=array(),$order_by)
    {
        $this->make_query($table,$select_column,$critere_txt,$critere_array,$order_by);
        if($_POST['length'] != -1){
           $this->db->limit($_POST["length"],$_POST["start"]);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data($table,$select_column,$critere_txt,$critere_array,$order_by)
    {
        $this->make_query($table,$select_column,$critere_txt,$critere_array,$order_by);
        $query = $this->db->get();
        return $query->num_rows();
        
    }

    public function count_all_data($table,$critere = array())
    {
       $this->db->select('*');
       $this->db->where($critere);
       $this->db->from($table);
       return $this->db->count_all_results();   
    }

    public function get_permission($url)
    {
        $this->db->select('af.*');
        $this->db->from('admin_fonctionnalites af');
        $this->db->join('admin_fonctionnalite_profil afp','afp.FONCTIONNALITE_ID = af.FONCTIONNALITE_ID');
        //$this->db->join('admin_profile ap','ap.PROFILE_ID = afp.PROFILE_ID');
        $this->db->join('admin_profiles_users aps','aps.PROFILE_ID = afp.PROFILE_ID');
        $this->db->where('af.FONCTIONNALITE_URL',$url);
        $this->db->where('aps.USER_ID',$this->session->userdata('DGPC_USER_ID'));

        $query = $this->db->get();

        if($query){
            return $query->row_array();
        }
    }
       function getListOrder($table,$criteres=array(),$order_by)
      {
         if(!empty($criteres))
          $this->db->where($criteres);
        
        $this->db->order_by($order_by,'ASC');
        $query= $this->db->get($table);
        
        if($query)
        {
            return $query->result_array();
        }
    }
    function create($table, $data) {

        $query = $this->db->insert($table, $data);
        return ($query) ? true : false;

    }
     function checkvalue($table, $criteres) {
        $this->db->where($criteres);
        $query = $this->db->get($table);
        if($query->num_rows() > 0)
        {
           return true ;
        }
        else{
    return false;
    }
    }
    function update($table, $criteres, $data) {
        $this->db->where($criteres);
        $query = $this->db->update($table, $data);
        return ($query) ? true : false;
    }


  function querysql($sql){
    $query=$this->db->query($sql);
    return $query->result_array();
    //return $query->row_array();

  }


  function querysqlone($sql){
    $query=$this->db->query($sql);
    return $query->row_array();
    //return $query->row_array();

  }


   function list_Some_One($table, $condition,$champ,$value="DESC") {
        $this->db->where($condition);
        $this->db->order_by($champ,$value);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    public function getEquipeHoraire($heure,$cppc_id)
    {
      $this->db->select("he.*");
      $this->db->from("rh_equipe_cppc ec");
      $this->db->join("horaire_equipe he","he.EQUIPE_ID = ec.EQUIPE_ID");
      $this->db->where("he.HEURE_DEBUT< $heure AND  he.HEURE_FIN >$heure");
      $this->db->where('ec.CPPC_ID',$cppc_id);
      $query = $this->db->get();

      if($query){
        return $query->row_array();
      }
    }
    
    public function verify_admin_dgpc()
    {
       $this->db->select();
       $this->db->from('admin_profiles_users apu');
       $this->db->join('admin_profile ap','ap.PROFILE_ID = apu.PROFILE_ID');
       $this->db->where('apu.USER_ID',$this->session->userdata('DGPC_USER_ID'));
       $this->db->where('ap.PROFILE_CODE','SYSADMIN');

       $query = $this->db->get();

       if($query){
        return $query->row_array();
       }
    }

    public function verify_standard_dgpc($USER_ID)
    {
       $this->db->select();
       $this->db->from('admin_profiles_users apu');
       $this->db->join('admin_profile ap','ap.PROFILE_ID = apu.PROFILE_ID');
       $this->db->where('apu.USER_ID',$USER_ID);
       $this->db->where('ap.PROFILE_CODE','STDGPC');

       $query = $this->db->get();

       if($query){
        return $query->row_array();
       }
    }

    function getListRequest($requete){
        $query = $this->db->query($requete);
      if($query){
         return $query->result_array();
      }
  }

  public function check_profile($USER_ID)
  {
     $this->db->select("DISTINCT(ap.NIVEAU_VALIDATION)");
     $this->db->select('ap.NIVEAU_VALIDATION');
     $this->db->from('admin_profile ap');
     $this->db->join('admin_profiles_users apu','apu.PROFILE_ID=ap.PROFILE_ID');
     $this->db->where('apu.USER_ID',$USER_ID);
     $this->db->where('ap.NIVEAU_VALIDATION>',0);

     $query = $this->db->get();

     if($query){
         return $query->result_array();
     }
  }

  public function getMembresServices($service_id)
  {
     $this->db->select("pers.*");
     $this->db->from("rh_personnel_dgpc pers");
     $this->db->join("rh_service_manager srv_man ","srv_man.PERSONNEL_ID= pers.PERSONNEL_ID");
     $this->db->where("srv_man.SERVICE_DGPC_ID",$service_id);

     $query = $this->db->get();
     if($query){
      return $query->result_array();
     }
  }
   
   public function getIncidentIntervention($criteres)
    {
      $this->db->select("tt.*,COUNT(img.IMAGE_ID) as nb_image,COUNT(vd.VIDEO_ID) as nb_video");
      $this->db->from('tk_ticket tt');
      $this->db->join('interv_odk_images img','img.TICKET_CODE=tt.TICKET_CODE','LEFT');
      $this->db->join('interv_odk_videos vd','vd.TICKET_CODE=tt.TICKET_CODE','LEFT');
      $this->db->where($criteres);
      $this->db->group_by('tt.TICKET_ID');

      $query = $this->db->get();
      //echo $this->db->last_query();
      if($query){
         return $query->result_array();
      }
    } 
      function getSommes($table, $criteres = array(),$somme,$info,$group) {
        $this->db->select_sum($somme);
        $this->db->select($info);
        $this->db->where($criteres);
        $this->db->group_by($group);
        $query = $this->db->get($table);
        return $query->result_array();
    }
    function getListOrdered($table,$order=array(),$criteres = array()) {
        $this->db->where($criteres);
        $this->db->order_by($order,"DESC");
        $query = $this->db->get($table);
        return $query->result_array();
    }
    public function getListJoin($cond=array())
    
    {

       $this->db->select("NOM_PRENOM,CONCERNE_DGPC,STATUT_SANTE");
       $this->db->from('tk_ticket tk');
       $this->db->join(" interv_odk_degat_humain dh","tk.TICKET_CODE = dh.TICKET_CODE");
      
       $this->db->where($cond);
       
       $query = $this->db->get();
       if($query){
          return $query->result_array();
       }
    }
     function getOneSearch($table, $criteres) {
        $this->db->like($criteres);
        $query = $this->db->get($table);
        return $query->row_array();
    }
    function member_profile($PERSONNEL_ID)
  {
       $this->db->select("pres.*,adm_prl.*");
       $this->db->from('rh_personnel_dgpc AS pres');
       $this->db->join("admin_users AS adm","pres.PERSONNEL_ID = adm.PERSONNEL_ID");
       $this->db->join("admin_profiles_users AS adm_usr","adm_usr.USER_ID = adm.USER_ID");
       $this->db->join("admin_profile AS adm_prl","adm_prl.PROFILE_ID = adm_usr.PROFILE_ID");
       $this->db->where("adm.PERSONNEL_ID",$PERSONNEL_ID);
       $query = $this->db->get();
       if($query){
          return $query->row_array();
       }
  }

    function member()
  {
       $this->db->select("pres.*");
       $this->db->from('rh_personnel_dgpc AS pres');
       $this->db->join("admin_users AS adm","pres.PERSONNEL_ID = adm.PERSONNEL_ID");
       $this->db->join("admin_profiles_users AS adm_usr","adm_usr.USER_ID = adm.USER_ID");
       $this->db->join("admin_profile AS adm_prl","adm_prl.PROFILE_ID = adm_usr.PROFILE_ID");
       $this->db->where("adm_prl.PROFILE_CODE = 'AGCPPC'");
       $query = $this->db->get();
       if($query){
          return $query->result_array();
       }
  }

  public function mes_intervention($my_id)
  {
    $this->db->select("DISTINCT(tt.TICKET_ID),tt.*, ts.STATUT_DESCR,ts.STATUT_COLOR,cm.COMMUNE_NAME,cp.CPPC_NOM,tcaus.CAUSE_DESCR");
    $this->db->from("interv_intervenants interv");
    $this->db->join("tk_ticket tt","tt.TICKET_CODE = interv.TICKET_CODE");
    $this->db->join("rh_cppc cp","cp.CPPC_ID = tt.CPPC_ID");
    $this->db->join("tk_statuts ts","tt.STATUT_ID = ts.STATUT_ID");
    $this->db->join("tk_causes tcaus","tcaus.CAUSE_ID = tt.CAUSE_ID");
    $this->db->join("ststm_communes cm","cm.COMMUNE_ID = tt.COMMUNE_ID");
    $this->db->where("interv.PERSONNEL_ID ",$my_id);
    
    $this->db->order_by('tt.TICKET_CODE','DESC');

    $query = $this->db->get();
   // echo $this->db->last_query();

    if($query){
      return $query->result_array();
    }
  }

  public function getMembreDHAMI()
  {
    $this->db->select('coll.*');
    $this->db->from('rh_service_dgpc srdg');
    $this->db->join('rh_service_manager srman','srdg.SERVICE_DGPC_ID =srman.SERVICE_DGPC_ID');
    $this->db->join('rh_personnel_dgpc coll','coll.PERSONNEL_ID=srman.PERSONNEL_ID');
    $this->db->where("srdg.SERVICE_DGPC_DESCR LIKE '%DHAMI%'");
    $query = $this->db->get();
    echo $this->db->last_query();

    if($query)
    {
      return $query->result_array();
    }
  }

  public function fetch_notification($cond){
       $this->db->select("interv_notification.NOTIFICATION_ID,interv_notification.TELEPHONE,interv_notification.TICKET_ID,interv_notification.MESSAGE_TEL,interv_notification.DATE_INSERTION,rh_personnel_dgpc.PERSONNEL_NOM,rh_personnel_dgpc.PERSONNEL_PRENOM,tk_ticket.TICKET_CODE,tk_ticket.LOCALITE,tk_ticket.DATE_INTERVENTION,rh_cppc.CPPC_NOM,rh_equipe_cppc.EQUIPE_NOM");
       $this->db->from('interv_notification');
       $this->db->join("tk_ticket","interv_notification.TICKET_ID = tk_ticket.TICKET_ID");
       $this->db->join("interv_intervenants","interv_intervenants.TICKET_CODE = tk_ticket.TICKET_CODE");
       $this->db->join("rh_personnel_dgpc","interv_intervenants.PERSONNEL_ID = rh_personnel_dgpc.PERSONNEL_ID");
       $this->db->JOIN("rh_cppc", "rh_cppc.CPPC_ID = tk_ticket.CPPC_ID");
       $this->db->JOIN("rh_equipe_cppc", "rh_cppc.CPPC_ID = tk_ticket.CPPC_ID");
       $this->db->where($cond);
       $query = $this->db->get();
       if($query){
          return $query->result_array();
       }
  }

  function insert_batch($table,$data){
      
    $query=$this->db->insert_batch($table, $data);
    return ($query) ? true : false;
   

    }
    public function get_Max_ID($id_ch,$tab) 
 {
        $this->db->select('max('.$id_ch.') as id_max');
        $this->db->from($tab);
        $query = $this->db->get();
        if ($query) {
            return $query->row_array();
        }  


        }


  public function reportingstatut($statutid,$date) {
       $this->db->select("COUNT(TICKET_ID) as nbre");
       $this->db->where("DATE_INSERTION LIKE '%$date%'");
       $this->db->where('STATUT_ID',$statutid);

       $query = $this->db->get('tk_ticket');
       if($query){
        return $query->row_array();
       }
   }
     public function getListeticke($conditions)
    {
      $this->db->select("tkt.*,stt.STATUT_COLOR,caus.CAUSE_DESCR,can.CANAL_DESCR,stt.STATUT_DESCR,cmn.COMMUNE_NAME,pr.PROVINCE_NAME,cppc.CPPC_NOM");
      $this->db->from("tk_ticket tkt");
      $this->db->join("tk_causes caus","caus.CAUSE_ID=tkt.CAUSE_ID");
      $this->db->join("tk_canal can","can.CANAL_ID=tkt.CANAL_ID");
      $this->db->join("tk_statuts stt","stt.STATUT_ID=tkt.STATUT_ID");
      $this->db->join("ststm_communes cmn","cmn.COMMUNE_ID=tkt.COMMUNE_ID");
      $this->db->join("ststm_provinces pr","pr.PROVINCE_ID=cmn.PROVINCE_ID");
      $this->db->join("rh_cppc cppc","cppc.CPPC_ID=tkt.CPPC_ID");

      if($conditions != NULL)
        $this->db->where($conditions);
      $this->db->order_by("tkt.TICKET_CODE","DESC");

      $query = $this->db->get();

      if($query){
        return $query->result();
      }
    }


     function getListDistinct2($table,$criteres = array(),$distinctions) {
        $this->db->select("DISTINCT($distinctions) as year");
        $this->db->where($criteres);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function getList_cond4($table,$criteres = array(),$criteres2 = array(),$criteres3 = array(),$criteres4 = array()) {
        $this->db->where($criteres);
        $this->db->where($criteres2);
        $this->db->where($criteres3);
        $this->db->where($criteres4);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function getOne_cond4($table,$criteres = array(),$criteres2 = array(),$criteres3 = array(),$criteres4 = array())
       {
         $this->db->where($criteres);
         $this->db->where($criteres2);
         $this->db->where($criteres3);
         $this->db->where($criteres4);              
         $query = $this->db->get($table);
         if($query){
          return $query->row_array();
         }
       } 

       public function getOne_cond5($table,$criteres = array(),$criteres2 = array(),$criteres3 = array(),$criteres4 = array(),$criteres5 = array())
       {
         $this->db->where($criteres);
         $this->db->where($criteres2);
         $this->db->where($criteres3);
         $this->db->where($criteres4); 
         $this->db->where($criteres5);              
         $query = $this->db->get($table);
         if($query){
          return $query->row_array();
         }
       }
       function getRequete($requete){
      $query=$this->db->query($requete);
      if ($query) {
         return $query->result_array();
      }
    }
   function getRequeteOne($requete){
      $query=$this->db->query($requete);
      if ($query) {
         // return $query->result_array();
        return $query->row_array();
      }
    }




   function record_countcriteres($table,$criteres1=array(),$criteres2,$criteres3,$criteres4,$criteres5 = '')
    {
      $this->db->where($criteres1);
      $this->db->where($criteres2);
      $this->db->where($criteres3);
      $this->db->where($criteres4);
      $this->db->where($criteres5);
    
       $query= $this->db->get($table);
       if($query)
       {
           return $query->num_rows();
       }
       
    }
    public function getdonneeMateriels($cppc_id,$MATERIEL_ID)
    {
      $this->db->select("SUM(QUANTITE_DISTRIBUE) as nbmateriel");
      $this->db->where('CPPC_ID',$cppc_id);
      $this->db->where('MATERIEL_ID',$MATERIEL_ID);

      $query = $this->db->get('inter_materiaux_distribue');

      if($query){
          return $query->row_array();
      }
    }

     function getList_cond5($table,$criteres = array(),$criteres2 = array(),$criteres3 = array(),$criteres4 = array(),$criteres5 = array()) {
        $this->db->where($criteres);
        $this->db->where($criteres2);
        $this->db->where($criteres3);
        $this->db->where($criteres4);
        $this->db->where($criteres5);
        $query = $this->db->get($table);
        return $query->result_array();
    } 

    public function getChefEquipe($TICKET_CODE)
    {
       $this->db->select("pers.*");
       $this->db->from("rh_personnel_dgpc pers"); 
       $this->db->join("interv_intervenants interv","interv.PERSONNEL_ID=pers.PERSONNEL_ID");
       $this->db->join("rh_equipe_membre_cppc memb","memb.PERSONEL_ID=pers.PERSONNEL_ID");
       $this->db->where("memb.IS_CHEF_EQUIPE",1); 
       $this->db->where("interv.IS_APPUI",0); 
       $this->db->where("interv.TICKET_CODE",$TICKET_CODE); 

       $query = $this->db->get();
       if($query){
          return $query->row_array();
       }
    }



}