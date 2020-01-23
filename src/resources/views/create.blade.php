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
                                <input type="text" id="charname" name="charname" class="form-control" value="" />
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="maincharname"> Main Character Name (optional) </label>
                            @if(isset($character))
                                <input type="text" id="maincharname" name="maincharname" class="form-control" value="{{ $character->maincharname }}" />
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
                                <option value=0> 0 </option>
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
            <div class="col-md-2">
                <img class="image-responsive img-circle" src={{ $character->getPortraitUrl(256) }}>
            </div>
        @endif

    </div>

@endsection