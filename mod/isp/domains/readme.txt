Known issues / future enhancements
----------------------------------
x In the last step - domain registration - the script defaults to a period of 1 year. In case an extension can not be registered for 1 year (examples: .nu, .co.uk), the registration will fail. Solvable by retrieving minimum period of the chosen extension.

x The local presence options of Openprovider cannot be used. This applies to .de and .fr domains.

x A new handle is created every time; might be solved by searching for a matching existing handle (on company name and contact name).

- Going back one or more steps is not available.

- Some extensions require additional data (VAT number, birth date, ...). With the current version of the scripts, these data cannot be entered and such domains can thus not be registered.

- In this version, the domain registration is requested immediately. In order to use it in a public environment, addition of a order queue might be required. Orders keep pending until an admin user decides to request them at Openprovider.