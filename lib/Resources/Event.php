<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a event, providing access to its
 * attributes
 *
 * @property-read mixed $action
 * @property-read mixed $created_at
 * @property-read mixed $customer_notifications
 * @property-read mixed $details
 * @property-read mixed $id
 * @property-read mixed $links
 * @property-read mixed $metadata
 * @property-read mixed $resource_metadata
 * @property-read mixed $resource_type
 */
class Event extends BaseResource
{
    protected $model_name = "Event";

    /**
     * What has happened to the resource. See [Event Actions](#event-actions)
     * for the possible actions.
     */
    protected $action;

    /**
     * Fixed [timestamp](#api-usage-dates-and-times), recording when this
     * resource was created.
     */
    protected $created_at;

    /**
     * Present only in webhooks when an integrator is authorised to send their
     * own
     * notifications. See
     * [here](/getting-started/api/handling-customer-notifications/)
     * for further information.
     */
    protected $customer_notifications;

    /**
     * 
     */
    protected $details;

    /**
     * Unique identifier, beginning with "EV".
     */
    protected $id;

    /**
     * 
     */
    protected $links;

    /**
     * The metadata that was passed when making the API request that triggered
     * the event
     * (for instance, cancelling a mandate).
     * 
     * This field will only be populated if the `details[origin]` field is `api`
     * otherwise it will be an empty object.
     */
    protected $metadata;

    /**
     * The metadata of the resource that the event is for. For example, this
     * field will have the same
     * value of the `mandate[metadata]` field on the response you would receive
     * from performing a GET request on a mandate.
     */
    protected $resource_metadata;

    /**
     * The resource type for this event. One of:
     * <ul>
     * <li>`billing_requests`</li>
     * <li>`creditors`</li>
     * <li>`exports`</li>
     * <li>`instalment_schedules`</li>
     * <li>`mandates`</li>
     * <li>`payer_authorisations`</li>
     * <li>`payments`</li>
     * <li>`payouts`</li>
     * <li>`refunds`</li>
     * <li>`scheme_identifiers`</li>
     * <li>`subscriptions`</li>
     * </ul>
     */
    protected $resource_type;

}
