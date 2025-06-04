<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'user_id' => Auth::id()
        ]);

        return response()->json($category);
    }

    public function destroy($id)
{
    $category = Category::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // Hapus tanpa peduli apakah kategori sedang dipakai atau tidak
    $category->delete();

    return response()->json(['success' => true]);
}

}
