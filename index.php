 <?php
session_start();
$fichierTransmis = $_FILES['nomDuFichier']['name'];
$fichierTransmisSize = $_FILES['nomDuFichier']['size'] . "<br />";
$fichierCharge = $_FILES['nomDuFichier']['tmp_name'];
$fichierCopie = 'Images/' . $_FILES['nomDuFichier']['name'];
$_SESSION['fichierCopie'] = $fichierCopie;
$fichierCopieSize = 'Images/' . $_FILES['nomDuFichier']['size'];
if (!file_exists($fichierCopie) && !($fichierTransmisSize == $fichierCopieSize)) {
    move_uploaded_file($fichierCharge, $fichierCopie);
    echo "Stocke dans : " . $fichierCopie;
} else {
    echo "Ce fichier existe deja!";
}
echo "<br>";
$nomImage = "Images/" . $fichierTransmis;
$img = '<img src="' . $nomImage . '" id = "monImage"/>';
$info = getimagesize($nomImage);
$largeur = $info[0] . "<br />";
$hauteur = $info[1] . "<br />";
$ratio = $largeur / $hauteur;
$hauteur1 = (500 / $ratio);
$hauteur2 = (800 / $ratio);
$hauteur3 = (1000 / $ratio);
$db = mysql_connect('zeta2.labunix.uqam.ca', 'hd791183' ,'pBzKUIWr');
mysql_select_db('db_hd791183', $db);
$login = $_SESSION['logins'];
$password = $_SESSION['passwords'];
$_SESSION['telephones'] = $_POST['telephone'];
$telephone = $_SESSION['telephones'];
$_SESSION['adresses'] = $_POST['adresse'];
$adresse = $_SESSION['adresses'];
$_SESSION['emails'] = $_POST['email'];
$email = $_SESSION['emails'];

if($_SESSION['cle'] === "modifier"){
$_SESSION['newLogin'] = $_POST['login'];
$_SESSION['newPassword'] = $_POST['password'];
}
if ($telephone == "" || $telephone == NULL) {
    $sqlAncienTelephone = "SELECT telephone FROM commandes WHERE login='$login' AND password='$password'";
    $reqAncienTelephone = mysql_query($sqlAncienTelephone) or die('Erreur SQL !<br>' . $sqlAncienTelephone . '<br>' 
            . mysql_error());
    $i = 0;
    while ($row = mysql_fetch_array($reqAncienTelephone)) {
        $list[$i] = $row['telephone'];
        $i++;
    }
    $_SESSION['telephones'] = $list[$i - 1];
   } else {
    $sqlNouveauTelepnone = "UPDATE commandes SET telephone = '$telephone' WHERE login='$login' AND password='$password'";
    $reqNouveauTelepnone = mysql_query($sqlNouveauTelepnone) or die('Erreur SQL !<br>' . $sqlNouveauTelepnone . '<br>' 
            . mysql_error());
}
if ($adresse == "" || $adresse == NULL) {
    $sqlAncienAdresse = "SELECT adresse FROM commandes WHERE login='$login' AND password='$password'";
    $reqAncienAdresse = mysql_query($sqlAncienAdresse) or die('Erreur SQL !<br>' . $sqlAncienAdresse . '<br>' 
            . mysql_error());
    $i = 0;
    while ($row = mysql_fetch_array($reqAncienAdresse)) {
        $list[$i] = $row['adresse'];
        $i++;
    }
    $_SESSION['adresses'] = $list[$i - 1];
} else {
    $sqlNouveauAdresse = "UPDATE commandes SET adresse = '$adresse' WHERE login='$login' AND password='$password'";
    $reqNouveauAdresse = mysql_query($sqlNouveauAdresse) or die('Erreur SQL !<br>' . $sqlNouveauAdresse . '<br>' 
            . mysql_error());
}
if ($email == "" || $email == NULL) {
    $sqlAncienEmail = "SELECT email FROM commandes WHERE login='$login' AND password='$password'";
    $reqAncienEmail = mysql_query($sqlAncienEmail) or die('Erreur SQL !<br>' . $sqlAncienEmail . '<br>' 
            . mysql_error());
    $i = 0;
    while ($row = mysql_fetch_array($reqAncienEmail)) {
        $list[$i] = $row['email'];
        $i++;
    }
    $_SESSION['emails'] = $list[$i - 1];
} else {
    $sqlNouveauEmail = "UPDATE commandes SET email = '$email' WHERE login='$login' AND password='$password'";
    $reqNouveauEmail = mysql_query($sqlNouveauEmail) or die('Erreur SQL !<br>' . $sqlNouveauEmail . '<br>' 
            . mysql_error());
}
mysql_close();
?>

