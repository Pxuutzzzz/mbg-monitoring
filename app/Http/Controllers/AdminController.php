<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = \App\Models\User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,driver'
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:admin,driver'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }

    // ================= MENUS CRUD =================

    public function menus()
    {
        $menus = \App\Models\Menu::with('sppg')->orderBy('serve_date', 'desc')->get();
        $sppgs = \App\Models\Sppg::all();
        return view('admin.menus.index', compact('menus', 'sppgs'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'sppg_id' => 'required|exists:sppgs,id',
            'target_group' => 'required|string',
            'serve_date' => 'required|date',
            'food_name' => 'required|string|max:255',
            'calories' => 'required|integer',
            'protein_g' => 'required|numeric',
            'karbo_g' => 'required|numeric',
            'fat_g' => 'required|numeric',
        ]);

        \App\Models\Menu::create($request->all());

        return redirect()->route('admin.menus')->with('success', 'Menu gizi berhasil ditambahkan.');
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        
        $request->validate([
            'sppg_id' => 'required|exists:sppgs,id',
            'target_group' => 'required|string',
            'serve_date' => 'required|date',
            'food_name' => 'required|string|max:255',
            'calories' => 'required|integer',
            'protein_g' => 'required|numeric',
            'karbo_g' => 'required|numeric',
            'fat_g' => 'required|numeric',
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.menus')->with('success', 'Menu gizi berhasil diperbarui.');
    }

    public function destroyMenu($id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menus')->with('success', 'Menu berhasil dihapus.');
    }

    // ================= SPPG CRUD =================

    public function sppg()
    {
        $sppgs = \App\Models\Sppg::orderBy('name', 'asc')->get();
        return view('admin.sppg.index', compact('sppgs'));
    }

    public function storeSppg(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        \App\Models\Sppg::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.sppg')->with('success', 'SPPG berhasil ditambahkan.');
    }

    public function updateSppg(Request $request, $id)
    {
        $sppg = \App\Models\Sppg::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $sppg->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.sppg')->with('success', 'Data SPPG berhasil diperbarui.');
    }

    public function destroySppg($id)
    {
        $sppg = \App\Models\Sppg::findOrFail($id);
        $sppg->delete();
        return redirect()->route('admin.sppg')->with('success', 'SPPG berhasil dihapus.');
    }

    // ================= FINANCE MANAGEMENT =================

    public function finance()
    {
        $records = \App\Models\FinancialRecord::with('sppg')->orderBy('date', 'desc')->get();
        $sppgs   = \App\Models\Sppg::orderBy('name', 'asc')->get();
        return view('admin.finance.index', compact('records', 'sppgs'));
    }

    public function storeFinance(Request $request)
    {
        $request->validate([
            'sppg_id'        => 'required|exists:sppgs,id',
            'date'           => 'required|date',
            'bahan_cost'     => 'required|numeric|min:0',
            'transport_cost' => 'required|numeric|min:0',
        ]);

        $total = $request->bahan_cost + $request->transport_cost;

        \App\Models\FinancialRecord::create([
            'sppg_id'        => $request->sppg_id,
            'date'           => $request->date,
            'bahan_cost'     => $request->bahan_cost,
            'transport_cost' => $request->transport_cost,
            'total'          => $total,
        ]);

        return redirect()->route('admin.finance')->with('success', 'Catatan keuangan berhasil ditambahkan.');
    }

    public function destroyFinance($id)
    {
        $record = \App\Models\FinancialRecord::findOrFail($id);
        $record->delete();
        return redirect()->route('admin.finance')->with('success', 'Catatan keuangan berhasil dihapus.');
    }
}
