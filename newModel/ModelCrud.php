<?php
namespace newModel;

use Illuminate\Contracts\Support\Arrayable;
use \Illuminate\Support\Arr;

class ModelCrud implements Arrayable {

    private $files = [];
    private $data = [];
    private $topDir = null;
    private $file;
    private $needFixTolens = [
        'lang_name',
        'view_name'
    ];

    public function __construct($file) {
        $this->file = (!file_exists($file . ".php") ? dirname(base_path(__CLASS__)) . "\\{$file}" : $file) . ".php";

        if (!file_exists($this->file)) {
            d(
                    "File not exist",$this->file
            );
        } else {
            $this->data = \File::getRequire($this->file);
        }
        $this->data = collect($this->data);
        if($this->data->count()) {
            $this->files = collect($this->read("stubs", false));
        } else {
            $this->files = collect($this->files);
        }

        $this->topDir = $this->data->get('top_dir', null);
        $this->data = $this->data->toArray();

        $namespaces = $this->get('namespaces', null);
        $namespaces = collect($namespaces)->map(function($v, $k) {
            if(!$v) {
                $_path = $this->get("paths.{$k}", null);
                return $_path ? dirname($_path) : null;
            } else return $v;
        });

        $this->data["namespaces"] = $namespaces->toArray();
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key) {
        return Arr::has($this->data, $key);
    }

    /**
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null) {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function getDots($key, $prepend = null) {
        return Arr::dot($this->get($key), $prepend);
    }

    /**
     * @return array
     */
    public function all() {
        return $this->data;
    }

    /**
     * @return array
     */
    public function read($key, $studlyClassName = true) {
        $_data = collect($this->getDots($key))->filter()->mapWithKeys(function ($v, $k) use ($studlyClassName) {
            $fName = dirname(base_path(__CLASS__)) . "\\{$v}.php";
            if(file_exists($fName)) {
                if($studlyClassName) {
                    $_key = collect(explode("\\", $v));
                    $_key = $_key->splice(-2)->implode("-");
                    $_key = studly_case($_key);
                } else $_key = $k;

                return [$_key=>file_get_contents($fName)];
            }

            return [];
        });

        return $_data;
    }

    /**
     * @return array
     */
    public function deleteAll() {
        return $this->writeAll(true, true);
    }
    public function writeAll($force = false, $delete = false) {
        $result = collect($this->getDots("stubs"))->map(function ($v,$k) use ($force,$delete) {
//            if(str_contains($k, '.')){
//                $_v = $this->write($k, $force,$delete);
//                return $_v;
//            }

            $_v = $this->write($k, $force,$delete);
            return $_v;
        });

        $result->put("autoRoute", $this->registerAutoRouteModels(!$delete));
        return $result;
    }

    public function delete($file) {
        return $this->write($file, true, true);
    }
    public function write($file, $force = false, $delete = false) {
        $result = [];
        $_file = $file ? $this->files->get($file, false) : false;

        if($_file) {
            $oldFile = $this->get("stubs.{$file}", false);
            $newFile = $this->get("paths.{$file}", false);
            $fileNoDot = current(explode(".", $file));

            if($newFileName = $this->get("tokens.".$fileNoDot."_name", $fileNoDot)) {
                if($fileNoDot == 'config'){
                    $dirName = basename(dirname(base_path($newFile)));

                    $dirName = ($dirName == 'config') ? "\\{$dirName}\\ModelCrud" : "\\ModelCrud\\{$dirName}";

                    $newFile =  dirname(dirname(base_path($newFile))) . $dirName . "\\{$newFileName}.php";
//                    d(
//                            $newFile,
//                            $dirName
//                    );
                } else if($fileNoDot == 'view'){
                    $newFile =  dirname(dirname(base_path($newFile))) . "\\{$newFileName}\\".basename($oldFile).".php";

                    if(\File::exists($newFile) && $delete){
                        \File::delete($newFile);
                        $result[] = $newFile;
                    }

                    $_topDir = $this->topDir ? $this->topDir : basename(dirname($newFile));

                    if(\File::exists(dirname($newFile)) && $delete){
                        $inTopDir = false;
                        while(\File::exists(dirname($newFile)) && $inTopDir == false) {
                            $newFile = dirname($newFile);
                            $__files = \File::files($newFile) + \File::directories($newFile);

                            if(basename($newFile) == $_topDir) {
                                $inTopDir = true;
                                if(count($__files) == 1) {
                                    if(!$__files[0]->getRealPath() || !\File::exists($__files[0]->getPathname()))
                                        $__files = [];
                                }

                                if(count($__files) == 0) {
                                    \File::deleteDirectory($newFile);
                                    $result[] = $newFile;
                                    break;
                                }
                            }

                            if(count($__files) > 0) {
                                break;
                            } else if(count($__files) == 0) {
                                \File::deleteDirectory($newFile);
                                $result[] = $newFile;
                            }
                        }

                        return count($result)==1 ? $result[0] : $result;
                    } else if(!\File::exists(dirname($newFile)) && $delete){
                        return dirname($newFile);
                    }
                } else {
                    $newFile_ =  dirname($newFile) . "\\{$newFileName}";
                    $newFile =  dirname(base_path($newFile)) . "\\{$newFileName}.php";
                }

                $_nfs = explode("\\", $newFile);
                $_cnf = array_shift($_nfs);
                array_pop($_nfs);
                foreach ($_nfs as $_nf) {
                    $_cnf .= "\\" . $_nf;
                    if(!\File::exists($_cnf) && !$delete){
                        \File::makeDirectory($_cnf);
                    }
                }
            } else {
                d(
                        "file name not found", $file
                );
            }

            if(!file_exists($newFile) && $delete) {
                return empty($result) ? false : (count($result)==1 ? $result[0] : $result);
            } else if(file_exists($newFile) && $delete) {
                \File::delete($newFile);
                $result[] = $newFile;
                return count($result)==1 ? $result[0] : $result;
            } else if(file_exists($newFile) && !$force) {
                dump("exist file!", $newFile);
                return false;
            }


            if(!$delete) {
                $newContent = $_file;
                $_this = $this;
                collect($this->get('tokens', []))->each(function ($vv,$kk) use(&$newContent, $_this) {
                    $vv = collect($this->needFixTolens)->contains($kk) ?
                            $this->dotPath( $this->get("paths.model", null) ) :
                            $vv;
                    $newContent = $_this->replace($kk, $vv, $newContent);
                });

                $fullClassPath = [];
                collect($this->get('namespaces', []))->each(function ($vv,$kk) use(&$newContent, $_this,&$fullClassPath) {
                    $newContent = $_this->replace("{$kk}_namespace", $vv, $newContent);
                    $fullClassPath[ $kk . "_class" ] = $vv . "\\" . $_this->get("tokens.{$kk}_name", null);
                });
                collect($fullClassPath)->each(function ($vv,$kk) use(&$newContent, $_this) {
                    $newContent = $_this->replace("{$kk}", $vv, $newContent);
                });

                $controllerName = $this->get("tokens.controller_name", null);
                $controllerNamelower = strtolower( $this->get("tokens.controller_name", null) );
                $modelName = $this->get("tokens.model_name", null);
                $modelNamelower = strtolower( $this->get("tokens.model_name", null) );

                collect([
                    'CONTROLLERNAME'=>$controllerName,
                    'controllername'=>$controllerNamelower,
                    'MODELNAME'=>$modelName,
                    'modelname'=>$modelNamelower,
                ])->each(function ($vv,$kk) use(&$newContent, $_this) {
                    $newContent = $_this->replace("{$kk}", $vv, $newContent);
                });

//                d(
//                        $fullClassPath
//                );
                file_put_contents($newFile, $newContent);
                return $newFile;
            }
            else
                return empty($result) ? $newFile : (count($result)==1 ? $result[0] : $result);
        }
        else return false;
    }

