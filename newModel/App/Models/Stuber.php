<?php

namespace {@ model_namespace @};

use {@ controller_namespace @}\{@ controller_name @};
use {@ filter_namespace @}\{@ filter_name @};
use {@ listener_namespace @}\{@ listener_name @};
use App\Models\Model;
use App\Traits\HasModelAutoRegister;
use App\Traits\HasName;

class {@ model_name @} extends Model
{
    use HasName;
    use HasModelAutoRegister;

    public static function bootRouteWeb($prefix, $class) {
        \Route::group(['middleware' => [
                'web',
                'language',
                'auth',
                'adminmenu',
                'permission:read-admin-panel']
        ], function () use ($prefix, $class) {
            self::getRouteGetWithVar("enable", "enable");

            self::getRouteGetWithVar("disable", "disable");

            self::getRouteResource($prefix, $class);
        });
    }

    public static function bootListeners($registerer) {
        $registerer(\App\Events\AdminMenuCreated::class, {@ listener_name @}::class);
    }

    public static function getController() {
        return {@ controller_name @}::class;
    }

    protected $table = '{@ table_name @}';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'name_ar', 'name_en', 'enabled'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public $sortable = ['name_ar', 'name_en', 'enabled'];


    /**
     * Returns the ModelFilter for the current model.
     *
     * @return string
     */
    public function getModelFilterClass() {
        return $this->provideFilter({@ filter_name @}::class);
    }

}
