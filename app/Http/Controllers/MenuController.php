<?php

namespace App\Http\Controllers;

use App\Models\MenuItem; // Pastikan ini mengarah ke model MenuItem kamu
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the menu items for the user.
     */
    public function index()
    {
        // Mengambil hanya menu item yang 'available' (tersedia)
        $menuItems = MenuItem::where('available', true)->get();

        // Mengirim data menu item ke view
        return view('user.menu.index', compact('menuItems'));
    }

    // Metode lain untuk keranjang, checkout, dll., akan ditambahkan di sini nanti
}