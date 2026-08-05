<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::withCount('companies')
            ->orderBy('price')
            ->get();

        return view('admin.subscriptions.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscriptions.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $plan = SubscriptionPlan::create($data);

        ActivityLog::record(
            'create_subscription_plan',
            "Membuat paket langganan baru: {$plan->name}.",
            $plan
        );

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', "Paket {$plan->name} berhasil dibuat.");
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscriptions.edit', ['plan' => $subscriptionPlan]);
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $subscriptionPlan->update($data);

        ActivityLog::record(
            'update_subscription_plan',
            "Memperbarui paket langganan: {$subscriptionPlan->name}.",
            $subscriptionPlan
        );

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', "Paket {$subscriptionPlan->name} berhasil diperbarui.");
    }

    /**
     * Toggle aktif/nonaktif paket.
     * Nama method "toggle" - HARUS SAMA dengan yang dipanggil di routes/web.php.
     */
    public function toggle(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->update(['is_active' => !$subscriptionPlan->is_active]);

        ActivityLog::record(
            'toggle_subscription_plan',
            ($subscriptionPlan->is_active ? 'Mengaktifkan' : 'Menonaktifkan') . " paket langganan: {$subscriptionPlan->name}.",
            $subscriptionPlan
        );

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', "Status paket {$subscriptionPlan->name} berhasil diubah.");
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $count = $subscriptionPlan->companies()->count();

        if ($count > 0) {
            return back()->withErrors([
                'delete' => "Tidak bisa menghapus paket {$subscriptionPlan->name} karena masih dipakai oleh {$count} perusahaan.",
            ]);
        }

        $name = $subscriptionPlan->name;
        $subscriptionPlan->delete();

        ActivityLog::record('delete_subscription_plan', "Menghapus paket langganan: {$name}.");

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', "Paket {$name} berhasil dihapus.");
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|integer|min:0',
            'billing_period' => 'required|in:monthly,yearly',
            'max_users'      => 'nullable|integer|min:1',
            'is_active'      => 'sometimes|boolean',
            'color'          => 'nullable|string|max:20',
            'icon'           => 'nullable|string|max:30',
        ]);
    }
}