    public function registerAutoRouteModels($active = true) {
        if($this->get("autoRouteModel", false)) {
            $newFileName = $this->get("tokens.model_name", null);
            $autoRouteModelName = $this->get("tokens.autoRouteModel_name", null);
            $model_path = $this->get("paths.model", null);
            $newFile =  str_ireplace(
                    base_path() . "\\",
                    "",
                    dirname(base_path($model_path)) . "\\{$newFileName}"
            );

            if($active) {
                autoModel()->add($autoRouteModelName, $newFile);
                autoModel()->enable($autoRouteModelName);
            } else {
                autoModel()->forget("enable.{$autoRouteModelName}")
                        ->forget("disable.{$autoRouteModelName}");
            }
            return $newFile;
        }
    }
    /**
     * @return array
     */
    public function stub($file = null, $content = false) {
        if($content) {
            if($file) {
                $this->files->put($file, $content);
                $_file = $this->files->get($file);
            } else {
                $this->files = collect($content);
                $_file = $this->files->all();
            }
        } else {
            $_file = $file ? $this->files->get($file, null) : $this->files->all();
        }
        return $_file;
//        return file_put_contents($fName, $data);

        return false;
    }

    public function replace($key, $value, $stub) {
        $key = "{@ {$key} @}";
        return str_ireplace($key, $value, $stub);
    }

    public function dotPath($controllerPath, $delemetr = "\\") {
        $controllers = collect(explode("\\", $controllerPath))->reverse();
        $controller = [];
        $controllers->each(function($v) use(&$controller) {
            if(str_contains(strtolower($v), [
                    'controller',
                    'models',
                    'entities'
            ]))
                return false;
            else
                $controller[] = $v;
        });
        $newFileName = $this->get("tokens.model_name", "");
        $controller[0] = strtolower($newFileName);
        $controller = implode($delemetr, array_reverse($controller));

        return $controller;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray() {
        return $this->data;
    }

    public function __get($name) {
        return $this->get($name, null);
    }
}

class ModelCrudController {
    private $model;
    public function __construct($app=false) {
        if($app !== false)
            $this->model = new ModelCrud(...func_get_args());
    }
    public function make() {
        return new  $this(...func_get_args());
    }
    public function install() {
        if($this->model) {
            $this->model->writeAll();
        }
        return $this;
    }
    public function uninstall() {
        if($this->model) {
            $this->model->deleteAll();
        }
        return $this;
    }
    public function instanse() {
        if($this->model) {
            return $this->model;
        }
        return null;
    }
}

if(isset($__auto_load) && is_callable($__auto_load)) {
    $__auto_load('ModelCrud', function () {
        return new ModelCrud(...func_get_args());
    });
    $__auto_load('ModelCrudController', ModelCrudController::class);

    return ModelCrudController::class;
}

