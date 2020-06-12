@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($products as $product)
            <div class="card badge-light mb-3">
                <div class="card-header">
                    <strong>{{ $product->{\App\Constants\Product::NAME} }}</strong>
                </div>
                <div class="card-body">
                    {{ $product->{\App\Constants\Product::DESCRIPTION} }}
                </div>
                <div class="card-footer">
                    @foreach($product->colors as $color)
                        {{ $color->name }}
                        <span class="badge badge-secondary">
                            {{
                                $color->pivot->{
                                    \App\Constants\ColorProduct::PRICE
                                }
                            }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{ $products->render() }}
    </div>
@endsection
