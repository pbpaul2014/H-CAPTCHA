function verifyToken(string $token, string $ip): array {
  $payload = http_build_query([
    "secret" => "ES_58fd..",
    "response" => $token,
    "remoteip" => $ip,
    "sitekey" => "58121974-557a-4d76-a3a4-a53e799e7dda",
  ]);
  $ctx = stream_context_create([
    "http" => [
      "method" => "POST",
      "header" => "Content-type: application/x-www-form-urlencoded\r\n",
      "content" => $payload,
      "timeout" => 5,
    ],
  ]);
  $raw = file_get_contents(
    "https://api.hcaptcha.com/siteverify",
    false,
    $ctx
  );
  $j = json_decode($raw, true);
  if (!empty($j["success"])) {
    return [true, []];
  }
  return [false, $j["error-codes"] ?? []];
}
