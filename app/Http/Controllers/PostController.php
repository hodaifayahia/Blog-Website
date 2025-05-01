<?php

namespace App\Http\Controllers;

use App\Models\Categroy;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Latest post
        $latestPosts = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();
    
        // Popular posts (3 based on upvotes)
        $popularPosts = Post::query()
            ->leftJoin('upvote_down_votes', 'posts.id', '=', 'upvote_down_votes.post_id')
            ->select('posts.*', DB::raw('COUNT(upvote_down_votes.id) as upvote_count'))
            ->where(function ($query) {
                $query->where('upvote_down_votes.is_upvote', true)
                    ->orWhereNull('upvote_down_votes.is_upvote');
            })
            ->where('active', true)
            ->whereDate('published_at', '<=', now())
            ->groupBy('posts.id')
            ->orderByDesc('upvote_count')
            ->limit(3)
            ->get();
    
        $user = auth()->user();
        
        if ($user) {
            // Recommended posts based on user's upvoted categories
            $recommendedPosts = Post::query()
                ->select('posts.*')
                ->join('category_posts as cp', 'posts.id', '=', 'cp.post_id')
                ->join(DB::raw('(select cp.category_id, cp.post_id 
                    from upvote_down_votes
                    join category_posts cp on upvote_down_votes.post_id = cp.post_id 
                    where upvote_down_votes.is_upvote = true and upvote_down_votes.user_id = '.$user->id.') as t'), 
                    function($join) {
                        $join->on('cp.category_id', '=', 't.category_id')
                             ->where('t.post_id', '<>', DB::raw('posts.id'));
                    })
                ->where('posts.active', true)
                ->whereDate('posts.published_at', '<=', now())
                ->where('posts.id', '<>', DB::raw('t.post_id'))
                ->groupBy('posts.id')
                ->limit(5)
                ->get();
        } else {
            // Get posts based on number of views
            $recommendedPosts = Post::query()
                ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
                ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
                ->where('active', true)
                ->whereDate('published_at', '<=', now())
                ->groupBy('posts.id')
                ->orderByDesc('view_count')
                ->limit(3)
                ->get();
        }
        $categories = Categroy::query()
        ->with('posts')
        ->where('active', true)
        ->select('categroys.*')
        ->whereHas('posts', function ($query) {
            $query->where('active', true)
                ->whereDate('published_at', '<=', now());
        })
        ->selectRaw('MAX(posts.published_at) as latest_post_date')
        ->join('category_posts', 'categroys.id', '=', 'category_posts.category_id')
        ->join('posts', 'category_posts.post_id', '=', 'posts.id')
        ->orderByDesc('latest_post_date')
        ->groupBy('categroys.id')
        ->limit(5)
        ->get();
        
    
        return view('home', compact('latestPosts', 'popularPosts', 'recommendedPosts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search()
    {
        $search = request()->get('search');
        
        // Search in posts and their related categories
        $posts = Post::with('categories')
            ->where(function($query) use ($search) {
                $query->where('title', 'like', '%'. $search. '%')
                    ->orWhere('body', 'like', '%'. $search. '%')
                    ->orWhereHas('categories', function($q) use ($search) {
                        $q->where('name', 'like', '%'. $search. '%');
                    });
            })
            ->where('active', true)
            ->whereDate('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('post.search', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if (!$post->active || $post->published_at > now()) {
            abort(404);
        }
    
        $next = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', now())
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
    
        $previous = Post::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', now())
            ->where('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    
        // Cookie key: one per post
        $cookieKey = 'viewed_post_' . $post->id;
    
        // If the cookie doesn't exist, record the view
        if (!request()->hasCookie($cookieKey)) {
            $user = request()->user();
    
            // PostView::create([
            //     'post_id' => $post->id,
            //     'user_id' => $user?->id,
            //     'ip_address' => request()->ip(),
            //     'user_agent' => request()->userAgent(),
            // ]);
    
            // Set cookie for 60 minutes
            cookie()->queue(cookie($cookieKey, true, 60));
        }
    
        return response()
            ->view('post.view', [
                'post' => $post,
                'next' => $next,
                'previous' => $previous,
            ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function byCategory(Categroy $Category)
    {
        $posts = Post::query()
            ->join('category_posts', 'posts.id', '=', 'category_posts.post_id')
            ->where('category_posts.category_id', $Category->id)
            ->where('active', true)
            ->whereDate('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            return view('post.index', compact('posts', 'Category')); // Use lowercase here
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
