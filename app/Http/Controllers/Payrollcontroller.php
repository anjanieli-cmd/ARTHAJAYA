<?php

namespace App\Http\Controllers;

use App\Enums\AccessLevel;
use App\Models\Payroll;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = Payroll::with('employee')->where('company_id', $company->id)->latest();

        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('position', 'like', "%{$q}%")
                    ->orWhere('period', 'like', "%{$q}%")
                    ->orWhereHas('employee', function ($e) use ($q) {
                        $e->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"]);
                    });
            });
        }

        $payrolls = $query->get();

        if ($request->ajax()) {
            return view('payroll.index', compact('user', 'company', 'payrolls'))->render();
        }

        return view('payroll.index', compact('user', 'company', 'payrolls'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;

        $employees = User::where('company_id', $company->id)
            ->where('access_level', AccessLevel::User)
            ->with('employeeProfile')
            ->orderBy('name')
            ->get();

        return view('payroll.create', compact('user', 'company', 'employees'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        $data = $request->validate([
            'employee_id'   => 'required|exists:users,id',
            'position'      => 'nullable|string',
            'period'        => 'required|string',
            'basic_salary'  => 'required|numeric',
            'allowance'     => 'nullable|numeric',
            'deduction'     => 'nullable|numeric',
            'status'        => 'nullable|string',
            'notes'         => 'nullable|string',
        ]);

        $basic = (int) $data['basic_salary'];
        $allowance = (int) ($data['allowance'] ?? 0);
        $deduction = (int) ($data['deduction'] ?? 0);

        $payroll = Payroll::create([
            'company_id'   => $company->id,
            'employee_id'  => $data['employee_id'],
            'position'     => $data['position'] ?: '-',
            'period'       => $data['period'],
            'basic_salary' => $basic,
            'allowance'    => $allowance,
            'deduction'    => $deduction,
            'total'        => $basic + $allowance - $deduction,
            'status'       => $data['status'] ?? 'pending',
            'notes'        => $data['notes'] ?? null,
        ]);

        $this->logActivity('created', "Membuat payroll untuk {$payroll->employee->name} periode {$payroll->period}", $payroll);

        return redirect()->route('payroll.index')->with('success', 'Payroll berhasil dibuat!');
    }

    public function show(Payroll $payroll)
    {
        $this->authorizeCompany($payroll);
        $user = Auth::user();
        $company = $user->company;
        return view('payroll.show', compact('user', 'company', 'payroll'));
    }

    public function edit(Payroll $payroll)
    {
        $this->authorizeCompany($payroll);
        $user = Auth::user();
        $company = $user->company;
        return view('payroll.edit', compact('user', 'company', 'payroll'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $this->authorizeCompany($payroll);

        $basic = (int) $request->input('basic_salary', $payroll->basic_salary);
        $allowance = (int) $request->input('allowance', $payroll->allowance);
        $deduction = (int) $request->input('deduction', $payroll->deduction);

        $payroll->update([
            'position'     => $request->input('position', $payroll->position),
            'period'       => $request->input('period', $payroll->period),
            'basic_salary' => $basic,
            'allowance'    => $allowance,
            'deduction'    => $deduction,
            'total'        => $basic + $allowance - $deduction,
            'status'       => $request->input('status', $payroll->status),
            'notes'        => $request->input('notes', $payroll->notes),
        ]);

        $this->logActivity('updated', "Mengupdate payroll periode {$payroll->period}", $payroll);

        return redirect()->route('payroll.index')->with('success', 'Payroll berhasil diupdate!');
    }

    public function destroy(Payroll $payroll)
    {
        $this->authorizeCompany($payroll);

        $period = $payroll->period;
        $payroll->delete();

        $this->logActivity('deleted', "Menghapus payroll periode {$period}");

        return redirect()->route('payroll.index')->with('success', 'Payroll berhasil dihapus!');
    }

    private function authorizeCompany(Payroll $payroll): void
    {
        abort_unless($payroll->company_id === Auth::user()->company->id, 404);
    }
}