<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

$isHome = $isHome ?? false;
$year = date('Y');
$privacyHref = $isHome ? '/politica-de-privacidade.php' : '';
?>
    <footer class="footer">
        <div class="container footer-inner">
            <p>&copy; <?= e($year) ?> Driver Finances. Desenvolvido por Allan Fenx.</p>
            <?php if ($isHome): ?>
            <a href="<?= e($privacyHref) ?>">Política de Privacidade</a>
            <?php endif; ?>
            <a class="footer-social" href="<?= e(FACEBOOK_URL) ?>" target="_blank"
                rel="noopener noreferrer">
                <svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor"
                        d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z" />
                </svg>
                Fale com a gente no Facebook
            </a>
        </div>
    </footer>
    <?php if ($isHome): ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "SoftwareApplication",
            "name": "Driver Finances",
            "alternateName": "Controle Financeiro para Motoristas de Aplicativo",
            "applicationCategory": "FinanceApplication",
            "operatingSystem": "Android",
            "inLanguage": "pt-BR",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "BRL"
            },
            "description": "App de controle financeiro para motoristas de aplicativo: ganhos, despesas, combustível e lucro.",
            "url": <?= json_encode(site_url('/'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
            "installUrl": "https://play.google.com/store/apps/details?id=com.allanfenx.finance",
            "downloadUrl": "https://play.google.com/store/apps/details?id=com.allanfenx.finance",
            "screenshot": <?= json_encode(site_url('/og-image.jpg'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
            "author": {
                "@type": "Person",
                "name": "Allan Fenx"
            }
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "Driver Finances",
            "url": <?= json_encode(site_url('/'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
            "inLanguage": "pt-BR",
            "description": "Controle financeiro para motoristas de aplicativo: ganhos, despesas, combustível e lucro.",
            "publisher": {
                "@type": "Organization",
                "name": "Driver Finances",
                "url": <?= json_encode(site_url('/'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
                "sameAs": [
                    "https://www.facebook.com/driverfinances"
                ]
            }
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "HowTo",
            "name": "Como instalar o Driver Finances",
            "description": "O Driver Finances está em teste fechado na Google Play. Veja o passo a passo para entrar na lista de testadores e instalar o app de controle financeiro para motoristas de aplicativo.",
            "inLanguage": "pt-BR",
            "totalTime": "PT2M",
            "estimatedCost": {
                "@type": "MonetaryAmount",
                "currency": "BRL",
                "value": "0"
            },
            "supply": [
                {
                    "@type": "HowToSupply",
                    "name": "Uma conta Gmail"
                },
                {
                    "@type": "HowToSupply",
                    "name": "Um celular Android com a Google Play Store"
                }
            ],
            "step": [
                {
                    "@type": "HowToStep",
                    "position": 1,
                    "name": "Separe uma conta Gmail",
                    "text": "O programa de testes do Google só funciona com conta Google. Use o mesmo Gmail que já está conectado na Play Store do seu celular.",
                    "url": <?= json_encode(site_url('/#como-instalar'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
                },
                {
                    "@type": "HowToStep",
                    "position": 2,
                    "name": "Cadastre seu e-mail no site",
                    "text": "Digite seu Gmail no campo no topo da página e toque em Quero instalar. Uma nova aba abre com o convite de testador.",
                    "url": <?= json_encode(site_url('/#como-instalar'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
                },
                {
                    "@type": "HowToStep",
                    "position": 3,
                    "name": "Aceite o convite na nova aba",
                    "text": "Na aba que abriu, toque em Tornar-se um testador. É esse passo que libera o app para a sua conta.",
                    "url": "https://play.google.com/apps/testing/com.allanfenx.finance"
                },
                {
                    "@type": "HowToStep",
                    "position": 4,
                    "name": "Volte à página inicial e baixe",
                    "text": "Depois de aceitar, volte para a página inicial. O botão de baixar o app aparece no lugar do formulário. Toque nele e instale na Google Play.",
                    "url": <?= json_encode(site_url('/#como-instalar'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
                }
            ]
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "Qual app de controle financeiro para motoristas de aplicativo?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "O Driver Finances foi feito para quem dirige por aplicativo: centraliza ganhos, despesas, combustível e lucro em um só lugar, com relatórios claros."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Para que serve o Driver Finances?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Ele ajuda motoristas de aplicativo a controlar ganhos, despesas, combustível e lucro em um só lugar."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Funciona para Uber, 99 e outros apps de corrida?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Sim. Você registra manualmente o que ganha em cada plataforma e todas as despesas do carro e do dia a dia — o lucro é calculado independente do app que você usa."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Se eu trocar de celular, perco meus dados?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Não. Seus lançamentos ficam guardados em um banco de dados na nuvem, ligado à sua conta. Basta entrar no novo aparelho para ter todo o histórico de volta."
                    }
                },
                {
                    "@type": "Question",
                    "name": "É fácil de usar?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Sim. A interface foi pensada para registrar corridas e despesas rapidamente, mesmo no dia a dia em movimento."
                    }
                }
            ]
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/src/app.js?v=20260919c"></script>
    <?php endif; ?>
</body>

</html>
