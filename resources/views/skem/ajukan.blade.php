@php
    /* Prodi dikelompokkan per departemen, D3 ditampilkan lebih dulu */
    $grup = collect($studyPrograms)
        ->sortBy(fn ($p) => [$p->degree === 'D3' ? 0 : 1, $p->name])
        ->groupBy(fn ($p) => $p->department?->name ?? 'Program Lainnya')
        ->sortKeys();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Ajukan SKEM PENS – Sistem Pengajuan Satuan Kredit Ekstrakurikuler</title>
<meta name="description" content="Ajukan klaim poin SKEM PENS: isi data kegiatan, unggah formulir verifikasi dan bukti, lalu pantau status pengajuan.">
<meta name="theme-color" content="#0b2a4d">
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%2297 37.5 285 285%22%3E%3Cpath fill=%22%23174679%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 320.917969 138.761719 C 315.0625 133.617188 308.199219 129.585938 300.800781 127.121094 C 295.324219 125.265625 289.5 124.296875 283.714844 124.695312 C 279.847656 124.953125 275.960938 125.8125 272.535156 127.675781 C 270.648438 128.699219 266.777344 130.941406 264.40625 135.566406 C 263.472656 137.386719 263.042969 139.050781 262.828125 140.199219 C 262.222656 140.601562 261.339844 141.167969 260.230469 141.789062 C 250.75 147.085938 241.40625 146.957031 238.457031 146.882812 C 228.554688 146.640625 220.792969 142.953125 216.136719 140.867188 C 215.527344 140.59375 215.027344 140.359375 214.683594 140.199219 C 214.316406 137.808594 213.113281 132.171875 208.835938 128.222656 C 205.921875 125.535156 201.542969 123.597656 200.148438 123.015625 C 199.464844 122.726562 198.882812 122.511719 198.484375 122.367188 C 198.332031 122.21875 198.113281 121.996094 197.859375 121.71875 C 192.796875 116.042969 193.886719 107.554688 194.214844 104.984375 C 195.074219 98.269531 198.265625 93.449219 200.21875 90.96875 C 202.851562 90.070312 205.785156 88.890625 208.898438 87.328125 C 211.476562 86.035156 213.765625 84.683594 215.761719 83.378906 C 237.226562 76.925781 249.964844 79.054688 257.75 82.480469 C 258.933594 83.003906 259.667969 83.300781 262.628906 84.734375 C 271.90625 89.246094 281.292969 93.746094 291.527344 94.738281 C 297.539062 95.25 303.804688 95.007812 309.410156 92.550781 C 312.101562 91.40625 314.5 89.214844 315.308594 86.332031 C 316.007812 83.847656 315.109375 81.25 313.894531 79.085938 C 311.820312 75.554688 308.566406 72.917969 305.21875 70.664062 C 296.96875 65.453125 287.457031 62.246094 277.742188 61.351562 C 273.53125 60.972656 269.253906 60.945312 265.078125 61.730469 C 261.941406 62.300781 258.757812 63.332031 256.316406 65.464844 C 255.28125 66.347656 254.585938 67.535156 253.71875 68.570312 C 252.914062 69.546875 251.675781 69.984375 250.507812 70.347656 C 247.835938 71.136719 245.054688 71.476562 242.285156 71.6875 C 237.21875 71.988281 232.101562 71.71875 227.125 70.707031 C 225.65625 70.359375 224.132812 70.046875 222.820312 69.261719 C 221.675781 68.511719 221.089844 67.207031 220.175781 66.230469 C 218.320312 64.171875 215.703125 62.996094 213.074219 62.277344 C 208.277344 60.988281 203.242188 60.882812 198.316406 61.300781 C 191.933594 61.847656 185.664062 63.472656 179.734375 65.886719 C 175.832031 67.457031 172.09375 69.464844 168.675781 71.929688 C 165.613281 74.179688 162.824219 76.96875 161.125 80.40625 C 159.664062 83.402344 159.921875 87.402344 162.398438 89.796875 C 165.457031 92.828125 169.792969 94.101562 173.976562 94.589844 C 175.324219 94.789062 176.730469 94.722656 178.050781 95.132812 C 178.746094 95.523438 179.109375 96.285156 179.472656 96.964844 C 181.324219 100.714844 181.457031 105.105469 180.566406 109.136719 C 179.625 113.304688 177.886719 117.292969 175.511719 120.839844 C 174.046875 123.097656 172.386719 125.371094 169.976562 126.691406 C 168.273438 127.617188 166.511719 128.421875 164.859375 129.4375 C 156.003906 134.691406 148.335938 142.296875 143.984375 151.714844 C 141.257812 157.714844 140.082031 164.800781 142.433594 171.117188 C 144.71875 177.386719 150.648438 181.800781 157.023438 183.277344 C 166.273438 185.550781 176.046875 183.65625 184.640625 179.914062 C 190.605469 177.375 195.960938 173.59375 200.820312 169.339844 C 202.09375 168.234375 203.261719 167.003906 204.648438 166.039062 C 209.96875 162.394531 216.144531 160.15625 222.433594 158.871094 C 229.097656 157.535156 235.925781 157.109375 242.710938 157.308594 C 252.890625 157.8125 263.125 161.082031 271.117188 167.539062 C 273.441406 169.359375 275.351562 171.632812 277.613281 173.53125 C 285.566406 180.382812 295.371094 185.25 305.8125 186.71875 C 310.308594 187.339844 314.949219 187.441406 319.378906 186.328125 C 323.992188 185.210938 328.453125 182.902344 331.503906 179.1875 C 333.746094 176.515625 335.125 173.164062 335.566406 169.707031 C 336.144531 164.984375 335.289062 160.164062 333.453125 155.796875 C 330.699219 149.230469 326.25 143.445312 320.917969 138.761719 Z M 320.917969 138.761719 %22 /%3E%3Cpath fill=%22%23174679%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 237.648438 61.242188 C 250.972656 61.242188 261.769531 56.507812 261.769531 50.667969 C 261.769531 44.832031 250.972656 40.097656 237.648438 40.097656 C 224.328125 40.097656 213.53125 44.832031 213.53125 50.667969 C 213.53125 56.507812 224.328125 61.242188 237.648438 61.242188 Z M 237.648438 61.242188 %22 /%3E%3Cpath fill=%22%23174679%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 146.707031 131.722656 C 160.132812 115.695312 163.96875 96.792969 155.277344 89.507812 C 146.585938 82.222656 128.65625 89.308594 115.230469 105.339844 C 101.804688 121.367188 97.96875 140.269531 106.660156 147.554688 C 115.355469 154.839844 133.28125 147.753906 146.707031 131.722656 Z M 146.707031 131.722656 %22 /%3E%3Cpath fill=%22%23f3c813%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 364.542969 105.339844 C 351.117188 89.308594 333.1875 82.222656 324.496094 89.507812 C 323.011719 90.753906 321.921875 92.359375 321.152344 94.210938 C 320.660156 95.414062 320.167969 96.621094 319.679688 97.824219 C 319.183594 98.9375 318.167969 99.679688 317.183594 100.335938 C 314.046875 102.363281 310.527344 103.726562 306.9375 104.703125 C 300.78125 106.34375 294.359375 106.730469 288.015625 106.523438 C 282.160156 106.292969 276.253906 105.671875 270.6875 103.765625 C 268.527344 103.003906 266.335938 102.136719 264.59375 100.605469 C 262.878906 99.113281 261.398438 97.347656 259.480469 96.09375 C 253.210938 91.910156 245.582031 90.09375 238.097656 90.207031 C 232.839844 90.183594 227.574219 91.179688 222.714844 93.195312 C 218.300781 95.050781 214.21875 97.945312 211.476562 101.917969 C 208.769531 105.789062 208.136719 111.027344 209.855469 115.4375 C 211.109375 118.640625 213.441406 121.316406 216.136719 123.410156 C 219.25 125.8125 222.871094 127.507812 226.640625 128.582031 C 237.058594 131.601562 248.773438 130.636719 258.214844 125.136719 C 259.964844 124.128906 261.785156 123.25 263.566406 122.296875 C 269.242188 119.265625 274.4375 117.167969 276.28125 116.460938 C 284.492188 113.300781 296.527344 113.371094 306.855469 116.089844 C 311.777344 117.382812 323.839844 120.488281 332.421875 130.949219 C 332.589844 131.15625 332.894531 131.519531 333.066406 131.722656 C 346.492188 147.753906 364.421875 154.839844 373.113281 147.554688 C 381.804688 140.269531 377.96875 121.367188 364.542969 105.339844 Z M 364.542969 105.339844 %22 /%3E%3Cpath fill=%22%23174679%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 237.648438 169.558594 C 216.578125 169.558594 199.492188 186.648438 199.492188 207.734375 C 199.492188 228.816406 216.578125 245.90625 237.648438 245.90625 C 258.722656 245.90625 275.808594 228.816406 275.808594 207.734375 C 275.808594 186.648438 258.722656 169.558594 237.648438 169.558594 Z M 237.648438 169.558594 %22 /%3E%3Cpath fill=%22%23174679%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 173.007812 295.339844 L 195.863281 295.339844 C 201.945312 295.339844 203.550781 293.539062 203.550781 287.417969 L 203.550781 281.011719 C 203.550781 274.960938 201.945312 273.089844 195.863281 273.089844 L 180.628906 273.089844 C 174.617188 273.089844 173.007812 274.960938 173.007812 281.011719 Z M 163.015625 319.898438 L 163.015625 279.066406 C 163.015625 268.625 167.070312 264.449219 179.648438 264.449219 L 196.84375 264.449219 C 209.421875 264.449219 213.476562 268.625 213.476562 279.066406 L 213.476562 289.4375 C 213.476562 299.875 209.421875 303.984375 196.84375 303.984375 L 173.007812 303.984375 L 173.007812 314.675781 C 173.007812 317.558594 170.597656 319.898438 167.621094 319.898438 Z M 163.015625 319.898438 %22 /%3E%3Cpath fill=%22%23f3c813%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 237.53125 279.898438 C 233.078125 279.898438 229.441406 282.894531 229.441406 287.214844 L 229.441406 288.113281 L 262.699219 288.113281 L 262.699219 278.015625 C 262.699219 269.308594 260.167969 264.433594 250.582031 264.433594 L 230.121094 264.433594 C 217.539062 264.433594 213.476562 268.617188 213.476562 279.050781 L 213.476562 289.449219 C 213.476562 299.882812 217.539062 303.996094 230.121094 303.996094 L 259.675781 303.996094 C 259.675781 299.191406 255.648438 295.320312 250.730469 295.320312 L 231.085938 295.320312 C 225.027344 295.320312 223.386719 293.457031 223.386719 288.933594 L 223.386719 278.636719 C 223.457031 274.179688 225.097656 272.453125 231.085938 272.453125 L 248.65625 272.453125 C 251.863281 272.453125 252.898438 273.589844 252.898438 276.5625 L 252.898438 279.898438 Z M 237.53125 279.898438 %22 /%3E%3Cpath fill=%22%23174679%22 fill-opacity=%221%22 fill-rule=%22nonzero%22 d=%22M 353.617188 292.171875 C 353.617188 294.621094 352.570312 295.628906 349.703125 295.628906 L 316.027344 295.628906 L 316.027344 281.9375 C 317.324219 285.386719 320.5 287.203125 326.222656 287.203125 L 349.703125 287.203125 C 352.570312 287.203125 353.617188 288.355469 353.617188 290.230469 Z M 352.359375 303.984375 C 360.609375 303.984375 363.332031 300.238281 363.332031 293.902344 L 363.332031 289.867188 C 363.332031 283.675781 360.257812 280.21875 352.429688 280.21875 L 328.878906 280.21875 C 326.011719 280.21875 325.03125 279.066406 325.03125 277.121094 L 325.03125 276.042969 C 325.03125 273.953125 326.011719 272.800781 328.878906 272.800781 L 353.039062 272.800781 C 357.796875 272.800781 361.65625 269.0625 361.65625 264.449219 L 326.292969 264.449219 C 318.644531 264.449219 315.75 267.796875 315.367188 273.046875 C 313.800781 266.996094 309.1875 264.449219 299.390625 264.449219 L 279.335938 264.449219 C 266.753906 264.449219 262.699219 268.625 262.699219 279.066406 L 262.699219 303.984375 L 272.695312 303.984375 L 272.695312 281.511719 C 272.695312 275.464844 274.300781 273.59375 280.3125 273.59375 L 298.902344 273.59375 C 304.914062 273.59375 306.101562 275.464844 306.101562 281.511719 L 306.101562 303.984375 Z M 352.359375 303.984375 %22/%3E%3C/svg%3E">
<style>
@verbatim
:root{--b:#174679;--b2:#0b2a4d;--b3:#2b6cb0;--y:#f6c90e;--bg:#f5f8fd;--l:#dde5f0;--ink:#0b1b2e;--mute:#47607e;--ok:#12703a;--okbg:#e6f6ec;--bad:#b3261e;--badbg:#fdeceb;--warn:#8a4b00;--warnbg:#fff6e0}
*{box-sizing:border-box}html{scroll-behavior:smooth}
body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.7 "Segoe UI",system-ui,-apple-system,Roboto,Arial,sans-serif;-webkit-font-smoothing:antialiased}
.w{max-width:980px;margin:0 auto;padding:0 22px}
.ico{width:24px;height:24px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
a{color:inherit;text-decoration:none}
:focus-visible{outline:3px solid var(--b3);outline-offset:3px;border-radius:6px}

/* nav */
.nav{position:sticky;top:0;z-index:50;background:#0b2a4deb;-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px);color:#fff;border-bottom:1px solid #ffffff1a}
.nv{display:flex;align-items:center;gap:22px;height:62px}
.brand{display:inline-flex;align-items:center;gap:12px;color:#fff}
.brand i{width:46px;height:46px;border-radius:12px;background:#fff;display:grid;place-items:center;padding:5px;flex:none;box-shadow:0 4px 12px #00000026;overflow:hidden}.brand i svg{width:36px;height:36px;display:block;flex:none}
.bt{display:flex;flex-direction:column;line-height:1.15}.bt b{font-size:19px;font-weight:800;letter-spacing:.8px;color:#fff}.bt b span{color:var(--y)}.bt small{font-size:11.5px;font-weight:500;color:#a9c2e2;letter-spacing:.2px;margin-top:3px}
.btn{display:inline-flex;align-items:center;gap:8px;border-radius:12px;padding:12px 22px;font:inherit;font-weight:700;cursor:pointer;border:0;transition:transform .15s,box-shadow .15s,background .15s;text-decoration:none}
.btn.y{background:var(--y);color:#10233b;box-shadow:0 8px 20px #f6c90e40}.btn.y:hover{transform:translateY(-2px)}
.btn.g{background:#ffffff14;color:#fff;border:1px solid #ffffff50}.btn.g:hover{background:#ffffff26}
.btn.o{background:#fff;border:1.5px solid var(--l);color:var(--ink)}.btn.o:hover{border-color:var(--b3);background:#f2f7fd}
.btn:disabled{opacity:.55;cursor:not-allowed;transform:none}
.nav .btn.g{margin-left:auto;padding:8px 16px;font-size:14px;border-radius:10px}.nav .btn.g .ico{width:17px;height:17px}

/* hero */
.hero{color:#fff;position:relative;overflow:hidden;padding:26px 0 92px;background:radial-gradient(800px 400px at 88% 0,#2f74bd55,transparent 65%),linear-gradient(165deg,var(--b2),var(--b))}
.hero:before{content:"";position:absolute;inset:0;background-image:linear-gradient(#ffffff0d 1px,transparent 1px),linear-gradient(90deg,#ffffff0d 1px,transparent 1px);background-size:44px 44px;-webkit-mask:linear-gradient(#000,transparent 85%);mask:linear-gradient(#000,transparent 85%)}
.hero .w{position:relative}
.crumbs{display:flex;align-items:center;gap:8px;font-size:13.5px;color:#bcd3ee;flex-wrap:wrap}.crumbs a:hover{color:#fff}.crumbs .ico{width:14px;height:14px}
.hero h1{font-size:clamp(28px,4.6vw,42px);line-height:1.15;margin:16px 0 10px;font-weight:800;letter-spacing:-.6px;display:inline-block}
.hero h1 em{font-style:normal;color:var(--y);background:linear-gradient(110deg,#f6c90e 30%,#ffffff 50%,#f6c90e 70%);background-size:200% auto;-webkit-background-clip:text;-webkit-text-fill-color:transparent;animation:shineText 4s linear infinite}
@keyframes shineText{to{background-position:200% center}}
.hero .sub{margin:0;color:#dbe8f8;max-width:620px;font-size:16.5px}
.chips{display:flex;flex-wrap:wrap;gap:10px;margin-top:20px}
.chip{display:inline-flex;align-items:center;gap:8px;background:#ffffff1a;border:1px solid #ffffff33;border-radius:99px;padding:7px 14px;font-size:13px;font-weight:600;color:#fff}
.chip .ico{width:16px;height:16px;color:var(--y)}

/* card + steps */
.card{background:#fff;border:1px solid var(--l);border-radius:20px;padding:28px;box-shadow:0 14px 34px #0b2a4d1f}
.steps{display:flex;gap:8px;margin:0 0 26px;padding:0;list-style:none;counter-reset:s}
.steps li{flex:1;display:flex;align-items:center;gap:10px;color:var(--mute);font-size:13.5px;font-weight:600;min-width:0}
.steps li:before{counter-increment:s;content:counter(s);display:grid;place-items:center;width:34px;height:34px;border-radius:50%;background:#e8f0fb;color:var(--b);font-weight:800;font-size:14.5px;flex:none;transition:.2s}
.steps li:not(:last-child):after{content:"";flex:1;height:2px;background:var(--l);border-radius:2px;min-width:12px}
.steps li.act{color:var(--ink)}.steps li.act:before{background:linear-gradient(160deg,var(--b),var(--b3));color:#fff;box-shadow:0 0 0 5px #e8f0fb}
.steps li.done:before{background:var(--okbg);color:var(--ok);content:"✓"}
.pane{display:none}.pane.on{display:block;animation:fade .3s ease}
@keyframes fade{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
h3.pt{margin:0 0 4px;font-size:20px;letter-spacing:-.3px}
p.pm{margin:0 0 20px;color:var(--mute);font-size:14.5px}

/* form */
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:0 18px}
.fld{margin-bottom:16px}
label{display:block;font-size:13px;font-weight:700;color:var(--ink);margin:0 0 6px}
label small{font-weight:500;color:var(--mute)}
input,select,textarea{width:100%;padding:11px 13px;border:1.5px solid var(--l);border-radius:10px;background:#fff;color:var(--ink);font:inherit;font-size:15px;transition:border-color .15s,box-shadow .15s}
input:focus,select:focus,textarea:focus{outline:0;border-color:var(--b3);box-shadow:0 0 0 3px rgba(43,108,176,.15)}
input::placeholder,textarea::placeholder{color:#93a5ba}
/* dropdown select: panah kustom & daftar pilihan yang lebih rapi */
select{appearance:none;-webkit-appearance:none;-moz-appearance:none;padding-right:40px;cursor:pointer;color-scheme:light;background-color:#fff;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23174679' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 13px center;background-size:18px}
select:hover{border-color:var(--b3)}
select:invalid,select option[value=""]:checked{color:#93a5ba}
select option{background:#fff;color:var(--ink);padding:9px 12px;font-size:15px}
select option:checked{background:#e8f0fb;color:var(--b);font-weight:700}
select option:hover,select option:focus{background:#eef4fb}
select optgroup{background:#f2f7fd;color:var(--b2);font-weight:800;font-style:normal;font-size:13px;letter-spacing:.2px}
select option[value="__lain"]{color:var(--b3);font-weight:700}
textarea{resize:vertical;min-height:74px}
#prodiLain, #deptLain{margin-top:8px}
.hint{font-size:12.5px;color:var(--mute);margin:6px 0 0}
.err{display:none;font-size:12.5px;color:var(--bad);margin:5px 0 0;font-weight:600}
.fld.bad input,.fld.bad select{border-color:var(--bad);background:#fffafa}
.fld.bad .err{display:block}
.pill{display:inline-flex;align-items:center;gap:7px;background:#e8f0fb;color:var(--b);border-radius:99px;padding:4px 13px;font-size:12.5px;font-weight:700}


/* ===== DROPDOWN KUSTOM (Program studi, Departemen, Jenis, Peran) ===== */
.cs{position:relative;z-index:1}
.cs.open{z-index:45}
.cs-native{position:absolute!important;opacity:0;pointer-events:none;width:1px;height:1px;left:0;top:0;overflow:hidden}
.cs-btn{width:100%;display:flex;align-items:center;justify-content:space-between;gap:10px;padding:11px 13px 11px 14px;border:1.5px solid var(--l);border-radius:14px;background:#fff;color:var(--ink);font:inherit;font-size:15px;text-align:left;cursor:pointer;transition:border-color .15s,box-shadow .15s,border-radius .2s;box-shadow:0 2px 6px #0b2a4d0a}
.cs-btn:hover{border-color:var(--b3)}
.cs-btn:focus-visible{outline:3px solid var(--b3);outline-offset:3px}
.cs-btn:disabled{opacity:.55;cursor:not-allowed;background:#f6f8fb}
.cs-val{flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.cs-val.ph{color:#93a5ba}
.cs-btn .ico{width:18px;height:18px;stroke:var(--b);stroke-width:2.2;flex:none;transition:transform .2s}
.cs.open .cs-btn{border-color:var(--b3);box-shadow:0 0 0 3px rgba(43,108,176,.15);border-radius:14px 14px 6px 6px}
.cs.open .cs-btn .ico{transform:rotate(180deg)}
.fld.bad .cs-btn{border-color:var(--bad);background:#fffafa}
.cs-list{display:none;position:absolute;left:0;right:0;top:calc(100% + 4px);z-index:30;background:#fff;border:1.5px solid var(--b3);border-radius:14px;box-shadow:0 18px 40px #0b2a4d2e;max-height:300px;overflow-y:auto;padding:6px;animation:fade .18s ease}
.cs-list.on{display:block}

.cs.open.up .cs-btn{border-radius:6px 6px 14px 14px}
.cs-sbox{padding:2px 2px 6px}
.cs-sbox input{padding:9px 12px;font-size:14px;border-radius:10px}
.cs-grp{position:sticky;top:0;z-index:1;background:#f2f7fd;color:var(--b2);font-size:12px;font-weight:800;letter-spacing:.3px;text-transform:uppercase;padding:8px 10px;margin:4px 0 2px;border-radius:8px}
.cs-opt{padding:9px 12px;border-radius:10px;font-size:15px;color:var(--ink);cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:8px;line-height:1.4}
.cs-opt.ph{color:#93a5ba}
.cs-opt.lain{color:var(--b3);font-weight:700}
.cs-opt.act,.cs-opt:hover{background:#eef4fb}
.cs-opt.sel{background:#e8f0fb;color:var(--b);font-weight:700}
.cs-opt.sel:after{content:"✓";color:var(--ok);font-weight:800}
.cs-empty{display:none;padding:12px;font-size:14px;color:var(--mute);text-align:center}

/* ===== FORM 1 IDENTITAS ===== */
.subh{display:flex;align-items:center;gap:10px;font-size:12px;font-weight:800;color:var(--b);text-transform:uppercase;letter-spacing:.7px;margin:6px 0 14px}
.subh:after{content:"";flex:1;height:1px;background:var(--l)}
.subh:not(:first-of-type){margin-top:8px}
.idbanner{display:flex;align-items:center;gap:12px;background:var(--okbg);color:var(--ok);border:1px solid #bfe5cd;border-radius:14px;padding:12px 14px;margin:0 0 22px;font-size:14px;line-height:1.5}
.idbanner[hidden]{display:none}
.idbanner .ico{width:20px;height:20px;color:var(--ok);flex:none}
.idbanner span{flex:1;font-weight:600}
.idbanner button{background:#fff;border:1px solid #bfe5cd;color:var(--ok);border-radius:10px;padding:6px 12px;font:inherit;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap}
.idbanner button:hover{background:#f3fbf6}
#nrpHint{display:flex;justify-content:space-between;gap:8px}
#nrpHint b{color:var(--b);font-weight:700}
/* ===== FORM 2 KEGIATAN & POIN ===== */
.kopt{position:relative;display:flex;flex-direction:column;gap:2px;padding:16px 16px 15px;min-height:118px;border-radius:16px}
.kopt b{padding-right:30px;font-size:15px}
.kopt small{font-size:12.5px}
.kopt:after{content:"";position:absolute;top:14px;right:14px;width:20px;height:20px;border-radius:50%;border:1.5px solid #c3d2e6;background:#fff;transition:.15s}
.kopt.sel:after{background:var(--b) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M5 12l5 5 9-10'/%3E%3C/svg%3E") center/12px no-repeat;border-color:var(--b)}
.kopt.sel b{color:var(--b)}
.kopt:focus-visible{outline:3px solid var(--b3);outline-offset:3px}
.komp-hint{display:none;align-items:center;gap:8px;background:var(--warnbg);color:var(--warn);border-radius:12px;padding:10px 14px;font-size:13.5px;font-weight:600;margin:-6px 0 18px}
.komp-hint.on{display:flex}
.komp-hint .ico{width:18px;height:18px;flex:none}
.poinv{position:relative}
input#poin{background:linear-gradient(135deg,#eef4fb,#e2ecf9);border-color:#c9d9ee;font-size:22px;font-weight:800;color:var(--b);padding:11px 64px 11px 14px;cursor:default}
.poinv span{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:700;color:var(--mute);pointer-events:none}
@media(max-width:760px){.kopt{min-height:0}}
/* ===== FORM 3 LAMPIRAN ===== */
.lamp-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin:0 0 10px}
.lamp-head .tt{display:flex;align-items:center;gap:10px;font-weight:700;font-size:14.5px;color:var(--ink)}
.lamp-head .no{width:26px;height:26px;border-radius:50%;background:linear-gradient(160deg,var(--b),var(--b3));color:#fff;font-size:13px;font-weight:800;display:grid;place-items:center;flex:none}
.lamp-head .req{font-size:11.5px;font-weight:800;color:var(--bad);background:var(--badbg);padding:3px 9px;border-radius:99px;letter-spacing:.2px}
.lamp-head .req.ok{color:var(--ok);background:var(--okbg)}
.cnt{font-size:12.5px;font-weight:700;color:var(--mute);background:#f0f4f9;padding:3px 10px;border-radius:99px;white-space:nowrap}
.cnt.full{color:var(--warn);background:var(--warnbg)}
.upl-box.full{opacity:.6;pointer-events:none;border-style:solid}
.upl-box .upl-title{margin-top:0}
.fld.lamp{margin-bottom:0}
.lamp-sep{height:1px;background:var(--l);margin:26px 0}
.fld.bad .upl-box{border-color:var(--bad);background:#fffafa}
.files-empty{font-size:13px;color:var(--mute);text-align:center;margin:10px 0 0}
ul.files{margin:12px 0 0;padding:0;list-style:none;display:grid;gap:8px}
ul.files:empty{display:none}
ul.files li{animation:fade .25s ease}
@media(max-width:760px){.upl-box{padding:20px 16px}.lamp-head .req{display:none}}
/* ===== FORM 4 RINGKASAN & PERNYATAAN ===== */
.summary-grid{gap:14px}
.summary-card{background:#fff;box-shadow:0 2px 8px rgba(11,42,77,.04);transition:border-color .15s}
.summary-card:hover{border-color:#b5d1f2}
.sc-edit{margin-top:14px;background:none;border:0;padding:0;color:var(--b);font:inherit;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:5px}
.sc-edit:hover{text-decoration:underline}
.sc-edit .ico{width:14px;height:14px}
.stmt{display:flex;gap:14px;align-items:flex-start;background:#fff;border:1.5px solid var(--l);border-radius:16px;padding:18px;cursor:pointer;transition:border-color .15s,background .15s;margin:0}
.stmt:hover{border-color:var(--b3)}
.stmt:has(input:checked){border-color:var(--b);background:#f3f8fe}
.stmt input{appearance:none;-webkit-appearance:none;width:22px;height:22px;border:2px solid #9fb6d3;border-radius:7px;margin:1px 0 0;flex:none;cursor:pointer;background:#fff;transition:.15s}
.stmt input:checked{background:var(--b) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M5 12l5 5 9-10'/%3E%3C/svg%3E") center/14px no-repeat;border-color:var(--b)}
.stmt input:focus-visible{outline:3px solid var(--b3);outline-offset:3px}
.stmt-txt{font-size:13.5px;line-height:1.65;color:var(--ink);font-weight:400}
.stmt-txt b{display:block;font-size:14.5px;margin-bottom:4px;color:var(--ink)}
.stmt-wrap.bad .stmt{border-color:var(--bad);background:#fffafa}
@media(max-width:760px){.summary-grid{grid-template-columns:1fr}.summary-list{grid-template-columns:1fr!important}}
/* ===== ANIMASI STEPPER & TIAP FORM ===== */
@keyframes stepPop{0%{transform:scale(.6);opacity:0}60%{transform:scale(1.12)}100%{transform:scale(1);opacity:1}}
@keyframes stepRing{0%{box-shadow:0 0 0 0 rgba(43,108,176,.45)}100%{box-shadow:0 0 0 12px rgba(43,108,176,0)}}
@keyframes lineGrow{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes slideIn{from{opacity:0;transform:translateX(28px)}to{opacity:1;transform:none}}
@keyframes slideBack{from{opacity:0;transform:translateX(-28px)}to{opacity:1;transform:none}}
@keyframes itemIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
.steps li{position:relative}
.steps li:before{transition:background .35s,color .35s,transform .35s}
.steps li.act:before{animation:stepPop .5s cubic-bezier(.2,.9,.3,1.2) both,stepRing 1.8s ease-out .5s infinite}
.steps li.done:before{animation:stepPop .45s cubic-bezier(.2,.9,.3,1.2) both}
.steps li.act span{animation:itemIn .4s ease both}
.steps li:not(:last-child):after{position:relative;overflow:hidden;background:var(--l);transform-origin:left center}
.steps li:not(:last-child):after{background:linear-gradient(90deg,var(--ok),var(--b3));background-size:100% 100%;transform:scaleX(0);transition:transform .5s ease}
.steps li.done:not(:last-child):after{transform:scaleX(1)}
.steps li.act:not(:last-child):after{transform:scaleX(0)}
.pane{display:none}
.pane.on{display:block;animation:slideIn .45s cubic-bezier(.2,.8,.2,1) both}
.pane.on.back{animation-name:slideBack}
.pane.on > *{animation:itemIn .45s ease both}
.pane.on > *:nth-child(1){animation-delay:.04s}
.pane.on > *:nth-child(2){animation-delay:.09s}
.pane.on > *:nth-child(3){animation-delay:.14s}
.pane.on > *:nth-child(4){animation-delay:.19s}
.pane.on > *:nth-child(5){animation-delay:.24s}
.pane.on > *:nth-child(n+6){animation-delay:.28s}
/* komponen picker */
.komp{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:18px}
.kopt{border:1.5px solid var(--l);border-radius:14px;padding:14px;cursor:pointer;background:#fff;transition:.15s;text-align:left;font:inherit}
.kopt b{display:block;font-size:14.5px;margin-bottom:3px;color:var(--ink)}
.kopt small{color:var(--mute);font-size:12.5px;line-height:1.45;display:block}
.kopt:hover{border-color:var(--b3)}
.kopt.sel{border-color:var(--b);background:#eef4fb;box-shadow:0 0 0 3px rgba(23,70,121,.12)}
.kopt.sel b{color:var(--b)}

/* uploads */
.upl-box{border:2px dashed #a8c5e8;border-radius:16px;padding:24px 20px;background:#f4f8fe;text-align:center;transition:all .2s ease;position:relative;cursor:pointer}
.upl-box:hover,.upl-box.dragover{border-color:var(--b3);background:#eef5fd;transform:translateY(-1px)}
.upl-box .upl-icon{width:48px;height:48px;border-radius:50%;background:#e1ecf9;color:var(--b);display:grid;place-items:center;margin:0 auto 10px;box-shadow:0 4px 10px rgba(23,70,121,.1)}
.upl-box .upl-icon .ico{width:24px;height:24px;stroke-width:2.2}
.upl-box .upl-title{font-size:15px;font-weight:700;color:var(--ink);margin-bottom:4px}
.upl-box .upl-sub{font-size:13px;color:var(--mute)}
.upl-box input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.upl-info-card{display:flex;align-items:center;gap:12px;background:#eef4fb;border:1px solid #d0e1f7;border-radius:12px;padding:12px 16px;margin-bottom:20px;font-size:13.5px;color:var(--b2)}
.upl-info-card .ico{width:20px;height:20px;color:var(--b3);flex:none}
ul.files{list-style:none;margin:12px 0 0;padding:0;display:flex;flex-direction:column;gap:8px}
ul.files li{display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--l);border-radius:12px;padding:10px 14px;box-shadow:0 2px 6px rgba(0,0,0,.03);transition:border-color .15s}
ul.files li:hover{border-color:#b5d1f2}
ul.files li .n{flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;font-size:14px;color:var(--ink)}
ul.files li .s{color:var(--mute);font-size:12px;background:#f0f4f9;padding:3px 8px;border-radius:6px;flex:none;font-weight:500}
ul.files li button{border:0;background:#fdeceb;color:var(--bad);width:28px;height:28px;border-radius:8px;cursor:pointer;font-size:16px;display:grid;place-items:center;line-height:1;flex:none;transition:background .15s}
ul.files li button:hover{background:#f8d7d4}
ul.files li img{width:42px;height:42px;object-fit:cover;border-radius:8px;border:1px solid var(--l);flex:none}
ul.files li .pdfi{width:42px;height:42px;border-radius:8px;background:#fdeceb;color:var(--bad);display:grid;place-items:center;font-size:11px;font-weight:800;flex:none;border:1px solid #f9cdca}

/* checkbox */
.chk{display:flex;gap:11px;align-items:flex-start;background:var(--warnbg);border:1px solid #f0dc8a;border-radius:12px;padding:14px 16px;cursor:pointer;font-size:14px;line-height:1.55;color:var(--ink)}
.chk input{width:auto;margin-top:4px;accent-color:var(--b)}

/* summary card grid */
.summary-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px}
.summary-card{background:#f8fafc;border:1px solid var(--l);border-radius:14px;padding:16px 18px;position:relative;overflow:hidden}
.summary-card.full{grid-column:1/-1}
.summary-card .sc-title{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--mute);margin-bottom:8px;display:flex;align-items:center;gap:6px}
.summary-card .sc-title .ico{width:16px;height:16px;color:var(--b3)}
.summary-card .sc-main{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:4px;line-height:1.3}
.summary-card .sc-sub{font-size:13.5px;color:var(--mute);line-height:1.5}
.summary-card .sc-badge{position:absolute;top:16px;right:18px;background:linear-gradient(135deg,var(--b2),var(--b));color:var(--y);font-size:18px;font-weight:800;padding:4px 12px;border-radius:10px;box-shadow:0 4px 10px rgba(11,42,77,.15)}
.summary-list{list-style:none;padding:0;margin:0;display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:13.5px}
.summary-list li{background:#fff;padding:8px 12px;border-radius:8px;border:1px solid var(--l);color:var(--ink)}
.summary-list li b{color:var(--mute);font-weight:600;display:block;font-size:11.5px;text-transform:uppercase;margin-bottom:2px}

/* custom submit button & pnav optimization */
.pnav{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-top:28px;padding-top:22px;border-top:1px solid var(--l)}
.btn-submit{background:linear-gradient(135deg,#0b2a4d,#174679);color:#fff;border:1px solid rgba(255,255,255,.2);border-radius:14px;padding:13px 26px;font-size:15px;font-weight:700;letter-spacing:.3px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:10px;box-shadow:0 8px 22px rgba(11,42,77,.28),inset 0 1px 0 rgba(255,255,255,.2);transition:all .2s cubic-bezier(.2,.8,.4,1);position:relative;overflow:hidden}
.btn-submit:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 12px 28px rgba(11,42,77,.38),inset 0 1px 0 rgba(255,255,255,.35);background:linear-gradient(135deg,#0e335d,#1d5796)}
.btn-submit:active:not(:disabled){transform:translateY(0);box-shadow:0 4px 14px rgba(11,42,77,.25)}
.btn-submit .ico-send{width:19px;height:19px;color:#fff;transition:transform .25s ease;flex:none}
.btn-submit:hover:not(:disabled) .ico-send{transform:translateX(3px) translateY(-2px) rotate(-8deg) scale(1.08)}
.btn-submit .spin-ico{display:none;width:18px;height:18px;border:2.5px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;flex:none}
.btn-submit.loading .ico-send{display:none}
.btn-submit.loading .spin-ico{display:inline-block}
@keyframes spin{to{transform:rotate(360deg)}}

/* overlay sukses */
.ov{position:fixed;inset:0;background:rgba(11,26,45,.55);-webkit-backdrop-filter:blur(4px);backdrop-filter:blur(4px);display:grid;place-items:center;z-index:100;padding:20px;opacity:0;visibility:hidden;transition:.25s}
.ov.on{opacity:1;visibility:visible}
.ovbox{background:#fff;border-radius:22px;padding:34px 30px 28px;text-align:center;width:min(420px,100%);box-shadow:0 24px 60px rgba(11,26,45,.45);transform:translateY(16px) scale(.96);transition:transform .35s cubic-bezier(.2,.9,.3,1.2)}
.ov.on .ovbox{transform:none}
.ckr{width:84px;height:84px;border-radius:50%;background:var(--okbg);display:grid;place-items:center;margin:0 auto 16px;animation:pop .45s cubic-bezier(.2,.9,.3,1.3)}
.ckr .ico{width:42px;height:42px;color:var(--ok);stroke-width:2.4}
@keyframes pop{from{transform:scale(0)}to{transform:scale(1)}}
.ovbox h3{margin:0 0 6px;font-size:21px}
.ovbox p{margin:0 0 6px;color:var(--mute);font-size:14px}

/* toast */
#toast{position:fixed;left:50%;bottom:24px;transform:translate(-50%,30px);background:#10233b;color:#fff;padding:11px 20px;border-radius:12px;font-size:14px;opacity:0;pointer-events:none;transition:.25s;z-index:120;max-width:88vw;text-align:center}
#toast.on{opacity:1;transform:translate(-50%,0)}

/* footer */
footer{margin-top:72px;background:var(--b2);color:#b9cde6;padding:30px 0;font-size:14px}
footer b{color:#fff}
.fwrap{display:flex;flex-wrap:wrap;gap:12px 28px;align-items:center;justify-content:space-between}
footer p{margin:0}
.js .rv{opacity:0;transform:translateY(16px);transition:opacity .6s,transform .6s}.js .rv.in{opacity:1;transform:none}
@media(prefers-reduced-motion:reduce){.js .rv{opacity:1;transform:none;transition:none}html{scroll-behavior:auto}*{animation:none!important}}
@media(max-width:760px){.hero{padding:22px 0 80px}.chip{font-size:12.5px;padding:6px 12px}.grid2{grid-template-columns:1fr}.komp{grid-template-columns:1fr}.steps li:not(.act) span{display:none}.steps li:before{margin:0 auto}.steps li{justify-content:center}.card{padding:22px 18px}.nav .bt small{display:none}.summary-list{grid-template-columns:1fr}}
@endverbatim

/* ===== UKURAN DROPDOWN ===== */
input:not([type=checkbox]),select,textarea{min-height:52px}
.cs-btn{min-height:52px;font-size:16px}
.cs-list{max-height:360px}
.cs-list [role="option"]{font-size:15.5px;padding:11px 14px}

/* ===== RINGKASAN (LANGKAH 4) ===== */
#ringkas .summary-grid{display:grid;grid-template-columns:1fr;gap:14px;margin-bottom:22px}
#ringkas .summary-card{position:relative;background:#fff;border:1px solid var(--l);border-radius:16px;padding:20px 22px;box-shadow:0 2px 10px rgba(11,42,77,.05)}
#ringkas .rk-head{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:12px}
#ringkas .sc-title{margin:0}
#ringkas .rk-badge{background:linear-gradient(135deg,var(--b2),var(--b));color:var(--y);font-weight:800;font-size:14.5px;padding:5px 14px;border-radius:99px;white-space:nowrap}
#ringkas .rk-main{font-size:17px;font-weight:700;color:var(--ink);line-height:1.35;margin-bottom:12px;overflow-wrap:anywhere}
#ringkas .rk-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
#ringkas .rk-grid2{grid-template-columns:repeat(2,1fr)}
#ringkas .rk-item{background:#f6f9fd;border:1px solid var(--l);border-radius:12px;padding:11px 14px;min-width:0}
#ringkas .rk-item b{display:block;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--mute);margin-bottom:3px}
#ringkas .rk-item span{display:block;font-size:14.5px;font-weight:600;color:var(--ink);overflow-wrap:anywhere;line-height:1.4}
#ringkas .sc-edit{margin-top:14px}
@media(min-width:761px){#ringkas .summary-grid{grid-template-columns:1fr}}
@media(max-width:760px){#ringkas .rk-grid,#ringkas .rk-grid2{grid-template-columns:1fr}#ringkas .summary-card{padding:18px 16px}}

/* ===== PERNYATAAN KEABSAHAN (LANGKAH 4): centang & teks sejajar ===== */
.stmt-wrap{margin-top:22px}
.stmt{align-items:center;gap:18px;padding:22px 24px;border-radius:16px}
#setuju,.stmt input[type=checkbox]{width:24px;height:24px;min-width:24px;min-height:24px;padding:0;margin:0;border-radius:7px;box-sizing:border-box}
.stmt-txt{flex:1;min-width:0;font-size:14px;line-height:1.7;color:var(--mute);margin:0}
.stmt-txt b{font-size:15px;line-height:24px;margin:0 0 6px;color:var(--ink)}
.stmt:has(input:checked) .stmt-txt{color:var(--ink)}
@media(max-width:760px){.stmt{padding:18px 16px;gap:14px}#setuju,.stmt input[type=checkbox]{width:22px;height:22px;min-width:22px;min-height:22px}}

/* ===== ANIMASI METEOR ===== */
.meteors{position:absolute;inset:0;overflow:hidden;pointer-events:none;z-index:0}
.meteors i{position:absolute;top:-110px;width:1.5px;border-radius:2px;background:linear-gradient(to bottom,transparent,rgba(255,255,255,.55));opacity:0;transform:translate3d(0,0,0) rotate(35deg);animation:meteor linear infinite;will-change:transform,opacity}
.meteors i:after{content:"";position:absolute;left:50%;bottom:0;width:3px;height:3px;margin-left:-1.5px;border-radius:50%;background:rgba(255,255,255,.7);box-shadow:0 0 6px 1px rgba(255,255,255,.35)}
@keyframes meteor{0%{transform:translate3d(0,0,0) rotate(35deg);opacity:0}10%{opacity:var(--o,.6)}70%{opacity:var(--o,.6)}100%{transform:translate3d(-290px,415px,0) rotate(35deg);opacity:0}}
@media(prefers-reduced-motion:reduce){.meteors{display:none}}
</style>
</head>
<body>
<script>document.documentElement.classList.add('js')</script>

<!-- Sprite ikon + logo (inline, tidak perlu file terpisah) -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
<symbol id="i-back" viewBox="0 0 24 24"><path d="M19 12H5M11 18l-6-6 6-6"/></symbol>
<symbol id="i-next" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
<symbol id="i-up" viewBox="0 0 24 24"><path d="M12 16V4M7 9l5-5 5 5M4 20h16"/></symbol>
<symbol id="i-doc" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></symbol>
<symbol id="i-check" viewBox="0 0 24 24"><path d="M9 11l3 3 8-8"/><path d="M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h9"/></symbol>
<symbol id="i-lock" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></symbol>
<symbol id="i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></symbol>
<symbol id="i-send" viewBox="0 0 24 24"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
<symbol id="i-akt" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></symbol>
<symbol id="i-logo" viewBox="97 37.5 285 285"><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 320.917969 138.761719 C 315.0625 133.617188 308.199219 129.585938 300.800781 127.121094 C 295.324219 125.265625 289.5 124.296875 283.714844 124.695312 C 279.847656 124.953125 275.960938 125.8125 272.535156 127.675781 C 270.648438 128.699219 266.777344 130.941406 264.40625 135.566406 C 263.472656 137.386719 263.042969 139.050781 262.828125 140.199219 C 262.222656 140.601562 261.339844 141.167969 260.230469 141.789062 C 250.75 147.085938 241.40625 146.957031 238.457031 146.882812 C 228.554688 146.640625 220.792969 142.953125 216.136719 140.867188 C 215.527344 140.59375 215.027344 140.359375 214.683594 140.199219 C 214.316406 137.808594 213.113281 132.171875 208.835938 128.222656 C 205.921875 125.535156 201.542969 123.597656 200.148438 123.015625 C 199.464844 122.726562 198.882812 122.511719 198.484375 122.367188 C 198.332031 122.21875 198.113281 121.996094 197.859375 121.71875 C 192.796875 116.042969 193.886719 107.554688 194.214844 104.984375 C 195.074219 98.269531 198.265625 93.449219 200.21875 90.96875 C 202.851562 90.070312 205.785156 88.890625 208.898438 87.328125 C 211.476562 86.035156 213.765625 84.683594 215.761719 83.378906 C 237.226562 76.925781 249.964844 79.054688 257.75 82.480469 C 258.933594 83.003906 259.667969 83.300781 262.628906 84.734375 C 271.90625 89.246094 281.292969 93.746094 291.527344 94.738281 C 297.539062 95.25 303.804688 95.007812 309.410156 92.550781 C 312.101562 91.40625 314.5 89.214844 315.308594 86.332031 C 316.007812 83.847656 315.109375 81.25 313.894531 79.085938 C 311.820312 75.554688 308.566406 72.917969 305.21875 70.664062 C 296.96875 65.453125 287.457031 62.246094 277.742188 61.351562 C 273.53125 60.972656 269.253906 60.945312 265.078125 61.730469 C 261.941406 62.300781 258.757812 63.332031 256.316406 65.464844 C 255.28125 66.347656 254.585938 67.535156 253.71875 68.570312 C 252.914062 69.546875 251.675781 69.984375 250.507812 70.347656 C 247.835938 71.136719 245.054688 71.476562 242.285156 71.6875 C 237.21875 71.988281 232.101562 71.71875 227.125 70.707031 C 225.65625 70.359375 224.132812 70.046875 222.820312 69.261719 C 221.675781 68.511719 221.089844 67.207031 220.175781 66.230469 C 218.320312 64.171875 215.703125 62.996094 213.074219 62.277344 C 208.277344 60.988281 203.242188 60.882812 198.316406 61.300781 C 191.933594 61.847656 185.664062 63.472656 179.734375 65.886719 C 175.832031 67.457031 172.09375 69.464844 168.675781 71.929688 C 165.613281 74.179688 162.824219 76.96875 161.125 80.40625 C 159.664062 83.402344 159.921875 87.402344 162.398438 89.796875 C 165.457031 92.828125 169.792969 94.101562 173.976562 94.589844 C 175.324219 94.789062 176.730469 94.722656 178.050781 95.132812 C 178.746094 95.523438 179.109375 96.285156 179.472656 96.964844 C 181.324219 100.714844 181.457031 105.105469 180.566406 109.136719 C 179.625 113.304688 177.886719 117.292969 175.511719 120.839844 C 174.046875 123.097656 172.386719 125.371094 169.976562 126.691406 C 168.273438 127.617188 166.511719 128.421875 164.859375 129.4375 C 156.003906 134.691406 148.335938 142.296875 143.984375 151.714844 C 141.257812 157.714844 140.082031 164.800781 142.433594 171.117188 C 144.71875 177.386719 150.648438 181.800781 157.023438 183.277344 C 166.273438 185.550781 176.046875 183.65625 184.640625 179.914062 C 190.605469 177.375 195.960938 173.59375 200.820312 169.339844 C 202.09375 168.234375 203.261719 167.003906 204.648438 166.039062 C 209.96875 162.394531 216.144531 160.15625 222.433594 158.871094 C 229.097656 157.535156 235.925781 157.109375 242.710938 157.308594 C 252.890625 157.8125 263.125 161.082031 271.117188 167.539062 C 273.441406 169.359375 275.351562 171.632812 277.613281 173.53125 C 285.566406 180.382812 295.371094 185.25 305.8125 186.71875 C 310.308594 187.339844 314.949219 187.441406 319.378906 186.328125 C 323.992188 185.210938 328.453125 182.902344 331.503906 179.1875 C 333.746094 176.515625 335.125 173.164062 335.566406 169.707031 C 336.144531 164.984375 335.289062 160.164062 333.453125 155.796875 C 330.699219 149.230469 326.25 143.445312 320.917969 138.761719 Z M 320.917969 138.761719 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 237.648438 61.242188 C 250.972656 61.242188 261.769531 56.507812 261.769531 50.667969 C 261.769531 44.832031 250.972656 40.097656 237.648438 40.097656 C 224.328125 40.097656 213.53125 44.832031 213.53125 50.667969 C 213.53125 56.507812 224.328125 61.242188 237.648438 61.242188 Z M 237.648438 61.242188 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 146.707031 131.722656 C 160.132812 115.695312 163.96875 96.792969 155.277344 89.507812 C 146.585938 82.222656 128.65625 89.308594 115.230469 105.339844 C 101.804688 121.367188 97.96875 140.269531 106.660156 147.554688 C 115.355469 154.839844 133.28125 147.753906 146.707031 131.722656 Z M 146.707031 131.722656 " /><path fill="#f3c813" fill-opacity="1" fill-rule="nonzero" d="M 364.542969 105.339844 C 351.117188 89.308594 333.1875 82.222656 324.496094 89.507812 C 323.011719 90.753906 321.921875 92.359375 321.152344 94.210938 C 320.660156 95.414062 320.167969 96.621094 319.679688 97.824219 C 319.183594 98.9375 318.167969 99.679688 317.183594 100.335938 C 314.046875 102.363281 310.527344 103.726562 306.9375 104.703125 C 300.78125 106.34375 294.359375 106.730469 288.015625 106.523438 C 282.160156 106.292969 276.253906 105.671875 270.6875 103.765625 C 268.527344 103.003906 266.335938 102.136719 264.59375 100.605469 C 262.878906 99.113281 261.398438 97.347656 259.480469 96.09375 C 253.210938 91.910156 245.582031 90.09375 238.097656 90.207031 C 232.839844 90.183594 227.574219 91.179688 222.714844 93.195312 C 218.300781 95.050781 214.21875 97.945312 211.476562 101.917969 C 208.769531 105.789062 208.136719 111.027344 209.855469 115.4375 C 211.109375 118.640625 213.441406 121.316406 216.136719 123.410156 C 219.25 125.8125 222.871094 127.507812 226.640625 128.582031 C 237.058594 131.601562 248.773438 130.636719 258.214844 125.136719 C 259.964844 124.128906 261.785156 123.25 263.566406 122.296875 C 269.242188 119.265625 274.4375 117.167969 276.28125 116.460938 C 284.492188 113.300781 296.527344 113.371094 306.855469 116.089844 C 311.777344 117.382812 323.839844 120.488281 332.421875 130.949219 C 332.589844 131.15625 332.894531 131.519531 333.066406 131.722656 C 346.492188 147.753906 364.421875 154.839844 373.113281 147.554688 C 381.804688 140.269531 377.96875 121.367188 364.542969 105.339844 Z M 364.542969 105.339844 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 237.648438 169.558594 C 216.578125 169.558594 199.492188 186.648438 199.492188 207.734375 C 199.492188 228.816406 216.578125 245.90625 237.648438 245.90625 C 258.722656 245.90625 275.808594 228.816406 275.808594 207.734375 C 275.808594 186.648438 258.722656 169.558594 237.648438 169.558594 Z M 237.648438 169.558594 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 173.007812 295.339844 L 195.863281 295.339844 C 201.945312 295.339844 203.550781 293.539062 203.550781 287.417969 L 203.550781 281.011719 C 203.550781 274.960938 201.945312 273.089844 195.863281 273.089844 L 180.628906 273.089844 C 174.617188 273.089844 173.007812 274.960938 173.007812 281.011719 Z M 163.015625 319.898438 L 163.015625 279.066406 C 163.015625 268.625 167.070312 264.449219 179.648438 264.449219 L 196.84375 264.449219 C 209.421875 264.449219 213.476562 268.625 213.476562 279.066406 L 213.476562 289.4375 C 213.476562 299.875 209.421875 303.984375 196.84375 303.984375 L 173.007812 303.984375 L 173.007812 314.675781 C 173.007812 317.558594 170.597656 319.898438 167.621094 319.898438 Z M 163.015625 319.898438 " /><path fill="#f3c813" fill-opacity="1" fill-rule="nonzero" d="M 237.53125 279.898438 C 233.078125 279.898438 229.441406 282.894531 229.441406 287.214844 L 229.441406 288.113281 L 262.699219 288.113281 L 262.699219 278.015625 C 262.699219 269.308594 260.167969 264.433594 250.582031 264.433594 L 230.121094 264.433594 C 217.539062 264.433594 213.476562 268.617188 213.476562 279.050781 L 213.476562 289.449219 C 213.476562 299.882812 217.539062 303.996094 230.121094 303.996094 L 259.675781 303.996094 C 259.675781 299.191406 255.648438 295.320312 250.730469 295.320312 L 231.085938 295.320312 C 225.027344 295.320312 223.386719 293.457031 223.386719 288.933594 L 223.386719 278.636719 C 223.457031 274.179688 225.097656 272.453125 231.085938 272.453125 L 248.65625 272.453125 C 251.863281 272.453125 252.898438 273.589844 252.898438 276.5625 L 252.898438 279.898438 Z M 237.53125 279.898438 " /><path fill="#174679" fill-opacity="1" fill-rule="nonzero" d="M 353.617188 292.171875 C 353.617188 294.621094 352.570312 295.628906 349.703125 295.628906 L 316.027344 295.628906 L 316.027344 281.9375 C 317.324219 285.386719 320.5 287.203125 326.222656 287.203125 L 349.703125 287.203125 C 352.570312 287.203125 353.617188 288.355469 353.617188 290.230469 Z M 352.359375 303.984375 C 360.609375 303.984375 363.332031 300.238281 363.332031 293.902344 L 363.332031 289.867188 C 363.332031 283.675781 360.257812 280.21875 352.429688 280.21875 L 328.878906 280.21875 C 326.011719 280.21875 325.03125 279.066406 325.03125 277.121094 L 325.03125 276.042969 C 325.03125 273.953125 326.011719 272.800781 328.878906 272.800781 L 353.039062 272.800781 C 357.796875 272.800781 361.65625 269.0625 361.65625 264.449219 L 326.292969 264.449219 C 318.644531 264.449219 315.75 267.796875 315.367188 273.046875 C 313.800781 266.996094 309.1875 264.449219 299.390625 264.449219 L 279.335938 264.449219 C 266.753906 264.449219 262.699219 268.625 262.699219 279.066406 L 262.699219 303.984375 L 272.695312 303.984375 L 272.695312 281.511719 C 272.695312 275.464844 274.300781 273.59375 280.3125 273.59375 L 298.902344 273.59375 C 304.914062 273.59375 306.101562 275.464844 306.101562 281.511719 L 306.101562 303.984375 Z M 352.359375 303.984375 "/></symbol>
</defs></svg>

<nav class="nav" aria-label="Navigasi utama"><div class="w nv">
  <a class="brand" href="{{ url('/') }}" aria-label="Kembali ke beranda SKEM PENS"><i><svg aria-hidden="true"><use href="#i-logo"/></svg></i><span class="bt"><b>SKEM <span>PENS</span></b><small>Satuan Kredit Ekstrakurikuler Mahasiswa</small></span></a>
  <a class="btn g" href="{{ url('/') }}"><svg class="ico"><use href="#i-back"/></svg> Beranda</a>
</div></nav>

<header class="hero"><div class="meteors" aria-hidden="true"></div><div class="w">
  <div class="crumbs rv"><a href="{{ url('/') }}">Beranda</a><svg class="ico"><use href="#i-next"/></svg><span>Pengajuan SKEM</span></div>
  <h1 class="rv">Ajukan <em>Klaim SKEM</em></h1>
  <p class="sub rv">Lengkapi data kegiatan, unggah formulir dan bukti pendukung resmi.<br>Klaim poin SKEM dapat diajukan maksimal 1 tahun setelah kegiatan.</p>
  <div class="chips rv">
    <span class="chip"><svg class="ico"><use href="#i-check"/></svg>4 langkah singkat</span>
    <span class="chip"><svg class="ico"><use href="#i-lock"/></svg>Data tersimpan otomatis</span>
    <span class="chip"><svg class="ico"><use href="#i-up"/></svg>Maks. 1 tahun setelah kegiatan</span>
  </div>
</div></header>

<div class="w" style="position:relative;z-index:2;margin-top:-56px;padding-bottom:60px">
  <div class="card rv">
    <ol class="steps" id="steps">
      <li class="act" data-s="1"><span>Identitas</span></li>
      <li data-s="2"><span>Kegiatan &amp; Poin</span></li>
      <li data-s="3"><span>Lampiran</span></li>
      <li data-s="4"><span>Pernyataan &amp; Kirim</span></li>
    </ol>

    <!-- PANE 1 : IDENTITAS -->
    <section class="pane on" id="pane1" aria-label="Langkah 1: Identitas mahasiswa">
      <h3 class="pt">Identitas Mahasiswa</h3>
      <p class="pm">Pastikan data sesuai dengan data akademik KTM.</p>
      <div class="idbanner" id="idBanner" hidden><svg class="ico"><use href="#i-check"/></svg><span>Data identitas diisi otomatis dari pengajuan sebelumnya.</span><button type="button" id="idClear">Kosongkan</button></div>
      <div class="subh">Data diri</div>
      <div class="grid2">
        <div class="fld"><label for="nama">Nama lengkap *</label><input id="nama" placeholder="Sesuai KTM" autocomplete="name"><p class="err">Nama wajib diisi.</p></div>
        <div class="fld"><label for="nrp">NRP * <small>(10 digit)</small></label><input id="nrp" maxlength="10" inputmode="numeric" pattern="[0-9]*" placeholder="31256xxxxx"><p class="hint" id="nrpHint"><span></span><b id="nrpCount">0/10</b></p><p class="err">NRP harus 10 digit angka.</p></div>
      </div>
      <div class="subh">Program studi &amp; departemen</div>
      <div class="grid2">
        <div class="fld">
          <label for="prodi">Program studi *</label>
          <select id="prodi" name="study_program_id">
            <option value="">— Pilih Program Studi —</option>
            @foreach($grup as $dept => $items)
              <optgroup label="{{ $dept }}">
                @foreach($items as $prodi)
                  <option value="{{ $prodi->id }}" data-dept="{{ $dept }}">{{ $prodi->name }}</option>
                @endforeach
              </optgroup>
            @endforeach
          </select>
          <p class="err">Program studi wajib dipilih.</p>
        </div>
        <div class="fld">
          <label for="dept">Departemen</label>
          <input id="dept" name="department_name" readonly tabindex="-1" placeholder="Terisi otomatis dari program studi">
          <p class="hint">Mengikuti program studi yang dipilih.</p>
        </div>
      </div>
      <div class="pnav"><span></span><button class="btn y" data-go="2" type="button">Lanjut: Kegiatan <svg class="ico"><use href="#i-next"/></svg></button></div>
    </section>

    <!-- PANE 2 : KEGIATAN & POIN -->
    <section class="pane" id="pane2" aria-label="Langkah 2: Informasi kegiatan dan estimasi poin">
      <h3 class="pt">Informasi Kegiatan</h3>
      <p class="pm">Pilih komponen dan jenis kegiatan. Estimasi poin mengacu pada pedoman SKEM PENS resmi.</p>
      <div class="subh">Komponen SKEM *</div>
      <div class="komp-hint on" id="kompHint"><svg class="ico"><use href="#i-akt"/></svg>Pilih salah satu komponen untuk membuka jenis kegiatan.</div>
      <div class="komp" id="komp">
        <button type="button" class="kopt" data-k="1"><b>Kredit 1</b><small>Interpersonal &amp; Manajerial — ditentukan kampus (PKKMB, OPP, LKMM)</small></button>
        <button type="button" class="kopt" data-k="2"><b>Kredit 2</b><small>Pengembangan Spiritual — ditentukan kampus (mentoring keagamaan)</small></button>
        <button type="button" class="kopt" data-k="3"><b>Kredit 3</b><small>Minat, Bakat, Organisasi &amp; Kompetisi — pilihan bebas mahasiswa</small></button>
      </div>
      <div class="subh">Detail kegiatan</div>
      <div class="fld"><label for="jenis">Jenis kegiatan *</label><select id="jenis" disabled><option value="">Pilih komponen terlebih dahulu</option></select><p class="err">Jenis kegiatan wajib dipilih.</p></div>
      <div class="subh">Penilaian</div>
      <div class="grid2">
        <div class="fld"><label for="peran">Peran / perolehan *</label><select id="peran" disabled><option value="">Pilih jenis kegiatan terlebih dahulu</option></select><p class="err">Peran wajib dipilih.</p></div>
        <div class="fld"><label for="poin">Estimasi poin SKEM</label><div class="poinv"><input id="poin" readonly value="—"><span>poin</span></div><p class="hint">Ditentukan otomatis dari pedoman resmi PENS. Nilai final oleh verifikator.</p></div>
      </div>
      <div class="pnav"><button class="btn o" data-go="1" type="button"><svg class="ico"><use href="#i-back"/></svg> Kembali</button><button class="btn y" data-go="3" type="button">Lanjut: Lampiran <svg class="ico"><use href="#i-next"/></svg></button></div>
    </section>

    <!-- PANE 3 : LAMPIRAN -->
    <section class="pane" id="pane3" aria-label="Langkah 3: Lampiran bukti">
      <h3 class="pt">Lampiran Bukti</h3>
      
      <div class="upl-info-card">
        <svg class="ico"><use href="#i-doc"/></svg>
        <span>Pastikan dokumen terbaca dengan jelas. Maksimal ukuran file <strong>5 MB</strong> per dokumen.</span>
      </div>

      <div class="fld lamp" id="fldForm">
        <div class="lamp-head"><div class="tt"><span class="no">1</span>Formulir kegiatan SKEM (PDF)</div><div style="display:flex;gap:8px;align-items:center"><span class="cnt" id="cntForm">0/1 file</span><span class="req" id="reqForm">Wajib</span></div></div>
        <div class="upl-box">
          <div class="upl-icon"><svg class="ico"><use href="#i-doc"/></svg></div>
          <div class="upl-title">Klik atau tarik file PDF formulir ke sini</div>
          <div class="upl-sub">Format PDF · Maksimal 5 MB</div>
          <input type="file" id="fFormulir" accept="application/pdf,.pdf">
        </div>
        <ul class="files" id="listFormulir"></ul>
        <p class="err" id="errFormulir" style="display:none">Formulir PDF wajib dilampirkan.</p>
      </div>

      <div class="lamp-sep"></div>

      <div class="fld lamp" id="fldBukti">
        <div class="lamp-head"><div class="tt"><span class="no">2</span>Bukti kegiatan <span style="font-weight:500;color:var(--mute)">(sertifikat / piagam / dokumentasi)</span></div><div style="display:flex;gap:8px;align-items:center"><span class="cnt" id="cntBukti">0/6 file</span><span class="req" id="reqBukti">Wajib</span></div></div>
        <div class="upl-box">
          <div class="upl-icon"><svg class="ico"><use href="#i-up"/></svg></div>
          <div class="upl-title">Klik atau tarik bukti kegiatan ke sini</div>
          <div class="upl-sub">Format JPG, PNG, atau PDF · Maks. 6 file (masing-masing 5 MB)</div>
          <input type="file" id="fBukti" accept="image/*,.jpg,.jpeg,.png,.webp,.pdf" multiple>
        </div>
        <ul class="files" id="listBukti"></ul>
        <p class="err" id="errBukti" style="display:none">Minimal 1 bukti kegiatan wajib dilampirkan.</p>
      </div>

      <div class="pnav"><button class="btn o" data-go="2" type="button"><svg class="ico"><use href="#i-back"/></svg> Kembali</button><button class="btn y" data-go="4" type="button">Lanjut: Pernyataan <svg class="ico"><use href="#i-next"/></svg></button></div>
    </section>

    <!-- PANE 4 : PERNYATAAN & KIRIM -->
    <section class="pane" id="pane4" aria-label="Langkah 4: Pernyataan dan kirim">
      <h3 class="pt">Ringkasan &amp; Pernyataan</h3>
      <p class="pm">Periksa kembali ringkasan pengajuan Anda sebelum menyetujui dan mengirimkan data.</p>
      
      <div id="ringkas"></div>

      <div class="fld stmt-wrap" style="margin-top:22px">
        <label class="stmt" id="chkStmt">
          <input type="checkbox" id="setuju">
          <span class="stmt-txt"><b>Pernyataan keabsahan data</b>Saya menyatakan bahwa seluruh data dan berkas dokumen yang dilampirkan adalah benar, sah, serta dapat dipertanggungjawabkan. Apabila di kemudian hari ditemukan ketidaksesuaian data, saya bersedia menerima sanksi akademik sesuai ketentuan kampus PENS yang berlaku.</span>
        </label>
        <p class="err" id="errSetuju" style="display:none;margin-top:8px">Anda wajib menyetujui pernyataan keabsahan data sebelum mengirim pengajuan.</p>
      </div>

      <div class="pnav">
        <button class="btn o" data-go="3" type="button"><svg class="ico"><use href="#i-back"/></svg> Kembali</button>
        <button class="btn-submit" id="kirim" type="button">
          <span class="btn-txt">Kirim Pengajuan SKEM</span>
          <svg class="ico ico-send"><use href="#i-send"/></svg>
          <span class="spin-ico"></span>
        </button>
      </div>
    </section>
  </div>
</div>

<div class="ov" id="ovOk" role="dialog" aria-modal="true"><div class="ovbox">
  <div class="ckr"><svg class="ico"><use href="#i-check"/></svg></div>
  <h3>Pengajuan berhasil dikirim!</h3>
  <p>Pengajuan Anda akan diproses dan diverifikasi oleh verifikator serta validator SKEM PENS.</p>
  <p id="regNo" hidden style="margin-top:10px;font-weight:800;color:var(--b)"></p>
  <div style="display:flex;gap:10px;margin-top:20px"><button class="btn o" id="ovLagi" style="flex:1;justify-content:center">Ajukan Lagi</button><button class="btn y" id="ovClose" style="flex:1;justify-content:center">Pantau Status</button></div>
</div></div>

<footer><div class="w fwrap"><span><b>SKEM PENS</b> — Politeknik Elektronika Negeri Surabaya</span><p>Alat bantu mahasiswa. Selalu rujuk pedoman SKEM resmi kampus untuk ketentuan terbaru.</p></div></footer>
<div id="toast" role="status"></div>

<script>
window.SKEM_CFG = {
    storeUrl: @json(route('skem.store')),
    trackUrl: @json(route('skem.track')),
    csrf: @json(csrf_token()),
};
</script>
<script>
@verbatim
/* Katalog poin resmi — Pedoman SKEM PENS.
   Format: SKEM_POIN[komponen].items[jenis] = [[peran, poin], ...]
   Hanya untuk tampilan/estimasi; nilai final tetap dihitung & divalidasi di server. */
window.SKEM_POIN = {
  1: { label:'Kredit 1 — Interpersonal & Manajerial', items:{
    'PKKMB (Pengenalan Kehidupan Kampus Mahasiswa Baru)': [['Peserta', 0.35]],
    'OPP (Orientasi Program Pendidikan)': [['Peserta', 0.20]],
    'LKMM Pra-TD (Pra-Tahap Dasar)': [['Peserta', 0.30]],
    'LKMM TD (Tahap Dasar)': [['Peserta', 0.40]]
  }},
  2: { label:'Kredit 2 — Pengembangan Spiritual', items:{
    'Mentoring Keagamaan (1 Semester)': [['Peserta / Mentee', 0.50]]
  }},
  3: { label:'Kredit 3 — Minat, Bakat, Organisasi & Kompetisi', items:{
    // A. Organisasi dan Kepemimpinan
    'Pengurus Organisasi (Internasional)': [['Ketua (1 Periode)', 1.50], ['Wakil Ketua (1 Periode)', 1.30], ['Pengurus Inti Lain (1 Periode)', 1.00], ['Anggota Pengurus (1 Periode)', 0.60]],
    'Pengurus Organisasi (Nasional)': [['Ketua (1 Periode)', 1.20], ['Wakil Ketua (1 Periode)', 1.00], ['Pengurus Inti Lain (1 Periode)', 0.80], ['Anggota Pengurus (1 Periode)', 0.50]],
    'Pengurus Organisasi (Kampus)': [['Ketua (1 Periode)', 1.00], ['Wakil Ketua (1 Periode)', 0.80], ['Pengurus Inti Lain (1 Periode)', 0.60], ['Anggota Pengurus (1 Periode)', 0.40]],
    'Pengurus Organisasi (Hima / Prodi)': [['Ketua (1 Periode)', 0.90], ['Wakil Ketua (1 Periode)', 0.70], ['Pengurus Inti Lain (1 Periode)', 0.50], ['Anggota Pengurus (1 Periode)', 0.30]],
    'Pengurus UKM / Tim Kompetisi': [['Ketua (1 Periode)', 0.90], ['Wakil Ketua (1 Periode)', 0.70], ['Pengurus Inti Lain (1 Periode)', 0.50], ['Anggota Pengurus (1 Periode)', 0.30]],
    'Pengurus BSO (Program Studi)': [['Ketua (1 Periode)', 0.70], ['Wakil Ketua (1 Periode)', 0.50], ['Pengurus Inti Lain (1 Periode)', 0.30], ['Anggota Pengurus (1 Periode)', 0.20]],
    'Panitia Kegiatan (Internasional)': [['Ketua (1 Kegiatan)', 1.20], ['Wakil Ketua (1 Kegiatan)', 1.10], ['Panitia Inti Lain (1 Kegiatan)', 0.60], ['Anggota Panitia (1 Kegiatan)', 0.40]],
    'Panitia Kegiatan (Nasional)': [['Ketua (1 Kegiatan)', 1.00], ['Wakil Ketua (1 Kegiatan)', 0.90], ['Panitia Inti Lain (1 Kegiatan)', 0.50], ['Anggota Panitia (1 Kegiatan)', 0.30]],
    'Panitia Kegiatan (Kampus)': [['Ketua (1 Kegiatan)', 0.70], ['Wakil Ketua (1 Kegiatan)', 0.50], ['Panitia Inti Lain (1 Kegiatan)', 0.30], ['Anggota Panitia (1 Kegiatan)', 0.10]],
    'Panitia Kegiatan (Prodi)': [['Ketua (1 Kegiatan)', 0.30], ['Wakil Ketua (1 Kegiatan)', 0.20], ['Panitia Inti Lain (1 Kegiatan)', 0.10], ['Anggota Panitia (1 Kegiatan)', 0.05]],
    'Pelatihan LKMM Lanjut / Menengah': [['Peserta LKMM Lanjut', 0.70], ['Peserta LKMM Menengah', 0.60]],

    // B. Penalaran, Kreativitas & Kewirausahaan
    'Lomba Karya Ilmiah / Inovasi (Internasional)': [['Juara I', 1.50], ['Juara II', 1.40], ['Juara III', 1.30], ['Penghargaan Lain', 1.00], ['Peserta', 0.60]],
    'Lomba Karya Ilmiah / Inovasi (Nasional)': [['Juara I', 1.20], ['Juara II', 1.10], ['Juara III', 1.00], ['Penghargaan Lain', 0.60], ['Peserta', 0.40]],
    'Lomba Karya Ilmiah / Inovasi (Regional)': [['Juara I', 0.80], ['Juara II', 0.70], ['Juara III', 0.60], ['Penghargaan Lain', 0.50], ['Peserta', 0.20]],
    'Lomba Karya Ilmiah / Inovasi (Kampus)': [['Juara I', 0.60], ['Juara II', 0.50], ['Juara III', 0.40], ['Penghargaan Lain', 0.30], ['Peserta', 0.10]],
    'Pendanaan Proposal (Penelitian / PKM)': [['Ketua (Internasional)', 0.90], ['Anggota (Internasional)', 0.30], ['Ketua (Nasional)', 0.70], ['Anggota (Nasional)', 0.20], ['Ketua (Regional)', 0.50], ['Anggota (Regional)', 0.15], ['Ketua (Kampus)', 0.40], ['Anggota (Kampus)', 0.10]],
    'Forum Ilmiah / Seminar (Internasional)': [['Pembicara', 1.50], ['Moderator', 0.60], ['Peserta Luring', 0.25], ['Peserta Daring', 0.20]],
    'Forum Ilmiah / Seminar (Nasional)': [['Pembicara', 1.30], ['Moderator', 0.50], ['Peserta Luring', 0.20], ['Peserta Daring', 0.15]],
    'Forum Ilmiah / Seminar (Regional)': [['Pembicara', 1.10], ['Moderator', 0.40], ['Peserta Luring', 0.15], ['Peserta Daring', 0.10]],
    'Forum Ilmiah / Seminar (Kampus)': [['Pembicara', 0.90], ['Moderator', 0.30], ['Peserta Luring', 0.10], ['Peserta Daring', 0.05]],
    'Workshop / Pelatihan (Internasional)': [['Pembicara', 1.10], ['Moderator', 0.50], ['Peserta Luring', 0.25], ['Peserta Daring', 0.20]],
    'Workshop / Pelatihan (Nasional)': [['Pembicara', 0.90], ['Moderator', 0.40], ['Peserta Luring', 0.20], ['Peserta Daring', 0.15]],
    'Workshop / Pelatihan (Regional)': [['Pembicara', 0.70], ['Moderator', 0.30], ['Peserta Luring', 0.15], ['Peserta Daring', 0.10]],
    'Workshop / Pelatihan (Kampus)': [['Pembicara', 0.50], ['Moderator', 0.20], ['Peserta Luring', 0.10], ['Peserta Daring', 0.05]],
    'Hak Cipta (IPTEK)': [['Ketua', 0.20], ['Anggota', 0.10]],
    'Paten / Desain Industri': [['Ketua', 1.00], ['Anggota', 0.30]],
    'Publikasi Jurnal Ilmiah': [['Ketua (Internasional Bereputasi)', 1.20], ['Anggota (Internasional Bereputasi)', 0.80], ['Ketua (Nasional S1-S2)', 0.80], ['Anggota (Nasional S1-S2)', 0.40], ['Ketua (Nasional S3-S4)', 0.60], ['Anggota (Nasional S3-S4)', 0.30], ['Ketua (Nasional S5-S6)', 0.40], ['Anggota (Nasional S5-S6)', 0.20], ['Ketua (Tidak Terakreditasi)', 0.30], ['Anggota (Tidak Terakreditasi)', 0.10]],
    'Konferensi Ilmiah': [['Ketua (Internasional Bereputasi)', 0.80], ['Anggota (Internasional Bereputasi)', 0.40], ['Ketua (Internasional)', 0.60], ['Anggota (Internasional)', 0.30], ['Ketua (Nasional)', 0.40], ['Anggota (Nasional)', 0.10]],
    'Mahasiswa Berprestasi (Mawapres)': [['Juara I (Nasional)', 1.20], ['Juara II (Nasional)', 1.10], ['Juara III (Nasional)', 1.00], ['Penghargaan Lain (Nasional)', 0.60], ['Juara I (Regional)', 0.80], ['Juara II (Regional)', 0.70], ['Juara III (Regional)', 0.60], ['Penghargaan Lain (Regional)', 0.50], ['Juara I (Kampus)', 0.60], ['Juara II (Kampus)', 0.50], ['Juara III (Kampus)', 0.40], ['Penghargaan Lain (Kampus)', 0.30]],
    'Wirausaha Mandiri': [['Ketua PT', 1.20], ['Anggota PT', 0.50], ['Ketua CV', 0.90], ['Anggota CV', 0.30], ['Ketua UD', 0.70], ['Anggota UD', 0.10], ['Ketua Usaha Mandiri', 0.50], ['Anggota Usaha Mandiri', 0.05]],

    // C. Minat dan Bakat
    'Prestasi Minat & Bakat (Olahraga, Seni, Kerohanian)': [['Juara I (Internasional)', 1.50], ['Juara II (Internasional)', 1.40], ['Juara III (Internasional)', 1.30], ['Penghargaan Lain (Internasional)', 1.00], ['Peserta (Internasional)', 0.60], ['Juara I (Nasional)', 1.20], ['Juara II (Nasional)', 1.10], ['Juara III (Nasional)', 1.00], ['Penghargaan Lain (Nasional)', 0.60], ['Peserta (Nasional)', 0.40], ['Juara I (Regional)', 0.80], ['Juara II (Regional)', 0.70], ['Juara III (Regional)', 0.60], ['Penghargaan Lain (Regional)', 0.50], ['Peserta (Regional)', 0.20], ['Juara I (Kampus)', 0.60], ['Juara II (Kampus)', 0.50], ['Juara III (Kampus)', 0.40], ['Penghargaan Lain (Kampus)', 0.30], ['Peserta (Kampus)', 0.10]],
    'Pelatih / Pembimbing Minat Bakat': [['Nasional', 0.80], ['Regional', 0.60], ['Kampus', 0.30], ['Sekolah', 0.20]],
    'Karya Seni (Konser, Pameran, Puisi, Foto, Teater)': [['Nasional', 1.10], ['Regional', 0.90], ['Kampus', 0.70]],

    // D. Kegiatan Lainnya
    'Upacara Bendera': [['Peserta / Petugas', 0.10]],
    'Tim PPK PENS (1 Semester)': [['Anggota Tim', 0.35]],
    'Pemadu LKMM': [['Pemadu', 0.40]],
    'Asisten Peneliti / Laboratorium (1 Semester)': [['Asisten', 0.35]],
    'Mentor Keagamaan (1 Periode Mentoring)': [['Mentor', 0.50]]
  }}
};

/* Wizard pengajuan SKEM — dipindahkan dari skem-ajukan.html, dihubungkan ke Laravel. */
const $ = id => document.getElementById(id);
const toastEl = $('toast'); let tm;
const toast = m => { toastEl.textContent = m; toastEl.classList.add('on'); clearTimeout(tm); tm = setTimeout(() => toastEl.classList.remove('on'), 2400); };

/* ================= DATA POIN RESMI (Pedoman SKEM PENS) ================= */
const POIN = window.SKEM_POIN;
const FIDS = ['nama','nrp','prodi'];
const CFG = window.SKEM_CFG || {};
const esc = s => String(s ?? '').replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));

let komponen = 0, filesFormulir = [], filesBukti = [];

function prodiValue(){ return $('prodi').value; }
function prodiText(){ const o=$('prodi').selectedOptions[0]; return (o && o.value) ? o.textContent.trim() : ''; }
function deptValue(){ return $('dept').value.trim(); }
/* Departemen diisi otomatis dari program studi yang dipilih */
function syncDept(){ const o=$('prodi').selectedOptions[0]; $('dept').value = (o && o.dataset.dept) ? o.dataset.dept : ''; }

/* ================= DROPDOWN KUSTOM ================= */
const CS_ICON='<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';
let csOpen=null;

function csReveal(c,el){
  const lr=c.list.getBoundingClientRect(), er=el.getBoundingClientRect();
  if(er.top<lr.top) c.list.scrollTop-=(lr.top-er.top);
  else if(er.bottom>lr.bottom) c.list.scrollTop+=(er.bottom-lr.bottom);
}

function csVisible(c){ return c.items.filter(x=>!x.opts && x.el.style.display!=='none'); }

function csFilter(c){
  const q=c.search.value.trim().toLowerCase();
  let any=false;
  c.items.forEach(x=>{
    if(x.opts){ const hit=x.opts.some(o=>!q||o.text.includes(q)); x.el.style.display=hit?'':'none'; }
  });
  c.items.forEach(x=>{
    if(!x.opts){ const show=!q||x.text.includes(q); x.el.style.display=show?'':'none'; if(show) any=true; }
  });
  c.empty.style.display=any?'none':'block';
  c.active=-1;
  csVisible(c).forEach(x=>x.el.classList.remove('act'));
}

function csRefresh(sel){
  const c=sel._cs; if(!c) return;
  c.box.innerHTML=''; c.items=[];
  const addOpt=(o,grp)=>{
    const d=document.createElement('div');
    d.className='cs-opt'+(o.value===''?' ph':'')+(o.value==='__lain'?' lain':'');
    d.textContent=o.textContent; d.dataset.i=o.index; d.setAttribute('role','option');
    c.box.appendChild(d);
    const it={el:d,i:o.index,text:o.textContent.toLowerCase(),grp};
    c.items.push(it); if(grp) grp.opts.push(it);
  };
  for(const ch of sel.children){
    if(ch.tagName==='OPTGROUP'){
      const h=document.createElement('div'); h.className='cs-grp'; h.textContent=ch.label;
      c.box.appendChild(h);
      const grp={el:h,opts:[]}; c.items.push(grp);
      for(const o of ch.children) addOpt(o,grp);
    } else if(ch.tagName==='OPTION') addOpt(ch,null);
  }
  c.box.appendChild(c.empty);
  const cur=sel.selectedIndex, o=sel.options[cur];
  c.items.forEach(x=>{ if(!x.opts && x.i===cur) x.el.classList.add('sel'); });
  c.val.textContent=o?o.textContent:'';
  c.val.classList.toggle('ph', !sel.value);
  c.btn.disabled=sel.disabled;
  c.wrap.classList.toggle('dis', sel.disabled);
  c.search.parentNode.style.display = sel.options.length>8 ? '' : 'none';
  csFilter(c);
}

function csChoose(sel,i){
  const c=sel._cs;
  sel.selectedIndex=i;
  sel.dispatchEvent(new Event('change',{bubbles:true}));
  csClose(sel); c.btn.focus({preventScroll:true});
}

function csPlace(sel){
  const c=sel._cs, r=c.btn.getBoundingClientRect(), L=c.list;
  const below=window.innerHeight-r.bottom-16, above=r.top-84;
  const want=Math.min(300, L.scrollHeight+14);
  const up = below<want && above>below;
  L.style.left=r.left+'px'; L.style.width=r.width+'px';
  if(up){ L.style.top='auto'; L.style.bottom=(window.innerHeight-r.top+4)+'px'; L.style.maxHeight=Math.max(140,Math.min(300,above))+'px'; }
  else { L.style.bottom='auto'; L.style.top=(r.bottom+4)+'px'; L.style.maxHeight=Math.max(140,Math.min(300,below))+'px'; }
  c.wrap.classList.toggle('up', up);
}

function csClose(sel){
  const c=sel._cs; if(!c) return;
  c.wrap.classList.remove('open'); c.btn.setAttribute('aria-expanded','false');
  c.list.classList.remove('on');
  c.wrap.appendChild(c.list); c.list.removeAttribute('style');
  c.search.value=''; csFilter(c);
  if(csOpen===sel) csOpen=null;
}

function csOpenList(sel){
  if(sel.disabled) return;
  if(csOpen && csOpen!==sel) csClose(csOpen);
  const c=sel._cs;
  // Daftar dipindah ke <body> dan diposisikan tetap di bawah/atas tombol,
  // sehingga tidak tertutup oleh bagian form di sekitarnya
  document.body.appendChild(c.list);
  c.list.classList.add('on');
  c.list.style.position='fixed'; c.list.style.zIndex='1000';
  c.wrap.classList.add('open'); c.btn.setAttribute('aria-expanded','true'); csOpen=sel;
  c.list.scrollTop=0;
  csPlace(sel);
  const vis=csVisible(c);
  const idx=vis.findIndex(x=>x.i===sel.selectedIndex);
  csSetActive(c, idx);
  if(c.search.parentNode.style.display!=='none') c.search.focus({preventScroll:true});
  const selEl=c.items.find(x=>!x.opts && x.i===sel.selectedIndex);
  if(selEl) csReveal(c, selEl.el);
}

window.addEventListener('resize', ()=>{ if(csOpen) csPlace(csOpen); });
window.addEventListener('scroll', e=>{
  if(csOpen && !csOpen._cs.list.contains(e.target)) csPlace(csOpen);
}, true);

function csSetActive(c,n){
  const vis=csVisible(c);
  vis.forEach(x=>x.el.classList.remove('act'));
  if(!vis.length){ c.active=-1; return; }
  c.active=Math.max(0,Math.min(vis.length-1,n));
  vis[c.active].el.classList.add('act');
  csReveal(c, vis[c.active].el);
}

function csKey(sel,e){
  const c=sel._cs;
  const isOpen=c.wrap.classList.contains('open');
  if(e.key==='ArrowDown'||e.key==='ArrowUp'){
    e.preventDefault();
    if(!isOpen){ csOpenList(sel); return; }
    csSetActive(c, c.active + (e.key==='ArrowDown'?1:-1));
  } else if(e.key==='Enter'){
    if(isOpen){
      e.preventDefault();
      const vis=csVisible(c);
      if(c.active>=0 && vis[c.active]) csChoose(sel, vis[c.active].i);
      else csClose(sel);
    }
  } else if(e.key==='Escape'){
    if(isOpen){ e.preventDefault(); csClose(sel); c.btn.focus({preventScroll:true}); }
  } else if(e.key==='Home'||e.key==='End'){
    if(isOpen && e.target===c.btn){ e.preventDefault(); csSetActive(c, e.key==='Home'?0:csVisible(c).length-1); }
  }
}

function csInit(sel){
  if(sel._cs) return;
  const wrap=document.createElement('div'); wrap.className='cs';
  sel.parentNode.insertBefore(wrap, sel); wrap.appendChild(sel);
  sel.classList.add('cs-native'); sel.tabIndex=-1; sel.setAttribute('aria-hidden','true');

  const btn=document.createElement('button');
  btn.type='button'; btn.className='cs-btn'; btn.id=sel.id+'-cs';
  btn.setAttribute('aria-haspopup','listbox'); btn.setAttribute('aria-expanded','false');
  const val=document.createElement('span'); val.className='cs-val';
  btn.append(val); btn.insertAdjacentHTML('beforeend', CS_ICON);

  const list=document.createElement('div'); list.className='cs-list'; list.setAttribute('role','listbox');
  const sbox=document.createElement('div'); sbox.className='cs-sbox';
  const search=document.createElement('input'); search.type='search'; search.placeholder='Cari pilihan…'; search.autocomplete='off';
  sbox.appendChild(search);
  const box=document.createElement('div');
  const empty=document.createElement('div'); empty.className='cs-empty'; empty.textContent='Tidak ada pilihan yang cocok';
  list.append(sbox, box);
  wrap.append(btn, list);

  const lbl=document.querySelector('label[for="'+sel.id+'"]'); if(lbl) lbl.htmlFor=btn.id;

  sel._cs={wrap,btn,val,list,search,box,empty,items:[],active:-1};
  const c=sel._cs;
  wrap._close=()=>csClose(sel);

  // Sinkronkan tampilan setiap kali nilai/opsi berubah (termasuk perubahan lewat script)
  const vDesc=Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype,'value');
  const iDesc=Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype,'selectedIndex');
  Object.defineProperty(sel,'value',{configurable:true,get(){return vDesc.get.call(this)},set(v){vDesc.set.call(this,v);csRefresh(this)}});
  Object.defineProperty(sel,'selectedIndex',{configurable:true,get(){return iDesc.get.call(this)},set(v){iDesc.set.call(this,v);csRefresh(this)}});
  new MutationObserver(()=>csRefresh(sel)).observe(sel,{childList:true,subtree:true,characterData:true,attributes:true,attributeFilter:['disabled']});

  btn.addEventListener('click',()=>{ c.wrap.classList.contains('open') ? csClose(sel) : csOpenList(sel); });
  btn.addEventListener('keydown',e=>csKey(sel,e));
  search.addEventListener('input',()=>csFilter(c));
  search.addEventListener('keydown',e=>csKey(sel,e));
  box.addEventListener('click',e=>{
    const d=e.target.closest('.cs-opt'); if(d) csChoose(sel, +d.dataset.i);
  });
  csRefresh(sel);
}

document.querySelectorAll('select').forEach(csInit);
document.addEventListener('mousedown',e=>{
  if(csOpen && !csOpen._cs.wrap.contains(e.target) && !csOpen._cs.list.contains(e.target)) csClose(csOpen);
});

/* ================= RESTORE FORM ================= */
try{
  const s = JSON.parse(localStorage.getItem('skemAjuanForm')||'{}');
  FIDS.forEach(i=>{ if(s[i]!==undefined && !(i==='prodi' && s[i]==='')) $(i).value=s[i]; });
  syncDept();
  if(s.komponen){
    setKomponen(+s.komponen);
    if(s.jenis){ $('jenis').value=s.jenis; fillPeran(s.jenis, s.peran); }
  }
}catch(e){}

function saveForm(){
  try{
    const o={};
    FIDS.forEach(i=>o[i]=$(i).value);
    o.komponen=komponen;
    o.jenis=$('jenis').value;
    o.peran=$('peran').value;
    localStorage.setItem('skemAjuanForm', JSON.stringify(o));
  }catch(e){}
}
FIDS.forEach(i => $(i).addEventListener('input', saveForm));

/* ===== FORM 1 IDENTITAS: banner data tersimpan & penghitung NRP ===== */
function updNrp(){ const n=$('nrp').value.length; $('nrpCount').textContent=n+'/10'; $('nrpCount').style.color=n===10?'var(--ok)':''; }
$('nrp').addEventListener('input', updNrp);
if(($('nama').value||$('nrp').value)) $('idBanner').hidden=false;
$('idClear').addEventListener('click', () => {
  $('nama').value=''; $('nrp').value='';
  $('prodi').value=''; syncDept();
  updNrp(); saveForm(); $('idBanner').hidden=true; $('nama').focus();
});
updNrp();

/* ================= STEPPER ================= */
let cur = 1;
function go(n){
  if(n > cur && !validate(cur)) return;
  const back = n < cur;
  cur = n;
  document.querySelectorAll('.pane').forEach(p => p.classList.remove('on','back'));
  $('pane'+n).classList.add('on');
  $('pane'+n).classList.toggle('back', back);
  document.querySelectorAll('#steps li').forEach(li => {
    const s = +li.dataset.s;
    li.classList.toggle('act', s === n);
    li.classList.toggle('done', s < n);
  });
  if(n === 4) renderRingkas();
  window.scrollTo({ top: document.querySelector('.card').offsetTop - 80, behavior:'smooth' });
}
document.querySelectorAll('[data-go]').forEach(b => b.addEventListener('click', () => go(+b.dataset.go)));

function markBad(id, bad){ $(id).closest('.fld')?.classList.toggle('bad', bad); if(!$(id).closest('.fld')) $(id).classList.toggle('bad', bad); return bad; }
function validate(n){
  let ok = true;
  if(n === 1){
    ok = !markBad('nama', !$('nama').value.trim()) && ok;
    ok = !markBad('nrp', !/^\d{10}$/.test($('nrp').value.trim())) && ok;
    ok = !markBad('prodi', !prodiValue()) && ok;
    if(!ok) toast('Lengkapi dulu data identitas dengan benar.');
  }
  if(n === 2){
    ok = !markBad('jenis', !komponen || !$('jenis').value) && ok;
    ok = !markBad('peran', !$('peran').value) && ok;
    if(!ok) toast('Pilih jenis kegiatan dan peran terlebih dahulu.');
  }
  if(n === 3){
    const eF = $('errFormulir'), eB = $('errBukti');
    eF.style.display = filesFormulir.length ? 'none' : 'block';
    eB.style.display = filesBukti.length ? 'none' : 'block';
    ok = filesFormulir.length > 0 && filesBukti.length > 0;
    if(!ok) toast('Lampiran wajib: formulir PDF + minimal 1 bukti kegiatan.');
  }
  return ok;
}
['nama','nrp'].forEach(i => $(i).addEventListener('input', () => { const f = $(i).closest('.fld'); if(f) f.classList.remove('bad'); }));
$('prodi').addEventListener('change', () => { syncDept(); saveForm(); $('prodi').closest('.fld')?.classList.remove('bad'); });

/* ================= KOMPONEN & POIN ================= */
function setKomponen(k){
  komponen = k;
  document.querySelectorAll('.kopt').forEach(b => b.classList.toggle('sel', +b.dataset.k === k));
  const sel = $('jenis'); sel.innerHTML = '';
  const items = POIN[k] ? POIN[k].items : {};
  const keys = Object.keys(items);
  if(!keys.length){ sel.innerHTML = '<option value="">Pilih komponen terlebih dahulu</option>'; sel.disabled = true; }
  else{
    sel.disabled = false;
    sel.innerHTML = '<option value="">— Pilih jenis kegiatan —</option>' + keys.map(j => `<option>${esc(j)}</option>`).join('');
  }
  $('peran').innerHTML = '<option value="">Pilih jenis kegiatan terlebih dahulu</option>'; $('peran').disabled = true;
  $('poin').value = '—';
  const kh=document.getElementById('kompHint'); if(kh) kh.classList.toggle('on', !k);
}
function fillPeran(jenis, keep){
  const items = POIN[komponen]?.items || {};
  const sel = $('peran'); sel.innerHTML = '';
  const arr = items[jenis] || [];
  if(!arr.length){ sel.disabled = true; sel.innerHTML = '<option value="">Pilih jenis kegiatan terlebih dahulu</option>'; $('poin').value='—'; return; }
  sel.disabled = false;
  sel.innerHTML = '<option value="">— Pilih peran / perolehan —</option>' + arr.map((p,i)=>`<option value="${i}">${esc(p[0])}</option>`).join('');
  if(keep !== undefined){ sel.value = keep; updPoin(); }
}
function updPoin(){
  const items = POIN[komponen]?.items || {};
  const arr = items[$('jenis').value] || [];
  const p = arr[+ $('peran').value];
  $('poin').value = p ? p[1].toFixed(2).replace('.', ',') : '—';
}
document.querySelectorAll('.kopt').forEach(b => b.addEventListener('click', () => { setKomponen(+b.dataset.k); saveForm(); }));
$('jenis').addEventListener('change', () => { fillPeran($('jenis').value); saveForm(); });
$('peran').addEventListener('change', () => { updPoin(); saveForm(); });

/* ================= UPLOADS ================= */
const MAXB = 5 * 1024 * 1024;
function updLampiran(){
  const f=filesFormulir.length, b=filesBukti.length;
  $('cntForm').textContent=f+'/1 file';
  $('cntBukti').textContent=b+'/6 file';
  $('cntBukti').classList.toggle('full', b>=6);
  $('reqForm').textContent=f?'Terlampir':'Wajib'; $('reqForm').classList.toggle('ok', !!f);
  $('reqBukti').textContent=b?'Terlampir':'Wajib'; $('reqBukti').classList.toggle('ok', !!b);
  $('fFormulir').closest('.upl-box').classList.toggle('full', f>=1);
  $('fBukti').closest('.upl-box').classList.toggle('full', b>=6);
}
function renderList(input, arr, listEl){
  listEl.innerHTML = '';
  updLampiran();
  arr.forEach((f, i) => {
    const li = document.createElement('li');
    const isImg = f.type.startsWith('image/');
    li.innerHTML = (isImg ? `<img src="${f.data}" alt="">` : '<span class="pdfi">PDF</span>')
      + `<span class="n">${esc(f.name)}</span><span class="s">${(f.size/1024).toFixed(0)} KB</span><button type="button" aria-label="Hapus ${esc(f.name)}">×</button>`;
    li.querySelector('button').onclick = () => { arr.splice(i,1); renderList(input, arr, listEl); };
    listEl.appendChild(li);
  });
}
function pickFiles(input, arr, listEl, maxFiles, onlyPdf){
  input.addEventListener('change', () => {
    const fs = [...input.files]; input.value = '';
    let added = 0;
    for(const f of fs){
      if(onlyPdf && !(f.type === 'application/pdf' || f.name.toLowerCase().endsWith('.pdf'))){ toast('"'+f.name+'" bukan PDF. Formulir wajib PDF.'); continue; }
      if(!onlyPdf && !(/image\//.test(f.type) || f.type === 'application/pdf' || /\.(jpe?g|png|webp|pdf)$/i.test(f.name))){ toast('"'+f.name+'" tidak didukung.'); continue; }
      if(f.size > MAXB){ toast('"'+f.name+'" melebihi 5 MB.'); continue; }
      if(arr.length >= maxFiles){ toast('Maksimal '+maxFiles+' file.'); break; }
      const r = new FileReader();
      r.onload = () => { arr.push({ name:f.name, type:f.type, size:f.size, data:r.result, file:f }); renderList(input, arr, listEl); };
      r.readAsDataURL(f); added++;
    }
    if(added) toast(added + ' file ditambahkan.');
  });
}
updLampiran();
pickFiles($('fFormulir'), filesFormulir, $('listFormulir'), 1, true);
pickFiles($('fBukti'), filesBukti, $('listBukti'), 6, false);

/* Drag & Drop Effect */
document.querySelectorAll('.upl-box').forEach(box => {
  ['dragenter','dragover'].forEach(e => box.addEventListener(e, ev => { ev.preventDefault(); box.classList.add('dragover'); }));
  ['dragleave','drop'].forEach(e => box.addEventListener(e, ev => { ev.preventDefault(); box.classList.remove('dragover'); }));
});

/* ================= RINGKASAN ================= */
function renderRingkas(){
  const j = $('jenis').value, per = $('peran');
  const peranTxt = per.selectedOptions[0]?.textContent || '—';
  const poin = $('poin').value || '0';
  const formulir = filesFormulir.length ? esc(filesFormulir[0].name) : 'Belum diunggah';

  $('ringkas').innerHTML = `
    <div class="summary-grid">
      <div class="summary-card">
        <div class="rk-head">
          <div class="sc-title"><svg class="ico"><use href="#i-doc"/></svg> Identitas Mahasiswa</div>
        </div>
        <div class="rk-main">${esc($('nama').value)}</div>
        <div class="rk-grid">
          <div class="rk-item"><b>NRP</b><span>${esc($('nrp').value)}</span></div>
          <div class="rk-item"><b>Program studi</b><span>${esc(prodiText())}</span></div>
          <div class="rk-item"><b>Departemen</b><span>${esc(deptValue())}</span></div>
        </div>
      </div>

      <div class="summary-card">
        <div class="rk-head">
          <div class="sc-title"><svg class="ico"><use href="#i-akt"/></svg> Kegiatan SKEM</div>
          <span class="rk-badge">+${esc(poin)} Poin</span>
        </div>
        <div class="rk-main">${esc(j)}</div>
        <div class="rk-grid rk-grid2">
          <div class="rk-item"><b>Komponen</b><span>Komponen ${komponen}</span></div>
          <div class="rk-item"><b>Peran / Perolehan</b><span>${esc(peranTxt)}</span></div>
        </div>
      </div>

      <div class="summary-card">
        <div class="rk-head">
          <div class="sc-title"><svg class="ico"><use href="#i-up"/></svg> Berkas Lampiran</div>
        </div>
        <div class="rk-grid rk-grid2">
          <div class="rk-item"><b>Formulir Kegiatan</b><span>${formulir}</span></div>
          <div class="rk-item"><b>Bukti Pendukung</b><span>${filesBukti.length} file terlampir</span></div>
        </div>
      </div>
    </div>
  `;
  const labels=['Ubah identitas','Ubah kegiatan','Ubah lampiran'];
  $('ringkas').querySelectorAll('.summary-card').forEach((card,i)=>{
    if(i>2) return;
    const b=document.createElement('button'); b.type='button'; b.className='sc-edit'; b.dataset.go=i+1;
    b.innerHTML='<svg class="ico" viewBox="0 0 24 24"><use href="#i-back"/></svg>'+labels[i];
    b.querySelector('svg').style.transform='rotate(180deg)';
    card.appendChild(b);
  });
}

/* Tombol "Ubah data" di setiap kartu ringkasan */
$('ringkas').addEventListener('click', e => {
  const b = e.target.closest('[data-go]'); if(b) go(+b.dataset.go);
});

/* ================= RESET & KIRIM ================= */
function resetForm(){
  /* Data identitas (nama, NRP, prodi, departemen) sengaja TIDAK dihapus
     agar pengajuan berikutnya tidak perlu diisi ulang. */
  $('setuju').checked = false;
  setKomponen(0); filesFormulir = []; filesBukti = [];
  renderList($('fFormulir'), filesFormulir, $('listFormulir')); renderList($('fBukti'), filesBukti, $('listBukti'));
  saveForm(); /* simpan ulang: identitas tetap, data kegiatan ikut direset */
  go(1);
}

/* ===== Susun data sesuai field yang diterima controller ===== */
function selectedPeran(){
  const arr = (POIN[komponen] && POIN[komponen].items[$('jenis').value]) || [];
  return arr[+$('peran').value] || null;
}
function buildFormData(){
  const p = selectedPeran();
  const fd = new FormData();
  fd.append('name', $('nama').value.trim());
  fd.append('nrp', $('nrp').value.trim());
  fd.append('study_program_id', $('prodi').value);
  fd.append('component', komponen);
  fd.append('activity_name', $('jenis').value);
  fd.append('role', p ? p[0] : '');
  fd.append('points', p ? p[1].toFixed(2) : '');
  fd.append('formulir', filesFormulir[0].file);
  filesBukti.forEach(f => fd.append('bukti[]', f.file));
  return fd;
}
function firstError(res){
  if(res && res.errors){ const k = Object.keys(res.errors)[0]; if(k) return res.errors[k][0]; }
  return (res && res.message) || 'Periksa kembali data Anda.';
}

let lastNrp = '';
$('kirim').addEventListener('click', async () => {
  if(!validate(1)) { go(1); return; }
  if(!validate(2)) { go(2); return; }
  if(!validate(3)) { go(3); return; }
  if(!$('setuju').checked){ $('errSetuju').style.display = 'block'; $('chkStmt').scrollIntoView({behavior:'smooth', block:'center'}); return; }
  $('errSetuju').style.display = 'none';

  const btn = $('kirim');
  btn.disabled = true;
  btn.classList.add('loading');
  btn.querySelector('.btn-txt').textContent = 'Mengirim Pengajuan…';
  try{
    const resp = await fetch(CFG.storeUrl, {
      method: 'POST',
      body: buildFormData(),
      headers: { 'X-CSRF-TOKEN': CFG.csrf, 'Accept': 'application/json' }
    });
    let res = null;
    try{ res = await resp.json(); }catch(e){}
    if(resp.ok && res && res.success){
      lastNrp = $('nrp').value.trim();
      const reg = res.data && res.data.registration_number;
      $('regNo').textContent = reg ? 'Nomor registrasi: ' + reg : '';
      $('regNo').hidden = !reg;
      $('ovOk').classList.add('on');
      resetForm();
    } else {
      toast('Gagal: ' + firstError(res));
    }
  }catch(err){
    toast('Koneksi terputus atau berkas gagal diunggah. Coba lagi.');
  }finally{
    btn.disabled = false;
    btn.classList.remove('loading');
    btn.querySelector('.btn-txt').textContent = 'Kirim Pengajuan SKEM';
  }
});

$('ovClose').onclick = () => { window.location.href = CFG.trackUrl + '?nrp=' + encodeURIComponent(lastNrp); };
$('ovLagi').onclick = () => { $('ovOk').classList.remove('on'); window.scrollTo({top:0, behavior:'smooth'}); };
$('setuju').addEventListener('change', () => { $('errSetuju').style.display = 'none'; });

/* ================= REVEAL ANIMATION ================= */
if('IntersectionObserver' in window){
  const io = new IntersectionObserver(es => es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); } }), {threshold:.06});
  document.querySelectorAll('.rv').forEach(el => io.observe(el));
} else document.querySelectorAll('.rv').forEach(el => el.classList.add('in'));

setKomponen(komponen);
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
@endverbatim
</script>
</body>
</html>