@extends('layouts.staff')

@section('title', 'Edit Customer')
@section('page_title', 'Edit Customer')

@section('content')

@include('staff.customers.create', ['customer' => $customer])

@endsection