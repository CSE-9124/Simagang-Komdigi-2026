<?php

namespace App\Http\Controllers;

use App\Models\FinalReport;
use Illuminate\Support\Str;

class SecureDownloadController extends Controller
{
    public function __invoke(string $path)
    {
        $normalizedPath = $this->normalizePath($path);

        if (!$normalizedPath || !Str::startsWith($normalizedPath, ['final-reports/', 'projects/'])) {
            abort(404);
        }

        $report = $this->findReportByFilePath($normalizedPath);
        if (!$report) {
            abort(404);
        }

        $this->authorize('view', $report);

        $fullPath = $this->resolveStoragePath($normalizedPath);
        if (!$fullPath) {
            abort(404);
        }

        return response()->download($fullPath);
    }

    private function normalizePath(string $path): ?string
    {
        $normalized = str_replace('\\', '/', $path);
        $normalized = ltrim($normalized, '/');

        if ($normalized === '') {
            return null;
        }

        if (Str::contains($normalized, ['../', '..\\']) || Str::startsWith($normalized, '..')) {
            return null;
        }

        return $normalized;
    }

    private function findReportByFilePath(string $path): ?FinalReport
    {
        $report = FinalReport::query()
            ->where('file_path', $path)
            ->orWhere('project_file', $path)
            ->orWhereJsonContains('project_files', ['path' => $path])
            ->first();

        if ($report) {
            return $report;
        }

        return FinalReport::query()
            ->whereNotNull('project_files')
            ->get()
            ->first(function (FinalReport $item) use ($path) {
                $projectFiles = is_array($item->project_files) ? $item->project_files : [];

                return collect($projectFiles)->contains(function ($projectFile) use ($path) {
                    return data_get($projectFile, 'path') === $path;
                });
            });
    }

    private function resolveStoragePath(string $relativePath): ?string
    {
        $privatePath = storage_path('app/private/' . $relativePath);
        if (file_exists($privatePath)) {
            return $privatePath;
        }

        $legacyPublicPath = storage_path('app/public/' . $relativePath);
        if (file_exists($legacyPublicPath)) {
            $privateDir = dirname($privatePath);
            if (!file_exists($privateDir)) {
                mkdir($privateDir, 0755, true);
            }

            if (@rename($legacyPublicPath, $privatePath)) {
                return $privatePath;
            }

            return $legacyPublicPath;
        }

        return null;
    }
}