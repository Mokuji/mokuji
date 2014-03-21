# Form protection

A.K.A.: project no more captcha's!


## What I want it to do

1. Create a flexible and easy interface for programmers to protect a form with ~5 lines of code.
2. Use multi-layer protection to detect spammers and hackers.
3. Aim for optimal effectiveness, performance and privacy awareness in the implementation.
4. Track the effectiveness locally, with the option to share it with mokuji.net for collaborative stats.
5. Allow configuration for EVERYTHING that improves any of the following aspects: effectiveness, performance and privacy-protection.
6. Divide all of these configuration values into basic and advanced scope, not to confuse webmasters.


## The plan

1. Design preliminary interface.
2. Implement a few of the quickest to implement layers.
3. Use that to perfection the interface.
4. Add local effectiveness tracking database.
5. Add configuration options.
6. Implement a few highly effective layers.
7. Add reporting option to send effectiveness statistics to mokuji.net.
8. Document the interface.
9. Release a beta version.
10. Implement and release more layers as needed.


## Choosing layers

Very abstract indicators should be available to the programmer to indicate the level of
security they desire. Optionally they can indicate whether they expect primarily
spamming, hacking or both attempts.

The threat can be increased by the layers themselves, before picking what to add to this
particular form. For example, the IP and total suspicion rate and the user-agent detection.

A selection algorithm will then pick the layers according to the threat model.
For a low threat, only the fastest and most effective methods are selected.
For a high threat, more layers will gradually be added.

Spammer and hacker threats are assessed individually for this selection process.


## The layers

### Challenge-response

* **Effectiveness vs spammers**: Medium
* **Effectiveness vs hackers**: High
* **Performance**: Very high. Minor disk I/O is involved (session variables).
* **Privacy awareness**: Perfect! Content does not need to be logged or shared.

Uses a hard-to-predict key unique to that form that must be included in the response to be considered valid.
Works well against cross-site request forging (hacking method)
and forces spambots to execute a GET request for every submitted form.

False positives only happen if the user loses / expires his session ID while they fill in the form.
Which is very rare in real world scenario's.

### Honeypot

* **Effectiveness vs spammers**: Very high
* **Effectiveness vs hackers**: Ineffective
* **Performance**: Perfect! - O(1)
* **Privacy awareness**: Perfect! Content does not need to be logged or shared.

Use a field that is invisible to users, but bots may fill in automatically.
It has a high catch rate and high certainty against spammers.
We assume hackers are willing to adjust their scripts to circumvent this.
Making sure only the proper fields are filled in is a trivial task for them.

### Timer

* **Effectiveness vs spammers**: High
* **Effectiveness vs hackers**: N/A
* **Performance**: Very high. Minor disk I/O is involved (session variables).
* **Privacy awareness**: Perfect! Content does not need to be logged or shared.

Checks the time it took between showing the form to the user and them sending it back.
If it's too fast or too slow, it could be malicious.

Against hackers, does the same as challenge-response. So best not do this twice, or combine them.
Against spambots, not only does it force them to do a GET request, they also must be SLOW or they will be caught.

### Akismet

* **Effectiveness vs spammers**: High
* **Effectiveness vs hackers**: Low
* **Performance**: Poor. External API requests needed.
* **Privacy awareness**: Poor. Much content needs to be shared.

Akismet is a collaborative service that scans content for likely spam.
This is effective against spammers and against malicious links, so also provides some hacking prevention.
Downside is that it requires (slow) API calls and sending a lot of information to a 3rd party.
For corporate users it is a paid service and it requires configuration to work(sign up, copy API key).
You should also reflect your data-sharing practice in your privacy policy.

This should be optional. And when enabled only use it when several other methods do not provide
a conclusive result.

### User-agent detection

* **Effectiveness vs spammers**: Medium
* **Effectiveness vs hackers**: Ineffective
* **Performance**: Perfect! O(1)
* **Privacy awareness**: Perfect! Content does not need to be logged or shared.

Check for the presence of a user agent. Simple spambots may not have included one.
This detection is trivial to circumvent though.
So if the spammer is willing to change one line of code, this method stops being effective.
The same goes for hackers, we assume they are very likely willing to invest the time to add
a user-agent so it counts as ineffective.

### Javascript detection

