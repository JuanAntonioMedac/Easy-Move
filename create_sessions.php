<?php
$ch = mysqli_init();
mysqli_real_connect($ch, 'localhost', 'root', '', 'easymove') or die('Connection failed');

$sql = "CREATE TABLE IF NOT EXISTS sessions (
  id varchar(255) NOT NULL,
  user_id bigint unsigned NULL,
  ip_address varchar(45) NULL,
  user_agent text NULL,
  payload longtext NOT NULL,
  last_activity int NOT NULL,
  PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";

mysqli_query($ch, $sql) or die(mysqli_error($ch));
echo 'Sessions table created/verified successfully';
mysqli_close($ch);
?>
