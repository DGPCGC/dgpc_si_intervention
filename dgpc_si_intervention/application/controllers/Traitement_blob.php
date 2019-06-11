
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Traitement_blob extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
    	echo 'Test';
    }

    public function readblob()
	{
		$donnes = $this->Model->getOne('tableblob',array('ID'=>2));
        $image = $donnes['VALUE'];
        Header("Content-type: image/png");
        echo $image;
        
        $collaboFolder = FCPATH . 'uploads/first_doc.png';
        file_put_contents($collaboFolder, $image);

		/*foreach ($donnes as $donne) {
			Header("Content-type: image/jpeg");
            echo $donne['VALUE']; 
		}*/
	}

}

?>