* **Effectiveness vs spammers**: Medium
* **Effectiveness vs hackers**: Ineffective
* **Performance**: Very high. Minor client-side CPU impact.
* **Privacy awareness**: Very high. Content does not need to be logged or shared, but javascript usage statistics may be revealed.

A piece of javascript sent along with the form adds a predictable token to the form data
to prove that the user had javascript enabled.
The majority of real users have javascript enabled, while spambots likely do not.
However, real users may have disabled/blocked javascript and bots may support javascript.
So this method should be used as a heuristic, not as a decisive factor.
A hacker could execute the same code in any other language, or just run the given javascript.

### IP-suspicion rate

* **Effectiveness vs spammers**: High
* **Effectiveness vs hackers**: Medium
* **Performance**: Very high. Minor disk I/O is involved (database queries).
* **Privacy awareness**: High. The IP should be logged along with a reputation, but does not need to be shared.

Whenever any other method gives an indicator of spam or hacking attempts,
keep track of which IP is a "likely bad guy". If they repeatedly come up with more
bad results from the other methods, their reputation will get worse.
Optionally you can track positive results too and gradually come to trust an IP-address.

The worse the reputation gets, the result of this check may increase.
Example order:
1. PASS (this guy is trusted)
2. UNKNOWN (we have no reason to suspect them yet)
3. MAYBE (some issues have come up, but they are not decisive yet)
4. FAIL (this guy is definitely a bad guy)

If the IP-address doesn't visit for a while, the suspicion rate goes back to neutral over time.

### Total suspicion rate

* **Effectiveness vs spammers**: High
* **Effectiveness vs hackers**: Medium
* **Performance**: Very high. Minor disk I/O is involved (database queries).
* **Privacy awareness**: Very High. Content does not need to be logged or shared, but may show patterns when users are active and when spammers are active.

Whenever any other method gives an indicator of spam or hacking attempts,
we can keep track of this and score it.
When the score is high, this means the website is likely under attack and you should be more strict.
When the score is low, this means we are likely having legitimate users and could even lower the strictness.

This method is quite context sensitive, but when tweaked properly can be a great protection method.
Using this in combination with the IP-suspicion rate, you can make sure that spammers / hackers
do not use proxies to change their IP addresses to try and avoid throttling.

If nobody visits the site for a while, the suspicion rate goes back to neutral over time.

### Javascript CPU challenge

* **Effectiveness vs spammers**: High
* **Effectiveness vs hackers**: Medium
* **Performance**: Low. Considerable client-side CPU impact.
* **Privacy awareness**: Very high. Content does not need to be logged or shared, but javascript usage statistics may be revealed.

This method is only effective when you want to defend against repeated attempts at something.
Such as sending comments (10.000 spam messages are worse than 1), or log in attempts.

Ask the client to run a script that solves a mathematical problem (fully automatic, but slow).
If the problem is solved, this gives high credibility that it's a legitimate user.

Spambots will probably not execute this script. And if they do they likely won't wait until
it is finished solving the math problem.
We assume hackers might choose to wait for the script to complete.

Spammers and hackers that do wait for the script to complete will severely slow down the speed
at which they can keep submitting forms.

While the timer method allows them to queue up many requests and just wait before submitting,
this approach actually requires them to spend their limited CPU resources. So parallel requests
do not speed up the process.

This method is however a very unfriendly thing to do to your real visitors too often.
By taking up their CPU power you slow down their computer for a few seconds, or if they
are using a mobile phone, slow it down even longer. On top of that you are wasting their
batteries / electricity and aren't being environmental friendly if you have a million visitors.

However if you are on certain high importance forms, this may be a trade off you're willing
to make. And by using it on high importance forms only, you limit how often the user experiences this.
As well as how bad you're being to the environment.

Alternatively you could use this as a second step. Don't run the script at first,
and when other methods do not provide satisfying certainty that they are not a spammer / hacker
you can send the math challenge to the client after all.
The client would then show a funny waiting screen like "Calculating your humanness... 25%... 40%...".
The hacker script or spambot are very unlikely to respond to this.
Make sure you use javascript detection in the first step, so you don't try to send a challenge
to a user without javascript support. In which case you can either mark them as suspicious or
send them some other challenge, like "Human, please click this button.".

**Conclusion:**
Use this for important and repeatedly attempted forms only, when it makes sense to slow down
the client computer for additional security. Can be used in two stages to avoid CPU-impact
for submissions that don't need it.