<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Mail\ProductsExportReady;
use App\Services\MailService;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductsExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userEmail;

    public function __construct(string $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function handle()
    {
        $products = Product::with('category')->orderBy('id')->get();

        // Ensure directory
        Storage::disk('public')->put('exports/.keep', '');

        $timestamp = now()->format('Ymd_His');
        $filename = 'exports/products_export_'.$timestamp.'.pdf';

        // Generar PDF
        $pdf = Pdf::loadView('pdf.products_export', compact('products'));
        $pdf->setPaper('a4', 'landscape');
        
        // Guardar PDF temporalmente
        $tmpPath = sys_get_temp_dir().'/'.basename($filename);
        $pdf->save($tmpPath);

        // Store file to public disk
        try {
            Storage::disk('public')->putFileAs('exports', new \Illuminate\Http\UploadedFile($tmpPath, basename($filename)), basename($filename));
        } catch (\Exception $e) {
            // Fallback: copy
            copy($tmpPath, storage_path('app/public/exports/'.basename($filename)));
        }

        // Build public url
        $url = Storage::disk('public')->url('exports/'.basename($filename));

        // Local path of stored file (in case we want to attach it)
        $localPath = storage_path('app/public/exports/'.basename($filename));

        // Send notification (attach file when available)
        try {
            $result = MailService::send(
                $this->userEmail,
                new ProductsExportReady($url, file_exists($localPath) ? $localPath : null),
                'products_export'
            );
            
            if ($result['success']) {
                Log::info('ProductsExportJob: export sent via Resend', [
                    'email' => $this->userEmail,
                    'file' => $url,
                    'local_path' => $localPath,
                    'provider' => $result['provider'] ?? 'unknown',
                ]);
            } else {
                Log::warning('ProductsExportJob: export mail failed', [
                    'email' => $this->userEmail,
                    'error' => $result['error'] ?? 'Unknown error',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send products export mail: '.$e->getMessage());
        }
    }
}
