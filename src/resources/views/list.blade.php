@extends('web::layouts.grids.12')

@push('head')
    <link href="{{ asset('esintel/css/esintel.css') }}" rel="stylesheet" type="text/css">
@endpush

@section('title', 'ES Intel Character List')
@section('page_header', 'ES Intel Character List')


@section('full')


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> ES Intel Character List </h3>
            </div>
            <div class="panel-body">

                {!! $dataTable->table(['class' => 'table table-condensed table-hover table-responsive no-margin', 'id'=>'characterTable']) !!}

            </div>
        </div>
    </div>
</div>

@endsection

@push('javascript')

{!! $dataTable->scripts() !!}

@endpush