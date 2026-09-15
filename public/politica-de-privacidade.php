<?php

declare(strict_types=1);

$isHome = false;
$includeAnalytics = false;
$pageTitle = 'Política de Privacidade | Driver Finances';
$pageDescription = 'Política de privacidade do Driver Finances: quais dados coletamos, por que coletamos e como você pode solicitar acesso ou exclusão.';
$canonicalPath = '/politica-de-privacidade.php';
$ogTitle = 'Política de Privacidade | Driver Finances';
$ogDescription = 'Política de privacidade do Driver Finances: quais dados coletamos, por que coletamos e como você pode solicitar acesso ou exclusão.';

require dirname(__DIR__) . '/includes/header.php';
require_once dirname(__DIR__) . '/includes/config.php';
?>
    <main class="legal">
        <div class="container legal-content">
            <h1>Política de Privacidade</h1>
            <p class="legal-date">Última atualização: 17 de agosto de 2026</p>

            <p>Esta política explica quais dados o Driver Finances coleta, para que eles são usados e quais são os seus
                direitos. Ela vale tanto para o site <strong>app.tecnofenx.com.br</strong> quanto para o aplicativo
                Driver Finances, disponível para Android.</p>

            <h2>1. Quem é o responsável</h2>
            <p>O Driver Finances é desenvolvido e mantido por Allan Fenx, responsável pelo tratamento dos dados
                descritos nesta política. O contato está na seção 10.</p>

            <h2>2. Quais dados coletamos</h2>

            <h3>2.1. No site</h3>
            <ul>
                <li><strong>Endereço de e-mail do Gmail</strong>, quando você preenche o formulário para participar do
                    teste do aplicativo. Aceitamos apenas endereços @gmail.com porque o programa de testes do Google
                    Play exige uma conta Google.</li>
                <li><strong>Dados de navegação</strong> coletados pelo Google Analytics, como páginas visitadas, tempo
                    de permanência, origem do acesso, tipo de dispositivo e localização aproximada por cidade. Esses
                    dados são estatísticos e não identificam você pessoalmente.</li>
            </ul>

            <h3>2.2. No aplicativo</h3>
            <ul>
                <li><strong>Dados da sua conta Google</strong>, usados para identificar você e vincular suas
                    informações.</li>
                <li><strong>Informações financeiras que você registra</strong>, como valores de corridas, despesas,
                    abastecimentos, manutenções e metas. Esses dados são inseridos por você e existem apenas para gerar
                    seus próprios relatórios.</li>
            </ul>

            <p>Não coletamos dados de localização em tempo real, não acessamos sua agenda de contatos e não temos
                qualquer integração que leia automaticamente seus ganhos na Uber, na 99 ou em outros aplicativos.</p>

            <h2>3. Para que usamos esses dados</h2>
            <ul>
                <li>Adicionar seu e-mail à lista de testadores do aplicativo na Google Play.</li>
                <li>Permitir que você acesse sua conta e recupere seu histórico ao trocar de aparelho.</li>
                <li>Calcular e exibir seus relatórios de ganhos, despesas e lucro.</li>
                <li>Entender como o site é usado e melhorar o produto.</li>
            </ul>
            <p>Não vendemos seus dados. Não enviamos suas informações financeiras para anunciantes e não usamos o que
                você registra no app para direcionar publicidade.</p>

            <h2>4. Base legal</h2>
            <p>Tratamos seus dados com base no seu <strong>consentimento</strong>, manifestado quando você preenche o
                formulário ou cria sua conta no aplicativo, e na <strong>execução do serviço</strong> que você solicitou
                ao instalar e usar o Driver Finances, conforme a Lei Geral de Proteção de Dados (Lei 13.709/2018).</p>

            <h2>5. Com quem compartilhamos</h2>
            <p>Compartilhamos dados apenas com os serviços necessários para o funcionamento do produto:</p>
            <ul>
                <li><strong>Google</strong>, para gerenciar a lista de testadores, distribuir o aplicativo pela Google
                    Play e coletar estatísticas de uso do site pelo Google Analytics.</li>
                <li><strong>Serviço de hospedagem em nuvem</strong>, onde ficam armazenados o site e o banco de dados do
                    aplicativo.</li>
            </ul>
            <p>Fora essas hipóteses, seus dados só serão fornecidos a terceiros mediante ordem judicial ou exigência
                legal.</p>

            <h2>6. Onde os dados ficam armazenados</h2>
            <p>As informações que você registra no aplicativo ficam guardadas em um banco de dados na nuvem, associado à
                sua conta. É isso que permite recuperar todo o seu histórico ao entrar em um novo aparelho. O acesso ao
                banco é restrito e protegido por credenciais, e a comunicação entre o aplicativo e o servidor é
                criptografada.</p>
            <p>Nenhum sistema é completamente imune a incidentes. Caso ocorra um vazamento que represente risco
                relevante a você, comunicaremos os usuários afetados e a Autoridade Nacional de Proteção de Dados, como
                determina a legislação.</p>

            <h2>7. Por quanto tempo guardamos</h2>
            <p>Mantemos seus dados enquanto sua conta estiver ativa. Se você pedir a exclusão, removemos suas
                informações do banco de dados e seu e-mail da lista de testadores, salvo registros que precisemos
                conservar por obrigação legal.</p>

            <h2>8. Seus direitos</h2>
            <p>A LGPD garante a você o direito de:</p>
            <ul>
                <li>confirmar se tratamos seus dados e acessar o que temos;</li>
                <li>corrigir informações incompletas ou desatualizadas;</li>
                <li>solicitar a exclusão dos seus dados;</li>
                <li>revogar o consentimento a qualquer momento;</li>
                <li>saber com quais entidades compartilhamos suas informações.</li>
            </ul>
            <p>Para exercer qualquer um desses direitos, use o contato da seção 10. Respondemos em até 15 dias.</p>

            <h2>9. Cookies e crianças</h2>
            <p>O site usa cookies do Google Analytics para medir audiência. Você pode bloqueá-los nas configurações do
                seu navegador sem prejudicar o uso da página.</p>
            <p>O Driver Finances não se destina a menores de 18 anos e não coletamos intencionalmente dados de
                crianças e adolescentes.</p>

            <h2>10. Contato</h2>
            <p>Dúvidas sobre esta política ou pedidos relacionados aos seus dados podem ser enviados pela nossa página
                no Facebook:
                <a href="<?= e(FACEBOOK_URL) ?>" target="_blank"
                    rel="noopener noreferrer">facebook.com/driverfinances</a>.
            </p>

            <h2>11. Alterações desta política</h2>
            <p>Podemos atualizar este documento para refletir mudanças no aplicativo ou na legislação. A data no topo da
                página sempre indica a versão vigente. Mudanças relevantes serão comunicadas pelos nossos canais.</p>
        </div>
    </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
