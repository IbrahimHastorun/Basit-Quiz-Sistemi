<?php

try {

	$database = new PDO("mysql:host=localhost;dbname=phpuygulamalar;charset=utf8", "root","");
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
} catch (PDOException $e) {
	die($e->getMessege());
}

function sorularıgetir($database) { ?>

    <h4>QUİZ 1</h4>

    <form action="index.php?islem=sonuc" method="post"> <?php
        $sorular = $database->prepare("SELECT * FROM sorular");
        $sorular->execute();
        while($sorularcek = $sorular->fetch(PDO::FETCH_ASSOC)) { ?>

            <div class="row" id="renk" style="margin-bottom:0px;">
                <div class="col-sm-12" id="pad">
                    <?php echo $sorularcek['soru']; ?>
                </div>
            </div>

            <div class="row" id="renk" style="margin-top:0px;">
                <div class="col-sm-6" id="pad">
                    <input type="radio" name="cevap<?php echo $sorularcek['id']; ?>" value="<?php echo $sorularcek['cevap1']; ?>">
                    <?php echo $sorularcek['cevap1']; ?>
                </div>
                <div class="col-sm-6" id="pad">
                    <input type="radio" name="cevap<?php echo $sorularcek['id']; ?>" value="<?php echo $sorularcek['cevap2']; ?>">
                    <?php echo $sorularcek['cevap2']; ?>
                </div>
                <div class="col-sm-6" id="pad">
                    <input type="radio" name="cevap<?php echo $sorularcek['id']; ?>" value="<?php echo $sorularcek['cevap3']; ?>">
                    <?php echo $sorularcek['cevap3']; ?>
                </div>
                <div class="col-sm-6" id="pad">
                    <input type="radio" name="cevap<?php echo $sorularcek['id']; ?>" value="<?php echo $sorularcek['cevap4']; ?>">
                    <?php echo $sorularcek['cevap4']; ?>
                </div>
                <input type="hidden" value="<?php echo $sorularcek['id'] ?>" name="id<?php echo $sorularcek['id'] ?>">
            </div> <?php

        } ?>
        <br> 
        <input name="buton" class="btn btn-success" type="submit" value="CEVAPLA">  
    </form><?php 
    

}

function sonuc($database) { ?>

    <h4>SONUÇLAR</h4> <?php

    @$buton = $_POST['buton'];

    if ($buton) {

        $cevapkontrol = $database->prepare("SELECT * FROM sorular");
        $cevapkontrol->execute();
        $sorusayisi = $cevapkontrol->rowCount();
        $hata = 0;
        while($cevapkontrolcek = $cevapkontrol->fetch(PDO::FETCH_ASSOC)) { 

            @$gelenid = $_POST['id'.$cevapkontrolcek['id']];
            @$gelencevap = $_POST['cevap'.$cevapkontrolcek['id']];

            $kontrol = $database->prepare("SELECT * FROM sorular where id = ?");
            $kontrol->bindParam(1,$gelenid,PDO::PARAM_STR);
            $kontrol->execute();
            $kontrolcek = $kontrol->fetch();

            if ($kontrolcek['dogru_cevap'] == $gelencevap) {
                //bir işlem yapılabilir
            } else {

                ++$hata; ?>
                <div class="row" id="renk">
                    <div class="col-sm-4">Soru No : <?php echo $kontrolcek['id'] ?></div>
                    <div class="col-sm-4">Verdiğin Cevap : <?php echo $gelencevap ?></div>
                    <div class="col-sm-4">Doğru Cevap : <?php echo $kontrolcek['dogru_cevap'] ?></div>
                </div> <?php
                
            }

        }

        if ($hata == 0) {  ?>

            <div class="row" id="renk">
                <div class="col-sm-12">SANA HELAL OLSUN TEBRİK EDERİM</div>
            </div> <?php

        } else { ?> 
        
            <div class="row" id="renk">
                <div class="col-sm-6">Hatalı Cevap Sayısı : <?php echo $hata ?></div>
                <div class="col-sm-6">Başarı Oranı : <?php echo "%". 5 * ($sorusayisi- $hata) ?></div>
            </div> <?php

        }

    } else {

        echo "Hata Var";
        
    }


}

function giris($database) { ?>

    <form action="index.php?islem=tanimla" method="post">
        <div class="row" id="renk" style="text-align:center;">
            <div class="col-sm-12">
                PAROLA <input type="password" required="required" name="giris" placeholder="Şifrenizi Giriniz..">
            </div>
            <div class="col-sm-12">
                <br>
                <input class="btn btn-warning" type="submit" name="gbuton" value="BAŞLA">
            </div>
        </div>
    </form> <?php

}

function formkontrol($database) {

    @$gbuton = $_POST['gbuton'];
    $pass = htmlspecialchars($_POST['giris']);

    if ($gbuton) {

        if ($pass != "") {

            $passkontrol = $database->prepare("SELECT * FROM giris WHERE password = ?");
            $passkontrol->bindparam(1,$pass,PDO::PARAM_STR);
            $passkontrol->execute();
            $passkontrolcek = $passkontrol->fetch();

            if ($passkontrol->rowCount() == 0) {

                echo "Şifre Hatalı";
                header("refresh:2,url=index.php");
                
            }else {

                $_SESSION['izin'] = "ok";

                echo "Oturum Başlatıldı";

                header("refresh:2,url=index.php");
                
            }
           
        }else {

            echo "Şifrenizi Giriniz";
            
        }

       
        
    }else {

        echo "Hata Var";
    }


}






?>