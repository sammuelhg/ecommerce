<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Newsletter;

use App\Models\CampaignOpen;
use App\Models\NewsletterSubscriber;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Lazy]
class NewsletterDashboard extends Component
{
    public int $totalSubscribers = 0;
    public int $newSubscribersToday = 0;
    public int $totalOpens = 0;
    public float $openRate = 0.0;
    
    public $recentCampaigns = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalSubscribers = NewsletterSubscriber::count();
        $this->newSubscribersToday = NewsletterSubscriber::whereDate('created_at', Carbon::today())->count();
        $this->totalOpens = CampaignOpen::count();

        // Calculate Open Rate based on Total Sent Emails recorded in Pivot (Best Approximation)
        // Count all 'newsletter_campaign_subscriber' records where 'last_email_sent_at' is not null
        $totalEmailsSent = DB::table('newsletter_campaign_subscriber')->whereNotNull('last_email_sent_at')->count();
        
        $this->openRate = $totalEmailsSent > 0 ? ($this->totalOpens / $totalEmailsSent) * 100 : 0;
        
        // Prepare simple chart data (Last 7 days opens)
        $this->chartData = CampaignOpen::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Recent Campaigns with granular stats
        $this->recentCampaigns = \App\Models\NewsletterCampaign::withCount('subscribers')
            ->with(['emails' => function($q) {
                $q->withCount('opens')->orderBy('sort_order');
            }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.newsletter.newsletter-dashboard');
    }
}
