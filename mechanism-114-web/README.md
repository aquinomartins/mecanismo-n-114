# Mecanismo nº 114

Landing page imersiva, responsiva e sem dependências de aplicação para apresentar o estudo cinemático do pinhão mutilado com cremalheira dupla. A experiência usa uma narrativa de 11 cenas controlada por rolagem, painéis técnicos, visualizações em CSS/SVG e partículas em Canvas.

## Executar

Requer PHP 8 ou superior:

```bash
cd mechanism-114-web
php -S localhost:8000
```

Abra `http://localhost:8000`. O conteúdo, links e indicações de material provisório ficam centralizados no array `$project` e em `$scenes`, no início de `index.php`.

## Interações

- Role a página ou use os indicadores laterais para percorrer as 11 cenas.
- Use o menu compacto em telas menores.
- Abra qualquer demonstração para testar o modal acessível (os vídeos finais ainda são provisórios).
- O formulário do rodapé valida o e-mail localmente e informa explicitamente que não realiza envio.
- Ative “reduzir movimento” no sistema para eliminar movimentos decorativos.

## Arquivos principais

- `index.php`: configuração editável, conteúdo semântico e componentes da página;
- `assets/css/style.css`: direção visual, transições de cenas e responsividade;
- `assets/js/mechanism-114.js`: sincronização com rolagem, navegação, modal, formulário e Canvas.
