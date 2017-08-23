@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            @if(count($featuredProducts) <= 0)
                <p>Sorry No Feature Product</p>
            @else
                <div class="col-12">

                    <div class="h1">
                        Inside Module Featured Products
                    </div>
                    @foreach($featuredProducts as $product)
                        <div class="col-4">
                            @include('catalog.product.view.product-card',['product'=> $product])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection