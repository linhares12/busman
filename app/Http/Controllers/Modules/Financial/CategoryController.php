<?php

namespace App\Http\Controllers\Modules\Financial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Financial\Category;
use App\Models\Financial\Release;
use Validator;

class CategoryController extends Controller
{
    public function index(){
        $pageParam = ['title' => 'Gerenciamento de Categorias'];

    	$categories = Category::allCategories();

    	return view('modules.financial.category.cat-manager')
                ->with($pageParam)
                ->with('categories', $categories);
    }

    public function store(Request $request){
        $v = Validator::make($request->all(),[
				'name' => 'required|max:255',
				'color' => 'required|max:255',
				'type' => 'categoryType|required|max:255',
			]);

        if ($v->fails()) {
                return back()->withErrors($v)->withInput();
        }
        $insert = $request->all();
        $insert['company'] = auth()->user()->company;

        Category::create($insert);

        return redirect('/admin/config/categorias');
    }

    public function update(Request $request){
        $v = Validator::make($request->all(),[
                                'id' => 'required',
				'name_edit' => 'required|max:255',
				'color_edit' => 'required|max:255',
			]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $data['name'] = $request->name_edit;
        $data['color'] = $request->color_edit;

        $category = Category::findOrFail($request->id);

        if($category){
                $category->update($data);
        }

        return redirect('/admin/config/categorias');
    }

    public function destroy(Request $request){
        if ($request->cat_id) {
    		$category = Category::findOrFail($request->cat_id);

            $test = Release::where('category', '=', $category->id);

            if($test->count() > 0){
                return back()->withErrors(['Esta categoria é utilizada em alguns lançamentos. Por isso não pode ser eliminada.']);
            }else{
                $category->delete();
                return back()->with('success', 'Categoria eliminada com sucesso!');
            }
    	}

    	return redirect('/admin/config/categorias');
    }
}
