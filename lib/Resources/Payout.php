<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a payout, providing access to its
 * attributes
 *
 * @property-read mixed $amount
 * @property-read mixed $arrival_date
 * @property-read mixed $created_at
 * @property-read mixed $currency
 * @property-read mixed $deducted_fees
 * @property-read mixed $fx
 * @property-read mixed $id
 * @property-read mixed $links
 * @property-read mixed $metadata
 * @property-read mixed $payout_type
 * @property-read mixed $reference
 * @property-read mixed $status
 * @property-read mixed $tax_currency
 */
class Payout extends BaseResource
{
    protected $model_name = "Payout";

    /**
     * Amount in minor unit (e.g. pence in GBP, cents in EUR).
     */
    protected $amount;

    /**
     * Date the payout is due to arrive in the creditor's bank account.
     * One of:
     * <ul>
     *   <li>`yyyy-mm-dd`: the payout has been paid and is due to arrive in the
     * creditor's bank
     *   account on this day</li>
     *   <li>`null`: the payout hasn't been paid yet</li>
     * </ul>
     */
    protected $arrival_date;

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
     * Fees that have already been deducted from the payout amount in minor unit
     * (e.g. pence in GBP, cents in EUR), inclusive of tax if applicable.
     * <br />
     * For each `late_failure_settled` or `chargeback_settled` action, we refund
     * the transaction fees in a payout. This means that a payout can have a
     * negative `deducted_fees` value.
     * <br />
     * This field is calculated as `(GoCardless fees + app fees + surcharge
     * fees) - (refunded fees)`
     * <br />
     * If the merchant is invoiced for fees separately from the payout, then
     * `deducted_fees` will be 0.
     */
    protected $deducted_fees;

    /**
     * 
     */
    protected $fx;

    /**
     * Unique identifier, beginning with "PO".
     */
    protected $id;

    /**
     * 
     */
    protected $links;

    /**
     * Key-value store of custom data. Up to 3 keys are permitted, with key
     * names up to 50 characters and values up to 500 characters. _Note:_ This
     * should not be used for storing PII data.
     */
    protected $metadata;

    /**
     * Whether a payout contains merchant revenue or partner fees.
     */
    protected $payout_type;

    /**
     * Reference which appears on the creditor's bank statement.
     */
    protected $reference;

    /**
     * One of:
     * <ul>
     * <li>`pending`: the payout has been created, but not yet sent to your bank
     * or it is in the process of being exchanged through our FX provider.</li>
     * <li>`paid`: the payout has been sent to the your bank. FX payouts will
     * become `paid` after we emit the `fx_rate_confirmed` webhook.</li>
     * <li>`bounced`: the payout bounced when sent, the payout can be
     * retried.</li>
     * </ul>
     */
    protected $status;

    /**
     * [ISO 4217](http://en.wikipedia.org/wiki/ISO_4217#Active_codes) code for
     * the currency in which tax is paid out to the tax authorities of your tax
     * jurisdiction. Currently “EUR”, “GBP”, for French or British merchants,
     * this will be `null` if tax is not applicable <em>beta</em>
     */
    protected $tax_currency;

}
