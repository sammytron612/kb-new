<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use App\Models\Setting;
use App\Models\ArticleBody;
use MeiliSearch\Client;

class ArticleSearch extends Component
{
    use WithPagination;

    public $search="";
    public $page = 1;
    public $perPage = 10;
    public $fullTextEnabled;


    public function updatingSearch()
    {
        $this->resetPage();
        $this->page = 1; // Reset page when search changes
    }

    public function render()
    {
        if (strlen($this->search) > 2) {
            if(config('scout.enabled')) {
                // Use Meilisearch client directly
                $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
                $index = $client->index('articles'); // Your index name
                
                $results = $index->search($this->search, [
                    'attributesToHighlight' => ['title', 'body'],
                    'filter' => 'published = true AND approved = true',
                    'limit' => $this->perPage,
                    'offset' => ($this->page - 1) * $this->perPage
                ]);
                
                // Convert SearchResult object to array and then to collection
                $resultsArray = $results->toArray();
                $articles = collect($resultsArray['hits']);
                $totalHits = $resultsArray['estimatedTotalHits'] ?? 0;
                
                // Create pagination data
                $paginationData = [
                    'total' => $totalHits,
                    'per_page' => $this->perPage,
                    'current_page' => $this->page,
                    'last_page' => ceil($totalHits / $this->perPage),
                ];
            } else {
                $articles = Article::fullTextSearch($this->search)->paginate(10);
                $paginationData = null;
            }
        } else {
            $articles = [];
            $paginationData = null;
        }

        return view('livewire.article-search', [
            'articles' => $articles,
            'paginationData' => $paginationData
        ]);
    }

    // Pagination methods for Meilisearch
    public function nextPage()
    {
        if ($this->canGoToNextPage()) {
            $this->page++;
        }
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page--;
        }
    }

    public function goToPage($page)
    {
        $this->page = $page;
    }

    private function canGoToNextPage()
    {
        if (strlen($this->search) > 2 && config('scout.enabled')) {
            $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
            $index = $client->index('articles');
            
            $results = $index->search($this->search, [
                'filter' => 'published = true AND approved = true',
                'limit' => 1,
                'offset' => 0
            ]);
            
            $resultsArray = $results->toArray();
            $totalHits = $resultsArray['estimatedTotalHits'] ?? 0;
            $lastPage = ceil($totalHits / $this->perPage);
            
            return $this->page < $lastPage;
        }
        
        return false;
    }
}
