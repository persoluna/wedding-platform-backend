<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::query()
            ->with(['media', 'category'])
            ->withCount('reviews');

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        $perPage = min(max((int) $request->input('per_page', 15), 1), 50);

        return VendorResource::collection(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function show(Request $request, Vendor $vendor): VendorResource
    {
        $vendor->loadMissing(['media', 'category', 'tags', 'services']);

        if ($request->boolean('track_views', true)) {
            $vendor->incrementViewsCount();
        }

        return new VendorResource($vendor);
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

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('min_price')) {
            $query->where('min_price', '>=', $request->float('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('max_price', '<=', $request->float('max_price'));
        }

        if ($request->filled('available_on')) {
            $query->whereHas('availabilities', function (Builder $builder) use ($request): void {
                $builder->whereDate('date', $request->date('available_on'))
                    ->whereIn('status', ['available', 'partially_booked']);
            });
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

        $allowed = ['created_at', 'avg_rating', 'review_count', 'views_count', 'min_price', 'max_price'];

        if (! in_array($column, $allowed, true)) {
            $column = 'created_at';
            $direction = 'desc';
        }

        $query->orderBy($column, $direction);
    }
}
