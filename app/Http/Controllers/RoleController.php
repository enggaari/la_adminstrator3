<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            // 'image'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'role'     => 'required|string|unique:roles,role',
            'info'   => 'required|string'
        ]);

        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/posts', $image->hashName());

        //create post
        Role::create([
            'role'     => $request->role,
            'info'   => $request->info
        ]);

        //redirect to index
        return redirect('/role')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            // Mencari role berdasarkan ID dan menghapusnya
            $role = Role::findOrFail($decryptedId);
            $role->delete();

            return redirect('/role')->with(['success' => 'Data Berhasil Dihapus!']);
        } catch (\Exception $e) {
            return redirect('/role')->with(['error' => 'Data Gagal Dihapus, Error: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $role = Role::find($decryptedId);
        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'roleEdit' => 'required|string',
            'infoEdit' => 'nullable|string|max:500',
        ]);

        // Cari role berdasarkan ID
        $role = Role::find($id);

        // Jika role tidak ditemukan
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.'
            ], 404);
            // return redirect('/role')->with(['error' => 'Periksa input']);
        }

        // Update data role
        $role->role = $request->roleEdit;
        $role->info = $request->infoEdit;
        $role->save();

        // Dapatkan nomor iterasi jika perlu
        $iteration = Role::where('id', '<=', $role->id)->count();

        // Bangun HTML baris table yang baru
        $updatedRow = '
                    <td class="align-middle product white-space-nowrap py-0">' . $iteration . '</td>
                    <td class="align-middle product white-space-nowrap" style="min-width:360px;">
                        <h6 class="fw-semi-bold mb-0">' . $request->roleEdit . '</h6>
                    </td>
                    <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 text-900">' . $request->infoEdit . '</h6>
                        </div>
                    </td>
                    <td class="align-middle white-space-nowrap text-end pe-0">
                        <a href="#" class="btn btn-sm btn-phoenix-warning me-1 fs--2">
                            <span class="fas fa-key"></span>
                        </a>
                        <button data-id="' . Crypt::encryptString($role->id)  . '" class="btn btn-sm btn-phoenix-primary me-1 fs--2 edit-role-btn">
                            <span class="fas fa-edit"></span>
                        </button>
                        <form id="delete-role-form-' . $role->id . '" action="/deleteRole/' . Crypt::encryptString($role->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-sm btn-phoenix-danger fs--2" onclick="confirmDelete(' . $role->id . ')">
                                <span class="fas fa-trash"></span>
                            </button>
                        </form>
                    </td>
                ';

        // Kembalikan data yang baru
        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully!',
            'updatedRow' => $updatedRow,
            'data' => [
                'id' => $role->id,
                'role' => $role->role,
                'info' => $role->info,
                'iteration' => $iteration // Urutan dalam table
            ],
            'roleId' => $role->id
        ]);
    }
}
