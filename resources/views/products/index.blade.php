@extends('layouts.main')

@section('head-data')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    @if(count($products) > 0)
        <form class="form-inline" method="post" action="{{ route('search-product') }}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="searchTerm" class="col-sm-4 col-form-label">Search term</label>
                <div class="col-sm-6">
                    <input name="text" class="form-control" id="searchTerm" placeholder="Intel">
                </div>
            </div>
            <div class="form-group row" style="margin-left: 10px">
                <button type="submit" id="searchButton" style="margin-left: 20%" class="btn btn-primary">Search</button>
            </div>
        </form>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Stock</th>
                <th scope="col">Price</th>
                <th scope="col">Cover image</th>
            </tr>
            </thead>
            <tbody>
                <?php $i = 1 ?>
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->price }}</td>

                        @if($product->imagePath !== null && $product->imagePath !== '')
                            <td>
                                <a href="http://eshop.com">
                                <img src="{{ $product->imagePath }}" style="width: 150px; height: 150px">
                                </a>
                            </td>
                        @else
                            <td>No image</td>
                        @endif
                    </tr>
                    <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
    @else
        <h3>No products found</h3>
    @endif
@endsection