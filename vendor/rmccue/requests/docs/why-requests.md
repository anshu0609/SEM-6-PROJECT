Why should I use Requests Instead of X?
=======================================

This is a quick look at why you should use Requests instead of another
solution. Keep in mind though that these are my point of view, and they may not
be issues for you.

As always with software, you should choose what you think is best.


Advantages of using Requests
--------------------------
1. **Designed for maximum compatibility**

   The realities of working with widely deployable software mean that awesome
   PHP features aren't always available. PHP 8.0, cURL, OpenSSL and more are not
   necessarily going to be available on every system. While you're welcome to
   require PHP 5.6, 7.2 or even 8.0, it's not our job to force you to use those.

   Don't worry though, Requests will automatically use better features where
   possible, giving you an extra speed boost with cURL.

2. **Straight-forward API**

   Requests' API is designed to be able to be learnt in 10 minutes. Everything
   from basic requests all the way up to advanced usage involving custom SSL
   certificates and stored cookies is handled by a straight-forward API.

   Other HTTP libraries optimize for the library developer's time; **Requests
   optimizes for your time**.

3. **Thoroughly tested**

   Requests is [continuously integrated with GH Actions][ghactions] and test coverage
   is [constantly monitored with CodeCov][codecov] to give you confidence in
   the library. We aim for test coverage **over 90%** at all times, and new
   features require new tests to go along with them. This ensures that you can
   be confident in the quality of the code, as well as being able to update to
   the latest version of Requests without worrying about compatibility.

4. **Secure by default**

   Unlike other HTTP libraries, Requests is secure by default. Requests was the
   **first** standalone HTTP library to
   **[fully verify][requests_ssl] all HTTPS requests** even without cURL. We
   also bundle the latest root certificate authorities to ensure that your
   secure requests are actually secure.

   _Of note is that WordPress as of version 3.7 also supports full checking of
   the certificates, thanks to [evangelism efforts on our behalf][wpssl].
   Together, we are the only HTTP libraries in PHP to fully verify certificates
   to the same level as browsers._

5. **Extensible from the core**

   If you need low-level access to Requests' internals, plug your
   callbacks in via the built-in [hooking system][] and mess around as much as
   you want. Requests' hooking system is so powerful that both
   authentication handlers and cookie support is actually handled internally
   with hooks.

[codecov]: https://app.codecov.io/gh/WordPress/Requests/branch/stable
[hooking system]: hooks.md
[requests_ssl]: https://github.com/WordPress/Requests/blob/stable/src/Ssl.php
[ghactions]: https://github.com/WordPress/Requests/actions
[wpssl]: https://core.trac.wordpress.org/ticket/25007


Why shouldn't I use...
----------------------
Requests isn't the first or only HTTP library in PHP and it's important to
acknowledge the other solutions out there. Here's why you should use Requests
instead of something else, in our opinion.


### cURL

1. **Not every host has cURL installed**

   cURL is far from being ubiquitous, so you can't rely on it always being
   available when distributing software. Anecdotal data collected from various
   projects indicates that cURL is available on roughly 90% of hosts, but that
   leaves 10% of hosts without it.

2. **cURL's interface is hard to work with**

   cURL's interface was designed for PHP 4, and hence uses resources with
   horrible functions such as `curl_setopt()`. Combined with that, it uses 229
   global constants, polluting the global namespace horribly.

   Requests, on the other hand, exposes only a handful of classes to the
   global namespace, most of which are for internal use. You can learn to use
   the `WpOrg\Requests\Requests::request()` method and the `WpOrg\Requests\Response`
   object in the space of 10 minutes and you already know how to use Requests.


### Guzzle

1. **Requires cURL and PHP 7.2+**

   Guzzle is designed to be a client to fit a large number of installations, but
   as a result of optimizing for Guzzle developer time, it uses cURL as an
   underlying transport. As noted above, this is fine for a majority of systems,
   but far from all.

   The same is true for PHP 7.2+. While we'd all love to rely on PHP's newer
   features, the fact is that a huge percentage of hosts are still running on
   older versions of PHP.

2. **Not just a HTTP client**

   Guzzle is not intended to just be a HTTP client, but rather to be a
   full-featured REST client. Requests is just and only a HTTP client, intentionally.
   Our development strategy is to act as a low-level library that REST clients can
   easily be built on, not to provide the whole kitchen sink for you.

   If you want to rapidly develop a web service client using a framework, Guzzle
   will suit you perfectly. On the other hand, if you want a HTTP client without
   all the rest, Requests is the way to go.


### Buzz

1. **Requires PHP 7.1+**

   As with Guzzle, while PHP 7.1+ is awesome, you can't always rely on it being
   on a host. With widely distributable software, this is a huge problem.

2. **Not transport-transparent**

   For making certain types of requests, such as multi-requests, you can't rely
   on a high-level abstraction and instead have to use the low-level transports.
   This really gains nothing (other than a fancy interface) over just using the
   methods directly and means that you can't rely on features to be available.


### fsockopen

1. **Very low-level**

   fsockopen is used for working with sockets directly, so it only knows about
   the transport layer (TCP in our case), not anything higher (i.e. HTTP on the
   application layer). To be able to use fsockopen as a HTTP client, you need
   to write all the HTTP code yourself, and once you're done, you'll end up
   with something that is almost exactly like Requests.


### PEAR HTTP_Request2

1. **Requires PEAR**

   PEAR is (in theory) a great distribution system (with a less than wonderful
   implementation), however it is not ubiquitous, as many hosts disable it to
   save on space that most people aren't going to use anyway.
   
   PEAR has also largely been superseded by Composer, making installation via
   PEAR a pain for users. Users want to be able to install via Composer or to
   download a zip of a project without needing to install anything else from PEAR.

2. **Depends on other PEAR utilities**

   HTTP\_Request2 requires Net\_URL2 in order to function, locking you in to
   using PEAR for your project.

   Requests is entirely self-contained, and includes all the libraries it needs
   (for example, `WpOrg\Requests\Iri` is based on `ComplexPie_IRI` by Geoffrey Sneddon).


### Zend Framework's Zend\_Http\_Client

1. **Requires other parts of the Zend Framework**

   Similar to HTTP_Request2, Zend's client is not fully self-contained and
   requires other components from the framework.

***

Previous: [Goals](goals.md)

Next: [Making a request](usage.md)
