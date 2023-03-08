<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected $allowIncluded = ['posts', 'posts.user', 'posts.tags'];
    protected $allowFilter = ['id', 'name', 'slug'];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function scopeIncluded(Builder $query) {

        // In case of no 'included' parameter.
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        //In case of invalid 'included' parameters.
        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

    public function scopeFilter(Builder $query) {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, "LIKE", '%' . $value . '%');
            }
        }

    }
}
