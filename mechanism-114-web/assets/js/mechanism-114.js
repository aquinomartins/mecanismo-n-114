(() => {
  'use strict';
  const stage = document.querySelector('.stage');
  const anchors = [...document.querySelectorAll('.scene-anchor')];
  const dots = [...document.querySelectorAll('.scene-nav a')];
  const config = window.PROJECT_CONFIG;
  const title = document.querySelector('#scene-title');
  const kicker = document.querySelector('#scene-kicker');
  const text = document.querySelector('#scene-text');
  let active = -1;

  function setScene(index) {
    if (index === active || index < 0 || index >= anchors.length) return;
    active = index;
    stage.dataset.scene = String(index);
    const scene = config.scenes[index];
    kicker.textContent = `${String(index + 1).padStart(2, '0')} · ${scene[1]}`;
    title.textContent = scene[2];
    text.textContent = scene[3];
    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
      if (i === index) dot.setAttribute('aria-current', 'step');
      else dot.removeAttribute('aria-current');
    });
  }

  const observer = new IntersectionObserver(entries => {
    const visible = entries.filter(entry => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
    if (visible) setScene(Number(visible.target.dataset.scene));
  }, { threshold: [.25, .5, .75], rootMargin: '-20% 0px -20% 0px' });
  anchors.forEach(anchor => observer.observe(anchor));
  setScene(0);

  // Build connection lines once; card identities stay constant as their positions change.
  const group = document.querySelector('#connection-lines');
  [[580,180,510,330],[580,180,760,330],[510,330,510,520],[760,330,760,520],[510,520,580,610],[760,520,760,610],[510,330,760,520]].forEach(points => {
    const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    ['x1','y1','x2','y2'].forEach((attr, i) => line.setAttribute(attr, points[i]));
    group.appendChild(line);
  });

  const menuButton = document.querySelector('.menu-toggle');
  const menu = document.querySelector('#menu');
  menuButton.addEventListener('click', () => {
    const open = menu.classList.toggle('open');
    menuButton.setAttribute('aria-expanded', String(open));
  });
  menu.addEventListener('click', () => { menu.classList.remove('open'); menuButton.setAttribute('aria-expanded', 'false'); });

  const demoToggle = document.querySelector('#demo-toggle');
  demoToggle.addEventListener('click', () => {
    const enabled = demoToggle.classList.toggle('enabled');
    demoToggle.lastChild.textContent = enabled ? ' Pausar mecanismo' : ' Acionar mecanismo';
    demoToggle.nextElementSibling.querySelector('b').textContent = enabled ? 'em movimento' : 'pronto';
  });

  // Accessible provisional video dialog: native dialog handles focus trapping.
  const dialog = document.querySelector('#video-modal');
  const modalTitle = document.querySelector('#modal-title');
  let opener = null;
  document.querySelectorAll('.open-video').forEach(button => button.addEventListener('click', () => {
    opener = button;
    modalTitle.textContent = button.dataset.video || 'Demonstração';
    dialog.showModal();
    dialog.querySelector('.modal-close').focus();
  }));
  function closeDialog() { dialog.close(); opener?.focus(); }
  dialog.querySelector('.modal-close').addEventListener('click', closeDialog);
  dialog.addEventListener('click', event => { if (event.target === dialog) closeDialog(); });
  dialog.addEventListener('cancel', event => { event.preventDefault(); closeDialog(); });

  const form = document.querySelector('#contact-form');
  form.addEventListener('submit', event => {
    event.preventDefault();
    const input = form.querySelector('input');
    const status = form.querySelector('.form-status');
    if (!input.validity.valid) {
      status.textContent = 'Informe um e-mail válido.';
      status.style.color = '#fbbf24';
      input.focus();
      return;
    }
    status.textContent = 'E-mail validado. Demonstração sem envio real.';
    status.style.color = '#34d399';
  });

  // Low-density canvas particles, capped at 2× resolution and paused off-screen.
  const canvas = document.querySelector('#particles');
  const ctx = canvas.getContext('2d');
  const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
  let points = [], frame = 0, running = !document.hidden && !reduced;
  function resize() {
    const ratio = Math.min(devicePixelRatio || 1, 2);
    canvas.width = innerWidth * ratio; canvas.height = innerHeight * ratio;
    canvas.style.width = `${innerWidth}px`; canvas.style.height = `${innerHeight}px`;
    ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
    const count = innerWidth < 600 ? 20 : 52;
    points = Array.from({ length: count }, () => ({ x: Math.random()*innerWidth, y: Math.random()*innerHeight, r: Math.random()*1.2+.25, v: Math.random()*.08+.02 }));
  }
  function draw() {
    if (!running) return;
    ctx.clearRect(0,0,innerWidth,innerHeight);
    points.forEach(p => { p.y -= p.v; if (p.y < -3) p.y = innerHeight+3; ctx.fillStyle='#8b9bd0'; ctx.globalAlpha=.2+p.r*.12; ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2); ctx.fill(); });
    ctx.globalAlpha=1; frame=requestAnimationFrame(draw);
  }
  addEventListener('resize', resize, { passive:true });
  document.addEventListener('visibilitychange', () => { running = !document.hidden && !reduced; cancelAnimationFrame(frame); if(running) draw(); });
  resize(); if(running) draw();
})();
