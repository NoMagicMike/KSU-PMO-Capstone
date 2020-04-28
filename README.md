# CCSE Project Management System - Capstone Project - 2020
Kennesaw State University's College of Computing and Software Engineering (CCSE) has requested an application that will allow KSU staff to track, manage, and review their projects and contracts for hire. The application allows administrative users to create and delete projects and users. Non-administrative users are able to view existing projects and submit new projects for approval.
## Contributors: 

Contributors to the GitHub Repo (Upon Submission) include:

#### Jason Hazenfield
   - Lead Developer - Created most of the PHP logic for table and project management and implemented PDO extension for PHP

#### Mike Kilinc
   - Assisted with adding features by modifying code created by Jason

#### Shravan Raul
   - Implemented Bootstrap Elements
                  
 Contributors not listed on Github:
 
#### Avery Brown
   - Database Design

#### Hannah Faissal
   - Project Documentation and Technical Writing

## Installation

We have created this application to work on RHEL 7 with a LAMP stack. Other operating systems will work as well with some adjustment.

Single Line LAMP Setup (from [rackspace.com](https://support.rackspace.com/how-to/how-to-install-a-lamp-stack-on-rhel-7-based-distributions/))
```bash
 sudo sh -c "yum install httpd mariadb mariadb-server mod_php73 -y; systemctl start mariadb && mysql_secure_installation && systemctl restart mariadb && systemctl start httpd && systemctl enable httpd && systemctl enable mariadb && firewall-cmd --permanent --zone=public --add-service=http && firewall-cmd --permanent --zone=public --add-service=https && firewall-cmd --reload"
```
Clone the repo to desired folder, then copy files over to default Apache Document Root

