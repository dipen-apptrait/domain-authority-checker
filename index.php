<?php
// Moz API credentials
$moz_api_key = 'YOUR_MOZ_API_KEY';
$moz_api_secret = 'YOUR_MOZ_API_SECRET';

// Function to get domain authority using Moz API
function get_domain_authority($domain) {
  $url = 'https://lsapi.seomoz.com/v2/metrics/url';
  $params = array(
    'cols' => 'domain_authority',
    'filters' => array(array('operator' => 'EQ', 'field' => 'q', 'values' => array($domain)))
  );
  $headers = array(
    'Authorization: Bearer ' . $moz_api_key,
    'Content-Type: application/json'
  );

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($response, true);
  return $data['results'][0]['domain_authority'];
}

// HTML form to enter domain name
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <label for="domain">Enter domain name:</label>
  <input type="text" id="domain" name="domain" />
  <input type="submit" value="Get Domain Authority" />
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $domain = $_POST['domain'];
  $da = get_domain_authority($domain);
  echo "<p>Domain Authority of $domain: $da</p>";
}
?>
