<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a block, providing access to its
 * attributes
 *
 * @property-read mixed $active
 * @property-read mixed $block_type
 * @property-read mixed $created_at
 * @property-read mixed $id
 * @property-read mixed $reason_description
 * @property-read mixed $reason_type
 * @property-read mixed $resource_reference
 * @property-read mixed $updated_at
 */
class Block extends BaseResource
{
    protected $model_name = "Block";

    /**
     * Shows if the block is active or disabled. Only active blocks will be used
     * when deciding
     * if a mandate should be blocked.
     */
    protected $active;

    /**
     * Type of entity we will seek to match against when blocking the mandate.
     * This
     * can currently be one of 'email', 'email_domain', 'bank_account', or
     * 'bank_name'.
     */
    protected $block_type;

    /**
     * Fixed [timestamp](#api-usage-dates-and-times), recording when this
     * resource was created.
     */
    protected $created_at;

    /**
     * Unique identifier, beginning with "BLC".
     */
    protected $id;

    /**
     * This field is required if the reason_type is other. It should be a
     * description of
     * the reason for why you wish to block this payer and why it does not align
     * with the
     * given reason_types. This is intended to help us improve our knowledge of
     * types of
     * fraud.
     */
    protected $reason_description;

    /**
     * The reason you wish to block this payer, can currently be one of
     * 'identity_fraud',
     * 'no_intent_to_pay', 'unfair_chargeback'. If the reason isn't captured by
     * one of the
     * above then 'other' can be selected but you must provide a reason
     * description.
     */
    protected $reason_type;

    /**
     * This field is a reference to the value you wish to block. This may be the
     * raw value
     * (in the case of emails or email domains) or the ID of the resource (in
     * the case of
     * bank accounts and bank names). This means in order to block a specific
     * bank account
     * (even if you wish to block generically by name) it must already have been
     * created as
     * a resource.
     */
    protected $resource_reference;

    /**
     * Fixed [timestamp](#api-usage-dates-and-times), recording when this
     * resource was updated.
     */
    protected $updated_at;

}
