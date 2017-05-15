<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pluviometris
 *
 * @author piga
 */
	//inclusion des classes 
    include 'connexion_db.php';


class pluviometris {
    //put your code here
    
    public function calcul_Im($temperature)
    {
    	$temp=$temperature/5;
    	return pow($temp,1.514);
    }

    public function calculI()
    {
    	$I;

    	 $con=new connexion_db();

          if (!$con->connected()) {
              # code...

                echo 'erreur connection avec le serveur';

          }else
          {
          	$I=0;
            $conn=$con->connected();
            $resultat=$conn->query('select * from temperaturePrecipitation where Year="2017" ;');
            
            foreach ($resultat as $ligne) {
            	# code...
            	$temp_means=$ligne['Mean_Temp_Normal'];
 			        $I=$I+$this->calcul_Im($temp_means);
 				
            	
            }



           return  number_format($I,2);

          }


    	
    }

    public function calcul_a()
    {
      return 0.016*$this->calculI()+0.5;
    }

    public function calcul_ETP($mois)
    {

      $con=new connexion_db();

      if (!$con->connected()) 
      {

            echo 'erreur de connection ';
              # code...
      }
      else
      {
        $conn=$con->connected();
          $T_m=0;

          $F_m=1;

          $resultat= $conn->query("select Mean_Temp_Normal from  temperaturePrecipitation where Month='$mois' and VILLES='OUAHIGOUYA';");
          $resu= $conn->query("select colFm from  F_m where mois='$mois' ; ");

          foreach ($resultat as $ligne) 
          {
            # code...

            $T_m=$ligne['Mean_Temp_Normal'];
          }

           foreach ($resu as $ligne1) {
             # code...
              $F_m=$ligne1['colFm'];

            

           }

           return 16*(10*$T_m/$this->calculI())*$F_m;


      }

     
    }

    public function ETM($KC)
    {
      return $this->calcul_ETP(1)*$KC;
    }


    public function Besion_eau($Year,$mois)
    {

         $con=new connexion_db();


      if (!$con->connected()) 
      {

            echo 'erreur de connection ';
              # code...
      }
      else
      {
        $conn=$con->connected();
        $precipitation;
          $resultat= $conn->query("select Precip_Normal from  temperaturePrecipitation where Month='$mois' and VILLES='OUAHIGOUYA' and Year='$Year';");
          

          foreach ($resultat as $ligne) 
          {
            # code...

           $precipitation= $ligne['Precip_Normal'];

          }

           if ($precipitation>75) {
             # code...
              return $this->ETM(20)-0.8;

           }
           else
           {
               return $this->ETM(20)-0.6;
           }


          }
    }
    
}

