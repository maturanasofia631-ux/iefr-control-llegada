<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\LateArrival;
use App\Models\Teacher;
use App\Models\Excuse;
use App\Models\Sanction;
use App\Models\Acudiente;

class LandingController extends Controller
{
    public function index()
    {
        $stats = [
            'total_estudiantes' => Student::count(),
            'tardanzas_hoy'     => LateArrival::whereDate('fecha', today())->count(),
            'tardanzas_mes'     => LateArrival::whereMonth('fecha', now()->month)->count(),
            'tardanzas_anio'    => LateArrival::whereYear('fecha', now()->year)->count(),
            'con_excusa'        => LateArrival::where('tiene_excusa', true)->count(),
            'sin_excusa'        => LateArrival::where('tiene_excusa', false)->count(),
        ];

        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labelsGrafica = [];
        $datosGrafica  = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha           = now()->subMonths($i);
            $labelsGrafica[] = $meses[$fecha->month - 1];
            $datosGrafica[]  = LateArrival::whereMonth('fecha', $fecha->month)->whereYear('fecha', $fecha->year)->count();
        }

        $porGrado = LateArrival::join('students', 'late_arrivals.student_id', '=', 'students.id')
            ->selectRaw('students.grado, COUNT(*) as total')
            ->groupBy('students.grado')
            ->orderByDesc('total')
            ->limit(6)->get();

        $excusasAprobadas  = Excuse::where('aprobada', true)->count();
        $excusasPendientes = Excuse::where('aprobada', false)->count();
        $teachers   = Teacher::latest()->get();
        $sanctions  = Sanction::with('student')->latest()->limit(5)->get();
        $acudientes = Acudiente::with('student')->latest()->limit(5)->get();

        return view('welcome', compact('stats', 'labelsGrafica', 'datosGrafica', 'porGrado', 'excusasAprobadas', 'excusasPendientes', 'teachers', 'sanctions', 'acudientes'));
    }
}