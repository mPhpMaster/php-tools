@extends('layouts.admin')

@section('title', trans('general.title.new', ['type' => $modelName]))

@section('content')
    <!-- Default box -->
    <div class="box box-success">
        {!! Form::open(['url' => $saveUrl, 'role' => 'form', 'class' => 'form-loading-button']) !!}

        <div class="box-body">
            @include($formPath)
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            {{ Form::saveButtons($saveUrl) }}
        </div>
        <!-- /.box-footer -->

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#enabled_1').trigger('click');

            $('#name_ar').focus();
        });
    </script>
@endpush
