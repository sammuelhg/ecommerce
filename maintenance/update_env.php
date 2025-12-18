<?php
$path = '.env';
$content = file_get_contents($path);

$replacements = [
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'smtp.hostinger.com',
    'MAIL_PORT' => '465',
    'MAIL_USERNAME' => 'contato@losfit.com.br',
    'MAIL_PASSWORD' => '"!Sa002125"',
    'MAIL_ENCRYPTION' => 'ssl',
    'MAIL_FROM_ADDRESS' => '"contato@losfit.com.br"',
];

foreach ($replacements as $key => $value) {
    if (preg_match("/^{$key}=.*/m", $content)) {
        $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
    } else {
        $content .= "\n{$key}={$value}";
    }
}

file_put_contents($path, $content);
echo "ENV updated successfully.";
