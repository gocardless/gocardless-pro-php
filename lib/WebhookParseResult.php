<?php

namespace GoCardlessPro;

/**
 * Represents the result of parsing a webhook, containing both the events
 * and the webhook metadata.
 */
class WebhookParseResult
{
    /**
     * @var Resources\Event[]
     */
    private $events;

    /**
     * @var string|null
     */
    private $webhookId;

    public function __construct(array $events, $webhookId)
    {
        $this->events = $events;
        $this->webhookId = $webhookId;
    }

    /**
     * Returns the list of events included in the webhook.
     *
     * @return Resources\Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Returns the webhook ID from the meta field, or null if not present.
     *
     * @return string|null
     */
    public function getWebhookId()
    {
        return $this->webhookId;
    }
}
