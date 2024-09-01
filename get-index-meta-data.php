<?php
  $ch = curl_init();

  // Get a valid TOKEN
  $headers = array(
    'X-aws-ec2-metadata-token-ttl-seconds: 60'
  );
  $url = "http://169.254.169.254/latest/api/token";

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  $token = curl_exec($ch);

  // Start of HTML content
  echo "<!DOCTYPE html>";
  echo "<html>";
  echo "<head>";
  echo "<style>";
  echo "body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f5f5f5; }";
  echo "table { border-collapse: collapse; }";
  echo "th, td { padding: 15px; text-align: center; font-size: 1.5em; font-weight: bold; }";
  echo "th { background-color: #4CAF50; color: white; }";
  echo "</style>";
  echo "</head>";
  echo "<body>";

  echo "<table border='1'>";
  echo "<tr><th>Meta-Data</th><th>Value</th></tr>";

  // Get the instance ID from meta-data and print to the screen
  $headers = array(
    'X-aws-ec2-metadata-token: ' . $token
  );
  $url = "http://169.254.169.254/latest/meta-data/";

  curl_setopt($ch, CURLOPT_URL, $url . 'instance-id');
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  $result = curl_exec($ch);

  echo "<tr><td>InstanceId</td><td><i>" . $result . "</i></td></tr>";

  // Availability Zone
  curl_setopt($ch, CURLOPT_URL, $url . 'placement/availability-zone');
  $result2 = curl_exec($ch);

  echo "<tr><td>Availability Zone</td><td><i>" . $result2 . "</i></td></tr>";

  echo "</table>";

  echo "</body>";
  echo "</html>";

  curl_close($ch);
?>
