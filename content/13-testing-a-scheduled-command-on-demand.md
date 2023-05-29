# Testing a Scheduled Command On Demand

There are differences between running console commands directly compared to when they’re run with the Laravel scheduler.  But, because of their schedules, these commands can be hard to test locally in this configuration.

If your command runs every minute, you could execute it by running `artisan schedule:run` locally.  However, unless you’re exceptionally good at running this command at a specific time - or you’re super patient and can wait hours - you might find other commands harder to test.

To handle this, the Laravel Scheduler exposes a useful method to test any scheduled command regardless of the current time.

```bash
artisan schedule:test
```

When you run this command, you’ll get a list of scheduled commands.  Pick the one you’d like to run and it will be run on demand.  This command will bypass the truth-test constraints on your command definition, however.  Or to say another way, even if your schedule has `when()` and `skip()` declarations that would resolve to restrict the command from running, this method will run them anyway.
