<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Overview Statistics
        $totalUsers = User::count();
        $newOrders = Order::whereBetween('created_at', [now()->subDays(1), now()])
            ->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $topSellingProduct = Product::withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->first();
        $topSellingProductName = $topSellingProduct ? $topSellingProduct->name : 'N/A';

        // Recent Activities
        $recentOrder = Order::with('user', 'items')->latest()->first();
        $recentReview = Review::with('user', 'product')->latest()->first();
        $recentUser = User::latest()->first();

        // Notifications
        $ordersToProcess = Order::where('status', 'success')->count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        $reviewsToReview = Review::where('rating', '<', 4)->count();

        // User Feedback
        $latestFeedback = Review::with('user', 'product')->latest()->limit(5)->get();
        $productRatingsSummary = Product::leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select('products.name', DB::raw('AVG(reviews.rating) as avg_rating'))
            ->groupBy('products.name')
            ->get();

        // System Status
        $serverStatus = 'All systems operational';
        $errorLogs = 'No critical errors found';

        // Sales Chart Data
        $salesChartData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'date');

        $salesChartLabels = $salesChartData->keys()->toArray();
        $salesChartData = $salesChartData->values()->toArray();

        // Visitor Chart Data
        $visitorChartData = [];
        $visitorChartLabels = [];

        // Product Category Data
        $productCategories = Product::select('category_id', DB::raw('COUNT(*) as count'))
            ->groupBy('category_id')
            ->get();

        $productCategoryLabels = $productCategories->map(function ($category) {
            return $category->category->name;
        })->toArray();

        $productCategoryData = $productCategories->pluck('count')->toArray();

        return view('admin.dashboard', compact(
            'totalUsers',
            'newOrders',
            'totalRevenue',
            'topSellingProductName',
            'topSellingProduct',
            'recentOrder',
            'recentReview',
            'recentUser',
            'ordersToProcess',
            'lowStockProducts',
            'reviewsToReview',
            'latestFeedback',
            'productRatingsSummary',
            'serverStatus',
            'errorLogs',
            'salesChartLabels',
            'salesChartData',
            'visitorChartLabels',
            'visitorChartData',
            'productCategoryLabels',
            'productCategoryData'
        ));
    }
}
