<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Style;

class StyleController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $styles = Style::withCount('coffeeshops') // Đếm số lượng quán cho mỗi phong cách
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('style_name', 'like', '%' . $query . '%');
            })
            ->get();
    
        return view('backend.admin.styles.index', compact('styles'));
    }

    public function create()
    {
        return view('backend.admin.styles.create'); // Đảm bảo rằng đường dẫn view là chính xác
    }

    public function store(Request $request)
    {
        $request->validate([
            'style_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Style::create($request->all());
        return redirect()->route('styles.index')->with('success', 'Phong cách đã được thêm thành công.');
    }

    public function show($id)
    {
        $style = Style::findOrFail($id);
        return view('backend.admin.styles.show', compact('style'));
    }

    public function edit($id)
    {
        $style = Style::findOrFail($id);
        return view('backend.admin.styles.edit', compact('style'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'style_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $style = Style::findOrFail($id);
        $style->update($request->all());
        return redirect()->route('styles.index')->with('success', 'Phong cách đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $style = Style::findOrFail($id);
        $style->delete();
        return redirect()->route('styles.index')->with('success', 'Phong cách đã được xóa thành công.');
    }
}