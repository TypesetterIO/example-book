# When to Use Single Action Controllers

In a previous tip, we shared our recommendation for using resourceful controllers wherever possible. While it keeps code consistent and easier to navigate, there are some use cases where a resourceful approach just doesn’t fit. Instead of bolting on an arbitrary action to a resourceful controller, we can use a single action controller instead.

Just as the name suggests, a single action controller is literally just a controller that has one public function: `__invoke`. 

Here are two common scenarios where single action controllers are a good fit:

**Content pages**

If you have a very simple, static page, you can route directly to a view and skip the controller altogether. But what if your mostly static page also needs some data bound to it? Or what if you have a dynamic page, like a dashboard, that has data bound to it for the logged-in user? A single action controller is a clean way of implementing it.

**Workflow logic**

Take for example a job application process. The resource is the job application, but when an application is approved or rejected, that isn’t the same thing as editing the resource. For one thing, different fields on the job application are likely editable by different roles. The applicant can change most of the information, but they can’t change the status to approved. In addition, the workflow around approving an application likely does more than just change a status field to a new value. You might send an email, reject other applications, and so on. Trying to do all these different things in a single resourceful edit/update action will get messy very quickly. A single action controller is a much cleaner fit for the workflow logic.

Using this approach, you may worry that you’ll end up with too many controllers, which would pose a different set of problems. While it’s true you’ll have more controllers, we argue that the end result will be far more manageable than a smaller number of giant controllers with lots of custom actions. If navigation truly becomes a challenge, don’t forget you can group single action controllers by feature into namespaced folders to make it easier to navigate.
