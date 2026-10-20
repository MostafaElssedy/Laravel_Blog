<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use App\Models\ParentCategory;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $pcategory_name;
    public $selected_id;
    public $updateParentCategoryMode = false;
    public $delete_id;

    public $category_name;
    public $parent_category = 0;
    public $selected_category_id;
    public $updateCategoryMode = false;
    public $delete_category_id;

    public $parentCategoryPerPage = 5;
    public $categoryPerPage = 10;

    public $searchParentCategory = '';
    public $searchCategory = '';

    public function updatedParentCategoryPerPage()
    {
        $this->resetPage('parentCategoryPage');
    }

    public function updatedSearchParentCategory()
    {
        $this->resetPage('parentCategoryPage');
    }

    public function updatedCategoryPerPage()
    {
        $this->resetPage('categoryPage');
    }

    public function updatedSearchCategory()
    {
        $this->resetPage('categoryPage');
    }

    public function addParentCategory()
    {
        $this->reset('pcategory_name', 'selected_id');
        $this->updateParentCategoryMode = false;
        $this->dispatch('showParentCategoryModal');
    }

    public function createParentCategory()
    {
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name',
        ], [
            'pcategory_name.required' => 'Enter parent category name',
            'pcategory_name.unique' => 'Parent category name already exists',
        ]);

        $pcategory = new ParentCategory();
        $pcategory->name = $this->pcategory_name;
        $pcategory->save();

        $this->dispatch('hideParentCategoryModal');
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Parent Category has been created successfully.']);
    }

    public function editParentCategory($id)
    {
        $pcategory = ParentCategory::findOrFail($id);
        $this->selected_id = $pcategory->id;
        $this->pcategory_name = $pcategory->name;
        $this->updateParentCategoryMode = true;
        $this->dispatch('showParentCategoryModal');
    }

    public function updateParentCategory()
    {
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name,'.$this->selected_id,
        ], [
            'pcategory_name.required' => 'Enter parent category name',
            'pcategory_name.unique' => 'Parent category name already exists',
        ]);

        $pcategory = ParentCategory::findOrFail($this->selected_id);
        $pcategory->name = $this->pcategory_name;
        $pcategory->save();

        $this->dispatch('hideParentCategoryModal');
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Parent Category has been updated successfully.']);
    }

    public function deleteParentCategory($id)
    {
        $this->delete_id = $id;
        $this->dispatch('showDeleteParentCategoryModal');
    }

    public function destroyParentCategory()
    {
        $pcategory = ParentCategory::findOrFail($this->delete_id);
        
        if ($pcategory->subcategories()->count() > 0) {
            $this->dispatch('hideDeleteParentCategoryModal');
            $this->dispatch('showToast', ['type' => 'error', 'message' => 'Cannot delete this Parent Category because it contains subcategories!']);
            return;
        }

        $pcategory->delete();
        $this->dispatch('hideDeleteParentCategoryModal');
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Parent Category has been deleted successfully.']);
    }

    public function updateParentCategoryOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $position[0];
            $id = $position[1];
            ParentCategory::where('id', $id)->update([
                'ordering' => $index
            ]);
        }
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Parent Categories ordering updated successfully.']);
    }

    public function addCategory()
    {
        $this->reset('category_name', 'parent_category', 'selected_category_id');
        $this->updateCategoryMode = false;
        $this->dispatch('showCategoryModal');
    }

    public function createCategory()
    {
        $this->validate([
            'category_name' => 'required|unique:categories,name',
            'parent_category' => 'required|exists:parent_categories,id',
        ], [
            'category_name.required' => 'Enter category name',
            'category_name.unique' => 'Category name already exists',
            'parent_category.required' => 'Select a parent category',
            'parent_category.exists' => 'Selected parent category is invalid',
        ]);

        $category = new Category();
        $category->name = $this->category_name;
        $category->parent = $this->parent_category;
        $category->save();

        $this->dispatch('hideCategoryModal');
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Category has been created successfully.']);
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->selected_category_id = $category->id;
        $this->category_name = $category->name;
        $this->parent_category = $category->parent;
        $this->updateCategoryMode = true;
        $this->dispatch('showCategoryModal');
    }

    public function updateCategory()
    {
        $this->validate([
            'category_name' => 'required|unique:categories,name,'.$this->selected_category_id,
            'parent_category' => 'required|exists:parent_categories,id',
        ], [
            'category_name.required' => 'Enter category name',
            'category_name.unique' => 'Category name already exists',
            'parent_category.required' => 'Select a parent category',
            'parent_category.exists' => 'Selected parent category is invalid',
        ]);

        $category = Category::findOrFail($this->selected_category_id);
        $category->name = $this->category_name;
        $category->parent = $this->parent_category;
        $category->save();

        $this->dispatch('hideCategoryModal');
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Category has been updated successfully.']);
    }

    public function deleteCategory($id)
    {
        $this->delete_category_id = $id;
        $this->dispatch('showDeleteCategoryModal');
    }

    public function destroyCategory()
    {
        $category = Category::findOrFail($this->delete_category_id);

        if ($category->posts()->count() > 0) {
            $this->dispatch('hideDeleteCategoryModal');
            $this->dispatch('showToast', ['type' => 'error', 'message' => 'Cannot delete this category because it contains posts!']);
            return;
        }

        $category->delete();
        $this->dispatch('hideDeleteCategoryModal');
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Category has been deleted successfully.']);
    }

    public function updateCategoryOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $position[0];
            $id = $position[1];
            Category::where('id', $id)->update([
                'ordering' => $index
            ]);
        }
        $this->dispatch('showToast', ['type' => 'success', 'message' => 'Categories ordering updated successfully.']);
    }

    public function render()
    {
        $pcategories = ParentCategory::withCount('subcategories')
            ->where('name', 'like', '%' . $this->searchParentCategory . '%')
            ->orderBy('ordering', 'asc')
            ->paginate($this->parentCategoryPerPage, ['*'], 'parentCategoryPage');

        $categories = Category::with('parentCategory')
            ->withCount('posts')
            ->where('name', 'like', '%' . $this->searchCategory . '%')
            ->orderBy('ordering', 'asc')
            ->paginate($this->categoryPerPage, ['*'], 'categoryPage');

        $all_pcategories = ParentCategory::orderBy('ordering', 'asc')->get();

        return view('livewire.categories.categories', [
            'pcategories' => $pcategories,
            'categories' => $categories,
            'all_pcategories' => $all_pcategories
        ]);
    }
}
