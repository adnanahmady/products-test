@extends('layouts.app')

@section('content')
    @foreach($products as $product)
        <div class="card">
            <div class="card-header">
                <strong>{{ $product->{\App\Constants\Product::NAME} }}</strong>
            </div>
            <div class="card-body">
                {{ $product->{\App\Constants\Product::DESCRIPTION} }}
            </div>
        </div>
    @endforeach
@endsection
