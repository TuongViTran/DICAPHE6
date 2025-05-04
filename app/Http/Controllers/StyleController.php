<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Style;
use App\Models\CoffeeShop; // Điều chỉnh không gian tên nếu cần

class StyleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter'); // Thêm filter

        $styles = Style::withCount('coffeeshops')
            ->when($search, function ($queryBuilder) use ($search) {
                return $queryBuilder->where('style_name', 'like', '%' . $search . '%');
            })
            ->when($filter, function ($queryBuilder) use ($filter) {
                if ($filter == 'asc') {
                    return $queryBuilder->orderBy('coffeeshops_count', 'asc');
                } elseif ($filter == 'desc') {
                    return $queryBuilder->orderBy('coffeeshops_count', 'desc');
                }
            })
            ->get(); // Nếu bạn muốn phân trang thì thay bằng ->paginate(10)

        return view('backend.admin.styles.index', compact('styles'));
    }

    public function create()
    {
        return view('backend.admin.styles.create');
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
        $coffeeShops = CoffeeShop::where('styles_id', $id)->get();
        return view('backend.admin.styles.show', compact('coffeeShops'));
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
