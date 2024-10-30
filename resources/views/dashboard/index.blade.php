@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('helpers.menu')
        <div class="col-10">
            <div class="card">
                <div class="card-header">{{ 'Dashboard' }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
