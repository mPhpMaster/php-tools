@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => $modelName]))

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        {!! Form::model($model, [
            'method' => 'PATCH',
            'url' => $saveUrl,
            'role' => 'form',
            'class' => 'form-loading-button'
        ]) !!}

        <div class="box-body">
            @include($formPath)
        </div>
        <!-- /.box-body -->

        @permission($permissionUpdateName)
        <div class="box-footer">
            {{ Form::saveButtons($indexUrl) }}
        </div>
        <!-- /.box-footer -->
        @endpermission

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        
        });
    </script>
@endpush
