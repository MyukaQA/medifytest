<?php

namespace App\Http\Controllers;

use App\Models\CategoryItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryItemsController extends Controller
{
    public function index()
    {
        return view('category_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = CategoryItems::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->select('kode', 'nama')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = CategoryItems::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('category_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = CategoryItems::where('kode', $kode)->first();
        return view('category_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new CategoryItems;
            $kode = CategoryItems::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = CategoryItems::find($id);
            $kode = $data_item->kode;
        }
        
        $data_item->nama = $request->nama;
        $data_item->kode = $kode;
        $data_item->save();

        return redirect('category-items');
    }

    public function delete($id)
    {
        CategoryItems::find($id)->delete();
        return redirect('category-items');
    }
}
