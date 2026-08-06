<?php

namespace App\Http\Controllers;

use App\Enums\AccessLevel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Data Karyawan - semua user dengan access_level "user" di company yang sama.
     * Otomatis muncul begitu karyawan register pakai kode undangan.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        $query = User::query()
            ->where('company_id', $company->id)
            ->where('access_level', AccessLevel::User)
            ->with('employeeProfile');

        if ($request->filled('q')) {
            $q = strtolower($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$q}%"]);
            });
        }

        $employees = $query->orderBy('name')->get();

        if ($request->ajax()) {
            return view('employees.index', compact('user', 'company', 'employees'))->render();
        }

        return view('employees.index', compact('user', 'company', 'employees'));
    }

    /**
     * Detail satu karyawan.
     */
    public function show($index)
    {
        $user = Auth::user();
        $company = $user->company;

        $employee = User::where('company_id', $company->id)
            ->where('access_level', AccessLevel::User)
            ->with('employeeProfile')
            ->findOrFail($index);

        return view('employees.show', compact('user', 'company', 'employee'));
    }

    /**
     * Form Staff melengkapi/mengedit data kerja karyawan
     * (posisi, departemen, gaji pokok - bukan data akun karyawan).
     */
    public function edit($index)
    {
        $user = Auth::user();
        $company = $user->company;

        $employee = User::where('company_id', $company->id)
            ->where('access_level', AccessLevel::User)
            ->with('employeeProfile')
            ->findOrFail($index);

        return view('employees.edit', compact('user', 'company', 'employee'));
    }

    /**
     * Simpan data kerja karyawan. Pakai updateOrCreate karena
     * pas karyawan baru register, employee_profile-nya belum ada sama sekali.
     */
    public function update(Request $request, $index)
    {
        $user = Auth::user();
        $company = $user->company;

        $employee = User::where('company_id', $company->id)
            ->where('access_level', AccessLevel::User)
            ->findOrFail($index);

        $data = $request->validate([
            'position'     => 'nullable|string|max:255',
            'department'   => 'nullable|string|max:255',
            'basic_salary' => 'nullable|numeric|min:0',
            'phone'        => 'nullable|string|max:30',
            'address'      => 'nullable|string',
            'joined_date'  => 'nullable|date',
            'status'       => 'nullable|in:active,inactive',
        ]);

        $data['status'] = $data['status'] ?? 'active';

        $employee->employeeProfile()->updateOrCreate(
            ['user_id' => $employee->id],
            array_merge($data, ['company_id' => $company->id])
        );

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diupdate!');
    }

    /**
     * "Hapus" karyawan = nonaktifkan, BUKAN hapus akun.
     * Akunnya tetap ada (biar histori data lain milik dia gak ikut hilang),
     * cuma statusnya diubah ke inactive.
     */
    public function destroy($index)
    {
        $user = Auth::user();
        $company = $user->company;

        $employee = User::where('company_id', $company->id)
            ->where('access_level', AccessLevel::User)
            ->findOrFail($index);

        $employee->employeeProfile()->updateOrCreate(
            ['user_id' => $employee->id],
            ['company_id' => $company->id, 'status' => 'inactive']
        );

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dinonaktifkan!');
    }
}