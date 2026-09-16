# Mecanismo nº 114

Página técnica, mobile-first e sem dependências externas para demonstrar o pinhão mutilado com cremalheira dupla. O desenho é SVG vetorial e a cinemática é calculada em JavaScript a partir de uma única variável angular.

## Executar

Requer PHP 8 ou superior:

```bash
cd mechanism-114-web
php -S localhost:8000
```

Abra `http://localhost:8000`. Para visualizar círculos primitivo e de base, linhas de ação, zonas de repouso e envelopes de alívio, use `http://localhost:8000/?debug=1`.

## Operação

Mantenha **PRESSIONE E SEGURE** acionado com mouse, toque ou caneta. Pelo teclado, mantenha `Espaço` ou `Enter`. Soltar, cancelar o ponteiro, trocar de aba ou perder o foco abre imediatamente o contato NA e preserva a posição.

## Decisões mecânicas

- Geometria paramétrica baseada em `m = 8`, com `z = 12`, raio primitivo `6m`, adendo `m`, dedendo `1,25m` e ângulo de pressão de 25°.
- Seis dentes nas posições −75°, −45°, −15°, +15°, +45° e +75°. Cada face é amostrada pela parametrização da involuta do círculo-base até o círculo de adendo.
- Cremalheiras conjugadas com cinco dentes e flancos retos a 25°. A abertura ampla e os alívios terminais mantêm livre o setor descarregado durante a transferência.
- Lei de movimento linear por trechos, sem easing: cursos de 150°, transferências em repouso de 30° e velocidade angular `2π/5 rad/s`.
- O mesmo `state.theta` posiciona pinhão, moldura, indicador e marcador do gráfico usando `requestAnimationFrame` e tempo real transcorrido.

## Verificação

`mechanics-test.js` varre 360 posições por revolução e registra no console continuidade, curso, derivadas por fase, limites e integridade do perfil. O modo de depuração torna visível a geometria de construção para inspeção quadro a quadro.

## Arquivos

- `index.php`: parâmetros, conteúdo semântico e SVG;
- `assets/css/style.css`: identidade editorial e responsividade;
- `assets/js/mechanism-114.js`: geometria, cinemática, renderização e controles;
- `assets/js/mechanics-test.js`: verificações mecânicas automáticas;
- `assets/img/reference.svg`: captura vetorial da implementação em uma viewport de 390 × 844, mantida como texto para compatibilidade com revisão de código e diffs.
