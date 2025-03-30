{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Prestataires" icon="la la-question" :link="backpack_url('prestataire')" />
<x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('categorie')" />
<x-backpack::menu-item title="Villes" icon="la la-question" :link="backpack_url('ville')" />
<x-backpack::menu-item title="Services" icon="la la-question" :link="backpack_url('service')" />
<x-backpack::menu-item title="Rapports" icon="la la-question" :link="backpack_url('rapport')" />