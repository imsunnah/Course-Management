@extends('master')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">📂 Category Management</h2>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-semibold">Add New Category</div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Category Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">➕ Add Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Category List -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">Category List</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Name</th>
                        <th width="10%">Status</th>
                        <th width="20%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $key => $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $key }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('categories.toggle', $category->id) }}"
                                   class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </a>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary editBtn" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-status="{{ $category->status }}">✏️ Edit</button>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">No categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $categories->links() }}
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" method="POST" class="modal-content">
        @csrf @method('PUT')
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
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
        <div class="modal-footer">
            <button class="btn btn-success" type="submit">💾 Update</button>
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
</script>
@endsection
