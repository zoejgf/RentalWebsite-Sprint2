#Sprint 5 ToDo List

## Tylers' List, "choose one from each category"

- Admin Page
    - reservation status - unconfirmed (default), confirmed, and cancelled
        - (Paul) db column added for status, default is 'unconfirmed'.  Currently there is no means of changing that, has to be added.
    - results searchable or sortable
    - make results divided/shown by week or divided/shown by set
    - add a dashboard of visual metrics that gives insightful feedback about past/future set/extras reservations
        - (Paul)this could be interesting, thoughts?
    - create a weekly email that tells lauren about sets/extras that are going out in the next 2 weeks in a visual way

- Maintaining State using Cookies or Sessions
    - Add security or a Session to the admin page to make the login process more secure/stable
        - done?
    - Use cookies to remember the user's choices on the form
    - Use cookieds or sesions in another effective or creative way

- Implement a change/improvement based on Feedback from Usability Testing
    - SQL Injection, should fix that 
        - (Paul) I can try ... 
    - Make checkbox items 'more clickable'
    - Fix bug where user can click back button, and keep submitting reservations.
        - (Paul) I can work on this to

- Implement a change/improvement based on Laurens Feedback
    - allow for multiple contacts/people to be associated with a single reservation
        - (Paul) This has been done, table added to allow a many-many relationship between customers and reservations.  The table simply contains a list of reservation IDs with associated customers.  Updated all queries/pages I could see that would be effected (PLEASE TEST!).  
        - TODO: Add a means of adding people to the reservation, currently one is added at checkout, and others can only be added right now through PHPMyAdmin.
         
    - (more ideas will be added here or you can implement your own)




## Other random items / fixes

- Other Small Issues / Fixes / Add Ons

    - Add drop-downs to select quantity for jars

    - admin page, add/edit extras

    - admin page, View/Add/remove notes
