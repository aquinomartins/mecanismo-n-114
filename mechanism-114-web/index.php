<?php
declare(strict_types=1);

/**
 * Conteúdo editável do site. Os valores marcados como provisórios devem ser
 * substituídos quando links e materiais finais do projeto estiverem disponíveis.
 */
$project = [
    'name' => 'Mecanismo 114',
    'product' => 'Um estudo cinemático interativo do pinhão mutilado com cremalheira dupla.',
    'audience' => 'Estudantes, projetistas e pessoas curiosas sobre engenharia mecânica.',
    'cta' => ['label' => 'Explorar mecanismo', 'url' => '#narrativa'],
    'contact' => '#contato', // provisório: nenhum backend de contato configurado
    'repository' => '#',    // provisório: informe a URL pública
];

function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

$scenes = [
  ['apresentacao', 'Apresentação', 'Movimento em evidência', 'Uma leitura visual, precisa e contínua do movimento 114.'],
  ['perimetro', 'Perímetro', 'Um sistema delimitado', 'Pinhão, cremalheiras e curso operam dentro de um único perímetro mecânico.'],
  ['compatibilidade', 'Compatibilidade', 'Geometria que se encaixa', 'Módulo, dentes e ângulo de pressão compartilham uma linguagem geométrica comum.'],
  ['continuidade', 'Continuidade', 'Cada volta conta uma história', 'O histórico angular mostra avanço, repouso, retorno e uma nova transferência.'],
  ['colaboracao', 'Colaboração', 'Componentes em sincronia', 'As relações permanecem visíveis enquanto a energia percorre o conjunto.'],
  ['nucleo', 'Núcleo', 'Uma ideia, muitas relações', 'No centro, uma rede cinemática conecta rotação, contato e deslocamento.'],
  ['controle', 'Controle', 'Comande o movimento', 'Acione, pause e inspecione o mecanismo sem perder a posição atual.'],
  ['regras', 'Regras', 'Limites bem definidos', 'As condições de contato protegem a transferência e tornam o ciclo previsível.'],
  ['tempo', 'Tempo', 'O ciclo em quatro tempos', 'Avanço, transferência, retorno e repouso dividem uma revolução completa.'],
  ['canais', 'Canais', 'Leia por diferentes sinais', 'Geometria, gráfico e estado textual comunicam a mesma posição.'],
  ['entrega', 'Entrega', 'Pronto para explorar', 'Uma demonstração aberta no navegador, responsiva e orientada à descoberta.'],
];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
  <meta name="theme-color" content="#030712"><title><?= e($project['name']) ?> · Cinemática interativa</title>
  <meta name="description" content="<?= e($project['product']) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<canvas id="particles" aria-hidden="true"></canvas>
<header class="site-header">
  <a class="brand" href="#inicio" aria-label="Mecanismo 114, início"><span class="brand-mark">M</span><?= e($project['name']) ?></a>
  <nav id="menu" aria-label="Navegação principal"><a href="#narrativa">Como funciona</a><a href="#comparacao">Versões</a><a href="#demonstracoes">Demonstrações</a></nav>
  <div class="header-actions"><a class="text-link" href="#contato">Contato</a><a class="button small" href="<?= e($project['cta']['url']) ?>"><?= e($project['cta']['label']) ?></a></div>
  <button class="menu-toggle" aria-expanded="false" aria-controls="menu"><span></span><span></span><span></span><span class="sr-only">Abrir menu</span></button>
</header>

