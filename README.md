# Driver Finances — site

Landing page PHP do **Driver Finances**, app de controle financeiro para motoristas de aplicativo (Uber, 99 e similares).

O visitante informa um Gmail, o site inclui esse e-mail no Google Group de testadores e abre o convite da Google Play. Nada é gravado em banco ou arquivo local.

- Produção: [https://app.tecnofenx.com.br](https://app.tecnofenx.com.br)
- Pacote Android: `com.allanfenx.finance`

## O que o site faz

1. Mostra a landing (recursos, instalação, FAQ, política de privacidade).
2. Valida Gmail no HTML e no PHP (`@gmail.com`).
3. Envia `POST /google.php` com `{ "email": "..." }`.
4. A service account, impersonando o admin do Workspace, adiciona o e-mail ao grupo `GOOGLE_WORKSPACE_GROUP`.
5. O navegador abre a página de testador da Play Store.

Respostas da API:

| HTTP | Significado |
| --- | --- |
| `201` | E-mail incluído no Google Group |
| `409` | Já era membro do grupo (o frontend trata como sucesso) |
| `400` | E-mail inválido ou não é Gmail |
| `405` | Método diferente de POST |
| `502` | Google recusou (permissão, grupo, chave) |

## Requisitos

- PHP 8.1 ou superior (`8.5` no asdf local e na Locaweb)
- Extensão OpenSSL (assinatura JWT)
- `allow_url_fopen` ligado (chamadas HTTPS à Google)
- Conta Google Workspace, grupo de testadores e service account com **delegação em todo o domínio**

Escopo da API:

```
https://www.googleapis.com/auth/admin.directory.group.member
```

Na Play Console, o teste fechado precisa estar ligado a esse Google Group.

## Estrutura

```
.
├── .env                          # segredos (não vai para o Git)
├── .env.example
├── credentials/
│   └── service-account.json      # chave da Google (não vai para o Git)
├── includes/
│   ├── config.php                # .env, URLs, constantes
│   ├── google_play.php           # JWT + Admin SDK (membros do grupo)
│   ├── header.php
│   └── footer.php
├── public/                       # document root (public_html na Locaweb)
│   ├── index.php
│   ├── google.php
│   ├── politica-de-privacidade.php
│   ├── robots.txt
│   ├── sitemap.xml
│   ├── sitemap.php
│   ├── styles.css
│   ├── favicon.svg
│   ├── og-image.jpg
│   ├── .htaccess
│   └── src/app.js
└── storage/                      # não usado para e-mails
```

Na Locaweb o nginx responde 404 se o arquivo não existir. Por isso o formulário chama `/google.php`, e `robots.txt` / `sitemap.xml` são arquivos reais.

## Variáveis de ambiente

Arquivo `.env` na **raiz** do projeto (ao lado de `includes/`), nunca em `public/` nem em `public_html`.

Não coloque valores reais neste README. Copie o exemplo e preencha só no seu computador / FTP:

```bash
cp .env.example .env
```

O `.env.example` só tem as chaves, sem valor. O PHP lê:

- `GOOGLE_WORKSPACE_ADMIN`
- `GOOGLE_WORKSPACE_GROUP`
- `GOOGLE_CREDENTIALS_JSON` — se usar o estilo Java `classpath:/google/...`, o código aponta para `credentials/service-account.json`

Opcional (já têm padrão no código): `PLAY_STORE_URL`, `TESTER_URL`, `FACEBOOK_URL`, `GA_MEASUREMENT_ID`, `ADS_ID`, `GOOGLE_SITE_VERIFICATION`.

Coloque a chave em:

```
credentials/service-account.json
```

## Rodar local

PHP via asdf (`8.5.10`):

```bash
cd /Users/allanfenx/Apps/PHP
php -S 127.0.0.1:8080 -t public public/router.php
```

Abra [http://127.0.0.1:8080](http://127.0.0.1:8080). Pare com `Ctrl + C`.

O `router.php` só existe para o servidor embutido do PHP. **Não suba** esse arquivo para a Locaweb.

## Publicar na Locaweb

Hospedagem **Linux**. PHP **8.1+** no painel.

### Pastas no FTP

```
/home/SEU_USUARIO_FTP/
  .env
  includes/
  credentials/service-account.json
  public_html/                 ← conteúdo de public/
    index.php
    google.php
    politica-de-privacidade.php
    robots.txt
    sitemap.xml
    styles.css
    favicon.svg
    og-image.jpg
    .htaccess
    src/app.js
```

`.env` e `service-account.json` precisam ir no FTP **uma vez**, mesmo estando no `.gitignore`. O deploy automático **não** envia esses arquivos.

### Deploy automático (GitHub Actions)

A Locaweb não clona o Git. Cada push em `main` (pastas `public/` e `includes/`) sobe os arquivos por FTP.

1. No painel: [painelhospedagem.locaweb.com.br](https://painelhospedagem.locaweb.com.br/) → **Administrar** → **Arquivos e FTP**.
2. No GitHub: **Settings → Secrets and variables → Actions** e crie:

| Secret | Valor no painel Locaweb |
| --- | --- |
| `HOST` | Host do servidor FTP |
| `USER` | Usuário FTP |
| `PASS` | Senha FTP |

3. Faça o commit da pasta `.github/workflows/deploy.yml` quando quiser ligar a automação.
4. Acompanhe em **Actions**. Também dá para rodar na mão: **Actions → Deploy Locaweb → Run workflow**.

O que **não** sobe: `.env`, `credentials/*.json`, `public/router.php`, `public/.htaccess` (para não apagar o `AddHandler` da Locaweb).

Primeira vez no servidor (FTP, uma vez só):

- `.env` na pasta do usuário (acima de `public_html`)
- `credentials/service-account.json` no mesmo nível
- `.htaccess` mesclado (veja abaixo)

### Deploy local (sem GitHub)

```bash
cp .env.deploy.example .env.deploy
# preencha HOST, USER e senha do FTP
brew install lftp
chmod +x scripts/deploy-locaweb.sh
./scripts/deploy-locaweb.sh
```

`.env.deploy` está no `.gitignore`.

Para enviar também o `.htaccess` neste script, use `DEPLOY_HTACCESS=1` no `.env.deploy`.

### `.htaccess`

A Locaweb já cria um arquivo com `AddHandler` e `suPHP_ConfigPath`. **Não apague.** Acrescente no final o conteúdo de `public/.htaccess`.

### Permissões

Pastas `755`, arquivos `644`. `credentials/` e `.env` fora do `public_html`.

### SSL Let's Encrypt (`app.tecnofenx.com.br`)

No painel Locaweb, em **Domínios**, use **Emitir Let's Encrypt** só para `app.tecnofenx.com.br`. O hostname precisa estar cadastrado como **Apontamento** e o DNS A deve apontar para o IP da Locaweb.

## SEO

Já incluso: title, description, canonical, Open Graph, JSON-LD (SoftwareApplication, FAQ, HowTo), `robots.txt`, `sitemap.xml`.

Search Console:

1. [https://search.google.com/search-console](https://search.google.com/search-console)
2. Propriedade **Prefixo do URL**: `https://app.tecnofenx.com.br`
3. Verificar (tag HTML já está no `header.php`)
4. **Sitemaps** → enviar `sitemap.xml`

## Checklist Google Workspace

- [ ] Service account criada no projeto GCP
- [ ] Delegação em todo o domínio com o escopo `admin.directory.group.member`
- [ ] Admin em `GOOGLE_WORKSPACE_ADMIN` pode gerenciar o grupo
- [ ] Grupo `GOOGLE_WORKSPACE_GROUP` usado na lista de testadores do teste fechado da Play
- [ ] Arquivo JSON em `credentials/service-account.json`

## Páginas

| URL | Arquivo |
| --- | --- |
| `/` | `public/index.php` |
| `/google.php` | cadastro no Google Group |
| `/politica-de-privacidade.php` | política de privacidade |
| `/robots.txt` | crawlers |
| `/sitemap.xml` | sitemap |

Desenvolvido por Allan Fenx.
