## Incident Scenario

### Incident Case:
It is 9:00 PM on a Friday. Users report that payments are going through on Stripe but no invoices or receipts are appearing in the portal. The admin panel also loads very slowly.

---

## Assumptions
Based on the scenario above I assume that: 
1. The app which the incident happned upon the one I just built for coding exercise
2. No money is lost. Stripe has the payments, and Stripe keeps retrying failed webhook deliveries for up to 3 days. So this is a customer-experience and trust problem, not a data-loss emergency. That means I can work carefully and avoid risky moves, instead of panicking

here is what I would do during the first 30 minutes:
* Acknowledge the report back to the customer to inform them that the report is well received and will be handled promptly with me as contact point for the updates about the fix
* Inform all team members to see who are available to be involve in the incident handling
* Rally all available team members and distribute the task for each person with to collect informations on Server Logs, Database Logs, Sentry Logs.
* Me or secret keeper that holds access to Stripe dashboard performs quick checks on Stripe dashboard to see any errors on callback or webhook delivery, and what error does it catched.
* Me (or QA staff if available) check the customer side of the system using QA-purposed account to make try reproduce the issue





Subsequently I will proceed the incident handling including and not limited to the following steps:
* Find and isolate what breaks and what caused it. Look for what changed today is it deployment, a cron job, rotated secret, or server failures
* if the system is caused by server failures then perform fix depends on what the failure is, could be Disk space is full, failed cron job. Collect evidence before the fix is applied on the server or the server is restarted.
* If the issue is caused by any broken recent deploy, do rollback immediately, create github issue about the incident pointing out the cause with error logs as evidences for review and fix process on Monday.
* Confirm the fix/recovery again from customer point of view using QA-purposed account, once confirmed fix communicate with all stakeholders including the customers who filed the report about the fix, and inform them the complete technical assessment will be made available by Monday.
* Acknoledgement to customer and report to direct report should be made whithin 15 minutes of the incident and While searching for the incident cause of even try to apply fix, give regular updates to all stakeholders every 30 minutes even if there's no fix applied yet or the cause not found yet.

