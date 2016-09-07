<?php
  $db_service  = getenv('DATABASE_SERVICE_NAME');
  $db_name     = getenv('DATABASE_NAME');
  $db_username = getenv('DATABASE_USER');
  $db_password = getenv('DATABASE_PASSWORD');
  $db_host     = getenv(strtoupper($db_service)."_SERVICE_HOST");
  $db_port     = getenv(strtoupper($db_service)."_SERVICE_PORT");
  $message     = getenv('HELLO_MESSAGE');
?>

<h1><?php echo "$message" ?></h1>

<table border="1">
<tr>
  <td>OpenShift pod</td>
  <td><?php echo gethostname(); ?></td>
</tr>
<tr>
  <td>OpenShift DB service</td>
  <td><?php echo "$db_service"; ?></td>
</tr>
<tr>
  <td>DB name</td>
  <td><?php echo "$db_name"; ?></td>
</tr>
<tr>
  <td>DB username</td>
  <td><?php echo "$db_username"; ?></td>
</tr>
<tr>
  <td>DB password</td>
  <td><?php echo "$db_password"; ?></td>
</tr>
<tr>
  <td>DB host</td>
  <td><?php echo "$db_host"; ?></td>
</tr>
<tr>
  <td>DB port</td>
  <td><?php echo "$db_port"; ?></td>
</tr>
</table>

<br/>

<b>
<?php
  $db = mysqli_connect("$db_host:$db_port", $db_username, $db_password);

  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }
  echo "Connected to MySQL host $db_host:$db_port<br/>";

  if (!mysqli_select_db($db , $db_name)) {
    die("Database $db_name not accessible!<br/>");
  }
  echo "Database '$db_name' selected<br/>";

  // Create tables if not there.
  $val = mysqli_query($db, 'select 1 from `Counter` LIMIT 1');
  if($val === FALSE) {
    echo "Creating table Counter<br/>";

    $sql = "CREATE TABLE Counter (
id INT(6) UNSIGNED PRIMARY KEY,
count INT(6))";
    $result = mysqli_query($db, $sql);
    if (!$result) {
      die("Error: " . $sql . "<br>" . mysqli_error($db));
    }

    $sql = "INSERT INTO Counter (id, count) VALUES (1, 0)";
    $result = mysqli_query($db, $sql);
    if (!$result) {
      die("Error: " . $sql . "<br>" . mysqli_error($db));
    }
  } else {
    echo "Table Counter exists<br/>";
  } 

  // Increment counter value
  $sql = "
    UPDATE Counter
    SET count = count + 1
    WHERE id = 1";
  $result = mysqli_query($db, $sql);
  if ($result) {
    echo "Incrementing counter";
  }
  
  // Display counter value
  $sql = "SELECT * FROM Counter";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      echo "<h2>Pocitadlo: " . $row['count'] . "</h2>";
    }
  }
 
  mysqli_close($db);
?>
</b>

