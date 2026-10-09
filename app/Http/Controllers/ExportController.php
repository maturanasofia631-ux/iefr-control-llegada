<?php
namespace App\Http\Controllers;

use App\Models\LateArrival;
use App\Models\Sanction;
use App\Models\Student;
use Rap2hpoutre\FastExcel\FastExcel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function lateArrivalsExcel()
    {
        $data = LateArrival::with('student')->get()->map(fn($item) => [
            'Código'       => $item->student->codigo ?? '—',
            'Estudiante'   => $item->student->nombre ?? '—',
            'Grado'        => $item->student->grado  ?? '—',
            'Grupo'        => $item->student->grupo  ?? '—',
            'Fecha'        => $item->fecha?->format('d/m/Y'),
            'Hora'         => $item->hora,
            'Motivo'       => $item->motivo,
            'Tiene excusa' => $item->tiene_excusa ? 'Sí' : 'No',
            'Observación'  => $item->observacion ?? '—',
        ]);
        return (new FastExcel($data))->download('llegadas-tarde.xlsx');
    }

    public function lateArrivalsPdf()
    {
        $arrivals = LateArrival::with('student')->latest()->get();
        $pdf = Pdf::loadView('exports.late-arrivals-pdf', compact('arrivals'))->setPaper('a4', 'landscape');
        return $pdf->download('llegadas-tarde.pdf');
    }

    public function sanctionsExcel()
    {
        $data = Sanction::with('student')->get()->map(fn($item) => [
            'Código'      => $item->student->codigo ?? '—',
            'Estudiante'  => $item->student->nombre ?? '—',
            'Grado'       => $item->student->grado  ?? '—',
            'Grupo'       => $item->student->grupo  ?? '—',
            'Tipo'        => $item->tipo,
            'Descripción' => $item->descripcion ?? '—',
            'Fecha'       => $item->fecha?->format('d/m/Y'),
            'Estado'      => $item->estado,
        ]);
        return (new FastExcel($data))->download('sanciones.xlsx');
    }

    public function sanctionsPdf()
    {
        $sanctions = Sanction::with('student')->latest()->get();
        $pdf = Pdf::loadView('exports.sanctions-pdf', compact('sanctions'))->setPaper('a4', 'landscape');
        return $pdf->download('sanciones.pdf');
    }

    public function studentReportExcel($id)
    {
        $student  = Student::findOrFail($id);
        $arrivals = LateArrival::where('student_id', $id)->latest()->get();
        $data = $arrivals->map(fn($item) => [
            'Código'       => $student->codigo ?? '—',
            'Estudiante'   => $student->nombre,
            'Grado'        => $student->grado,
            'Grupo'        => $student->grupo,
            'Fecha'        => $item->fecha?->format('d/m/Y'),
            'Hora'         => $item->hora,
            'Motivo'       => $item->motivo,
            'Tiene excusa' => $item->tiene_excusa ? 'Sí' : 'No',
            'Observación'  => $item->observacion ?? '—',
        ]);
        return (new FastExcel($data))->download("reporte-{$student->codigo}.xlsx");
    }

    public function studentReportPdf($id)
    {
        $student  = Student::findOrFail($id);
        $arrivals = LateArrival::where('student_id', $id)->latest()->get();
        $pdf = Pdf::loadView('exports.student-report-pdf', compact('student', 'arrivals'))->setPaper('a4', 'portrait');
        return $pdf->download("reporte-{$student->codigo}.pdf");
    }
}