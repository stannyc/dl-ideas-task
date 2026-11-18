# SERVER MANAGEMENT AND DEPLOYMENT

Based on the case presented, here's my responses to the questions:


### Server Setup
For OS I will choose Ubuntu LTS or latest stable Debian. The reason for this choice is just based on my familiarity with debian based linux distribution compared to RHEL based such as CentOS. Docker is preferable mode of delivery to allow easier rollback if needed. For web server I will choose Nginx + PHP-FPM7.3. For PHP Configuration, I'll set display_errors=Off, log_errors=On, exposer_php=Off, set memory level to sensible level as well as upload limits. FrankenPHP and any other custom services needed to run the application should run under a dedicated user (for simple setup I usually use same user that run these services and the one I linked with github action). Port opened to internet is only 80 and 443 if possible and access to database port should preferably available only from the web servers (no access directly from the internet). SSH login is based on key, where everyone given access to the servers should be given their own user account instead of everyone using one account for traceability.

---

### Deployment Pipeline
For branching strategy due to small size of the team will not using git flow strategy. I will choose a simpler flow where all feature branch should be branched out from main branch. any merge into main branch will automatically deploy to production. I will create a staging for QA purpose where all features developed either approved or not for release lives there for the sake of Quality Assurance. When a feature branch is deemed ready to be review, a PR request is made towards staging branch and trigger Github action to deploy to staging. Once QA confirmed and approve the feature, a PR is made from that feature branch towards main. Staging branch will never merged into main. In staging branch all features comes in but never comes out. Since deployment is made using docker, rolling back can be done simply by rolling back the docker image tag to the previous one. Database migration should be done incrementally, without touching the previously deployed migration file. Any expand and contract  process of the database should be reviewed before PR is merged to avoid any issue with production data.

---

### Access and secrets
Senior developer held access to production server and Stripe or any other third party server live dashboard admin. Junior developer contributes changes only via Pull Requests, and held no access to production server SSH. In an urgent moment this credentials can be given to them where the activities are logged, and the access is revoked once the activity for that urgent situation passed. Senior developer should always prepare this emergency key ready to be sent to whoever Junior developer needs them. All secrets should never commited to git, Senior develper can set these in github secrets or any other secreat manager tools.

---

### Backup and Recovery
A regular nightly database backup should be schedule to run automatically, and the recovery process can be done by restoring that nightly backup plus binary logs up to the time when the incident needed recovery happened. For deployment using docker as my code is, I will use wal-g to handle nightly backup and binlog backup to a dedicated storage (preferably S3) makes it easier to perform recovery when needed.

---

### Maintenance
Server's security patches should be periodically checked and updated, SSL should be set to renew SSL certificate automatically using certbot. However a reminder should also be set to send alert (preferably to Slack). Server's disk space should be monitored and alert is triggered into slack when capacity reached 80%.

---

### Team Process
All team members work from a set of runbooks prepared for each situation: branching, pull requests, deployment, rollback, restoring backups, secret rotation and incident handling. For clarity during code reviews, every pull request should follow a predefined template containing checklists for backward compatibility, testing on staging, QA approval, and whether it needs manual approval due to a destructive database migration. Structured reviews are conducted after incidents to reveal any mistakes and drive improvements. A simple self- and peer-review feedback system lets team members measure their performance against their own past performance or against their peers. All achievements and substantial contributions, especially by junior developers, should be recorded and properly reported up the chain of command.
