<?php

namespace App\Traits;

use App\Models\ActivityLog;

/**
 * Tempel trait ini ke model manapun yang mau otomatis kecatet ke riwayat aktivitas.
 * Contoh: class Invoice extends Model { use LogsActivity; ... }
 *
 * Begitu model itu di-create/update/delete lewat cara APAPUN (controller, job,
 * tinker, seeder, dll), otomatis kebentuk entry ActivityLog — nggak perlu manual
 * panggil ActivityLog::record() lagi di tiap controller.
 */
trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->writeActivityLog('created');
        });

        static::updated(function ($model) {
            // Skip kalau cuma timestamp yang berubah (nggak ada perubahan berarti)
            $changed = array_diff_key(
                $model->getChanges(),
                array_flip(['updated_at'])
            );
            if (empty($changed)) {
                return;
            }
            $model->writeActivityLog('updated');
        });

        static::deleted(function ($model) {
            $model->writeActivityLog('deleted');
        });
    }

    /**
     * Tulis entry ke ActivityLog. Kalau model punya method activityDescription(),
     * dipakai buat bikin teks yang lebih manusiawi. Kalau nggak ada, fallback ke
     * teks generik pakai nama class model.
     */
    protected function writeActivityLog(string $event): void
    {
        // Jangan catat kalau nggak ada user yang login (misal dari seeder/job background)
        if (!auth()->check()) {
            return;
        }

        $modelName = class_basename($this);
        $action = strtolower($modelName) . '_' . $event; // contoh: invoice_created, expense_updated

        if (method_exists($this, 'activityDescription')) {
            $description = $this->activityDescription($event);
        } else {
            $label = match ($event) {
                'created' => 'Membuat',
                'updated' => 'Memperbarui',
                'deleted' => 'Menghapus',
                default   => ucfirst($event),
            };
            $description = "{$label} {$modelName} #{$this->getKey()}";
        }

        ActivityLog::record($action, $description, $this);
    }
}