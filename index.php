<?php
  $db_service  = getenv('DATABASE_SERVICE_NAME');
  $db_name     = getenv('DATABASE_NAME');
  $db_username = getenv('DATABASE_USER');
  $db_password = getenv('DATABASE_PASSWORD');
  $message     = getenv('HELLO_MESSAGE');
?>

<h1><?php echo "$message" ?></h1>

service = <?php echo "$db_service" ?><br/>
name = <?php echo "$db_name" ?><br/>
username = <?php echo "$db_username" ?><br/>
password = <?php echo "$db_password" ?><br/>

