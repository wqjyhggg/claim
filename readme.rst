############################
Login Details to view THEME
############################

Username: admin@admin.com

Password: password


#####################
Jan, 24 2016 update:-
#####################
*******************
Claim and examine page update
*******************
- Send email/print function with intake form in 'create claim' page is done (some pre-fill values in certain places of docs is remaining)
- Edit claim item from claim examine page is done
- Examine page: policy info is done 
- examine claim: Payee information and intake forms list si done 


- QUERY:- Where to get "Policy Premium" and "Policy Pre-existion condition coverage", we have not find these info from "http://jfinsurance.auroraeducationonline.info/api/search" api. Please explain



#####################
Jan, 21 2016 update:-
#####################
*******************
Claim page update
*******************
- working on claim and examine claim page


#####################
Jan, 19 2016 update:-
#####################
*******************
Claim page update
*******************
- Add all OTC templates for email print
- Work on Claim Examine page
- Claim examin page design done
* other modules are in progress....



#####################
Jan, 17 2016 update:-
#####################
*******************
Claim page update
*******************
- Intake form submission
- Multiple expenses submission
- Multiple payees submission
- Setup fuzzy search on Diagnosis



#####################
Jan, 13 2016 update:-
#####################
*******************
Claim page update
*******************
- import database of icd10cm codes
- jquery functions:- multiple expenses / multiple payee, multiple file upload, email print(one doc), intake form(add and delete)



#####################
Jan, 11 2016 update:-
#####################
- Search policy function : If users search by client's name, system can list all the clients whose name is same one, then users can choose a client to display his/her all policies.If users search by a policy number，system will display the policy's clients (holder, insured), then list his/her all policies. - done


#####################
Jan, 10 2016 update:-
#####################
- Create Claim page basic info - done
- Search claim page - done


#####################
Jan, 07 2016 update:-
#####################
- Create Claim page layout - done


#####################
Dec, 23 2016 update:-
#####################
- Case Management: follow and inactivate from listing and edit screen is - done
- Create policy - done
- Claim page layout - done
-Note:- please import database files to avoid errors



#####################
Dec, 22 2016 update:-
#####################
- Case Management Page----- ------
- Print/Email templates complete functionality - done
- Print/Email templates and inactive function in edit case page - done
- Add insured amount in case - done
- Products api integtation - done
-Note:- please import database files to avoid errors


#####################
Dec, 21 2016 update:-
#####################
- automatically schedule: at user management page, every EMC user account has a work shift field . When case manager click Auto Schedule, system automatically all the EMCs' schedule according to the default work shift in the user management in this month.  After Auto Schedule, case manager can user above manual schedule function to adjust some EMCs' work shift. - DONE
- Print/Email:- Edit template, preview function, print function done on case management page.
- Create a provider: Add a field priority, (values range :1,2,3,4,5). - DONE

***Please import database to avoid db errors**

#####################
Dec, 20 2016 update:-
#####################
- Case Management Page----- ------
- Print/Email templates integration - done (sending is remaining)
- Popup layout and settings is - done
--- email/print in progress---
-Note:- please import database files to avoid errors


#####################
Dec, 19 2016 update:-
#####################
- Case Management Page----- ------
- Auto Assign to emc - done
- Assign emc manually - done
- Categorize emc list based on currenttime and shift - done
- Follow on case management page - done
- Set inactive function - done
- View/Edit button action - done
--- other functionalies on case management page email/print, reserve amount are in progress---
-Note:- please import database files to avoid errors


#####################
Dec, 17 2016 update:-
#####################
- Add Schedule calender - done
- Show schedule on calender dates cell - done
- Calender design - done
- Case management page some jquery validations, checkbox selections, emc users list - done
--- other functionalies on case management page is in progress---


#####################
Dec, 16 2016 update:-
#####################
- Search emc users via list name, firstname and email - done
- List of emc employees on popup window - done
- Add daily schedule once manager click on any future date - done
- Add weekly schedule once user click on week header(like "Monday") for all monday's of month - done
- Remove schedule - done
--- Show all added schedules on calender dates is in progress---


#####################
Dec, 15 2016 update:-
#####################
- Schedule page layout and design - done
- Schedule page permissions - done
- Model window design after clicking on date - done
--- Other functionalities of schedule are in progress, assigning case functionality will be done once schedule process is complete ---


#####################
Dec, 14 2016 update:-
#####################
- Case management page layout - done
- Case management page, search case and list cases is  - done
--- Other functionalities of case are in progress ---


