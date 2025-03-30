@if($entry->statut !== 'valide')
<a href="{{ url(config('backpack.base.route_prefix') . '/prestataire/' . $entry->id . '/valider') }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Valider ce prestataire">
    <i class="la la-check"></i> Valider
</a>
@endif