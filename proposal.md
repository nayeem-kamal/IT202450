IT 202 Project Proposal

**Project Name: Simple Bank**

**Project Summary: This project will create a bank simulation for users. They&#39;ll be able to have various accounts, do standard bank functions like deposit, withdraw, internal (user&#39;s accounts)/external(other user&#39;s accounts) transfers, and creating/closing accounts.**

**Github Link:** https://github.com/nayeemkamal/IT202450

**Website Link:** https://nhk6finalproj.herokuapp.com/index.php

**Your Name:** Nayeem Kamal

**Milestone Features:**

**Milestone 1:**

- [x] User will be able to register a new account
  - [x] Form Fields
    - [x] Username, email, password, confirm password (other fields optional)
    - [x] Email is required and must be validated
    - [x] Username is required
    - [x] Confirm password&#39;s match
      
      -https://github.com/nayeemkamal/IT202450/pull/15
  - [x] Users Table
    - [x] Id, username, email, password (60 characters), created, modified
  - [x] Password must be hashed (plain text passwords will lose points)
  - [x] Email should be unique
  - [x] Username should be unique
  - [x] System should let user know if username or email is taken and allow the user to correct the error without wiping/clearing the form
    - [x] The only fields that may be cleared are the password fields
      - https://github.com/nayeemkamal/IT202450/pull/16
