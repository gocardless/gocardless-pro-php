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
 * @property-read $exit_uri
 * @property-read $expires_at
 * @property-read $id
 * @property-read $language
 * @property-read $links
 * @property-read $lock_bank_account
 * @property-read $lock_currency
 * @property-read $lock_customer_details
 * @property-read $prefilled_bank_account
 * @property-read $prefilled_customer
 * @property-read $redirect_uri
 * @property-read $session_token
 * @property-read $show_redirect_buttons
 * @property-read $show_success_redirect_button
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
     * (Experimental feature) Fulfil the Billing Request on completion of the
     * flow (true by default). Disabling the auto_fulfil is not allowed
     * currently.
     */
    protected $auto_fulfil;

    /**
     * Timestamp when the flow was created
     */
    protected $created_at;

    /**
     * URL that the payer can be taken to if there isn't a way to progress ahead
     * in flow.
     */
    protected $exit_uri;

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
     * Sets the default language of the Billing Request Flow and the customer.
     * [ISO 639-1](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) code.
     */
    protected $language;

    /**
     * 
     */
    protected $links;

    /**
     * If true, the payer will not be able to change their bank account within
     * the flow. If the bank_account details are collected as part of
     * bank_authorisation then GC will set this value to true mid flow.
     * 
     * You can only lock bank account if these have already been completed as a
     * part of the billing request.
     */
    protected $lock_bank_account;

    /**
     * If true, the payer will not be able to change their currency/scheme
     * manually within the flow. Note that this only applies to the mandate only
     * flows - currency/scheme can never be changed when there is a specified
     * subscription or payment.
     */
    protected $lock_currency;

    /**
     * If true, the payer will not be able to edit their customer details within
     * the flow. If the customer details are collected as part of
     * bank_authorisation then GC will set this value to true mid flow.
     * 
     * You can only lock customer details if these have already been completed
     * as a part of the billing request.
     */
    protected $lock_customer_details;

    /**
     * Bank account information used to prefill the payment page so your
     * customer doesn't have to re-type details you already hold about them. It
     * will be stored unvalidated and the customer will be able to review and
     * amend it before completing the form.
     */
    protected $prefilled_bank_account;

    /**
     * Customer information used to prefill the payment page so your customer
     * doesn't have to re-type details you already hold about them. It will be
     * stored unvalidated and the customer will be able to review and amend it
     * before completing the form.
     */
    protected $prefilled_customer;

    /**
     * URL that the payer can be redirected to after completing the request
     * flow.
     */
    protected $redirect_uri;

    /**
     * Session token populated when responding to the initialise action
     */
    protected $session_token;

    /**
     * If true, the payer will be able to see redirect action buttons on Thank
     * You page. These action buttons will provide a way to connect back to the
     * billing request flow app if opened within a mobile app. For successful
     * flow, the button will take the payer back the billing request flow where
     * they will see the success screen. For failure, button will take the payer
     * to url being provided against exit_uri field.
     */
    protected $show_redirect_buttons;

    /**
     * If true, the payer will be able to see a redirect action button on the
     * Success page. This action button will provide a way to redirect the payer
     * to the given redirect_uri. This functionality is applicable only for
     * Android users as automatic redirection is not possible in such cases.
     */
    protected $show_success_redirect_button;

}
