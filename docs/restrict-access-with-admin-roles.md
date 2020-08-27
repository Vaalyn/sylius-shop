# How to restrict access to admin pages with roles

The funtionality to restrict the access to different parts of Sylius is provided by the [odiseoteam/RbacPlugin](https://github.com/odiseoteam/RbacPlugin). For more information about how this plugin works, please refer to their GitHub repository.

When setting up the shop for the first time you'll need to run the `bin/console sylius-rbac:install-plugin` command which will install some default roles for you that you can use as base for further customization of the Rbac system.
If you've entered a users email for the environment variable `ADMIN_EMAIL` this user will be automatically be assigned with the `Configurator` role. You should customize this role as the fixture will only provide it with access to the basic functionality of Sylius and the Rbac plugin but does not take into account other plugins installed.

To restrict a user to only be able to access for example the `Sales` admin pages you can create a role named `Sales Manager` and turn on the read/write permissions for `Sales management`. Then you assign the role to the admin user on the edit page of the user.
