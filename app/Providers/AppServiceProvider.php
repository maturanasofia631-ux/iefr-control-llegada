<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Student;
use App\Models\LateArrival;
use App\Models\Teacher;
use App\Models\Excuse;
use App\Models\Sanction;
use App\Models\Acudiente;

use App\Policies\StudentPolicy;
use App\Policies\LateArrivalPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\ExcusePolicy;
use App\Policies\SanctionPolicy;
use App\Policies\AcudientePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Student::class,     StudentPolicy::class);
        Gate::policy(LateArrival::class, LateArrivalPolicy::class);
        Gate::policy(Teacher::class,     TeacherPolicy::class);
        Gate::policy(Excuse::class,      ExcusePolicy::class);
        Gate::policy(Sanction::class,    SanctionPolicy::class);
        Gate::policy(Acudiente::class,   AcudientePolicy::class);
    }
}
