### CHANGE LOG:

**1.3.1:**
- Modify validate component inspection.
- Modify README decor.

**1.3.0:**
- Change var type from protected to private in BaseController for: model, searchModel, 
validateComponent. They can be set and got just only by magic methods.
- Add a static var "_translations" in module class. Automatic run registerTranslations() function,
 when the function **t()** in use.

**1.2.0:**
- Optimize load authManager.

**1.1.0:**
- Modify interface architecture for expansion perspective with increased number of components.

**1.0.0:**
- Create module, which provides user management with changing the next default profile data:
    - name
    - login
    - email
    - password
    - status
    - roles (if authManager exists in application and rbacManage is true)
- Created documentation.
