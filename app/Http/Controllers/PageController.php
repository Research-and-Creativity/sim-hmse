<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PageController extends Controller
{
    public function home()
    {
        // Nanti diganti dengan query dari database
        $news    = collect();
        $gallery = collect([
            (object)[
                'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600&auto=format&fit=crop&q=60',
                'title' => 'HMSE Tech Talk Series',
            ],
            (object)[
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&auto=format&fit=crop&q=60',
                'title' => 'Rapat Kerja Pengurus HMSE',
            ],
            (object)[
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&auto=format&fit=crop&q=60',
                'title' => 'Sharing Session Mahasiswa',
            ],
            (object)[
                'image' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=600&auto=format&fit=crop&q=60',
                'title' => 'Seminar Literasi Digital',
            ],
            (object)[
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=60',
                'title' => 'Workshop UI/UX Design',
            ],
            (object)[
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=60',
                'title' => 'HMSE Mengabdi Masyarakat',
            ],
            (object)[
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=60',
                'title' => 'Pemberantasan Gagap Teknologi',
            ],
            (object)[
                'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=600&auto=format&fit=crop&q=60',
                'title' => 'Fun Gathering & bonding HMSE',
            ],
        ]);

        return view('pages.home', compact('news', 'gallery'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function newsIndex(Request $request)
    {
        $search = $request->get('search');

        // ── Placeholder kosong (kompatibel dengan template paginator) ──
        // Nanti ganti bagian ini dengan query Eloquent:
        //
        // $news = \App\Models\News::query()
        //     ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%")
        //                                  ->orWhere('content', 'like', "%{$search}%"))
        //     ->latest()
        //     ->paginate(9);

        $news = new LengthAwarePaginator(
            items:       new Collection(),
            total:       0,
            perPage:     9,
            currentPage: 1,
            options:     ['path' => $request->url(), 'query' => $request->query()],
        );

        return view('pages.news.index', compact('news'));
    }

    public function newsShow(string $slug)
    {
        // Nanti ganti dengan query Eloquent:
        // $item = \App\Models\News::where('slug', $slug)->firstOrFail();

        return view('pages.news.show', ['slug' => $slug]);
    }
}
