# Nail Down a Flaky Test

A failing test is actually a good thing, since it helped us catch a potential bug before it reached production. But what about a flaky test, that is a test that only fails every once in a while for no apparent reason? Flaky tests are extremely frustrating. They slow us down and erode our confidence in the test suite. They can also be difficult to diagnose. 

Today’s tip will share a real world example of a flaky test and highlight some tips on how to debug them and confirm they’re really fixed once and for all.

This particular flaky test involved sending an SMS notification when someone was awarded a job application. Our test would assert that the right person was notified, that their preferred mobile number was used, and that the expected message was sent. Most of the time, this test would pass, but every 1 out of 100 times, it would fail. Quite annoying!

The first issue to solve is why the test was failing. In our test, we were using Mockery to mock the actual SMS client so we avoided sending real messages during test runs. But because of how Mockery was failing, our test failure gave us no indication as to why it was failing. To get to the root cause, Mockery was temporarily removed from that test, and instead we added some extra code to the class being tested to avoid the external call.

Next, it was time to get the test to fail so I could get at the real error, but how? PHPUnit has a handy command line option `--repeat` which does just what you might expect. So with the new test code in place, this one flaky test was run with `--repeat 1000`.

Hooray, it failed after 100 or so runs! With this temporary test debug code in place, we finally had the root cause: SMS messages get truncated at 160 characters. So if the factory generated a test job with a title just a little bit too long, it would push the message over that boundary, and cause a test failure. Armed with this knowledge, the test was easy to fix.

With the fix made, the temporary debugging code was removed, Mockery was restored and we ran the test with `--repeat 1000` again. This time it got all the way through all 1000 runs without a failure. The flaky test was squashed!

This may seem like a lot of effort for something that doesn’t fail all that often, but the investment is worth it. True, a flaky test may fail only 1 out of 100 times, and when it does fail, you can just run the tests one more time to get them to pass, but we recommend you don’t live with the pain of a flaky test. Get to the bottom of it and regain confidence in your test suite.
