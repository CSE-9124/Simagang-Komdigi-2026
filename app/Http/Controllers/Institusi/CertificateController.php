<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    private function getInstitusiInternIds(): \Illuminate\Support\Collection
    {
        $institusi = Auth::user()->institusi;

        if (! $institusi) {
            return collect();
        }

        return DB::table('interns')
            ->join('users', 'users.id', '=', 'interns.user_id')
            ->join('pengajuan_details', 'pengajuan_details.email', '=', 'users.email')
            ->join('pengajuans', 'pengajuans.id', '=', 'pengajuan_details.pengajuan_id')
            ->where('pengajuans.institusi_id', $institusi->id)
            ->where('interns.is_active', true)
            ->pluck('interns.id');
    }

    public function index(Request $request)
    {
        $internIds = $this->getInstitusiInternIds();

        $query = Certificate::with(['intern.finalReport', 'score']);

        if ($internIds->isNotEmpty()) {
            $query->whereHas('intern', function ($builder) use ($internIds) {
                $builder->whereIn('id', $internIds);
            });
        } else {
            $query->whereRaw('1 = 0');
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('intern', function ($inner) use ($search) {
                    $inner->where('name', 'like', $search);
                })
                ->orWhere('certificate_number', 'like', $search);
            });
        }

        $certificates = $query->orderByDesc('issue_date')->paginate(15)->withQueryString();

        return view('institusi.certificate.index', compact('certificates'));
    }

    public function show(Certificate $certificate)
    {
        $internIds = $this->getInstitusiInternIds();

        if (! $internIds->contains($certificate->intern_id)) {
            abort(403);
        }

        $certificate->load(['intern.finalReport', 'score']);

        return view('institusi.certificate.show', compact('certificate'));
    }
}
