<?php

namespace {@ controller_namespace @};

use App\Http\Controllers\Controller;
use {@ request_namespace @}\{@ request_name @} as Request;
use {@ model_namespace @}\{@ model_name @} as CModel;

class {@ controller_name @} extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = CModel::collect();
        $modelName = trans(CModel::transQuery('name'));
        $saveUrl = route(CModel::routePath('store'));
        $newUrl = route(CModel::routePath('create'));
        $showUrl = CModel::routePath('show');
        $destroyUrl = CModel::routePath('destroy');
        $editUrl = CModel::routePath('edit');
        $disableUrl = CModel::routePath('disable');
        $enableUrl = CModel::routePath('enable');
        $permissionCreateName = CModel::PermissionName('create');
        $permissionDeleteName = CModel::PermissionName('delete');

        return view(CModel::viewPath('index'), compact(
                'models',
                'modelName',
                'saveUrl',
                'newUrl',
                'destroyUrl',
                'editUrl',
                'disableUrl',
                'enableUrl',
                'showUrl',
                'permissionCreateName',
                'permissionDeleteName'
        ));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param \App\Models\{@ model_name @} $model
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(CModel $model)
    {
        $modelName = CModel::trans('name');
        $editUrl = route(CModel::routePath('edit'), $model->id);
        $indexUrl = route(CModel::routePath('index'));
        $formPath = CModel::viewPath('form');

        return view(CModel::viewPath('show'), compact(
                'model',
                'modelName',
                'formPath',
                'indexUrl',
                'editUrl'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $modelName = CModel::trans('name');
        $formPath = CModel::viewPath('form');
        $saveUrl = route(CModel::routePath('index'));

        return view(CModel::viewPath('create'), compact(
                'saveUrl',
                'modelName',
                'formPath'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\{@ request_name @} $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        CModel::create($request->all());

        $message = trans('messages.success.success');
        flash($message)->success();

        return redirect()->route(CModel::routePath('index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\{@ model_name @} $model
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CModel $model)
    {
        $modelName = trans('{@ lang_name @}.name');
        $saveUrl = route(CModel::routePath('update'), $model->id);
        $indexUrl = route(CModel::routePath('index'));
        $formPath = CModel::viewPath('form');
        $permissionUpdateName = CModel::PermissionName('update');

        return view(CModel::viewPath('edit'), compact(
                'model',
                'saveUrl',
                'indexUrl',
                'formPath',
                'modelName',
                'permissionUpdateName'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\{@ model_name @}       $model
     * @param \App\Http\Requests\{@ request_name @} $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CModel $model, Request $request)
    {
        $model->update($request->all());

        $message = trans('messages.success.success');
        flash($message)->success();

        return redirect()->route(CModel::routePath('index'));
    }

    /**
     * Enable the specified resource.
     *
     * @param \App\Models\{@ model_name @} $model
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(CModel $model)
    {
        $model->enabled = 1;
        $model->save();

        $message = trans('messages.success.success');
        flash($message)->success();

        return redirect()->route(CModel::routePath('index'));
    }

    /**
     * Disable the specified resource.
     *
     * @param \App\Models\{@ model_name @} $model
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(CModel $model)
    {
        $model->enabled = 0;
        $model->save();

        $message = trans('messages.success.disabled_done');
        flash($message)->success();

        return redirect()->route(CModel::routePath('index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\{@ model_name @} $model
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(CModel $model)
    {
        $model->delete();

        $message = trans('messages.success.success');
        flash($message)->success();


        return redirect()->route(CModel::routePath('index'));
    }

}
