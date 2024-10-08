<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPLE LARAVEL 11 CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
      <div class="bg-dark py-3">
        <h3 class="text-white text-center">SIMPLE LARAVEL 11 CRUD</h3>
      </div>
      <div class="container">
      <div class="row justify-content-center mt-4">
    <div class="col-md-10 d-flex justify-content-end">
        <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a>
    </div>
    </div>
      <div class="row d-flex justify-content-center">
        <div class="col-md-10">
          <div class="card border-0 shadow-lg my-4">
            <div class="card-header bg-dark">
              <h3 class="text-white">Edit Product</h3>
            </div>
            <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                @method('put')
              @csrf
             <div class="card-body">
                <div class="mb-3">
                  <label for="name" class="form-label h5">Name</label>
                  <input value="{{ old('name',$product->name) }}" type="text" class=" @error('name') is-invalid @enderror form-control form-control-lg" placeholder="Name" name="name" id="name">
                  @error('name')
                  <p class="invalid-feedback">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="sku" class="form-label h5">SKU</label>
                  <input value="{{ old('sku',$product->sku) }}" type="text" class=" @error('sku') is-invalid @enderror form-control form-control-lg" placeholder="SKU" name="sku" id="sku">
                  @error('sku')
                  <p class="invalid-feedback">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="price" class="form-label h5">Price</label>
                  <input value="{{ old('price',$product->price) }}" type="number" class="@error('price') is-invalid @enderror form-control form-control-lg" placeholder="Price" name="price" id="price">
                  @error('price')
                  <p class="invalid-feedback">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label h5">Description</label>
                  <textarea placeholder="Description" class="form-control" name="description" cols="30" rows="5" id="description">{{ old('description',$product->description) }}</textarea>
                </div>
                <div class="mb-3">
                  <label for="image" class="form-label h5">Image</label>
                  <input value="{{ old('image') }}" type="file" class="form-control form-control-lg" name="image" id="image">
                  @if($product->image)
                      <img src="{{ asset('uploads/products/' . $product->image) }}" class="w-50 my-3"   alt="Product Image">
                    @else
                      No image
                    @endif
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-lg btn-primary">update</button>
                </div>
             </div>
            </form>
          </div>
        </div>
      </div>
   </body>
</html>
