<?php

return [
    'base_uri' => env('HUBSPOT_BASE_URI', 'https://api.hubapi.com'),
    'access_token' => env('HUBSPOT_ACCESS_TOKEN'),

    'definitions' => [
        'cache' => '30 days',
    ],

    'contacts' => [
        'include_properties' => ['firstname', 'lastname', 'email'],
        'include_associations' => ['companies', 'contact', 'deals', 'tickets'],
    ],

    'companies' => [
        'include_properties' => ['domain', 'name', 'phone'],
        'include_associations' => ['contacts', 'deals', 'tickets'],
    ],

    'deals' => [
        'include_properties' => ['dealname', 'amount', 'closedate', 'pipeline', 'dealstage'],
        'include_associations' => ['companies', 'contacts', 'tickets'],
    ],

    'products' => [
        'include_properties' => ['name', 'description', 'price'],
        'include_associations' => ['companies', 'contacts', 'deals', 'tickets'],
    ],

    'tickets' => [
        'include_properties' => ['content', 'subject'],
        'include_associations' => ['companies', 'contacts', 'deals'],
    ],

    'line_items' => [
        'include_properties' => ['quantity', 'amount', 'price'],
        'include_associations' => ['companies', 'contacts', 'deals', 'tickets'],
    ],

    'quotes' => [
        'include_properties' => [],
        'include_associations' => ['companies', 'contacts', 'deals', 'tickets'],
    ],

    'calls' => [
        'include_properties' => ['hs_call_title', 'hubspot_owner_id', 'hs_call_body', 'hs_call_direction', 'hs_call_callee_object_id', 'hs_call_callee_object_type_id', 'hs_call_disposition', 'hs_call_duration', 'hs_call_from_number', 'hs_call_to_number'],
        'include_associations' => ['companies', 'contacts', 'deals', 'tickets'],
    ],

    'emails' => [
        'include_properties' => [
            'hubspot_owner_id',
            'hs_timestamp',
            'hs_email_subject',
            'hs_email_status',
            'hs_email_text',
            'hs_email_direction',
        ],
        'include_associations' => ['companies', 'contacts', 'deals', 'tickets'],
    ],

    'notes' => [
        'include_properties' => ['hubspot_owner_id', 'hs_timestamp', 'hs_note_body'],
        'include_associations' => ['companies', 'contacts', 'deals', 'tickets'],
    ],

    'http' => [
        'timeout' => env('HUBSPOT_HTTP_TIMEOUT', 10),
        'connect_timeout' => env('HUBSPOT_HTTP_CONNECT_TIMEOUT', 10),
    ],

    'endpoints' => [
        'read' => env('HUBSPOT_READ_ENDPOINT', '/crm/v3/objects/{type}/{id}'),
        'create' => env('HUBSPOT_CREATE_ENDPOINT', '/crm/v3/objects/{type}'),
        'update' => env('HUBSPOT_UPDATE_ENDPOINT', '/crm/v3/objects/{type}/{id}'),
        'delete' => env('HUBSPOT_DELETE_ENDPOINT', '/crm/v3/objects/{type}/{id}'),
        'search' => env('HUBSPOT_SEARCH_ENDPOINT', '/crm/v3/objects/{type}/search'),
        'batchRead' => env('HUBSPOT_BATCH_READ_ENDPOINT', '/crm/v3/objects/{type}/batch/read'),
        'associate' => env('HUBSPOT_ASSOCIATE_ENDPOINT', '/crm/v3/objects/{type}/{id}/associations/{association}/{associationId}/{associationType}'),
        'associations' => env('HUBSPOT_ASSOCIATIONS_ENDPOINT', '/crm/v3/objects/{type}/{id}/associations/{association}'),
        'properties' => env('HUBSPOT_PROPERTIES_ENDPOINT', '/crm/v3/properties/{type}'),
    ],
];
