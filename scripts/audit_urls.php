<?php

use Illuminate\Support\Facades\Http;

require __DIR__ . '/../vendor/autoload.php';

$mdFile = __DIR__ . '/../docs/MAPEAMENTO_URLS.md';
$baseUrl = 'http://127.0.0.1:8000';
$prodDomain = 'https://losfit.com.br';
$cookieFile = __DIR__ . '/cookie.txt';

// Cleanup old cookie
if (file_exists($cookieFile)) @unlink($cookieFile);

echo "Reading $mdFile...\n";

if (!file_exists($mdFile)) {
    die("File not found: $mdFile\n");
}

// --- 1. LOGIN STEP ---
echo "Attempting to login as sammuelhg@gmail.com...\n";
$agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

// 1.1 GET login page to get CSRF token and cookies
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
$loginPageHtml = curl_exec($ch);
curl_close($ch);

// Extract CSRF Token
$csrfToken = '';
if (preg_match('/name="csrf-token" content="(.*?)"/', $loginPageHtml, $matches)) {
    $csrfToken = $matches[1];
} elseif (preg_match('/name="_token" value="(.*?)"/', $loginPageHtml, $matches)) {
    $csrfToken = $matches[1];
}

if (!$csrfToken) {
    echo "Warning: Could not find CSRF token. Login might fail.\n";
} else {
    echo "CSRF Token found.\n";
}

// 1.2 POST login
$postData = [
    'email' => 'sammuelhg@gmail.com',
    'password' => '!Sa002125',
    '_token' => $csrfToken,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
// Headers for Laravel
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-CSRF-TOKEN: $csrfToken",
    "Referer: $baseUrl/login",
    "Origin: $baseUrl"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);

$loggedIn = false;
// Check if we are redirected to a dashboard-like page or home, NOT login
if ($httpCode == 200 && !str_contains($finalUrl, '/login')) {
    echo "Login Successful! Final URL: $finalUrl\n";
    $loggedIn = true;
} else {
    echo "Login Failed (HTTP $httpCode) ended at $finalUrl.\n";
    // echo "Response snippet: " . substr(strip_tags($response), 0, 200) . "\n";
}

// --- 2. AUDIT LOOP ---

$content = file_get_contents($mdFile);
$lines = explode("\n", $content);
$newLines = [];
$updatedCount = 0;

$ch = curl_init();
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);

// Map of parameter replacements
$replacements = [
    '{id}' => '1',
    '{slug}' => 'exemplo',
    '{campaign}' => '1',
    '{product}' => '1',
    '{category}' => 'suplementos',
    '{parent}' => 'geral',
    '{email}' => 'teste@exemplo.com',
    '{subscriber}' => '1',
    '{lead}' => '1',
    '{provider}' => 'google',
    '{tab?}' => 'general',
    '{pageIdentifier?}' => 'home',
    '{component?}' => 'header',
    '{id?}' => '1',
    '{type}' => 'welcome',
];

foreach ($lines as $line) {
    // Regex matches lines with status icon and URL including ⚫
    if (preg_match('/^\|\s*([🟢🟡🔴🔵⚪⚫])\s*\|\s*`?(' . preg_quote($prodDomain, '/') . ')(.*?)`?\s*\|/u', $line, $matches)) {
        $currentIcon = $matches[1];
        $path = $matches[3];
        
        $path = rtrim($path, '`');

        $testPath = $path;
        foreach ($replacements as $key => $value) {
            $testPath = str_replace($key, $value, $testPath);
        }

        if (str_contains($testPath, '{')) {
             $newLines[] = $line;
             continue;
        }

        $url = $baseUrl . $testPath;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD request
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Increased timeout
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        $newIcon = $currentIcon;
        $statusMsg = "Unknown";
        $isLoginPage = str_contains($effectiveUrl, '/login');

        if ($httpCode >= 200 && $httpCode < 400) {
            if ($loggedIn && $isLoginPage && $path !== '/login' && $path !== '/logout') {
                 // We expected to be authenticated but got sent to login
                 $newIcon = '🔴';
                 $statusMsg = "Auth Lost (Redir to Login)";
            } else {
                $newIcon = '🟢';
                $statusMsg = "OK ($httpCode)";
            }
        } elseif ($httpCode == 404) {
            $newIcon = '⚫'; // New 404 icon
            $statusMsg = "Not Found (404)";
        } elseif ($httpCode >= 500) {
            $newIcon = '🔴';
            $statusMsg = "Server Error ($httpCode)";
        } elseif ($httpCode == 0) {
             $newIcon = '🔴';
             $statusMsg = "Unreachable (0)";
        } else {
             $newIcon = '🔴';
             $statusMsg = "Code $httpCode";
        }

        if ($newIcon !== $currentIcon) {
            echo "$statusMsg: $testPath ($currentIcon -> $newIcon)\n";
            $updatedCount++;
            $line = preg_replace('/^\|\s*[🟢🟡🔴🔵⚪⚫]\s*\|/u', "| $newIcon |", $line);
        } else {
             if ($currentIcon === '🟡' || $currentIcon === '🔴') {
                 // echo "$statusMsg (No Change): $testPath\n";
             }
        }

        $newLines[] = $line;

    } else {
        $newLines[] = $line;
    }
}

curl_close($ch);
if (file_exists($cookieFile)) @unlink($cookieFile);

file_put_contents($mdFile, implode("\n", $newLines));

echo "Audit complete. Updated $updatedCount URLs.\n";
