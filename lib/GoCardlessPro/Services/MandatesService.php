<?php
/**
  * WARNING: Do not edit by hand, this file was generated by Crank:
  *
  * https://github.com/gocardless/crank
  */

namespace GoCardlessPro\Services;

/**
  *  Mandates
  *
  * @method \GoCardlessPro\Core\ListResponse
  * list(array $options=array(), array $headers=array()) gets a non-paginated list of models given finder options.
  *
  *  Mandates represent the Direct Debit mandate with a
  *  [customer](https://developer.gocardless.com/pro/2015-04-29/#api-endpoints-customers).

  *   *  
  *  GoCardless will notify you via a
  *  [webhook](https://developer.gocardless.com/pro/2015-04-29/#webhooks)
  *  whenever the status of a mandate changes.
  */
class MandatesService extends Base
{
  
  /**
    *  Create a mandate
    *
    *  Creates a new mandate object
    *
    *  Example URL: /mandates
    *
    *
    * @param array $params POST/URL parameters for the argument. Automatically wrapped.
    * @param array $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return Mandate
    * @throws \GoCardlessPro\Core\Error\GoCardlessError GoCardless API or server error, subclasses thereof.
    * @throws \GoCardlessPro\Core\Error\HttpError PHP Curl transport layer-level errors.
    **/
    public function create($params = array(), $headers = array())
    {
        return $this->make_request('create', 'post', '/mandates', $params, $headers);
    }

  /**
    *  List mandates
    *
    *  Returns a
    *  [cursor-paginated](https://developer.gocardless.com/pro/2015-04-29/#overview-cursor-pagination)
    *  list of your mandates. Except where stated, these filters can only be
    *  used one at a time.
    *
    *  Example URL: /mandates
    *
    *
    * @param array $params POST/URL parameters for the argument. Automatically wrapped.
    * @param array $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return \GoCardlessPro\Core\ListResponse
    * @throws \GoCardlessPro\Core\Error\GoCardlessError GoCardless API or server error, subclasses thereof.
    * @throws \GoCardlessPro\Core\Error\HttpError PHP Curl transport layer-level errors.
    **/
    public function do_list($params = array(), $headers = array())
    {
        return $this->make_request('list', 'get', '/mandates', $params, $headers);
    }

  /**
    *  Get a single mandate
    *
    *  Retrieves the details of an existing mandate.
    *  
    *  If you
    *  specify `Accept: application/pdf` on a request to this endpoint it will
    *  return a PDF complying to the relevant scheme rules, which you can
    *  present to your customer.
    *  
    *  PDF mandates can be retrieved in
    *  Dutch, English, French, German, Italian, Portuguese and Spanish by
    *  specifying the [ISO
    *  639-1](http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes#Partial_ISO_639_table)
    *  language code as an `Accept-Language` header.
    *
    *  Example URL: /mandates/:identity
    *
    *
    * @param string $identity Unique identifier, beginning with "MD"
    * @param array $params POST/URL parameters for the argument. Automatically wrapped.
    * @param array $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return Mandate
    * @throws \GoCardlessPro\Core\Error\GoCardlessError GoCardless API or server error, subclasses thereof.
    * @throws \GoCardlessPro\Core\Error\HttpError PHP Curl transport layer-level errors.
    **/
    public function get($identity, $params = array(), $headers = array())
    {
        $path = self::sub_url('/mandates/:identity', array(
            'identity' => $identity
        ));

        return $this->make_request('get', 'get', $path, $params, $headers);
    }

  /**
    *  Update a mandate
    *
    *  Updates a mandate object. This accepts only the metadata parameter.
    *
    *  Example URL: /mandates/:identity
    *
    *
    * @param string $identity Unique identifier, beginning with "MD"
    * @param array $params POST/URL parameters for the argument. Automatically wrapped.
    * @param array $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return Mandate
    * @throws \GoCardlessPro\Core\Error\GoCardlessError GoCardless API or server error, subclasses thereof.
    * @throws \GoCardlessPro\Core\Error\HttpError PHP Curl transport layer-level errors.
    **/
    public function update($identity, $params = array(), $headers = array())
    {
        $path = self::sub_url('/mandates/:identity', array(
            'identity' => $identity
        ));

        return $this->make_request('update', 'put', $path, $params, $headers);
    }

