<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'all');
        $city = $request->query('city');
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $rating = $request->query('rating');

        $listings = collect();

        if ($type === 'all' || $type === 'vendor') {
            $vendorsQuery = Vendor::with(['media', 'category', 'tags'])->latest();

            if ($city) {
                $vendorsQuery->where('city', 'like', "%{$city}%");
            }
            if ($search) {
                $vendorsQuery->where('business_name', 'like', "%{$search}%");
            }
            if ($categoryId) {
                $vendorsQuery->where('category_id', $categoryId);
            }
            if ($rating) {
                $vendorsQuery->where('avg_rating', '>=', $rating);
            }

            $vendors = $vendorsQuery->get()->map(function ($vendor) {
                $vendor->listing_type = 'vendor';
                return $vendor;
            });
            $listings = $listings->concat($vendors);
        }

        if ($type === 'all' || $type === 'agency') {
            $agenciesQuery = Agency::with(['media', 'tags'])->latest();

            if ($city) {
                $agenciesQuery->where('city', 'like', "%{$city}%");
            }
            if ($search) {
                $agenciesQuery->where('business_name', 'like', "%{$search}%");
            }
            if ($rating) {
                $agenciesQuery->where('avg_rating', '>=', $rating);
            }

            $agencies = $agenciesQuery->get()->map(function ($agency) {
                $agency->listing_type = 'agency';
                return $agency;
            });
            $listings = $listings->concat($agencies);
        }

        // Sort combined listings by latest or rating
        $listings = $listings->sortByDesc('created_at')->values();

        // Manual Pagination for the collection
        $page = (int) $request->query('page', 1);
        $perPage = 12;
        $paginated = new LengthAwarePaginator(
            $listings->forPage($page, $perPage),
            $listings->count(),
            $perPage,
            $page,
            ['path' => url('/explore'), 'query' => $request->query()]
        );

        $categories = Category::all();

        return view('explore', [
            'listings' => $paginated,
            'categories' => $categories,
        ]);
    }
}
