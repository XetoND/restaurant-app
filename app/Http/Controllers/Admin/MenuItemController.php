<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Validation\Rule; // Import Rule
use Illuminate\Support\Facades\Storage; // Import Storage

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuItems = MenuItem::all();
        return view('admin.menu-items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menu-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:menu_items',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:Makanan,Minuman',
            'image' => 'nullable|image|max:2048',
            'available' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_images', 'public');
            $validated['image'] = $path;
        } else {
            $validated['image'] = null; // Memastikan image di-set null jika tidak ada gambar
        }

        $validated['available'] = $request->has('available');

        MenuItem::create($validated);

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu berhasil di tambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menuItem)
    {
        // Biasanya tidak diperlukan halaman show terpisah untuk admin list.
        // Anda bisa membiarkannya kosong atau menambahkan view jika memang perlu detail khusus.
        // return view('admin.menu-items.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu-items.edit', compact('menuItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_items')->ignore($menuItem->id), // Unique dengan ignore
            ],
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|in:Makanan,Minuman',
            'image' => 'nullable|image|max:2048',
            'available' => 'nullable|boolean',
        ]);

        // Penanganan gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $path = $request->file('image')->store('menu_images', 'public'); // Gunakan 'menu_images'
            $validated['image'] = $path;
        } elseif ($request->input('remove_image')) { // Jika checkbox 'remove_image' dicentang
            // Hapus gambar lama
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $validated['image'] = null; // Set kolom image di DB menjadi null
        } else {
            // Jika tidak ada upload gambar baru dan tidak ada permintaan hapus, pertahankan gambar yang sudah ada
            $validated['image'] = $menuItem->image;
        }

        $validated['available'] = $request->has('available');

        $menuItem->update($validated);

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu berhasil di update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        // Hapus file gambar terkait sebelum menghapus record dari database
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();
        return redirect()->route('admin.menu-items.index')->with('success', 'Menu berhasil di hapus!');
    }
}