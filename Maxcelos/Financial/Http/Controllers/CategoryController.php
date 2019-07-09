<?php

namespace Maxcelos\Financial\Http\Controllers;

use Nwidart\Modules\Routing\Controller;
use Maxcelos\Financial\Entities\Category;
use Maxcelos\Financial\Http\Requests\CategoryRequest;
use Maxcelos\Financial\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $this->authorize('index', Category::class);

        return response()->json(Category::jsonPaginate(), 200);
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        $category = $this->categoryService->make($request->all());

        return response()->json($category->toArray(), 201);
    }

    public function show($category)
    {
        $category = $this->categoryService->get($category);

        $this->authorize('view',  $category);

        return response()->json($category->toArray(), 200);
    }

    public function update(CategoryRequest $request, $category)
    {
        $this->authorize('update', $this->categoryService->get($category));

        $category = $this->categoryService->update($category, $request->all());

        return response()->json($category->toArray(), 200);
    }

    public function destroy($category)
    {
        $this->authorize('delete', $this->categoryService->get($category));

        $this->categoryService->delete($category);

        return response()->json(['message' => 'The role has been deleted'], 204);
    }
}
