<?php
session_start();
if (isset($_SESSION["pseudo"])){
    echo "je me souviens de toi, tu t'appelles ".$_SESSION['pseudo'];
} else {
    echo "je n'ai rien sur toi";
}
?>
