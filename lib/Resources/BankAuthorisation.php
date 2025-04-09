<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a bank_authorisation, providing access to its
 * attributes
 *
 * @property-read mixed $authorisation_type
 * @property-read mixed $authorised_at
 * @property-read mixed $created_at
 * @property-read mixed $expires_at
 * @property-read mixed $id
 * @property-read mixed $last_visited_at
 * @property-read mixed $links
 * @property-read mixed $qr_code_url
 * @property-read mixed $redirect_uri
 * @property-read mixed $url
 */
class BankAuthorisation extends BaseResource
{
    protected $model_name = "BankAuthorisation";

    /**
     * Type of authorisation, can be either 'mandate' or 'payment'.
     */
    protected $authorisation_type;

    /**
     * Fixed [timestamp](#api-usage-dates-and-times), recording when the user
     * has been authorised.
     */
    protected $authorised_at;

    /**
     * Timestamp when the flow was created
     */
    protected $created_at;

    /**
     * Timestamp when the url will expire. Each authorisation url currently
     * lasts for 15 minutes, but this can vary by bank.
     */
    protected $expires_at;

    /**
     * Unique identifier, beginning with "BAU".
     */
    protected $id;

    /**
     * Fixed [timestamp](#api-usage-dates-and-times), recording when the
     * authorisation URL has been visited.
     */
    protected $last_visited_at;

    /**
     * 
     */
    protected $links;

    /**
     * URL to a QR code PNG image of the bank authorisation url.
     * This QR code can be used as an alternative to providing the `url` to the
     * payer to allow them to authorise with their mobile devices.
     */
    protected $qr_code_url;

    /**
     * URL that the payer can be redirected to after authorising the payment.
     * 
     * On completion of bank authorisation, the query parameter of either
     * `outcome=success` or `outcome=failure` will be
     * appended to the `redirect_uri` to indicate the result of the bank
     * authorisation. If the bank authorisation is
     * expired, the query parameter `outcome=timeout` will be appended to the
     * `redirect_uri`, in which case you should
     * prompt the user to try the bank authorisation step again.
     * 
     * Please note: bank authorisations can still fail despite an
     * `outcome=success` on the `redirect_uri`. It is therefore recommended to
     * wait for the relevant bank authorisation event, such as
     * [`BANK_AUTHORISATION_AUTHORISED`](#billing-request-bankauthorisationauthorised),
     * [`BANK_AUTHORISATION_DENIED`](#billing-request-bankauthorisationdenied),
     * or
     * [`BANK_AUTHORISATION_FAILED`](#billing-request-bankauthorisationfailed)
     * in order to show the correct outcome to the user.
     * 
     * The BillingRequestFlow ID will also be appended to the `redirect_uri` as
     * query parameter `id=BRF123`.
     * 
     * Defaults to `https://pay.gocardless.com/billing/static/thankyou`.
     */
    protected $redirect_uri;

    /**
     * URL for an oauth flow that will allow the user to authorise the payment
     */
    protected $url;

}
