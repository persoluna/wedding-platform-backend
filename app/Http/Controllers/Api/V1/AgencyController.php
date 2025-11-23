<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgencyResource;
use App\Models\Agency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Agency::query()
            ->with(['media'])
            ->withCount('reviews');

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        $perPage = min(max((int) $request->input('per_page', 15), 1), 50);

        return AgencyResource::collection(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function show(Request $request, Agency $agency): AgencyResource
    {
        $agency->loadMissing(['media', 'tags']);

        if ($request->boolean('track_views', true)) {
            $agency->incrementViewsCount();
        }

        return new AgencyResource($agency);
    }

    protected function applyFilters(Builder $query, Request $request): void
    {
        if ($search = trim((string) $request->query('search'))) {
            $query->where(function (Builder $builder) use ($search): void {
                $builder
                    ->where('business_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%");
            });
        }

        foreach (['city', 'country', 'state'] as $field) {
            if ($value = trim((string) $request->query($field))) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        foreach (['verified', 'featured', 'premium'] as $flag) {
            if (! is_null($request->query($flag))) {
                $query->where($flag, filter_var($request->query($flag), FILTER_VALIDATE_BOOLEAN));
            }
        }
    }

    protected function applySorting(Builder $query, Request $request): void
    {
        $sort = $request->query('sort', '-created_at');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        $allowed = ['created_at', 'avg_rating', 'review_count', 'views_count'];

        if (! in_array($column, $allowed, true)) {
            $column = 'created_at';
            $direction = 'desc';
        }

        $query->orderBy($column, $direction);
    }
}
