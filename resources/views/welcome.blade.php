<!DOCTYPE html>
<html lang="es">
{{-- FAVICONS INSTITUCIONALES --}}
<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#8B1A1A">
<meta name="msapplication-TileColor" content="#8B1A1A">
<meta name="theme-color" content="#8B1A1A">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Llegadas Tarde — I.E. Felipe de Restrepo</title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* stylelint-disable */
        :root {
            --negro: #0f0f0f;
            --gris-oscuro: #1e1e1e;
            --gris-medio: #3a3a3a;
            --gris-claro: #8a8a8a;
            --gris-linea: #d4d4d4;
            --blanco: #f9f9f9;
            --azul: #2e7fcf;
            --azul-claro: #4fa0e8;
            --azul-suave: #e8f2fb;
            --rojo: #e03a3a;
            --rojo-suave: #fceaea;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Barlow', sans-serif; background-color: var(--blanco); color: var(--negro); min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: var(--negro); border-bottom: 3px solid var(--azul); }
        .header-inner { max-width: 1100px; margin: 0 auto; padding: 1.4rem 2rem; display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; }
        .header-brand { display: flex; align-items: center; gap: 1rem; }
        .brand-icon { width: 48px; height: 48px; background: var(--azul); border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .brand-text h1 { font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; font-weight: 700; color: #fff; letter-spacing: 0.03em; line-height: 1.1; }
        .brand-text p { font-size: 0.78rem; color: var(--gris-claro); font-weight: 300; letter-spacing: 0.06em; text-transform: uppercase; margin-top: 2px; }
        .btn-admin { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--azul); color: #fff; font-size: 0.85rem; font-weight: 500; padding: 0.6rem 1.3rem; border-radius: 4px; text-decoration: none; transition: background 0.2s; white-space: nowrap; }
        .btn-admin:hover { background: var(--azul-claro); }
        .breadcrumb { background: #f0f0f0; border-bottom: 1px solid var(--gris-linea); padding: 0.55rem 2rem; }
        .breadcrumb-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: var(--gris-claro); text-transform: uppercase; letter-spacing: 0.05em; }
        .breadcrumb-inner span { color: var(--azul); }
        .hero { background: var(--gris-oscuro); padding: 2.5rem 2rem; }
        .hero-inner { max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; }
        .hero h2 { font-family: 'Barlow Condensed', sans-serif; font-size: 2.2rem; font-weight: 700; color: #fff; letter-spacing: 0.02em; line-height: 1.1; }
        .hero h2 span { color: var(--azul-claro); }
        .hero-date { font-size: 0.8rem; color: var(--gris-claro); text-transform: uppercase; letter-spacing: 0.08em; text-align: right; flex-shrink: 0; }
        main { flex-grow: 1; max-width: 1100px; width: 100%; margin: 0 auto; padding: 2.5rem 2rem 3rem; }
        .section-label { display: flex; align-items: center; gap: 0.6rem; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.12em; color: var(--gris-claro); margin-bottom: 1.5rem; }
        .section-label::after { content: none; }
        .section-label .line { flex: 1; height: 1px; background: var(--gris-linea); }
        .export-btns { display: flex; gap: 8px; flex-shrink: 0; }
        .btn-excel { background: #2e7fcf; color: #fff; padding: 4px 12px; border-radius: 4px; font-size: 0.72rem; text-decoration: none; font-weight: 600; white-space: nowrap; }
        .btn-pdf   { background: #e03a3a; color: #fff; padding: 4px 12px; border-radius: 4px; font-size: 0.72rem; text-decoration: none; font-weight: 600; white-space: nowrap; }
        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--gris-linea); border: 1px solid var(--gris-linea); border-radius: 8px; overflow: hidden; margin-bottom: 2.5rem; }
        .stat-card { background: #fff; padding: 1.8rem 1.5rem; display: flex; flex-direction: column; gap: 1rem; position: relative; transition: background 0.15s; }
        .stat-card:hover { background: #fafafa; }
        .stat-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .stat-icon { width: 36px; height: 36px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon.blue { background: var(--azul-suave); }
        .stat-icon.red  { background: var(--rojo-suave); }
        .stat-icon.gray { background: #f0f0f0; }
        .stat-accent { width: 3px; height: 100%; position: absolute; left: 0; top: 0; }
        .stat-accent.blue { background: var(--azul); }
        .stat-accent.red  { background: var(--rojo); }
        .stat-accent.gray { background: var(--gris-claro); }
        .stat-value { font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 700; line-height: 1; }
        .stat-value.blue { color: var(--azul); }
        .stat-value.red  { color: var(--rojo); }
        .stat-value.gray { color: var(--gris-medio); }
        .stat-label { font-size: 0.78rem; color: var(--gris-claro); line-height: 1.3; }
        .analytics-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2.5rem; }
        .analytics-grid-half { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2.5rem; }
        .analytics-card { background: #fff; border: 1px solid var(--gris-linea); border-radius: 8px; padding: 1.5rem; }
        .analytics-card h3 { font-family: 'Barlow Condensed', sans-serif; font-size: 0.85rem; font-weight: 600; color: var(--gris-claro); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1.2rem; padding-bottom: 0.8rem; border-bottom: 1px solid var(--gris-linea); }
        .chart-wrap { position: relative; height: 220px; }
        .grado-row { display: flex; align-items: center; gap: 0.8rem; padding: 0.65rem 0; border-bottom: 1px solid #f0f0f0; }
        .grado-row:last-child { border-bottom: none; }
        .grado-rank { font-size: 0.7rem; color: var(--gris-claro); min-width: 16px; text-align: center; }
        .grado-badge { font-family: 'Barlow Condensed', sans-serif; font-size: 0.85rem; font-weight: 700; background: var(--azul-suave); color: var(--azul); padding: 0.2rem 0.6rem; border-radius: 4px; min-width: 46px; text-align: center; }
        .grado-bar-wrap { flex: 1; background: #f0f0f0; border-radius: 2px; height: 5px; overflow: hidden; }
        .grado-bar { height: 5px; border-radius: 2px; background: var(--azul); }
        .grado-total { font-family: 'Barlow Condensed', sans-serif; font-size: 0.95rem; font-weight: 600; color: var(--gris-medio); min-width: 24px; text-align: right; }
        .tabla-wrap { background: #fff; border: 1px solid var(--gris-linea); border-radius: 8px; overflow: hidden; margin-bottom: 2.5rem; }
        .tabla-wrap table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        .tabla-wrap thead tr { background: #f9f9f9; border-bottom: 1px solid var(--gris-linea); }
        .tabla-wrap th { padding: 0.9rem 1.2rem; text-align: left; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gris-claro); font-weight: 600; }
        .tabla-wrap td { padding: 0.75rem 1.2rem; border-bottom: 1px solid #f0f0f0; color: var(--gris-medio); vertical-align: middle; }
        .tabla-wrap tr:last-child td { border-bottom: none; }
        .tabla-wrap .td-name { font-weight: 500; color: var(--negro); }
        .tabla-wrap .td-empty { text-align: center; color: var(--gris-claro); padding: 2rem; }
        .badge-activa   { background: var(--rojo-suave); color: var(--rojo); padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; }
        .badge-resuelta { background: var(--azul-suave); color: var(--azul); padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; }
        .badge-cancelada{ background: #f0f0f0; color: var(--gris-claro); padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; }
        .roles-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--gris-linea); border: 1px solid var(--gris-linea); border-radius: 6px; overflow: hidden; margin-bottom: 2.5rem; }
        .role-card { background: #fff; padding: 1.2rem 1.5rem; display: flex; align-items: center; gap: 0.9rem; }
        .role-icon { width: 36px; height: 36px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .role-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.07em; color: var(--gris-claro); }
        .role-name  { font-size: 0.9rem; font-weight: 500; color: var(--negro); }
        footer { background: var(--negro); border-top: 1px solid #2a2a2a; padding: 1.5rem 2rem; }
        .footer-inner { max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .footer-copy { font-size: 0.75rem; color: #555; }
        .footer-copy span { color: var(--azul); font-weight: 500; }
        @media (max-width: 768px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .analytics-grid { grid-template-columns: 1fr; }
            .analytics-grid-half { grid-template-columns: 1fr; }
            .roles-grid { grid-template-columns: 1fr; }
            .hero-inner { flex-direction: column; align-items: flex-start; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <header>
        <div class="header-inner">
            <div class="header-brand">
                <div class="brand-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>I.E. Felipe de Restrepo</h1>
                    <p>Control de Llegadas Tarde</p>
                </div>
            </div>
            <a href="{{ route('moonshine.login') }}" class="btn-admin">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Panel Administrativo
            </a>
        </div>
    </header>

    <div class="breadcrumb">
        <div class="breadcrumb-inner">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            </svg>
            Inicio &nbsp;/&nbsp; <span>Resumen General</span>
        </div>
    </div>

    <div class="hero">
        <div class="hero-inner">
            <h2>Resumen de <span>Llegadas</span><br>Escolares</h2>
            <div class="hero-date">
                <div>Año lectivo {{ date('Y') }}</div>
                <div style="margin-top:4px;color:#555;font-size:0.7rem;">Actualizado en tiempo real</div>
            </div>
        </div>
    </div>

    <main>

        <!-- INDICADORES -->
        <div class="section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            Indicadores Principales
            <span class="line"></span>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-accent blue"></div>
                <div class="stat-top">
                    <div><div class="stat-value blue">{{ $stats['total_estudiantes'] }}</div><div class="stat-label">Estudiantes<br>Registrados</div></div>
                    <div class="stat-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2e7fcf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-accent red"></div>
                <div class="stat-top">
                    <div><div class="stat-value red">{{ $stats['tardanzas_hoy'] }}</div><div class="stat-label">Tardanzas<br>Hoy</div></div>
                    <div class="stat-icon red"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e03a3a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-accent blue"></div>
                <div class="stat-top">
                    <div><div class="stat-value blue">{{ $stats['tardanzas_mes'] }}</div><div class="stat-label">Tardanzas<br>Este Mes</div></div>
                    <div class="stat-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2e7fcf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-accent gray"></div>
                <div class="stat-top">
                    <div><div class="stat-value gray">{{ $stats['tardanzas_anio'] }}</div><div class="stat-label">Tardanzas<br>Año {{ date('Y') }}</div></div>
                    <div class="stat-icon gray"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3a3a3a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-accent blue"></div>
                <div class="stat-top">
                    <div><div class="stat-value blue">{{ $stats['con_excusa'] }}</div><div class="stat-label">Tardanzas<br>Con Excusa</div></div>
                    <div class="stat-icon blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2e7fcf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-accent red"></div>
                <div class="stat-top">
                    <div><div class="stat-value red">{{ $stats['sin_excusa'] }}</div><div class="stat-label">Tardanzas<br>Sin Excusa</div></div>
                    <div class="stat-icon red"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#e03a3a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
                </div>
            </div>
        </div>

        <!-- ANÁLISIS -->
        <div class="section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Análisis de Tardanzas
            <span class="line"></span>
        </div>

        <div class="analytics-grid">
            <div class="analytics-card">
                <h3>Tardanzas por mes — {{ date('Y') }}</h3>
                <div class="chart-wrap"><canvas id="graficaMeses"></canvas></div>
            </div>
            <div class="analytics-card">
                <h3>Grados con más tardanzas</h3>
                @if($porGrado->isEmpty())
                    <p style="font-size:0.8rem;color:var(--gris-claro);text-align:center;padding:2rem 0">Sin datos registrados aún</p>
                @else
                    @php $maxGrado = $porGrado->max('total') ?: 1; @endphp
                    @foreach($porGrado as $index => $item)
                        <div class="grado-row">
                            <span class="grado-rank">{{ $index + 1 }}</span>
                            <span class="grado-badge">{{ $item->grado }}</span>
                            <div class="grado-bar-wrap">
                                <div class="grado-bar" style="width:{{ round(($item->total / $maxGrado) * 100) }}%"></div>
                            </div>
                            <span class="grado-total">{{ $item->total }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- EXCUSAS -->
        <div class="section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Estado de Excusas
            <span class="line"></span>
        </div>

        <div class="analytics-grid-half">
            <div class="analytics-card">
                <h3>Excusas aprobadas vs pendientes</h3>
                <div class="chart-wrap"><canvas id="graficaExcusas"></canvas></div>
            </div>
            <div class="analytics-card" style="display:flex;flex-direction:column;justify-content:center;gap:2rem;">
                <div style="display:flex;align-items:center;gap:1.2rem;">
                    <div style="width:16px;height:16px;border-radius:50%;background:var(--azul);flex-shrink:0"></div>
                    <div>
                        <div style="font-family:'Barlow Condensed',sans-serif;font-size:2.5rem;font-weight:700;color:var(--azul);line-height:1">{{ $excusasAprobadas }}</div>
                        <div style="font-size:0.78rem;color:var(--gris-claro);margin-top:2px">Excusas aprobadas</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:1.2rem;">
                    <div style="width:16px;height:16px;border-radius:50%;background:var(--rojo);flex-shrink:0"></div>
                    <div>
                        <div style="font-family:'Barlow Condensed',sans-serif;font-size:2.5rem;font-weight:700;color:var(--rojo);line-height:1">{{ $excusasPendientes }}</div>
                        <div style="font-size:0.78rem;color:var(--gris-claro);margin-top:2px">Excusas pendientes</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DOCENTES -->
        <div class="section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Docentes Registrados
            <span class="line"></span>
        </div>

        <div class="tabla-wrap">
            <table>
                <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Materia</th><th>Teléfono</th></tr></thead>
                <tbody>
                    @forelse($teachers as $index => $teacher)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="td-name">{{ $teacher->nombre }} {{ $teacher->apellido }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->materia ?? '—' }}</td>
                            <td>{{ $teacher->telefono ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="td-empty">Sin docentes registrados aún</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- SANCIONES -->
        <div class="section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/></svg>
            Últimas Sanciones
            <span class="line"></span>
        </div>

        <div class="tabla-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sanctions as $sanction)
                        <tr>
                            <td class="td-name">{{ $sanction->student->nombre ?? '—' }}</td>
                            <td>{{ $sanction->tipo }}</td>
                            <td>{{ \Carbon\Carbon::parse($sanction->fecha)->format('d/m/Y') }}</td>
                            <td>
                                @if($sanction->estado === 'activa')
                                    <span class="badge-activa">Activa</span>
                                @elseif($sanction->estado === 'resuelta')
                                    <span class="badge-resuelta">Resuelta</span>
                                @else
                                    <span class="badge-cancelada">Cancelada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="td-empty">Sin sanciones registradas aún</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ACUDIENTES -->
        <div class="section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Acudientes Registrados
            <span class="line"></span>
        </div>

        <div class="tabla-wrap">
            <table>
                <thead><tr><th>Estudiante</th><th>Acudiente</th><th>Parentesco</th><th>Teléfono</th><th>Email</th></tr></thead>
                <tbody>
                    @forelse($acudientes as $acudiente)
                        <tr>
                            <td class="td-name">{{ $acudiente->student->nombre ?? '—' }}</td>
                            <td>{{ $acudiente->nombre }} {{ $acudiente->apellido }}</td>
                            <td>{{ $acudiente->parentesco }}</td>
                            <td>{{ $acudiente->telefono }}</td>
                            <td>{{ $acudiente->email ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="td-empty">Sin acudientes registrados aún</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ROLES -->
        <div class="section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Acceso por Rol
            <span class="line"></span>
        </div>

        <div class="roles-grid">
            <div class="role-card">
                <div class="role-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e1e1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <div><div class="role-label">Rol</div><div class="role-name">Coordinador</div></div>
            </div>
            <div class="role-card">
                <div class="role-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e1e1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div><div class="role-label">Rol</div><div class="role-name">Docente</div></div>
            </div>
            <div class="role-card">
                <div class="role-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1e1e1e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                <div><div class="role-label">Rol</div><div class="role-name">Acudiente</div></div>
            </div>
        </div>

    </main>

    <footer>
        <div class="footer-inner">
            <div class="footer-copy">&copy; {{ date('Y') }} &nbsp;<span>I.E. Felipe de Restrepo</span> &nbsp;&mdash;&nbsp; Sistema de Control Escolar</div>
            <div style="font-size:0.7rem;color:#444;letter-spacing:0.05em;">Desarrollado con Laravel + MoonShine</div>
        </div>
    </footer>

    <script>
        var labelsGrafica     = <?php echo json_encode($labelsGrafica ?? []); ?>;
        var datosGrafica      = <?php echo json_encode($datosGrafica ?? []); ?>;
        var excusasAprobadas  = <?php echo (int) ($excusasAprobadas ?? 0); ?>;
        var excusasPendientes = <?php echo (int) ($excusasPendientes ?? 0); ?>;
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var canvas = document.getElementById('graficaMeses');
            if (canvas) {
                new Chart(canvas.getContext('2d'), {
                    type: 'bar',
                    data: { labels: labelsGrafica, datasets: [{ label: 'Tardanzas', data: datosGrafica, backgroundColor: 'rgba(46,127,207,0.12)', borderColor: '#2e7fcf', borderWidth: 2, borderRadius: 4, borderSkipped: false }] },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e1e1e', titleColor: '#fff', bodyColor: '#8a8a8a', padding: 10, callbacks: { label: function(c) { return ' ' + c.parsed.y + ' tardanzas'; } } } },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: '#8a8a8a', font: { family: 'Barlow', size: 12 } } },
                            y: { beginAtZero: true, grid: { color: '#f0f0f0' }, ticks: { color: '#8a8a8a', font: { family: 'Barlow', size: 12 }, stepSize: 1, precision: 0 } }
                        }
                    }
                });
            }
            var canvasExcusas = document.getElementById('graficaExcusas');
            if (canvasExcusas) {
                new Chart(canvasExcusas.getContext('2d'), {
                    type: 'doughnut',
                    data: { labels: ['Aprobadas', 'Pendientes'], datasets: [{ data: [excusasAprobadas, excusasPendientes], backgroundColor: ['#2e7fcf', '#e03a3a'], borderWidth: 0 }] },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e1e1e', titleColor: '#fff', bodyColor: '#8a8a8a', padding: 10 } } }
                });
            }
        });
    </script>

</body>
</html>