<?php

declare(strict_types=1);

require dirname(__DIR__) . '/includes/config.php';

header('Content-Type: application/xml; charset=utf-8');

$home = site_url('/');
$privacy = site_url('/politica-de-privacidade.php');
$lastmod = '2026-08-17';

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= htmlspecialchars($home, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></loc>
        <lastmod><?= $lastmod ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= htmlspecialchars($privacy, ENT_XML1 | ENT_QUOTES, 'UTF-8') ?></loc>
        <lastmod><?= $lastmod ?></lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>
</urlset>
