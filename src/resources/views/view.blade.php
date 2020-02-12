{{-- Include stylesheet for ES background colors --}}

@extends('web::layouts.grids.12')
@section('title', 'ES Intel Request')
@section('page_header', 'ES Intel Request')



@section('full')

<link href="{{ asset('esintel/css/esintel.css') }}" rel="stylesheet" type="text/css">

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading bg-green">
                <h3 class="panel-title"> Search Character </h3>
            </div>
            <div class="panel-body">
                <form method="post" id="esintelsearch">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="charname">Character Name</label>
                        <input type="text" id="charname" name="charname" class="form-control" value="{{ old('charname') }}" />
                    </div>
                </form>
            </div>
            {{-- Panel Footer --}}
            <div class="panel-footer clearfix">
                <button type="submit" class="btn btn-success pull-right" form="esintelsearch"> Search Character </button>
            </div>
        </div>
    </div>
    {{-- End left column --}}
    {{-- Start right column containing character data --}}
    {{-- Render only if a search result is given --}}
    @if($id)
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <div class="row">
                        @if($characterInDB)
                        <img class="img-circle" src={{$character->getPortraitUrl(128)}}>
                        @else
                        <img class="img-circle" src="https://images.evetech.net/characters/{{$id}}/portrait?size=128">
                        @endif
                    </div>
                    <div class="row">
                        <h3> {{$character->name}}</h3>
                    </div>
                    {{-- Insert row for creation or edit --}}
                    @if(auth()->user()->has("esintel.create", false))
                    <div class="row" style="padding-bottom: 1em;">
                        <div class="col-xs-4-8">
                            @if($characterInDB && (auth()->user()->has('esintel.edit', false)))
                            <a href="{{ route("edit", array($character->character_id)) }}" class="btn btn-warning"> Edit Character </a>
                            @elseif(!$characterInDB)
                            <a href="{{ route("esintel.create") }}" class="btn btn-success"> Create Character </a>
                            @endif
                        </div>
                    </div>
                    @endif
                    {{-- Row below portrait and name contains Ranking, Metadata --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Ranking </h3>
                                </div>
                                @if($characterInDB)
                                <div class="panel-body text-center es-{{ $character->es }}">
                                    <h1><b> ES {{ $character->es}} </b></h1>
                                </div>
                                @else
                                <div class="panel-body text-center es-no">
                                    <h1><b> No ES </b></h1>
                                </div>
                                @endif
                            </div>
                        </div>
                        {{-- Panel with character information --}}
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Character Information </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-hover text-left">
                                            <tbody>
                                                <tr>
                                                    <th> Name: </th>
                                                    <td> </td>
                                                    <td> {{ $character->name }} </td>
                                                </tr>
                                                <tr>
                                                    <th> Corporation: </th>
                                                    <td> <img src="{{ $character->getCorpLogoUrl(32)}}" style="width:16px;"> </td>
                                                    <td> {{ $character->corpinfo()->name }} </td>
                                                </tr>
                                                @if(isset($character->corpinfo()->alliance_id))
                                                <tr>
                                                    <th> Alliance:</th>
                                                    <td> <img src="{{ $character->getAllianceLogoUrl(32)}}" style="width:16px;"> </td>
                                                    <td> {{ $character->allianceinfo()->name }} </td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <th> Security Status: </th>
                                                    <td> </td>
                                                    <td> {{ round($character->info->security_status, 2) }} </td>
                                                </tr>
                                                <tr>
                                                    <th> Date of Birth: </th>
                                                    <td> </td>
                                                    <td> {{ carbon($character->info->birthday)->toDateString() }}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Panel Character Information --}}
                        {{-- Panel Corporation History --}}
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Corporation History </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-hover text-left">
                                            <thead>
                                                <tr>
                                                    <th> </th>
                                                    <th> Corporation </th>
                                                    <th> Joined </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($character->history as $h)
                                                <tr>
                                                    <td> <img src="https://images.evetech.net/corporations/{{$h->corporation_id}}/logo?size=32" style="width:16px;"> </td>
                                                    <td> {{ $h->corporation_name }} </td>
                                                    <td> {{ carbon($h->start_date)->toDateString() }} </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Corporation History --}}
                        {{-- Metadata Panel --}}
                        @if($characterInDB)
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Metadata </h3>
                                </div>
                                <div class="panel-body text-left">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th> Created at: </th>
                                                    <td> {{ carbon($character->created_at)->toDateTimeString() }} </td>
                                                </tr>
                                                <tr>
                                                    <th> Updated at: </th>
                                                    <td> {{ carbon($character->updated_at)->toDateTimeString() }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- End Metadata Panel --}}
                        {{-- Panel ES Category --}}
                    </div>
                    {{-- End of first row --}}
                    {{-- Second row --}}
                    @if(auth()->user()->has('esintel.view_related', false))
                    <div class="row">
                        @if($character->mainchar)
                        <div class="col-xs-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Main Character </h3>
                                </div>
                                <div class="panel-body text-center">
                                    <div class="row">
                                        <img src="{{ $character->mainchar->getPortraitUrl(64) }}" class="img-thumbnail" />
                                    </div>
                                    <div class="row">
                                        <h4> <a href={{ route("esintel.view", ["id" => $character->main_character_id]) }}> {{ $character->mainchar->name }} </a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($character->related)
                        @if($character->mainchar)
                        <div class="col-md-8">
                        @else
                        <div class="col-md-8 col-md-offset-4">
                        @endif
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Related Characters </h3>
                                </div>
                                <div class="panel-body text-center">
                                    <div class="col-xs-12">
                                        @foreach($character->related as $alt)
                                        <div class="col-xs-3">
                                            <div class="row">
                                                <img src="{{ $alt->getPortraitUrl(64) }}" class="img-thumbnail"/>
                                            </div>
                                            <div class="row">
                                                <a href={{ route('esintel.view', ["id" => $alt->character_id]) }}> {{ $alt->name }} </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    {{-- End of second row --}}
                    {{-- Third row --}}
                    <div class="row">
                        @if(auth()->user()->has('esintel.view_category', false) and $characterInDB)
                        <div class="col-xs-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Ranking Category </h3>
                                </div>
                                <div class="panel-body">
                                    {{-- This is a placeholder until the logic is written --}}
                                    <h4> {{ $category_name }} </h4>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- Intel Description Field --}}
                        @if(auth()->user()->has('esintel.view_description', false) and $characterInDB)
                        <div class="col-xs-8">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> Detailed Information </h3>
                                </div>
                                <div class="panel-body text-left">
                                    {!! $character->intel_text !!}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    {{-- End of third row --}}
                    {{-- Fourth row --}}
                    <div class="row">

                    </div>
                    {{-- End of fourth row --}}
                <div>
            </div>
        </div>
    </div>
    {{-- End Panel with Character Data --}}
    @endif
</div>

@endsection