<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected function logActivity(string $action, string $description, $model = null, array $oldValues = null, array $newValues = null)
    {
        $logData = [
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($model) {
            $logData['model_type'] = get_class($model);
            $logData['model_id'] = $model->id;
        }

        if ($oldValues !== null) {
            $logData['old_values'] = $oldValues;
        }

        if ($newValues !== null) {
            $logData['new_values'] = $newValues;
        }

        ActivityLog::create($logData);
    }

    protected function logCreate($model, string $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?? "Membuat {$modelName} baru";
        $this->logActivity('create', $desc, $model, null, $model->toArray());
    }

    protected function logUpdate($model, array $oldValues, string $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?? "Memperbarui {$modelName}";
        $this->logActivity('update', $desc, $model, $oldValues, $model->toArray());
    }

    protected function logDelete($model, string $description = null)
    {
        $modelName = class_basename($model);
        $desc = $description ?? "Menghapus {$modelName}";
        $this->logActivity('delete', $desc, $model, $model->toArray(), null);
    }

    protected function logLogin()
    {
        $user = Auth::user();
        $desc = "User {$user->name} ({$user->email}) login ke sistem";
        $this->logActivity('login', $desc, $user);
    }

    protected function logLogout()
    {
        $user = Auth::user();
        $desc = "User {$user->name} ({$user->email}) logout dari sistem";
        $this->logActivity('logout', $desc, $user);
    }
}