<main>
  <section class="story" id="narrativa" aria-label="Narrativa do mecanismo">
    <div class="story-track">
      <?php foreach ($scenes as $i => $scene): ?><div class="scene-anchor" id="cena-<?= $i + 1 ?>" data-scene="<?= $i ?>"></div><?php endforeach; ?>
    </div>
    <div class="stage" id="inicio">
      <div class="stage-glow"></div>
      <div class="copy intro-copy">
        <span class="announcement"><i></i> ESTUDO INTERATIVO · DADOS DEMONSTRATIVOS</span>
        <p class="kicker">MECÂNICA EM MOVIMENTO</p>
        <h1>Transforme rotação<br>em <em>ritmo preciso.</em></h1>
        <p><?= e($project['product']) ?></p>
        <div class="hero-actions"><a class="button" href="#cena-2">Iniciar narrativa <span>↓</span></a><button class="button ghost open-video" data-video="Visão geral">Ver demonstração <span>↗</span></button></div>
        <div class="hero-meta"><span>01 REVOLUÇÃO</span><span>04 FASES</span><span>360° CONTÍNUOS</span></div>
      </div>
      <div class="copy scene-copy" aria-live="polite"><p class="kicker" id="scene-kicker"></p><h2 id="scene-title"></h2><p id="scene-text"></p><a href="#iniciar" class="inline-link">Conhecer os detalhes <span>↗</span></a></div>

      <div class="visual" aria-label="Visualização cinemática demonstrativa">
        <svg class="connections" viewBox="0 0 1000 700" preserveAspectRatio="none" aria-hidden="true"><g id="connection-lines"></g></svg>
        <div class="perimeter"><span>AMBIENTE CINEMÁTICO · 360°</span></div>
        <?php
        $cards = [
          ['ÂNGULO', 'θ 214°', 'phase'], ['PINHÃO', '06 dentes', 'gear'], ['CURSO', '+7,85 m', 'chart'],
          ['CONTATO', 'ENGATADO', 'pulse'], ['VELOCIDADE', 'rₚω', 'bars'], ['PRESSÃO', '25°', 'dial'], ['CICLO', '03 / 04', 'steps']
        ];
        foreach ($cards as $i => $card): ?>
          <article class="metric-card card-<?= $i + 1 ?>" data-card="<?= $i ?>">
            <div class="card-top"><span><?= e($card[0]) ?></span><i></i></div><strong><?= e($card[1]) ?></strong>
            <div class="mini <?= e($card[2]) ?>"><span></span><span></span><span></span><span></span><span></span></div>
            <small><?= $i === 3 ? 'SINAL ATIVO' : 'DADO DEMONSTRATIVO' ?></small>
          </article>
        <?php endforeach; ?>
        <div class="network" id="network" aria-hidden="true"></div>
        <div class="core"><div class="core-ring ring-a"></div><div class="core-ring ring-b"></div><b>M114</b><span>NÚCLEO</span></div>
        <div class="timeline"><i></i><b>0°</b><b>150°</b><b>180°</b><b>330°</b><b>360°</b></div>
        <div class="command-panel"><span>CONTROLE LOCAL</span><button id="demo-toggle"><i></i> Acionar mecanismo</button><code>estado: <b>pronto</b></code></div>
      </div>
      <div class="scroll-hint">ROLE PARA EXPLORAR <span>↓</span></div>
      <nav class="scene-nav" aria-label="Cenas da narrativa">
        <?php foreach ($scenes as $i => $scene): ?><a href="#cena-<?= $i + 1 ?>" data-index="<?= $i ?>" aria-label="Ir para <?= e($scene[1]) ?>"><span><?= e($scene[1]) ?></span></a><?php endforeach; ?>
      </nav>
    </div>
  </section>

  <section class="content-section compare" id="comparacao"><div class="section-intro"><p class="kicker">DUAS FORMAS DE OBSERVAR</p><h2>Da visão essencial<br>à inspeção completa.</h2><p>Escolha o nível de detalhe ideal para sua exploração. Ambas as opções são demonstrações gratuitas.</p></div>
    <div class="compare-grid"><article><span class="plan-tag">VISUALIZAÇÃO</span><h3>Essencial</h3><p>Para entender o princípio rapidamente.</p><ul><li>Animação cinemática</li><li>Leitura das quatro fases</li><li>Controles acessíveis</li></ul><a class="button ghost" href="#iniciar">Abrir visão essencial</a></article><article class="featured"><span class="plan-tag">INSPEÇÃO TÉCNICA</span><h3>Detalhada</h3><p>Para investigar geometria e relações.</p><ul><li>Tudo da visão essencial</li><li>Linhas construtivas</li><li>Métricas e gráfico dinâmico</li></ul><a class="button" href="?debug=1#iniciar">Ativar modo técnico</a></article></div>
  </section>

  <section class="content-section getting-started" id="iniciar"><p class="kicker">COMECE AGORA</p><h2>Entenda em três movimentos.</h2><p>Sem instalação ou cadastro. Explore diretamente no navegador.</p><div class="steps"><article><b>01</b><h3>Observe</h3><p>Reconheça o pinhão e as duas cremalheiras.</p></article><article><b>02</b><h3>Acione</h3><p>Mantenha o controle pressionado para mover.</p></article><article><b>03</b><h3>Compare</h3><p>Relacione posição, fase e gráfico.</p></article></div><a class="button" href="#demonstracoes">Ver demonstrações <span>↓</span></a></section>

  <section class="content-section feature"><div class="feature-visual"><div class="orbit"><i></i><i></i><i></i><strong>θ</strong></div><span>RELAÇÃO CENTRAL</span></div><div><p class="kicker">UM ÚNICO ESTADO</p><h2>Uma variável conecta todo o mecanismo.</h2><p>O ângulo do pinhão determina a posição da moldura, o contato ativo e o instante exibido no gráfico. Assim, todas as leituras permanecem coerentes.</p><a class="inline-link" href="?debug=1">Examinar a geometria <span>↗</span></a></div></section>

  <section class="content-section demos" id="demonstracoes"><div class="section-intro"><p class="kicker">DEMONSTRAÇÕES · CONTEÚDO PROVISÓRIO</p><h2>Veja cada relação em ação.</h2></div><div class="demo-grid">
    <?php foreach ([['Ciclo completo','CINEMÁTICA','01:20'],['Transferência sem carga','GEOMETRIA','00:48'],['Leitura do deslocamento','ANÁLISE','01:05']] as $i => $demo): ?><button class="demo-card open-video" data-video="<?= e($demo[0]) ?>"><span class="thumb thumb-<?= $i + 1 ?>"><i class="play">▶</i><small><?= e($demo[2]) ?></small></span><span class="demo-info"><small><?= e($demo[1]) ?></small><strong><?= e($demo[0]) ?></strong><em>Material ilustrativo · vídeo pendente</em></span></button><?php endforeach; ?>
  </div></section>
