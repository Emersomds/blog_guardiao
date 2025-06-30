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
   git clone https://github.com/seu-usuario/blog_guardiao.git
   ```

2. Configure o banco de dados MySQL:
   - Crie um banco com nome `guardiao_db`
   - Importe o arquivo `guardiao_db.sql`

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