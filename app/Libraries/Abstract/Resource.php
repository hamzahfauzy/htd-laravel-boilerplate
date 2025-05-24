<?php

namespace App\Libraries\Abstract;

use App\Http\Middleware\AllowedRoute;
use App\Libraries\Components\Action;
use App\Libraries\Components\Button;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

abstract class Resource
{

    protected static ?string $breadcrumb = null;
    protected static ?string $navigationIcon = null;
    protected static ?string $navigationGroup = null;
    protected static ?string $navigationLabel = null;
    protected static ?int $navigationOrder = 1;
    protected static ?string $slug = null;
    protected static ?string $routeGroup = null;
    protected static $model = null;
    protected static $record = null;
    protected static $records = null;
    protected static $deleteRoute = true;
    public static $dataTableClass = 'datatable';

    private static $additionalStyles = [];
    private static $additionalScripts = [];

    public static function mount() {}

    public static function getNavShortcut()
    {
        return [];
    }

    public static function getNavigationLabel()
    {
        return static::$navigationLabel;
    }

    public static function getNavigationOrder()
    {
        return static::$navigationOrder;
    }

    public static function getNavigationIcon()
    {
        return static::$navigationIcon;
    }

    public static function getNavigationGroup()
    {
        return static::$navigationGroup;
    }

    public static function getBreadcrumb()
    {
        return static::$breadcrumb;
    }

    public static function getPages()
    {
        $resource = static::class;
        return [
            'index' => new Pages\ListPage($resource),
            'create' => new Pages\CreatePage($resource),
            'edit' => new Pages\EditPage($resource),
            'detail' => new Pages\DetailPage($resource),
        ];
    }

    public static function setRecord($data)
    {
        static::$record = $data;
    }

    public static function getModel()
    {
        return new static::$model;
    }

    public static function getRoute()
    {
        return static::$routeGroup . '.' . static::$slug . '.index';
    }

    public static function getRecord()
    {
        return static::$record;
    }

    public static function registerRoutes()
    {
        Route::name(static::$routeGroup . '.')->middleware(['web', 'auth', AllowedRoute::class])->group(fn() => static::routes());
    }

    public static function routes()
    {
        Route::name(static::$slug . '.')
            ->prefix(static::$slug)
            ->group(function () {
                foreach (static::getPages() as $name => $page) {
                    if (in_array($page->getRoute(), ['/', 'create'])) {

                        if ($page->getRoute() == 'create') {
                            Route::match(['GET', 'POST'], $page->getRoute(), function (Request $request) use ($page) {
                                if ($request->isMethod('POST')) {
                                    return static::store($request);
                                }

                                return $page->render();
                            })->name($name);
                        } else {
                            Route::get($page->getRoute(), function () use ($page) {
                                return $page->render();
                            })
                                ->name($name);
                        }
                    } else {
                        if ($page->getRoute() == '{id}/edit') {
                            Route::match(['GET', 'PUT'], $page->getRoute(), function (Request $request, $id) use ($page) {
                                if ($request->isMethod('PUT')) {
                                    return static::update($request, $id);
                                }

                                return $page->render($id);
                            })->name($name);
                        } else {
                            Route::get($page->getRoute(), function ($id) use ($page) {
                                return $page->render($id);
                            })
                                ->name($name);
                        }
                    }
                }

                if (static::$deleteRoute) {
                    Route::delete('{id}', function (Request $request, $id) {
                        return static::destroy($request, $id);
                    })
                        ->name('delete');
                }
            });
    }

    public static function getPageRoute($key, $params = [])
    {
        return route(static::getPageRouteName($key), $params);
    }

    public static function getPageRouteName($key)
    {
        return static::$routeGroup . '.' . static::$slug . '.' . $key;
    }

    public static function table()
    {
        return [];
    }

    public static function form()
    {
        return [];
    }

    public static function detail()
    {
        return [];
    }

