#Sprint 5 ToDo List

## Tylers' List, "choose one from each category"

- Tyler, from the ToDo List, "Make sure your forms validate input on the HTML forms AND validates data before making changes to the Database"
    - validate / run a sanity check on form data prior to insertion?
        - DONE
    - escape data in inserts?
        - DONE / used prepared statements

- Admin Page
    - reservation status - unconfirmed (default), confirmed, and cancelled
        - (Paul) DONE - 
    - results searchable or sortable
    - make results divided/shown by week or divided/shown by set
    - add a dashboard of visual metrics that gives insightful feedback about past/future set/extras reservations
        - (Paul) this could be interesting, thoughts?
    - create a weekly email that tells lauren about sets/extras that are going out in the next 2 weeks in a visual way
    - View Customers page, that lists customers including number of reservations each holds?

- Maintaining State using Cookies or Sessions
    - Add security or a Session to the admin page to make the login process more secure/stable
        - (Jazmin) DONE
    - Use cookies to remember the user's choices on the form (Jack) DONE
    - Use cookieds or sessions in another effective or creative way (Jack) DONE

- Implement a change/improvement based on Feedback from Usability Testing
    - SQL Injection, should fix that 
        - (Paul) DONE
    - Make checkbox items 'more clickable' (Jack) DONE
    - Fix bug where user can click back button, and keep submitting reservations.
        - (Paul) DONE

- Implement a change/improvement based on Laurens Feedback
    - allow for multiple contacts/people to be associated with a single reservation
        - (Paul) DONE - table added to allow a many-many relationship between customers and reservations.  The table simply contains a list of reservation IDs with associated customers.
        - (Jasmin/Zoe) DONE -  Add a means of adding people to the reservation, currently one is added at checkout, and others can only be added right now through PHPMyAdmin.
         
    - (more ideas will be added here or you can implement your own)


## Other random items / fixes

- Other Small Issues / Fixes / Add Ons

    - Add drop-downs to select quantity for jars

    - admin page, add/edit extras

    - admin page, View/Add/remove notes
