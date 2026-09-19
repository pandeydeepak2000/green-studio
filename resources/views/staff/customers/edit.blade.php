@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.staff')

@section('title', 'Edit Customer')
@section('page_title', 'Edit Customer')

@section('content')

@include('staff.customers.create', ['customer' => $customer])

@endsection