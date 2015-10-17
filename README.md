# Where's My Cash
This was a project made for the **Mubaloo's 24 hours Appathon held at the University Of Bristol.**
![first screen](https://cloud.githubusercontent.com/assets/9435724/10561078/e3340f8a-7515-11e5-9c41-03855b0c1d5b.png)

**Where's My Cash** is an Android app aimed at groups of people with shared costs (students sharing a house, friends taking turns in paying restaurant checks or going on a trip together).

The App keeps track of the shared expenses, who paid them (in total or partial) and who has to pay. It also reduces the number of transactions and eliminates circular/indirect debt.

Note: this repo contains only the backend files (since I worked on this part of the project); the magic of simplifying and removing circular/indirect debt happens in simplify_debt.php

###How it works:
0. Make a group and invite your friends to it.

    ![your groups](https://cloud.githubusercontent.com/assets/9435724/10561081/e335f5ac-7515-11e5-8cc4-3ac22cbe2714.png)

0.  If you paid something for the whole group, insert the sum and details in the app and the server will split the debt between all group members.
0.  If just one person owes you money, you can also insert that debt in the app.

    ![debt](https://cloud.githubusercontent.com/assets/9435724/10561079/e334cbfa-7515-11e5-8858-577285f80c10.png)
    
0.  When you get your money back, just mark the debt as paid in the app.

At any time you can check what is your balance in every group and see who you own money to. If you do not trust our algorithm for removing indirect / circular debt, you can also see the history of transactions in the group.

![debt](https://cloud.githubusercontent.com/assets/9435724/10561079/e334cbfa-7515-11e5-8858-577285f80c10.png)

###Team members:
- Andrei Ilisei (backend - PHP, MySQL)
- Milan Zolota (frontend - Android SDK)
- Shayan Chaudhary (frontend - Android SDK)
- Stephen Livermore-Tozer (backend - PHP)
