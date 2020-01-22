@extends('web::layouts.grids.12')

@section('title', 'ES Intel')
@section('page_header', 'ES Intel')
@section('page_description', 'Add Character')

@section('full')

    <div class="row">

        <div class="col-md-4">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> Add Character </h3>
                </div>
                <div class="panel-body">
                    <form method="post" id="esinteladdchar">
                        {{ csrf_field () }}
                        <div class="form-group">
                            <label for="charname">Character Name</label>
                            <input type="text" id="charname" name="charname" class="form-control" value="{{ old('charname') }}" />
                        </div>
                        <div class="form-group">
                            <label for="maincharname"> Main Character Name (optional) </label>
                            <input type="text" id="maincharname" name="maincharname" class="form-control" value="{{ old('maincharname') }}" />
                        </div>
                        <div class="form-group">
                            <label for="eslevel"> ES Tier </label>
                            <select name="eslevel" id="eslevel" class="form-control">
                                @for ($i = 0; $i < 11; $i++)
                                    <option value={{ $i }}> {{ $i }} </option>
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
                            <textarea type="text" class="form-control" rows="5" name="estext" id="estext">{{ old('estext') }}</textarea>
                        </div>
                    </form>
                </div>

                <div class="panel-footer clearfix">
                    <button type="submit" class="btn btn-success pull-right" form="esinteladdchar"> Add Character </button>
                </div>
            </div>
        </div>
    </div>

@endsection