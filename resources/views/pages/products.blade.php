@extends('layouts.app')

@section('title', 'Products — Ajax Trading Corporation')
@section('meta_description', 'Melamine boards, laminated marine plywood, and modular kitchen hardware from Ajax Trading Corporation.')

@section('content')
<section class="products-page">
    <h1>Products</h1>
    <p>Full catalog and live pricing — see report Section 6/9 for the data bridge needed to pull real prices from the ERP's BoardPrice/MaterialPrice tables.</p>
    <div class="products-grid" id="products-grid"></div>
</section>
@endsection
