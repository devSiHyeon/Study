<?php
  session_start();
  $_SESSION['user_id'] = '';
  $_SESSION['idx'] = '';
  $res['success']     = true;
  exit(json_encode($res));
?>
