<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/12/2019
 * Time: 4:47 PM
 */

namespace Modules\Tools\Traits;

trait PaginationDenial
{
    use HasPaginationDenial;

    /**
     * Check weather if current response should be paginated or not.
     *
     * @param null|string $actionName
     *
     * @return bool
     */
    public function canPaginate($actionName = null): bool
    {
        $controller = currentController();
        $actionName = $actionName ?: currentRoute()->getActionMethod();

        if ($actionName && $controller && method_exists($controller, $actionName))
            /** @var PaginationDenial $controller */
            return toCollect($controller->getDeniedPaginationList())->search(trim($actionName)) === false;
        else
            return true;
    }

    /**
     * #_Controller Methods ONLY_
     *
     * Call it inside **_Controller Method (Action) Only_**.
     * set api response to no paginate
     *
     * @return $this
     */
    public function preventActionPagination()
    {
        $debug_bt = @debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        @reset($debug_bt);
        $methodName = @next($debug_bt);
        $methodName = is_array($methodName) && isset($methodName['function']) ? $methodName['function'] : $methodName;
        if ($methodName) {
            $this->deniedPagination = toCollect($this->deniedPagination)->push($methodName)->unique()->toArray();
        }

        return $this;
    }

}
