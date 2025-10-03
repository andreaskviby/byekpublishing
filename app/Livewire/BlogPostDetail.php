<?php

namespace App\Livewire;

use App\Models\BlogPost;
use App\Services\SeoService;
use Livewire\Component;

class BlogPostDetail extends Component
{
    public BlogPost $blogPost;

    public function mount(BlogPost $blogPost)
    {
        if (!$blogPost->is_published) {
            abort(404);
        }
        
        $this->blogPost = $blogPost;
    }

    public function render()
    {
        $seoData = SeoService::generateMetaTags($this->blogPost);
        $structuredData = SeoService::generateStructuredData($this->blogPost);

        return view('livewire.blog-post-detail', [
            'seoData' => $seoData,
            'structuredData' => $structuredData,
        ])->layout('layouts.app')
          ->title($seoData['title']);
    }
}
