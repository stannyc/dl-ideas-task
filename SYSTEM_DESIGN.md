# SYSTEM DESIGN EXERCISE

### Problem Statement:

You have inherited a production application built on a PHP 5 framework with a MySQL database, serving active clients who depend on it daily. Design a strategy to migrate it to a modern stack while continuing to support existing clients, with zero or near-zero downtime.

---


### Migration Strategy
For migration strategy I will Strangler Fig strategy a to allow replacement of the old system gradually piece by piece and keep the existing customers able to continue using the old system and eventually both in paralael and then fully migrated to new system. The reason for choosing this strategy is because the migration process itself is gradual for example by feature, the process of development can be started from the least critical part of the system allowing all team members to also familiarize themself with the new system gradually and slowly moving towards the more critical part of the system where the experience on introducing new feature on the modern new system can be a valuable addaptation process for the development team as the migration sub tasks move towards more and more critical part.

---


### Architechture

First thing first, we must ensure that user able to communicate with both legacy and the new system without they even noticing. For example we can first change the authentication session on the old app to use redis, so the session is accessible for both old and new systems. Other strategy can also include moving the authentication layer first to the new system and issued cookie or token that can authenticate users on both systems. If the architechture on the old system contains technical debts and flaws, the new system should not absorb that, instead we created an adapter that can translate the data structure to be compatible on both old and the new system that already implemented the improvement from the flawed legacy one.

---

### Data

For the data syncronization I would devide the process into two stage:
1. Stage one is the both system syncronization. The goal is to make both legacy and new system communicate with the same database to avoid duplication and keeps existing client able to continue using the system without interuption. If there are changes on the table structure needed by the new system, then we expand the table to accomodate the new system but at the same time make sure the old system ignore those new columns that intended for the system to use. We might need to do backfill on the expanded columns in order to syncronize the data used by old system.
2. The second stage is the whole database update and migration process, that can only be done if the old system is fully retired. This including the steps of changing the MySQL version, or even changing the database engine completely. The main point is to avoid using multiple database engine while the two system is still being syncronized on legacy data. If there are improvements needed to be made on the database level due to modernization e.g changing of data types or change the way we codify certain information on database level, must also wait until the legacy system is fully retired.

---


### Compatibility

During the transition, all the public contract should be identical (URL, request and response formats, status codes, emails, etc...) any improvement intended for new system should wait until the legacy system is fully retired. We can monitor the real prodduction traffic on both ole and gradually introduced new systems to ensure there's no interuption on the User's side. Any changes needed for UI have to wait until the legacy system is fully retired. Introduction of new feature on the new system should be kept minimal during transition.

---

### Rollout and Risk

I will kickstart the migration process by making sure the telemetry are in place on the old system, and is configured to also able to monitor the new system. Then the roll out should start small e.g internal users if there are any, or a portion of customer based on region or other criteria. This  addoption process is then monitored and the incident rate is measured towards a pre-defined tolerancy level while making sure a rollback can be done fast and without disruption to customers when the rollback needed to be performed. We can set a proxy or api gateway that rerouted the traffic of certain portion we want to implement from the new system, so when the need of rollback arise we can just switch back the traffic to the old system. There should be a clear metric defined to indicate the rollout is succeeded and no rollback is needed.

---

### Decomissioning

Decommisioning can be done when a pre-defined criteria is met. e.g no traffic on the old system for 30 days. Before that, the legacy system should always be kept up and running and ready to receive a  fallback traffic whenever a rollback is executed on the new system.
