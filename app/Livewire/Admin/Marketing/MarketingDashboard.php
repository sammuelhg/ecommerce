<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Marketing;

use App\Domains\Marketing\Models\CampaignOpen;
use App\Domains\Marketing\Models\Lead;
use App\Domains\Marketing\Models\NewsletterCampaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Lazy]
class MarketingDashboard extends Component
{
    public int $totalLeads = 0;
    public int $newLeadsToday = 0;
    public int $totalOpens = 0;
    public float $openRate = 0.0;
    public array $chartData = [];
    public $recentCampaigns = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Metric 1: Total Leads
        $this->totalLeads = Lead::count();
        
        // Metric 2: New Leads Today
        $this->newLeadsToday = Lead::whereDate('created_at', Carbon::today())->count();
        
        // Metric 3: Total Email Opens
        $this->totalOpens = CampaignOpen::count();

        // Metric 4: Open Rate (Estimated)
        // Count all 'newsletter_campaign_subscriber' records where 'last_email_sent_at' is not null
        // Note: This table name 'newsletter_campaign_subscriber' is from legacy pivot, 
        // update this if/when migrating to a new tracking table.
        $totalEmailsSent = DB::table('newsletter_campaign_subscriber')
            ->whereNotNull('last_email_sent_at')
            ->count();
        
        $this->openRate = $totalEmailsSent > 0 ? ($this->totalOpens / $totalEmailsSent) * 100 : 0;
        
        // Chart: Last 7 days opens
        $this->chartData = CampaignOpen::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Recent Campaigns
        // Using Legacy NewsletterCampaign model as transition until full migration
        $this->recentCampaigns = NewsletterCampaign::withCount('subscribers')
            ->with(['emails' => function($q) {
                $q->withCount('opens')->orderBy('step_order');
            }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.marketing.dashboard');
    }
}