<html>
    <head>
       <link rel="stylesheet" type="text/css" href="css/Style.css"/>
        <link rel="stylesheet" type="text/css" href="css/principal.css"  />
        <script type="text/javascript" src="js/index.js"></script>
    </head>
    <body>
        <form action="Final.php" method="post"  enctype="multipart/form-data" 
              onsubmit="return validateDimentions()">
            <div id="photo">
                <?php echo $img; ?>
            </div>

            <br />


            Dimensions:
            <select id="mySelect" onchange="sizeFunction()" name="dimentionSelect"> <br />
                <option > </option> <br />
                <option value = "13 x <?php echo (int) ($hauteur1 / 37.79) ?> cm">13 x <?php echo (int) ($hauteur1 / 37.79) ?> cm</option> <br />
                <option value = "21 x <?php echo (int) ($hauteur2 / 37.79) ?> cm">21 x <?php echo (int) ($hauteur2 / 37.79) ?> cm</option> <br />
                <option value = "26 x <?php echo (int) ($hauteur3 / 37.79) ?> cm">26 x <?php echo (int) ($hauteur3 / 37.79) ?> cm</option> <br />
            </select > <br />

            <p id="demo"></p>



            Type de materiel:
            <select id="frameType" name="frameType" onchange="materielFunction()">
                <option value = "bois" >Bois</option>
                <option value = "metal" >Metal</option>
            </select>
            <br>

            <p id="materiel"></p>

            Profondeur des marges:
            <select id="profondeur" name="profondeur" onchange="profondeurFunction()">
                <option value = "1cm"></option>
                <option value = "1cm">1 cm</option>
                <option value = "2cm" >2 cm</option>
                <option value = "3cm" >3 cm</option>
            </select>
            <br>

            <p id="profondeurMarges"></p>

            Largeur des marges:
            <select id="largeurMarges" name="largeurMarges" onchange="margeFunction()">
                <option value = "1cm"></option>
                <option value = "1cm">1 cm</option>
                <option value = "2cm">2 cm</option>
                <option value = "3cm">3 cm</option>
            </select>
            <br>

            <p id="marges"></p>

            Couleur de cadre:
            <select id="frameColor" name="frameColor" onclick="colorFunction()">
                <option value = "bois" ></option>
                <option value = "red" >Rouge</option>
                <option value = "black" >Noir</option>
                <option value = "brown" >Brun</option>
                <option value = "white" >Blanc</option>
                <option value = "blue" >Bleu</option>
            </select>

            <p id="color"></p>

            <br>

            Modele de cadre:
            <select id="framePart" name="framePart" onchange="frameFunction()">
                <option ></option>
                <option value = "top" >Haut</option>
                <option value = "right" >Droit</option>
                <option value = "bottom" >Bas</option>
                <option value = "left" >Gauche</option>
            </select>
            <br>

            <p id="frame" name = "frame"></p>

            <br>
            <input type="hidden" id="topcolor" name="topcolor" value=""> </input>
            <input type="hidden" id="bottomcolor" name="bottomcolor" value=""> </input>
            <input type="hidden" id="rightcolor" name="rightcolor" value=""> </input>
            <input type="hidden" id="leftcolor" name="leftcolor" value=""> </input>

            <input type="submit" name="terminer" value="Terminer" />
        </form>
    </body>
</html>

<?
?>