#####################
Dec, 13 2016 update:-
#####################

- A Database Error - solved, please import sql file -  DONE

- at policy result , click a policy record ,system should enter policy details information page and at this page ,return the previous page. - DONE

- at case result, click a case record , system should enter an "edit case " page rather than a "create case " page. - Already DONE

- after create an intake form(also are called as "note"),  the "Emergency assistance" function page need to show the intake form's detailed information in this page, not only an attached file.  and attached file link should can be browsed its content. - DONE(you can able to browse file from browse button from edit/detail case page.)

- the variable name will be: plan_id 
if this variable (plan_id) is existing, other parameter will be ignored for the search result. - DONE
 
- For birthday search the change as following:
if  birthday2 is existed, the search query will search from birthday to birthday2 - DONE
 
- For apply_date search the change as following:
if  apply_date2 is existed, the search query will search from apply_date to apply_date2 - DONE
 
- For arrival_date search the change as following:
if  arrival_date2 is existed, the search query will search from arrival_date to arrival_date2 - DONE
 
- For effective_date search the change as following:
if  effective_date2 is existed, the search query will search from effective_date to effective_date2 - DONE
 
- For expiry_date2 search the change as following:
if  expiry_date2 is existed, the search query will search from expiry_date to expiry_date2 - DONE



#####################
Dec, 12 2016 update:-
#####################
- API integration and configuration - done
- Search policies from api  - done
--- Please see queries which is listed in doc ---


#####################
Dec, 09 2016 update:-
#####################
- Add inteke forms form edit case page - done
- Delete intake form - done
- Intake forms functionality - done


#####################
Dec, 08 2016 update:-
#####################
- Create intake from from add case page - done
- create intake from edit page is in progress.....


#####################
Dec, 07 2016 update:-
#####################
- Create design of intake form as client requirement
- handle multi upload function
- add function to hold all intake form data/files in "create case" page
- add intake from edit/detail case is in progress.....


#####################
Dec, 06 2016 update:-
#####################
- Search and List case management - done
- Edit case, assign case - done
- Clone case - done
* Intake forms management is in progress...


#####################
Dec, 05 2016 update:-
#####################

 4. User management page, advanced search
add a ‘advanced search button’ after “Reset button”, after clicking the “advanced search” button, shows more search functions as following. make all search function Fuzzy	search. E.g. I input adm in email, it shows adm@admin.com, admi@test.com, admin@dd.com.
4.1 add a “search by status” function
4.2 add a “search by last name” function
4.3 add a “search by first name” function
4.4 add a “search by username” function (We don't have an username field, so we have not consider this)
4.5 add a “search by email” function
DONE

5. User management page, sort functions.
please add “sort by first name”, “sort by last name”, “sort by email” function,
DONE

**Intake form in case management is in progress


#####################
Dec, 02 2016 update:-
#####################

- 1. Change the task bar on left side to JF logo’s green. - done
- 2. please change all these blue buttons color to dark green (JF Logo's color.#1f3f20) - done
- 3. Please change the green color as shown in the picture: The green in the image is rgba(155, 243, 151, 0.44). Or you can use a similar color. The green you use is too bright. - done
- 6. Make the clickable area for this button bigger. I have to click on the left side of this button to toggle the menu bar, which is incovient. - done
- 7. Add footer to this system. The footer should always attach the bottom of the screen. Please refer to JF Policy system’s footer and left side bar. - done
- Create Case function is done.
Note* Please update database also.


##################################
Nov, 30 and Dec, 01 2016 update:-
##################################

- Worked on providers page - done
- Create Provider function - done
- Search provider page and function - done
- Google map integration - done
- Search nearest provider via lat-lng - done


######################
Nov, 29 2016 update:-
######################

- Create InTake Form layout - done
- Create InTake list layout - done
- Create Provider Form layout - done
- Search Provider Form layout - done



######################
Nov, 28 2016 update:-
######################

- Emergency assistance page: New case layout - done

- New policy page layout - done
* ---- please provide api to search policies


######################
Nov, 25 2016 update:-
######################

- My task page (layout) - done

- Emergency assistance page (layout and js implementation) - done
* please provide api to search policies, products etc...
 

######################
Nov, 24 2016 update:-
######################

- Users management - done

- add user / edit user / activate user / inactivate user - done

- assign multiple group to user - done

- users group login - done

- group access security - done



##################################
JF Claim Management Installation
##################################

Please pull code from here and import database from "DB" folder


###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community IRC <https://webchat.freenode.net/?channels=%23codeigniter>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.