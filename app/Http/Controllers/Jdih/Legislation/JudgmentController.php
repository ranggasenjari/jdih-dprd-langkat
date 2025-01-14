<?php

namespace App\Http\Controllers\Jdih\Legislation;

use App\Http\Controllers\Jdih\Legislation\LegislationController;
use App\Http\Traits\VisitorTrait;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Legislation;
use App\Models\Post;
use App\Models\Link;
use Illuminate\Support\Facades\Config;

class JudgmentController extends LegislationController
{
    use VisitorTrait;

    private $categories;

    public function __construct(Request $request)
    {
        // Record visitor
        $this->recordVisitor($request);

        $this->categories = Category::ofType(4)
            ->sorted()
            ->pluck('name', 'id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $legislations = Legislation::ofType(4)
            ->with(['category', 'category.type'])
            ->filter($request)
            ->published()
            ->sorted($request)
            ->paginate($this->limit)
            ->withQueryString();

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
        ];

        return view('jdih.legislation.judgment.index', compact(
            'legislations',
            'vendors',
        ))->with('categories', $this->categories)
            ->with('latestMonographs', $this->latestMonographs())
            ->with('banners', $this->banners())
            ->with('orderOptions', $this->orderOptions);
    }

    public function category(Category $category, Request $request)
    {
        $legislations = Legislation::ofType(4)
            ->where('category_id', $category->id)
            ->published()
            ->sorted($request)
            ->latestApproved()
            ->paginate($this->limit)
            ->withQueryString();

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
        ];

        return view('jdih.legislation.judgment.index', compact(
            'legislations',
            'category',
            'vendors',
        ))->with('categories', $this->categories)
            ->with('latestMonographs', $this->latestMonographs())
            ->with('banners', $this->banners())
            ->with('orderOptions', $this->orderOptions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Legislation $legislation)
    {
        $legislation->incrementViewCount();

        $adobeKey = Config::get('services.adobe.key');

        $otherLegislations = Legislation::ofType(4)
            ->where('category_id', $legislation->category_id)
            ->whereNot('id', $legislation->id)
            ->published()
            ->sorted()
            ->take(6)
            ->get();

        $latestNews = Post::ofType('news')->with('taxonomy', 'author', 'cover')
            ->published()
            ->latestPublished()
            ->take(5)
            ->get();

        $asideBanners = Link::banners()
            ->whereDisplay('aside')
            ->published()
            ->sorted()
            ->get();

        $vendors = [
            'assets/jdih/js/vendor/forms/selects/select2.min.js',
            'assets/jdih/js/vendor/share/share.js',
        ];

        return view('jdih.legislation.judgment.show', compact(
            'legislation',
            'adobeKey',
            'otherLegislations',
            'latestNews',
            'asideBanners',
            'vendors',
        ))->with('adobeKey', $this->adobeKey())
            ->with('banners', $this->banners())
            ->with('shares', $this->shares());
    }
}
