<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a payment, providing access to its
 * attributes
 *
 * @property-read mixed $amount
 * @property-read mixed $amount_refunded
 * @property-read mixed $charge_date
 * @property-read mixed $created_at
 * @property-read mixed $currency
 * @property-read mixed $description
 * @property-read mixed $faster_ach
 * @property-read mixed $fx
 * @property-read mixed $id
 * @property-read mixed $links
 * @property-read mixed $metadata
 * @property-read mixed $reference
 * @property-read mixed $retry_if_possible
 * @property-read mixed $status
 */
class Payment extends BaseResource
{
    protected $model_name = "Payment";

    /**
     * Amount, in the lowest denomination for the currency (e.g. pence in GBP,
     * cents in EUR).
     */
    protected $amount;

    /**
     * Amount [refunded](#core-endpoints-refunds), in the lowest denomination
     * for the currency (e.g. pence in GBP, cents in EUR).
     */
    protected $amount_refunded;

    /**
     * A future date on which the payment should be collected. If not specified,
     * the payment will be collected as soon as possible. If the value is before
     * the [mandate](#core-endpoints-mandates)'s `next_possible_charge_date`
     * creation will fail. If the value is not a working day it will be rolled
     * forwards to the next available one.
     */
    protected $charge_date;

    /**
     * Fixed [timestamp](#api-usage-dates-and-times), recording when this
     * resource was created.
     */
    protected $created_at;

    /**
     * [ISO 4217](http://en.wikipedia.org/wiki/ISO_4217#Active_codes) currency
     * code. Currently "AUD", "CAD", "DKK", "EUR", "GBP", "NZD", "SEK" and "USD"
     * are supported.
     */
    protected $currency;

    /**
     * A human-readable description of the payment. This will be included in the
     * notification email GoCardless sends to your customer if your organisation
     * does not send its own notifications (see [compliance
     * requirements](#appendix-compliance-requirements)).
     */
    protected $description;

    /**
     * This field indicates whether the ACH payment is processed through Faster
     * ACH or standard ACH.
     * 
     * It is only present in the API response for ACH payments.
     */
    protected $faster_ach;

    /**
     * 
     */
    protected $fx;

    /**
     * Unique identifier, beginning with "PM".
     */
    protected $id;

    /**
     * 
     */
    protected $links;

    /**
     * Key-value store of custom data. Up to 3 keys are permitted, with key
     * names up to 50 characters and values up to 500 characters.
     */
    protected $metadata;

    /**
     * An optional reference that will appear on your customer's bank statement.
     * The character limit for this reference is dependent on the scheme.<br />
     * <strong>ACH</strong> - 10 characters<br /> <strong>Autogiro</strong> - 11
     * characters<br /> <strong>Bacs</strong> - 10 characters<br />
     * <strong>BECS</strong> - 30 characters<br /> <strong>BECS NZ</strong> - 12
     * characters<br /> <strong>Betalingsservice</strong> - 30 characters<br />
     * <strong>Faster Payments</strong> - 18 characters<br />
     * <strong>PAD</strong> - scheme doesn't offer references<br />
     * <strong>PayTo</strong> - 18 characters<br /> <strong>SEPA</strong> - 140
     * characters<br /> Note that this reference must be unique (for each
     * merchant) for the BECS scheme as it is a scheme requirement. <p
     * class='restricted-notice'><strong>Restricted</strong>: You can only
     * specify a payment reference for Bacs payments (that is, when collecting
     * from the UK) if you're on the <a
     * href='https://gocardless.com/pricing'>GoCardless Plus, Pro or Enterprise
     * packages</a>.</p> <p
     * class='restricted-notice'><strong>Restricted</strong>: You can not
     * specify a payment reference for Faster Payments.</p>
     */
    protected $reference;

    /**
     * On failure, automatically retry the payment using [intelligent
     * retries](#success-intelligent-retries). Default is `false`. <p
     * class="notice"><strong>Important</strong>: To be able to use intelligent
     * retries, Success+ needs to be enabled in [GoCardless
     * dashboard](https://manage.gocardless.com/success-plus). </p>
     */
    protected $retry_if_possible;

    /**
     * One of:
     * <ul>
     * <li>`pending_customer_approval`: we're waiting for the customer to
     * approve this payment</li>
     * <li>`pending_submission`: the payment has been created, but not yet
     * submitted to the banks</li>
     * <li>`submitted`: the payment has been submitted to the banks</li>
     * <li>`confirmed`: the payment has been confirmed as collected</li>
     * <li>`paid_out`:  the payment has been included in a
     * [payout](#core-endpoints-payouts)</li>
     * <li>`cancelled`: the payment has been cancelled</li>
     * <li>`customer_approval_denied`: the customer has denied approval for the
     * payment. You should contact the customer directly</li>
     * <li>`failed`: the payment failed to be processed. Note that payments can
     * fail after being confirmed if the failure message is sent late by the
     * banks.</li>
     * <li>`charged_back`: the payment has been charged back</li>
     * </ul>
     */
    protected $status;

}
