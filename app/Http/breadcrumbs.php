<?php

// Dashboard
Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('dashboard'));
});

// Ballots
Breadcrumbs::register('ballots', function($breadcrumbs) {
    $breadcrumbs->push('Ballots', route('ballots.index'));
});

// Ballots > Ballot
Breadcrumbs::register('ballot', function($breadcrumbs, $ballot) {
    $breadcrumbs->parent('ballots');
    $breadcrumbs->push($ballot->title, route('ballots.show', $ballot->id));
});

// Ballots > Create
Breadcrumbs::register('ballot_create', function($breadcrumbs) {
    $breadcrumbs->parent('ballots');
    $breadcrumbs->push('Create', route('ballots.create'));
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});