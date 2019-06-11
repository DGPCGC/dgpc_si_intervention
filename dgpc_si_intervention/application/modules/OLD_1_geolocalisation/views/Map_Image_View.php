<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class="container" style="background-color: white">
      <h4><?=$title?></h4>
      <fieldset>
        <legend>Information du Ticket</legend>
            <table class="table table-bordered table-striped">
                            <tr>
                                <th>Code intervention</th>
                                <th>Description</th>
                                <th>Date Déclaré</th>
                                <th>Déclaré par</th>
                            </tr>
                            <tr>
                                <td><?=$ticket['TICKET_CODE']?></td>
                                <td><?=$ticket['TICKET_DESCR']?></td>
                                <td><?php $date_inter = new DateTime($ticket['DATE_INSERTION']); echo $date_inter->format('d/m/Y');?></td>
                                <td><?=$ticket['TICKET_DECLARANT'].' ('.$ticket['TICKET_DECLARANT_TEL'].')'?></td>
                            </tr>
                            
                            <tr>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Localité</th>
                                <th>Commune/Province</th>
                            </tr>

                            <tr>
                                <td><?=$ticket['LATITUDE']?></td>
                                <td><?=$ticket['LONGITUDE']?></td>
                                <td><?=$ticket['LOCALITE']?></td>
                                <td>
                                   <?php 
                                     $commune = $this->mylibrary->getOne('ststm_communes',array('COMMUNE_ID'=>$ticket['COMMUNE_ID']));
                                     $province = $this->mylibrary->getOne('ststm_provinces',array('PROVINCE_ID'=>$commune['PROVINCE_ID']));
                                     
                                    echo $commune['COMMUNE_NAME'].'/'.$province['PROVINCE_NAME'];
                                   ?>


                                </td>
                            </tr>

                            <tr>
                                <th>Statut</th>
                                <th>Canal</th>
                                <th>Cause</th>
                                <th>Enregistré par</th>
                            </tr>

                            <tr>
                                
                                <td><?=$this->mylibrary->getOne('tk_statuts',array('STATUT_ID'=>$ticket['STATUT_ID']))['STATUT_DESCR']?></td>
                                <td><?=$this->mylibrary->getOne('tk_canal',array('CANAL_ID'=>$ticket['CANAL_ID']))['CANAL_DESCR']?></td>
                                <td><?=$this->mylibrary->getOne('tk_causes',array('CAUSE_ID'=>$ticket['CAUSE_ID']))['CAUSE_DESCR']?></td>
                                <td><?php $user = $this->mylibrary->getOne('admin_users',array('USER_ID'=>$ticket['USER_ID'])); 
                                 echo $user['USER_NOM'].' '.$user['USER_PRENOM'];?></td>
                            </tr>

                        </table>
        </fieldset>
       <fieldset>
       	<legend>Images</legend>
       <?php
         foreach ($images as $image) {          
          echo '<img src="data:image/jpeg;base64,'.base64_encode($image['IMAGE_BLOB']) .'" width="200" alt="user image" title="image" download/>';
        }
       ?>
       </fieldset>

       <fieldset>
        <legend>Vidéos</legend>
       <?php
         foreach ($videos as $video) {          
           $ma_video = "data:video/mp4;base64,".base64_encode($video['VIDEO_BLOB']);
            echo "<video controls width='150px' height='150px'><source src='".$ma_video."' type='video/mp4'></video>";
        }
       ?>
       </fieldset>
    </div>
    </body>
    </html>