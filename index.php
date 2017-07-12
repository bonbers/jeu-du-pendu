    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <title>Jeu du pendu FULL php !!!</title>
        <meta charset="utf-8">
        <script src="jquery.js"></script>
        <link rel="stylesheet" href="style.css" type="text/CSS">
    </head>

    <body>

    <h1>Jeu du Pendu</h1>
    <h3>Vous avez droit à 7 erreurs !</h3>
    <h4>Clique sur les lettres de ton choix. Bonne chance !</h4>
    <?php
    error_reporting(0);
    session_start();
    $alphabet="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $tabDesMots=file('dico.txt',FILE_SKIP_EMPTY_LINES);
    $nbreLignes=count($tabDesMots, COUNT_RECURSIVE);
    $ligneAleatoire = mt_rand (0,($nbreLignes-1));
    if(!empty($_GET['reset']) && $_GET['reset'] == 'true')
        session_unset();
    if(empty($_GET['jouer']))
    {
        ?>
        <form method="post" action="index.php?jouer=oui">
            <input name="partie" type="submit" value="Commencer la partie"/>
        </form>
    <?php
    }
    else
    {
    ?>
        <form method="post" action="index.php?reset=true">
            <input name="partie" type="submit" value="Recommencer la partie"/>
        </form>
    <?php

    if(isset($_POST['partie']) && $_POST['partie'] == "Commencer la partie")
    {
        echo $_SESSION['mot']=$tabDesMots[$ligneAleatoire];
        $_SESSION['img'] = -1;
        $a = 0;
        $trouve=false;
        $_GET['lettre']='';
        for($i = 0; $i < strlen($_SESSION['mot'])-1; $i++)
        {
            $_SESSION['recherche'][$i]="_&nbsp;";
            $a++;
        }
        $_SESSION['nb_lettre'] = $a;
    }
    if(isset($_SESSION['mot']))
    {
    if(isset($_GET['lettre']))
    {
        $_SESSION['lettres'] = $_GET['lettre'];
        for($j = 0; $j < count($_SESSION['recherche']); $j++)
        {
            if(substr($_SESSION['mot'], $j, 1) == $_GET['lettre'])
            {
                $_SESSION['recherche'][$j] = $_GET['lettre'];
                $trouve = true;
                $_SESSION['nb_lettre']--;
            }
        }
    }
    function win($gg='Tu as gagné !! Félicitation !!'){
    ?>
        <script>
            alert('<?php echo $gg ?>');
        </script>
    <?php
    }
    for($i = 0; $i < count($_SESSION['recherche']); $i++)
    {
            echo $_SESSION['recherche'][$i]." ";
    }
    echo "<br/><br />";
    if($_SESSION['nb_lettre'] == 0)
    {
        win();
    }
    else
    {
        for($i = 0; $i <strlen($alphabet); $i++)
        {
            if (strpos($_SESSION['lettres'],substr($alphabet,$i,1)) === false)
            {
                echo "&nbsp;&nbsp;<a href='index.php?lettre=".substr($alphabet,$i,1)."&jouer=oui'>&nbsp;".substr($alphabet,$i,1)."</a> ";
            }
            else
            {
                echo substr($alphabet,$i,1)." ";
            }
        }
    }
    if(!$trouve)
    {
        $_SESSION['img']++;
    }

    function perdu($dommage='Tu as perdu !! AHAHA!!'){
    ?>
        <script>
            alert('<?php echo $dommage ?>');
        </script>
        <?php
    }

        echo '<br/>';
        echo '<div class="img_red"><img src="img0.jpg" width="700"></div>';
        $trouve='';
        if ($_SESSION['img']==7)
        {
            echo '<a href="index.php?reset=true">Recommencer</a>';
            perdu();
            session_unset();
        }
    }
    }
    ?>
    </body>
    </html>
