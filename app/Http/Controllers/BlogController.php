<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    /**
     * Liste des articles formatée pour le carrousel de la page d'accueil.
     */
    public static function carouselPosts(): array
    {
        return collect(config('blog', []))
            ->map(fn ($post, $slug) => [
                'title' => $post['title'],
                'tag' => $post['tag'],
                'text' => $post['excerpt'],
                'image' => $post['image'],
                'url' => route('blog.show', $slug),
            ])
            ->values()
            ->all();
    }

    /**
     * Page de détail d'un article.
     */
    public function show(string $slug)
    {
        $posts = config('blog', []);

        abort_unless(isset($posts[$slug]), 404);

        return view('blog.show', [
            'slug' => $slug,
            'post' => $posts[$slug],
        ]);
    }
}
