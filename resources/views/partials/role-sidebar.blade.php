{{-- Role-aware sidebar: includes the correct sidebar partial based on the user's role --}}
@auth
    @if(auth()->user()->hasRole('admin'))
        @include('partials.admin-sidebar')
    @elseif(auth()->user()->hasRole('agent'))
        @include('partials.agent-sidebar')
    @else
        @include('partials.customer-sidebar')
    @endif
@else
    @include('partials.customer-sidebar')
@endauth
