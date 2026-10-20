<div>
    <style>
        /* Smooth scale animation for all modals in this component */
        .modal.fade .modal-dialog {
            transform: scale(0.85);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }
        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }
    </style>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/categories.css') }}" />
    @endpush
    <div class="premium-page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Categories</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Parent Categories Start -->
    <div class="pd-20 card-box mb-30 premium-card">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2">
            <div>
                <h4 class="premium-card-title"><i class="fa fa-folder-open-o mr-2 text-primary"></i>Parent categories</h4>
            </div>
            <div class="d-flex align-items-center" style="gap: 15px;">
                <input type="text" wire:model.live.debounce.500ms="searchParentCategory" class="form-control premium-search" placeholder="Search parent...">
                <a href="javascript:;" wire:click="addParentCategory()" class="custom-action-btn add-btn m-0">
                    <i class="fa fa-plus"></i> Add P. category
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table premium-table table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="5%" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">N. of categories</th>
                        <th scope="col" class="text-center" width="15%" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable_parent_categories">
                    @forelse($pcategories as $pcategory)
                    <tr data-id="{{ $pcategory->id }}">
                        <td style="font-weight: 600; vertical-align: middle;">
                            <div class="d-flex align-items-center">
                                <span class="drag-handle-icon mr-2"><i class="fa fa-arrows-v"></i></span>
                                <span>{{ $loop->iteration }}</span>
                            </div>
                        </td>
                        <td style="vertical-align: middle; font-weight: 500; font-size: 15px; color: #334155;">{{ $pcategory->name }}</td>
                        <td style="vertical-align: middle;"><span class="premium-badge">{{ $pcategory->subcategories_count }} Subcategories</span></td>
                        <td class="text-center" style="vertical-align: middle;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 6px;">
                                <a href="javascript:;" wire:click="editParentCategory({{ $pcategory->id }})" class="custom-action-btn edit-btn" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="javascript:;" wire:click="deleteParentCategory({{ $pcategory->id }})" class="custom-action-btn delete-btn" title="Delete">
                                     <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state" style="padding: 40px 20px; text-align: center;">
                                <i class="fa fa-folder-open-o" style="font-size: 48px; color: #e2e8f0; margin-bottom: 15px; display: block;"></i>
                                <span style="font-size: 16px; color: #64748b; font-weight: 500;">No parent categories found</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="padding: 0 10px; border-top: 1px solid #cbd5e1;">
            <div class="d-flex align-items-center">
                <span class="mr-2 text-muted" style="font-weight: 500; font-size: 14px;">Show:</span>
                <select name="parentCategoryPerPage" id="parentCategoryPerPage" wire:model.live="parentCategoryPerPage" class="form-control premium-select" style="width: 75px; height: 35px; padding: 4px 10px; cursor: pointer;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
            <div class="pagination-wrapper">
                {{ $pcategories->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
    <!-- Parent Categories End -->

    <!-- Sub Categories Start -->
    <div class="pd-20 card-box mb-30 premium-card secondary" style="margin-top: 40px;">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2">
            <div>
                <h4 class="premium-card-title" style="background: -webkit-linear-gradient(45deg, #1e293b, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><i class="fa fa-tags mr-2" style="color: #a855f7;"></i>Categories</h4>
            </div>
            <div class="d-flex align-items-center" style="gap: 15px;">
                <input type="text" wire:model.live.debounce.500ms="searchCategory" class="form-control premium-search" placeholder="Search categories...">
                <a href="javascript:;" wire:click="addCategory()" class="custom-action-btn add-btn m-0">
                    <i class="fa fa-plus"></i> Add category
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table premium-table table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="5%" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Parent category</th>
                        <th scope="col">N. of posts</th>
                        <th scope="col" class="text-center" width="15%" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable_categories">
                    @forelse($categories as $category)
                    <tr data-id="{{ $category->id }}">
                        <td style="font-weight: 600; vertical-align: middle;">
                            <div class="d-flex align-items-center">
                                <span class="drag-handle-icon mr-2"><i class="fa fa-arrows-v"></i></span>
                                <span>{{ $loop->iteration }}</span>
                            </div>
                        </td>
                        <td style="vertical-align: middle; font-weight: 500; font-size: 15px; color: #334155;">{{ $category->name }}</td>
                        <td style="vertical-align: middle; font-size: 14px; color: #64748b;">{{ $category->parentCategory->name ?? 'Uncategorized' }}</td>
                        <td style="vertical-align: middle;"><span class="premium-badge secondary-badge">{{ $category->posts_count }} Posts</span></td>
                        <td class="text-center" style="vertical-align: middle;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 6px;">
                                <a href="javascript:;" wire:click="editCategory({{ $category->id }})" class="custom-action-btn edit-btn" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="javascript:;" wire:click="deleteCategory({{ $category->id }})" class="custom-action-btn delete-btn" title="Delete">
                                     <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state" style="padding: 40px 20px; text-align: center;">
                                <i class="fa fa-tags" style="font-size: 48px; color: #e2e8f0; margin-bottom: 15px; display: block;"></i>
                                <span style="font-size: 16px; color: #64748b; font-weight: 500;">No categories found</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="padding: 0 10px; border-top: 1px solid #cbd5e1;">
            <div class="d-flex align-items-center">
                <span class="mr-2 text-muted" style="font-weight: 500; font-size: 14px;">Show:</span>
                <select name="categoryPerPage" id="categoryPerPage" wire:model.live="categoryPerPage" class="form-control premium-select" style="width: 75px; height: 35px; padding: 4px 10px; cursor: pointer;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
            <div class="pagination-wrapper">
                {{ $categories->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
    <!-- Sub Categories End -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade custom-modal" id="parentCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">{{ $updateParentCategoryMode ? 'Update Parent Category' : 'Add Parent Category' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form wire:submit.prevent="{{ $updateParentCategoryMode ? 'updateParentCategory' : 'createParentCategory' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control premium-input" wire:model="pcategory_name" placeholder="Enter parent category name">
                            @error('pcategory_name')
                                <span class="text-danger ml-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">{{ $updateParentCategoryMode ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Parent Category Modal -->
    <div wire:ignore.self class="modal fade" id="deleteParentCategoryModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 30px;">
                <div class="modal-body">
                    <div class="mb-4">
                        <div style="width: 80px; height: 80px; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fa fa-trash text-danger" style="font-size: 36px;"></i>
                        </div>
                    </div>
                    <h4 class="font-weight-bold mb-3" style="color: #1e293b;">Are you sure?</h4>
                    <p class="text-muted mb-4" style="font-size: 16px;">Do you really want to delete this parent category? This action cannot be undone.</p>
                    
                    <div class="d-flex justify-content-center" style="gap: 15px;">
                        <button type="button" class="btn btn-light rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 font-weight-bold shadow-sm" wire:click="destroyParentCategory">
                            <span wire:loading.remove wire:target="destroyParentCategory">Yes, Delete it!</span>
                            <span wire:loading wire:target="destroyParentCategory" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span wire:loading wire:target="destroyParentCategory" class="ml-1">Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div wire:ignore.self class="modal fade custom-modal" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">{{ $updateCategoryMode ? 'Update Category' : 'Add Category' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form wire:submit.prevent="{{ $updateCategoryMode ? 'updateCategory' : 'createCategory' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select class="form-control premium-select" wire:model="parent_category" style="width: 100%; height: 48px; padding: 12px 18px; border-radius: 12px;">
                                <option value="0">Select Parent Category</option>
                                @foreach($all_pcategories as $pcategory)
                                    <option value="{{ $pcategory->id }}">{{ $pcategory->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_category')
                                <span class="text-danger ml-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control premium-input" wire:model="category_name" placeholder="Enter category name">
                            @error('category_name')
                                <span class="text-danger ml-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-save">{{ $updateCategoryMode ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div wire:ignore.self class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 30px;">
                <div class="modal-body">
                    <div class="mb-4">
                        <div style="width: 80px; height: 80px; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fa fa-trash text-danger" style="font-size: 36px;"></i>
                        </div>
                    </div>
                    <h4 class="font-weight-bold mb-3" style="color: #1e293b;">Are you sure?</h4>
                    <p class="text-muted mb-4" style="font-size: 16px;">Do you really want to delete this category? This action cannot be undone.</p>
                    
                    <div class="d-flex justify-content-center" style="gap: 15px;">
                        <button type="button" class="btn btn-light rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 font-weight-bold shadow-sm" wire:click="destroyCategory">
                            <span wire:loading.remove wire:target="destroyCategory">Yes, Delete it!</span>
                            <span wire:loading wire:target="destroyCategory" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span wire:loading wire:target="destroyCategory" class="ml-1">Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    window.addEventListener('showParentCategoryModal', function(e){
        $('#parentCategoryModal').modal('show');
    });
    window.addEventListener('hideParentCategoryModal', function(e){
        $('#parentCategoryModal').modal('hide');
    });
    window.addEventListener('showDeleteParentCategoryModal', function(e){
        $('#deleteParentCategoryModal').modal('show');
    });
    window.addEventListener('hideDeleteParentCategoryModal', function(e){
        $('#deleteParentCategoryModal').modal('hide');
    });

    window.addEventListener('showCategoryModal', function(e){
        $('#categoryModal').modal('show');
    });
    window.addEventListener('hideCategoryModal', function(e){
        $('#categoryModal').modal('hide');
    });
    window.addEventListener('showDeleteCategoryModal', function(e){
        $('#deleteCategoryModal').modal('show');
    });
    window.addEventListener('hideDeleteCategoryModal', function(e){
        $('#deleteCategoryModal').modal('hide');
    });
</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        if($.fn.sortable) {
            $('#sortable_parent_categories').sortable({
                cursor: 'grabbing',
                cancel: '.custom-action-btn',
                opacity: 0.9,
                placeholder: 'sortable-placeholder',
                helper: function(e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index) {
                        $(this).width($originals.eq(index).width());
                    });
                    $helper.css({
                        'box-shadow': '0 5px 15px rgba(0,0,0,0.15)',
                        'background-color': '#ffffff',
                        'border-radius': '6px',
                        'display': 'table-row'
                    });
                    return $helper;
                },
                update: function(event, ui) {
                    let items = [];
                    $('#sortable_parent_categories tr').each(function(index) {
                        let id = $(this).data('id');
                        if (id !== undefined) {
                            items.push([index + 1, id]);
                        }
                    });
                    @this.call('updateParentCategoryOrdering', items);
                }
            });

            $('#sortable_categories').sortable({
                cursor: 'grabbing',
                cancel: '.custom-action-btn',
                opacity: 0.9,
                placeholder: 'sortable-placeholder',
                helper: function(e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index) {
                        $(this).width($originals.eq(index).width());
                    });
                    $helper.css({
                        'box-shadow': '0 5px 15px rgba(0,0,0,0.15)',
                        'background-color': '#ffffff',
                        'border-radius': '6px',
                        'display': 'table-row'
                    });
                    return $helper;
                },
                update: function(event, ui) {
                    let items = [];
                    $('#sortable_categories tr').each(function(index) {
                        let id = $(this).data('id');
                        if (id !== undefined) {
                            items.push([index + 1, id]);
                        }
                    });
                    @this.call('updateCategoryOrdering', items);
                }
            });
        }
    });
</script>
@endpush
