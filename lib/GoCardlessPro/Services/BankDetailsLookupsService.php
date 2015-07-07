<?php
/**
  * WARNING: Do not edit by hand, this file was generated by Crank:
  *
  * https://github.com/gocardless/crank
  */

namespace GoCardlessPro\Services;

/**
  *  Bank Details Lookups
  *

  *
  *  Look up the name and reachability of a bank.
  */
class BankDetailsLookupsService extends Base
{
  
  /**
    *  Perform a bank details lookup
    *
    *  Performs a bank details lookup.
    *  
    *  Bank account details may
    *  be supplied using [local details](#appendix-local-bank-details) or an
    *  IBAN.
    *
    *  Example URL: /bank_details_lookups
    *
    *
    * @param array $params POST/URL parameters for the argument. Automatically wrapped.
    * @param array $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return BankDetailsLookup
    * @throws \GoCardlessPro\Core\Error\GoCardlessError GoCardless API or server error, subclasses thereof.
    * @throws \GoCardlessPro\Core\Error\HttpError PHP Curl transport layer-level errors.
    **/
    public function create($params = array(), $headers = array())
    {
        return $this->make_request('create', 'post', '/bank_details_lookups', $params, $headers);
    }




   /**
    * Get the resource loading class.
    * Used internally to send http requests.
    *
    * @return string
    */
    protected function resourceClass()
    {
        return '\GoCardlessPro\Resources\BankDetailsLookup';
    }

  /**
    *  Get the key the response object is enclosed in in JSON.
    *  Used internally to wrap and unwrap http requests.
    *
    *  @return string
    */
    protected function envelopeKey()
    {
        return 'bank_details_lookups';
    }
}
