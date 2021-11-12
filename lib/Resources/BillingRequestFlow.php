<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a billing_request_flow, providing access to its
 * attributes
 *
 * @property-read $authorisation_url
 * @property-read $auto_fulfil
 * @property-read $created_at
 * @property-read $expires_at
 * @property-read $id
 * @property-read $links
 * @property-read $lock_bank_account
 * @property-read $lock_customer_details
 * @property-read $redirect_uri
 * @property-read $session_token
 */
class BillingRequestFlow extends BaseResource
{
    protected $model_name = "BillingRequestFlow";

    /**
     * URL for a GC-controlled flow which will allow the payer to fulfil the
     * billing request
     */
    protected $authorisation_url;

    /**
     * Fulfil the Billing Request on completion of the flow (true by default)
     */
    protected $auto_fulfil;

    /**
     * Timestamp when the flow was created
     */
    protected $created_at;

    /**
     * Timestamp when the flow will expire. Each flow currently lasts for 7
     * days.
     */
    protected $expires_at;

    /**
     * Unique identifier, beginning with "BRF".
     */
    protected $id;

    /**
     * 
     */
    protected $links;

    /**
     * If true, the payer will not be able to change their bank account within
     * the flow. If the bank_account details are collected as part of
     * bank_authorisation then GC will set this value to true mid flow
     */
    protected $lock_bank_account;

    /**
     * If true, the payer will not be able to edit their customer details within
     * the flow. If the customer details are collected as part of
     * bank_authorisation then GC will set this value to true mid flow
     */
    protected $lock_customer_details;

    /**
     * URL that the payer can be redirected to after completing the request
     * flow.
     */
    protected $redirect_uri;

    /**
     * Session token populated when responding to the initalise action
     */
    protected $session_token;

}
