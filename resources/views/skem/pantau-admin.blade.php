@php
    $items = $submissions instanceof \Illuminate\Pagination\AbstractPaginator
        ? $submissions->getCollection()
        : collect($submissions ?? []);

    $payload = $items->map(function ($s) {
        $student = $s->student;
        $form    = $s->attachments->where('attachment_type', 'formulir_pdf')->first();
        return [
            'id'          => (string) $s->id,
            'regNo'       => $s->registration_number,
            'tgl'         => optional($s->created_at)->toISOString(),
            'nama'        => $student->name ?? 'Mahasiswa',
            'nrp'         => $student->nrp ?? '-',
            'prodi'       => $student->studyProgram->name ?? '-',
            'dept'        => $student->studyProgram->department->name ?? '-',
            'komponen'    => (int) $s->component,
            'jenis'       => $s->activity_name,
            'peran'       => $s->role,
            'poin'        => number_format((float) $s->points, 2, ',', '.'),
            'status'      => $s->status,
            'catatan'     => $s->admin_note ?? '',
            'bukti_count' => $s->attachments->count(),
            'formulir'    => $form->original_name ?? '-',
            'files'       => $s->attachments->map(fn ($f) => [
                'nama'  => $f->original_name ?? basename((string) $f->file_path),
                'jenis' => $f->attachment_type === 'formulir_pdf' ? 'Formulir' : 'Bukti kegiatan',
                'url'   => route('skem.berkas', $f->id),
            ])->values(),
            'riwayat'     => $s->logs->sortBy('created_at')->map(fn ($l) => [
                't' => optional($l->created_at)->toISOString(),
                's' => $l->status_to,
                'n' => $l->note ?? '',
            ])->values(),
        ];
    })->values();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow">
<title>Dashboard Admin – Pengajuan SKEM</title>
@include('partials.favicon')
@vite(['resources/css/skem/pantau-admin.css'])
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
</defs></svg>

<header class="top">
  <div class="meteors" aria-hidden="true"></div>
  <div class="w">
    <div class="topbar">
      <a class="brand" href="{{ route('skem.index') }}"><i><img src="{{ asset('images/logo-pens.svg') }}" alt="" width="36" height="36"></i><span><b>SKEM PENS</b><small>Satuan Kredit Ekstrakurikuler</small></span></a>
      <div class="tb-r">
        <span class="logo-admin">Admin</span>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">
          @csrf
          <button class="btn out" type="submit">Keluar</button>
        </form>
      </div>
    </div>
    <div class="hrow">
      <div>
        <h1>Dashboard <span class="ad-txt">Admin</span></h1>
        <p>Kelola dan verifikasi seluruh pengajuan klaim poin SKEM.</p>
      </div>
      <div class="acts">
        <button class="btn" id="btnCsv" type="button">Unduh CSV</button>
        <a href="{{ route('skem.index') }}" class="btn">Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</header>

<main class="w">
  <section class="sum" id="sum" aria-label="Ringkasan"></section>

  <section class="panel">
    <div class="ph"><h2>Daftar pengajuan</h2><small id="jumlah"></small></div>

    <div class="tabs" id="tabs" role="tablist">
      <button type="button" class="tab on" data-tab="proses" role="tab" aria-selected="true">
        Dalam Proses <span class="tc" id="tcProses">0</span>
      </button>
      <button type="button" class="tab" data-tab="selesai" role="tab" aria-selected="false">
        Selesai <span class="tc" id="tcSelesai">0</span>
      </button>
    </div>

    <div class="chips" id="chips"></div>
    <div class="bar">
      <label class="search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        <input id="q" type="search" placeholder="Cari nama, NRP, atau jenis kegiatan…" autocomplete="off" aria-label="Cari"></label>
      <select id="fKomp" aria-label="Filter komponen">
        <option value="">Semua komponen</option><option value="1">Kredit 1</option><option value="2">Kredit 2</option><option value="3">Kredit 3</option>
      </select>
      <select id="fSort" aria-label="Urutkan">
        <option value="new">Terbaru</option><option value="old">Terlama</option><option value="poin">Poin tertinggi</option>
      </select>
    </div>
    <div class="tw">
      <table>
        <thead><tr><th>ID</th><th>Tanggal</th><th>Mahasiswa</th><th>Kegiatan</th><th>Poin</th><th>Status</th><th></th></tr></thead>
        <tbody id="tb"></tbody>
      </table>
    </div>
    <div class="empty" id="empty" hidden>
      <div class="ill"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/></svg></div>
      <p id="emptyMsg">Belum ada pengajuan dalam kategori ini.</p>
    </div>
  </section>
