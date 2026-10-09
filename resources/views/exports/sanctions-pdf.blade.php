<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Sanciones</title>
    <style>
        @page { margin: 30px 30px 40px 30px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; }
        .header { text-align: center; margin-bottom: 14px; border-bottom: 2px solid #c0392b; padding-bottom: 8px; }
        .header img { width: 50px; height: 50px; }
        .header h1 { font-size: 15px; margin: 4px 0 0 0; color: #0f0f0f; }
        .header h2 { font-size: 12px; margin: 2px 0 0 0; color: #c0392b; }
        .header p { margin: 2px 0 0 0; color: #777; font-size: 9px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #c0392b; color: #fff; padding: 6px 4px; text-align: left; font-size: 9px; }
        td { padding: 5px 4px; border-bottom: 1px solid #e3e3e3; vertical-align: top; }
        tr:nth-child(even) td { background: #fbf6f5; }
        .activa { color: #c0392b; font-weight: bold; }
        .resuelta { color: #1a8a3a; font-weight: bold; }
        .cancelada { color: #888; font-weight: bold; }
        .total { margin-top: 10px; font-size: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo-institucion.png') }}" alt="Logo">
        <h1>I.E. Felipe de Restrepo</h1>
        <h2>Reporte de Sanciones</h2>
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
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sanctions as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->student->codigo ?? '—' }}</td>
                    <td>{{ $s->student->nombre ?? '—' }}</td>
                    <td>{{ $s->student->grado ?? '—' }}</td>
                    <td>{{ $s->student->grupo ?? '—' }}</td>
                    <td>{{ $s->tipo }}</td>
                    <td>{{ $s->descripcion ?? '—' }}</td>
                    <td>{{ $s->fecha?->format('d/m/Y') }}</td>
                    <td class="{{ $s->estado }}">{{ ucfirst($s->estado) }}</td>
                </tr>
            @empty
                <tr><td colspan="9" style="text-align:center;padding:14px;">No hay sanciones registradas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="total">Total de sanciones: {{ $sanctions->count() }}</p>
</body>
</html>