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
<style>
:root{--b:#174679;--b2:#0b2a4d;--b3:#2b6cb0;--y:#f6c90e;--bg:#f2f6fc;--l:#e1e8f2;--ink:#0b1b2e;--mute:#5a6f88;--ok:#12703a;--okbg:#e6f6ec;--bad:#b3261e;--badbg:#fdeceb;--warn:#8a4b00;--warnbg:#fff6e0}
*{box-sizing:border-box}
[hidden]{display:none!important}
html{-webkit-text-size-adjust:100%}
body{margin:0;background:var(--bg);color:var(--ink);font:15px/1.55 "Segoe UI",system-ui,-apple-system,Roboto,Arial,sans-serif;-webkit-font-smoothing:antialiased;min-height:100vh}
button,input,select,textarea{font:inherit;color:inherit}
button{cursor:pointer}
:focus-visible{outline:3px solid var(--b3);outline-offset:2px;border-radius:8px}
.w{max-width:1180px;margin:0 auto;padding:0 20px}
.mono{font-family:ui-monospace,Consolas,monospace;font-size:12.5px;color:var(--mute)}

/* ---------- header ---------- */
.topbar{display:flex;align-items:center;gap:12px}
.tb-r{margin-left:auto;display:flex;align-items:center;gap:8px}
.logo-admin{display:inline-flex;align-items:center;gap:7px;height:38px;padding:0 15px;border-radius:99px;background:#ffffff1f;border:1px solid #ffffff40;color:#fff;font-size:12px;font-weight:800;letter-spacing:.8px;text-transform:uppercase;line-height:1;white-space:nowrap}
.logo-admin:before{content:"";width:8px;height:8px;border-radius:50%;background:var(--y);box-shadow:0 0 0 3px #f6c90e33}
.topbar .btn.out{height:38px;padding:0 18px;border-radius:99px;background:#fff;color:var(--b);border:1px solid #fff;font-size:13px;font-weight:800;line-height:1;box-shadow:0 6px 14px #0b2a4d33;transition:transform .15s,box-shadow .15s,background .15s}
.topbar .btn.out:hover{background:#eef4fb;color:var(--b2);transform:translateY(-1px);box-shadow:0 10px 18px #0b2a4d40}
.topbar .btn.out:active{transform:scale(.97)}
.top{background:radial-gradient(800px 320px at 92% -30%,#2f74bd66,transparent 60%),linear-gradient(165deg,var(--b2),var(--b));color:#fff;padding:20px 0 96px;position:relative;overflow:hidden}
.brand{display:inline-flex;align-items:center;gap:12px;color:#fff;text-decoration:none}
.brand i{width:40px;height:40px;border-radius:12px;background:var(--y);color:#10233b;display:grid;place-items:center;font-style:normal;font-weight:900;box-shadow:0 6px 16px #00000033}
.brand b{display:block;font-size:17px;font-weight:800;letter-spacing:.8px;line-height:1.1}
.brand small{font-size:12px;color:#bcd3ee}
.hrow{margin-top:26px;display:flex;align-items:flex-end;justify-content:space-between;gap:18px;flex-wrap:wrap}
.hrow h1{margin:0;font-size:clamp(26px,3.4vw,34px);font-weight:800;letter-spacing:-.5px;line-height:1.15}
.hrow p{margin:6px 0 0;color:#cfe0f5;font-size:14.5px}
.tag{display:inline-flex;align-items:center;gap:6px;font-size:11.5px;font-weight:800;letter-spacing:.6px;text-transform:uppercase;padding:6px 12px;border-radius:99px;background:var(--y);color:#10233b;margin-bottom:10px}
.acts{display:flex;gap:8px;flex-wrap:wrap}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:1px solid #ffffff4d;background:#ffffff1a;color:#fff;border-radius:11px;padding:9px 15px;font-size:13.5px;font-weight:700;text-decoration:none;transition:background .15s,transform .15s,border-color .15s;white-space:nowrap}
.btn:hover{background:#ffffff2e}
.btn:active{transform:scale(.98)}
.btn.y{background:var(--y);color:#10233b;border-color:var(--y);box-shadow:0 8px 18px #f6c90e40}
.btn.y:hover{background:#ffd93a}
.btn.dk{background:var(--b);color:#fff;border-color:var(--b)}
.btn.dk:hover{background:var(--b2)}
.btn.o{background:#fff;color:var(--ink);border:1.5px solid var(--l)}
.btn.o:hover{border-color:var(--b3)}
.btn.g{background:#fff;color:var(--b);border:1.5px solid var(--l)}
.btn.g:hover{border-color:var(--b3);background:#f5f9ff}
.btn.r{background:var(--badbg);color:var(--bad);border:1.5px solid #f3c6c2}
.btn.r:hover{background:#f8d7d4}
.btn.w{background:var(--warnbg);color:var(--warn);border:1.5px solid #f0dc8a}
.btn.w:hover{background:#ffefc2}
.btn.sm{padding:7px 13px;font-size:13px}
.btn:disabled{opacity:.5;cursor:not-allowed}
.btn.icon{padding:9px 13px}

/* ---------- ringkasan ---------- */
.sum{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin:-64px 0 22px;position:relative;z-index:2}
.st{background:#fff;border:1px solid var(--l);border-radius:18px;padding:16px 16px;display:flex;flex-direction:column;gap:12px;box-shadow:0 10px 24px rgba(11,42,77,.08);transition:transform .2s,box-shadow .2s;min-width:0}
.st:hover{transform:translateY(-2px);box-shadow:0 14px 28px rgba(11,42,77,.12)}
.st .ic{width:44px;height:44px;border-radius:14px;display:grid;place-items:center;flex:none;background:linear-gradient(150deg,var(--ib),#ffffff);color:var(--ic);box-shadow:inset 0 0 0 1px var(--ib),0 4px 10px -4px var(--ic)}
.st .ic svg{width:22px;height:22px;stroke:currentColor;fill:none;stroke-width:2.1;stroke-linecap:round;stroke-linejoin:round}
.st:hover .ic{transform:scale(1.06)}
.st .ic{transition:transform .2s}
.st small{font-size:11.5px;font-weight:700;color:var(--mute);text-transform:uppercase;letter-spacing:.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.st b{display:block;font-size:24px;font-weight:800;line-height:1;font-variant-numeric:tabular-nums;margin-top:4px}
.st.p{--ib:#e8f0fb;--ic:#174679}.st.v{--ib:#f1ecfb;--ic:#5b3aa0}.st.g{--ib:#e6f6ec;--ic:#12703a}.st.o{--ib:#fdf0e6;--ic:#d9731a}.st.r{--ib:#fdeceb;--ic:#b3261e}.st.m{--ib:#fff6e0;--ic:#8a4b00}

/* ---------- tab ---------- */
.tabs{display:flex;gap:4px;margin-bottom:18px;background:#f0f4f9;border-radius:14px;padding:4px}
.tab{flex:1;border:0;background:transparent;border-radius:10px;padding:9px 16px;font-size:13.5px;font-weight:700;color:var(--mute);cursor:pointer;transition:.15s;display:flex;align-items:center;justify-content:center;gap:7px}
.tab .tc{font-size:12px;font-weight:800;background:#dde5f0;color:var(--mute);border-radius:99px;padding:1px 8px;min-width:22px;text-align:center;transition:.15s}
.tab.on{background:#fff;color:var(--ink);box-shadow:0 2px 8px rgba(11,42,77,.1)}
.tab.on .tc{background:var(--b);color:#fff}
.tab:hover:not(.on){background:#e8edf5;color:var(--ink)}

/* ---------- panel ---------- */
.panel{background:#fff;border:1px solid var(--l);border-radius:20px;padding:22px;box-shadow:0 10px 26px rgba(11,42,77,.07);margin-bottom:24px}
.ph{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px}
.ph h2{margin:0;font-size:18px;letter-spacing:-.3px}
.ph small{color:var(--mute);font-size:13px}
.chips{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px}
.chip{border:1.5px solid var(--l);background:#fff;color:var(--mute);border-radius:99px;padding:6px 13px;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:7px;transition:.15s}
.chip i{width:8px;height:8px;border-radius:50%;background:var(--c)}
.chip span{background:#f0f4f9;color:var(--mute);border-radius:99px;padding:0 8px;font-size:12px;min-width:22px;text-align:center}
.chip:hover{border-color:var(--b3);color:var(--b)}
.chip.on{background:var(--b);border-color:var(--b);color:#fff}
.chip.on i{background:#fff}
.chip.on span{background:#ffffff33;color:#fff}
.bar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px}
.search{flex:1;min-width:220px;position:relative;display:block}
.search svg{position:absolute;left:13px;top:50%;transform:translateY(-50%);width:18px;height:18px;stroke:var(--mute);fill:none;stroke-width:2;stroke-linecap:round}
.bar input[type=search]{width:100%;padding:10px 13px 10px 40px;border:1.5px solid var(--l);border-radius:12px;background:#fff;font-size:14.5px}
.bar select{padding:10px 12px;border:1.5px solid var(--l);border-radius:12px;background:#fff;font-size:14px;cursor:pointer}
input:focus,select:focus,textarea:focus{outline:0;border-color:var(--b3)!important;box-shadow:0 0 0 3px rgba(43,108,176,.15)}

/* badge duplikat untuk mobile card */
td[data-label="Poin"] .badge{display:none}
@media(max-width:760px){
  td[data-label="Poin"] .badge{display:inline-flex}
  .td-status-desk{display:none}
}

/* ---------- tabel ---------- */
.tw{border:1px solid var(--l);border-radius:16px;overflow:auto;max-height:620px}
table{width:100%;border-collapse:separate;border-spacing:0;min-width:900px}
thead th{position:sticky;top:0;z-index:2;background:#f7f9fc;color:var(--mute);font-size:11px;text-transform:uppercase;letter-spacing:.6px;text-align:left;padding:12px 16px;font-weight:700;border-bottom:1px solid var(--l)}
td{padding:14px 16px;border-bottom:1px solid #eef2f7;vertical-align:middle;font-size:14px}
tbody tr{cursor:pointer;transition:background .15s,box-shadow .15s}
tbody tr:hover{background:#f6faff;box-shadow:inset 3px 0 0 var(--b3)}
tbody tr:last-child td{border-bottom:0}
.who{display:flex;align-items:center;gap:12px;min-width:0;max-width:380px}
.who-t{min-width:0;flex:1}
.who-nama{display:block;font-size:14.5px;font-weight:700;line-height:1.3;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.who-meta{display:flex;flex-direction:column;align-items:flex-start;gap:4px;margin-top:4px;min-width:0}
.nrp-chip{flex:none;font-family:ui-monospace,Consolas,monospace;font-size:11.5px;font-weight:700;color:var(--b);background:#eef4fb;border:1px solid #d6e4f5;border-radius:6px;padding:1px 7px;letter-spacing:.3px;font-variant-numeric:tabular-nums}
.jur{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;font-size:12.5px;line-height:1.4;color:var(--mute);min-width:0;max-width:100%}
.av{width:38px;height:38px;border-radius:12px;background:linear-gradient(150deg,#dbe8f8,#c3d8f1);color:var(--b);display:grid;place-items:center;font-weight:800;font-size:13px;flex:none}
.who small,.kg small{color:var(--mute);font-size:12.5px}
.kg b{display:block;font-weight:600}
.poin{display:inline-flex;align-items:baseline;gap:3px;background:#eef4fb;color:var(--b);padding:4px 10px;border-radius:9px;font-weight:800;white-space:nowrap;font-variant-numeric:tabular-nums}
.poin small{font-size:11px;font-weight:700;color:var(--mute)}
.badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:99px;font-size:12.5px;font-weight:700;white-space:nowrap}
.badge:before{content:"";width:7px;height:7px;border-radius:50%;background:currentColor}
.s-blue{background:#e8f0fb;color:#174679}.s-amber{background:#fff6e0;color:#8a4b00}.s-violet{background:#f1ecfb;color:#5b3aa0}.s-green{background:var(--okbg);color:var(--ok)}.s-orange{background:#fdf0e6;color:#9a4a0a}.s-red{background:var(--badbg);color:var(--bad)}
.empty{text-align:center;padding:44px 20px;color:var(--mute)}
.empty .ill{width:60px;height:60px;border-radius:20px;background:#eef4fb;display:grid;place-items:center;margin:0 auto 12px;color:var(--b3)}
.empty .ill svg{width:28px;height:28px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.empty p{margin:0 0 14px}
.foot{text-align:center;color:var(--mute);font-size:12.5px;padding:0 0 36px}

/* ---------- modal ---------- */
.ov{position:fixed;inset:0;background:rgba(11,26,45,.55);backdrop-filter:blur(5px);display:grid;place-items:center;padding:20px;z-index:100;animation:fadeOv .2s ease}
@keyframes fadeOv{from{opacity:0}to{opacity:1}}
@keyframes popIn{from{opacity:0;transform:translateY(14px) scale(.98)}to{opacity:1;transform:none}}
.mdl{background:#fff;border-radius:24px;max-width:760px;width:100%;max-height:90vh;overflow:auto;padding:28px;position:relative;box-shadow:0 30px 60px rgba(0,0,0,.25);animation:popIn .3s cubic-bezier(.2,.8,.2,1)}
.mdl .x{position:absolute;top:14px;right:14px;border:0;background:#f0f4f9;width:34px;height:34px;border-radius:50%;font-size:18px;color:var(--mute)}
.mdl .x:hover{background:#e3ebf5}
.mh{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:16px;padding-right:44px}
.mh .av{width:50px;height:50px;border-radius:16px;font-size:17px;background:linear-gradient(150deg,var(--b),var(--b3));color:#fff}
.mh h3{margin:0;font-size:19px;letter-spacing:-.2px;line-height:1.2}
.mh .mono{display:block;margin-top:2px}
.mh .mb{margin-left:auto}
.alert{display:flex;gap:12px;align-items:flex-start;border-radius:14px;padding:13px 15px;font-size:14px;margin:0 0 14px;line-height:1.55}
.alert b{display:block;margin-bottom:2px;font-size:14.5px}
.alert svg{width:20px;height:20px;flex:none;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;margin-top:2px}
.alert.ok{background:var(--okbg);color:var(--ok);border:1px solid #bfe5cd}
.alert.rev{background:var(--warnbg);color:var(--warn);border:1px solid #f0dc8a}
.alert.tol{background:var(--badbg);color:var(--bad);border:1px solid #f3c6c2}
.alert.run{background:#eef4fb;color:var(--b);border:1px solid #d0e1f7}
.prog{display:flex;align-items:flex-start;margin:6px 0 16px}
.pst{flex:1;display:flex;flex-direction:column;align-items:center;position:relative;text-align:center;min-width:0}
.pst:not(:last-child):after{content:"";position:absolute;top:15px;left:calc(50% + 18px);right:calc(-50% + 18px);height:3px;border-radius:3px;background:var(--l)}
.pst.done:not(:last-child):after{background:linear-gradient(90deg,var(--ok),#2fb36a)}
.pst.cur:not(:last-child):after{background:linear-gradient(90deg,var(--b3),var(--l))}
.dot{width:32px;height:32px;border-radius:50%;background:#eef2f7;color:#9aa9bb;display:grid;place-items:center;font-weight:800;font-size:13px;position:relative;z-index:1;border:3px solid #fff;box-shadow:0 0 0 1px var(--l)}
.pst.done .dot{background:var(--ok);color:#fff;box-shadow:none}
.pst.cur .dot{background:var(--b);color:#fff;animation:ring 1.8s ease-out infinite}
@keyframes ring{0%{box-shadow:0 0 0 0 rgba(43,108,176,.4)}100%{box-shadow:0 0 0 12px rgba(43,108,176,0)}}
.dot svg{width:16px;height:16px;stroke:#fff;fill:none;stroke-width:3;stroke-linecap:round;stroke-linejoin:round}
.pst .lb{font-size:12.5px;font-weight:700;color:var(--mute);margin-top:6px;line-height:1.25}
.pst.done .lb,.pst.cur .lb{color:var(--ink)}
.dgrid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px}
.dcell{background:#f7f9fc;border:1px solid #eef2f7;border-radius:14px;padding:10px 13px;min-width:0}
.dcell.full{grid-column:1/-1}
.dcell span{display:block;font-size:11px;font-weight:700;color:var(--mute);text-transform:uppercase;letter-spacing:.5px}
.dcell div{font-size:14px;font-weight:600;margin-top:2px;overflow-wrap:anywhere}
.sec{font-size:12px;font-weight:800;color:var(--b);text-transform:uppercase;letter-spacing:.7px;margin:4px 0 10px}
.tl{list-style:none;margin:0 0 6px 6px;padding:0 0 0 18px;border-left:2px solid #e6edf6}
.tl li{position:relative;padding:0 0 14px 4px;font-size:14px;line-height:1.5}
.tl li:last-child{padding-bottom:0}
.tl li:before{content:"";position:absolute;left:-26px;top:5px;width:12px;height:12px;border-radius:50%;background:var(--c,var(--b3));box-shadow:0 0 0 4px #fff,0 0 0 5px #dfe9f6}
.tl li b{font-weight:700}
.tl li .tm{display:block;color:var(--mute);font-size:12.5px}
.tl li .nt{display:block;margin-top:4px;background:#fdf7e8;color:var(--warn);border-radius:10px;padding:7px 11px;font-size:13.5px}
.act-box{margin-top:16px;border-top:1px solid var(--l);padding-top:16px}
.act-box label{display:block;font-size:13px;font-weight:700;margin-bottom:6px}
.act-box textarea{width:100%;min-height:72px;padding:10px 12px;border:1.5px solid var(--l);border-radius:12px;resize:vertical;background:#fff}
.abtns{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}
.ddel{margin-top:16px;padding-top:14px;border-top:1px dashed var(--l);display:flex;justify-content:flex-end}
.fin{font-size:13.5px;color:var(--mute);background:#f7f9fc;padding:10px 14px;border-radius:12px;margin:14px 0 0}


/* ---------- detail (modal) ---------- */
.m-head{display:flex;align-items:center;gap:14px;flex-wrap:wrap;padding-right:44px;margin-bottom:16px}
.av-lg{width:56px;height:56px;border-radius:18px;font-size:18px;background:linear-gradient(150deg,var(--b),var(--b3));color:#fff;box-shadow:0 8px 18px rgba(23,70,121,.25)}
.m-title{flex:1;min-width:200px}
.m-title h3{margin:0;font-size:21px;letter-spacing:-.3px;line-height:1.2}
.m-sub{display:flex;align-items:center;gap:8px;margin-top:4px;flex-wrap:wrap}
.m-sub .mono{font-size:12.5px}
.dot-sep{width:4px;height:4px;border-radius:50%;background:#b5c3d4}
.m-badge .badge{font-size:13px;padding:6px 13px}
.m-card{background:#f8fbff;border:1px solid #e3ecf7;border-radius:18px;padding:16px 18px 10px;margin:14px 0 6px}
.m-card-h{font-size:12px;font-weight:800;color:var(--mute);text-transform:uppercase;letter-spacing:.6px;margin-bottom:4px}
.m-note{font-size:13.5px;color:var(--mute);margin:6px 0 10px}
.m-sec{font-size:12px;font-weight:800;color:var(--b);text-transform:uppercase;letter-spacing:.7px;margin:18px 0 10px;display:flex;align-items:center;gap:10px}
.m-sec:after{content:"";flex:1;height:1px;background:var(--l)}
.dgrid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.dcell{background:#fff;border:1px solid var(--l);border-radius:14px;padding:11px 14px;min-width:0}
.dcell.full{grid-column:1/-1}
.dcell span{display:block;font-size:11px;font-weight:700;color:var(--mute);text-transform:uppercase;letter-spacing:.5px}
.dcell div{font-size:14.5px;font-weight:600;margin-top:3px;overflow-wrap:anywhere;line-height:1.4}
.pt-big{font-size:20px;font-weight:800;color:var(--b)!important}
.sub-t{color:var(--mute);font-weight:500}
.tl{margin:0;padding:0 0 0 22px;border-left:2px solid #e6edf6;list-style:none}
.tl li{position:relative;padding:0 0 16px 6px;font-size:14px;line-height:1.5}
.tl li:last-child{padding-bottom:0}
.tl li:before{left:-30px;top:4px;width:14px;height:14px;box-shadow:0 0 0 4px #fff,0 0 0 5px #dfe9f6}
.tl li .tm{font-size:12.5px}
.act-panel{margin-top:20px;background:#f8fbff;border:1px solid #e3ecf7;border-radius:18px;padding:16px 18px}
.act-label{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px;font-size:13.5px;font-weight:800;margin-bottom:8px}
.act-label span{font-size:12px;font-weight:600;color:var(--mute)}
.note-ta{display:block;width:100%;min-height:88px;padding:12px 14px;border:1.5px solid #cfdbea;border-radius:13px;resize:none;background:#f8fbff;font-size:14.5px;line-height:1.5;color:var(--ink);cursor:default;caret-color:transparent}
.note-ta:focus{box-shadow:none;border-color:#cfdbea!important}
.note-ta::placeholder{color:#8a9bb0}
.note-hint{font-size:12.5px;color:var(--mute);margin:6px 0 12px}
.act-panel textarea{width:100%;min-height:76px;padding:11px 13px;border:1.5px solid var(--l);border-radius:13px;resize:vertical;background:#fff;font-size:14.5px}
.act-row{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}
.act-row .btn{padding:10px 16px;font-size:13.5px;border-radius:12px}
.final{margin-top:20px;text-align:center;font-size:13.5px;color:var(--mute);background:#f8fbff;border:1px dashed #cfdbea;border-radius:14px;padding:12px}
.m-foot{margin-top:18px;padding-top:14px;border-top:1px solid var(--l);display:flex;justify-content:flex-end}
.btn-link{border:0;background:none;padding:6px 8px;border-radius:8px;font-size:13.5px;font-weight:700;color:var(--mute)}
.btn-link:hover{background:#f4f6fa}
.btn-link.danger{color:var(--bad)}
.btn-link.danger:hover{background:var(--badbg)}
@media(max-width:560px){.dgrid{grid-template-columns:1fr}.m-head{padding-right:36px}.act-row .btn{flex:1 1 auto}}

.note-groups{margin:0 0 12px;display:grid;gap:12px}
.ng-h{display:flex;align-items:center;gap:7px;font-size:11.5px;font-weight:800;color:var(--mute);text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px}
.ng-h i{width:8px;height:8px;border-radius:50%}
.ng-clr{display:flex;justify-content:flex-end}
.note-opts{display:flex;flex-wrap:wrap;gap:7px}
.nopt{border:1.5px solid var(--l);background:#fff;border-radius:99px;padding:6px 12px;font-size:12.5px;font-weight:600;color:var(--mute);text-align:left;line-height:1.35;transition:.15s}
.nopt:hover{border-color:var(--b3);color:var(--b);background:#f5f9ff;transform:translateY(-1px)}
.nopt:active{transform:scale(.97)}
.nopt-clr{color:var(--bad);border-color:#f3c6c2;background:#fff}
.nopt-clr:hover{background:var(--badbg);color:var(--bad);border-color:#e9a7a1}
@media(max-width:560px){.nopt{font-size:12px;padding:6px 10px}}

.act-title{font-size:13.5px;font-weight:800;margin-bottom:12px;display:flex;align-items:center;gap:8px}
.step-badge{font-size:11px;font-weight:700;padding:2px 9px;border-radius:99px;background:#eef4fb;color:var(--b);border:1px solid #d0e1f7;white-space:nowrap}
.opt-cols{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.opt-col{background:#fff;border:1px solid var(--l);border-radius:16px;padding:12px;display:flex;flex-direction:column;gap:8px}
.oc-h{display:flex;align-items:center;gap:8px;font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;padding:2px 4px 6px;color:var(--mute)}
.oc-h i{width:9px;height:9px;border-radius:50%;background:currentColor}
.opt-col.ok .oc-h{color:var(--ok)}
.opt-col.bad .oc-h{color:var(--bad)}
.opt-btn{display:block;width:100%;text-align:left;border:1.5px solid var(--l);background:#fbfcfe;border-radius:12px;padding:10px 13px;font-size:13.5px;font-weight:600;line-height:1.4;color:var(--ink);transition:transform .15s,border-color .15s,background .15s,box-shadow .15s}
.opt-col.ok .opt-btn:hover{border-color:#8fd0a8;background:#f1faf4;box-shadow:0 6px 14px -8px var(--ok)}
.opt-col.bad .opt-btn:hover{border-color:#efb1ab;background:#fdf3f2;box-shadow:0 6px 14px -8px var(--bad)}
.opt-btn:active{transform:scale(.98)}
@media(max-width:620px){.opt-cols{grid-template-columns:1fr}}

#toast{position:fixed;left:50%;bottom:24px;transform:translate(-50%,30px);background:#10233b;color:#fff;padding:11px 20px;border-radius:12px;font-size:14px;opacity:0;pointer-events:none;transition:.25s;z-index:200;max-width:88vw;text-align:center;box-shadow:0 10px 24px rgba(0,0,0,.2)}
#toast.on{opacity:1;transform:translate(-50%,0)}

/* ---------- responsif ---------- */
@media(max-width:1180px){.sum{grid-template-columns:repeat(3,1fr)}}
@media(max-width:760px){
  .top{padding:16px 0 84px}
  .hrow{margin-top:18px}
  .acts{width:100%}
  .acts .btn{flex:1 1 auto}
  .sum{margin-top:-52px;gap:10px}
  .st{padding:13px 14px}
  .st .ic{width:36px;height:36px}
  .st b{font-size:20px}

  /* tabel → kartu */
  .tw{border:0;overflow:visible;max-height:none;background:transparent}
  table{min-width:0;width:100%}
  thead{display:none}
  tbody{display:grid;gap:10px}
  tbody tr{display:grid;grid-template-areas:"who who""kg kg""meta act";grid-template-columns:1fr auto;border:1px solid var(--l);border-radius:18px;padding:14px 15px;background:#fff;box-shadow:0 4px 14px rgba(11,42,77,.05);gap:0}
  tbody tr:hover{background:#f8fbff}

  /* sembunyikan kolom tak perlu */
  td.nd,td[data-label="Tanggal"]{display:none}

  /* baris who */
  td.who-cell{grid-area:who;display:flex;align-items:center;border:0;padding:0 0 10px;text-align:left}
  td.who-cell .who{max-width:100%}
  td.who-cell .who-nama{font-size:15px}

  /* baris kegiatan */
  td.kg-cell{grid-area:kg;display:flex;align-items:flex-start;border:0;padding:0 0 10px;text-align:left;border-top:1px solid #eef2f7;padding-top:10px}
  td.kg-cell .kg{display:flex;flex-direction:column;gap:2px}
  td.kg-cell .kg b{font-size:13.5px;font-weight:700}
  td.kg-cell .kg small{font-size:12px;color:var(--mute)}

  /* baris bawah: poin + status kiri, tombol kanan */
  td[data-label="Poin"]{grid-area:meta;display:flex;align-items:center;gap:8px;border:0;padding:0;border-top:1px solid #eef2f7;padding-top:10px}
  td.act-cell{grid-area:act;display:flex;align-items:center;justify-content:flex-end;border:0;padding:0;border-top:1px solid #eef2f7;padding-top:10px}
}
@media(max-width:560px){
  .sum{grid-template-columns:1fr 1fr}
  .st:last-child{grid-column:1/-1}
  .dgrid{grid-template-columns:1fr}
  .bar select{flex:1}
  .mdl{padding:22px 18px}
  .pst:not(.cur) .lb{display:none}
}

/* ---------- logo & meteor ---------- */
.brand i{width:46px;height:46px;border-radius:12px;background:#fff;padding:5px;overflow:hidden;box-shadow:0 4px 12px #00000026}
.brand i svg{width:36px;height:36px;display:block;flex:none}
.top>.w{position:relative;z-index:1}
.meteors{position:absolute;inset:0;overflow:hidden;pointer-events:none;z-index:0}
.meteors i{position:absolute;top:-110px;width:1.5px;border-radius:2px;background:linear-gradient(to bottom,transparent,rgba(255,255,255,.55));opacity:0;transform:translate3d(0,0,0) rotate(35deg);animation:meteor linear infinite;will-change:transform,opacity}
.meteors i:after{content:"";position:absolute;left:50%;bottom:0;width:3px;height:3px;margin-left:-1.5px;border-radius:50%;background:rgba(255,255,255,.7);box-shadow:0 0 6px 1px rgba(255,255,255,.35)}
@keyframes meteor{0%{transform:translate3d(0,0,0) rotate(35deg);opacity:0}10%{opacity:var(--o,.6)}70%{opacity:var(--o,.6)}100%{transform:translate3d(-330px,470px,0) rotate(35deg);opacity:0}}
@media(prefers-reduced-motion:reduce){.meteors{display:none}}

/* ===== DAFTAR DOKUMEN LAMPIRAN ===== */
.doc-list{display:grid;gap:8px;margin-bottom:6px}
.doc-row{display:flex;align-items:center;gap:12px;padding:11px 14px;border:1px solid #dde5f0;border-radius:12px;background:#fff;color:#0b1b2e;transition:border-color .15s,background .15s}
.doc-row:hover{border-color:#2b6cb0;background:#f4f8fe}
.doc-tag{flex:none;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:#174679;background:#e8f0fb;padding:3px 9px;border-radius:99px}
.doc-name{flex:1;min-width:0;font-size:14px;font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.doc-open{flex:none;font-size:13px;font-weight:700;color:#174679}

/* ===== TULISAN ADMIN: KUNING + KILAU ===== */
.ad-txt{color:var(--y);background:linear-gradient(110deg,#f6c90e 30%,#ffffff 50%,#f6c90e 70%);background-size:200% auto;-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;animation:adShine 3.2s linear infinite}
@keyframes adShine{to{background-position:200% center}}
@media(prefers-reduced-motion:reduce){.ad-txt{animation:none;background:none;-webkit-text-fill-color:currentColor;color:var(--y)}}
</style>
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
<symbol id="i-logo" viewBox="97 37.5 285 285"><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 320.917969 138.761719 C 315.0625 133.617188 308.199219 129.585938 300.800781 127.121094 C 295.324219 125.265625 289.5 124.296875 283.714844 124.695312 C 279.847656 124.953125 275.960938 125.8125 272.535156 127.675781 C 270.648438 128.699219 266.777344 130.941406 264.40625 135.566406 C 263.472656 137.386719 263.042969 139.050781 262.828125 140.199219 C 262.222656 140.601562 261.339844 141.167969 260.230469 141.789062 C 250.75 147.085938 241.40625 146.957031 238.457031 146.882812 C 228.554688 146.640625 220.792969 142.953125 216.136719 140.867188 C 215.527344 140.59375 215.027344 140.359375 214.683594 140.199219 C 214.316406 137.808594 213.113281 132.171875 208.835938 128.222656 C 205.921875 125.535156 201.542969 123.597656 200.148438 123.015625 C 199.464844 122.726562 198.882812 122.511719 198.484375 122.367188 C 198.332031 122.21875 198.113281 121.996094 197.859375 121.71875 C 192.796875 116.042969 193.886719 107.554688 194.214844 104.984375 C 195.074219 98.269531 198.265625 93.449219 200.21875 90.96875 C 202.851562 90.070312 205.785156 88.890625 208.898438 87.328125 C 211.476562 86.035156 213.765625 84.683594 215.761719 83.378906 C 237.226562 76.925781 249.964844 79.054688 257.75 82.480469 C 258.933594 83.003906 259.667969 83.300781 262.628906 84.734375 C 271.90625 89.246094 281.292969 93.746094 291.527344 94.738281 C 297.539062 95.25 303.804688 95.007812 309.410156 92.550781 C 312.101562 91.40625 314.5 89.214844 315.308594 86.332031 C 316.007812 83.847656 315.109375 81.25 313.894531 79.085938 C 311.820312 75.554688 308.566406 72.917969 305.21875 70.664062 C 296.96875 65.453125 287.457031 62.246094 277.742188 61.351562 C 273.53125 60.972656 269.253906 60.945312 265.078125 61.730469 C 261.941406 62.300781 258.757812 63.332031 256.316406 65.464844 C 255.28125 66.347656 254.585938 67.535156 253.71875 68.570312 C 252.914062 69.546875 251.675781 69.984375 250.507812 70.347656 C 247.835938 71.136719 245.054688 71.476562 242.285156 71.6875 C 237.21875 71.988281 232.101562 71.71875 227.125 70.707031 C 225.65625 70.359375 224.132812 70.046875 222.820312 69.261719 C 221.675781 68.511719 221.089844 67.207031 220.175781 66.230469 C 218.320312 64.171875 215.703125 62.996094 213.074219 62.277344 C 208.277344 60.988281 203.242188 60.882812 198.316406 61.300781 C 191.933594 61.847656 185.664062 63.472656 179.734375 65.886719 C 175.832031 67.457031 172.09375 69.464844 168.675781 71.929688 C 165.613281 74.179688 162.824219 76.96875 161.125 80.40625 C 159.664062 83.402344 159.921875 87.402344 162.398438 89.796875 C 165.457031 92.828125 169.792969 94.101562 173.976562 94.589844 C 175.324219 94.789062 176.730469 94.722656 178.050781 95.132812 C 178.746094 95.523438 179.109375 96.285156 179.472656 96.964844 C 181.324219 100.714844 181.457031 105.105469 180.566406 109.136719 C 179.625 113.304688 177.886719 117.292969 175.511719 120.839844 C 174.046875 123.097656 172.386719 125.371094 169.976562 126.691406 C 168.273438 127.617188 166.511719 128.421875 164.859375 129.4375 C 156.003906 134.691406 148.335938 142.296875 143.984375 151.714844 C 141.257812 157.714844 140.082031 164.800781 142.433594 171.117188 C 144.71875 177.386719 150.648438 181.800781 157.023438 183.277344 C 166.273438 185.550781 176.046875 183.65625 184.640625 179.914062 C 190.605469 177.375 195.960938 173.59375 200.820312 169.339844 C 202.09375 168.234375 203.261719 167.003906 204.648438 166.039062 C 209.96875 162.394531 216.144531 160.15625 222.433594 158.871094 C 229.097656 157.535156 235.925781 157.109375 242.710938 157.308594 C 252.890625 157.8125 263.125 161.082031 271.117188 167.539062 C 273.441406 169.359375 275.351562 171.632812 277.613281 173.53125 C 285.566406 180.382812 295.371094 185.25 305.8125 186.71875 C 310.308594 187.339844 314.949219 187.441406 319.378906 186.328125 C 323.992188 185.210938 328.453125 182.902344 331.503906 179.1875 C 333.746094 176.515625 335.125 173.164062 335.566406 169.707031 C 336.144531 164.984375 335.289062 160.164062 333.453125 155.796875 C 330.699219 149.230469 326.25 143.445312 320.917969 138.761719 Z M 320.917969 138.761719 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 237.648438 61.242188 C 250.972656 61.242188 261.769531 56.507812 261.769531 50.667969 C 261.769531 44.832031 250.972656 40.097656 237.648438 40.097656 C 224.328125 40.097656 213.53125 44.832031 213.53125 50.667969 C 213.53125 56.507812 224.328125 61.242188 237.648438 61.242188 Z M 237.648438 61.242188 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 146.707031 131.722656 C 160.132812 115.695312 163.96875 96.792969 155.277344 89.507812 C 146.585938 82.222656 128.65625 89.308594 115.230469 105.339844 C 101.804688 121.367188 97.96875 140.269531 106.660156 147.554688 C 115.355469 154.839844 133.28125 147.753906 146.707031 131.722656 Z M 146.707031 131.722656 " /><path fill="#f3c813" fill-opacity="1" fill-rule="nonzero" d="M 364.542969 105.339844 C 351.117188 89.308594 333.1875 82.222656 324.496094 89.507812 C 323.011719 90.753906 321.921875 92.359375 321.152344 94.210938 C 320.660156 95.414062 320.167969 96.621094 319.679688 97.824219 C 319.183594 98.9375 318.167969 99.679688 317.183594 100.335938 C 314.046875 102.363281 310.527344 103.726562 306.9375 104.703125 C 300.78125 106.34375 294.359375 106.730469 288.015625 106.523438 C 282.160156 106.292969 276.253906 105.671875 270.6875 103.765625 C 268.527344 103.003906 266.335938 102.136719 264.59375 100.605469 C 262.878906 99.113281 261.398438 97.347656 259.480469 96.09375 C 253.210938 91.910156 245.582031 90.09375 238.097656 90.207031 C 232.839844 90.183594 227.574219 91.179688 222.714844 93.195312 C 218.300781 95.050781 214.21875 97.945312 211.476562 101.917969 C 208.769531 105.789062 208.136719 111.027344 209.855469 115.4375 C 211.109375 118.640625 213.441406 121.316406 216.136719 123.410156 C 219.25 125.8125 222.871094 127.507812 226.640625 128.582031 C 237.058594 131.601562 248.773438 130.636719 258.214844 125.136719 C 259.964844 124.128906 261.785156 123.25 263.566406 122.296875 C 269.242188 119.265625 274.4375 117.167969 276.28125 116.460938 C 284.492188 113.300781 296.527344 113.371094 306.855469 116.089844 C 311.777344 117.382812 323.839844 120.488281 332.421875 130.949219 C 332.589844 131.15625 332.894531 131.519531 333.066406 131.722656 C 346.492188 147.753906 364.421875 154.839844 373.113281 147.554688 C 381.804688 140.269531 377.96875 121.367188 364.542969 105.339844 Z M 364.542969 105.339844 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 237.648438 169.558594 C 216.578125 169.558594 199.492188 186.648438 199.492188 207.734375 C 199.492188 228.816406 216.578125 245.90625 237.648438 245.90625 C 258.722656 245.90625 275.808594 228.816406 275.808594 207.734375 C 275.808594 186.648438 258.722656 169.558594 237.648438 169.558594 Z M 237.648438 169.558594 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 173.007812 295.339844 L 195.863281 295.339844 C 201.945312 295.339844 203.550781 293.539062 203.550781 287.417969 L 203.550781 281.011719 C 203.550781 274.960938 201.945312 273.089844 195.863281 273.089844 L 180.628906 273.089844 C 174.617188 273.089844 173.007812 274.960938 173.007812 281.011719 Z M 163.015625 319.898438 L 163.015625 279.066406 C 163.015625 268.625 167.070312 264.449219 179.648438 264.449219 L 196.84375 264.449219 C 209.421875 264.449219 213.476562 268.625 213.476562 279.066406 L 213.476562 289.4375 C 213.476562 299.875 209.421875 303.984375 196.84375 303.984375 L 173.007812 303.984375 L 173.007812 314.675781 C 173.007812 317.558594 170.597656 319.898438 167.621094 319.898438 Z M 163.015625 319.898438 " /><path fill="#f3c813" fill-opacity="1" fill-rule="nonzero" d="M 237.53125 279.898438 C 233.078125 279.898438 229.441406 282.894531 229.441406 287.214844 L 229.441406 288.113281 L 262.699219 288.113281 L 262.699219 278.015625 C 262.699219 269.308594 260.167969 264.433594 250.582031 264.433594 L 230.121094 264.433594 C 217.539062 264.433594 213.476562 268.617188 213.476562 279.050781 L 213.476562 289.449219 C 213.476562 299.882812 217.539062 303.996094 230.121094 303.996094 L 259.675781 303.996094 C 259.675781 299.191406 255.648438 295.320312 250.730469 295.320312 L 231.085938 295.320312 C 225.027344 295.320312 223.386719 293.457031 223.386719 288.933594 L 223.386719 278.636719 C 223.457031 274.179688 225.097656 272.453125 231.085938 272.453125 L 248.65625 272.453125 C 251.863281 272.453125 252.898438 273.589844 252.898438 276.5625 L 252.898438 279.898438 Z M 237.53125 279.898438 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 353.617188 292.171875 C 353.617188 294.621094 352.570312 295.628906 349.703125 295.628906 L 316.027344 295.628906 L 316.027344 281.9375 C 317.324219 285.386719 320.5 287.203125 326.222656 287.203125 L 349.703125 287.203125 C 352.570312 287.203125 353.617188 288.355469 353.617188 290.230469 Z M 352.359375 303.984375 C 360.609375 303.984375 363.332031 300.238281 363.332031 293.902344 L 363.332031 289.867188 C 363.332031 283.675781 360.257812 280.21875 352.429688 280.21875 L 328.878906 280.21875 C 326.011719 280.21875 325.03125 279.066406 325.03125 277.121094 L 325.03125 276.042969 C 325.03125 273.953125 326.011719 272.800781 328.878906 272.800781 L 353.039062 272.800781 C 357.796875 272.800781 361.65625 269.0625 361.65625 264.449219 L 326.292969 264.449219 C 318.644531 264.449219 315.75 267.796875 315.367188 273.046875 C 313.800781 266.996094 309.1875 264.449219 299.390625 264.449219 L 279.335938 264.449219 C 266.753906 264.449219 262.699219 268.625 262.699219 279.066406 L 262.699219 303.984375 L 272.695312 303.984375 L 272.695312 281.511719 C 272.695312 275.464844 274.300781 273.59375 280.3125 273.59375 L 298.902344 273.59375 C 304.914062 273.59375 306.101562 275.464844 306.101562 281.511719 L 306.101562 303.984375 Z M 352.359375 303.984375 " /></symbol>
</defs></svg>

<header class="top">
  <div class="meteors" aria-hidden="true"></div>
  <div class="w">
    <div class="topbar">
      <a class="brand" href="{{ route('skem.index') }}"><i><svg aria-hidden="true"><use href="#i-logo" width="36" height="36"/></svg></i><span><b>SKEM PENS</b><small>Satuan Kredit Ekstrakurikuler</small></span></a>
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