</main>

<div class="foot">Dashboard admin SKEM terhubung dengan Database Laravel 12 &amp; MySQL.</div>

<div class="ov" id="ov" hidden>
  <div class="mdl" role="dialog" aria-modal="true" aria-labelledby="mTitle">
    <button class="x" id="mx" type="button" aria-label="Tutup">×</button>
    <div id="mb"></div>
  </div>
</div>
<div id="toast" role="status"></div>

<script>
// Data diambil langsung dari database Laravel
let data = @json($payload);
const STATUS_URL = @json(url('/admin/submission'));
const ST={
  diajukan:{label:'Diajukan',cls:'s-blue',c:'#174679'},
  verifikasi:{label:'Verifikasi',cls:'s-amber',c:'#e0a100'},
  validasi:{label:'Validasi',cls:'s-violet',c:'#5b3aa0'},
  acc:{label:'Disetujui (ACC)',cls:'s-green',c:'#12703a'},
  tolak:{label:'Ditolak',cls:'s-red',c:'#b3261e'}
};
const STEPS=[['diajukan','Diajukan'],['verifikasi','Verifikasi'],['validasi','Validasi'],['acc','Disetujui']];
const NEXT={diajukan:'verifikasi',verifikasi:'validasi',validasi:'acc'};
const NEXT_LBL={verifikasi:'Mulai verifikasi',validasi:'Teruskan ke validasi',acc:'Setujui (ACC)'};
const KOMP={1:'Kredit 1',2:'Kredit 2',3:'Kredit 3'};
const STAGE={
  diajukan:{step:1,totalSteps:3,next:'verifikasi',nextLbl:'Verifikasi',badTo:'tolak',badLbl:'Tolak pengajuan',
    ok:['Berkas formulir lengkap dan sesuai.','Identitas sesuai KTM.','Bukti kegiatan sudah dilampirkan.'],
    bad:['Berkas formulir belum lengkap.','Formulir belum ditandatangani verifikator.','Nama atau NRP tidak sesuai KTM.','Formulir PDF tidak terbaca.']},
  verifikasi:{step:2,totalSteps:3,next:'validasi',nextLbl:'Validasi',badTo:'tolak',badLbl:'Tolak pengajuan',
    ok:['Bukti kegiatan sah dan sesuai jenis kegiatan.','Peran dan perolehan sesuai bukti.'],
    bad:['Sertifikat tidak terbaca, mohon unggah ulang.','Bukti tidak sesuai jenis kegiatan.','Tanggal kegiatan tidak tercantum pada bukti.']},
  validasi:{step:3,totalSteps:3,next:'acc',nextLbl:'Disetujui (ACC)',badTo:'tolak',badLbl:'Tolak pengajuan',
    ok:['Poin sesuai pedoman SKEM PENS.','Komponen dapat diklaim.'],
    bad:['Poin tidak sesuai pedoman SKEM PENS.','Kegiatan tidak termasuk komponen yang dapat diklaim.','Kegiatan melewati batas 1 tahun sejak pelaksanaan.','Kuota poin komponen sudah terpenuhi.']},
};
const ICON={
  p:'<path d="M12 2L3 7l9 5 9-5-9-5z"/><path d="M3 12l9 5 9-5"/><path d="M3 17l9 5 9-5"/>',
  v:'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
  g:'<circle cx="12" cy="12" r="9"/><path d="M8.5 12.5l2.5 2.5 5-5.5"/>',
  o:'<path d="M4 20h4L19 9l-4-4L4 16v4z"/><path d="M13.5 6.5l4 4"/>',
  r:'<circle cx="12" cy="12" r="9"/><path d="M9 9l6 6M15 9l-6 6"/>',
  m:'<circle cx="12" cy="9" r="6"/><path d="M8.5 14L7 21l5-2.5L17 21l-1.5-7"/>'
};

