## 🚀 Funcionalidades
- **Cadastro de Usuários:** Registro com validação e envio de token de ativação por e-mail.
- **Token com Expiração:** Token de validação com validade estipulada de **30 minutos**.
- **Login Seguro:** Autenticação protegida para acesso à plataforma.
- **Recuperação de Senha:** Fluxo completo de "Esqueci minha senha" via envio de e-mail.
- **Envio de E-mails:** Integração SMTP configurada para disparos automáticos.

---

## 🛠️ Pré-requisitos e Instalação
Antes de iniciar, certifique-se de ter as seguintes ferramentas instaladas em sua máquina:
- **PHP** e o gerenciador de dependências **Composer** instalado (caso não tenha, faça o download no site oficial: [getcomposer.org/download](https://getcomposer.org/download/)).
- Um servidor local como o **XAMPP** (ou qualquer outro interpretador Apache/PHP compatível).

Após clonar o repositório, abra o terminal na pasta raiz do projeto e execute o comando abaixo para instalar as dependências:
```bash
composer install
```
---

## 💾 Configuração do Banco de Dados
O sistema necessita de uma base de dados rodando localmente no `localhost` utilizando a porta **3306**.

- Certifique-se de ter o seu SGBD ativo em `localhost:3306`.
- O script de criação e estruturação do banco de dados encontra-se localizado na pasta `database` do projeto. Importe-o para o seu ambiente local antes de iniciar a aplicação.

---

## ⚙️ Configuração do Ambiente (.env)
Para rodar o projeto localmente, você precisará configurar as variáveis de ambiente:

1. Na raiz do projeto, duplique o arquivo `.env-example` e renomeie-o para `.env`.
2. Preencha as credenciais de e-mail conforme o modelo abaixo:

```env
# Configurações de SMTP (Host e Porta do Gmail já configurados)
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587

# Coloque o seu e-mail nas variáveis abaixo
SMTP_USERNAME=seu-email@gmail.com
SMTP_FROM_EMAIL=seu-email@gmail.com

# ==========================================
# COMO GERAR A SENHA DE APP DO GMAIL:
# 1. Acesse sua Conta Google (Configurações de Segurança).
# 2. Ative a Verificação em Duas Etapas.
# 3. Pesquise por "Senhas de app", crie uma nova para o projeto 
#    e cole o código gerado de 16 letras abaixo (sem espaços):
# ==========================================
SMTP_PASSWORD=sua-senha-de-app-aqui
