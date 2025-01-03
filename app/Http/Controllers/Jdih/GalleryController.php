<?php

namespace App\Http\Controllers\Jdih;

use App\Http\Controllers\Jdih\JdihController;
use App\Http\Traits\VisitorTrait;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Link;

class GalleryController extends JdihController
{
    use VisitorTrait;

    public function __construct(Request $request)
    {
        // Record visitor
        $this->recordVisitor($request);
    }

    public function photo()
    {
        $photos = Media::images()
            ->published()
            ->sorted()
            ->paginate(12)
            ->withQueryString();

        $vendors = [
            'assets/admin/js/vendor/media/glightbox.min.js',
        ];

        return view('jdih.gallery.photo', compact(
            'photos',
            'vendors',
        ));
    }

    public function video()
    {
        $videos = Link::youtubes()
            ->published()
            ->sorted()
            ->paginate(12)
            ->withQueryString();

        return view('jdih.gallery.video')->with('videos', $videos);
    }
}
