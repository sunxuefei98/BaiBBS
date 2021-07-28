@extends('layouts.app')

@section('title', $user->name . " 's profile")

@section('content')

  <div class="row">


    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">


      <div class="card ">
        <img class="card-img-top" src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600" alt="{{ $user->name }}">
        <div class="card-body">
          <h5><strong>Introduction</strong></h5>
          <p>{{ $user->introduction }}</p>
          <hr>
          <h5><strong>Registered at</strong></h5>
          <p>{{ $user->created_at->diffForHumans() }}</p>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

      @if(session()->has('success'))
        <div class="alert alert-success">
          {{ session()->get('success') }}
        </div>
      @endif

      <div class="card ">
        <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
        </div>

      </div>
      <hr>



      {{-- 用户发布的内容 --}}
      <div class="card ">
        <div class="card-body">
          No any data X_X
        </div>
      </div>

    </div>
  </div>
@stop
