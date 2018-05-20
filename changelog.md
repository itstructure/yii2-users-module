### CHANGE LOG:

**1.5.0 May 20, 2018:**
- Add string|callable attribute ```formTemplate``` in to ```ProfileValidateComponent```.
- Add ```getAdditionFields()``` function in to ```BaseController```.
- Modify view templates.
- Modify ```ProfileController``` with new function ```getAdditionFields()```.

**1.4.0 May 13, 2018:**
- Modify dependencies: minimum-stability is set to dev.
- Added prefer-stable with true.
- Add .scrutinizer file.
- Add badges:
    - Latest Stable Version
    - Latest Unstable Version
    - License
    - Total Downloads.
    - Build Status
    - Scrutinizer Code Quality

**1.3.1 March 17, 2017:**
- Modify validate component inspection.
- Modify README decor.

**1.3.0 February 13, 2017:**
- Change var type from protected to private in BaseController for: model, searchModel, 
validateComponent. They can be set and got just only by magic methods.
- Add a static var "_translations" in module class. Automatic run registerTranslations() function,
 when the function **t()** in use.

**1.2.0 February 10, 2017:**
- Optimize load authManager.

**1.1.0 February 9, 2017:**
- Modify interface architecture for expansion perspective with increased number of components.

**1.0.0 February 8, 2017:**
- Create module, which provides user management with changing the next default profile data:
    - name
    - login
    - email
    - password
    - status
    - roles (if authManager exists in application and rbacManage is true)
- Created documentation.
