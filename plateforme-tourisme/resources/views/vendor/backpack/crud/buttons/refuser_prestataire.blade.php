@if($entry->statut !== 'non_valide')
<a href="{{ url(config('backpack.base.route_prefix') . '/prestataire/' . $entry->id . '/refuser') }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Refuser ce prestataire">
    <i class="la la-times"></i> Refuser
</a>
@endif