<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Llegadas Tarde</title>
    <style>
        @page { margin: 30px 30px 40px 30px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; }
        .header { text-align: center; margin-bottom: 14px; border-bottom: 2px solid #2e7fcf; padding-bottom: 8px; }
        .header img { width: 50px; height: 50px; }
        .header h1 { font-size: 15px; margin: 4px 0 0 0; color: #0f0f0f; }
        .header h2 { font-size: 12px; margin: 2px 0 0 0; color: #2e7fcf; }
        .header p { margin: 2px 0 0 0; color: #777; font-size: 9px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2e7fcf; color: #fff; padding: 6px 4px; text-align: left; font-size: 9px; }
        td { padding: 5px 4px; border-bottom: 1px solid #e3e3e3; vertical-align: top; }
        tr:nth-child(even) td { background: #f7f9fc; }
        .si { color: #1a8a3a; font-weight: bold; }
        .no { color: #c0392b; font-weight: bold; }
        .total { margin-top: 10px; font-size: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo-institucion.png') }}" alt="Logo">
        <h1>I.E. Felipe de Restrepo</h1>
        <h2>Reporte de Llegadas Tarde</h2>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Estudiante</th>
                <th>Grado</th>
                <th>Grupo</th>
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
                    <td>{{ $a->student->codigo ?? '—' }}</td>
                    <td>{{ $a->student->nombre ?? '—' }}</td>
                    <td>{{ $a->student->grado ?? '—' }}</td>
                    <td>{{ $a->student->grupo ?? '—' }}</td>
                    <td>{{ $a->fecha?->format('d/m/Y') }}</td>
                    <td>{{ $a->hora }}</td>
                    <td>{{ $a->motivo }}</td>
                    <td class="{{ $a->tiene_excusa ? 'si' : 'no' }}">{{ $a->tiene_excusa ? 'Sí' : 'No' }}</td>
                    <td>{{ $a->observacion ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="10" style="text-align:center;padding:14px;">No hay llegadas tarde registradas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="total">Total de registros: {{ $arrivals->count() }}</p>
</body>
</html>