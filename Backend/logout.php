<?php

  // Created by Srdjan Grbic

  session_start();
  session_destroy();

  header('Location: index.php');

?>