  /**
    *  Cancel a mandate
    *
    *  Immediately cancels a mandate and all associated cancellable payments.
    *  Any metadata supplied to this endpoint will be stored on the mandate
    *  cancellation event it causes.
    *  
    *  This will fail with a
    *  `cancellation_failed` error if the mandate is already cancelled.
    *
    *  Example URL: /mandates/:identity/actions/cancel
    *
    *
    * @param string $identity Unique identifier, beginning with "MD"
    * @param array $params POST/URL parameters for the argument. Automatically wrapped.
    * @param array $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return Mandate
    * @throws \GoCardlessPro\Core\Error\GoCardlessError GoCardless API or server error, subclasses thereof.
    * @throws \GoCardlessPro\Core\Error\HttpError PHP Curl transport layer-level errors.
    **/
    public function cancel($identity, $params = array(), $headers = array())
    {
        $path = self::sub_url('/mandates/:identity/actions/cancel', array(
            'identity' => $identity
        ));

        return $this->make_request('cancel', 'post', $path, $params, $headers);
    }

  /**
    *  Reinstate a mandate
    *
    *  <a name="mandate_not_inactive"></a>Reinstates a cancelled or expired
    *  mandate to the banks. You will receive a `resubmission_requested`
    *  webhook, but after that reinstating the mandate follows the same process
    *  as its initial creation, so you will receive a `submitted` webhook,
    *  followed by a `reinstated` or `failed` webhook up to two working days
    *  later. Any metadata supplied to this endpoint will be stored on the
    *  `resubmission_requested` event it causes.
    *  
    *  This will fail
    *  with a `mandate_not_inactive` error if the mandate is already being
    *  submitted, or is active.
    *  
    *  Mandates can be resubmitted up to
    *  3 times.
    *
    *  Example URL: /mandates/:identity/actions/reinstate
    *
    *
    * @param string $identity Unique identifier, beginning with "MD"
    * @param array $params POST/URL parameters for the argument. Automatically wrapped.
    * @param array $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return Mandate
    * @throws \GoCardlessPro\Core\Error\GoCardlessError GoCardless API or server error, subclasses thereof.
    * @throws \GoCardlessPro\Core\Error\HttpError PHP Curl transport layer-level errors.
    **/
    public function reinstate($identity, $params = array(), $headers = array())
    {
        $path = self::sub_url('/mandates/:identity/actions/reinstate', array(
            'identity' => $identity
        ));

        return $this->make_request('reinstate', 'post', $path, $params, $headers);
    }



  /**
    *  List mandates
    *
    *  Returns a
    *  [cursor-paginated](https://developer.gocardless.com/pro/2015-04-29/#overview-cursor-pagination)
    *  list of your mandates. Except where stated, these filters can only be
    *  used one at a time.
    *
    * Example URL: /mandates
    *
    * @param int $list_max The maximum number of records to return while paginating.
    * @param string[mixed] $params POST/URL parameters for the argument. Automatically wrapped.
    * @param string[string] $headers String to string associative array of custom headers to add to the requestion.
    *
    * @return \GoCardlessPro\Core\Paginator
    **/
    public function all($list_max, $params = array(), $headers = array())
    {
        return new \GoCardlessPro\Core\Paginator($this, $list_max, $this->do_list($params), $params, $headers);
    }


   /**
    * Get the resource loading class.
    * Used internally to send http requests.
    *
    * @return string
    */
    protected function resourceClass()
    {
        return '\GoCardlessPro\Resources\Mandate';
    }

  /**
    *  Get the key the response object is enclosed in in JSON.
    *  Used internally to wrap and unwrap http requests.
    *
    *  @return string
    */
    protected function envelopeKey()
    {
        return 'mandates';
    }
}
