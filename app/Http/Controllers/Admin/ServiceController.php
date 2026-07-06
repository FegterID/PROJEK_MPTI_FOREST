<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Port dari pages/admin/services.php. CSRF, validasi, dan redirect
 * flash message di sini ditangani otomatis oleh Laravel (VerifyCsrfToken
 * middleware + session flash), jadi tidak perlu csrf_token manual lagi.
 */
class ServiceController extends Controller
{
    public function index(): View
    {
        $editingService = null;

        if (request()->filled('edit')) {
            $editingService = Service::find((int) request('edit'));
        }

        return view('admin.services.index', [
            'services' => Service::orderBy('id')->get(),
            'editingService' => $editingService,
            'validCategories' => Service::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['image'] = $this->storeImage($request);

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $this->storeImage($request);
        }

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Validasi + normalisasi price/price_range, setara logic
     * price_type ('fixed' vs 'range') pada pages/admin/services.php.
     *
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'in:'.implode(',', Service::CATEGORIES)],
            'duration' => ['required', 'integer', 'min:1'],
            'price_type' => ['required', 'in:fixed,range'],
            'price' => ['nullable', 'integer', 'min:0'],
            'price_range' => ['nullable', 'string', 'max:60'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'category.in' => 'Data layanan tidak valid. Mohon cek kembali input Anda.',
            'image.image' => 'File harus berupa gambar (jpg, png, webp, dst).',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($data['price_type'] === 'fixed' && (int) ($data['price'] ?? 0) <= 0) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'price' => 'Harga tetap harus lebih dari 0.',
            ]);
        }

        if ($data['price_type'] === 'range' && trim((string) ($data['price_range'] ?? '')) === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'price_range' => 'Rentang harga tidak boleh kosong.',
            ]);
        }

        return [
            'category' => $data['category'],
            'category_name' => Service::CATEGORY_LABELS[$data['category']],
            'name' => $data['name'],
            'description' => $data['description'],
            'duration' => $data['duration'],
            'price' => $data['price_type'] === 'fixed' ? $data['price'] : null,
            'price_range' => $data['price_type'] === 'range' ? $data['price_range'] : null,
        ];
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return $request->file('image')->store('services', 'public');
    }
}
