@extends('web::layouts.grids.12')
@section('title', 'ES Intel Categories')
@section('page_header', 'ES Intel Categories')

@section('full')
<div class="row">
    {{-- Create new category --}}
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading bg-green">
                <h3 class="panel-title"> New Intel Category </h3>
            </div>
            <div class="panel-body">
                <form method="post" id="intelcategory">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="category_name"> Category Name </label>
                        <input type="text" id="category_name" name="category_name" class="form-control" />
                    </div>
                </form>
            </div>
            <div class="panel-footer clearfix">
                <button type="submit" class="btn btn-success pull-right" form="intelcategory"> Create Category </button>
            </div>
        </div>
    </div>
    {{-- Table showing categories --}}
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"> Categories </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Category Name </th>
                                <th> Active </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                            <tr>
                                <td> {{ $cat->id }} </td>
                                <td> {{ $cat->category_name }} </td>
                                <td> <input data-id='{{ $cat->id }}' class="selactive" type="checkbox" {{ $cat->is_active ? "checked" : "" }}/></td>
                            </tr>
                            @empty
                            <tr>
                                <td> </td>
                                <td> No categories in database. </td>
                                <td> </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')

<script type="text/javascript">

    $( function() {

        $('.selactive').change( function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var cat_id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route("esintel.categories.status") }}",
                data: { 'status': status, 'id': cat_id},
                success: function(data) {
                    console.log(data.success)
                }
            });
        })
    })
</script>
@endpush