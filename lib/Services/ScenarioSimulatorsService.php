<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Services;

use \GoCardlessPro\Core\Paginator;
use \GoCardlessPro\Core\Util;
use \GoCardlessPro\Core\ListResponse;
use \GoCardlessPro\Resources\ScenarioSimulator;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the ScenarioSimulator
 * endpoints of the API
 */
class ScenarioSimulatorsService extends BaseService
{

    protected $envelope_key   = 'scenario_simulators';
    protected $resource_class = '\GoCardlessPro\Resources\ScenarioSimulator';


    /**
     * Simulate a scenario
     *
     * Example URL: /scenario_simulators/:identity/actions/run
     *
     * @param  string               $identity The unique identifier of the simulator, used to initiate
     *                                        simulations. One of: <ul>
     *                                        <li>`creditor_verification_status_action_required`: Sets
     *                                        a creditor's `verification status` to `action required`,
     *                                        meaning that the creditor must provide further
     *                                        information to GoCardless in order to verify their
     *                                        account to receive payouts.</li>
     *                                        <li>`creditor_verification_status_in_review`: Sets a
     *                                        creditor's `verification status` to `in review`, meaning
     *                                        that the creditor has provided all of the information
     *                                        requested by GoCardless to verify their account, and is
     *                                        now awaiting review.</li>
     *                                        <li>`creditor_verification_status_successful`: Sets a
     *                                        creditor's `verification status` to `successful`,
     *                                        meaning that the creditor is fully verified and can
     *                                        receive payouts.</li> <li>`payment_confirmed`:
     *                                        Transitions a payment through to `confirmed`. It must
     *                                        start in the `pending_submission` state, and its mandate
     *                                        must be in the `activated` state (unless it is a payment
     *                                        for ACH, BECS, BECS_NZ or SEPA, in which cases the
     *                                        mandate may be `pending_submission`, since their
     *                                        mandates are submitted with their first payment).</li>
     *                                        <li>`payment_paid_out`: Transitions a payment through to
     *                                        `paid_out`, having been collected successfully and paid
     *                                        out to you. It must start in the `pending_submission`
     *                                        state, and its mandate must be in the `activated` state
     *                                        (unless it is a payment for ACH, BECS, BECS_NZ or SEPA,
     *                                        in which cases the mandate may be `pending_submission`,
     *                                        since their mandates are submitted with their first
     *                                        payment).</li> <li>`payment_failed`: Transitions a
     *                                        payment through to `failed`. It must start in the
     *                                        `pending_submission` state, and its mandate must be in
     *                                        the `activated` state (unless it is a payment for ACH,
     *                                        BECS, BECS_NZ or SEPA, in which cases the mandate may be
     *                                        `pending_submission`, since their mandates are submitted
     *                                        with their first payment).</li>
     *                                        <li>`payment_charged_back`: Behaves the same as the
     *                                        `payout_paid_out` simulator, except that the payment is
     *                                        transitioned to `charged_back` after it is paid out,
     *                                        having been charged back by the customer.</li>
     *                                        <li>`payment_chargeback_settled`: Behaves the same as
     *                                        the `payment_charged_back` simulator, except that the
     *                                        charged back payment is additionally included as a debit
     *                                        item in a payout, thereby settling the charged back
     *                                        payment.</li> <li>`payment_late_failure`: Transitions a
     *                                        payment through to `late_failure`, having been
     *                                        apparently collected successfully beforehand. It must
     *                                        start in either the `pending_submission` or `paid_out`
     *                                        state, and its mandate must be in the `activated` state
     *                                        (unless it is a payment for ACH, BECS, BECS_NZ or SEPA,
     *                                        in which cases the mandate may be `pending_submission`,
     *                                        since their mandates are submitted with their first
     *                                        payment). Not compatible with Autogiro mandates.</li>
     *                                        <li>`payment_late_failure_settled`: Behaves the same as
     *                                        the `payment_late_failure` simulator, except that the
     *                                        late failure is additionally included as a debit item in
     *                                        a payout, thereby settling the late failure.</li>
     *                                        <li>`payment_submitted`: Transitions a payment to
     *                                        `submitted`, without proceeding any further. It must
     *                                        start in the `pending_submission` state.</li>
     *                                        <li>`mandate_activated`: Transitions a mandate through
     *                                        to `activated`, having been submitted to the banks and
     *                                        set up successfully. It must start in the
     *                                        `pending_submission` state. Not compatible with ACH,
     *                                        BECS, BECS_NZ and SEPA mandates, which are submitted and
     *                                        activated with their first payment.</li>
     *                                        <li>`mandate_customer_approval_granted`: Transitions a
     *                                        mandate through to `pending_submission`, as if the
     *                                        customer approved the mandate creation. It must start in
     *                                        the `pending_customer_approval` state. Compatible only
     *                                        with Bacs and SEPA mandates, which support customer
     *                                        signatures on the mandate. All payments associated with
     *                                        the mandate will be transitioned to
     *                                        `pending_submission`. All subscriptions associated with
     *                                        the mandate will become `active`.</li>
     *                                        <li>`mandate_customer_approval_skipped`: Transitions a
     *                                        mandate through to `pending_submission`, as if the
     *                                        customer skipped the mandate approval during the mandate
     *                                        creation process. It must start in the
     *                                        `pending_customer_approval` state. Compatible only with
     *                                        Bacs and SEPA mandates, which support customer
     *                                        signatures on the mandate. All payments associated with
     *                                        the mandate will be transitioned to
     *                                        `pending_submission`. All subscriptions associated with
     *                                        the mandate will become `active`.</li>
     *                                        <li>`mandate_failed`: Transitions a mandate through to
     *                                        `failed`, having been submitted to the banks but found
     *                                        to be invalid (for example due to invalid bank details).
     *                                        It must start in the `pending_submission` or `submitted`
     *                                        states. Not compatible with SEPA mandates, which are
     *                                        submitted with their first payment.</li>
     *                                        <li>`mandate_expired`: Transitions a mandate through to
     *                                        `expired`, having been submitted to the banks, set up
     *                                        successfully and then expired because no collection
     *                                        attempts were made against it for longer than the
     *                                        scheme's dormancy period (13 months for Bacs, 3 years
     *                                        for SEPA, 15 months for ACH, Betalingsservice, and
     *                                        BECS). It must start in the `pending_submission` state.
     *                                        Not compatible with Autogiro, BECS NZ, and PAD mandates,
     *                                        which do not expire.</li> <li>`mandate_transferred`:
     *                                        Transitions a mandate through to `transferred`, having
     *                                        been submitted to the banks, set up successfully and
     *                                        then moved to a new bank account due to the customer
     *                                        using the UK's Current Account Switching Service (CASS).
     *                                        It must start in the `pending_submission` state. Only
     *                                        compatible with Bacs mandates.</li>
     *                                        <li>`mandate_transferred_with_resubmission`: Transitions
     *                                        a mandate through `transferred` and resubmits it to the
     *                                        banks, can be caused be the UK's Current Account
     *                                        Switching Service (CASS) or when a customer contacts
     *                                        GoCardless to change their bank details. It must start
     *                                        in the `pending_submission` state. Only compatible with
     *                                        Bacs mandates.</li> <li>`mandate_suspended_by_payer`:
     *                                        Transitions a mandate to `suspended_by_payer`, as if
     *                                        payer has suspended the mandate after it has been setup
     *                                        successfully. It must start in the `activated` state.
     *                                        Only compatible with PAY_TO mandates.</li>
     *                                        <li>`refund_paid`: Transitions a refund to `paid`. It
     *                                        must start in either the `pending_submission` or
     *                                        `submitted` state.</li> <li>`refund_settled`:
     *                                        Transitions a refund to `paid`, if it's not already,
     *                                        then generates a payout that includes the refund,
     *                                        thereby settling the funds. It must start in one of
     *                                        `pending_submission`, `submitted` or `paid` states.</li>
     *                                        <li>`refund_bounced`: Transitions a refund to `bounced`.
     *                                        It must start in either the `pending_submission`,
     *                                        `submitted`, or `paid` state.</li>
     *                                        <li>`refund_returned`: Transitions a refund to
     *                                        `refund_returned`. The refund must start in
     *                                        `pending_submission`.</li> <li>`payout_bounced`:
     *                                        Transitions a payout to `bounced`. It must start in the
     *                                        `paid` state.</li> <li>`billing_request_fulfilled`:
     *                                        Authorises the billing request, and then fulfils it. The
     *                                        billing request must be in the `pending` state, with all
     *                                        actions completed except for `bank_authorisation`. Only
     *                                        billing requests with a `payment_request` are
     *                                        supported.</li>
     *                                        <li>`billing_request_fulfilled_and_payment_failed`:
     *                                        Authorises the billing request, fulfils it, and moves
     *                                        the associated payment to `failed`. The billing request
     *                                        must be in the `pending` state, with all actions
     *                                        completed except for `bank_authorisation`. Only billing
     *                                        requests with a `payment_request` are supported.</li>
     *                                        <li>`billing_request_fulfilled_and_payment_paid_out`:
     *                                        Authorises the billing request, fulfils it, and moves
     *                                        the associated payment to `paid_out`. The billing
     *                                        request must be in the `pending` state, with all actions
     *                                        completed except for `bank_authorisation`. Only billing
     *                                        requests with a `payment_request` are supported.</li>
     *                                        </ul>
     * @param  array<string, mixed> $params   An associative array for any params
     * @return ScenarioSimulator
     **/
    public function run($identity, $params = array())
    {
        $path = Util::subUrl(
            '/scenario_simulators/:identity/actions/run',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array("data" => (object)$params['params']));
        
            unset($params['params']);
        }

        
        $response = $this->api_client->post($path, $params);
        

        return $this->getResourceForResponse($response);
    }

}