</main>

<footer id="contato"><div class="footer-lead"><a class="brand" href="#inicio"><span class="brand-mark">M</span><?= e($project['name']) ?></a><p><?= e($project['product']) ?></p></div><form id="contact-form" novalidate><label for="email">Receba atualizações <small>DEMONSTRAÇÃO · SEM ENVIO REAL</small></label><div><input id="email" type="email" placeholder="seu@email.com" required><button type="submit" aria-label="Validar email">→</button></div><p class="form-status" role="status"></p></form><div class="footer-links"><div><b>EXPLORAR</b><a href="#narrativa">Narrativa</a><a href="#demonstracoes">Demonstrações</a></div><div><b>PROJETO</b><a href="<?= e($project['repository']) ?>">Repositório <small>provisório</small></a><a href="?debug=1">Modo técnico</a></div></div><div class="footer-bottom"><span>© <?= date('Y') ?> <?= e($project['name']) ?></span><span>CONCEITO EDUCACIONAL · PT-BR</span></div></footer>

<button class="floating-action open-video" data-video="Visão geral" aria-label="Abrir visão geral"><span>▶</span><b>VER DEMO</b></button>
<dialog id="video-modal" aria-labelledby="modal-title"><button class="modal-close" aria-label="Fechar">×</button><div class="modal-placeholder"><span>▶</span></div><p class="kicker">CONTEÚDO PROVISÓRIO</p><h2 id="modal-title">Demonstração</h2><p>O vídeo final ainda não foi fornecido. Esta janela demonstra o comportamento acessível do player.</p></dialog>
<script>window.PROJECT_CONFIG = <?= json_encode(['scenes' => $scenes, 'provisional' => true], JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>
<script src="assets/js/mechanism-114.js"></script>
</body></html>
