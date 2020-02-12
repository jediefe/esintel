@extends('web::layouts.grids.12')

@section('title', 'ES Intel')
@section('page_header', 'ES Intel')

@if(isset($character))
    @section('page_description', 'Edit Character')
@else
    @section('page description', 'Create new character entry')
@endif

@section('full')

    <div class="row">

        <div class="col-md-4 ">

            <div class="panel panel-default">
                @if(isset($character))
                    <div class="panel-heading bg-yellow">
                        <h3 class="panel-title"> Edit {{ $character->name }} </h3>
                @else
                    <div class="panel-heading bg-green">
                        <h3 class="panel-title"> Add new character </h3>
                @endif
                </div>
                <div class="panel-body">
                    <form method="post" id="esinteladdchar">

                        {{ csrf_field () }}
                        <div class="form-group">
                            <label for="charname">Character Name</label>
                            @if(isset($character))
                                <input type="text" id="charname" name="charname" class="form-control" readonly value="{{ $character->name }}" />
                            @else
                                <input type="text" id="charname" name="charname" class="form-control" value="{{old('charname')}}" />
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="maincharname"> Main Character Name (optional) </label>
                            @if(isset($character->main_character_id))
                                <input type="text" id="maincharname" name="maincharname" class="form-control" value="{{ $character->mainchar->name }}" />
                            @else
                                <input type="text" id="maincharname" name="maincharname" class="form-control" value="" />
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="eslevel"> ES Tier </label>
                            <select name="eslevel" id="eslevel" class="form-control">
                                @for ($i = 0; $i < 11; $i++)
                                    @if(isset($character) && $i == $character->es)
                                        <option selected value={{ $i }}> {{ $i }} </option>
                                    @else
                                        <option value={{ $i }}> {{ $i }} </option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="escategory"> ES Category </label>
                            <select name="escategory" id="escategory" class="form-control">
                                @forelse($categories as $cat)
                                <option value="{{ $cat->id }}"> {{ $cat->category_name }} </option>
                                @empty
                                <option value="0"> No categories in database </option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="estext"> Intelligence Information </label>
                            @if(isset($character))
                                <textarea type="text" class="form-control" rows="5" name="estext" id="estext">{{ $character->intel_text }}</textarea>
                            @else
                                <textarea type="text" class="form-control" rows="5" name="estext" id="estext"></textarea>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="panel-footer clearfix">
                    @if(isset($character))
                        <button type="submit" class="btn btn-warning pull-right" form="esinteladdchar"> Update Character </button>
                    @else
                        <button type="submit" class="btn btn-success pull-right" form="esinteladdchar"> Add Character </button>
                    @endif

                </div>
            </div>
        </div>

        @if(isset($character))
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"> About {{ $character->name }} </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <img class="image-responsive img-circle center-block" style="margin-bottom: 1rem;" src={{ $character->getPortraitUrl(128) }}>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th> Name: </th>
                                            <td> {{ $character->name }} </td>
                                        </tr>
                                        <tr>
                                            <td> <b> Corporation: </b> </td>
                                            <td> <img src={{ $character->getCorpLogoUrl(32)}} img-circle style="width:16px;">
                                                 {{ $character->corp->name }} [{{ $character->corp->ticker }}]
                                             </td>
                                        </tr>
                                        @if(isset($character->alliance))
                                        <tr>
                                            <th> Alliance: </th>
                                            <td> <img src={{$character->getAllianceLogoUrl(32)}} img-circle style="width:16px;">
                                                 {{$character->alliance->name}} [{{$character->alliance->ticker}}]
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class = "panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Related Characters </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if($character->related)
                                @foreach ($character->related as $alt)
                                    <div class="col-xs-4 text-center">
                                        <div class="row">
                                            <img class="img-thumbnail" src={{$alt->getPortraitUrl(64)}}>
                                        </div>
                                        <div class="row">
                                            <a href={{ route("edit", ["id" => $alt->character_id]) }}> {{ $alt->name }} </a>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                    None
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

@endsection