<?php
declare(strict_types=1);

$config = [
    'module' => 8,
    'teeth' => 12,
    'keptTeeth' => 6,
    'pressureAngle' => 25,
    'period' => 5,
    'samples' => 360,
];

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$title = 'Mecanismo 114';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#f5f0e6">
  <title><?= e($title) ?> · Estudo cinemático</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main class="sheet">
  <header class="masthead">
    <p class="eyebrow">ART MECHANISM <span>·</span> ESTUDO CINEMÁTICO</p>
    <div class="rule"></div>
    <h1>MECANISMO <strong>114</strong></h1>
    <p class="subtitle">PINHÃO MUTILADO + CREMALHEIRA DUPLA</p>
    <p class="dek">Rotação uniforme convertida em translação alternada, com engate conjugado em cada curso.</p>
  </header>

  <section class="construction" aria-labelledby="construction-title">
    <div class="section-head"><h2 id="construction-title">CONSTRUÇÃO</h2><b>114</b></div>
    <figure class="mechanism-card">
      <svg id="mechanism" viewBox="0 0 800 500" role="img" aria-labelledby="svg-title svg-desc">
        <title id="svg-title">Mecanismo de pinhão mutilado e cremalheira dupla</title>
        <desc id="svg-desc">Um pinhão de seis dentes gira no sentido horário e engata alternadamente as cremalheiras internas de uma moldura, produzindo movimento horizontal alternado.</desc>
        <defs>
          <linearGradient id="frame-gradient" x1="0" x2="1"><stop stop-color="#6541a5"/><stop offset=".48" stop-color="#2f74b9"/><stop offset="1" stop-color="#31a1b1"/></linearGradient>
          <linearGradient id="gear-gradient" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#7754b8"/><stop offset="1" stop-color="#49307f"/></linearGradient>
          <pattern id="mesh" width="16" height="16" patternUnits="userSpaceOnUse"><path d="M16 0H0V16" fill="none" stroke="#fff" stroke-opacity=".15" stroke-width="1"/></pattern>
          <filter id="shadow" x="-20%" y="-20%" width="140%" height="150%"><feDropShadow dx="0" dy="8" stdDeviation="8" flood-color="#26252b" flood-opacity=".16"/></filter>
          <marker id="arrow" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse"><path d="M0 0 10 5 0 10z" fill="context-stroke"/></marker>
        </defs>
        <g class="construction-lines"><path d="M80 250H720M400 65V435"/><path class="pitch-rack" d="M105 190H695M105 310H695"/><circle class="debug-only pitch-circle" cx="400" cy="250" r="48"/><circle class="debug-only base-circle" cx="400" cy="250" r="43.5"/><path class="debug-only action-line" d="M330 283 470 217"/></g>
        <g id="moving-frame" filter="url(#shadow)">
          <path class="frame-body" fill="url(#frame-gradient)" fill-rule="evenodd" d="M95 140 H705 Q750 140 750 185 V315 Q750 360 705 360 H95 Q50 360 50 315 V185 Q50 140 95 140 Z M115 180 H685 Q710 180 710 205 V295 Q710 320 685 320 H115 Q90 320 90 295 V205 Q90 180 115 180 Z"/>
          <path class="frame-mesh" fill="url(#mesh)" fill-rule="evenodd" d="M95 140 H705 Q750 140 750 185 V315 Q750 360 705 360 H95 Q50 360 50 315 V185 Q50 140 95 140 Z M115 180 H685 Q710 180 710 205 V295 Q710 320 685 320 H115 Q90 320 90 295 V205 Q90 180 115 180 Z"/>
          <g id="top-rack" class="rack"></g><g id="bottom-rack" class="rack"></g>
          <g class="debug-only relief-envelopes"><path d="M92 180q30 44 68 0M640 180q38 44 68 0M92 320q30-44 68 0M640 320q38-44 68 0"/></g>
        </g>
        <g id="gear" filter="url(#shadow)"><circle class="gear-core" cx="0" cy="0" r="38"/><g id="gear-teeth"></g><circle class="hub-outer" r="18"/><circle class="hub" r="11"/><circle class="axle" r="4"/></g>
        <g class="annotations">
          <circle class="fixed-point" cx="400" cy="250" r="3"/><text x="410" y="272">O</text>
          <circle class="pitch-point" cx="400" cy="202" r="3"/><text x="410" y="198">P</text>
          <path class="rotation-arrow" d="M330 220 A75 75 0 0 1 452 188" marker-end="url(#arrow)"/><text x="464" y="185">ω = const.</text>
          <path d="M400 250V202" marker-end="url(#arrow)"/><text x="410" y="228">rₚ = 6m</text>
          <path class="dimension" d="M300 403H500M300 394V412M500 394V412" marker-start="url(#arrow)" marker-end="url(#arrow)"/><text x="400" y="430" text-anchor="middle">curso s = (5π/6)rₚ = 5πm</text>
          <g id="velocity"><path d="M350 378H450" marker-end="url(#arrow)"/><text x="400" y="372" text-anchor="middle">v = rₚω</text></g>
        </g>
        <g class="debug-panel debug-only" transform="translate(20 18)"><rect width="238" height="75" rx="4"/><text id="debug-readout" x="12" y="22"></text><text x="12" y="43">zonas de repouso: ±15°</text><text x="12" y="64">envelopes terminais amostrados</text></g>
      </svg>
      <figcaption id="engagement" class="engagement" aria-live="polite">TRANSFERÊNCIA SEM CARGA · MOLDURA EM REPOUSO</figcaption>
    </figure>
  </section>

  <section class="facts" aria-label="Dados técnicos">
    <article><small>REFERÊNCIA</small><strong>z = 12</strong><span>6 dentes preservados</span></article>
    <article><small>PERFIL CONJUGADO</small><strong>α = 25°</strong><span>involuta + alívio terminal</span></article>
    <article><small>LEI DE MOVIMENTO</small><strong>|v| = rₚω</strong><span>curso + repouso de reversão</span></article>
  </section>

  <section class="chart-section" aria-labelledby="chart-title">
    <div class="chart-head"><h2 id="chart-title">DESLOCAMENTO DA MOLDURA</h2><output id="x-output">x/m = +7,85</output></div>
    <svg id="motion-chart" viewBox="0 0 760 170" role="img" aria-label="Gráfico dinâmico de x em função de teta">
      <g class="chart-grid"><path d="M45 20H735M45 85H735M45 150H735M45 20V150"/><text x="4" y="25">+2,5πm</text><text x="13" y="154">−2,5πm</text><text x="43" y="167">0</text><text x="385" y="167">π</text><text x="725" y="167">2π</text></g>
      <path id="motion-path" class="motion-path"/><line id="chart-cursor" class="chart-cursor" y1="16" y2="154"/><circle id="chart-dot" class="chart-dot" r="6"/>
    </svg>
  </section>

  <section class="controls" aria-label="Controle do mecanismo">
    <p id="electrical-state" class="electrical-state" aria-live="polite">○ CONTATO ABERTO · MOTOR DESENERGIZADO</p>
    <button id="hold-button" type="button" aria-pressed="false"><strong>PRESSIONE E SEGURE</strong><span>BOTÃO MOMENTÂNEO · NORMALMENTE ABERTO (NA)</span></button>
    <p class="instructions">Mantenha o botão pressionado para girar. Ao soltar, o mecanismo para exatamente na posição atual. Também funciona com Espaço ou Enter.</p>
  </section>

  <footer><span>MECHANICAL MOVEMENTS · Nº 114</span><span>ANIMAÇÃO CINEMÁTICA · 30° DE TRANSFERÊNCIA</span></footer>
</main>
<script>window.MECHANISM_CONFIG = <?= json_encode($config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<script src="assets/js/mechanism-114.js"></script>
<script src="assets/js/mechanics-test.js"></script>
</body>
</html>
