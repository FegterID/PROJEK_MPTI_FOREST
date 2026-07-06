<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $editingProduct = null;

        if (request()->filled('edit')) {
            $editingProduct = Product::find((int) request('edit'));
        }

        return view('admin.products.index', [
            'products' => Product::orderBy('category')->orderBy('id')->get(),
            'editingProduct' => $editingProduct,
            'validCategories' => Product::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['image'] = $this->storeImage($request);

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum simpan yang baru, biar disk gak numpuk file.
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $this->storeImage($request);
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Setara action 'toggle' pada pages/admin/products.php.
     */
    public function toggle(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Status produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'in:'.implode(',', Product::CATEGORIES)],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:1'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'category.in' => 'Data produk tidak valid. Mohon cek kembali input Anda.',
            'image.image' => 'File harus berupa gambar (jpg, png, webp, dst).',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
    }

    /**
     * Simpan file upload ke disk 'public', folder products/. Return null
     * kalau tidak ada file yang diupload (biar kolom image tetap null).
     */
    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        return $request->file('image')->store('products', 'public');
    }
}
