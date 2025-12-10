<?php

namespace App\Livewire\Admin\Crm;

use Livewire\Component;

class AudienceIndex extends Component
{
    use \Livewire\WithPagination;

    public $search = '';

    public function render()
    {
        // 1. Unified Query to get distinct emails with basic info for Pagination
        // We prioritize User > Lead > Contact for the "primary" name/source
        $usersQuery = \App\Models\User::selectRaw("email, name, 'user' as type, created_at")
            ->whereNotNull('email');
        
        $leadsQuery = \App\Models\Lead::selectRaw("email, name, 'lead' as type, created_at")
            ->whereNotNull('email');
            
        $contactsQuery = \App\Models\Contact::selectRaw("email, name, 'contato' as type, created_at")
            ->whereNotNull('email');

        // Apply Search
        if ($this->search) {
            $term = "%{$this->search}%";
            $usersQuery->where(function($q) use ($term) {
                $q->where('email', 'like', $term)->orWhere('name', 'like', $term);
            });
            $leadsQuery->where(function($q) use ($term) {
                $q->where('email', 'like', $term)->orWhere('name', 'like', $term);
            });
            $contactsQuery->where(function($q) use ($term) {
                $q->where('email', 'like', $term)->orWhere('name', 'like', $term);
            });
        }

        // Union ALL
        $union = $usersQuery
            ->union($leadsQuery)
            ->union($contactsQuery);

        // We wrap in a subquery or collection to group by email? 
        // SQL Group By on UNION is tricky in simple Eloquent.
        // Let's settle for a simplified approach: Get distinct emails via DB facade
        
        $results = \Illuminate\Support\Facades\DB::table(\Illuminate\Support\Facades\DB::raw("({$union->toSql()}) as combined"))
            ->mergeBindings($usersQuery->getQuery())
            ->mergeBindings($leadsQuery->getQuery()) // Note: Union bindings handling is manual in raw
            ->mergeBindings($contactsQuery->getQuery()) 
            ->select('email')
            ->groupBy('email')
            ->selectRaw('MAX(name) as name, MAX(created_at) as latest_activity, GROUP_CONCAT(DISTINCT type) as roles')
            ->orderBy('latest_activity', 'desc')
            ->paginate(15);

        // 2. Hydrate "Full Profiles" for the current page
        $enrichedAudience = collect($results->items())->map(function($item) {
            return $this->buildUnifiedProfile($item->email, $item);
        });

        return view('livewire.admin.crm.audience-index', [
            'audience' => $enrichedAudience,
            'paginator' => $results
        ])
        ->layout('layouts.admin')
        ->title('Audiência Unificada');
    }

    protected function buildUnifiedProfile($email, $baseData)
    {
        $user = \App\Models\User::where('email', $email)->first();
        $lead = \App\Models\Lead::where('email', $email)->first();
        $contacts = \App\Models\Contact::where('email', $email)->orderBy('created_at', 'desc')->get();

        $isCustomer = $user && $user->orders()->exists();

        return [
            'email' => $email,
            'name' => $user->name ?? $lead->name ?? $contacts->first()->name ?? 'Sem Nome',
            'avatar' => $user ? $user->profile_photo_url : null, 
            'is_customer' => $isCustomer,
            'is_user' => $user && !$isCustomer, // New flag for specific Badge
            'is_lead' => !!$lead,
            'contact_count' => $contacts->count(),
            'user' => $user,
            'lead' => $lead,
            'contacts' => $contacts,
            'joined_at' => $baseData->latest_activity,
            'roles' => explode(',', $baseData->roles ?? ''),
        ];

    }
}
