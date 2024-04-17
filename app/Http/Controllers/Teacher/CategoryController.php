<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\DeleteCategoryRequest;
use App\Http\Requests\Teacher\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Test;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::query()
            ->where('teacher_id', Auth::id())
            ->get();

        return Inertia::render('Teacher/Categories/List', ["categories" => $categories]);
    }

    public function showCategory(int $id): Response
    {
        $data['category'] = Category::query()
            ->with('tests')
            ->findOrFail($id);

        return Inertia::render('Teacher/Categories/ShowCategory', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = Category::query()
            ->where(
                [
                    'name' => $request->post('name'),
                    'teacher_id' => Auth::id(),
                ]
            );

        if ($category->exists()) {
            return back()->withErrors(
                [
                    'name' => 'Имя категории должно быть уникальным.',
                ]
            );
        }

        Category::query()
            ->insert(
                [
                    'name' => $request->post('name'),
                    'teacher_id' => Auth::id(),
                ]
            );

        return redirect(route('categories', absolute: false));
    }

    public function destroy(DeleteCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Category::query()
            ->where('id', $data['category_id'])
            ->delete();

        return redirect()->route('categories');
    }
}
