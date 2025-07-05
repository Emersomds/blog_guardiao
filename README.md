# 🛡️ blog_guardiao

**Sistema de blog com painel administrativo**, desenvolvido com **PHP** em estrutura **MVC** e interface em **Bootstrap**. O sistema é focado em segurança, controle de usuários e rastreabilidade por meio de logs.

---

## 📁 Estrutura do Projeto

blog_guardiao/

├── app/

│ ├── controllers/

│ ├── core/

│ ├── models/

│ └── views/

├── config/

│ └── database.php

├── public/

│ ├── assets/

│ ├── uploads/

│ └── .htaccess

└── index.php


---

## ✅ Funcionalidades

### 🔐 Autenticação
- Login seguro com `password_hash()` e `password_verify()`
- CSRF token em formulários
- Controle de sessão
- Logout seguro

### 👤 Gerenciamento de Usuários
- Cadastro de novos usuários (admin ou usuário comum)
- Validação de dados (e-mail, senha)
- Edição e exclusão de usuários
- Acesso restrito com base no tipo (`role`)
- Apenas `admin` pode gerenciar usuários e visualizar logs

### 📝 Gerenciamento de Posts
- Criação de posts com upload de imagem (JPG, PNG


### 📝 Gerenciamento de Posts
- Criação de posts com upload de imagem (JPG, PNG, GIF)
- Validação de tipo e tamanho (máx. 2MB)
- Listagem e edição de posts
- Exclusão com confirmação
- Apenas o autor visualiza seus próprios posts (exceto admin, que vê todos)

### 📊 Logs e Auditoria
- Logs de login, criação, edição e exclusão
- Armazena IP, agente do navegador e ação executada
- Painel de visualização com paginação

### 📄 Página Pública
- Página inicial exibe posts mais recentes
- Página individual do post via URL amigável `/post/ver/:id`

---

## 🔐 Controle de Acesso

| Tipo de Usuário | Criar Posts | Ver Próprios Posts | Ver Todos Posts | Gerenciar Usuários | Ver Logs |
|-----------------|-------------|---------------------|------------------|---------------------|----------|
| `admin`         | ✅          | ✅                  | ✅               | ✅                  | ✅       |
| `user`          | ✅          | ✅                  | ❌               | ❌                  | ❌       |

---

## ⚙️ Configuração Inicial

1. Clone o repositório:
   ```bash
   [git clone https://github.com/Emersomds/blog_guardiao.git
   ```

2. Configure o banco de dados MySQL:
   - Crie um banco com nome `guardiao_db`
   - Importe o arquivo `guardiao_db.sql`

```bash
   -- Tabela: users 
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `role` varchar(20) NOT NULL DEFAULT 'autor',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: postsVFZ
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `data_publicacao` datetime DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL,
  `autor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: logs
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `acao` varchar(100) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `data_hora` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

3. Ajuste o arquivo `/config/database.php` com suas credenciais.

4. Configure o Apache para apontar para a pasta `public/`.

5. Verifique se o `.htaccess` está ativado para URLs amigáveis.

---

## 🛡️ Segurança Implementada

- CSRF tokens em todos os formulários
- Senhas criptografadas
- Sessões protegidas
- Restrições por tipo de usuário (`role`)
- Logs de ações administrativas
- Proteção contra uploads maliciosos

---

## 💡 Tecnologias Utilizadas

- PHP 8.2+
- MySQL
- Bootstrap 5
- Estrutura MVC personalizada
- Apache com mod_rewrite

---

## 📌 Futuras Melhorias

- Implementar sistema de comentários
- Enviar e-mails de notificação
- Dashboard com gráficos (analytics)
- Pesquisa e filtro de logs/posts
- Upload de múltiplas imagens por post

---

## 👨‍💻 Autor

Projeto desenvolvido por **Emerson Matos** para o sistema **Guardião Digital**.

---

## 📝 Licença

Este projeto está licenciado sob a licença MIT.
