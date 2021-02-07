
{{ Form::textGroup('name_ar', trans('general.name_ar'), 'id-card-o', (isViewMode('show') ?             ['readonly'=>'readonly'] : [])) }}
{{ Form::textGroup('name_en', trans('general.name_en'), 'id-card-o', (isViewMode('show') ?             ['readonly'=>'readonly'] : [])) }}

{{ Form::radioGroup('enabled', trans('general.enabled')) }}