<div>

    @include('livewire.admin.brand.modal-form')

    <div class="content-header">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Brand List</h3>
                
                                <div class="card-tools">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addBrandModal" class="btn btn-primary btn-sm">Add Brands</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->id }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>
                                                @if($brand->category_id)
                                                    {{ $brand->category->name }}
                                                @else
                                                    No Category
                                                @endif
                                            </td>
                                            <td>{{ $brand->slug }}</td>
                                            <td>{{ $brand->status == '1' ? 'Hidden':'Visible' }}</td>
                                            <td>
                                                <a href="#" wire:click="editBrand({{ $brand->id }})" data-bs-toggle="modal" data-bs-target="#updateBrandModal" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="#" wire:click="deleteBrand({{ $brand->id }})" data-bs-toggle="modal" data-bs-target="#deleteBrandModal" class="btn btn-danger btn-sm">Delete</a>
                                        </tr>
                                            
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Brands Found</td>
                                            </tr>
                                        @endforelse
                                        
                                    </tbody>
                                </table>    
                                <div>
                                    {{ $brands->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
</div>

@push('script')

<script>
    window.addEventListener('close-modal', event => {
        $('#addBrandModal').modal('hide');
        $('#updateBrandModal').modal('hide');
        $('#deleteBrandModal').modal('hide');
    });

</script>

@endpush
