<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiTrait{

     /**
     * Query scope included
     * 
     * url: localhost/api/v1/categories?included=posts,posts.user
     */

    public function scopeIncluded(Builder $query){
        if(empty($this->allowIncluded) || empty(request('included'))){
            return ;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach($relations as $key => $relationship){
            if(!$allowIncluded->contains($relationship)){
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

    /**
     * Query scope filter
     * 
     * url: localhost/api/v1/categories?filter=name:algo
     */

    public function scopeFilter(Builder $query){
        if(empty($this->allowFilter) || empty(request('filter'))){
            return ;
        }

        $filters = explode(',', request('filter'));
        foreach($filters as $filter){
            [$criteria, $value] = explode(':', $filter);
            $query->where($criteria,'LIKE',  '%' .$value. '%');
        }

        return $query;
    }

    /**
     * Query scope sort
     * 
     * url: localhost/api/categories?sort=-name
     * 
     */

     public function scopeSort(Builder $query){
        if(empty($this->allowSort) || empty(request('sort'))){
            return;
        }

        $sorts = explode(',', request('sort'));

        foreach($sorts as $sortColumn){
            $sortDirection = str_starts_with($sortColumn, '-') ? 'desc' : 'asc';
            $sortColumn = ltrim($sortColumn, '-');

            $query->orderBy($sortColumn, $sortDirection);
        }

        return $query;
     }
}