    public static function listHeader()
    {
        return [
            'title' => static::$navigationLabel . ' List',
            'button' => [
                (new Button([
                    'url' => static::getPageRoute('create'),
                    'class' => 'btn btn-sm btn-primary',
                    'label' => 'Create',
                    'icon' => 'fas fa-fw fa-plus'
                ]))
                    ->routeName(static::getPageRouteName('create'))
                    ->render()
            ]
        ];
    }

    public static function createHeader()
    {
        return [
            'title' => 'Create ' . static::$navigationLabel,
            'button' => [
                (new Button([
                    'url' => static::getPageRoute('index'),
                    'class' => 'btn btn-sm btn-outline-secondary',
                    'label' => 'Back',
                    'icon' => 'fas fa-fw fa-arrow-left'
                ]))
                    ->routeName(static::getPageRouteName('index'))
                    ->render()
            ]
        ];
    }

    public static function editHeader()
    {
        return [
            'title' => 'Edit ' . static::$navigationLabel,
            'button' => [
                (new Button([
                    'url' => static::getPageRoute('index'),
                    'class' => 'btn btn-sm btn-outline-secondary',
                    'label' => 'Back',
                    'icon' => 'fas fa-fw fa-arrow-left'
                ]))
                    ->routeName(static::getPageRouteName('index'))
                    ->render()
            ]
        ];
    }

    public static function detailHeader()
    {
        return [
            'title' => 'Detail ' . static::$navigationLabel,
            'button' => [
                (new Button([
                    'url' => static::getPageRoute('index'),
                    'class' => 'btn btn-sm btn-outline-secondary',
                    'label' => 'Back',
                    'icon' => 'fas fa-fw fa-arrow-left'
                ]))
                    ->routeName(static::getPageRouteName('index'))
                    ->render(),
                (new Button([
                    'url' => static::getPageRoute('edit', ['id' => static::$record?->id]),
                    'class' => 'btn btn-sm btn-warning',
                    'label' => 'Edit',
                    'icon' => 'fas fa-fw fa-pencil'
                ]))
                    ->routeName(static::getPageRouteName('edit'))
                    ->render(),
            ]
        ];
    }

    public static function store(Request $request)
    {
        if (count(static::createRules())) {
            $request->validate(static::createRules());
        }

        static::beforeCreate($request);
        $data = static::$model::create($request->all());
        static::afterCreate($request, $data);

        return redirect()->route(static::getPageRouteName('detail'), ['id' => $data->id]);
    }

    public static function update(Request $request, $id = null)
    {
        if (count(static::updateRules())) {
            $request->validate(static::updateRules());
        }

        $data = static::$model::find($id);
        static::beforeUpdate($request, $data);
        $data->update($request->all());
        static::afterUpdate($request, $data);

        return redirect()->route(static::getPageRouteName('detail'), ['id' => $id]);
    }

    public static function destroy(Request $request, $id = null)
    {
        $data = static::$model::find($id);
        static::beforeDelete($request, $data);
        $data->delete();
        static::afterDelete($request, $data);

        return redirect()->route(static::getPageRouteName('index'));
    }

    public static function addStyles($additionalStyles)
    {
        static::$additionalStyles = $additionalStyles;
    }

    public static function getStyles()
    {
        return static::$additionalStyles;
    }

    public static function addScripts($additionalScripts)
    {
        static::$additionalScripts = $additionalScripts;
    }

    public static function getScripts()
    {
        return static::$additionalScripts;
    }

    public static function beforeCreate(Request $request) {}

    public static function afterCreate(Request $request, $data) {}

    public static function beforeUpdate(Request $request, $data) {}

    public static function afterUpdate(Request $request, $data) {}

    public static function beforeDelete(Request $request, $data) {}

    public static function afterDelete(Request $request, $data) {}

    public static function createRules()
    {
        return [];
    }

    public static function updateRules()
    {
        return [];
    }

    public static function getAction($d)
    {
        return Action::render(static::class, $d);
    }
}
