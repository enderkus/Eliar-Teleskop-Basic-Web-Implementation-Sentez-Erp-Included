<?php

include 'db.php';

 ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>WEB EMMC V0.1 (BETA)</title>
    <style media="screen">
    body {
      background-color: #b2bec3;
    }

    </style>
  </head>
  <body>

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">WEB EMMC</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-link active" href="index.php">ANA SAYFA <span class="sr-only">(current)</span></a>

    </div>
  </div>
</nav>




    <div class="container-fluid">
      <div class="row">


        <?php

        $makinalarigetir = $database->select("BFMACHINES","*");
        $makinarrgetir = $database->select("TFMACHINESTATUS","RUNNING_JOBORDER");


        foreach ($makinalarigetir as $mg) {
          $makinedurum = $database->select("TFMACHINESTATUS","*",[
            "MACHINEID" => $mg["MACHINEID"],
          ]);



         ?>


        <div class="col-sm-3 mt-4">
        <div class="card bg-secondary text-light">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <b><?= str_replace(" ","",$mg["MACHINECODE"]); ?> (<?= $mg["MACHINEID"]; ?>)</b>
              </div>

              <div class="col-6 text-right">
                <div class="badge badge-warning">IP : <?= $mg["IP"]; ?> <i class="fa fa-desktop text-success"></i>
                  <?php

                  $host = $mg["IP"];
                  $port = 80;
                  $waitTimeoutInSeconds = 1;
                  if(@$fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){
                     echo '<i class=" fa fa-eye text-success"></i>';
                  } else {
                     echo '<i class=" fa fa-eye text-danger"></i>';
                  }
                  @fclose($fp);


                  ?>



                </div>
              </div>
            </div>

          </div>

          <div class="card-body">
            <div class="row no-gutters">
              <div class="col-4">
                <input type="text" class="form-control bg-dark text-light" value="<?= $makinedurum[0]["RUNNING_JOBORDER"]; ?>" disabled>
              </div>
              <div class="col-8">
                <input type="text" class="form-control bg-dark text-success" value="<?= $makinedurum[0]["RUNNING_PROGRAMNAME"]; ?>" disabled>
              </div>

              <div class="col-12 mt-1">
                <div class="progress">
                  <div class="progress-bar bg-info" role="progressbar" style="width: <?= $makinedurum[0]["runningCompletionRatio"]; ?>%;" aria-valuenow="<?= $makinedurum[0]["runningCompletionRatio"]; ?>" aria-valuemin="0" aria-valuemax="100"><?= $makinedurum[0]["runningCompletionRatio"]; ?>%</div>
                </div>
              </div>

              <div class="col-4 mt-1">

                  <input type="text" class="form-control bg-dark text-warning" value="<?= substr($makinedurum[0]["UPDATETIME"],5); ?>" disabled>

              </div>
              <div class="col-8 mt-1">

                  <input type="text" class="form-control bg-dark text-warning" value="ADIM : [<?= $makinedurum[0]["RUNNING_STEPNO"]; ?>]<?= $makinedurum[0]["RUNNING_CMDNAME"]; ?>" disabled>

              </div>

              <div class="col-12 mt-1">
                <input type="text" class="form-control bg-dark text-info text-center" value="[<?= $makinedurum[0]["RUNNING_ALARMNO"]; ?>]<?= $makinedurum[0]["RUNNING_ALARMNAME"]; ?>" disabled>
              </div>

              <div class="col-12 mt-1">
                <input type="text" class="form-control bg-dark text-light text-center" value="<?php if ($makinedurum[0]["RUNNING_JOBORDER"] == "") {
                  echo "Makine boş.";
                } ?>" disabled>
              </div>

              <div class="col-12 mt-1">
                <input type="text" class="form-control bg-dark text-info text-center" value="ANLIK SICAKLIK : <?= number_format($makinedurum[0]["currentTemp"],2,',','.'); ?>C" disabled>
              </div>



            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-6">
              <!-- ERP BİLGİLERİ -->

              <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#mod<?= $mg["MACHINEID"]; ?>">
                ERP BİLGİLERİ
              </button>

