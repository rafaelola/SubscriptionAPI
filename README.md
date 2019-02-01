Technical Test
Thanks for showing interest in working with PM Connect! Below is a technical test we use to gauge a candidate's technical level. It should take no longer than 7 days, at which point we ask you to submit what you have. We want to see your flair and individuality so don’t be afraid to add things not in the spec, you can use any language or tech to achieve this.

Subscription API
PMSubService is a subscription service that provides a company with its subscription needs, your task is to produce an API to handle subscribing, unsubscribing, and listing phone identifiers (a unique identifier for a phone, a phone number for example) for a given product identifier.

You will need to produce endpoints for the following functionality:

Parameters:
msisdn: A phone number, this may be provided in national format (e.g. 07700900797) or international format (e.g. +447700900797)
product_id: A string with a maximum length of 255 characters to identify the product.
Subscribe a phone
Accepts msisdn and product_id in the request query string.
Unsubscribe a phone
Accepts msisdn and product_id in the request query string.
Find subscription
Accepts a msisdn and returns the subscriptions related to it.
Anything not mentioned in the specification above is up to you. You may implement these endpoints how you see fit and should provide us with documentation on how to interact with them.

Additional Requirements
The below are additional requirements for the API. Please implement as many of these as you wish, in any order. We do not expect you to implement them all.

In no specific order:

All endpoints to return valid JSON.
Returned subscriptions should include the subscribed and unsubscribed date.
The product_id parameter on the unsubscribe endpoint should be optional.
When only a msisdn is provided, it should unsubscribe from all products.
All parameters may be provided in the request as a query string, via json, or via x-www-form-urlencoded.
Implement CORS to enable requests to be made from JavaScript applications on different domains.
Support multiple returned data types
As well as accepting parameters in the query string, via json, or via x-www-form-urlencoded, also support parameters passed in by all of the supported returned data types.
Allow changing of returned data type.
Allow options requests to see supported data types for returned data and accepted data.
Anything else you consider to be beneficial
