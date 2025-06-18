<?php

namespace STS\HubSpot;

use Carbon\Carbon;
use STS\HubSpot\Api\Model;
use STS\HubSpot\Crm\Call;
use STS\HubSpot\Crm\Company;
use STS\HubSpot\Crm\Contact;
use STS\HubSpot\Crm\Deal;
use STS\HubSpot\Crm\Email;
use STS\HubSpot\Crm\FeedbackSubmissions;
use STS\HubSpot\Crm\Invoice;
use STS\HubSpot\Crm\LineItems;
use STS\HubSpot\Crm\Meeting;
use STS\HubSpot\Crm\Note;
use STS\HubSpot\Crm\Product;
use STS\HubSpot\Crm\Quote;
use STS\HubSpot\Crm\Subscription;
use STS\HubSpot\Crm\Task;
use STS\HubSpot\Crm\Ticket;

class Sdk
{
    protected array $models = [
        'companies' => Company::class,
        'contacts' => Contact::class,
        'deals' => Deal::class,
        'feedback_submissions' => FeedbackSubmissions::class,
        'line_items' => LineItems::class,
        'products' => Product::class,
        'tickets' => Ticket::class,
        'quotes' => Quote::class,
        'calls' => Call::class,
        'emails' => Email::class,
        'meetings' => Meeting::class,
        'notes' => Note::class,
        'tasks' => Task::class,
        'invoices' => Invoice::class,
        'subscriptions' => Subscription::class,
    ];

    public function __construct()
    {
    }

    public function isType($type)
    {
        return array_key_exists($type, $this->models);
    }

    public function getModel($type)
    {
        return $this->models[$type];
    }

    public function factory($type): Model
    {
        $class = $this->getModel($type);

        return new $class;
    }

    public function shouldCacheDefinitions(): bool
    {
        return config('hubspot.definitions.cache') !== false;
    }

    public function definitionCacheTtl(): Carbon
    {
        return now()->add(config('hubspot.definitions.cache'));
    }
}