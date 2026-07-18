Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/boardtools/upload/config/services.yml" "[FORUM_EXT]/boardtools/upload/config/services.yml"
--- "[ORIGINAL]/boardtools/upload/config/services.yml"
+++ "[FORUM_EXT]/boardtools/upload/config/services.yml"
@@ -2,6 +2,6 @@ services:
     boardtools.upload.listener:
         class: boardtools\upload\event\listener
         arguments:
-            - @user
+            - '@user'
         tags:
             - { name: event.listener }
diff --git "[ORIGINAL]/boardtools/upload/LICENSE.txt" "[FORUM_EXT]/boardtools/upload/license.txt"
similarity index 100%
rename from LICENSE.txt
rename to license.txt
```

Alem destas duas diferencas de origem, a versao instalada no forum recebeu, em 2026-07-18, uma auditoria de
seguranca e hardening completa (ver `CUSTOM_NOTES.md` para o detalhe de cada alteracao):

- Correcoes de seguranca em `acp/upload_module.php`, `includes/filetree/filetree.php`,
  `includes/filetree/filedownload.php`, `includes/upload/base.php`, `includes/upload/lang.php`,
  `includes/functions/extensions.php` (leitura arbitraria de ficheiros, XSS refletido, e varios
  sinks de path traversal).
- `vendor/michelf/php-markdown` atualizado de 1.9.1 para 2.0.0 (biblioteca + arvore de testes +
  composer.json do vendor), acompanhando a subida do piso minimo de PHP para >=7.4.
- Novo `.github/workflows/tests.yml` (CI GitHub Actions, matriz PHP 7.4-8.3), substituindo a
  ausencia de CI propria da extensao.
- Codigo morto removido: `add_form_key('version_check_settings')` (token nunca verificado) e as
  variaveis `$host`/`$port` nao utilizadas em `includes/types/zip.php`.
