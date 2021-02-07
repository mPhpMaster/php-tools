<?php

namespace {@ transformer_namespace @};

use {@ model_namespace @}\{@ model_name @} as Model;
use League\Fractal\TransformerAbstract;

class {@ transformer_name @} extends TransformerAbstract
{
    /**
     * @param Model $model
     * @return array
     */
    public function transform(Model $model)
    {
        return [
            'id' => $model->id,
            'company_id' => $model->company_id,
            'name' => $model->name,
            'name_ar' => $model->name_ar,
            'name_en' => $model->name_en,
            'enabled' => $model->enabled,
            'created_at' => parseDate($model->created_at),
            'updated_at' => parseDate($model->updated_at),
        ];
    }
}
