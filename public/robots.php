<?php

declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';

header('Content-Type: text/plain; charset=utf-8');

echo "User-agent: *\n";
echo "Allow: /\n\n";
echo 'Sitemap: ' . site_url('/sitemap.xml') . "\n";
echo 'Sitemap: ' . site_url('/sitemap.php') . "\n";
