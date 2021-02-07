@extends('layouts.admin')

@section('title', $modelName)

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        {!! Form::model($model, [
            'method' => 'get',
            'url' => $editUrl,
            'role' => 'form',
            'class' => 'form-loading-button'
        ]) !!}
    
        <div class="box-body">
            @include($formPath)
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <span class="">
                <a href="{{ url($editUrl) }}" class="btn btn-success btn-sm">{{ trans('general.edit') }}</a>
                <a href="{{ url($indexUrl) }}" class="btn btn-danger btn-sm">{{ trans('general.cancel') }}</a>
            </span>
        </div>
    {!! Form::close() !!}
        <!-- /.box-footer -->
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        
        });
    </script>
@endpush
