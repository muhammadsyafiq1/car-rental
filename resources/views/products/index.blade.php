@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Product List</h2>
    <button class="btn btn-success mb-3" id="createBtn">Add Product</button>
    <table class="table table-bordered" id="productTable">
        <thead>
            <tr>
                <th>ID</th><th>nama</th><th>Category</th><th>harga</th><th>stok</th><th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="productForm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Product Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" id="product_id">
              <div class="mb-3">
                <label>nama</label>
                <input type="text" class="form-control" id="nama">
              </div>
              <div class="mb-3">
                <label>Category</label>
                <select class="form-control" id="category_id"></select>
              </div>
              <div class="mb-3">
                <label>harga</label>
                <input type="number" class="form-control" id="harga">
              </div>
              <div class="mb-3">
                <label>stok</label>
                <input type="number" class="form-control" id="stok">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let searchTimer;

    let table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/products/data',
            type: 'GET',
            beforeSend: function(xhr) {
                if (typeof this.currentXHR !== 'undefined') {
                    this.currentXHR.abort();
                }
                this.currentXHR = xhr;
            },
            complete: function() {
                this.currentXHR = null;
            },
            error: function(xhr) {
                if (xhr.statusText !== 'abort') {
                    alert('Terjadi kesalahan.');
                }
            }
        },
        columns: [
            { data: 'id' },
            { data: 'nama' },
            { data: 'category.nama' },
            { data: 'harga' },
            { data: 'stok' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    $('#productTable_filter input').off().on('keyup', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            table.search(this.value).draw();
        }, 500);
    });

    function loadCategories() {
        $.get('/categories', function(res) {
            let select = $('#category_id').empty();
            res.forEach(cat => select.append(`<option value=\"${cat.id}\">${cat.nama}</option>`));
        });
    }

    $('#createBtn').click(function() {
        $('#product_id').val('');
        $('#productForm')[0].reset();
        loadCategories();
        $('#productModal').modal('show');
    });

    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        loadCategories();
        $.get('/products/' + id, function(res) {
            $('#product_id').val(res.id);
            $('#nama').val(res.nama);
            $('#harga').val(res.harga);
            $('#stok').val(res.stok);
            $('#category_id').val(res.category_id);
            $('#productModal').modal('show');
        });
    });

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        if (confirm('Delete this product?')) {
            $.ajax({
                url: '/products/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: () => table.ajax.reload()
            });
        }
    });

    $('#productForm').submit(function(e) {
        e.preventDefault();
        let id = $('#product_id').val();
        let method = id ? 'PUT' : 'POST';
        let url = id ? '/products/' + id : '/products';

        $.ajax({
            url: url,
            type: method,
            data: {
                _token: '{{ csrf_token() }}',
                nama: $('#nama').val(),
                harga: $('#harga').val(),
                stok: $('#stok').val(),
                category_id: $('#category_id').val()
            },
            success: () => {
                $('#productModal').modal('hide');
                table.ajax.reload();
            }
        });
    });
});
</script>
@endpush