const $=id=>document.getElementById(id);
const esc=s=>String(s??'').replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
const pNum=p=>parseFloat(String(p).replace(',','.'))||0;
const fmtP=n=>n.toFixed(2).replace('.',',');
const fmtDate=iso=>new Date(iso).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});
const fmtTime=iso=>new Date(iso).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
const initials=n=>String(n||'?').trim().split(/\s+/).slice(0,2).map(w=>w[0]).join('').toUpperCase();
const badge=s=>`<span class="badge ${ST[s]?ST[s].cls:''}">${esc(ST[s]?ST[s].label:s)}</span>`;
const card=(c,l,v,ic)=>`<div class="st ${c}"><span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true">${ICON[ic]}</svg></span><div><small>${l}</small><b>${v}</b></div></div>`;

let openId=null, tm, activeTab='proses';
const TAB_PROSES=['diajukan','verifikasi','validasi'];
const TAB_SELESAI=['acc','tolak'];
function toast(m){const t=$('toast');t.textContent=m;t.classList.add('on');clearTimeout(tm);tm=setTimeout(()=>t.classList.remove('on'),2400);}

function progress(x){
  if(x.status==='tolak') return '';
  const idx=STEPS.findIndex(([k])=>k===x.status);
  return `<div class="prog">${STEPS.map(([k,l],i)=>{
    const cls=(x.status==='acc'||i<idx)?'done':(i===idx?'cur':'');
    const inner=cls==='done'?'<svg viewBox="0 0 24 24"><path d="M5 12l5 5 9-10"/></svg>':(i+1);
    return `<div class="pst ${cls}"><div class="dot">${inner}</div><div class="lb">${l}</div></div>`;
  }).join('')}</div>`;
}
function banner(x){
  if(x.status==='acc') return `<div class="alert ok"><svg viewBox="0 0 24 24"><path d="M5 12l5 5 9-10"/></svg><div><b>Pengajuan disetujui</b>Poin ${esc(x.poin)} sudah tercatat sebagai klaim SKEM.</div></div>`;
  if(x.status==='tolak') return `<div class="alert tol"><svg viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg><div><b>Pengajuan ditolak</b>${esc(x.catatan||'Pengajuan tidak memenuhi ketentuan.')}</div></div>`;
  const t=x.status==='diajukan'?'menunggu verifikasi':x.status==='verifikasi'?'sedang diverifikasi':'sedang divalidasi';
  return `<div class="alert run"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><div><b>Sedang diproses</b>Pengajuan ini ${t}.</div></div>`;
}
function timeline(x){
  return `<div class="sec">Riwayat status</div><ul class="tl">${x.riwayat.map(r=>{
    const st=ST[r.s]?ST[r.s].label:r.s, c=ST[r.s]?ST[r.s].c:'#2b6cb0';
    return `<li style="--c:${c}"><b>${esc(st)}</b><span class="tm">${fmtDate(r.t)} · ${fmtTime(r.t)}</span>${r.n&&r.n!==st?`<span class="nt">${esc(r.n)}</span>`:''}</li>`;
  }).join('')}</ul>`;
}


