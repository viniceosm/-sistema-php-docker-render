# 🚀 Sistema PHP + PostgreSQL (Render Deploy)

Projeto PHP 7.4 com Apache e banco de dados PostgreSQL, preparado para deploy gratuito na [Render.com](https://render.com).  
O repositório inclui o `Dockerfile` para buildar o ambiente web, conexão com banco via variáveis de ambiente e instruções de setup.

---

## 🧩 Estrutura do Projeto

```
.
├── Dockerfile
└── src/
    ├── index.php         # Login + cadastro
    ├── home.php          # Tela inicial pós-login
    ├── logout.php        # Finaliza sessão
    └── conexao.php       # Conexão com PostgreSQL
```

---

## ⚙️ Requisitos

- Conta gratuita no [Render](https://render.com)
- Repositório público ou privado no GitHub
- PostgreSQL Database criado na Render

---

## 🧱 Passo a passo — Deploy no Render

### 1️⃣ Crie o banco de dados PostgreSQL
1. No painel da Render, clique em **New → PostgreSQL**  
2. Escolha o nome e confirme a criação  
3. Após criado, abra a aba **Connections** e anote:
   - **Hostname**
   - **Database**
   - **Username**
   - **Password**
   - **Port (5432)**  

---

### 2️⃣ Crie o serviço PHP
1. Vá em **New → Web Service**
2. Escolha o repositório GitHub com este projeto
3. Na tela de build, selecione:
   - **Environment:** Docker
   - **Branch:** `main`
   - **Build Command:** *(deixa em branco, o Dockerfile faz tudo)*
   - **Start Command:** *(deixa em branco também)*

4. O Render vai usar o `Dockerfile`:

   ```dockerfile
   FROM php:7.4-apache
   RUN apt-get update && apt-get install -y libpq-dev \
       && docker-php-ext-install pgsql pdo pdo_pgsql
   RUN a2enmod rewrite
   COPY src/ /var/www/html/
   EXPOSE 80
   ```

---

### 3️⃣ Configure as variáveis de ambiente do PHP
No painel do Render → serviço PHP → **Settings → Environment → Add Environment Variable**

| Key | Value |
|------|--------|
| PGHOST | (Hostname do banco) |
| PGPORT | 5432 |
| PGDATABASE | (Database name) |
| PGUSER | (Username) |
| PGPASSWORD | (Password) |

> ⚠️ **Não usa `MYSQL_*`** — o projeto agora usa PostgreSQL!

---

### 4️⃣ (Opcional) Suba o Adminer
Se quiser gerenciar o banco via interface web:

1. Baixe o [Adminer](https://www.adminer.org/latest.php) e suba no mesmo serviço PHP (ou outro Web Service).
2. Acesse: `https://seu-servico.onrender.com/adminer.php`
3. Use:
   ```
   System: PostgreSQL
   Server: <Hostname do banco>
   Username: <Username>
   Password: <Password>
   Database: <Database>
   ```
4. Clique em **Login** e você poderá criar a tabela:

   ```sql
   CREATE TABLE usuarios (
       id SERIAL PRIMARY KEY,
       usuario VARCHAR(50) UNIQUE NOT NULL,
       senha VARCHAR(100) NOT NULL
   );
   ```

---

### 5️⃣ Teste o sistema
Acesse a URL do teu app (exemplo:  
`https://sistema-php-docker-render.onrender.com`)  

Você verá a tela de **Login/Cadastro**.  
Cadastre um usuário, depois logue para ir até a **home.php**.

---

## 🧠 Observações

- O Render não suporta `docker-compose.yml`, apenas um container por serviço.  
- O PostgreSQL da Render já vem com armazenamento persistente e backups automáticos.  
- O Adminer pode ser removido após a criação inicial das tabelas.

---

## 🧾 Licença
Este projeto é livre para uso e modificação.  
Criado por **Vinícius Miiller Rebello (Vini)** 💜
