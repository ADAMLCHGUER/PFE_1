<!-- resources/views/vendor/backpack/base/inc/sidebar_content.blade.php -->
<!-- This file is used to store sidebar items, inside the Backpack admin panel -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-title">Prestataires</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('prestataire') }}"><i class="nav-icon la la-users"></i> Prestataires</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('service') }}"><i class="nav-icon la la-concierge-bell"></i> Services</a></li>

<li class="nav-title">Références</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('categorie') }}"><i class="nav-icon la la-list"></i> Catégories</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('ville') }}"><i class="nav-icon la la-city"></i> Villes</a></li>

<li class="nav-title">Rapports</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('rapport') }}"><i class="nav-icon la la-file-pdf"></i> Rapports</a></li>