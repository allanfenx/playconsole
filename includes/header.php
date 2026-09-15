<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

$pageTitle = $pageTitle ?? 'Controle Financeiro para Motoristas de Aplicativo | Driver Finances';
$pageDescription = $pageDescription ?? 'Controle financeiro para motoristas de aplicativo: ganhos, despesas, combustível e lucro em um app grátis. Baixe o Driver Finances na Google Play.';
$canonicalPath = $canonicalPath ?? '/';
$includeAnalytics = $includeAnalytics ?? false;
$isHome = $isHome ?? false;
$ogTitle = $ogTitle ?? $pageTitle;
$ogDescription = $ogDescription ?? 'App de controle financeiro para motoristas de aplicativo. Registre ganhos, despesas e veja seu lucro real com o Driver Finances.';
$canonical = site_url($canonicalPath);
$ogImage = site_url('/og-image.jpg');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="theme-color" content="#0f766e">
    <meta name="robots" content="index,follow">
    <meta property="og:title" content="<?= e($ogTitle) ?>">
    <meta property="og:description" content="<?= e($ogDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Driver Finances">
    <meta property="og:locale" content="pt_BR">
    <meta name="google-site-verification" content="<?= e(GOOGLE_SITE_VERIFICATION) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"
        content="Driver Finances: resumo de ganhos, despesas e lucro do motorista de aplicativo">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?= e($ogTitle) ?>">
    <meta property="twitter:description" content="<?= e($ogDescription) ?>">
    <meta property="twitter:image" content="<?= e($ogImage) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" media="print" onload="this.media='all'"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <noscript>
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    </noscript>
    <?php if ($includeAnalytics): ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e(GA_MEASUREMENT_ID) ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', '<?= e(GA_MEASUREMENT_ID) ?>');
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e(ADS_ID) ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', '<?= e(ADS_ID) ?>');

        gtag('event', 'sign_up', {
            method: 'email'
        });
    </script>
    <?php endif; ?>
</head>

<body>
    <header class="header">
        <nav class="nav container" aria-label="Navegação principal">
            <a href="/" class="logo" aria-label="Driver Finances início">
                <span class="logo-icon" aria-hidden="true">💰</span>
                <span>Driver Finances</span>
            </a>
            <?php if ($isHome): ?>
            <a class="btn btn-sm btn-primary" id="headerDownloadBtn"
                href="<?= e(PLAY_STORE_URL) ?>" target="_blank"
                rel="noopener noreferrer">
                Baixar app
            </a>
            <?php else: ?>
            <a class="btn btn-sm btn-primary" href="/">Voltar ao site</a>
            <?php endif; ?>
        </nav>
    </header>
