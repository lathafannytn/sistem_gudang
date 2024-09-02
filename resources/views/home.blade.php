@extends('layouts.app')

@section('title', 'Home')

@section('page-header')
<div class="page-header">
  <h3 class="page-title"> Home </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span></span>Home <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ol>
  </nav>
</div>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Welcome to ID-Grow</h4>
        <p class="card-text">This is the home page.</p>
      </div>
    </div>
  </div>
</div>
@endsection
