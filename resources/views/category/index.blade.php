@extends('master')

@section('content')
    <div class="container mt-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Category Management</h2>
            <button class="btn  shadow-sm" data-bs-toggle="collapse" data-bs-target="#createCategoryCard"
                style="background-color: #68a0d2">
                <i class="bi bi-plus-lg"></i> Add Category
            </button>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Add Category Form -->
        <div class="card shadow-sm mb-4 collapse" id="createCategoryCard">
            <div class="card-header  text-white fw-semibold d-flex justify-content-between align-items-center"
                style="background-color: #8d9eae">
                Add New Category
                <button class="btn btn-sm btn-light" data-bs-toggle="collapse"
                    data-bs-target="#createCategoryCard">✖️</button>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('categories.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-10">
                        <input type="text" name="name" class="form-control" placeholder="Category name" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end" style="background-color: #8d9eae">
                        <button type="submit" class="btn  w-100"><i class="bi bi-plus-lg"></i> Add</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Table -->
        <div class="card shadow-sm">
            <div class="card-header text-white fw-semibold" style="background-color: #68a0d2">Category List</div>
            <div class="card-body bg-light table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $category)
                            <tr class="{{ $key % 2 == 0 ? 'bg-white' : 'bg-light' }}">
                                <td>{{ $categories->firstItem() + $key }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <span class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $category->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-secondary editBtn" data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}" data-status="{{ $category->status }}"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger deleteBtn" data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="editForm" method="POST" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header  text-white" style="background-color: #68a0d2">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" id="editStatus" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn w-100"style="background-color: #68a0d2" type="submit"><i class="bi bi-save"></i>
                        Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteForm" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header text-white" style="background-color: #68a0d2">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <p>Are you sure you want to delete this category?</p>
                    <p class="fw-semibold" id="deleteCategoryName"></p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline" style="background-color: #68a0d2"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const status = this.dataset.status;

                document.getElementById('editName').value = name;
                document.getElementById('editStatus').value = status;
                document.getElementById('editForm').action = `/categories/${id}`;

                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;

                document.getElementById('deleteCategoryName').textContent = name;
                document.getElementById('deleteForm').action = `/categories/${id}`;

                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            });
        });
    </script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
            /* subtle hover effect */
        }

        .editBtn,
        .deleteBtn,
        .btn-outline-dark,
        .btn-outline-secondary {
            transition: transform 0.15s;
        }

        .editBtn:hover,
        .deleteBtn:hover,
        .btn-outline-dark:hover,
        .btn-outline-secondary:hover {
            transform: scale(1.05);
        }
    </style>
@endsection