function renderStats(){
  const cnt=k=>data.filter(x=>x.status===k).length, total=data.length;
  const proses=TAB_PROSES.reduce((a,k)=>a+cnt(k),0);
  const selesai=TAB_SELESAI.reduce((a,k)=>a+cnt(k),0);
  const poin=data.filter(x=>x.status==='acc').reduce((a,x)=>a+pNum(x.poin),0);
  $('sum').innerHTML=
    card('p','Total',total,'p')+
    card('v','Dalam proses',proses,'v')+
    card('g','ACC',cnt('acc'),'g')+
    card('r','Ditolak',cnt('tolak'),'r')+
    card('m','Poin disetujui',fmtP(poin),'m');
  // update tab counters
  $('tcProses').textContent=proses;
  $('tcSelesai').textContent=selesai;
  // chips: hanya tampilkan status yang relevan dengan tab aktif
  const tabKeys=activeTab==='proses'?TAB_PROSES:TAB_SELESAI;
  const cur=$('chips').dataset.cur||'';
  // reset chip jika tidak sesuai tab
  if(cur&&!tabKeys.includes(cur)) $('chips').dataset.cur='';
  const curNow=$('chips').dataset.cur||'';
  $('chips').innerHTML=[['','Semua',tabKeys.reduce((a,k)=>a+cnt(k),0),'#174679']]
    .concat(tabKeys.map(k=>[k,ST[k].label,cnt(k),ST[k].c]))
    .map(([k,l,n,c])=>`<button type="button" class="chip${curNow===k?' on':''}" data-st="${k}" style="--c:${c}"><i></i>${esc(l)} <span>${n}</span></button>`).join('');
}
function filtered(){
  const q=$('q').value.trim().toLowerCase(), fs=$('chips').dataset.cur||'', fk=$('fKomp').value, so=$('fSort').value;
  const tabKeys=activeTab==='proses'?TAB_PROSES:TAB_SELESAI;
  let arr=data.filter(x=>{
    if(!tabKeys.includes(x.status)) return false;
    if(fs&&x.status!==fs) return false;
    if(fk&&String(x.komponen)!==fk) return false;
    if(q&&![x.nama,x.nrp,x.jenis,x.regNo,x.prodi].some(v=>String(v||'').toLowerCase().includes(q))) return false;
    return true;
  });
  if(so==='new') arr.sort((a,b)=>b.tgl.localeCompare(a.tgl));
  else if(so==='old') arr.sort((a,b)=>a.tgl.localeCompare(b.tgl));
  else arr.sort((a,b)=>pNum(b.poin)-pNum(a.poin));
  return arr;
}
function renderTable(){
  const rows=filtered();
  const tabTotal=(activeTab==='proses'?TAB_PROSES:TAB_SELESAI).reduce((a,k)=>a+data.filter(x=>x.status===k).length,0);
  const isEmpty=tabTotal===0;
  $('empty').hidden=!isEmpty;
  if(isEmpty) $('emptyMsg').textContent=activeTab==='selesai'?'Belum ada pengajuan yang selesai.':'Belum ada pengajuan yang sedang diproses.';
  $('jumlah').textContent=rows.length+(rows.length!==tabTotal?' dari '+tabTotal:'')+' pengajuan';
  const body=rows.map(x=>`
    <tr data-id="${esc(x.id)}">
      <td class="mono nd" data-label="ID">${esc(x.regNo)}</td>
      <td data-label="Tanggal">${fmtDate(x.tgl)}</td>
      <td class="who-cell" data-label="Mahasiswa"><div class="who"><span class="av">${esc(initials(x.nama))}</span><div class="who-t"><b class="who-nama" title="${esc(x.nama)}">${esc(x.nama)}</b><div class="who-meta"><span class="nrp-chip">${esc(x.nrp)}</span><span class="jur" title="${esc(x.prodi)}">${esc(x.prodi)}</span></div></div></div></td>
      <td class="kg-cell" data-label="Kegiatan"><div class="kg"><b>${esc(x.jenis)}</b><small>${KOMP[x.komponen]||''} · ${esc(x.peran)}</small></div></td>
      <td data-label="Poin"><span class="poin">${esc(x.poin)}<small>poin</small></span>${badge(x.status)}</td>
      <td data-label="Status" class="td-status-desk">${badge(x.status)}</td>
      <td class="act-cell"><button class="btn g sm" type="button" data-open="${esc(x.id)}">Kelola</button></td>
    </tr>`).join('');
  $('tb').innerHTML=body||(data.length?`<tr><td colspan="7" class="empty">Tidak ada pengajuan yang cocok dengan filter.</td></tr>`:'');
}
function renderAll(){renderStats();renderTable();}

