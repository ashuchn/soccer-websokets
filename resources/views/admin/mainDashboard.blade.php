@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">

   
                @if (\Session::has('error'))
                    <div class="alert alert-warning">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                @endif
                @php
                    session()->forget('error');
                @endphp

    <div class="content">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-12 ">

                <hr>
                @include('admin.partials.navbar')
                    
                </div>
            
            
            </div>
        </div>
    </div>
</div>

@endsection