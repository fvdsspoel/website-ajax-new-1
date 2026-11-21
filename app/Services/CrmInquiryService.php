<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Every lead of the website goes into the CRM as a new Inquiry, through the
 * CRM's public endpoint POST /api/inquiry (SalesToolController::storeInquiry):
 * the design selector and the contact form, with the visitor's plan and
 * photos (up to 5 files, JPG/PNG/WEBP/PDF, 8 MB each — the CRM's own limits).
 *
 * It lands on the CRM's 'web' channel, in the same Inquiries inbox as
 * Facebook and WhatsApp, and is assigned and followed up there as usual.
 * If the CRM cannot be reached, the lead and its files are kept on this
 * server (storage/app/failed-leads) and logged — nothing is lost.
 */
class CrmInquiryService
{
    /** @param UploadedFile[] $files */
    public function submit(array $payload, array $files = []): bool
    {
        $url = config('services.crm.inquiry_api_url');
        if (! $url) {
            $this->keep($payload, $files, 'CRM_INQUIRY_API_URL not set');
            return false;
        }

        try {
            $request = Http::acceptJson()->timeout(25);

            $response = $files
                ? $request->asMultipart()->post($url, $this->parts($payload, $files))
                : $request->post($url, $payload);

            if (! $response->successful()) {
                $this->keep($payload, $files, 'CRM answered '.$response->status().': '.mb_substr($response->body(), 0, 300));
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            $this->keep($payload, $files, $e->getMessage());
            return false;
        }
    }

    /** Multipart parts: nested arrays as design_config[key][…], files as files[]. */
    private function parts(array $payload, array $files): array
    {
        $parts = [];
        $flatten = function ($value, string $name) use (&$flatten, &$parts) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $flatten($v, $name.'['.$k.']');
                }
                return;
            }
            if ($value === null) {
                return;
            }
            $parts[] = ['name' => $name, 'contents' => is_bool($value) ? ($value ? '1' : '0') : (string) $value];
        };
        foreach ($payload as $key => $value) {
            $flatten($value, $key);
        }
        foreach ($files as $file) {
            $parts[] = [
                'name' => 'files[]',
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        return $parts;
    }

    /** A lead the CRM did not take is kept here, with its files, for staff to enter by hand. */
    private function keep(array $payload, array $files, string $reason): void
    {
        $dir = 'failed-leads/'.now()->format('Y-m-d_His').'_'.Str::random(6);
        try {
            Storage::disk('local')->put($dir.'/lead.json', json_encode(['reason' => $reason, 'payload' => $payload], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            foreach ($files as $i => $file) {
                Storage::disk('local')->putFileAs($dir, $file, ($i + 1).'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension());
            }
        } catch (\Throwable $e) {
            report($e);
        }
        Log::error('Website lead NOT sent to the CRM — kept in storage/app/'.$dir, ['reason' => $reason, 'name' => $payload['name'] ?? null, 'contact' => $payload['contact'] ?? null]);
    }
}