- [x] User will be able to login to their account (given they enter the correct credentials)
  - [x] Form
    - [x] User can login with **email** or **username**
      - [x] This can be done as a single field or as two separate fields
    - [x] Password is required
  - [x] User should see friendly error messages when an account either doesn&#39;t exist or if passwords don&#39;t match
  - [x] Logging in should fetch the user&#39;s details (and roles) and save them into the session.
  - [x] User will be directed to a landing page upon login
    - [x] This is a protected page (non-logged in users shouldn&#39;t have access)
    - [x] This can be home, profile, a dashboard, etc
      - https://github.com/nayeemkamal/IT202450/pull/17
- [x] User will be able to logout
  - [x] Logging out will redirect to login page
  - [x] User should see a message that they&#39;ve successfully logged out
  - [x] Session should be destroyed (so the back button doesn&#39;t allow them access back in)
     - https://github.com/nayeemkamal/IT202450/pull/17 (in comments)
- [x] Basic security rules implemented
  - [x] Authentication:
    - [x] Function to check if user is logged in
    - [x] Function should be called on appropriate pages that only allow logged in users
      - https://github.com/nayeemkamal/IT202450/pull/18 (in comments)
  - [x] Roles/Authorization:
    - [x] Have a roles table (see below)
- [x] Basic Roles implemented
  - [x] Have a Roles table (id, name, description, is\_active, modified, created)
  - [x] Have a User Roles table (id, user\_id, role\_id, is\_active, created, modified)
  - [x] Include a function to check if a user has a specific role (we won&#39;t use it for this milestone but it should be usable in the future)
    - https://github.com/nayeemkamal/IT202450/pull/18
- [x] Site should have basic styles/theme applied; everything should be styled
  - [x] e., forms/input, navigation bar, etc
- [x] Any output messages/errors should be &quot;user friendly&quot;
  - [x] Any technical errors or debug output displayed will result in a loss of points
    - https://github.com/nayeemkamal/IT202450/pull/20
- [x] User will be able to see their profile
  - [x] Email, username, etc
- [x] User will be able to edit their profile
  - [x] Changing username/email should properly check to see if it&#39;s available before allowing the change
  - [x] Any other fields should be properly validated
  - [x] Allow password reset (only if the existing correct password is provided)
    - [x] Hint: logic for the password check would be similar to login
      - https://github.com/nayeemkamal/IT202450/pull/19


**Milestone 2:**

- [x] Create the Accounts table (id, account\_number [unique, always 12 characters], user\_id, balance (default 0), account\_type, created, modified)
  - https://github.com/nayeemkamal/IT202450/pull/22
- [x] Project setup steps:
  - [ ] Create these as initial setup scripts in the sql folder
    - [x] Create a system user if they don&#39;t exist (this will never be logged into, it&#39;s just to keep things working per system requirements)
    - [x] Create a world account in the Accounts table created below (if it doesn&#39;t exist)
      - [x] Account\_number must be &quot;000000000000&quot;
      - [x] User\_id must be the id of the system user
      - [x] Account type must be &quot;world&quot;
- [x] Create the Transactions table (see reference below)
  - https://github.com/nayeemkamal/IT202450/pull/23
- [x] Dashboard page
  - [x] Will have links for Create Account, My Accounts, Deposit, Withdraw Transfer, Profile
    - [x] Links that don&#39;t have pages yet should just have href=&quot;#&quot;, you&#39;ll update them later
      -  https://github.com/nayeemkamal/IT202450/pull/24
- [x] User will be able to create a checking account
  - [x] System will generate a unique 12 digit account number
    - [x] **Options (strike out the option you won&#39;t do):**
      - [x] **Option 1:** Generate a random 12 digit/character value; must regenerate if a duplicate collision occurs
  - [x] System will associate the account to the user
  - [x] Account type will be set as checking
  - [x] Will require a minimum deposit of $5 (from the world account)
    - [x] Entry will be recorded in the Transaction table as a transaction pair (per notes below)
    - [x] Account Balance will be updated based on SUM of **BalanceChange** of **AccountSrc**
  - [x] User will see user-friendly error messages when appropriate
  - [x] User will see user-friendly success message when account is created successfully
    - [x] Redirect user to their Accounts page

  - https://github.com/nayeemkamal/IT202450/pull/25
- [x] User will be able to list their accounts
  - [x] Limit results to 5 for now
  - [x] Show account number, account type and balance
  - https://github.com/nayeemkamal/IT202450/pull/25
- [x] User will be able to click an account for more information (a.ka. Transaction History page)
  - [x] Show account number, account type, balance, opened/created date
  - [x] Show transaction history (from Transactions table)
    - [x] For now limit results to 10 latest
      -https://github.com/nayeemkamal/IT202450/pull/26
- [x] User will be able to deposit/withdraw from their account(s)
  - [x] Form should have a dropdown of _their_ accounts to pick from
    - [x] World account should not be in the dropdown
  - [x] Form should have a field to enter a positive numeric value
    - [x] For now, allow any deposit value (0 - inf)
  - [ ] For withdraw, add a check to make sure they can&#39;t withdraw more money than the account has
  - [ ] Form should allow the user to record a memo for the transaction
  - [x] Each transaction is recorded as a transaction pair in the Transaction table per the details below
    - [x] These will reflect on the transaction history page (Account page&#39;s &quot;more info&quot;)
    - [x] After each transaction pair, make sure to update the Account Balance by SUMing the **BalanceChange** for the **AccountSrc**
      - [x] This will be done after the insert
    - [x] Deposits will be **from** the &quot;world account&quot;
      - [x] Must fetch the world account to get the id (do not hard code the id as it may change if the application migrates or gets rebuilt)
    - [ ] Withdraws will be **to** the &quot;world account&quot;
      - [ ] Must fetch the world account to get the id (do not hard code the id as it may change if the application migrates or gets rebuilt)
    - [x] Transaction type should show accordingly (deposit/withdraw)
  - [x] Show appropriate user-friendly error messages
  - [x] Show user-friendly success messages

**Milestone 3:**

- [ ] User will be able to transfer between their accounts
  - [ ] Form should include a dropdown first **AccountSrc** and a dropdown for **AccountDest** (only accounts the user owns; no world account)
  - [ ] Form should include a field for a positive numeric value
  - [ ] System shouldn&#39;t allow the user to transfer more funds than what&#39;s available in **AccountSrc**
  - [ ] Form should allow the user to record a memo for the transaction
  - [ ] Each transaction is recorded as a transaction pair in the Transaction table
    - [ ] These will reflect in the transaction history page
  - [ ] Show appropriate user-friendly error messages
  - [ ] Show user-friendly success messages
- [ ] Transaction History page
  - [ ] Will show the latest 10 transactions by default
  - [ ] User will be able to filter transactions between two dates
  - [ ] User will be able to filter transactions by type (deposit, withdraw, transfer)
  - [ ] Transactions should paginate results after the initial 10
- [ ] User&#39;s profile page should record/show First and Last name
- [ ] User will be able to transfer funds to another user&#39;s account
  - [ ] Form should include a dropdown of the current user&#39;s accounts (as **AccountSrc** )
  - [ ] Form should include a field for the destination user&#39;s last name
  - [ ] Form should include a field for the last 4 digits of the destination user&#39;s account number (to lookup AccountDest)
  - [ ] Form should include a field for a positive numerical value
  - [ ] Form should allow the user to record a memo for the transaction
  - [ ] System shouldn&#39;t let the user transfer more than the balance of their account
  - [ ] System will lookup appropriate account based on destination user&#39;s last name and the last 4 digits of the account number
  - [ ] Show appropriate user-friendly error messages
  - [ ] Show user-friendly success messages
  - [ ] Transaction will be recorded with the type as &quot;ext-transfer&quot;
  - [ ] Each transaction is recorded as a transaction pair in the Transaction table
    - [ ] These will reflect in the transaction history page

**Milestone 4:**

- [ ] User can set their profile to be public or private (will need another column in Users table)
  - [ ] If public, hide email address from **other** users
- [ ] User will be able open a savings account
  - [ ] System will generate a 12 digit/character account number per the existing rules (see Checking Account above)
  - [ ] System will associate the account to the user
  - [ ] Account type will be set as savings
  - [ ] Will require a minimum deposit of $5 (from the world account)
    - [ ] Entry will be recorded in the Transaction table in a transaction pair (per notes below)
    - [ ] Account Balance will be updated based on SUM of **BalanceChange** of AccountSrc
  - [ ] System sets an APY that&#39;ll be used to calculate monthly interest based on the balance of the account
    - [ ] Recommended to create a table for &quot; **system properties**&quot; and have this value stored there and fetched when needed, this will allow you to have an admin account change the value in the future)
  - [ ] User will see user-friendly error messages when appropriate
  - [ ] User will see user-friendly success message when account is created successfully
    - [ ] Redirect user to their Accounts page
  - [ ]
- [ ] User will be able to take out a loan
  - [ ] System will generate a 12 digit/character account number per the existing rules (see Checking Account above)
  - [ ] Account type will be set as loan
  - [ ] Will require a minimum value of $500
  - [ ] System will show an APY (before the user submits the form)
    - [ ] This will be used to add interest to the loan account
    - [ ] Recommended to create a table for &quot; **system properties**&quot; and have this value stored there and fetched when needed, this will allow you to have an admin account change the value in the future)
  - [ ] Form will have a dropdown of the user&#39;s accounts of which to deposit the money into
  - [ ] **Special Case for Loans:**
    - [ ] Loans will show with a positive balance of what&#39;s required to pay off (although it is a negative since the user owes it)
    - [ ] User will transfer funds to the loan account to pay it off
    - [ ] Transfers will continue to be recorded in the Transactions table
    - [ ] Loan account&#39;s balance will be the balance minus any transfers **to** this account
    - [ ] Interest will be applied to the current loan balance and add to it (causing the user to owe more)
    - [ ] A loan with 0 balance will be considered paid off and will not accrue interest and will be eligible to be marked as closed
    - [ ] User can&#39;t transfer more money **from** a loan once it&#39;s been opened and a loan account should not appear in the Account Source dropdowns
  - [ ] User will see user-friendly error messages when appropriate
  - [ ] User will see user-friendly success message when account is created successfully
    - [ ] Redirect user to their Accounts page
- [ ] Listing accounts and/or viewing Account Details should show any applicable APY or &quot;-&quot; if none is set for the particular account (may alternatively just hide the display for these types)
- [ ] User will be able to close an account
  - [ ] User must transfer or withdraw all funds out of the account before doing so
  - [ ] Account should have a column &quot;active&quot; that will get set as false.
    - [ ] All queries for Accounts should be updated to pull only &quot;active&quot; = true accounts (i.e., dropdowns, My Accounts, etc)
    - [ ] Do not delete the record, this is a soft delete so it doesn&#39;t break transactions
  - [ ] Closed accounts don&#39;t show up anymore
  - [ ] If the account is a loan, it must be paid off in full first
- [ ] Admin role (leave this section for last)
  - [ ] Will be able to search for users by firstname and/or lastname
  - [ ] Will be able to look-up specific account numbers (partial match).
  - [ ] Will be able to see the transaction history of an account
  - [ ] Will be able to freeze an account (this is similar to disable/delete but it&#39;s a different column)
    - [ ] Frozen accounts still show in results, but they can&#39;t be interacted with.
    - [ ] [Dev note]: Will want to add a column to Accounts table called frozen and default it to false
      - [ ] Update transactions logic to not allow frozen accounts to be used for a transaction
  - [ ] Will be able to open accounts for specific users
  - [ ] Will be able to deactivate a user
    - [ ] Requires a new column on the Users table (i.e., is\_active)
    - [ ] Deactivated users will be restricted from logging in
      - [ ] &quot;Sorry your account is no longer active&quot;

**Notes/References:**

- [ ] **Account Number Requirements**
  - [ ] Should be 12 characters long
  - [ ] &quot;World&quot; account should be &quot;000000000000&quot; (this is used for deposit/withdraw showing the movement of money outside of the bank)
  - [ ] Each transaction **must** be recorded as **two** separate inserts to the transaction table
- [ ] \*Transaction Table Minimum Requirements
  - [ ] Each action for a set of accounts will be in pairs. The colors in the table below highlight what this means.
  - [ ] The first source/dest is the account that triggered the action to the dest account. This typically will be a negative change.
  - [ ] The second source/dest is the dest account&#39;s half of the transaction info.
    - [ ] source/dest will swap in the second half of the transaction
    - [ ] **BalanceChange** will invert in the second half of the transaction
    - [ ] This typically will be a positive change
  - [ ] **Src/Dest** are the account id&#39;s affected (Accounts.id, not Accounts.account\_number).
  - [ ] **BalanceChange** is the difference in the account balance (i.e., a deposit of $50) (deposit subtracts from source for the first part and adds to source for the second part.)
  - [ ] **TransactionType** is a built-in identifier to track the action (i.e., deposit, withdraw, transfer, ext-transfer)
  - [ ] **Memo** user-defined notes
  - [ ] **ExpectedTotal** is the account&#39;s final value after the transaction, respectively. This is not to be used as the &quot;Account Balance&quot; it&#39;s recorded for bookkeeping and review purposes.
  - [ ] **Created** is when the transaction occurred
  - [ ] The below Transaction/Ledger table should total (SUM) up to zero to show that your bank is in balance. Otherwise, something bad happened with the transaction based on whether it&#39;s negative or positive. In that case we either lost money or stole money.
- [ ] ![](RackMultipart20210705-4-rs6ksv_html_4d39bbd56ba70ba2.png)
