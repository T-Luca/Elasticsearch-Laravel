@extends('layouts.main')

@section('content')
        <form method="post" action="{{ route('store-product') }}">
            <h3 class="text-center">Add new product</h3><br>
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="productTitle" class="col-sm-2 col-form-label">Title*</label>
                <div class="col-sm-10">
                    <input name="title" type="text" id="productTitle" class="form-control" placeholder="Product name...">
                </div>
            </div>
            <div class="form-group row">
                <label for="productDescription" class="col-sm-4 col-form-label">Description*</label>
                <div class="col-sm-12">
                    <textarea name="description" class="form-control" id="productDescription" placeholder="Short description of product"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="productStock" class="col-sm-2 col-form-label">Stock*</label>
                <div class="col-sm-10">
                    <input name="stock" class="form-control" id="productStock">
                </div>
            </div>
            <div class="form-group row">
                <label for="productPrice" class="col-sm-2 col-form-label">Price*</label>
                <div class="col-sm-10">
                    <input name="price" class="form-control" id="productPrice" placeholder="Product price...">
                </div>
            </div>
            <div class="form-group row">
                <label for="productImage" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input name="image" class="form-control" id="productImage" placeholder="Link to image">
                </div>
            </div>

            <div class="text-center">
                <small>Fields marked with * are required</small><br><br>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>
@endsection