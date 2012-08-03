# Payment Framework - Execution Overview

This is a summary in English of how payment processing works in the SilverStripe
Payment Framework.

 * Execution begins in developer application.
 * Pass a payment method to PaymentFactory. This returns a PaymentProcessor which
 has been instantiated with an the appropriate gateway and model classes.
 * Supply/build an array of payment data (Amount, Currency, Adderess, Credit Card, etc),
 depending on the payment gateway being used. This data can be gathered from a form,
 model data, other sources or combintations. Also supplied is a link to redirect to
 after all payment processing has completed.
 * Pass the payment data to the processor's *setup* function, which will put the data
 in the right places, validate the data, and possibly make provisional connections with
 gateways.
 * Call *capture* on processor to do the actual payment. If the gateway is merchant-hosted
 (also known as 2nd-party), then credit card information will have been provided during
 processor *setup*, and all payment transacting is performed through contact with the gateway
 server and no further interaction from the customer. If the gateawy is externally-hosted
 (also known as 3rd-party), then the customer is redirected to the external gateway website,
 where they enter credit-card details, and are then redirected back to the application site.
 * Our gateway object will then parse results from the gateway server, and package appropriate
 data into a PaymentGateway_Result object.
 * The processor saves appropriate result data into the model.
 * Processor redirects to link that was provided during setup. This could be back to the same place
 payment was captured, or to some kind of 'order complete' page / controller.