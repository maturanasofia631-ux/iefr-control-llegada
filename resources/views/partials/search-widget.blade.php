<div style="max-width:600px;margin:40px auto;padding:2rem;background:#ffffff;border-radius:12px;border:1px solid #d4d4d4;box-shadow:0 2px 12px rgba(0,0,0,0.06);">
    <div style="text-align:center;margin-bottom:1.5rem;">
        <img src="/images/logo-institucion.png.webp"
             alt="Logo I.E. Felipe de Restrepo"
             style="display:block;margin:0 auto 12px auto;width:auto;height:90px;object-fit:contain;">
        <h2 style="font-size:1.3rem;font-weight:700;color:#0f0f0f;margin-bottom:4px;">Buscar Estudiante</h2>
        <p style="font-size:0.85rem;color:#8a8a8a;">Ingresa el número de documento o nombre del estudiante</p>
    </div>

    <form action="{{ route('student.search') }}" method="GET">
        <div style="display:flex;gap:10px;">
            <input type="text" name="q" placeholder="Documento, nombre o grupo..."
                value="{{ request('q') }}"
                style="flex:1;padding:0.75rem 1rem;border:1px solid #d4d4d4;border-radius:6px;font-size:0.95rem;outline:none;"
                autofocus>
            <button type="submit" style="background:#2e7fcf;color:#fff;border:none;padding:0.75rem 1.5rem;border-radius:6px;font-size:0.95rem;font-weight:500;cursor:pointer;">Buscar</button>
        </div>
    </form>

    @if(request('q'))
        @php
            $query    = strtoupper(request('q'));
            $students = \App\Models\Student::where('nombre', 'like', '%' . $query . '%')
                ->orWhere('codigo', 'like', '%' . $query . '%')
                ->orWhere('grupo',  'like', '%' . $query . '%')
                ->limit(10)->get();
        @endphp
        <div style="margin-top:1.5rem;">
            @if($students->isEmpty())
                <p style="text-align:center;color:#8a8a8a;font-size:0.9rem;">No se encontraron estudiantes.</p>
            @else
                <p style="font-size:0.78rem;color:#8a8a8a;margin-bottom:0.8rem;text-transform:uppercase;letter-spacing:0.08em;">{{ $students->count() }} resultado(s)</p>
                @foreach($students as $student)
                    <a href="/admin/resource/student-resource/detail-page/{{ $student->id }}"
                       style="display:flex;align-items:center;justify-content:space-between;padding:0.85rem 1rem;border-bottom:1px solid #f0f0f0;text-decoration:none;color:inherit;border-radius:6px;"
                       onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                        <div>
                            <div style="font-weight:600;color:#0f0f0f;font-size:0.95rem;">{{ $student->nombre }}</div>
                            <div style="font-size:0.8rem;color:#8a8a8a;margin-top:2px;">Código: {{ $student->codigo ?? '—' }} &nbsp;·&nbsp; Grupo: {{ $student->grupo ?? '—' }}</div>
                        </div>
                        <div style="background:#e8f2fb;color:#2e7fcf;padding:0.25rem 0.7rem;border-radius:4px;font-size:0.8rem;font-weight:600;">Grado {{ $student->grado }}</div>
                    </a>
                @endforeach
            @endif
        </div>
    @endif
</div>