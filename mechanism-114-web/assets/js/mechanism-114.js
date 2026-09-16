(() => {
  'use strict';
  const cfg = window.MECHANISM_CONFIG;
  const NS = 'http://www.w3.org/2000/svg';
  const TAU = Math.PI * 2;
  const G = Object.freeze({
    m: cfg.module, z: cfg.teeth, alpha: cfg.pressureAngle * Math.PI / 180,
    p: Math.PI * cfg.module, rp: 6 * cfg.module, ra: 7 * cfg.module,
    rf: 4.75 * cfg.module, rb: 6 * cfg.module * Math.cos(cfg.pressureAngle * Math.PI / 180),
    S: 5 * Math.PI * cfg.module, d: Math.PI / 12, omega: TAU / cfg.period
  });
  const state = { theta: 0, energized: false, lastTime: null, pointerId: null, keys: new Set() };
  const $ = (id) => document.getElementById(id);
  const svgEl = (name, attrs = {}) => { const e = document.createElementNS(NS, name); Object.entries(attrs).forEach(([k,v]) => e.setAttribute(k,v)); return e; };
  const norm = theta => ((theta % TAU) + TAU) % TAU;

  function motion(theta) {
    const t = norm(theta), half = G.S / 2;
    if (t < G.d || t > TAU - G.d) return { x: half, phase: 'rest', active: 'none', dx: 0 };
    if (t <= Math.PI - G.d) return { x: half - G.rp * (t - G.d), phase: 'lower', active: 'inferior', dx: -G.rp };
    if (t < Math.PI + G.d) return { x: -half, phase: 'rest', active: 'none', dx: 0 };
    return { x: -half + G.rp * (t - Math.PI - G.d), phase: 'upper', active: 'superior', dx: G.rp };
  }

  // Parametrização polar exata da involuta; as duas faces são espelhadas.
  function involutePoint(radius, side) {
    const t = Math.sqrt(Math.max(0, radius * radius / (G.rb * G.rb) - 1));
    const inv = t - Math.atan(t);
    const pitchT = Math.sqrt(G.rp * G.rp / (G.rb * G.rb) - 1);
    const pitchInv = pitchT - Math.atan(pitchT);
    const halfTooth = Math.PI / (2 * G.z) - 0.08 * G.m / (2 * G.rp);
    const angle = side * (halfTooth + pitchInv - inv);
    return [radius * Math.cos(angle), radius * Math.sin(angle)];
  }
  function toothPath() {
    const left = [], right = [];
    for (let i=0;i<=8;i++) { const r=G.rb+(G.ra-G.rb)*i/8; left.push(involutePoint(r,1)); right.push(involutePoint(r,-1)); }
    const polar=(r,a)=>[r*Math.cos(a),r*Math.sin(a)];
    const lRoot=polar(G.rf,Math.atan2(left[0][1],left[0][0]));
    const rRoot=polar(G.rf,Math.atan2(right[0][1],right[0][0]));
    const pts=[lRoot,...left,...right.reverse(),rRoot];
    return `M${pts.map(p=>p.map(n=>n.toFixed(2)).join(',')).join('L')}Z`;
  }
  function buildGear() {
    const d = toothPath();
    [-75,-45,-15,15,45,75].forEach(angle => $('gear-teeth').append(svgEl('path',{d,class:'gear-tooth',transform:`rotate(${angle})`})));
    $('gear').setAttribute('transform','translate(400 250)');
  }
  function rackToothPath(cx, upper) {
    const h=G.m, half=(G.p/4)-0.04*G.m, run=h*Math.tan(G.alpha), base=upper?180:320, tip=upper?base+h:base-h;
    return `M${cx-half-run},${base} L${cx-half},${tip} L${cx+half},${tip} L${cx+half+run},${base} Z`;
  }
  function buildRacks() {
    [-2,-1,0,1,2].forEach(i=>{ const cx=400+i*G.p; $('top-rack').append(svgEl('path',{d:rackToothPath(cx,true)})); $('bottom-rack').append(svgEl('path',{d:rackToothPath(cx,false)})); });
  }
  function buildChart() {
    let d=''; for(let i=0;i<=360;i++){const t=TAU*i/360, q=motion(t), px=45+690*i/360, py=85-q.x/(G.S/2)*65; d += `${i?'L':'M'}${px.toFixed(2)},${py.toFixed(2)}`;} $('motion-path').setAttribute('d',d);
  }
  let announcedPhase='';
  function render() {
    const t=norm(state.theta), q=motion(t), shift=q.x;
    $('gear').setAttribute('transform',`translate(400 250) rotate(${t*180/Math.PI})`);
    $('moving-frame').setAttribute('transform',`translate(${shift} 0)`);
    $('velocity').setAttribute('transform',q.phase==='lower'?'scale(-1 1) translate(-800 0)':'');
    $('velocity').style.opacity=q.phase==='rest'?'0':'1';
    const px=45+690*t/TAU, py=85-q.x/(G.S/2)*65;
    $('chart-cursor').setAttribute('x1',px); $('chart-cursor').setAttribute('x2',px); $('chart-dot').setAttribute('cx',px); $('chart-dot').setAttribute('cy',py);
    $('x-output').value=`x/m = ${q.x/G.m>=0?'+':'−'}${Math.abs(q.x/G.m).toFixed(2).replace('.',',')}`;
    const label=q.phase==='lower'?'ENGATE INFERIOR · CURSO PARA A ESQUERDA':q.phase==='upper'?'ENGATE SUPERIOR · CURSO PARA A DIREITA':'TRANSFERÊNCIA SEM CARGA · MOLDURA EM REPOUSO';
    if(label!==announcedPhase){$('engagement').textContent=label;announcedPhase=label;}
    if ($('debug-readout')) $('debug-readout').textContent=`θ ${(t*180/Math.PI).toFixed(1)}° · x ${(q.x/G.m).toFixed(3)}m · ${q.active}`;
  }
  function frame(now) { if(state.lastTime===null) state.lastTime=now; const dt=Math.min((now-state.lastTime)/1000,.1); state.lastTime=now; if(state.energized){state.theta=norm(state.theta+G.omega*dt);render();} requestAnimationFrame(frame); }
  function setEnergy(on) { if(state.energized===on)return; state.energized=on; const b=$('hold-button'); b.setAttribute('aria-pressed',String(on)); b.classList.toggle('is-pressed',on); $('electrical-state').textContent=on?'● CONTATO FECHADO · MOTOR ENERGIZADO':'○ CONTATO ABERTO · MOTOR DESENERGIZADO'; }
  function bindControl() {
    const b=$('hold-button');
    b.addEventListener('pointerdown',e=>{e.preventDefault();state.pointerId=e.pointerId;b.setPointerCapture(e.pointerId);setEnergy(true);});
    const release=e=>{if(state.pointerId===null||!e||e.pointerId===state.pointerId){state.pointerId=null;setEnergy(state.keys.size>0);}};
    ['pointerup','pointercancel','lostpointercapture'].forEach(type=>b.addEventListener(type,release));
    const relevant=e=>e.code==='Space'||e.code==='Enter';
    b.addEventListener('keydown',e=>{if(relevant(e)){e.preventDefault();state.keys.add(e.code);setEnergy(true);}});
    b.addEventListener('keyup',e=>{if(relevant(e)){e.preventDefault();state.keys.delete(e.code);setEnergy(state.pointerId!==null||state.keys.size>0);}});
    const stop=()=>{state.pointerId=null;state.keys.clear();setEnergy(false);};
    window.addEventListener('blur',stop); window.addEventListener('pointerup',release); document.addEventListener('visibilitychange',()=>{if(document.hidden)stop();});
  }
  if(new URLSearchParams(location.search).get('debug')==='1') document.documentElement.classList.add('debug');
  buildGear();buildRacks();buildChart();bindControl();render();requestAnimationFrame(frame);
  window.Mechanism114={G,state,motion,norm,toothPath,render,setEnergy};
})();