function docsSection(x){
  const f=x.files||[];
  const rows=f.length?f.map(d=>`<a class="doc-row" href="${esc(d.url)}" target="_blank" rel="noopener"><span class="doc-tag">${esc(d.jenis)}</span><span class="doc-name">${esc(d.nama)}</span><span class="doc-open">Buka</span></a>`).join(''):'<p class="m-note">Tidak ada dokumen terlampir.</p>';
  return `<div class="m-sec">Dokumen lampiran (${f.length})</div><div class="doc-list">${rows}</div>`;
}
function openModal(id){
  const x=data.find(d=>String(d.id)===String(id)); if(!x) return;
  openId=id;
  const next=NEXT[x.status];
  const canAct=!['acc','tolak'].includes(x.status);
  const cell=(l,v,cls='')=>`<div class="dcell ${cls}"><span>${l}</span><div>${v}</div></div>`;
  $('mb').innerHTML=`
    <div class="m-head">
      <span class="av av-lg">${esc(initials(x.nama))}</span>
      <div class="m-title">
        <h3 id="mTitle">${esc(x.nama)}</h3>
        <div class="m-sub"><span class="mono">${esc(x.regNo)}</span><span class="dot-sep"></span><span class="mono">NRP ${esc(x.nrp)}</span></div>
      </div>
      <div class="m-badge">${badge(x.status)}</div>
    </div>

    ${banner(x)}

    <div class="m-card">
      <div class="m-card-h">Progres pengajuan</div>
      ${progress(x)||'<p class="m-note">Pengajuan dikembalikan atau ditolak, progres tidak berjalan.</p>'}
    </div>

    <div class="m-sec">Data mahasiswa</div>
    <div class="dgrid">
      ${cell('Program studi', esc(x.prodi),'full')}
      ${cell('Departemen', esc(x.dept),'full')}
    </div>

    <div class="m-sec">Data kegiatan</div>
    <div class="dgrid">
      ${cell('Jenis kegiatan', esc(x.jenis),'full')}
      ${cell('Peran / perolehan', esc(x.peran))}
      ${cell('Komponen', KOMP[x.komponen]||'-')}
      ${cell('Estimasi poin', `<span class="pt-big">${esc(x.poin)}</span>`)}
      ${cell('Tanggal pengajuan', fmtDate(x.tgl))}
    </div>

    ${docsSection(x)}

    <div class="m-sec">Riwayat status</div>
    ${timeline(x).replace(/<div class="sec">.*?<\/div>/,'')}

    ${STAGE[x.status]?(()=>{
      const st=STAGE[x.status];
      const hasStep=st.step!==null;
      const stepBadge=hasStep?`<span class="step-badge">Tahap ${st.step}/${st.totalSteps}</span>`:'';
      const nextHeader=`Lanjut ke ${st.nextLbl}`;
      return `
    <div class="act-panel">
      <div class="act-title">Pilih catatan untuk melanjutkan ${stepBadge}</div>
      <div class="opt-cols">
        <div class="opt-col ok">
          <div class="oc-h"><i></i>${nextHeader}</div>
          ${st.ok.map(o=>`<button type="button" class="opt-btn" data-pick="${st.next}" data-opt="${esc(o)}">${esc(o)}</button>`).join('')}
        </div>
        <div class="opt-col bad">
          <div class="oc-h"><i></i>${st.badLbl}</div>
          ${st.bad.map(o=>`<button type="button" class="opt-btn" data-pick="${st.badTo}" data-opt="${esc(o)}">${esc(o)}</button>`).join('')}
        </div>
      </div>
    </div>`;})():`<div class="final">Pengajuan ini sudah berstatus final.</div>`}`;
  $('ov').hidden=false;
}
function closeModal(){$('ov').hidden=true;openId=null;}
async function changeStatus(id,to,note){
  const x=data.find(d=>String(d.id)===String(id)); if(!x) return;
  const fallback={tolak:'Pengajuan tidak memenuhi ketentuan.',diajukan:'Diajukan ulang oleh mahasiswa',verifikasi:'Lolos pemeriksaan kelengkapan',validasi:'Bukti kegiatan telah diverifikasi',acc:'Data sesuai dan disetujui'};
  const text=(note||'').trim()||fallback[to]||'';
  try{
    toast('Memperbarui status...');
    const r=await fetch(`${STATUS_URL}/${id}/status`,{
      method:'POST',
      headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
      body:JSON.stringify({status:to,note:text})
    });
    // Sesi login berakhir (401) atau token CSRF kedaluwarsa (419)
    if(r.status===401||r.status===419){
      toast('Sesi berakhir. Memuat ulang...');
      setTimeout(()=>location.reload(),900);
      return;
    }
    const res=await r.json();
    if(!r.ok||!res.success) throw new Error('gagal');
    x.status=to;
    x.catatan=(to==='tolak')?text:'';
    x.riwayat.push({t:new Date().toISOString(),s:to,n:text});
    if(TAB_SELESAI.includes(to)){
      closeModal(); setTab('selesai'); renderAll();
      toast('Status → '+ST[to].label+'. Pengajuan dipindah ke tab Selesai.');
    }else{
      setTab('proses'); renderAll(); openModal(id);
      toast('Status → '+ST[to].label+'.');
    }
  }catch(err){
    toast('Gagal memperbarui status ke server.');
  }
}
function exportCsv(){
  if(!data.length){toast('Belum ada data untuk diunduh.');return;}
  const head=['ID','Tanggal','Nama','NRP','Prodi','Departemen','Komponen','Jenis','Peran','Poin','Status','Catatan'];
  const q=v=>'"'+String(v??'').replace(/"/g,'""')+'"';
  const rows=data.map(x=>[x.regNo,fmtDate(x.tgl),x.nama,x.nrp,x.prodi,x.dept,KOMP[x.komponen]||'',x.jenis,x.peran,x.poin,ST[x.status]?ST[x.status].label:x.status,x.catatan].map(q).join(','));
  const blob=new Blob(['\ufeff'+[head.map(q).join(',')].concat(rows).join('\n')],{type:'text/csv;charset=utf-8'});
  const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download='pengajuan-skem.csv'; a.click();
  setTimeout(()=>URL.revokeObjectURL(a.href),1000);
}

function setTab(t){
  activeTab=t;
  $('chips').dataset.cur='';
  document.querySelectorAll('#tabs .tab').forEach(b=>{
    const on=b.dataset.tab===t;
    b.classList.toggle('on',on);
    b.setAttribute('aria-selected',on);
  });
}

/* event */
$('tabs').addEventListener('click',e=>{
  const b=e.target.closest('[data-tab]'); if(!b) return;
  setTab(b.dataset.tab); renderAll();
});
$('tb').addEventListener('click',e=>{const tr=e.target.closest('tr[data-id]'); if(tr) openModal(tr.dataset.id);});
$('mb').addEventListener('click',e=>{
  const pk=e.target.closest('[data-pick]');
  if(pk&&openId){ changeStatus(openId,pk.dataset.pick,pk.dataset.opt); return; }
  const a=e.target.closest('[data-act]'); if(a&&openId){ changeStatus(openId,a.dataset.act,''); return; }
});
$('mx').addEventListener('click',closeModal);
$('ov').addEventListener('click',e=>{if(e.target===$('ov')) closeModal();});
document.addEventListener('keydown',e=>{if(e.key==='Escape'&&!$('ov').hidden) closeModal();});
$('chips').addEventListener('click',e=>{
  const c=e.target.closest('[data-st]'); if(!c) return;
  $('chips').dataset.cur=c.dataset.st; renderAll();
});
['q','fKomp','fSort'].forEach(id=>$(id).addEventListener(id==='q'?'input':'change',renderAll));
$('btnCsv').addEventListener('click',exportCsv);

/* meteor */
(function(){
  var box=document.querySelector('.meteors');
  if(!box||(window.matchMedia&&matchMedia('(prefers-reduced-motion:reduce)').matches))return;
  var n=window.innerWidth<600?7:14;
  for(var k=0;k<n;k++){
    var m=document.createElement('i');
    m.style.left=(Math.random()*125-5)+'%';
    m.style.height=(45+Math.random()*70)+'px';
    m.style.setProperty('--o',(.25+Math.random()*.4).toFixed(2));
    m.style.animationDuration=(2.6+Math.random()*3)+'s';
    m.style.animationDelay=(-Math.random()*6)+'s';
    box.appendChild(m);
  }
})();

renderAll();
</script>
</body>
</html>