<!-- Modal -->
<div class="modal fade" id="mod<?= $mg["MACHINEID"]; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable text-dark">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">ERP BİLGİLERİ <?= str_replace(" ","",$mg["MACHINECODE"]); ?>(<?= $mg["MACHINEID"]; ?>)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php

        @$trimisemri = trim(str_replace(" ","",$makinedurum[0]["RUNNING_JOBORDER"]));
        @$anaisemriid = $database2->query("SELECT * FROM Erp_WorkOrder WHERE WorkOrderNo = '".$trimisemri."'")->fetchAll();
        @$musteriadi = $database2->query("SELECT CurrentAccountName FROM Erp_CurrentAccount WHERE RecId = '".$anaisemriid[0]["CurrentAccountId"]."' ")->fetchAll();
        @$recipeid = $anaisemriid[0]["RecipeId"];
        $renkadi = $database2->query("SELECT * FROM Erp_Recipe WHERE RecId = '".$recipeid."'")->fetchAll();




         ?>


        <p>MÜŞTERİ ADI : <b> <?= @$musteriadi[0]["CurrentAccountName"]; ?> </b> </p>
        <p>RENK : <b><?= @$renkadi[0]["Explanation"] ?></b> </p>

        <?php

        @$satirbilgileri = $database2->query("SELECT * FROM Erp_WorkOrderItem WHERE WorkOrderId = '".$anaisemriid[0]["RecId"]."'")->fetchAll();




        $satirtoplam = 0;
        foreach ($satirbilgileri as $sb) {
            echo '<p class="alert alert-secondary"><b>ANA İŞ EMRİ :</b> '.$trimisemri.' <b>SATIR : </b>'.$sb["ItemOrderNo"].'- ('.number_format($sb["Quantity"],2,'.',',').'KG)</p>';
            // Kumaş Adı Buraya Gelecek

            $envanterid = $sb["InventoryId"];

            if (isset($envanterid)) {
              $envanteradi = $database2->query("SELECT * FROM Erp_Inventory WHERE RecId = '".$envanterid."' ")->fetchAll();
              echo '<p><b>KUMAŞ ADI : </b>'.$envanteradi[0]["InventoryName"].'</p>';
              echo '<hr>';

            }

            //echo '<p><b>PLANLANAN KİLOGRAM BİLGİSİ : </b>'.number_format($sb["PlannedQuantity"],2,'.',',').'KG</p>';
            //echo '<hr>';

            //echo '<p><b>GERÇEKLEŞEN KİLOGRAM BİLGİSİ : </b>'.number_format($sb["Quantity"],2,'.',',').'KG</p>';
            //echo '<hr>';



            $satirtoplam = $satirtoplam + $sb["Quantity"];
            echo '<hr>';

        }

        echo '<p><b>TOPLAM KİLO :</b> '.$satirtoplam.' KG</p>';

         ?>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">KAPAT</button>

      </div>
    </div>
  </div>
</div>


              <!-- ERP BİLGİLERİ BİTTİ -->
              </div>
              <div class="col-6 text-right">
                D.O : <?php
                $makinekapasitesi = $mg["MACHINECAPACITY"];
                $makinearray = array_count_values($makinarrgetir);
                @$isemrisay = $makinearray[$makinedurum[0]["RUNNING_JOBORDER"]];

                 $workorderbilgisi = $database2->select("Erp_WorkOrder","RecId",[
                  "WorkOrderNo" => str_replace(" ","",$makinedurum[0]["RUNNING_JOBORDER"]),
                ]);

                if (isset($workorderbilgisi[0])) {
                    $kilotopla = $database->query("SELECT TOP 1 FABRIC_WEIGHT FROM BADATA WHERE MACHINEID = '".$mg["MACHINEID"]."' AND JOBORDER = '".$makinedurum[0]["RUNNING_JOBORDER"]."' ORDER BY BATCHKEY DESC")->fetchAll();

                      @$yuzdehesapla2 = ($kilotopla[0]["FABRIC_WEIGHT"] * 100) / $makinekapasitesi;
                      echo number_format($yuzdehesapla2,1,'.',',').'%';
                } else {
                  echo "0%";
                }


                ?>
              </div>
            </div>
          </div>






        </div>
        </div>

        <?php } ?>






      </div>
    </div>

    <footer class="mt-4">
      <div class="container-fluid">
        <div class="row text-center">
          <div class="col-md-12">
            <p class="text-center">&copy; 2020</p>
          </div>
        </div>
      </div>
    </footer>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
