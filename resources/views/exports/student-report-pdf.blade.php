<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte del Estudiante</title>
    <style>
        @page { margin: 35px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 2px solid #2e7fcf; padding-bottom: 8px; }
        .header img { width: 55px; height: 55px; }
        .header h1 { font-size: 16px; margin: 4px 0 0 0; }
        .header h2 { font-size: 13px; margin: 2px 0 0 0; color: #2e7fcf; }
        .header p { margin: 2px 0 0 0; color: #777; font-size: 9px; }
        .info { width: 100%; margin-bottom: 14px; border: 1px solid #d4d4d4; border-collapse: collapse; }
        .info td { padding: 6px 10px; border-bottom: 1px solid #eee; }
        .info td.label { width: 28%; background: #f2f6fb; font-weight: bold; color: #2e7fcf; }
        .resumen { margin-bottom: 14px; }
        .resumen span { display: inline-block; background: #e8f2fb; color: #2e7fcf; padding: 5px 12px; border-radius: 4px; font-weight: bold; margin-right: 8px; }
        table.det { width: 100%; border-collapse: collapse; }
        table.det th { background: #2e7fcf; color: #fff; padding: 6px; text-align: left; font-size: 10px; }
        table.det td { padding: 6px; border-bottom: 1px solid #e3e3e3; vertical-align: top; }
        table.det tr:nth-child(even) td { background: #f7f9fc; }
        .si { color: #1a8a3a; font-weight: bold; }
        .no { color: #c0392b; font-weight: bold; }
        .firma { margin-top: 60px; text-align: center; }
        .firma div { display: inline-block; width: 200px; border-top: 1px solid #333; padding-top: 4px; margin: 0 25px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo-institucion.png') }}" alt="Logo">
        <h1>I.E. Felipe de Restrepo</h1>
        <h2>Reporte Individual de Llegadas Tarde</h2>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="info">
        <tr><td class="label">Estudiante</td><td>{{ $student->nombre }}</td></tr>
        <tr><td class="label">Código</td><td>{{ $student->codigo ?? '—' }}</td></tr>
        <tr><td class="label">Grado</td><td>{{ $student->grado }}</td></tr>
        <tr><td class="label">Grupo</td><td>{{ $student->grupo ?? '—' }}</td></tr>
        @if($student->observaciones)
            <tr><td class="label">Observaciones</td><td>{{ $student->observaciones }}</td></tr>
        @endif
    </table>

    <div class="resumen">
        <span>Total: {{ $arrivals->count() }}</span>
        <span>Con excusa: {{ $arrivals->where('tiene_excusa', true)->count() }}</span>
        <span>Sin excusa: {{ $arrivals->where('tiene_excusa', false)->count() }}</span>
    </div>

    <table class="det">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Motivo</th>
                <th>Excusa</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($arrivals as $i => $a)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $a->fecha?->format('d/m/Y') }}</td>
                    <td>{{ $a->hora }}</td>
                    <td>{{ $a->motivo }}</td>
                    <td class="{{ $a->tiene_excusa ? 'si' : 'no' }}">{{ $a->tiene_excusa ? 'Sí' : 'No' }}</td>
                    <td>{{ $a->observacion ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;padding:14px;">Este estudiante no tiene llegadas tarde registradas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="firma">
        <div>Coordinación</div>
        <div>Acudiente</div>
    </div>
</body>
</html>