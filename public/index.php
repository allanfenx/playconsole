<?php

declare(strict_types=1);

$isHome = true;
$includeAnalytics = true;
$pageTitle = 'Controle Financeiro para Motoristas de Aplicativo | Driver Finances';
$pageDescription = 'Controle financeiro para motoristas de aplicativo: ganhos, despesas, combustível e lucro em um app grátis. Baixe o Driver Finances na Google Play.';
$canonicalPath = '/';
$ogTitle = 'Controle Financeiro para Motoristas de Aplicativo | Driver Finances';
$ogDescription = 'App de controle financeiro para motoristas de aplicativo. Registre ganhos, despesas e veja seu lucro real com o Driver Finances.';

require dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/config.php';
?>
    <main>
        <section class="hero" aria-labelledby="hero-title">
            <div class="container hero-grid">
                <div class="hero-content">
                    <span class="badge">Grátis na Google Play</span>
                    <h1 id="hero-title">Driver Finances: controle financeiro para motoristas de aplicativo</h1>
                    <p class="hero-text">
                        O Driver Finances é um app de controle financeiro para motoristas de aplicativo — Uber, 99 e
                        similares. Registre corridas, acompanhe combustível, despesas e manutenção, e veja em tempo
                        real quanto você lucra na estrada.
                    </p>

                    <form action="#" class="form-input" id="formEmail">
                        <label class="sr-only" for="emailInput">Seu e-mail</label>
                        <input type="email" id="emailInput" name="email" placeholder="seuemail@gmail.com"
                            class="input-email" autocomplete="email" inputmode="email" required
                            pattern="^[^\s@]+@gmail\.com$"
                            title="Use um endereço @gmail.com">
                        <button type="submit" class="btn btn-primary" id="button">Quero instalar</button>
                    </form>

                    <div class="hero-actions" id="googlePlay">
                        <p class="tester-help" id="testerHelp">Se aparecer “App not available”, o Google Play ainda não
                            viu o grupo. Confirme o mesmo Gmail da Play Store, espere um ou dois minutos e toque de
                            novo em “Aceitar participar do teste”.</p>
                        <a class="btn btn-primary btn-lg" id="testerAcceptBtn"
                            href="<?= e(TESTER_URL) ?>" target="_blank"
                            rel="noopener noreferrer">
                            Aceitar participar do teste
                        </a>
                        <a class="btn btn-primary btn-lg store-btn" id="heroDownloadBtn"
                            href="<?= e(PLAY_STORE_URL) ?>"
                            target="_blank" rel="noopener noreferrer">
                            <svg class="store-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="currentColor"
                                    d="M3.609 1.814L13.792 12 3.61 22.186a1.005 1.005 0 0 1-.601-.92V2.734a1.005 1.005 0 0 1 .6-.92zm10.89 10.893l2.302 2.302-10.937 6.333 8.635-8.635zm3.199-3.198l2.807 1.626a1.002 1.002 0 0 1 0 1.738l-2.808 1.626L15.206 12l2.492-2.491zM5.864 2.658L16.802 8.99l-2.303 2.303-8.635-8.635z" />
                            </svg>
                            Disponível no Google Play
                        </a>
                    </div>
                    <ul class="hero-stats">
                        <li>
                            <strong>Simples</strong>
                            <span>Interface direta ao ponto</span>
                        </li>
                        <li>
                            <strong>Completo</strong>
                            <span>Ganhos, gastos e lucro</span>
                        </li>
                        <li>
                            <strong>Seu</strong>
                            <span>Dados na nuvem</span>
                        </li>
                    </ul>
                </div>

                <div class="hero-visual" aria-hidden="true">
                    <div class="phone">
                        <div class="phone-notch"></div>
                        <div class="phone-screen">
                            <div class="mock-header">Resumo do mês</div>
                            <div class="mock-card mock-income">
                                <span>Ganhos</span>
                                <strong>R$ 4.820,00</strong>
                            </div>
                            <div class="mock-card mock-expense">
                                <span>Despesas</span>
                                <strong>R$ 1.240,00</strong>
                            </div>
                            <div class="mock-card mock-profit">
                                <span>Lucro líquido</span>
                                <strong>R$ 3.580,00</strong>
                            </div>
                            <div class="mock-chart">
                                <div class="bar" style="height: 45%"></div>
                                <div class="bar" style="height: 70%"></div>
                                <div class="bar" style="height: 55%"></div>
                                <div class="bar" style="height: 85%"></div>
                                <div class="bar" style="height: 60%"></div>
                                <div class="bar" style="height: 90%"></div>
                                <div class="bar" style="height: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="features" id="recursos" aria-labelledby="features-title">
            <div class="container">
                <div class="section-head">
                    <h2 id="features-title">Recursos do Driver Finances para motoristas de app</h2>
                    <p>Organize ganhos, despesas, combustível e lucro com uma ferramenta simples para quem vive na
                        estrada.</p>
                </div>
                <div class="features-grid">
                    <article class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Controle de ganhos do motorista</h3>
                        <p>Registre corridas, pedidos e receitas por dia, semana ou mês para ver com clareza quanto
                            entrou no bolso.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon">⛽</div>
                        <h3>Despesas do veículo e da rotina</h3>
                        <p>Acompanhe combustível, manutenção, pedágios e outros custos que reduzem seu lucro real como
                            motorista.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon">📈</div>
                        <h3>Relatórios visuais de lucro</h3>
                        <p>Gráficos e resumos mostram se você está no azul, onde pode economizar e como melhorar suas
                            finanças.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon">🎯</div>
                        <h3>Metas financeiras</h3>
                        <p>Defina objetivos de faturamento e acompanhe seu progresso ao longo do tempo.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon">🔒</div>
                        <h3>Seus dados seguros na nuvem</h3>
                        <p>Seu histórico financeiro fica salvo na nuvem e acompanha você em qualquer aparelho. Trocou de
                            celular? Seus números continuam lá.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h3>Rápido e prático</h3>
                        <p>Registre uma corrida ou despesa em segundos, ideal para quem está sempre em movimento.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="how-it-works" id="como-funciona" aria-labelledby="steps-title">
            <div class="container">
                <div class="section-head">
                    <h2 id="steps-title">Como funciona</h2>
                    <p>Três passos para entender de verdade quanto você ganha.</p>
                </div>
                <ol class="steps">
                    <li class="step">
                        <span class="step-number">1</span>
                        <div>
                            <h3>Baixe o app</h3>
                            <p>Cadastre seu Gmail, entre na lista de testadores e instale gratuitamente pela Google
                                Play. <a href="#como-instalar">Veja o passo a passo</a>.</p>
                        </div>
                    </li>
                    <li class="step">
                        <span class="step-number">2</span>
                        <div>
                            <h3>Registre entradas e saídas</h3>
                            <p>Anote ganhos das corridas e despesas do dia a dia enquanto trabalha.</p>
                        </div>
                    </li>
                    <li class="step">
                        <span class="step-number">3</span>
                        <div>
                            <h3>Veja seu lucro real</h3>
                            <p>Consulte relatórios e descubra quanto sobra depois de todos os custos.</p>
                        </div>
                    </li>
                </ol>
            </div>
        </section>

        <section class="install" id="como-instalar" aria-labelledby="install-title">
            <div class="container">
                <div class="section-head">
                    <h2 id="install-title">Como instalar o Driver Finances</h2>
                    <p>O app está em fase de teste fechado na Google Play, por isso ele não aparece na busca da loja.
                        Sua conta precisa entrar na lista de testadores. Depois de aceitar, volte a esta página: o
                        botão de baixar aparece aqui.</p>
                </div>
                <ol class="steps install-steps">
                    <li class="step">
                        <span class="step-number">1</span>
                        <div>
                            <h3>Separe uma conta Gmail</h3>
                            <p>O programa de testes do Google só funciona com conta Google. Use o mesmo Gmail que já
                                está conectado na Play Store do seu celular.</p>
                        </div>
                    </li>
                    <li class="step">
                        <span class="step-number">2</span>
                        <div>
                            <h3>Cadastre seu e-mail no site</h3>
                            <p>Digite seu Gmail no campo no topo desta página e toque em “Quero instalar”. Uma nova aba
                                abre com o convite de testador.</p>
                        </div>
                    </li>
                    <li class="step">
                        <span class="step-number">3</span>
                        <div>
                            <h3>Aceite o convite na nova aba</h3>
                            <p>Na aba que abriu, toque em “Tornar-se um testador”. É esse passo que libera o app para a
                                sua conta.</p>
                        </div>
                    </li>
                    <li class="step">
                        <span class="step-number">4</span>
                        <div>
                            <h3>Volte à página inicial e baixe</h3>
                            <p>Depois de aceitar, volte para esta página. O botão de baixar o app aparece no lugar do
                                formulário. Toque nele e instale na Google Play.</p>
                        </div>
                    </li>
                </ol>

                <div class="install-help">
                    <h3>Se o app não aparecer para instalar</h3>
                    <dl>
                        <div>
                            <dt>Aparece “item não encontrado”</dt>
                            <dd>Quase sempre é conta trocada. Abra a Play Store, toque na sua foto de perfil e confirme
                                que está no mesmo Gmail que você cadastrou.</dd>
                        </div>
                        <div>
                            <dt>Aparece “App not available”</dt>
                            <dd>O e-mail já está no grupo, mas o Google Play atrasa para liberar. Espere um ou dois
                                minutos, recarregue a aba do convite ou toque de novo em “Aceitar participar do teste”.
                                Use o mesmo Gmail da Play Store do celular.</dd>
                        </div>
                        <div>
                            <dt>A conta está certa e mesmo assim não libera</dt>
                            <dd>É a propagação do Google. Espere cerca de dez minutos, feche a Play Store e tente de
                                novo.</dd>
                        </div>
                        <div>
                            <dt>Meu e-mail foi recusado no cadastro</dt>
                            <dd>Aceitamos apenas endereços @gmail.com, porque é uma exigência do sistema de testes do
                                Google.</dd>
                        </div>
                        <div>
                            <dt>Já me cadastrei antes</dt>
                            <dd>Pode ir direto para o passo 3 e aceitar o convite de testador.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <section class="faq" id="faq" aria-labelledby="faq-title">
            <div class="container">
                <div class="section-head">
                    <h2 id="faq-title">Perguntas frequentes sobre controle financeiro para motoristas</h2>
                </div>
                <div class="features-grid">
                    <article class="feature-card">
                        <h3>Qual app de controle financeiro para motoristas de aplicativo?</h3>
                        <p>O Driver Finances foi feito para quem dirige por aplicativo: centraliza ganhos, despesas,
                            combustível e lucro em um só lugar, com relatórios claros.</p>
                    </article>
                    <article class="feature-card">
                        <h3>Para que serve o Driver Finances?</h3>
                        <p>Ele ajuda motoristas de aplicativo a controlar ganhos, despesas, combustível e lucro em um
                            só lugar.</p>
                    </article>
                    <article class="feature-card">
                        <h3>Funciona para Uber, 99 e outros apps de corrida?</h3>
                        <p>Sim. Você registra manualmente o que ganha em cada plataforma e todas as despesas do carro e
                            do dia a dia — o lucro é calculado independente do app que você usa.</p>
                    </article>
                    <article class="feature-card">
                        <h3>Se eu trocar de celular, perco meus dados?</h3>
                        <p>Não. Seus lançamentos ficam guardados em um banco de dados na nuvem, ligado à sua conta.
                            Basta entrar no novo aparelho para ter todo o histórico de volta.</p>
                    </article>
                    <article class="feature-card">
                        <h3>É fácil de usar?</h3>
                        <p>Sim. A interface foi pensada para registrar corridas e despesas rapidamente, mesmo no dia a
                            dia em movimento.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="cta" aria-labelledby="cta-title">
            <div class="container cta-box">
                <h2 id="cta-title">Pronto para assumir o controle?</h2>
                <p>Baixe o Driver Finances agora e transforme a forma como você enxerga seu trabalho na estrada.</p>
                <a class="btn btn-light btn-lg store-btn" id="ctaDownloadBtn"
                    href="<?= e(PLAY_STORE_URL) ?>" target="_blank"
                    rel="noopener noreferrer">
                    <svg class="store-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor"
                            d="M3.609 1.814L13.792 12 3.61 22.186a1.005 1.005 0 0 1-.601-.92V2.734a1.005 1.005 0 0 1 .6-.92zm10.89 10.893l2.302 2.302-10.937 6.333 8.635-8.635zm3.199-3.198l2.807 1.626a1.002 1.002 0 0 1 0 1.738l-2.808 1.626L15.206 12l2.492-2.491zM5.864 2.658L16.802 8.99l-2.303 2.303-8.635-8.635z" />
                    </svg>
                    Baixar na Google Play
                </a>
            </div>
        </section>
    </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
