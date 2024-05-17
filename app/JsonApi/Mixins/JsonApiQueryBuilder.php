<?php

namespace App\JsonApi\Mixins;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonApiQueryBuilder
{
    public function allowedIncludes(): Closure
    {
        return function($allowedIncludes){
            /** @var Builder $this */
            if (request()->isNotFilled('include')) {
                return $this;
            }

            $includes = explode(',', request()->input('include'));

            foreach ($includes as $include) {
                if (! in_array($include, $allowedIncludes)) {
                    throw new BadRequestHttpException("The included relationship '{$include}' is not allowed in the '{$this->getResourceType()}' resource");
                }
                 $this->with($include);
            }
            return $this;
        };
    }

    public function allowedFilters(): Closure
    {
        return function ($allowedFilters) {
            /** @var Builder $this */

            foreach (request('filter', []) as $filter => $value) {
                if ($value === '' || is_null($value) || $value === 'null' || $value === 'NULL') {
                    throw new BadRequestHttpException("The filter '{$filter}' no se puede filtrar por null");
                }

                if (! in_array($filter, $allowedFilters)) {
                    throw new BadRequestHttpException("The filter '{$filter}' is not allowed in the '{$this->getResourceType()}' resource");
                }



                $this->hasNamedScope($filter)
                    ? $this->{$filter}($value)
                    : $this->where($filter, 'LIKE', '%'.$value.'%');
            }

            return $this;
        };
    }

        public function sparseFieldset(): Closure
        {
            return function () {
                /** @var Builder $this */
                if (request()->isNotFilled('fields')) {
                    return $this;
                }
                $fields = explode(',', request('fields.'.$this->getResourceType()));

                $routeKeyName = $this->model->getRouteKeyName();

                if (! in_array($routeKeyName, $fields)) {
                    $fields[] = $routeKeyName;
                }

                $fields = array_map(function ($field) {
                    return str($field)->replace('-', '_');
                }, $fields);

                return $this->addSelect($fields);
            };
        }

    public function jsonPaginate(): Closure
    {
        return function () {
            /** @var Builder $this */
            $paginator = $this->paginate(
                $perPage = request('page.size', 15),
                $columns = ['*'],
                $pageName = 'page[number]',
                $page = request('page.number', 1)
            )->appends(request()->only('sort', 'filter', 'page.size'));

            // Personaliza la respuesta
            $paginator->setCollection($paginator->getCollection()->map(function ($item) {
                return [
                    'total' => $paginator->total(),
                    'to' => $paginator->lastItem(),
                    'current_page' => $paginator->currentPage(),
                ];
            }));

            return $paginator;
        };
    }
    public function getResourceType(): Closure
    {
        return function () {
            /** @var Builder $this */
            if (property_exists($this->model, 'resourceType')) {
                return $this->model->resourceType;
            }

            return $this->model->getTable();
        };
    }

}
